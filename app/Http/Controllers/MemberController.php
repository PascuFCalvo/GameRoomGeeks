<?php

namespace App\Http\Controllers;

use App\Models\Member; // Asegúrate de importar el modelo Member

use Illuminate\Http\Request;
use Illuminate\Http\Response; // Asegúrate de importar la clase Response

class MemberController extends Controller
{
    public function createMember(Request $request) // Corregí el nombre de la función
    {
        try {
            $newMember = Member::create(
                [
                    "user_id" => $request->user_id,
                    "room_id" => $request->room_id,
                ]
            );
            return response()->json(
                [
                    'message' => 'Member created successfully',
                    'member' => $newMember
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $e) {
            // Maneja la excepción aquí
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
