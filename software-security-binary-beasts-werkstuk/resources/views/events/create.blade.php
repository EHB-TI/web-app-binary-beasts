<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('MyEvents') }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-2xl justify-center sm:px-6 lg:px-8">
      <div class="flex flex-col">
        <div class="py-2 min-w-full sm:px-3 lg:px-4" style="margin-left: 175px">
          <x-jet-validation-errors class="mb-4" />
          <form method="POST" action="{{ url('events/create') }}">
            {{ csrf_field() }}
            <div>
              <x-jet-label for="eventName" value="{{ __('EventName') }}" />
              <x-jet-input id="eventName" class="block mt-1 w-full" type="text" name="eventName"
                :value="old('eventName')" required autofocus autocomplete="eventName" />
            </div>

            <div class="mt-4">
              <x-jet-label for="eventDescription" value="{{ __('Event Description') }}" />
              <x-jet-input id="eventDescription" class="block mt-1 w-full" type="text" name="eventDescription"
                :value="old('eventDescription')" required autofocus autocomplete="eventDescription" />

            </div>

            <div class="mt-4">
              <x-jet-label for="eventDate" value="{{ __('Date') }}" />
              <input id="eventDate" type="text" name="eventDate"
                class="form-control datepicker border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            </div>

            <div class="mt-4">
              <x-jet-label for="eventTime" value="{{ __('Time') }}" />
              <input id="eventTime" type="text" name="eventTime"
                class="form-control timepicker border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            </div>
            @if($groups->count() > 0)
            <div class="mt-4">
              <x-jet-label for="eventGroup" value="{{ __('Group') }}" />
              <select id="eventGroup" name="eventGroup" name="eventGroup"
                class=" form-control custom-select border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                style="width: 210px;height: 45px">
                <option value="">Public</option>
                @foreach($groups as $group)
                <option class="form-control" value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
              </select>

              @endif

            </div>
            <div class="flex items-center justify-center mt-4">
              <x-jet-button class="ml-4">
                {{ __('Create Event') }}
              </x-jet-button>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>
</x-app-layout>