<nav id="main-menu" class="section">
<ul class="parent-menu" >
<li class="hop"><a href="{{ url('/dashboard') }}"><img class="health" src="/images/healthcare.png"></a></li>
    <li><a href="{{ url('/doctors') }}">{{__('start.doctors') }}</a></li>
    

    @canany([ 'is_user', 'is_manager'])
        <li><a href="{{ url('/appointments')}}">{{__('start.appointments') }}</a></li>
    @endcanany

    @can('is_user')
    <li> <a href="{{ route('appointments.create') }}" class="btn btn-primary">{{__('start.rezerv') }}</a> <li>
@endcan
    @can('is_admin')
        <li><a href="{{  url('/comments')}}">{{__('start.comments') }}</a></li>
        <li><a href="{{  url('/users')}}">{{__('start.users') }}</a></li>
    @endcan
    <li class="sub-menu-caption">{{__('start.lang') }}
    <ul class="sub-menu">

    <li class="drop "><a href="{{ url('lang/en') }}">EN</a></li>
    <li class="drop"><a href="{{ url('lang/lv') }}">LV</a></li>
    </ul>
    </li>


    <li class="sub-menu-caption cool-drop" >{{ Auth::user()->name }}
    <ul class="sub-menu lol" >

    <li> 
    <x-responsive-nav-link :href="route('profile.edit')">
    {{__('start.profile') }}
                </x-responsive-nav-link>


    </li>
    <li>
    <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                      {{__('start.logout') }}
                    </x-responsive-nav-link>
                </form>
    </li>
    </ul>
    </li>
</ul>
</nav>