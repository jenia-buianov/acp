</section>
</section>
</section>

@if(isset($_SESSION['user']))
<div class="rightClickMenu">
    <ul>
        <li class="ajax_request" data-history="1" data-url="settings"><i class="fa fa-cogs" aria-hidden="true" style="font-size: 15px"></i> {{translate('settings')}}</li>
        <li class="ajax_request" data-history="1" data-url="modules/add"><i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 15px"></i> {{translate('add_module')}}</li>
        <li class="ajax_request" data-url="found_error"><i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size: 15px"></i> {{translate('found_error')}}</li>
        <li><a href="{{url('logout')}}"><i class="fa fa-key" aria-hidden="true" style="font-size: 12px"></i> {{translate('logout')}}</a></li>
    </ul>
</div>
@endif

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
