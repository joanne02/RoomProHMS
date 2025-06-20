<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacilityType;

class FacilityTypeController extends Controller
{
    public function mainFacilityType(){
        $facility_types = FacilityType::latest()->get();
        return view('facility_type.main_facility_type',compact('facility_types'));
    }

    public function addFacilityType(){
        
        return view('facility_type.add_facility_type');
    }

    public function storeFacilityType(Request $request){
        
        $request->validate([
            'facility_type_name'=>'required',
        ]);
        
        $facility_type = new FacilityType();
        $facility_type->name = $request->facility_type_name;

        $facility_type->save();
        
        $notification = array(
            'message'=>'Facility added successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('mainfacilitytype')->with($notification);
    }

    public function editFacilityType($id){

        $facility_type = FacilityType::findOrFail($id);
        return view('facility_type.edit_facility_type',compact('facility_type'));
    }

    public function updateFacilityType(Request $request, $id){
        
        // dd($request->all());
        $facility_type = FacilityType::findOrFail($id);

        $request->validate([
            'facility_type_name'=>'required',
        ]);
        
        $facility_type->name = $request->facility_type_name;

        $facility_type->save();
        
        $notification = array(
            'message'=>'Facility updated successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('mainfacilitytype')->with($notification);
    }

    public function deleteFacilityType($id)
    {
        $facilityType = FacilityType::withCount('facilities')->findOrFail($id);

        if ($facilityType->facilities_count > 0) {
            $notification = [
                'message' => 'Cannot delete: This facility type is assigned to one or more facilities.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $facilityType->delete();

        $notification = [
            'message' => 'Facility type deleted successfully',
            'alert-type' => 'info'
        ];

        return redirect()->back()->with($notification);
    }

}
