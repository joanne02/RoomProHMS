<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitation;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VisitationController extends Controller
{
    public function mainVisitation()
    {
        $visitations = Visitation::all();
        return view('visitation.main_visitation', compact('visitations'));
    }

    public function addVisitation()
    {
        return view('visitation.add_visitation');
    }

    public function storeVisitation(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'visitor_name'       => 'required|string|max:255',
            'visitor_contact_no' => 'required|string|max:20',
            'visit_purpose'      => 'required|string',
            'visit_check_in'     => 'required|date',
            'visit_check_out'    => 'required|date|after_or_equal:visit_check_in',
            'visit_appendix'     => 'nullable|array',
            'visit_appendix.*'   => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:2048',
            'visit_description'  => 'nullable|string',
            'other_visit_purpose' => 'nullable|string|max:255',
        ]);

        $visitation = new Visitation();
        $visitation->name = $request->visitor_name;
        $visitation->contact_no = $request->visitor_contact_no;
        $visitation->purpose = $request->visit_purpose;
        $visitation->check_in = $request->visit_check_in;
        $visitation->check_out = $request->visit_check_out;
        $visitation->description = $request->visit_description;
        $visitation->other_purpose = $request->other_visit_purpose;

        // Generate a unique token for this visitation
        // $visitation->token = Str::random(32); // This token will be used in the QR code

        // Handle multiple file uploads
        if ($request->hasFile('visit_appendix')) {
            $filePaths = [];
            foreach ($request->file('visit_appendix') as $file) {
                $filePaths[] = $file->store('visitations', 'public');
            }
            $visitation->appendix = json_encode($filePaths); // Store as JSON array
        }

        // dd($visitation);

        $visitation->save();

        $notification = array(
            'message'=>'Visitation added successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('mainvisitation')->with($notification);
    }

    public function viewVisitation($id)
    {
        $visitation = Visitation::findOrFail($id);
        return view('visitation.view_visitation', compact('visitation'));
    }

    public function editVisitation($id)
    {
        $visitation = Visitation::findOrFail($id);
        return view('visitation.edit_visitation', compact('visitation'));
    }

    public function updateVisitation(Request $request, $id)
    {
        // $visiatation = Visitation::findOrFail($id);
        $request->validate([
            'visitor_name'       => 'required|string|max:255',
            'visitor_contact_no' => 'required|string|max:20',
            'visit_purpose'      => 'required|string',
            'visit_check_in'     => 'required|date',
            'visit_check_out'    => 'required|date|after_or_equal:visit_check_in',
            'visit_description'  => 'nullable|string',
            'other_visit_purpose' => 'nullable|string|max:255',
        ]);

        $visitation = Visitation::findOrFail($id);
        $visitation->name = $request->visitor_name;
        $visitation->contact_no = $request->visitor_contact_no;
        $visitation->purpose = $request->visit_purpose;
        $visitation->check_in = $request->visit_check_in;
        $visitation->check_out = $request->visit_check_out;
        $visitation->description = $request->visit_description;
        $visitation->other_purpose = $request->other_visit_purpose;

        // Handle deletions
        if ($request->has('delete_appendix')) {
            $filesToDelete = $request->input('delete_appendix');
            $existingFiles = json_decode($visitation->appendix, true) ?? [];

            foreach ($filesToDelete as $filePath) {
                // Remove from storage
                Storage::disk('public')->delete($filePath);

                // Remove from the list
                $existingFiles = array_filter($existingFiles, fn($f) => $f !== $filePath);
            }

            // Re-index and update the appendix
            $visitation->appendix = json_encode(array_values($existingFiles));
        }

        // Handle multiple file uploads
        if ($request->hasFile('visit_appendix')) {
            $filePaths = [];
            foreach ($request->file('visit_appendix') as $file) {
                $filePaths[] = $file->store('visitations', 'public');
            }

            $existingFiles = json_decode($visitation->appendix, true) ?? [];
            $allFiles = array_merge($existingFiles, $filePaths);

            $visitation->appendix = json_encode($allFiles); // Store as JSON array
        }

        $visitation->save();

        $notification = array(
            'message' => 'Visitation updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('mainvisitation')->with($notification);
    }

public function downloadQr()
{
    $url = route('visitation.form', [], true); // No token needed now

    $qrSvg = QrCode::format('svg')
        ->size(300)
        ->generate($url);

    $qrSvgClean = preg_replace('/<\?xml.*?\?>/', '', $qrSvg);

    $wrappedSvg = <<<SVG
    <?xml version="1.0" encoding="UTF-8"?>
    <svg width="500" height="500" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
        <g transform="translate(100,100)">
            $qrSvgClean
        </g>
    </svg>
    SVG;

    return response($wrappedSvg)
        ->header('Content-Type', 'image/svg+xml')
        ->header('Content-Disposition', 'attachment; filename="visitation_qr.svg"');
}
    
    public function showQrPage($visitationToken)
    {
        $qr = QrCode::format('svg')
            ->size(300)
            ->generate(route('visitation.form', ['visitationToken' => $visitationToken])); // Token passed here
        return view('visitation.qr_page', compact('qr'));
    
    }

    public function viewTokenQr()
    {
        $qrUrl = route('visitation.form', [], true);

        $qrSvg = QrCode::format('svg')
            ->size(300)
            ->generate($qrUrl);

        return view('visitation.view_QR', compact('qrSvg', 'qrUrl'));

    }

    public function publicForm(Request $request)
    {
        return view('visitation.public_form'); // You can reuse add_visitation or make a simpler version
    }

    // public function scanQr($visitationToken)
    // {
    //     $today = Carbon::now()->toDateString();

    //     $existingVisitation = Visitation::where('token', $visitationToken)
    //         ->whereDate('created_at', $today)
    //         ->first();

    //     if ($existingVisitation) {
    //         // Show checkout form with prefilled values
    //         return view('visitation.public_form', [
    //             'visitationToken' => $visitationToken,
    //             'existing' => $existingVisitation
    //         ]);
    //     } else {
    //         // New visitor (check-in)
    //         return view('visitation.public_form', [
    //             'visitationToken' => $visitationToken,
    //             // 'existing' => null
    //         ]);
    //     }
    // }

    public function scanQr()
{
    return view('visitation.contact_prompt'); // no need to pass visitationToken
}


    public function storePublicVisitation(Request $request)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:255',
            'visitor_contact_no' => 'required|string|max:20',
            'visit_check_in' => 'nullable|date',
            'visit_check_out' => 'nullable|date',
            'visit_appendix.*' => 'file|max:2048' // optional file validation
        ], [
            'visitor_name.required' => 'Please enter your full name.',
            'visitor_contact_no.required' => 'Please enter your contact number.',
            'visit_check_in.date' => 'Check-in time must be a valid date.',
            'visit_check_out.date' => 'Check-out time must be a valid date.',
            'visit_appendix.*.max' => 'Each uploaded file must be less than 2MB.',
        ]);

        $today = Carbon::now()->toDateString();

        $existing = Visitation::where('contact_no', $request->visitor_contact_no)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->first();

        if ($existing) {
            // Checkout
            $existing->check_out = $request->visit_check_out ?? now();
            $existing->save();

            return redirect()->back()->with('success', 'Thank you! Your check-out was recorded.');
        } else {
            // Check-in
            $visitation = new Visitation();
            $visitation->name = $request->visitor_name;
            $visitation->contact_no = $request->visitor_contact_no;
            $visitation->purpose = $request->visit_purpose === 'other'
                ? $request->other_visit_purpose
                : $request->visit_purpose;
            $visitation->description = $request->visit_description ?? null;
            $visitation->check_in = $request->visit_check_in ?? now();
            $visitation->token = $request->visitation_token; // still optional, or use static/default

            $visitation->save();

            return redirect()->back()->with('success', 'Thank you! Your check-in was recorded.');
        }

    }

public function checkContact(Request $request)
{
    $today = Carbon::now()->toDateString();

    if ($request->isMethod('post')) {
        $request->validate([
            'visitor_contact_no' => 'required|string|max:20',
        ]);

        $existing = Visitation::where('contact_no', $request->visitor_contact_no)
            ->whereDate('created_at', $today)
            ->first();

        return view('visitation.public_form', [
            'existing' => $existing,
            'contactNo' => $request->visitor_contact_no,
        ])->with('success', 'Record found. You may now check in or out.');
    }

    return view('visitation.contact_prompt');
}


    public function deleteVisitation($id)
    {
        $visitation = Visitation::findOrFail($id);
        $visitation->delete();

        $notification = array(
            'message' => 'Visitation deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('mainvisitation')->with($notification);
    }

}
