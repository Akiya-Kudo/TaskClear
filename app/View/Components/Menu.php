<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Menu extends Component
{
    // $type
    public $type;

    // $items
    public $items;
    /**
     * Menubar
     *
     * @return void
     */
    public function __construct($type, $items)
    {
        $this->type = $type;
        $this->items = $items;
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
