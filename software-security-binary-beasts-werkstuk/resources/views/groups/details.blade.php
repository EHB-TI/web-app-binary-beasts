<x-app-layout>


  <h1>Group name: {{ $group->name }}</h1>
  <h2>Group admin: {{ $group->admin->name }}</h2>
  <h3>Members: </h3>

  <ul>

    @foreach($group->members as $member)
    <li>
      <p>{{$member->name}}</p>
    </li>
    @endforeach
  </ul>



</x-app-layout>