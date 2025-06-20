<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use App\Models\Facility;
use App\Models\FacilityType;

class FacilityController extends Controller
{
    public function mainFacility(){
        $facilities = Facility::with('facilityType')->get();
        $facility_types = FacilityType::all();
        return view('facility.main_facility',compact('facilities','facility_types'));
    }

    public function addFacility(){

        $facilityTypes = FacilityType::all();
        return view('facility.add_facility', compact('facilityTypes'));
    }

    public function storeFacility(Request $request){
        
        // dd($request->all());
        $request->validate([
            'facility_name'=>'required',
            'facility_type'=>'required',
            'facility_description'=>'required',
            'facility_status'=>'required|in:Good,Under Maintenance,Closed',
            'facility_image'=>'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
        
        $facility = new Facility();
        $facility->name = $request->facility_name;
        $facility->facility_type_id = $request->facility_type;
        $facility->description = $request->facility_description;
        $facility->status = $request->facility_status;

        if ($request->hasFile('facility_image')){
            $imagePath = $request->file('facility_image');
            $path = $imagePath->store('facilities','public');
            $facility->image = $path;
        }

        // dd($facility);

        $facility->save();
        
        $notification = array(
            'message'=>'Facility added successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('mainfacility')->with($notification);
    }

    public function editFacility($id){

        $facility = Facility::findOrFail($id);
        $facilityTypes = FacilityType::all();
        return view('facility.edit_facility',compact('facility', 'facilityTypes'));
    }

    public function updateFacility(Request $request, $id){
        
        // dd($request->all());
        $facility = Facility::findOrFail($id);

        $request->validate([
            'facility_name'=>'required',
            'facility_type'=>'required',
            'facility_description'=>'required',
            'facility_status'=>'required|in:Good,Under Maintenance,Closed',
            'facility_image'=>'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
        
        $facility->name = $request->facility_name;
        $facility->facility_type_id = $request->facility_type;
        $facility->description = $request->facility_description;
        $facility->status = $request->facility_status;


        if ($request->hasFile('facility_image')){
            if($facility->image){
                Storage::disk('public')->delete($facility->image);
            }

            $imagePath = $request->file('facility_image')->store('facilities','public');
            $facility->image = $imagePath;
        }

        $facility->save();
        
        $notification = array(
            'message'=>'Facility updated successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('mainfacility')->with($notification);
    }

    public function deleteFacility($id){

        Facility::findOrFail($id)->delete();
        
        $notification = array(
            'message'=>'Facility deleted successfully',
            'alert-type'=>'info'
        );

        return redirect()->back()->with($notification);
    }
}
