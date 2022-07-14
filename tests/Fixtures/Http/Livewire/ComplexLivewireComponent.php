<?php

namespace Tests\Fixtures\Http\Livewire;

use Livewire\Component;

class ComplexLivewireComponent extends Component
{
    public function mount($data, $happy)
    {
        $this->data = $data;
        $this->happy = $happy;
    }

    public function render()
    {
        return view('livewire.complex-livewire-component');
    }
}