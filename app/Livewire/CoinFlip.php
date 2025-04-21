<?php

namespace App\Livewire;

use Livewire\Component;

class CoinFlip extends Component
{

    public string $coin = 'Click the flip button to flip a coin';

    public array $flips = [];

    public function render()
    {
        return view('livewire.coin-flip');
    }

    public function flip()
    {
        $this->flips[] = $this->coin;
        $this->coin = rand(0, 1) ? 'heads!' : 'tails!';
    }

    public function mount()
    {
        $this->flip();
    }

    public function placeholder()
    {
        return '<div>Looking for a coin.</div>';
    }
}
