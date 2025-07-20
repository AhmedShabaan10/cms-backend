<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    @yield('styles')
</head>

<body class="layout-boxed alt-menu" data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="140">
    @include('partials.loader')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container sidebar-closed sbar-open" id="container">

            <div class="overlay"></div>
            <div class="cs-overlay"></div>
            <div class="search-overlay"></div>

            @include('partials.navbar')

            @include('partials.sidebar')

            <div id="content" class="main-content">
                @yield('content')
                @include('partials.footer')
            </div>
        </div>
    </div>
    <!--  END MAIN CONTAINER  -->
</body>
