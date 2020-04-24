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

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- MapBox -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.css" rel="stylesheet" />
    <style>
        @import url("https://fonts.googleapis.com/css?family=Akronim");
        @import url("https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Oswald&display=swap");

        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 1; bottom: 1; width: 100%; height: 100vh }

        .marker {
          background-size: cover;
          width: 18px;
          height: 18px;
          border-radius: 50%;
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

        .sidebar {
          overflow: auto;
          position: absolute;
          background-color: white;
          width: 30%;
          height: 100vh;
          right: 0px;
          left: -30%;
          bottom: 0px;
          top: 0px;
          z-index: 300;
        }

        .sidebar img{
          width: 100%;
          height: 36vh;
        }

        .sidebar h1{
          margin: 0 auto;
          font-family: 'Fjalla One', sans-serif;
          font-size: 1.5rem;
          padding-left: 5%;
          padding-top: 5%;
        }

        .sidebar label{
          color: #a9a9a9;
          padding-left: 5%;
        }

        .sidebar hr{
          margin: 0;
        }

        #loading{
          position: absolute;
          top: 0px;
          right: 0px;
          display: none;
        }

        .info-place{
          height: 51.9vh;
          background-color: #00152c;
        }

        .info-place hr{
          background-color: #f2ca30;
        }

        .icon{
          margin: 3%;
          width: 10%;
          height: 40px;
          border-radius: 40px;
          background-color: #f2ca30;
        }

        .icon i{
          margin: 19%;
          font-size: 1.5rem;
          color: white;
        }

        .feature{
          float: right;
          width: 85%;
        }

        .feature label{
          font-size: 1rem;
          font-family: 'Oswald', sans-serif;
        }

        .feature a{
          font-size: 1rem;
          font-family: 'Oswald', sans-serif;
          padding-left: 5%;
        }

        .hide-sidebar{
          left: -30%;
          transition: all linear .3s;
        }

        .show-sidebar {
          left: 0;
          transition: all linear .3s;
        }

        .categories-box{
            opacity: 0;
            visibility: hidden;             
            height: 64vh;
            width: 23%;
            position: absolute;
            bottom: 31%;
            left: 75%;
            border-radius: 10px;
            background-color: rgba(255, 255, 255);
            -webkit-transition: opacity 2000ms, visibility 2000ms;
            transition: opacity 2000ms, visibility 2000ms;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
            z-index: 300;
        }

        .categories-box h2{
            margin-left: 35%;
            margin-top: 3%;
            font-size: 1.5rem;
            font-family: 'Oswald', sans-serif;
        }

        .categories-box ul{
          list-style-type: none;
        }

        .categories-box img{
          width: 18px;
          height: 18px;
          border-radius: 50%;
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
            z-index: 300;
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