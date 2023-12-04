<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function create(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $roomId = $request->input('room_id');

            $isMember=Member::query()
            ->where("room_id",$roomId)
            ->where("user_id",$userId)
            ->firstOrFail();

            $newMessage = Message::create(
                [
                    "user_id" => $userId,
                    "room_id" => $roomId,
                    "content" => $request->input('message')
                ]
            );
            return response()->json(
                [
                    'message' => 'Message created successfully',
                    'message' => $newMessage
                ],
                Response::HTTP_CREATED
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Member not found in the specified room"
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating message"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function deleteMessage(Request $request, $id)
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
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting message"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function getMessages(Request $request, $id)
    {
        try {
            $userId = auth()->user()->id;
            $member = Member::query()
                ->where('room_id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            $messages = Message::query()
                ->where('room_id', $id)
                ->get(["id", "user_id", "room_id", "content"]);

            return response()->json(
                [
                    'message' => 'Messages listed successfully',
                    'messages' => $messages
                ],
                Response::HTTP_OK
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json(
                [
                    "success" => false,
                    "message" => "Member not found in the specified room"
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting messages"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function editMesssage(Request $request, $id)
    {
        try {
            $message = Message::query()->find($id);
            $newText = $request->input('message');

            $message->content = $newText;
            $message->save();

            return response()->json(
                [
                    'message' => 'Message edited successfully',
                    'message' => $message
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error editing message"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
