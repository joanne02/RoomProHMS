<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function mainRoom(){
        $rooms = Room::all();
        return view('room.main_room', compact('rooms'));
    }
    
    public function addRoom(){

        return view('room.add_room');
    }

    public function storeRoom(Request $request) {
        
        $request->validate([
            'block_from' => 'required|string',
            'block_to'   => 'required|string',
            'floor_from' => 'required|string',
            'floor_to'   => 'required|string',
            'house_from' => 'required|integer',
            'house_to'   => 'required|integer',
            'room_types' => 'required|array',
            'room_types.*.letter' => 'required|string',
            'room_types.*.type' => 'required|string',
            'room_types.*.capacity'  => 'required|integer',
            ],[],[
            'room_types.*.letter' => 'room type letter',
            'room_types.*.type' => 'room type name',
            'room_types.*.capacity' => 'room type capacity',
            'room_gender' => 'required'
        ]);
    
        $rooms = [];
        $room_types = $request->input('room_types');

        function convertFloorInput($floor) {
            return strtoupper($floor) === 'G' ? 0 : (int)$floor;
        }
    
        $startFloor = convertFloorInput($request->floor_from);
        $endFloor = convertFloorInput($request->floor_to);
    
        for ($block = ord($request->block_from); $block <= ord($request->block_to); $block++) {
            $blockLetter = chr($block);
    
            // for ($floor = ord($request->floor_from); $floor <= ord($request->floor_to); $floor++) {
            //     $floorLabel = ($floor == 1) ? 'G' : ($floor - 1);
            for ($floor = $startFloor;$floor <= $endFloor; $floor++) {
                $floorLabel = ($floor == 0) ? 'G' : $floor;
    
                for ($house = $request->house_from; $house <= $request->house_to; $house++) {
                    $houseFormatted = str_pad($house, 2, '0', STR_PAD_LEFT);
    
                    foreach ($room_types as $roomType) {
                        $roomLetter = $roomType['letter'];  // Room Letter (A, B, C)
                        $housename = "{$blockLetter}{$floorLabel}/{$houseFormatted}";
                        
                        $rooms[] = [
                            'name'       => "{$blockLetter}{$floorLabel}/{$houseFormatted}/{$roomLetter}",
                            'block'      => $blockLetter,
                            'floor'      => $floorLabel,
                            'house'      => $houseFormatted,
                            'house_name' => $housename,
                            'room'       => $roomLetter,
                            'type'       => $roomType['type'],
                            'capacity'   => $roomType['capacity'],
                            'occupy'     => 0,
                            'status'     => 'available',
                            'gender'     => $request->room_gender,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
        }
    
        Room::insert($rooms);
        $notification = array(
            'message' => 'Rooms created successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->route('mainroom')->with($notification);
    }

    public function editRoom($id){

        $room = Room::findOrFail($id);
        return view('room.edit_room',compact('room'));
    }

    public function updateRoom(Request $request, $id){
        
        // dd($request->all());
        $room = Room::findOrFail($id);

        $request->validate([
            'room_name'=>'required',
            'room_block'=>'required',
            'room_floor'=>'required',
            'room_house'=>'required',
            'room_room'=>'required',
            'room_type'=>'required',
            'room_capacity'=>'required',
            'room_status'=>'required',
            'room_occupy'=>'required',
            'room_remark'=>'nullable',
        ]);
        
        $room->name = $request->room_name;
        $room->block = $request->room_block;
        $room->floor = $request->room_floor;
        $room->house = $request->room_house;
        $room->room = $request->room_room;
        $room->type = $request->room_type;
        $room->capacity = $request->room_capacity;
        $room->status = $request->room_status;
        $room->occupy = $request->room_occupy;
        $room->remark = $request->room_remark;

        $room->save();
        
        $notification = array(
            'message'=>'Room updated successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('mainroom')->with($notification);
    }

    public function deleteRoom($id){

        Room::findOrFail($id)->delete();
        
        $notification = array(
            'message'=>'Facility deleted successfully',
            'alert-type'=>'info'
        );

        return redirect()->back()->with($notification);
    }
}

