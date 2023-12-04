<?php

namespace App\Http\Controllers;

use App\Models\Member; // Asegúrate de importar el modelo Member
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Asegúrate de importar la clase Response
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function createMember(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $roomId = $request->input("room_id");
            // $room = Room::query()
            // ->where("id", $roomId)
            // ->firstOrFail();

            // $userExist = Member::query()
            // ->where("room_id", $roomId)
            // ->where("user_id", $user)

            // ->first();
           
          
            $user = User::find($userId);
            if (!$user) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
            //to do: Manejar respuesta en caso de que ese usuario ya este añadido a esa sala
            $user->rooms()->attach($roomId);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Member added successfully'
                ],
                Response::HTTP_CREATED
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json(
                [
                    "success" => false,
                    "message" => "Room not found"
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error adding member"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }



    public function deleteMember(Request $request)

    {
        try {
            $userId = auth()->user()->id;
            $roomId = $request->input("room_id");
            $user = User::find($userId);
            $user->rooms()->detach($roomId);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Member deleted successfully',
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting member"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function getMembers(Request $request)
    {
        try {
            $members = Member::query()
                ->get(["id", "user_id", "room_id"]);

            return response()->json(
                [
                    'message' => 'Members listed successfully',
                    'members' => $members
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting all members"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
