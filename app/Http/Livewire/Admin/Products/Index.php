<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $searchTerm;
    public $sortField ='name';
    public $sortAsc = true;

    public function updatedSearchTerm($value)
    {
        $this->gotoPage(1);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        }else{
            $this->sortAsc = true;
        }

        $this->sortField = $field;

        $this->gotoPage(1);
    }

    public function render()
    {
        // dump($this);
        return view('livewire.admin.products.index', [
            'products' => Product::where('name', 'like' , "%$this->searchTerm%")
                ->with(['images', 'categories'])
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
            ,
        ]);
    }
}
