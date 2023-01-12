<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;

class HomeController extends Controller
{
    public function __invoke()
    {
        /* Send welcome view with all polls that are open (paginated), desc order */

        $all_posts = Poll::where('is_open', true)->orderBy('created_at', 'desc')->paginate(10);

        // Remove admin polls if user is not admin or owner
        if (!auth()->user()->is_admin && !auth()->user()->is_owner) {
            $all_posts = $all_posts->filter(function ($poll) {
                // Remove admin polls using poll table 'type'
                return $poll->type != 'admin';
            });
        }

        // Remove student polls if user is not student
        if (!auth()->user()->is_approved) {
            $all_posts = $all_posts->filter(function ($poll) {
                // Remove student polls using poll table 'type'
                return $poll->type != 'student';
            });
        }


        return view('welcome', [
            'polls' => $all_posts,
        ]);
    }
}
