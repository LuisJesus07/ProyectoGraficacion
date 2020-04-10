<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Mapa</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- MapBox -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.css" rel="stylesheet" />
    <style>
        @import url("https://fonts.googleapis.com/css?family=Akronim");

        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 1; bottom: 1; width: 100%; height: 100vh }

        .marker {
          background-image: url({{ asset('iconos/mapbox-icon.png') }});
          background-size: cover;
          width: 50px;
          height: 50px;
          border-radius: 50%;
          cursor: pointer;
           z-index: 200;
        }

        .cines {
          background-image: url({{ asset('iconos/cines.png') }});
          background-size: cover;
          width: 50px;
          height: 50px;
          cursor: pointer;
           z-index: 200;
        }

        .restaurantes {
          background-image: url({{ asset('iconos/restaurantes.png') }});
          background-size: cover;
          width: 40px;
          height: 50px;
          cursor: pointer;
           z-index: 200;  
        }


        .mapboxgl-popup {
          max-width: 200px;
        }

        .mapboxgl-popup-content {
          text-align: center;
          font-family: 'Open Sans', sans-serif;
        }

        .city-box {
            opacity: 0;
            visibility: hidden;             
            height: 28vh;
            width: 23%;
            position: absolute;
            bottom: 70%;
            left: 75%;
            background-color: rgba(255, 255, 255);
            -webkit-transition: opacity 2000ms, visibility 2000ms;
            transition: opacity 2000ms, visibility 2000ms;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
        }

        .city-box img {
            width: 100%;
            height: 17vh;
        }

        .city-box h2 {
            position: absolute;
            font-size: 2.9vw;
            color: black;
            top: 67%;
            left: 45%;
            font-family: Akronim;
        }

        .logo {
           margin-left: 25px;
           margin-top: -45px
        }

        .logo img{
          border-radius: 50%;
          box-shadow: 2px 5px 5px rgba(0, 0, 0, 0.3);
          width: 90px;
          height: 15vh;
        }
             
        p {
            font-family: 'Open Sans';
            margin: 0;
            font-size: 13px;
        }
    </style>

</head>
<body>


    <div id="app">
        
    </div>

    @yield('content')

 


@yield('scripts')

</body>
</html>