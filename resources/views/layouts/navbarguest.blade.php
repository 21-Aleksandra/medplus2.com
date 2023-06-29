<nav id="main-menu" class="section">
<ul class="parent-menu" >
<li class="astra ast"><a href="{{ url('/') }}"><img class="health" src="/images/healthcare.png"></a></li>
   
    <li class="sub-menu-caption">{{__('start.lang') }}
    <ul class="sub-menu">

    <li class="drop "><a href="{{ url('lang/en') }}">EN</a></li>
    <li class="drop"><a href="{{ url('lang/lv') }}">LV</a></li>
    </ul>
    </li>   


    @can('is_admin')
        <li><a href="{{  url('/comments')}}">{{__('start.comments') }}</a></li>
        <li><a href="{{  url('/users')}}">{{__('start.users') }}</a></li>
    @endcan
    @if (Route::has('login'))
    @auth
    <li class="sub-menu-caption"> 
    @canany(['is_admin', 'is_user', 'is_manager'])
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{__('start.start') }}</a>
     @endcanany
    </li>


@else
    <li class="sub-menu-caption">
    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{__('start.login') }}</a>
    </li>

    <li class="sub-menu-caption">
    @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{__('start.register') }}</a>
                        @endif
    </li>
   @endauth
   @endif


 
   

    
</ul>
</nav>



