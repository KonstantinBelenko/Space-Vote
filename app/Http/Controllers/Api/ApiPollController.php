<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use Illuminate\Http\Request;
use \App\Models\User;

class ApiPollController extends Controller
{
    private function validateApiKey($key) {
        try {
            return User::where('api_key', $key)->exists();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAllPolls(Request $request)
    {
        if (!$this->validateApiKey($request->header('X-API-KEY'))) {
            return response()->json([
                'error' => 'Invalid API key',
            ], 401);
        }

        if ($request->has('page')) {
            $page = $request->input('page');
        } else {
            $page = 1;
        }

        // Check if there are no polls
        if (\App\Models\Poll::count() == 0) {
            return response()->json([
                'error' => 'No polls exist',
            ], 200);
        }


        $polls = \App\Models\Poll::all()->forPage($page, 10)->filter(function ($poll) {
            return $poll->is_public;
        });

        // Return only title, description, uuid, type, created_at, is_open, and nVotes
        $polls = $polls->map(function ($poll) {
            return [
                'title' => $poll->title,
                'description' => $poll->description,
                'uuid' => $poll->uuid,
                'type' => $poll->type,
                'created_at' => $poll->created_at,
                'is_open' => $poll->is_open,
                'nVotes' => $poll->nVoted(),
                'answers' => $poll->answers->map(function ($answer) {
                    return [
                        'answer' => $answer->text,
                        'nVotes' => $answer->nVoted(),
                    ];
                }),
            ];
        });

        return response()->json($polls);
    }

    public function getPollById(Request $request) {

        if (!$this->validateApiKey($request->header('X-API-KEY'))) {
            return response()->json([
                'error' => 'Invalid API key',
            ], 401);
        }

        $poll = \App\Models\Poll::where('uuid', $request->uuid)->first();

        if ($poll === null) {
            return response()->json([
                'error' => 'Poll not found',
            ], 404);
        }

        return response()->json([
            'title' => $poll->title,
            'description' => $poll->description,
            'uuid' => $poll->uuid,
            'type' => $poll->type,
            'created_at' => $poll->created_at,
            'is_open' => $poll->is_open,
            'nVotes' => $poll->nVoted(),
            'answers' => $poll->answers->map(function ($answer) {
                return [
                    'answer' => $answer->text,
                    'nVotes' => $answer->nVoted(),
                ];
            }),
        ]);
    }

    public function createPoll(Request $request) {

        if (!$this->validateApiKey($request->header('X-API-KEY'))) {
            return response()->json([
                'error' => 'Invalid API key',
            ], 401);
        }

        $user = User::where('api_key', $request->header('X-API-KEY'))->first();

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'type' => 'required|in:anarchy,general',
                'is_public' => 'required|boolean',
                'answers' => 'required|array|min:2|max:10',
                'answers.*' => 'required|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Invalid request',
                'message' => $e->getMessage(),
            ], 400);
        }


        // Create poll
        $poll = Poll::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'is_open' => true,
            'is_public' => $request->is_public,
            'user_id' => $user->id,
        ]);
        $poll->save();

        // Create answers
        foreach ($request->answers as $answer) {
            $answer = \App\Models\Answer::create([
                'text' => $answer,
                'poll_id' => $poll->id,
            ]);
            $answer->save();
        }

        return response()->json([
            'title' => $poll->title,
            'description' => $poll->description,
            'uuid' => $poll->uuid,
            'type' => $poll->type,
            'created_at' => $poll->created_at,
            'is_open' => $poll->is_open,
            'nVotes' => $poll->nVoted(),
            'answers' => $poll->answers->map(function ($answer) {
                return [
                    'answer' => $answer->text,
                    'nVotes' => $answer->nVoted(),
                ];
            }),
        ]);
    }
}
