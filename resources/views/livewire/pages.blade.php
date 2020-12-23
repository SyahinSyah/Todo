<div class="p-6">
    <div class="flex items-center justify-end px-x py-3 text-right sm:px-6">
    <x-jet-button wire:click="createShowModal">
          {{ __('Create') }}
    </x-jet-button>
    </div>
   
    {{--the data table--}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercas tracking-wider">Title</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercas tracking-wider">Link</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercas tracking-wider">Content</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercas tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($data->count())
                                @foreach ($data as $item)
                                 <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                        {{$item->title}}
                                        {!! $item->is_default_home ? '<span class="text-green-400 text-xs font-bold">[Default Home Page]</span>':''!!}
                                        {!! $item->is_default_not_found ? '<span class="text-red-400 text-xs font-bold">[Default 404 Page]</span>':''!!}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                        <a class="text-indigo-600 hover:text-indigo-900" target="_blank" href="{{URL::to('/'.$item->slug)}}">
                                            {{$item->slug}}
                                        </a>

                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap">{!! $item->context !!}</td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <x-jet-button wire:click="updateShowModal({{$item->id}})">
                                            {{ __('Update') }}
                                      </x-jet-button>
                                      <x-jet-danger-button wire:click="deleteShowModal({{ $item->id }})">
                                        {{ __('Delete') }}
                                      </x-jet-danger-button>
                                    </td>
                                </tr>
                            @endforeach
                            @else                 
                                <tr>
                                    <td  class="px-6 py-4 text-right text-sm whitespace-no-wrap" colspan="4">No Result</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <br><br/>

    {{$data -> links()}}

    {{--modal form--}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
            <x-slot name="title">
                {{ __('Save Page') }} 
            </x-slot>
            <x-slot name="content">
                The form element goes here.
                <div class="mt-4">
                    <x-jet-label for="titile" value="{{ __('Title') }}" />
                    <x-jet-input id="title" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="title" />
                    @error('title')  <span class="error"> {{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for="titile" value="{{ __('Slug') }}" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-1-md border border-r-0 gray-300 bg-gray-50 text-gray-500 text-sm">
                            http://localhost:8000/
                        </span>
                        <input wire:model="slug" class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="url-slug">
                    </div>
                    @error('slug') <span class="error">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <label>
                    <input class="form-checkbox" type="checkbox" value="{{$isSetToBeDefaultHomePage}}" wire:model="isSetToBeDefaultHomePage"/>
                    <span class="ml-2 text-sm text-gray-600">Set as the default home page</span> 
                    </label>
                </div>
                <div class="mt-4">
                    <input class="form-checkbox" type="checkbox" value="{{$isSetToBeDefaultNotFoundPage}}" wire:model="isSetToBeDefaultNotFoundPage"/>
                    <span class="ml-2 text-sm text-red-600">Set as the default eror 404 page</span> 
                </div>
                <div class="mt-4">
                    <x-jet-label for="title" value="{{ __('Content') }}" />
                    <div class="rounded-md shadow-sm">
                        <div class="mt-1 bg-white">
                            <div class="body-content" wire:ignore>      {{--wire ignore tak update dekat trix--}}
                                    <trix-editor
                                    class="trix-content"
                                    x-ref="trix"
                                    wire:model.debounce.100000ms="context"
                                    wire:key="trix-context-unique-key">
                                    </trix-editor>
                            </div>
                        </div>
                    </div>
                    @error('context') <span class="error">{{$message}}</span>
                    @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

            @if ($modelId)
                  <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                     {{ __('Update') }}
                  </x-jet-danger-button>
            @else
                   <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                     {{ __('Save') }}
                  </x-jet-danger-button>
            @endif 
            </x-slot>
        </x-jet-dialog-modal>


          <!-- Delete User Confirmation Modal -->
          <x-jet-dialog-modal wire:model="modalConfirmDelete">
            <x-slot name="title">
                {{ __('Delete Page') }}
            </x-slot>

            
            <x-slot name="content">
                {{ __('Are you sure you want to delete your page? Once your page is deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalConfirmDelete')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete Page') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
</div>
