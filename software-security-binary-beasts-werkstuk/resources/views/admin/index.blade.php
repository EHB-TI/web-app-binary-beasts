<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Admin') }}
    </h2>
  </x-slot>



  @if(Auth::user()->roles()->where("role_name", "ADMIN")->count() == 1)
  <!-- Only admins can see this part -->
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th colspan=5 scope="col"
                  class="px-6 py-3 text-center text-xl font-medium text-gray-500 uppercase tracking-wider">
                  Assign roles
                </th>
              </tr>
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Name
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Email
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Admin
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Teacher</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Student</th>
              </tr>
            </thead>
            @foreach($users as $user)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                  {{ $user->name }}

                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                  {{ $user->email }}

                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @if($user->id != 1)
                @if($user->roles()->where("role_name", "ADMIN")->count() == 1)
                <form method="POST" action="{{route('admin.removeAdmin')}}">
                  @csrf
                  <input type="hidden" name="memberId" value="{{ $user->id }}">

                  <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                      Remove
                    </x-jet-button>

                  </div>
                </form>
                @else
                <form method="POST" action="{{route('admin.addAdmin')}}">
                  @csrf
                  <input type="hidden" name="memberId" value="{{ $user->id }}">

                  <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                      Add
                    </x-jet-button>

                  </div>
                </form>
                @endif
                @else
                <div class="flex items-center justify-center mt-4">
                  <x-jet-danger-button disabled class="ml-4">
                    Locked
                  </x-jet-danger-button>

                </div>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @if($user->roles()->where("role_name", "TEACHER")->count() == 1)
                <form method="POST" action="{{route('admin.removeTeacher')}}">
                  @csrf
                  <input type="hidden" name="memberId" value="{{ $user->id }}">

                  <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                      Remove
                    </x-jet-button>

                  </div>
                </form>
                @else
                <form method="POST" action="{{route('admin.addTeacher')}}">
                  @csrf
                  <input type="hidden" name="memberId" value="{{ $user->id }}">

                  <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                      Add
                    </x-jet-button>

                  </div>
                </form>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @if($user->roles()->where("role_name", "STUDENT")->count() == 1)
                <form method="POST" action="{{route('admin.removeStudent')}}">
                  @csrf
                  <input type="hidden" name="memberId" value="{{ $user->id }}">

                  <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                      Remove
                    </x-jet-button>

                  </div>
                </form>
                @else
                <form method="POST" action="{{route('admin.addStudent')}}">
                  @csrf
                  <input type="hidden" name="memberId" value="{{ $user->id }}">

                  <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                      Add
                    </x-jet-button>

                  </div>
                </form>
                @endif
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
</x-app-layout>