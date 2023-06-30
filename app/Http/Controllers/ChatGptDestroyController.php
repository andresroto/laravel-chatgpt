<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChatGptDestroyController extends Controller
{
    /**
     * @param Chat $chat
     * @return RedirectResponse
     */
    public function __invoke(Chat $chat): RedirectResponse
    {
        $chat->delete();
        return to_route('chat.show');
    }
}
