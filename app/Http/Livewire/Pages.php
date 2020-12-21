<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Pages extends Component
{
    public $modalFormVisible =true; //ni kena check balik apa dia cakap . tapi kena buat 
    public $slug;
    public $title;
    public $context;  

    
    /**
     * the validation rules
     * 
     *
     * @return void
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required',Rule::unique('pages', 'slug')],
            'context' => 'required',
        ];
    }
    
    /**
     * updatedTitle everytime he update it
     * turn into slug
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedTitle($value)
    {

        $this->generateSlug($value);

    }
        
    /**
     * This for create into the database pages
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        Page::create($this->modelData()); 
        $this->modalFormVisible =false; //hide model punya 
        $this->cleanVars();
    }

    

    /** control shift i
     * show the form modal 
     * of the create function.
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->modalFormVisible = true; 
    }
    
    //seperate the asignemnet of data in another fx for cleaner look    
    /**
     * The data for the model mapped 
     * in this component.
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'title'=> $this->title,
            'slug' => $this->slug,
            'context' => $this->context
        ];
    }

    
    /**
     * Reset var to null balik
     *
     * @return void
     */
    public function cleanVars()
    {
        $this->title =null;
        $this->slug=null;
        $this->context= null;
    }
    
    /**
     * generateSlug a url sliug based on the title
     *
     * @param  mixed $value
     * @return void
     */
    private function generateSlug($value)
    {
        $process1 = str_replace(' ','-',$value);
        $process2 = strtolower($process1);
        $this->slug = $process2;
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
