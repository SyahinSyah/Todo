<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;

class FrontPage extends Component
{
    public $urlslug;
    public $title;
    public $context;

    public function mount($urlslug = null)
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
        //get home page if slug is empty
        if(empty($urlslug))
        {
            $data = Page::where('is_default_home',true)->first();
        }
        else
        {
            //get the page according to the slug value
            $data =Page::wher('slug',$urlslug)->first();

             // if wen reteriece anything , let get default not found page.
            if(!$data)
            {
                $data = Page::where('is_default_not_found', true)->first();
            }

        }
        
       


        $data = Page::where('slug' ,$urlslug)->first();
        $this->title = $data->title;
        $this->context = $data->context;

    }
    public function render()
    {
        return view('livewire.front-page')-> layout('layouts.frontpage');
    }
}
