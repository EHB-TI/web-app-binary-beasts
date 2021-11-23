<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Groups edit') }}
    </h2>
  </x-slot>




  <div class="py-6">
    <div class="max-w-2xl mx-auto justify-center sm:px-6 lg:px-8">
      <div class="flex flex-col">
        <div class="py-2 min-w-full sm:px-3 lg:px-4">
          <x-jet-validation-errors class="mb-4" />
          <form method="POST" action="{{ route('groups.postEdit', ['id' => $group->id])}}">
            @csrf
            <div>
              <x-jet-label for="name" class="text-center" value="Group name" />
              <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$group->name}}" required
                autofocus autocomplete="name" />
            </div>
            <div class="flex items-center justify-center mt-4">
              <x-jet-button class="ml-4">
                {{ __('Edit Group') }}
              </x-jet-button>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>




</x-app-layout>