<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Student;
use App\Http\Requests\CreateRoomRequest;

class RoomsController extends Controller
{
    public function index()
    {
        $rooms=Room::withCount('students')->get();

        return response()->json([
            "data"=>$rooms
        ],200);
    }

    public function store(CreateRoomRequest $request)
    {
        $room = Room::create($request->validated());

        return response()->json([
            'message'=>'Запись успешно создана',
        ],201);
    }
    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'message'=>'Запись успешно удалена',
        ],200);
    }
}
