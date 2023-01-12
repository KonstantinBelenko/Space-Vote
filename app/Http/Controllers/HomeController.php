<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;

class HomeController extends Controller
{
    public function __invoke()
    {
        /* Send welcome view with all polls that are open (paginated), desc order */
        return view('welcome', [
            'polls' => Poll::where('is_open', true)->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
