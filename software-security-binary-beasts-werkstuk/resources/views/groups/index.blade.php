<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Groups') }}
    </h2>
  </x-slot>



  @if(Auth::user()->roles()->where("role_name", "TEACHER")->count() == 1)
  <!-- Only teachers can see this part -->
  <div class="py-6">
    <div class="max-w-2xl mx-auto justify-center sm:px-6 lg:px-8">
      <div class="flex flex-col">
        <div class="py-2 min-w-full sm:px-3 lg:px-4">
          <x-jet-validation-errors class="mb-4" />
          <form method="POST" action="{{ route('groups.create' )}}">
            @csrf
            <div>
              <x-jet-label for="name" class="text-center" value="Group name" />
              <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            </div>
            <div class="flex items-center justify-center mt-4">
              <x-jet-button class="ml-4">
                {{ __('Create Group') }}
              </x-jet-button>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>



  @endif




  @if($admingroups->count() > 0)
  <div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th colspan=2 scope="col"
                  class="px-6 py-3 text-center text-xl font-medium text-gray-500 uppercase tracking-wider">
                  Groups where we are admin

                </th>
              </tr>
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Title
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date
                </th>
              </tr>
            </thead>
            @foreach($admingroups as $group)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                  <a href="{{url('groups/') . '/' . $group->id}}">
                    {{ $group->name }}

                  </a>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ $group->date }}</div>
              </td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endif



  @if($membergroups->count() > 0)
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" colspan=2
                    class="px-6 py-3 text-center text-xl font-medium text-gray-500 uppercase tracking-wider">
                    Groups where we are member
                  </th>
                </tr>
                <tr>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Title
                  </th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Date
                  </th>
                </tr>
              </thead>
              <br>
              @foreach($membergroups as $group)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    <a href="{{url('groups/') . '/' . $group->id}}">
                      {{ $group->name }}

                    </a>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ $group->date }}</div>
                </td>
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
  @endif
</x-app-layout>




@foreach($membergroups as $group)
@if($group->events()->count() > 0)

<div class="py-12">

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th colspan=2 scope="col"
                class="px-6 py-3 text-center text-xl font-medium text-gray-500 uppercase tracking-wider">
                EVENTS for group {{ $group->name }}

              </th>
            </tr>
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Title
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Date
              </th>
            </tr>
          </thead>
          @foreach($group->events as $event)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                <a href="{{url('events/') . '/' . $event->id}}">
                  {{ $event->eventname }}

                </a>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ $event->eventdate }} - {{ $event->eventtime}}</div>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif
@endforeach