<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use RakibDevs\Weather\Weather;

class HomeController extends Controller
{
    public function __invoke()
    {
        $wt = new Weather();
        $weather = $wt->getGeoByCity('Barcelona');

        /* Send welcome view with all polls that are open (paginated), desc order */

        $all_posts = Poll::where('is_open', true)->orderBy('created_at', 'desc')->paginate(10);
        $authed = auth()->check();

        // Remove admin polls if user is not admin or owner
        if ($authed && !auth()->user()->is_admin && !auth()->user()->is_owner) {
            $all_posts = $all_posts->filter(function ($poll) {
                // Remove admin polls using poll table 'type'
                return $poll->type != 'admin';
            });
        }

        // Remove student polls if user is not student
        if ($authed && !auth()->user()->is_approved) {
            $all_posts = $all_posts->filter(function ($poll) {
                // Remove student polls using poll table 'type'
                return $poll->type != 'student';
            });
        }

        // Remove private polls
        $all_posts = $all_posts->filter(function ($poll) {
            // Remove private polls using poll table 'type'
            return $poll->type != 'private';
        });
        $all_posts = $all_posts->filter(function ($poll) {
            // Remove private polls using poll table 'is_public'
            return $poll->is_public != false;
        });


        return view('welcome', [
            'polls' => $all_posts,
//            'weather' => $weather,
        ]);
    }
}
