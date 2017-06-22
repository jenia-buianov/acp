<section id="container">
    <header id="tbar" class="header white-bg" style="display: none;">
        <div class="sidebar-toggle-box">
            <i class="fa fa-bars"></i>
        </div>
        <!--logo start-->
        <a href="/" data-url="/" data-history="1" class="ajax_request logo hidden-xs">Admin<span>Control</span>Panel</a>
        <a href="/" data-url="/" data-history="1" class="ajax_request hidden-md-up logo">A<span>C</span>P</a>
        <!--logo end-->
        <div class="nav notify-row" id="top_menu">
            <!--  notification start -->
            <ul class="nav top-menu">
                <!-- settings start -->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="fa fa-comments-o"></i>
                        @if($countOCMessages>0) <span class="badge bg-success">{{$countOCMessages}}</span> @endif
                    </a>
                    <ul class="dropdown-menu extended inbox">
                        <div class="notify-arrow notify-arrow-green"></div>
                        <li>
                            <p class="green">{{translate('online_consultant')}}</p>
                        </li>
                        @if(!isset($OCMessages) or  count($OCMessages)==0)
                            <li class="external">
                                <a href="#">{{translate('empty')}}</a>
                            </li>
                        @else
                            @foreach($OCMessages as $k=>$v)
                                <li @if($v->seen==0) class="new" @endif>
                                    <a href="#" class="ajax_request" data-history="1" data-url="module/online_consultant/view/{{$v->id}}">
                                        <span class="photo">
                                            @if($v->user>0 and !empty($v->avatar)) <img alt="avatar" src="{{asset('assets/images/users/'.$v->avatar)}}"> @else <img alt="avatar" src="{{asset('assets/images/noavatar.png')}}"> @endif
                                        </span>
                                        <span class="subject">
                                    <span class="from">{{$v->name}}</span>
                                    <span class="time">{{date("H:i\nj.m.y",strtotime($v->date))}}</span>
                                    </span>
                                        <span class="message">
                                        @if (mb_strlen($v->text)>27) {{mb_substr($v->text,0,27).'...'}} @else {{$v->text}} @endif
                                        @if($v->user>0) <br><br><b>{{translate('consultant').' '.$v->username}}</b> @endif
                                    </span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        @if(count($OCMessages)>0)
                            <li class="external">
                                <a href="#" class="ajax_request" data-history="1"  data-url="module/online_consultant/all">{{translate('see_all')}}</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- settings end -->
                <!-- inbox dropdown start-->
                <li id="header_inbox_bar" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="fa fa-envelope-o"></i>
                        @if(($countEMessages + $countCMessages)>0) <span class="badge bg-important">{{($countEMessages + $countCMessages)}}</span> @endif
                    </a>
                    <ul class="dropdown-menu extended inbox">
                        <div class="notify-arrow notify-arrow-red"></div>
                        <li>
                            <p class="red">{{translate('email_messages')}}</p>
                        </li>
                        @if(!isset($EMessages) or  count($EMessages)==0)
                            <li class="external">
                                <a href="#">{{translate('empty')}}</a>
                            </li>
                        @else
                            @foreach($EMessages as $k=>$v)
                                <li @if($v->seen==0) class="new" @endif>
                                    <a href="#" class="ajax_request" data-history="1" data-url="module/email/message/{{$v->id}}">
                                        <span class="subject">
                                    <span class="from">{{$v->from}}</span>
                                    <span class="time">{{date("H:i\nj.m.y",strtotime($v->date))}}</span>
                                    </span>
                                        <span class="message">
                                        @if (mb_strlen($v->subject)>27) {{mb_substr($v->subject,0,27).'...'}} @else {{$v->subject}} @endif
                                    </span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        @if(count($EMessages)>0)
                            <li>
                                <a href="#" class="ajax_request"  data-history="1" data-url="module/email/all">{{translate('see_all')}}</a>
                            </li>
                        @endif
                        <li>
                            <p class="red">{{translate('chat_messages')}}</p>
                        </li>
                        @if(!isset($CMessages) or  count($CMessages)==0)
                            <li class="external">
                                <a href="#">{{translate('empty')}}</a>
                            </li>
                        @else
                            @foreach($CMessages as $k=>$v)
                                <li @if($v->count>0) class="new" @endif>
                                    <a href="#" class="ajax_request" data-history="1" data-url="module/chat/message/{{$v->id}}">
                                         <span class="photo">
                                            @if(!empty($v->avatar)) <img alt="avatar" src="{{asset('assets/images/users/'.$v->avatar)}}"> @else <img alt="avatar" src="{{asset('assets/images/noavatar.png')}}"> @endif
                                        </span>
                                        <span class="subject">
                                    <span class="from">{{$v->username}}</span>
                                    <span class="time">{{date("H:i\nj.m.y",strtotime($v->date))}}</span>
                                            @if($v->count>0)
                                                <span class="message">{{translate('new_messages').': '.$v->count}}</span>
                                            @endif
                                    </span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        @if(count($CMessages)>0)
                            <li>
                                <a href="#" class="ajax_request"  data-history="1" data-url="module/chat/all">{{translate('see_all')}}</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- inbox dropdown end -->
                <!-- notification dropdown start-->
                <li id="header_notification_bar" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                        <i class="fa fa-bell-o"></i>
                        @if($countNotifications>0) <span class="badge bg-warning">{{$countNotifications}}</span> @endif
                    </a>
                    <ul class="dropdown-menu extended notification">
                        <div class="notify-arrow notify-arrow-yellow"></div>
                        <li>
                            <p class="yellow">{{translate('notifications')}}</p>
                        </li>
                        @if(!isset($Notifications) or  count($Notifications)==0)
                            <li class="external">
                                <a href="#">{{translate('empty')}}</a>
                            </li>
                        @else
                            @foreach($Notifications as $k=>$v)
                                <?php
                                $type = json_decode($v->type);
                                ?>
                                <li @if($v->seen==0) class="new" @endif>
                                    <a href="#" @if(!empty($v->link)) class="ajax_request" @if(isset($type->hisotry) and $type->hisotry==1) data-hisotry="1" @endif data-url="/module/notification/view/{{$v->id}}" @endif >
                                        <span class="label label-{{$type->class}}"><i class="fa fa-{{$type->icon}}"></i></span>
                                        <span class="small italic">{{date("H:i\nj.m.y",strtotime($v->date))}}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        @if(count($Notifications)>0)
                            <li>
                                <a href="#" class="ajax_request"  data-history="1" data-url="module/notifications/all">{{translate('see_all')}}</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- notification dropdown end -->
            </ul>
            <!--  notification end -->
        </div>
        <div class="top-nav ">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <li>
                    <input type="text" class="form-control search" placeholder=" {{translate('search')}}">
                </li>
                <li class="dropdown language">
                    <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
                        <img style="width:16px;height:11px" src="{{asset('assets/flags/'.lang().'.png')}}" alt="">
                        <span class="username">{{$titleLang}}</span>
                        <b class="caret"></b>
                    </a>
                    @if (count($languages)>1)
                        <ul class="dropdown-menu">
                            @foreach($languages as $k=>$v)
                                <li><a href="#"><img style="width:16px;height:11px" src="{{asset('assets/flags/'.$v->code.'.png')}}" alt=""> {{$v->title}}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
                <!-- user login dropdown start-->
                <li class="dropdown top_profile">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        @if(!empty($user->avatar)) <img style="max-width: 29px;max-height: 29px" alt="avatar" src="{{asset('assets/images/users/'.$user->avatar)}}"> @else <img style="max-width: 29px;max-height: 29px"  alt="avatar" src="{{asset('assets/images/noavatar.png')}}"> @endif
                        <span class="username">{{$user->name.' '.$user->lastname}}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li><a href="#" class="ajax_request" data-history="1" data-url="{{url('modules/groups/')}}"><i class=" fa fa-suitcase"></i>{{translate($user->group)}}</a></li>
                        <li><a href="#" class="ajax_request" data-history="1" data-url="{{url('settings')}}"><i class="fa fa-cog"></i> {{translate('settings')}}</a></li>
                        <li><a href="{{url('logout')}}"><i class="fa fa-key"></i> {{translate('logout')}}</a></li>
                    </ul>
                </li>
                <li class="sb-toggle-right">
                    <i class="fa  fa-align-right"></i>
                </li>
                <!-- user login dropdown end -->
            </ul>
            <!--search & user info end-->
        </div>
    </header>
