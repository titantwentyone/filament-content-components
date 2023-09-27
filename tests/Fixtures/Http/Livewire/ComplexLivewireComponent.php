<?php

namespace Tests\Fixtures\Http\Livewire;

use Livewire\Component;

class ComplexLivewireComponent extends Component
{
    public function mount($message, $happy)
    {
        $this->message = $message;
        $this->happy = $happy;
    }

    public function render()
    {
        return view('livewire.complex-livewire-component');
    }
}