<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class Search extends Component
{
    public $searchQuery;

    protected $queryString = [
        'searchQuery' => ['as' => 'q'],
    ];

    public function render()
    {
        return view('livewire.component.search');
    }
}
