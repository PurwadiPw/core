<!DOCTYPE html>
<html id="extr-page" lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>@hasSection('htmlheader_title')@yield('htmlheader_title') - @endif{{ CoreConfigs::getByKey('sitename') }}</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- #CSS Links -->
    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('default::css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('default::css/font-awesome.min.css') }}">

    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('default::css/smartadmin-production-plugins.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('default::css/smartadmin-production.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('default::css/smartadmin-skins.min.css') }}">

    <!-- SmartAdmin RTL Support -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('default::css/smartadmin-rtl.min.css') }}">

    <!-- We recommend you use "your_style.css') }}" to override SmartAdmin
         specific styles this will also ensure you retrain your customization with each SmartAdmin update.
    <link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('default::css/your_style.css') }}"> -->

    <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('default::css/demo.min.css') }}">

    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="{{ Theme::asset('default::img/favicon/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ Theme::asset('default::img/favicon/favicon.ico') }}" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- #APP SCREEN / ICONS -->
    <!-- Specifying a Webpage Icon for Web Clip 
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="{{ Theme::asset('default::img/splash/sptouch-icon-iphone.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ Theme::asset('default::img/splash/touch-icon-ipad.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ Theme::asset('default::img/splash/touch-icon-iphone-retina.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ Theme::asset('default::img/splash/touch-icon-ipad-retina.png') }}">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="{{ Theme::asset('default::img/splash/ipad-landscape.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="{{ Theme::asset('default::img/splash/ipad-portrait.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="{{ Theme::asset('default::img/splash/iphone.png') }}" media="screen and (max-device-width: 320px)">

</head>

<body class="animated fadeInDown">

<header id="header">
    <div id="logo-group">
        <span id="logo"> <img src="{{ Theme::asset('default::img/logo.png') }}" alt="SmartAdmin"> </span>
    </div>
</header>

<div id="main" role="main">

    <!-- MAIN CONTENT -->
    @yield('content')
    <!-- END CONTENT -->

</div>

<!--================================================== -->

<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script src="{{ Theme::asset('default::js/plugin/pace/pace.min.js') }}"></script>

<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script> if (!window.jQuery) { document.write('<script src="{{ Theme::asset('default::js/libs/jquery-2.1.1.min.js') }}"><\/script>');} </script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script> if (!window.jQuery.ui) { document.write('<script src="{{ Theme::asset('default::js/libs/jquery-ui-1.10.3.min.js') }}"><\/script>');} </script>

<!-- IMPORTANT: APP CONFIG -->
<script src="{{ Theme::asset('default::js/app.config.js') }}"></script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events 		
<script src="{{ Theme::asset('default::js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script> -->

<!-- BOOTSTRAP JS -->
<script src="{{ Theme::asset('default::js/bootstrap/bootstrap.min.js') }}"></script>

<!-- JQUERY VALIDATE -->
<script src="{{ Theme::asset('default::js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

<!-- JQUERY MASKED INPUT -->
<script src="{{ Theme::asset('default::js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

<!--[if IE 8]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->

<!-- MAIN APP JS FILE -->
<script src="{{ Theme::asset('default::js/app.min.js') }}"></script>

<script type="text/javascript">
    runAllForms();
</script>

@stack('scripts')

</body>
</html>