<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Sociality</title>
        <link rel="icon" href="logo/logo2.png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/font.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome-free-5.0.8/svg-with-js/css/fa-svg-with-js.css') }}">
        <style type="text/css">
            body{
                background: #F8F9F9;
            }
        </style>

        
    </head>
    <body>
        <div id = "fb-root" > </div> <script async defer crossorigin = "anónimo" src = "https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v7.0&appId= 2711739702480818 & autoLogAppEvents = 1 " nonce = " muSMJqga " > </script> 
        <div class = "fb-login-button" data-size = "large" data-button-type = "continue_with" data-layout = "default" data-auto-logout-link = "false" data-use-continue -as = "false" data-width = "" > </div> 
        <div id="app">
           
        </div>
    </body> 
  
    <script type="text/javascript" src="{{ asset('./js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fontawesome-free-5.0.8/svg-with-js/js/fontawesome-all.js') }}" ></script>
</html>
