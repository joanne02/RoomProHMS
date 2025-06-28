<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;
use App\Models\User;
use App\Models\Room;
use Carbon\Carbon;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Support\Facades\DB;

class CheckOutSeeder extends Seeder
{
    public function run(): void
    {
        $residents = Resident::whereNull('check_out')->get();

        foreach ($residents as $resident) {
            // Generate a check-out datetime 1–30 days after check-in
            $checkIn = Carbon::parse($resident->check_in);
            $checkOut = fake()->dateTimeBetween(
                $checkIn->copy()->addDays(1),
                '2024-11-30 23:59:59'
            );

            // Update resident check_out
            $resident->check_out = Carbon::parse($checkOut);
            $resident->save();

            // Update user usertype to 'user'
            $user = User::find($resident->user_id);
            if ($user) {
                $user->usertype = 'user';
                $user->save();

                $user->roles()->detach();
                Bouncer::assign('user')->to($user);
            }

            // Update room occupancy
            $room = Room::find($resident->room_id);
            if ($room && $room->occupy > 0) {
                $room->occupy -= 1;

                if ($room->occupy < $room->capacity) {
                    $room->status = 'available';
                }

                $room->save();
            }

            $this->command->info("Checked out {$resident->name} on {$resident->check_out}");
        }
    }
}
