<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" >
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            getUsers();
            let sender_id = "{{Auth::id()}}";
            let receiver_id = "";
            $(document).on('keyup', 'input.search-user', function(){
                getUsers();
            });

            $(document).on('click', '.user', function(e){
                receiver_id = $(this).attr('id');
                let elem = $(this).find('.pending');
                $.ajax({
                    method: "GET",
                    url: `message/${receiver_id}`,
                    success: function(data)
                    {
                        $('div#messages').html(data);
                        elem.remove();
                        scrollToBottomFunc();

                    }
                });
            });            
            
            $(document).on('keyup', 'input#message', function(e){
                let message = $(this).val();
                if(e.keyCode == 13 && message != '' && receiver_id != '')
                {
                    $(this).val('');

                    $.ajax({
                        method: "POST",
                        url: `{{ route('message.store') }}`,
                        data: {message,receiver_id},
                        success: function(data)
                        {
                            // scrollToBottomFunc();
                        }
                    });
                }

            });

            Pusher.logToConsole = true;

            var pusher = new Pusher('216576b2ccf844a076f4', {
                cluster: 'ap2'
            });

            var channel = pusher.subscribe('message-channel');
            channel.bind('message-event', function(data) {
                if(data.sender_id == sender_id)
                {
                    $('#'+data.receiver_id).click();
                }               
                if(data.receiver_id == sender_id)
                {
                    if(data.sender_id == receiver_id)
                    {
                        $('#'+data.sender_id).click();
                    }
                    else
                    {
                        let unread = parseInt($('#'+data.sender_id).find('.pending').text());
                        if(unread)
                        {
                            $('#'+data.sender_id).find('.pending').text(unread + 1);
                        }
                        else{
                            $('#'+data.sender_id).append(`<span class="pending">1</span>`);
                        }
                    }
                }
            });

            function getUsers()
            {
                let query = $('input.search-user').val();
                $.ajax({
                    method: "GET",
                    url: `message?query=${query}`,
                    success: function(data)
                    {
                        $('div.user-list').html(data);
                    }
                });
            }
            
        });

        // make a function to scroll down auto
        function scrollToBottomFunc() {
            let wrapper = $('.message-wrapper');
            wrapper.animate({ scrollTop: wrapper.prop("scrollHeight") }, 300);
        }
    </script>

</body>
</html>
