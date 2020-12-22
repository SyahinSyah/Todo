<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;

class FrontPage extends Component
{
    public $urlslug;
    public $title;
    public $context;

    public function mount($urlslug)
    {
        $this->retriveContent($urlslug) ;

    }
    
    /**Retrive all the content of the page;
     * retriveContent
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function retriveContent($urlslug)
    {
        $data = Page::where('slug' ,$urlslug)->first();
        $this->title = $data->title;
        $this->context = $data->context;

    }
    public function render()
    {
        return view('livewire.front-page')-> layout('layouts.frontpage');
    }
}
