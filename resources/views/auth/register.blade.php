@include('template.site_header')
<div class="container " style="margin-top: 5%; margin-bottom: 5%;"  >
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ translate('register') }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="login" class="col-md-4 control-label">{{ translate('username') }}<span class="req">*</span></label>

                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control {{ $errors->has('email') ? ' error' : '' }}" name="login" value="{{ old('login') }}" required autofocus>

                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">{{translate('email_address')}}<span class="req">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' error' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">{{ translate('password') }}<span class="req">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control {{ $errors->has('email') ? ' error' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">{{ translate('confirm_pass') }}<span class="req">*</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="lang" class="col-md-4 control-label">{{ translate('lang') }}<span class="req">*</span></label>

                            <div class="col-md-6">
                                    <select name="language" class="form-control {{ $errors->has('email') ? ' error' : '' }}">
                                        <option selected disabled>--{{ translate('choose') }}--</option>
                                        @if($langs->count())
                                            @foreach($langs as $lang)
                                                <option value="{{$lang->code}}">{{ $lang->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                @if ($errors->has('language'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('language') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="countries" class="col-md-4 control-label ">{{ translate('country') }}<span class="req">*</span></label>

                            <div class="col-md-6">
                                <select name="countries" class="form-control {{ $errors->has('email') ? ' error' : '' }}">
                                    @if($countries->count())
                                        <option selected disabled>--{{ translate('choose') }}--</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->country_id}}">{{ $country->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('countries'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('countries') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="button">
                                    {{ translate('register_btn') }}
                                </button>

                            </div>
                        </div>
                    </form>
                    <div class="form-group ">
                        <a  href="{{url('login/facebook')}}"><button class="button secondary"><i class="fa fa-facebook"></i></button></a>
                        <a  href="{{url('login/google')}}"><button class="button secondary"><i class="fa fa-google"></i></button></a>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>


@include('template.site_footer')
