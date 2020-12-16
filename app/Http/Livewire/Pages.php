<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class Pages extends Component
{
    public $modalFormVisible = false ; //ni kena check balik apa dia cakap . tapi kena buat 
    public $slug;
    public $titile;
    public $content;  
    
    /**
     * show the form modal 
     * of the create function.
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->modalFormVisible = true; 
    }
    
    /**
     * the livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages');
    }
}
