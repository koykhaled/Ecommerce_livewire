<?php

namespace App\Livewire;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class DetailComponent extends Component
{
    public $slug;
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $product = Product::whereSlug($this->slug)->first();
        $popular_products = Product::inRandomOrder()->limit(4)->get();
        $related_prodcuts = Product::where('category_id', $product->category_id)->inRandomOrder()->limit(5)->get();
        return view('livewire.detail-component', compact('product', 'popular_products', 'related_prodcuts'))->layout('layouts.base');
    }

    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flush('success_message', 'Item added in Cart');
        return to_route('cart');
    }
}