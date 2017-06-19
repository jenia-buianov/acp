<div class="container">
    <div class="col-lg-6 col-sm-12 col-xs-12 col-lg-offset-3 panel">
        <h3>{{__('install.acp')}}</h3>
        <p>
            {{__('install.select_lang')}}
        </p>


            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">SELECT</button>
                <ul class="dropdown-menu languages">
                    @for($i=0;$i<count($languages);$i++)
                        <li class="ajax_request" data-url="setup" data-post="{{data_to_attribute(array('lang'=>$languages[$i]))}}"><img src="{{url('/assets/flags/'.$languages[$i].'.png')}}"> {{__('install.'.$languages[$i])}}</li>
                    @endfor
                </ul>
            </div>


    </div>
</div>