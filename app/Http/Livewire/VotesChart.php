<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VotesChart extends Component
{
    public $poll;
    public $answers;

    public function mount($poll)
    {
        $this->poll = $poll;
        $this->answers = $poll->answers;

        $this->dispatchBrowserEvent('contentChanged', ['answers' => $this->answers]);
    }
    public function render()
    {
        return view('livewire.votes-chart');
    }
}
