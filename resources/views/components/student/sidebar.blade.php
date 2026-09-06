<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'SLAS - Student Portal')
    </title>

    {{-- Bootstrap + App --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @livewireStyles
</head>

<body>

    <div class="d-flex min-vh-100">

        {{-- ================= SIDEBAR ================= --}}
        @include('components.student.sidebar')


        {{-- ================= MAIN AREA ================= --}}
        <div class="flex-grow-1">

            {{-- Header --}}
            @include('components.student.header')


            {{-- Page Content --}}
            <main>
                @yield('content')
            </main>


            {{-- Footer --}}
            @include('components.student.footer')

        </div>

    </div>

    @livewireScripts

</body>
</html>