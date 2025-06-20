<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class AnnouncementController extends Controller
{

    public function mainAnnouncement()
    {
        if (Auth::check()) {
            $userRole = Auth::user()->usertype;
            $now = \Carbon\Carbon::now();

            $announcements = Announcement::when(!in_array($userRole, ['superadmin', 'staff']), function ($query) use ($now) {
                // For non-admins: only show published and scheduled (if scheduled time has passed)
                $query->where(function ($query) use ($now) {
                    $query->where('status', 'published')
                        ->orWhere(function ($query) use ($now) {
                            $query->where('status', 'scheduled')
                                ->where('scheduled_at', '<=', $now);  // For non-admin, show only if time passed
                        });
                });
            }, function ($query) {
                // For admin: show all announcements, including scheduled ones
                $query->whereIn('status', ['published', 'scheduled']);
            })
            ->orderByRaw('COALESCE(scheduled_at, created_at) DESC')  // Sort by scheduled date in descending order
            ->get();
            
            return view('announcement.main_announcement', compact('announcements'));
        } else {
            return redirect()->route('login');
        }
    }

    public function draftAnnouncement()
    {
        $announcements = Announcement::where('status', 'draft')
            ->orderBy('created_at', 'desc') // Use creation date instead
            ->get();

        return view('announcement.draft_announcement', compact('announcements'));
    }

    public function archiveAnnouncement()
    {
        $announcements = Announcement::where('status', 'archived')
        ->orderBy('created_at', 'desc') // Use creation date instead
        ->get();

        return view('announcement.archive_announcement', compact('announcements'));

    }

    public function addAnnouncement()
    {
        return view('announcement.add_announcement');
    }
    
    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'announcement_title' => 'required',
            'announcement_description' => 'required',
            'announcement_status' => 'required',
        ]);

        $announcement = new Announcement();
        $announcement->title = $request->announcement_title;
        $announcement->description = $request->announcement_description;
        $announcement->status = $request->announcement_status;

        // Handle scheduled_at only if status is scheduled and datetime is provided
        if ($request->announcement_status === 'scheduled' && $request->filled('scheduled_at')) {
            $announcement->scheduled_at = $request->scheduled_at;
        } else {
            $announcement->scheduled_at = null; // optional: reset in case not scheduled
        }

        if ($request->hasFile('announcement_attachment')) {
            $paths = [];

            foreach ($request->file('announcement_attachment') as $image){
                $paths[] = $image->store('attachments', 'public');
            }

            $announcement->attachment = json_encode($paths);
        }

        $announcement->save();

        $notification = [
            'message' => $request->announcement_status === 'draft'
                ? 'Draft saved successfully.'
                : 'Announcement created successfully.',
            'alert-type' => 'success'
        ];

        return redirect()->route('mainannouncement')->with($notification);
    }

    public function editAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcement.edit_announcement', compact('announcement'));
    }

    public function updateAnnouncement(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'announcement_title' => 'required',
            'announcement_description' => 'required',
            'announcement_status' => 'required',
        ]);

        $announcement->title = $request->announcement_title;
        $announcement->description = $request->announcement_description;
        $announcement->status = $request->announcement_status;

        if ($request->announcement_status === 'scheduled') {
            $announcement->scheduled_at = $request->scheduled_at;
        }

        // Handle attachments
        $currentAttachments = $announcement->attachment ? json_decode($announcement->attachment, true) : [];

        // Handle removed attachments
        if ($request->has('remove_attachments')) {
            $currentAttachments = array_diff($currentAttachments, $request->remove_attachments);

            // Optionally delete files from storage:
            foreach ($request->remove_attachments as $removeAttachment) {
                Storage::disk('public')->delete($removeAttachment);

            }
        }

        // Handle new uploaded files
        if ($request->hasFile('announcement_attachment')) {
            foreach ($request->file('announcement_attachment') as $image) {
                $currentAttachments[] = $image->store('attachments','public');
            }
        }

        $announcement->attachment = json_encode(array_values($currentAttachments));

        $announcement->save();

        $notification = array(
            'message' => 'Announcement updated successfully.',
            'alert-type' => 'success',
        );

        return redirect()->route('mainannouncement')->with($notification);
    }

    // public function archiveAnnouncement($id)
    // {
    //     $announcement = Announcement::findOrFail($id);
    //     $announcement->status = 'archived';
    //     $announcement->save();

    //     return redirect()->route('mainannouncement')->with('success', 'Announcement archived successfully.');
    // }

    public function updateStatus(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'id' => 'required|exists:announcements,id',
            'status' => 'required|in:published,scheduled,archived', // Add all valid statuses
        ]);

        // Find the announcement and update its status
        $announcement = Announcement::findOrFail($request->id);
        $announcement->status = $request->status;
        $announcement->save();

        // Return a success response
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function unarchiveAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->status = 'published'; // Restore to published after unarchiving
        $announcement->save();

        $notification = array(
            'message' => 'Announcement unarchieved successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('mainannouncement')->with($notification);
    }

    public function updateAnnouncementStatus(Request $request)
    {
        $announcement = Announcement::findOrFail($request->id);

        if ($request->status === 'unarchive') {
            $announcement->status = 'published';
        } else {
            $announcement->status = $request->status;
        }

        $announcement->save();
        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function deleteAnnouncement($id){

        Announcement::findOrFail($id)->delete();
        
        $notification = array(
            'message'=>'Announcement deleted successfully',
            'alert-type'=>'info'
        );

        return redirect()->back()->with($notification);
    }
}
