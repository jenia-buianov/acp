@include('template.header')
<div class="container" style="margin-top: 5%; margin-bottom: 5%  ">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-heading">{{translate('autorize')}}</div>
                <div class="panel-body">

                    @if(isset($error) and isset($error['text_message']))
                    <div class="alert alert-block alert-danger fade in">
                        {{$error['text_message']}}
                    </div>
                    @endif
                    <form class="center form-horizontal" role="form" method="POST" action="{{ url('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group @if(isset($error) and isset($error['email'])) {{'has-error'}} @endif">
                            <label for="email" class="col-md-4 control-label">{{ translate('email_address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="@if(isset($user)) {{ $user['email']  }} @endif" required autofocus>
                            </div>
                        </div>

                        <div class="form-group @if(isset($error) and isset($error['password'])) {{'has-error'}} @endif">
                            <label for="password" class="col-md-4 control-label">{{ translate('password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ translate('login_btn') }}
                                </button>
                               

                                <a class="btn btn-link" href="{{ url('forget') }}">
                                   {{ translate('forgot_pass') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('template.footer')
