<!DOCTYPE html>
<html >

<head>
    <meta charset="UTF-8">
    <link rel='stylesheet' href="{{asset('/css/main.css')}}" >
    <title>Home</title>
</head>
<body>
<section class="centered-content">   
@include('layouts.navbarguest')
   
<div class="banner">
                <div class="special-message">
                </div>
                <div class="title">
                <h1>{{__('start.welcome') }}</h1>
              <a class='mylink' href="{{ url('/doctors') }}">{{__('start.doctors') }}</a>
                </div>
                </div>

</section>                   
</body>
</html>
