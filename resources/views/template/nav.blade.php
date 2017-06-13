<div class="navbar">
    <nav class="light-green darken-1">
        <div class="nav-wrapper">
            <ul class="side-nav" id="nav-mobile" style="transform: translateX(-100%);">
                <li class="white"><a href="<?=url('/')?>" style="color:#263238">SOCCER<span style="color:#666">-</span><span style="color:#2e7d32">TODAY</span></a></li>
                <li><a href="<?=url('news')?>"><i class="fa fa-newspaper-o" aria-hidden="true" style="font-size: 1.5em;"></i> <?=translate('news')?></a></li>
                <li><a href="<?=url('tables')?>"><i class="fa fa-list-ol" aria-hidden="true" style="font-size: 1.5em;"></i> <?=translate('tables')?></a></li>
                <li><a href="<?=url('transfers')?>"><i class="fa fa-money aria-hidden="true" style="font-size: 1.5em;"></i> <?=translate('transfers')?></a></li>
                <li><a href="<?=url('teams')?>"><i class="fa fa-users" aria-hidden="true" style="font-size: 1.5em;"></i> <?=translate('teams')?></a></li>
                <li><a href="<?=url('coaches')?>"><i class="fa fa-user-secret" aria-hidden="true" style="font-size: 1.5em;"></i> <?=translate('coaches')?></a></li>
                <li><a href="<?=url('players')?>"><i class="fa fa-user" aria-hidden="true" style="font-size: 1.5em;"></i> <?=translate('players')?></a></li>
                <li class="divider"></li>
                <li><a href="<?=url('login')?>"><i class="fa fa-sign-in" aria-hidden="true" style="font-size: 1.5em;"></i> <?=translate('sing_in')?></a></li>
                <li><a href="<?=url('registration')?>"><i class="fa fa-user-plus" aria-hidden="true" style="font-size: 1.5em;"></i> <?=translate('sing_up')?></a></li>
            </ul>
            <ul>
                <li><a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a></li>
                <li class="white"><a href="<?=url('/')?>" style="color:#263238">SOCCER<span style="color:#666">-</span><span style="color:#2e7d32">TODAY</span></a></li>
            </ul>
            <ul class="hide-on-med-and-down">
                <li><a href="<?=url('news')?>"><?=translate('news')?></a></li>
                <li><a href="<?=url('tables')?>"><?=translate('tables')?></a></li>
                <li><a href="<?=url('transfers')?>"><?=translate('transfers')?></a></li>
                <li><a href="<?=url('teams')?>"><?=translate('teams')?></a></li>
                <li><a href="<?=url('coaches')?>"><?=translate('coaches')?></a></li>
                <li><a href="<?=url('players')?>"><?=translate('players')?></a></li>
            </ul>
            <ul class="right hide-on-med-and-down">
                <li><a class='dropdown-button' href='#' data-activates='dropdown1'> <i class="material-icons">more_vert</i></a></li>
                <ul id='dropdown1' class='dropdown-content' style="min-width:150px">
                    <li><a href="<?=url('login')?>"><?=translate('sing_in')?></a></li>
                    <li><a href="<?=url('registration')?>"><?=translate('sing_up')?></a></li>
                </ul>
            </ul>
        </div>
    </nav>
</div>