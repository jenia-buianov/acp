</section>
</section>
</section>
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

    <script src="{{asset('assets/custom/js/jquery.js')}}"></script>
    <script src="{{asset('assets/custom/js/application.js')}}"></script>
    <script src="{{asset('assets/custom/js/bootstrap.min.js')}}"></script>
@if(isset($_SESSION['user']))

    <script src="{{asset('assets/custom/js/dcAccordion.js')}}" ></script>
    <script src="{{asset('assets/custom/js/scrollTo.min.js')}}" ></script>
    <script src="{{asset('assets/custom/js/nicescroll.js')}}" ></script>
    <script src="{{asset('assets/custom/js/owl.js')}}" ></script>
    <script src="{{asset('assets/custom/js/select.min.js')}}" ></script>
    <script src="{{asset('assets/custom/js/slidebars.min.js')}}" ></script>
    <script src="{{asset('assets/custom/js/common-scripts.js')}}" ></script>
@endif
    <script src="{{asset('assets/languages/'.lang().'.js')}}"></script>
    <script>
        APPLICATION = new App({});
        @if(isset($_SESSION['user']))
        $(document).ready(function () {
            $("#owl-demo").owlCarousel({
                navigation : true,
                slideSpeed : 300,
                paginationSpeed : 400,
                singleItem : true,
                autoPlay:true

            });
        });
        $(function(){
            $('select.styled').customSelect();
        });

        $(window).on("resize",function(){
            var owl = $("#owl-demo").data("owlCarousel");
            owl.reinit();
        });
        @endif
    </script>
    </body>
</html>
