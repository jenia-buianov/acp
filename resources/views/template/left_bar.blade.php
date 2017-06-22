<aside id="lbar" style="display: none;">
    <div id="sidebar" class="nav-collapse " tabindex="0" style="overflow: hidden; outline: none;">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            @foreach($leftMenu as $k=>$v)
                <li>
                    <a @if($v->tab==1) href="{{$v->link}}" target="_blank" @else class="ajax_request" href="#" data-history="1" data-url="{{$v->link}}" @endif>
                        <i class="fa {{$v->icon}}"></i>
                        <span>{{translate($v->title)}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<section id="main-content">
    <section class="wrapper">