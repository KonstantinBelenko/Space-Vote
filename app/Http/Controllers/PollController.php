<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('polls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // Validate the request
        $request->validate([
            'title' => 'required|max:42',
            'description' => 'required|max:255',
            'type' => 'required',
        ]);

        // Create the poll
        $poll = Poll::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'is_open' => true,
            'user_id' => auth()->user()->id,
        ]);

        // Save poll
        $poll->save();

        // Redirect to the poll page by poll id
        return redirect()->route('polls.show', $poll->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $poll_uuid)
    {

        // Check if poll exists
        if (Poll::where('uuid', $poll_uuid)->exists()) {
            // Get poll
            $poll = Poll::where('uuid', $poll_uuid)->first();

            // Return view with poll
            return view('polls.show', compact('poll'));
        } else {
            // Return 404
            abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    // Vote function
    public function vote(Request $request, string $poll_uuid)
    {

        // Check if poll exists
        if (!Poll::where('uuid', $poll_uuid)->exists()) {
            // Return 404
            abort(404);
        }

        // Get poll
        $poll = Poll::where('uuid', $poll_uuid)->first();

        // Validate the request
        $request->validate([
            'vote' => 'required',
        ]);

        // Check if poll is open
        if ($poll->is_open) {

            // Check if user has voted
            if (!$poll->hasVoted(auth()->user())) {
                $poll->createVote(auth()->user(), $request->vote, $request->anonymous, $poll->id);
            }
        }

        // Redirect to poll page
        return redirect()->route('polls.show', $poll->uuid);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $uuid)
    {

        // Check if poll exists
        if (!Poll::where('uuid', $uuid)->exists()) {
            // Return 404
            abort(404);
        }

        // Get poll
        $poll = Poll::where('uuid', $uuid)->first();

        // Delete poll
        Poll::destroy($poll->id);

        // Redirect to home
        return redirect()->route('home');
    }

    public function stop(string $uuid)
    {
        // Check if poll exists
        if (!Poll::where('uuid', $uuid)->exists()) {
            // Return 404
            abort(404);
        }

        // Change is_open to false
        Poll::where('uuid', $uuid)->update(['is_open' => false]);

        // Redirect to poll
        return redirect()->route('polls.show', $uuid);
    }
}
