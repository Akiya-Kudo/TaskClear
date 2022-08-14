<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Menu extends Component
{
    // $type
    // public $type;

    // $goals
    public $goals;
    /**
     * Menubar
     *
     * @return void
     */
    public function __construct($goals)
    {
        $this->goals = $goals;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu');
    }
}
