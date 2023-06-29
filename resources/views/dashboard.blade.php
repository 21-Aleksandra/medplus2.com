<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel='stylesheet' href="{{asset('/css/main.css')}}" >
    <title>{{__('start.start') }}</title>
</head>

<body>
<section class="centered-content">
@include('layouts.navbar')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                
                <div class="banner">
                <div class="special-message">
                </div>
                <div class="title">
                <h1>{{__('start.welcome') }}</h1>
                </div>
                </div>

                <div class="container">
    <div class="row">
        <h1 class="subs">{{__('start.oursub') }}</h1>
        @foreach ($subsidiaries as $subsidiary)
            <div class="subsidary-card">
                <img src="{{ asset('images/hospital.png') }}" class="subsidary-img" alt="Hospital Image">
                <h3 class="subsidary-name">{{ $subsidiary->naming }}</h3>
                <p class="subsidary-address">{{ $subsidiary->address->city }}, {{ $subsidiary->address->street }}</p>
                <p class="subsidary-email">{{ $subsidiary->email }}</p>
            </div>
        @endforeach
    </div>
</div>
                 

                 
                    
                </div>
            </div>
        </div>
    </div>
    </section>
</body>
</html>