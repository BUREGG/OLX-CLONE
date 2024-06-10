<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbstractCommunicationController extends Controller
{
    public function authorizeConversationAccess(Conversation $conversation)
    {
        if (!$conversation->users->contains(Auth::id())) {
            abort(403, 'Unauthorized access to this conversation.');
        }
    }
}
