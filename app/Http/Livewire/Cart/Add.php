<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use App\Models\Reference;
use Illuminate\Support\Str;
use App\Services\Cart\CartManager;

class Add extends Component
{
    public $reference;

    public function mount(Reference $reference)
    {
        $this->reference = $reference;
    }

    public function addToCart(CartManager $cartManager)
    {
        $cartManager->add($this->reference);

        // session()->flash('type', 'success');
        // session()->flash('message', 'Product successfully added to cart.');
        $this->emit('flashMessage', [
            'type' => 'success',
            'message' => 'Product successfully added to cart.',
            'id' => Str::random(6)
        ]);

        // return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.cart.add');
    }
}
