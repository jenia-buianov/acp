<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php if (isset($title)) echo $title; else echo __('install.acp_title');?></title>
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="{{asset('assets/libraries/font-awesome/css/font-awesome.min.css')}}"  media="screen,projection"/>

         <link href="{{ asset('assets/custom/css/install.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/libraries/animate.css') }}" rel="stylesheet">
        <script>
            var HOME_URL = '{{url("/")}}';
            var options = {}
        </script>
    </head>

    <body>