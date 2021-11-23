<x-app-layout>

  <div class="flex flex-col">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <livewire:users-table :group='$group'>
    </div>
  </div>

  <h1>Group name: {{ $group->name }}</h1>
  <h2>Group admin: {{ $group->admin->name }}</h2>
  <h3>Members: </h3>

  <ul>

    @foreach($group->members as $member)
    <li>
      {{$member->name}}
    </li>
    <li>
      {{$member->id}}
    </li>

    @endforeach
  </ul>




</x-app-layout>