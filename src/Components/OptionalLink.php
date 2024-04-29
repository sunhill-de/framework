<?php

namespace Sunhill\Framework\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class OptionalLink extends Component
{
    public $entry;
    
    public function __construct($entry)
    {
        if (is_a($entry, \StdClass::class)) {
            $this->entry = $entry;
            return;
        }
        
        $this->entry = new \StdClass();
        if (is_string($entry)) {
            $this->entry->title = $entry;
            return;
        }
        if (is_array($entry)) {
            if (isset($entry['link']) && (isset($entry['title']))) {
                $this->entry->link = $entry['link'];
                $this->entry->title = $entry['title'];
                return;
            }
            if (count($entry) == 1) {
                $this->entry->link = array_values($entry)[0];
                $this->entry->title = array_keys($entry)[0];
                return;
            }
        }
        throw new \Exception('Cant process data to a optional link');
    }
    
    public function render(): View
    {
        return view('framework::components.optional_link',['entry'=>$this->entry]);
    }
}