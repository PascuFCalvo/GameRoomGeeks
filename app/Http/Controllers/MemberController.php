<?php

namespace App\Http\Controllers;

use App\Models\Member; // Asegúrate de importar el modelo Member
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Asegúrate de importar la clase Response
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function createMember(Request $request) // Corregí el nombre de la función
    {
        try {
            $userId= auth()->user()->id;
            $roomId = $request->input("room_id");
            $user = User::find($userId);
            
            $user->rooms()->attach($roomId);
                
            return response()->json(
                [
                    'success'=>true,
                    'message' => 'Member added successfully'
                ],
                Response::HTTP_CREATED
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

    public function deleteMember(Request $request, $id) 
    {
        try {
            $member = Member::query()
                ->where("id", $id)
                ->firstOrFail();

            $member->delete();

            return response()->json(
                [
                    'message' => 'Member deleted successfully',
                    'member' => $member
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            // Maneja la excepción aquí
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
        } catch (\Throwable $e) {
            // Maneja la excepción aquí
        }
    }
    
}
