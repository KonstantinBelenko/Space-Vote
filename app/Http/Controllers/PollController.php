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
            'title' => 'required|max:32',
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
    public function show(int $id)
    {
        // Check if poll exists
        if (Poll::where('id', $id)->exists()) {
            // Get poll
            $poll = Poll::find($id);

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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete poll
        Poll::destroy($id);

        // Redirect to home
        return redirect()->route('home');
    }

    public function stop($id)
    {
        // Change is_open to false
        Poll::where('id', $id)->update(['is_open' => false]);

        // Redirect to poll
        return redirect()->route('polls.show', $id);
    }
}
