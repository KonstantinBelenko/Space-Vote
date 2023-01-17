<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;
use App\Models\Answer;
use App\Models\Vote;

class VoteAnarchical extends Component
{


    public function render()
    {
        return view('livewire.vote-anarchical');
    }
}
