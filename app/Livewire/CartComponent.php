<?php

namespace App\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartComponent extends Component
{
    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }

    public function increaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $quantity = $product->qty + 1;
        Cart::update($rowId, $quantity);
    }

    public function decreaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $quantity = $product->qty - 1;
        Cart::update($rowId, $quantity);
    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);
        session()->flash('success_message', 'Item has been removed');
    }

    public function destroyAll()
    {
        Cart::destroy();
        session()->flash('success_message', 'All items have been removed');
    }
}