<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function create(Request $request){
        try {
            $userId = User::query()
                ->where("isActive", true)
                ->get(["id"]);

             $roomId = Room::query()
                ->get(["id"]);   
            $newMessage = Message::create(
                [

                    "user_id" => $userId,
                    "room_id" => $roomId,
                    "message" => $request->message
                ]
            );
            return response()->json(
                [
                    'message' => 'Message created successfully',
                    'message' => $newMessage
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $e) {
            // Maneja la excepción aquí
        }
    }
    public function delete(Request $request, $id)
    {
        try {
            $message = Message::query()
                ->where("id", $id)
                ->firstOrFail();

            $message->delete();

            return response()->json(
                [
                    'message' => 'Message deleted successfully',
                    'message' => $message
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            // Maneja la excepción aquí
        }
    }
    public function getMessages(Request $request)
    {
        try {
            $messages = Message::query()
                ->get(["id", "user_id", "room_id", "message"]);

            return response()->json(
                [
                    'message' => 'Messages listed successfully',
                    'messages' => $messages
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            // Maneja la excepción aquí
        }
    }
    public function editMesssage(Request $request, $id)
    {
        try {
            $message = Message::query()
                ->where("id", $id)
                ->firstOrFail();

            $message->update();

            return response()->json(
                [
                    'message' => 'Message edited successfully',
                    'message' => $message
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            // Maneja la excepción aquí
        }
    }
}
