<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class FaceitWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        // Log the incoming request for debugging
        Log::info('Faceit Webhook:', $request->all());

        Telegram::sendMessage([
            'chat_id' => 401336836,
            'text' => "Incoming Faceit Webhook: " . json_encode($request->all()),
        ]);
        // Process the webhook data
        // You can access the data using $request->input('key')

        return response()->json(['status' => 'success']);
    }
}
