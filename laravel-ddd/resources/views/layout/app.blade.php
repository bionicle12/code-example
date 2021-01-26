<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/favicon.png" type="image/png">
    <link rel="alternate" hreflang="ru" href="{{url('')}}/lang/ru" />
    <link rel="alternate" hreflang="en" href="{{url('')}}/lang/en" />

    <title>@yield('title')</title>

    <meta name="description" content="@yield('description')"/>
    <link rel="canonical" href="{{Request::url()}}" />

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="@yield('description')"/>
    <meta name="twitter:title" content="@yield('title')"/>
    <meta name="twitter:image" content="@yield('image')"/>

    <meta property='og:site_name' content="{{ config('app.name', 'Tion Global') }}"/>
    <meta property='og:title' content="@yield('title')"/>
    <meta property='og:url' content="{{Request::url()}}" />
    <meta property='og:description' content="@yield('description')"/>
    <meta property='og:image' content="@yield('image')"/>

    <!-- Fonts -->
{{--    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap" rel="stylesheet">--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;600;700&display=swap" rel="stylesheet">--}}

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}

        /* critical */
        :root{--blue:#3490dc;--indigo:#6574cd;--purple:#9561e2;--pink:#f66d9b;--red:#e3342f;--orange:#f6993f;--yellow:#ffed4a;--green:#38c172;--teal:#4dc0b5;--cyan:#6cb2eb;--white:#fff;--gray:#6c757d;--gray-dark:#343a40;--primary:#3490dc;--secondary:#6c757d;--success:#38c172;--info:#6cb2eb;--warning:#ffed4a;--danger:#e3342f;--light:#f8f9fa;--dark:#343a40;--breakpoint-xs:0;--breakpoint-sm:576px;--breakpoint-md:768px;--breakpoint-lg:992px;--breakpoint-xl:1200px;--font-family-sans-serif:"Roboto",sans-serif;--font-family-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace}*,::after,::before{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%}header,main,nav{display:block}body{margin:0;font-family:Roboto,sans-serif;font-size:.9rem;font-weight:400;line-height:1.6;color:#212529;text-align:left;background-color:#f8fafc}h1,h2{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ul{margin-top:0;margin-bottom:1rem}a{color:#3490dc;text-decoration:none;background-color:transparent}img{vertical-align:middle;border-style:none}svg{overflow:hidden;vertical-align:middle}button{border-radius:0}button{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button{overflow:visible}button{text-transform:none}[type=button],button{-webkit-appearance:button}[type=button]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}h1,h2{margin-bottom:.5rem;font-weight:500;line-height:1.2}h1{font-size:2.25rem}h2{font-size:1.8rem}.img-fluid{max-width:100%;height:auto}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.row{display:flex;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.col-12,.col-5,.col-lg-4,.col-md-4,.col-md-8,.col-sm-4{position:relative;width:100%;padding-right:15px;padding-left:15px}.col-5{flex:0 0 41.6666666667%;max-width:41.6666666667%}.col-12{flex:0 0 100%;max-width:100%}@media (min-width:576px){.col-sm-4{flex:0 0 33.3333333333%;max-width:33.3333333333%}}@media (min-width:768px){.col-md-4{flex:0 0 33.3333333333%;max-width:33.3333333333%}.col-md-8{flex:0 0 66.6666666667%;max-width:66.6666666667%}}@media (min-width:992px){.col-lg-4{flex:0 0 33.3333333333%;max-width:33.3333333333%}}.collapse:not(.show){display:none}.dropdown{position:relative}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:10rem;padding:.5rem 0;margin:.125rem 0 0;font-size:.9rem;color:#212529;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.15);border-radius:.25rem}.dropdown-menu-left{right:auto;left:0}.dropdown-menu-right{right:0;left:auto}.dropdown-item{display:block;width:100%;padding:.25rem 1.5rem;clear:both;font-weight:400;color:#212529;text-align:inherit;white-space:nowrap;background-color:transparent;border:0}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;padding:.5rem 1rem}.navbar-brand{display:inline-block;padding-top:.32rem;padding-bottom:.32rem;margin-right:1rem;font-size:1.125rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:flex;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-nav .dropdown-menu{position:static;float:none}.navbar-collapse{flex-basis:100%;flex-grow:1;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.125rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:no-repeat center center;background-size:100% 100%}@media (min-width:992px){.navbar-expand-lg{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-lg .navbar-nav{flex-direction:row}.navbar-expand-lg .navbar-nav .dropdown-menu{position:absolute}.navbar-expand-lg .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-lg .navbar-collapse{display:flex!important;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}.navbar-light .navbar-brand{color:rgba(0,0,0,.9)}.navbar-light .navbar-nav .nav-link{color:rgba(0,0,0,.5)}.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1)}.d-flex{display:flex!important}.justify-content-end{justify-content:flex-end!important}@media (min-width:768px){.flex-md-row-reverse{flex-direction:row-reverse!important}}.mt-4{margin-top:1.5rem!important}.py-3{padding-top:1rem!important}.py-3{padding-bottom:1rem!important}.py-4{padding-top:1.5rem!important}.py-4{padding-bottom:1.5rem!important}.ml-auto{margin-left:auto!important}@media (min-width:768px){.py-md-0{padding-top:0!important}.py-md-0{padding-bottom:0!important}}.text-left{text-align:left!important}.text-center{text-align:center!important}main{min-height:500px}body{background-color:#fff;font-family:Roboto,sans-serif;font-size:1rem;color:#333;font-weight:300;line-height:1.5}a{color:#30cbf2;line-height:24px}a.more{border:1px solid #30cbf2;color:#30cbf2;padding:10px 60px;display:inline-block}h1,h2{font-family:"Roboto Condensed",sans-serif;font-weight:200;text-align:center;color:#333;text-transform:uppercase}header{height:100px}header .header-nav{height:100px}header .nav-link{font-family:"Roboto Condensed",sans-serif;font-weight:300;color:#666;font-size:1.25rem;padding-right:30px}header .dropdown-menu{border-radius:0}header a{color:#686868}header a.dropdown-item{font-weight:300;line-height:1em;font-size:.94rem;font-family:"Roboto Condensed",sans-serif;color:#000}header .navbar-light .navbar-toggler{color:#fff;border-color:#fff}@media all and (min-width:992px){header .navbar .nav-item .dropdown-menu{display:none;margin-top:0}}@media (max-width:767px){header .navbar-collapse{position:fixed;z-index:1;top:100px;right:0;padding-left:15px;padding-right:15px;padding-bottom:15px;width:80%;height:100%;background-color:#fff}header .nav-link{text-transform:uppercase}header .dropdown-menu{display:block;border:none}header a.dropdown-item{text-transform:uppercase;width:100%;color:#7d7d7d;padding:5px 0 5px 20px;font-size:.8125rem;font-family:"Roboto Condensed",sans-serif;font-style:normal;font-weight:300;text-align:left;display:block}header a.dropdown-item:before{content:" - "}header .nav-item.dropdown{position:relative}header .nav-item.dropdown a.nav-link:after{content:"\203A";color:#7d7d7d;position:absolute;font-size:2rem;padding-left:5px;top:6px}}h1{font-size:2.625rem}h1.main{padding:45px 0 75px}.product h2{font-size:2.25rem;padding:20px 0 20px}.product h2 a{font-family:"Roboto Condensed";color:#333}.product-icon img{height:46px}.product>.row{border-bottom:1px solid #ededed;margin-bottom:50px;padding-bottom:50px}
    </style>

{{--    <link href="{{ mix('css/app.css') }}" rel="stylesheet">--}}
</head>
<body>

<header class="container">
    @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                @endif
            @endif
        </div>
    @endif


    <nav class="navbar navbar-light navbar-expand-lg header-nav">
        <a class="navbar-brand" href="/">
            <svg height="39" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 149 39" class="c-icon c-icon-custom-size c-sidebar-brand-full" role="img">
                <title>Tion Global</title>
                <g style="fill:#013444">
                    <path d="M127.4,2V38h-9.25L102.75,19V38H92.47V2h9.25l15.41,18.49V2ZM30.82,2V12.3H20.55V38H10.27V12.3H0V2ZM46.23,38H36V2H46.23V38Zm23.12-9.76A8.22,8.22,0,1,1,77.57,20a8.22,8.22,0,0,1-8.22,8.22ZM69.35,1a19,19,0,1,0,19,19,19,19,0,0,0-19-19Z" transform="translate(0 -1)"></path>
                </g>
                <g style="fill:#0cf">
                    <path d="M140.71,37.31a8.32,8.32,0,0,1-1.13-.08,8.22,8.22,0,1,1,1.13.08Z" transform="translate(0 -1)"></path>
                </g>
            </svg>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ml-auto">
                <?php
                $halfCountMenus = count($hMenus)/2;
                $iterator = 0;
                ?>
                @foreach ($hMenus as $key=>$menu)
                    @php
                        $countChildren =  count($menu->getChildren());
                    @endphp
                    <li class="nav-item @if($countChildren){{'dropdown'}}@endif">
                        <a class="nav-link"
                           @if($countChildren)
                               {{"id=navbarDropdown$key"}}
                                href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                           @else
                                href="{{$menu->getUrl()}}"
                           @endif
                        >{{$menu->getTitle()}}</a>
                        @if ($countChildren)
                            <div class="dropdown-menu dropdown-menu-@if($iterator>$halfCountMenus){{'right'}}@else{{'left'}}@endif" aria-labelledby="navbarDropdown{{$key}}">
                                <div class="d-flex">
                                    <div>
                                    @foreach ($menu->getChildren() as $child)
                                        <a class="dropdown-item {{str_replace('col-break', '', $child->getClass())}}" href="{{$child->getUrl()}}">{{$child->getTitle()}}</a>
                                        @if (strstr($child->getClass(), 'col-break'))
                                            </div><div>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </li>
                    <?php $iterator++; ?>
                @endforeach
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @php $ll = \Illuminate\Support\Facades\App::getLocale(); @endphp
                        {{ $ll ? $locales[$ll]->title : $locales[$locales->keys()->first()]->title }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @foreach ($locales as $locale)
                            <a class="dropdown-item" href="lang/{{$locale->code}}">{{ $locale->title }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>
            <div class="d-md-flex justify-content-end ml-auto d-none">
                <svg height="40" viewBox="0 0 39 40" xmlns="http://www.w3.org/2000/svg" role="img">
                    <g xmlns="http://www.w3.org/2000/svg" id="layout_2" data-name="layout2">
                        <g id="layout_1-2" data-name="layout1">
                            <path d="M19.84,0A18.94,18.94,0,0,1,33.59,5.33,18,18,0,0,1,39.07,18.8q0,5-1.93,7.83a5.8,5.8,0,0,1-4.94,2.78,6,6,0,0,1-3.64-1.15,5.89,5.89,0,0,1-2.19-3.2,8,8,0,0,1-2.94,3.18,7.91,7.91,0,0,1-4.24,1.17A8.24,8.24,0,0,1,13,26.76a9.12,9.12,0,0,1-2.55-6.57A9.12,9.12,0,0,1,13,13.62,8.31,8.31,0,0,1,19.23,11a7.67,7.67,0,0,1,6.83,3.7V11.49h2.18v11A5.19,5.19,0,0,0,29.37,26a3.7,3.7,0,0,0,2.92,1.29,3.78,3.78,0,0,0,3.43-2.2,12.56,12.56,0,0,0,1.22-6A16.38,16.38,0,0,0,32.07,6.88,16.72,16.72,0,0,0,19.84,2.09,17.26,17.26,0,0,0,2.13,19.8a17.51,17.51,0,0,0,5.29,13A18,18,0,0,0,20.58,38,21.73,21.73,0,0,0,30,35.94L30.67,38a24.24,24.24,0,0,1-10.13,2.13A20.09,20.09,0,0,1,5.87,34.35,19.5,19.5,0,0,1,0,19.84,19.35,19.35,0,0,1,19.84,0ZM14.75,25.26a6.28,6.28,0,0,0,4.7,2,6.34,6.34,0,0,0,4.74-2,7,7,0,0,0,2-5.11,6.74,6.74,0,0,0-2-5,6.38,6.38,0,0,0-4.7-2,6.36,6.36,0,0,0-4.72,2,7,7,0,0,0-1.93,5.07A7,7,0,0,0,14.75,25.26Z" fill="#003f4e"/>
                        </g>
                    </g>
                </svg>
                <div class="EmailPopup" data-text="EMAIL US"></div>
            </div>
        </div>
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer class="container d-flex flex-column mt-3">
    <div class="footer-content py-3 d-flex flex-column flex-md-row align-items-center">
        <div class="d-flex flex-column pl-3 mr-md-5">
            <div>
                <a href="/">
                    <img height="30" src="/images/logo-tion-global.png" alt="">
                </a>
            </div>
            <div class="d-flex justify-content-between footer-content-social pl-1 pt-3 pr-3">
                <a href="https://facebook.com/tion.02">
                    <svg height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" role="img">
                        <defs><style>.cls-1{fill:#a1aaaf;}</style></defs>
                        <g id="Слой_2" data-name="Слой 2">
                            <g id="Слой_1-2" data-name="Слой 1">
                                <path class="cls-1" d="M11,0A11,11,0,1,0,22,11,11,11,0,0,0,11,0Zm5.89,12.57a2.64,2.64,0,0,1-2.64,2.64H7.49a2.64,2.64,0,0,1-2.64-2.64V9.43A2.64,2.64,0,0,1,7.49,6.79h6.76a2.64,2.64,0,0,1,2.64,2.64Z"/><path class="cls-1" d="M12.79,10.92,9.89,9.35c-.12-.07-.52,0-.52.15v3.08c0,.13.4.22.52.15l3-1.49C13,11.17,12.91,11,12.79,10.92Z"/>
                            </g>
                        </g>
                    </svg>
                </a>
                <a href="https://instagram.com/tion.official">
                    <svg height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.78 22" role="img">
                        <defs><style>.cls-1{fill:#a1aaaf;}</style></defs>
                        <g id="Слой_2" data-name="Слой 2">
                            <g id="Слой_1-2" data-name="Слой 1">
                                <path class="cls-1" d="M11,12.38l.61-4H7.8V5.81a2,2,0,0,1,2.25-2.15h1.73V.27A21,21,0,0,0,8.7,0C5.55,0,3.5,1.91,3.5,5.36v3H0v4H3.5V22H7.8V12.38Z"/>
                            </g>
                        </g>
                    </svg>
                </a>
                <a href="https://youtube.com/user/tioninfo">
                    <svg height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" role="img">
                        <defs><style>.cls-1{fill:#a1aaaf;}</style></defs>
                        <g id="Слой_2" data-name="Слой 2">
                            <g id="Слой_1-2" data-name="Слой 1">
                                <path class="cls-1" d="M16.82,3.93a1.29,1.29,0,1,0,1.29,1.29A1.29,1.29,0,0,0,16.82,3.93Z"/><path class="cls-1" d="M11.09,5.58A5.42,5.42,0,1,0,16.51,11,5.42,5.42,0,0,0,11.09,5.58Zm0,8.89A3.47,3.47,0,1,1,14.56,11,3.48,3.48,0,0,1,11.09,14.47Z"/><path class="cls-1" d="M15.39,22H6.61A6.61,6.61,0,0,1,0,15.39V6.61A6.61,6.61,0,0,1,6.61,0h8.78A6.61,6.61,0,0,1,22,6.61v8.78A6.61,6.61,0,0,1,15.39,22ZM6.61,2.07A4.55,4.55,0,0,0,2.07,6.61v8.78a4.55,4.55,0,0,0,4.54,4.54h8.78a4.55,4.55,0,0,0,4.54-4.54V6.61a4.55,4.55,0,0,0-4.54-4.54Z"/>
                            </g>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
        <div class="mr-md-auto pl-md-5 d-flex pt-3 pt-md-0 flex-column flex-md-row footer-menu text-center text-md-left">
            @foreach ($fMenus as $menu)
                <div class="d-flex flex-column mr-md-5">
                    @if($menu->getShowTitle())
                        <h4>{{$menu->getTitle()}}</h4>
                    @endif
                    @foreach($menu->getItems() as $item)
                            <a href="{{$item->getUrl()}}">{{$item->getTitle()}}</a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-md-flex justify-center mb-5 d-none copyright">TION GROUP OF COMPANIES © 2006 - {{ date("Y") }}</div>
</footer>

<div id="scrollUp"></div>

<script>
    function loadStyle(url){
        let link = document.createElement('link');
        link.href = url;
        link.rel = 'stylesheet';
        document.body.appendChild(link);
    }
    loadStyle("{{ mix('css/app.css') }}");
</script>

<script async src="{{ mix('js/app.js') }}"></script>
</body>
</html>
