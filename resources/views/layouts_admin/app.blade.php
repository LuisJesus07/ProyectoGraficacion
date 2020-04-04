<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts_admin.head')
    @yield('head')
</head>

<body class="">

    <div id="wrapper">

    @include('layouts_admin.sidebar')

        <div id="page-wrapper" class="gray-bg">

        @include('layouts_admin.navigation')

            @include('layouts_admin.breadcrum')

            <div class="wrapper wrapper-content">

                @yield('content')

                 
            </div>
            
            @include('layouts_admin.footer')

            @yield('modals')
            
        </div>

    </div>

    @include('layouts_admin.scripts') 
    @yield('scripts')

</body>

</html>
