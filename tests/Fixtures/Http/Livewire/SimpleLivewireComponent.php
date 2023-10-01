<?php

namespace Tests\Fixtures\Http\Livewire;

use Livewire\Component;

class SimpleLivewireComponent extends Component
{
    public string $message;
    public string $another_message = 'from livewire';

    public function mount(string $message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.simple-livewire-component');
    }
}