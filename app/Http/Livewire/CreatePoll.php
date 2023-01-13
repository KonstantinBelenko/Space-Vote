<?php

namespace App\Http\Livewire;

use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{

    public $title = '';
    public $description = '';
    public $type = 'public';
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
        ]);

        // Create the poll
        $poll = Poll::create([
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'is_open' => true,
            'user_id' => auth()->user()->id,
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
        return redirect()->route('polls.show', $poll->id);
    }

    public function render()
    {
        return view('livewire.create-poll');
    }
}
