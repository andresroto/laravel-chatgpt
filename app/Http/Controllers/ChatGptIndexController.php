<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ChatGptIndexController extends Controller
{

    /**
     * @param string|null $id
     * @return Response
     */
    public function __invoke(string $id = null): Response
    {
        return Inertia::render('Chat/ChatIndex', [
            'chat' => fn () => $id ? Chat::findOrFail($id) : null,
            'messages' => Chat::latest()->whereUserId(Auth::id())->get(),
        ]);
    }
}
