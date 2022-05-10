<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function getAllMessagesFromParty($id)
    {
        try {
            $messages = Party::find($id)->messages;
            return $messages;
        } catch (\Throwable $th) {
            Log::error('Error getting all messages ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error getting all messages '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createMessage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'message' => 'required|string',
                'party_id' => 'required|int',
            ]);

            if ($validator->fails()) return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);

            $userId = auth()->user()->id;

            $newMessage = new Message();

            $newMessage->message = $request->message;
            $newMessage->party_id = $request->party_id;
            $newMessage->user_id = $userId;

            $newMessage->save();

            return response()->json(["success" => "Message created -> " . $newMessage->message], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Error creating Message ' . $th->getMessage());

            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error creating message '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateMessage(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'message' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $userId = auth()->user()->id;

            $message = Message::where('id', $id)->where('user_id', $userId)->first();

            if (empty($message)) return response()->json(["error" => "Message not found"], Response::HTTP_NOT_FOUND);

            if (isset($request->message)) $message->message = $request->message;

            $message->save();

            return response()->json(["success" => "Updated message => " . $message->message], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error updating message '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteMessage($id){
        try {
            $userId = auth()->user()->id;

            $message = Message::where('id', $id)->where('user_id', $userId)->first();
            
            if (empty($message)) return response()->json(["error" => "Message not found"], Response::HTTP_NOT_FOUND);

            $message->delete();

            return response()->json(["success" => "Deleted message => " . $message->message], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error deleting message '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
