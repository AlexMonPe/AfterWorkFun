<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function getAllMessagesFromParty($id)
    {
        try {
            $messages = Party::find($id)->messages;

            return $messages;
        } catch (\Throwable $th) {
            Log::error('Error getting all parties ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error getting all parties '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
