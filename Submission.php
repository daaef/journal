<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Submission extends Component
{
    public function __construct(
        public object $submission,
    ) {}
    public function render(): View
    {
        return view('components.submission');
    }
}
