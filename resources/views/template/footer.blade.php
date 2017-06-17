    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

    <script src="{{asset('assets/libraries/jquery.min.js')}}"></script>
    <script src="{{asset('assets/custom/js/application.js')}}"></script>
    <script src="{{asset('assets/libraries/bootstrap/js/bootstrap.min.js')}}"></script>
    <script>
        APPLICATION = new App({});
    </script>
    </body>
</html>
