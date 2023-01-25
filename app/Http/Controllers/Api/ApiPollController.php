<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\User;

class ApiPollController extends Controller
{
    private function validateApiKey(string $key) {
        return User::where('api_key', $key)->exists();
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

        $polls = \App\Models\Poll::paginate(10, ['*'], 'page', $page);

        return response()->json($polls);

    }
}
