<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatGptRequest;
use App\Models\Chat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;

class ChatGptStoreController extends Controller
{

    /**
     * @param StoreChatGptRequest $request
     * @param string|null $id
     * @return RedirectResponse
     */
    public function __invoke(StoreChatGptRequest $request, string $id = null): RedirectResponse
    {
        $messages = [];

        if ($id) {
            $chat = Chat::findOrFail($id);
            $messages = $chat->context;
        }

        $messages[] = [
            'role' => 'user',
            'content' => $request->input('prompt')
        ];

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
        ]);

        $messages[] = [
            'role' => 'assistant',
            'content' => $response->choices[0]->message->content
        ];

        $chatData = [
            'user_id' => Auth::id(),
            'context' => $messages,
        ];

        if ($id) {
            $chat->update($chatData);
        } else {
            $chat = Chat::create($chatData);
        }

        return redirect()->route('chat.show', [$chat->id]);
    }
}
