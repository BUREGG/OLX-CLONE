<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatController extends Controller
{
    public function store(Request $request): string
    {
        try {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('CHAT_GPT_KEY')
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                "model" => 'llama3-8b-8192',
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $request->post('content')
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ])->body();

            $response = json_decode($response, true);

            if (isset($response['choices'][0]['message']['content'])) {
                return $response['choices'][0]['message']['content'];
            } else {
                Log::error('Unexpected response structure', ['response' => $response]);
                return "Unexpected response structure.";
            }
        } catch (Throwable $e) {
            Log::error('Error in ChatController', ['exception' => $e]);
            return "An error occurred: " . $e->getMessage();
        }
    }
    public function show()
    {
        return view('chatai');
    }
}
