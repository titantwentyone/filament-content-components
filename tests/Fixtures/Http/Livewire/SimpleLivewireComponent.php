<?php

namespace Tests\Fixtures\Http\Livewire;

use Livewire\Component;

class SimpleLivewireComponent extends Component
{
    public string $another_message = 'from livewire';

    public function mount(array $data)
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.simple-livewire-component');
    }
}