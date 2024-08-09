<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\User;
use WebSocket\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use WebSocket\ConnectionException;

class ChatController extends Controller
{
    private Client $wsClient;
    public function __construct()
    {
        $this->wsClient = new Client("ws://go-websocket:3001/ws");
    }

    public function index()
    {
        return Inertia::render('Chat/Index', [

        ]);
    }

    public function create(Request $request)
    {
        $userId = intval($request->input('user_id'));
        $auth = Auth::user();

        $chat = Chat::whereHas('chatMembers', function($query) use ($auth, $userId) {
            $query->whereIn('user_id', [$auth->id, $userId])
                ->select('chat_id')
                ->groupBy('chat_id')
                ->havingRaw('COUNT(DISTINCT user_id) = 2');
        })->with('chatMessages')->first();

        return Inertia::render('Chat/Index', [
            'sender' => new UserResource($auth),
            'user' => new UserResource(User::find($userId)),
            'chat' => $chat,
        ]);
    }

    public function store(Request $request)
    {
        if ($chatId = $request->input('chat_id')) {
            $chat = Chat::find($chatId);
            $newMessage = $chat->chatMessages()->create([
                'sender_id' => $request->input('sender_id'),
                'content' => $request->input('content'),
            ]);
        } else {
            $chat = new Chat();
            $chat->name = 'one-to-one-'.rand(1, 20);
            $chat->save();
            $newMessage = $chat->chatMessages()->create([
                'sender_id' => $request->input('sender_id'),
                'content' => $request->input('content')
            ]);
            $ids = [$request->input('sender_id'), $request->input('user_id')];
            $chat->chatMembers()->sync($ids);
        }

        try {
            $this->wsClient->send(json_encode([
                'sender_id' => $newMessage['sender_id'],
                'content' => $newMessage['content'],
                'chat_id' => $newMessage['chat_id'],
            ]));
            $message = $this->wsClient->receive();
           // echo $message;
        } catch (ConnectionException $e) {
            dd("Connection error: " . $e->getMessage());
        } catch (\Exception $e) {
            dd("General error: " . $e->getMessage());
        }

    }

    public function clearChat(Chat $chat)
    {
        $chat->chatMessages()->delete();
        return response(['success' => true]);
    }

    public function sendMessage(Request $request)
    {
        dd($request->all());
    }
}
