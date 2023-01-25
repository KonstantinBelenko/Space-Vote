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
        $weather = $wt->getCurrentByCity('Barcelona');
//     $weather = json_decode('{"coord":{"lon":71.5785,"lat":34.008},"weather":[{"id":721,"main":"Haze","description":"haze","icon":"50n"}],"base":"stations","main":{"temp":285.23,"feels_like":283.46,"temp_min":285.23,"temp_max":285.23,"pressure":1019,"humidity":37},"visibility":7000,"wind":{"speed":3.09,"deg":230},"clouds":{"all":1},"dt":1674658230,"sys":{"type":1,"id":7590,"country":"PK","sunrise":1674612922,"sunset":1674650164},"timezone":18000,"id":1168197,"name":"Peshawar","cod":200}');


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
            'weather' => $weather,
        ]);
    }
}
