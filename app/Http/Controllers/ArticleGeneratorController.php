<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class ArticleGeneratorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->title == null) {
            return;
        }

        $title = $request->title;

        $client = OpenAI::client(config('app.openai_api_key'));

        $result = $client->chat()->create([
            "model" => "gpt-3.5-turbo",
            "messages" => [
                ["role" => "system", "content" => "You are a helpful assistant."],
                ["role" => "user", "content" => sprintf('Write article about: %s', $title)],
            ],
        ]);

        $content = trim($result['choices'][0]['message']['content']);

        return view('welcome', compact('title', 'content'));
    }
}
