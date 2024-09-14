<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/6b0fd150ee.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css.css') }}">
    <title>Weathering Heights</title>
</head>
<body>
    @php
        $city = array("Ho Chi Minh","Hanoi","London","Tokyo","Frankfurt","Sydney","Melbourne",);
        sort($city);
        
    @endphp 
    <section>

        <video autoplay muted loop id="myVid">
            <source src="{{ asset('videos/'.$weatherData['weather'][0]['main'].'.mp4') }}" type="video/mp4">
            </video>
    </section>
    <div class="weather">

        <form action="{{ route('weather') }}" method="get">
            @csrf
            <select class="custom-select w-auto" name="city" id="" onchange="this.form.submit()">
            @foreach ($city as $item)
                <option value="{{ $item }}" @if ($item == $oldInput)
                    echo selected
                @endif><i class="fa-solid fa-font">{{ $item }}</i></option>
            @endforeach
            </select>
        </form>
        <h1>Current Weather in {{ $weatherData['name'] }}</h1>
        <p>Description: {{ $weatherData['weather'][0]['description'] }}</p>
        <p>Temperature: {{ $weatherData['main']['temp'] }} &#8451;</p>
        <p>Type: {{ $weatherData['weather'][0]['main'] }}</p>
    </div>
</body>
</html>