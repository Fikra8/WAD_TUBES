<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public function render()
    {
        return view('layouts.app'); // Ensure this matches the view file path
    }
}   
    