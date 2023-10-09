<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;


class CategoryComponent extends Component
{
    use WithPagination;
    public $sorting;
    public $pagesize;
    public $categorySlug;
    public function mount($categorySlug)
    {
        $this->sorting = "default";
        $this->pagesize = 12;
        $this->categorySlug = $categorySlug;
    }
    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item added to cart.');
        return redirect()->route('cart');
    }

    public function render()
    {

        $category = Category::where('slug', $this->categorySlug)->first();
        $categories = Category::all();
        switch ($this->sorting) {
            case 'date':
                $products = Product::where('category_id', $category->id)->orderBy('created_at', 'DESC')->paginate($this->pagesize);
                break;
            case 'price':
                $products = Product::where('category_id', $category->id)->orderBy('reqular_price', 'ASC')->paginate($this->pagesize);
                break;
            case 'price-desc':
                $products = Product::where('category_id', $category->id)->orderBy('reqular_price', 'DESC')->paginate($this->pagesize);
                break;
            default:
                $products = Product::where('category_id', $category->id)->paginate($this->pagesize);
        }
        return view('livewire.category-component', compact('products', 'categories', 'category'))->layout('layouts.base');
    }
}