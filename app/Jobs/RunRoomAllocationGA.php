<?php

namespace App\Jobs;

use App\Models\Application;
use App\Models\Room;
use App\Models\User;
use App\Models\AllocationStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\RoomAllocationCompletedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class RunRoomAllocationGA implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sessionId;
    public $chunkNumber;
    public $triggeredBy;

    public function __construct($sessionId, $chunkNumber = null, User $triggeredBy)
    {
        Log::info("Constructor called with session ID: {$sessionId}");
        $this->sessionId = $sessionId;
        $this->chunkNumber = $chunkNumber;
        $this->triggeredBy = $triggeredBy;
    }

    public function handle(): void
    {
        $start = microtime(true);
        if ($this->chunkNumber !== null) {
        Log::info("Starting Room Allocation GA for session: {$this->sessionId}, chunk: {$this->chunkNumber}");
        } else {
            Log::warning("No chunk number provided for session: {$this->sessionId} (chunk is null)");
        }

        try {
            $perPage = 50;

            $appQuery = Application::where('application_status', 'approved')
                ->where('session_id', $this->sessionId)
                ->whereDoesntHave('resident')
                ->orderBy('created_at');

            if ($this->chunkNumber !== null) {
                $appQuery->skip(($this->chunkNumber - 1) * $perPage)->take($perPage);
            }

            $applications = $appQuery->get()
                ->filter(fn($app) => is_array(json_decode($app->preferred_room_feature, true)))
                ->values();

            if ($applications->isEmpty()) {
                Log::warning("No applications for session {$this->sessionId}, chunk {$this->chunkNumber}");
                return;
            }

            $rooms = Room::where('status', 'available')->get();

            if ($rooms->isEmpty()) {
                Log::warning("No available rooms for session {$this->sessionId}");
                return;
            }

            Log::info("Chunk {$this->chunkNumber}: Applications: {$applications->count()}, Rooms: {$rooms->count()}");

            $preferenceMap = $applications->mapWithKeys(fn($app) => [
                $app->id => json_decode($app->preferred_room_feature, true) ?? [],
            ]);

            $populationSize = 20;
            $maxGenerations = 5;
            $mutationRate = 0.05;
            $stagnationLimit = 2;

            $population = [];
            for ($i = 0; $i < $populationSize; $i++) {
                $chromosome = [];
                foreach ($applications as $app) {
                    $pref = $preferenceMap[$app->id] ?? null;
                    if (!is_array($pref)) continue;
                    $room = $this->getRandomRoom($rooms, $app->gender, $pref['room_type'] ?? null);
                    $chromosome[$app->id] = $room?->id;
                }
                $population[] = $chromosome;
            }

            $lastBestFitness = null;
            $stagnantCount = 0;

            for ($g = 0; $g < $maxGenerations; $g++) {
                usort($population, fn($a, $b) =>
                    $this->calculateFitness($b, $applications, $rooms, $preferenceMap)
                    <=> $this->calculateFitness($a, $applications, $rooms, $preferenceMap)
                );

                $bestSolution = $population[0];
                $overallMatch = $this->calculateOverallMatch($bestSolution, $applications, $rooms, $preferenceMap);
                $currentFitness = $this->calculateFitness($bestSolution, $applications, $rooms, $preferenceMap);

                Log::info("🧬 Gen $g — Chunk {$this->chunkNumber} — Match: {$overallMatch}%, Fitness: $currentFitness");

                if ($overallMatch >= 70 || ($lastBestFitness === $currentFitness && ++$stagnantCount >= $stagnationLimit)) {
                    break;
                }

                $lastBestFitness = $currentFitness;
                $newPopulation = array_slice($population, 0, $populationSize / 2);
                while (count($newPopulation) < $populationSize) {
                    $p1 = $population[random_int(0, count($population) / 2 - 1)];
                    $p2 = $population[random_int(0, count($population) / 2 - 1)];

                    $child = [];
                    foreach ($applications as $app) {
                        $child[$app->id] = rand(0, 1) ? $p1[$app->id] : $p2[$app->id];
                    }

                    if (mt_rand(0, 100) < $mutationRate * 100) {
                        $randApp = $applications[random_int(0, count($applications) - 1)];
                        $pref = $preferenceMap[$randApp->id] ?? [];
                        $child[$randApp->id] = $this->getRandomRoom($rooms, $randApp->gender, $pref['room_type'] ?? null)?->id;
                    }

                    $newPopulation[] = $child;
                }

                $population = $newPopulation;
            }

            $bestSolution = $population[0];
            $assignedRooms = [];
            $totalMatch = 0;
            $matched = 0;

            foreach ($applications as $app) {
                $roomId = $bestSolution[$app->id] ?? null;
                if (!$roomId || isset($assignedRooms[$roomId])) continue;

                $room = $rooms->firstWhere('id', $roomId);
                if (!$room || $room->gender !== $app->gender) continue;

                $assignedCount = Application::where('room_id', $roomId)->count();
                if ($assignedCount >= $room->capacity) {
                    $assignedRooms[$roomId] = true;
                    continue;
                }

                $pref = $preferenceMap[$app->id] ?? null;
                if (!is_array($pref)) continue;

                $score = 0;
                if (strcasecmp($room->type, $pref['room_type']) === 0) $score += 3;
                if (strcasecmp($room->block, $pref['block']) === 0) $score += 2;
                if (strcasecmp($room->floor, $pref['floor']) === 0) $score += 1;

                $match = round(($score / 6) * 100, 2);
                $totalMatch += $match;
                $matched++;

                $app->room_id = $roomId;
                $app->allocation_match_percentage = $match;
                $app->save();

                $assignedRooms[$roomId] = true;
            }

            $overall = $matched > 0 ? round($totalMatch / $matched, 2) : 0;
            $status = AllocationStatus::firstOrNew([
                'session_id' => $this->sessionId,
                'chunk_number' => $this->chunkNumber,
            ]);
            $status->chunk_number = $this->chunkNumber;

            $status->is_running = false;
            $status->overall_match_percentage = $overall;
            $status->save();

            Log::info("Saved overall match percentage: {$overall}% for session: {$this->sessionId}");

            Log::info("Chunk {$this->chunkNumber} completed. Match: {$overall}%");

            $this->triggeredBy->notify(
                new RoomAllocationCompletedNotification(
                    "Room allocation completed for session {$this->sessionId}, chunk {$this->chunkNumber}.",
                    $this->sessionId,
                    $this->chunkNumber
                )
            );

            Log::info("📬 Notification sent to user: {$this->triggeredBy->id}");


        } catch (\Throwable $e) {
            Log::error("Job failed for session {$this->sessionId}, chunk {$this->chunkNumber}: {$e->getMessage()}");
            throw $e;
        } finally {
            $duration = round(microtime(true) - $start, 2);
            Log::info("Chunk {$this->chunkNumber} for session {$this->sessionId} completed in {$duration} seconds.");
        }
    }

    private function calculateFitness($chromosome, $applications, $rooms, $preferenceMap): int
    {
        $score = 0;
        $occupancy = [];

        foreach ($chromosome as $appId => $roomId) {
            if (!$roomId) continue;

            $app = $applications->firstWhere('id', $appId);
            $room = $rooms->firstWhere('id', $roomId);
            if (!$room || $room->gender !== $app->gender) continue;

            $pref = $preferenceMap[$appId];
            if (strcasecmp($room->type, $pref['room_type']) === 0) $score += 3;
            if (strcasecmp($room->block, $pref['block']) === 0) $score += 2;
            if (strcasecmp($room->floor, $pref['floor']) === 0) $score += 1;

            $occupancy[$roomId] = ($occupancy[$roomId] ?? 0) + 1;
            if ($occupancy[$roomId] > $room->capacity) $score -= 10;
        }

        return (int) $score;
    }

    private function calculateOverallMatch($solution, $applications, $rooms, $preferenceMap): float
    {
        $totalMatch = 0;
        $matched = 0;

        foreach ($solution as $appId => $roomId) {
            if (!$roomId) continue;

            $app = $applications->firstWhere('id', $appId);
            $room = $rooms->firstWhere('id', $roomId);
            if (!$room || $room->gender !== $app->gender) continue;

            $score = 0;
            $pref = $preferenceMap[$appId];
            if (strcasecmp($room->type, $pref['room_type']) === 0) $score += 3;
            if (strcasecmp($room->block, $pref['block']) === 0) $score += 2;
            if (strcasecmp($room->floor, $pref['floor']) === 0) $score += 1;

            $totalMatch += round(($score / 6) * 100, 2);
            $matched++;
        }

        return $matched > 0 ? round($totalMatch / $matched, 2) : 0;
    }

    private function getRandomRoom($rooms, $gender, $preferredType = null)
    {
        $filtered = $rooms->filter(fn($room) =>
            $room->gender === $gender &&
            (!$preferredType || strcasecmp($room->type, $preferredType) === 0)
        );

        return $filtered->isNotEmpty() ? $filtered->random() : null;
    }

    public function failed(\Throwable $exception)
    {
        AllocationStatus::where('session_id', $this->sessionId)->update([
            'is_running' => false,
            'message' => 'Room allocation job failed.',
        ]);
        Log::error("Room allocation job failed for session {$this->sessionId}: " . $exception->getMessage());
    }

    public function middleware(): array
    {
        $key = "room-allocation-{$this->sessionId}";

        if ($this->chunkNumber !== null) {
            $key .= "-chunk-{$this->chunkNumber}";
        }

        return [
            (new \Illuminate\Queue\Middleware\WithoutOverlapping($key))->expireAfter(60) // expire lock after 60 seconds
        ];
    }

}
