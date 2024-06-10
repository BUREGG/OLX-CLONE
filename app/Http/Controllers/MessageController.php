<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private function authorizeConversationAccess(Conversation $conversation)
    {
        if (!$conversation->users->contains(Auth::id())) {
            abort(403, 'Unauthorized access to this conversation.');
        }
    }
    public function store(Request $request, Conversation $conversation)
    {
        $this->authorizeConversationAccess($conversation);

        $request->validate([
            'content' => [
                'required',
                'string',
                'max:100'
            ],
        ]);

        $conversation->messages()->create([
            'content' => $request->content,
            'sender_id' => Auth::id(),
        ]);

        return redirect()->route('conversations.show', $conversation);
    }
}
