<?php

namespace Sunhill\Framework\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class OptionalLink extends Component
{
    public function __construct(
        public \StdClass $entry)
    {
        
    }
    
    public function render(): View
    {
        return view('framework::components.optional_link',['entry'=>$this->entry]);
    }
}