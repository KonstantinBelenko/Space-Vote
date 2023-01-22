<?php

namespace App\Http\Livewire;

use App\Models\Poll;
use Livewire\Component;
use Illuminate\Support\Str;

class CreatePoll extends Component
{

    public $title = '';
    public $description = '';
    public $type = 'anarchy';
    public $is_public = 'public';
    public $answers = [
        [
            'text' => 'Yes',
        ],
        [
            'text' => 'No',
        ],
    ];

    public function removeAnswer($id)
    {
        // Check if there are more than 2 answers
        if (count($this->answers) > 2) {
            unset($this->answers[$id]);
        }

    }

    public function addAnswer()
    {
        // Check if there are more than 10 answers
        if (count($this->answers) >= 10) {
            return;
        }

        // Add answer to array
        $this->answers[] = [
            'text' => '',
        ];
    }

    public function createPoll()
    {
        // Validate the request
        $this->validate([
            'title' => 'required|max:42',
            'description' => 'required|max:255',
            'type' => 'required',
            'answers.*.text' => 'required|max:255',
            'is_public' => 'required',
        ]);

        if ($this->is_public === 'public') {
            $is_public = true;
        } else {
            $is_public = false;
        }

        // Create the poll
        $poll = Poll::create([
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'is_open' => true,
            'user_id' => auth()->user()->id,
            'uuid' => Str::uuid(),
            'is_public' => $is_public,
        ]);

        // Save poll
        $poll->save();

        // Create answers
        foreach ($this->answers as $answer) {
            $poll->answers()->create([
                'poll_id' => $poll->id,
                'text' => $answer['text'],
            ]);

            // save
            $poll->save();
        }

        // Redirect to the poll page by poll id
        return redirect()->route('polls.show', $poll->uuid);
    }

    public function render()
    {
        return view('livewire.create-poll');
    }
}
