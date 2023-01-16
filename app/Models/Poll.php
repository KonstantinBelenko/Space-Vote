<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import models
use App\Models\Vote;
use App\Models\Answer;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'is_open',
        'user_id',
    ];

    public function hasVoted(?\Illuminate\Contracts\Auth\Authenticatable $user)
    {
        if ($user === null) {
            return false;
        }

        return Vote::where('user_id', $user->id)->where('poll_id', $this->id)->exists();
    }

    public function userVote(?\Illuminate\Contracts\Auth\Authenticatable $user)
    {
        if ($user === null) {
            return null;
        }

        return Vote::where('user_id', $user->id)->where('poll_id', $this->id)->first();
    }

    public function userAnswer(?\Illuminate\Contracts\Auth\Authenticatable $user)
    {
        if ($user === null) {
            return null;
        }

        // If user voted
        if ($this->hasVoted($user)) {
            // Get the vote
            $vote = $this->userVote($user);

            // Get the answer
            $answer = Answer::find($vote->vote);

            // Return the answer
            return $answer;
        }

    }

    // Get n poll votes
    public function nVoted()
    {
        return Vote::where('poll_id', $this->id)->count();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function createVote(?\Illuminate\Contracts\Auth\Authenticatable $user, mixed $vote, mixed $anonymous, int $poll_id)
    {
        if ($user === null) {
            return false;
        }

        Vote::create([
            'user_id' => $user->id,
            'poll_id' => $poll_id,
            'vote' => $vote,
            'anonymous' => $anonymous,
        ]);

        return true;
    }
}
