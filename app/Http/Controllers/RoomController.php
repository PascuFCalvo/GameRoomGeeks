<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Videogame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
   public function createRoom(Request $request)
   {
      try {
         $name = $request->input('name');
         $videogame_id = $request->input('videogame_id');
         $id = auth()->user()->id;

         $newRoom = Room::create([
            'name' => $name,
            'videogame_id' => $videogame_id,
            'room_owner' => $id
         ]);
         return response()->json(
            [
               "success" => true,
               "message" => "Created room successfully",
               "data" => $newRoom
            ],
            Response::HTTP_CREATED
         );
      } catch (\Throwable $th) {
         Log::error($th->getMessage());

         return response()->json(
            [
               "success" => false,
               "message" => "Error creating room"
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
         );
      }
   }

   public function getRooms()
   {
      try {
         $rooms = Room::query()
            ->get(["id", "name", "videogame_id", "room_owner"]);


         return response()->json(
            [
               'message' => 'Rooms listed successfully',
               'rooms' => $rooms
            ],
            Response::HTTP_OK
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error listing rooms'], response::HTTP_INTERNAL_SERVER_ERROR);
      }
   }

   public function getRoomsbyVideogame($id)
   {
      try {
         $rooms = Room::query()
            ->where("videogame_id", $id)
            ->get(["id", "name", "videogame_id", "room_owner"]);

         return response()->json(
            [
               'message' => 'Rooms listed successfully',
               'rooms' => $rooms
            ],
            response::HTTP_OK
         );
      } catch (\Throwable $th) {
         Log::error($th->getMessage());
         return response()->json(['message' => 'Error listing rooms'], response::HTTP_INTERNAL_SERVER_ERROR);
      }
   }
   public function deleteRoom($id)
   {
      try {
         $room = Room::query()
            ->where("id", $id);


         $room->delete();

         return response()->json(
            [
               'message' => 'Room deleted successfully',
               'room' => $room
            ],
            response::HTTP_OK
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error deleting room'], response::HTTP_INTERNAL_SERVER_ERROR);
      }
   }

   public function updateRoom($id, Request $request)
   {
      try {
         $room = Room::query()
            ->where("id", $id);

         $room->update($request->all());

         return response()->json(
            [
               'message' => 'Room updated successfully',
               'room' => $room
            ],
            response::HTTP_OK
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error updating room'], response::HTTP_INTERNAL_SERVER_ERROR);
      }
   }  
}
