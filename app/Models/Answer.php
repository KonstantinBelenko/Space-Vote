<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'poll_id',
    ];

    protected $appends = [
        'votes',
    ];

    public function nVoted()
    {
        return Vote::where('vote', $this->id)->count();
    }

    public function getVotesAttribute()
    {
        return $this->nVoted();
    }
}
