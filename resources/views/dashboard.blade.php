<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
 
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <h1>{{__('start.welcome') }}</h1>
                    <br>

                    <a href="{{ url('/doctors') }}">{{__('start.doctors') }}</a><br>

                    @canany([ 'is_user', 'is_manager'])
                    <a href="{{ url('/appointments')}}">{{__('start.appointments') }}</a>
                    @endcanany

                    @can('is_admin')
                    <a href="{{  url('/comments')}}">{{__('start.comments') }}</a><br>
                    <a href="{{  url('/users')}}">{{__('start.users') }}</a><br>
                    @endcan
                    <br>
                    <a href="{{ url('lang/en') }}">EN</a><br>
                    <a href="{{ url('lang/lv') }}">LV</a>

                 
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
