<div class="col-lg-6 col-sm-12 col-xs-12 col-lg-offset-3 panel">
        <h3>{{__('install.acp')}}</h3>
        <p>
            {{__('install.welcome_install')}}
        </p>

        <ul class="tabs">
           <li class="active">{{__('install.step',['s'=>1])}}</li>
           <li>{{__('install.step',['s'=>2])}}</li>
           <li>{{__('install.step',['s'=>3])}}</li>
           <li>{{__('install.step',['s'=>4])}}</li>
        </ul>

        <form data-url="{{'install/finish'}}" method="post" class="ajax_request" id="install_form">
            <text>
                <div class="bg-danger" id="alert"></div>
                <div class="form-group">
                    <label class="sr-only">{{__('install.name')}}</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>
                        <input type="text" class="form-control" name="name" placeholder="{{__('install.name')}}" must="1" onchange="setAdmin(this)">
                    </div>
                </div>

                <div class="form-group">
                    <label class="sr-only">{{__('install.email')}}</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        </div>
                        <input type="email" class="form-control" name="email" placeholder="{{__('install.email')}}" must="1" onchange="setAdmin(this)">
                    </div>
                </div>

                <div class="form-group">
                    <label class="sr-only">{{__('install.url')}}</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-link" aria-hidden="true"></i>
                        </div>
                        <input type="text" class="form-control" name="url" placeholder="http://" value="http://{{$_SERVER['HTTP_HOST']}}" must="1">
                    </div>
                </div>


                <button class="btn btn-danger" type="button" style="position: absolute; bottom: 0px; right: 2em;margin-bottom: 2em" onclick="next(1)">{{__('install.next')}}</button>
            </text>
            <text>

                {{__('install.step2')}}
                <br>
                <div class="bg-danger" id="alert"></div>
                <div style="margin-top: 1em">
                    <label class="col-md-12 col-xs-12">
                        <input type="radio" name="db" value="0" must="1" placeholder="{{__('install.no_db')}}"> {{__('install.no_db')}}
                    </label>
                    <label class="col-md-12 col-xs-12">
                        <input type="radio" name="db" value="1" must="1" placeholder="{{__('install.e_db')}}"> {{__('install.e_db')}}
                    </label>
                </div>

                <button class="btn btn-primary" type="button"  style="position: absolute; bottom: 0px; left: 2em;margin-bottom: 2em" onclick="next(0)">{{__('install.prev')}}</button>
                <button class="btn btn-danger" type="button"  style="position: absolute; bottom: 0px; right: 2em;margin-bottom: 2em" onclick="next(2)">{{__('install.next')}}</button>
            </text>
            <text>

                {{__('install.step3')}}
                <br>
                <br>
                <div class="bg-danger" id="alert"></div>
                <div id="databases">
                    <h4>{{__('install.db')}}1</h4>
                    <div class="form-group">
                        <label class="sr-only">{{__('install.host')}}</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-server" aria-hidden="true"></i>
                            </div>
                            <input type="text" class="form-control" name="host[]" placeholder="{{__('install.host')}}" value="82.163.178.67" must="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="sr-only">{{__('install.user')}}</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                            <input type="text" class="form-control" name="user[]" placeholder="{{__('install.user')}}" must="1" value="buianove_root">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="sr-only">{{__('install.password')}}</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-key" aria-hidden="true"></i>
                            </div>
                            <input type="password" class="form-control" name="password[]" placeholder="{{__('install.password')}}" must="1" value="Qq4541201096">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="sr-only">{{__('install.db_title')}}</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-table" aria-hidden="true"></i>
                            </div>
                            <input type="text" class="form-control" name="databases[]" placeholder="{{__('install.db_title')}}" must="1" value="buianove_acp">
                        </div>
                    </div>


                </div>

                <p align="center">
                    <a href="#" onclick="addAnotherDB()">{{__('install.add_db')}}</a>
                </p>

                <button class="btn btn-primary" type="button"  style="position: absolute; bottom: 0px; left: 2em;margin-bottom: 2em" onclick="next(0)">{{__('install.prev')}}</button>
                <button class="btn btn-danger" type="button" id="b" style="position: absolute; bottom: 0px; right: 2em;margin-bottom: 2em" onclick="verifyDB()">{{__('install.db_connection')}}</button>
            </text>
            <text>
                <p>

                </p>
            </text>
        </form>
</div>