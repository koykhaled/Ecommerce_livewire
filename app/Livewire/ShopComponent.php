<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;


class ShopComponent extends Component
{
    use WithPagination;
    public $sorting;
    public $pagesize;
    public function mount()
    {
        $this->sorting = "default";
        $this->pagesize = 12;
    }
    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item added to cart.');
        return redirect()->route('cart');
    }

    public function render()
    {

        $categories = Category::all();
        switch ($this->sorting) {
            case 'date':
                $products = Product::orderBy('created_at', 'DESC')->paginate($this->pagesize);
                break;
            case 'price':
                $products = Product::orderBy('reqular_price', 'ASC')->paginate($this->pagesize);
                break;
            case 'price-desc':
                $products = Product::orderBy('reqular_price', 'DESC')->paginate($this->pagesize);
                break;
            default:
                $products = Product::paginate($this->pagesize);
        }
        return view('livewire.shop-component', compact('products', 'categories'))->layout('layouts.base');
    }
}