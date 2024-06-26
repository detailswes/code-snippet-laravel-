<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id;
    public $direction;
    public $show_header;
    public $centerClass;

    public function __construct($id, $direction = null, $showHeader = true, $centerClass = null)
    {
        $this->id = $id;
        $this->direction = $direction;
        $this->show_header = $showHeader;
        $this->centerClass = $centerClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
