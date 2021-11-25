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
      <ul>
        @foreach($event->attendees as $attendee)
        <li>{{$attendee->name}}</li>
        @endforeach
      </ul>
      @endif
    </div>
  </div>
  @endif





</x-app-layout>