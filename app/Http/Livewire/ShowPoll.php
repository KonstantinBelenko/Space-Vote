<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Vote;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ShowPoll extends Component
{
    public $poll;
    public $hasVoted;
    public $userVote;
    public $currentHref;

    // initialisation
    public function mount($poll)
    {
        $this->poll = $poll;

        // Check if user has already voted using cookies
        $this->hasVoted = Cookie::get('poll_' . $this->poll->uuid) !== null;

        // Get the user's vote from cookie
        if ($this->hasVoted) {
            $this->userVote = Cookie::get('poll_' . $this->poll->uuid);
        }

        // Get the current URL
        $this->currentHref = url()->current();
    }

    public function vote(int $answer_id)
    {
        // Check if user has already voted
        if ($this->hasVoted) {
            return;
        }

        // Set the cookie
        Cookie::queue('poll_' . $this->poll->uuid, $answer_id, 60 * 24 * 30);

        // Set the user's vote
        $this->userVote = $answer_id;

        // Set hasVoted to true
        $this->hasVoted = true;

        // Validate the answer
        $answer = Answer::find($answer_id);

        // If answer is valid
        if ($answer !== null) {

            // Create new vote with random negative id
            Vote::create([
                'user_id' => null,
                'vote' => $answer_id,
                'poll_id' => $this->poll->id,
            ])->save();
        }

        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.show-poll');
    }
}
