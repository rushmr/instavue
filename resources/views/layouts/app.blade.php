<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Войти</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('home') }}">Панель</a>
                                    <li><a href="{{ route('register') }}">Регистрация пользователя</a>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Выйти
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

<div class="container">


  <div class="row">
    <div class="col-md-8 col-md-offset-2">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

</div>

</div>


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
        
                <a style='text-decoration:none' href="/panel"><button type="button" class="btn btn-block btn-lg btn-info">Статистика</button></a>

                </div>

                <div class="panel-body">


                <div class="row">

                    <div class="col-md-4">
                        <a style='text-decoration:none' href="{{ route('settings') }}"><button type="button" class="btn btn-block btn-lg btn-info">Настройки</button></a>
                    </div>

                    <div class="col-md-4">
                        <a style='text-decoration:none' href="{{ route('get') }}"><button type="button" class="btn btn-block btn-lg btn-info">Получение</button></a>
                    </div>

                     <div class="col-md-4">
                          <a style='text-decoration:none' href="{{ route('post') }}"><button type="button" class="btn btn-block btn-lg btn-info">Постинг</button></a>
                    </div>
                </div>
<br>

                 @yield('content')


            </div>
        </div>
    </div>
</div>


    </div>

<script>
   window.Laravel = <?php echo json_encode([
       'csrfToken' => csrf_token(),
            ]); ?>
</script>
<script src="{{asset('js/app.js')}}"></script>
</div>

</body>
</html>
