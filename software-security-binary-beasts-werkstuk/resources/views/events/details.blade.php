<x-app-layout>

  <div class="flex flex-col">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      @if($event)
      <h1>
        Name: {{ $event->eventname }}
      </h1>
      <h2>
        Description: {{ $event->eventdescription }}
      </h2>
      <h2>
        Date: {{ $event->eventdate }}
      </h2>
      <h2>
        Time: {{ $event->eventtime }}
      </h2>

      <ul>
        @foreach($event->groups as $group)
        <li>Belongs to group: {{$group->name}}</li>
        @endforeach

      </ul>
      {{$event->attendees()->count()}}
      @if($canSeeAttendees)
      <h1>People that will be attending:</h1>
      <ul>
        @foreach($event->attendees as $attendee)
        <li>{{$attendee->name}}</li>
        @endforeach
      </ul>
      @endif
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
        <br>
            @if(auth()->user()->id == $event->host_id)
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <form method="POST" action="{{ url('events/delete') }}">
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <input type="hidden" name="host_id" value="{{$event->host_id }}">
                    {!! csrf_field() !!}
                    <x-jet-button class="ml-4">
                        Delete
                    </x-jet-button>
                </form>
            </td>
            @endif
    </div>
  </div>
  @endif





</x-app-layout>
