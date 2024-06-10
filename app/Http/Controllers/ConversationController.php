<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelIgnition\FlareMiddleware\AddJobs;

class ConversationController extends AbstractCommunicationController
{
    public function index()
    {
        $conversations = Auth::user()->conversations;
        $users = User::where('id', '!=', Auth::id())->get();

        return view('conversations.index', compact('conversations', 'users'));
    }

    public function show(Conversation $conversation)
    {
        $this->authorizeConversationAccess($conversation);

        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();

        return view('conversations.show', compact('conversation', 'messages'));
    }
    public function store($id)
    {
        $product = Product::findOrFail($id);
        $conversation = Conversation::whereHas('users', function ($query) use ($product) {
            $query->where('user_id', Auth::id())
                ->orWhere('user_id', $product->user_id);
        })->whereHas('messages', function ($query) use ($id) {
            $query->where('sender_id', Auth::id())
                ->whereHas('conversation', function ($q) use ($id) {
                    $q->whereHas('products', function ($q) use ($id) {
                        $q->where('products.id', $id);
                    });
                });
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->users()->attach([Auth::id(), $product->user_id]);
            $conversation->products()->attach($id);
            $conversation->save();
        }

        return redirect()->route('conversations.show', $conversation);
    }
}
