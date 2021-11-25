<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('MyEvents') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex flex-col">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8" style="margin-left: 175px">
          <a class="btn" href="{{route('events.create')}}"
            style="background: #313131; color: #ffffff; padding: 10px; width: 20%; text-align: center; display: block; border-radius:3px;">
            New Event
          </a>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Host
                    </th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Event
                    </th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Date
                    </th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Attendees
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Accept</span>
                    </th>
                  </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                  <!-- More people... -->
                  @foreach($events as $event)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          <img class="h-10 w-10 rounded-full"
                            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                            alt="">
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            {{ $event->host()->get()->first()->name }}
                          </div>
                          <div class="text-sm text-gray-500">
                            {{ $event->host()->get()->first()->email }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <a href="{{ route('events.show', ['event' => $event->id]) }}">
                        <div class="text-sm text-gray-900">{{ $event->eventname }}</div>
                        <div class="text-sm text-gray-500">{{ $event->eventdescription }}</div>
                      </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{ $event->eventdate }}
                        {{ $event->eventtime }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ $event->attendees()->count() }}
                    </td>
                    @if($event->attendees->contains(Auth::user()))
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <form method="POST" action="{{ url('events/reject') }}">
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        {!! csrf_field() !!}
                        <x-jet-button class="ml-4">
                          Stop attending
                        </x-jet-button>
                      </form>
                    </td>
                    @else
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <form method="POST" action="{{ url('events/accept') }}">
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        {!! csrf_field() !!}
                        <x-jet-button class="ml-4">
                          Attend
                        </x-jet-button>
                      </form>
                    </td>
                    @endif
                  </tr>

                  @endforeach









                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>



    </div>
  </div>
</x-app-layout>