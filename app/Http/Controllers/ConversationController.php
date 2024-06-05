<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelIgnition\FlareMiddleware\AddJobs;

class ConversationController extends Controller
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

    public function storeMessage(Request $request, Conversation $conversation)
    {
        $this->authorizeConversationAccess($conversation);

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $conversation->messages()->create([
            'content' => $request->content,
            'sender_id' => Auth::id(),
        ]);

        return redirect()->route('conversations.show', $conversation);
    }

    public function create(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $conversation = Conversation::create();
        $conversation->users()->attach([Auth::id(), $request->receiver_id]);

        return redirect()->route('conversations.show', $conversation);
    }

    private function authorizeConversationAccess(Conversation $conversation)
    {
        if (!$conversation->users->contains(Auth::id())) {
            abort(403, 'Unauthorized access to this conversation.');
        }
    }
    public function start($id)
    {
        $product = Product::findOrFail($id);
        $receiver = $product->user_id;
        $conversation = Conversation::whereHas('users', function($query) use ($receiver) {
            $query->where('user_id', Auth::id())
                  ->orWhere('user_id', $receiver);
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
    
            $conversation->users()->attach([Auth::id(), $receiver]);
            $conversation->products()->attach($id);
            $conversation->save();
        }

        return redirect()->route('conversations.show', $conversation);
    }

}
