<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Journal extends Component
{
    public function __construct(
        public object $journal,
    ) {}
    public function render(): View
    {
        return view('components.journal');
    }
}
