<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Firebase extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $authType;
    public function __construct($authType)
    {
        $this->authType = $authType;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.admin.firebase');
    }
}
