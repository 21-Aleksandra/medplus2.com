<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <br>

                    <a href="{{ url('/doctors') }}">View Doctors</a><br>

                    @canany([ 'is_user', 'is_manager'])
                    <a href="{{ url('/appointments')}}">Appointments</a>
                    @endcanany

                    @can('is_admin')
                    <a href="{{  url('/comments')}}">View Comments</a><br>
                    <a href="{{  url('/users')}}">View Users</a><br>
                    @endcan

                 
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
