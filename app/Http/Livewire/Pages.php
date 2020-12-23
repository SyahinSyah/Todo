<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;
    public $modalFormVisible =true; //ni kena check balik apa dia cakap . tapi kena buat 
    public $slug;
    public $title;
    public $context;  
    public $modelId;
    public $modalConfirmDelete =false;
    public $isSetToBeDefaultHomePage;
    public $isSetToBeDefaultNotFoundPage;

    
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
            'slug' => ['required',Rule::unique('pages', 'slug') -> ignore($this->modelId)],
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
    
    public function delete()
    {
        Page::destroy($this->modelId);
        $this->modalConfirmDelete = false;
        $this->resetPage();
    }
    
    /**function ni show delete confirmation
     * deleteShowModal
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modalId = $id;
        $this->modalConfirmDelete = true;

    }


    /**
     * the livewire mount function
     *
     * @return void
     */
    public function mount()
    {
        //reset the pagination after reloading the page
        $this->resetPage();
    }



    public function update()
    {
       // dd("Updating . . ");
       $this->validate();
       Page::find($this->modelId)->update($this->modelData());
       $this->modalFormVisible =false;
    }

    /** control shift i
     * show the form modal 
     * of the create function.
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->cleanVars();
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
            'context' => $this->context,
            'is_default_home' => $this->isSetToBeDefaultHomePage,
            'is_default_not_found' => $this->isSetToBeDefaultNotFoundPage, 
        ];
    }

    

    public function updatedIsSetToDefaultHomePage()
    {
        $this->isSetToBeDefaultNotFoundPage =null;
    }

    public function updatedIsSetDefaultNotFoundPage()
    {
        $this->isSetToBeDefaultHomePage =null;
    }
    




    /**
     * Reset var to null balik
     *
     * @return void
     */
    public function cleanVars()
    {
        $this->modelId=null;
        $this->title =null;
        $this->slug=null;
        $this->context= null;
        $this->isSetToBeDefaultNotFoundPage =null;
        $this->isSetToBeDefaultHomePage=null;
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
     * read
     *
     * @return void
     */
    public function read()
    {
        return Page::paginate(5);
    }
    
    /**shows the form modal
     * updateShowModal
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->cleanVars();
        $this-> modelId =$id;
        $this->modalFormVisible =true;
        $this->loadModal();
    }
    
    /**load the model data of this component
     * loadModal
     *
     * @return void
     */
    public function loadModal()
    {
        $data = Page::find($this->modelId);
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->context = $data->context;
        $this->isSetToBeDefaultHomePage= !$data->is_default_home? null:true ;
        $this->isSetToBeDefaultNotFoundPage =null;
       

    }

    /**
     * the livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages',[
            'data' => $this->read()

        ]);
    }
}
