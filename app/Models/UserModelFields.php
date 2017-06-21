<?php
namespace App\Models;

trait  UserModelFields
{

    public static $usersTable = 'acp_users';
    public static $userId = 'userId';

    public static $rows = array(
                        'lang' => 'lang',
                        'groupId' => 'groupId',
                        'login' => 'login',
                        'email' => 'email',
                        'password' => 'password',
                        'name' => 'name',
                        'lastname' => 'lastname',
                        'avatar' => 'avatar',
                        'regDate' => 'regDate',
                        'regTime' => 'regTime',
                        'isEnabled' => 'isEnabled',
                        'firstEnter' => 'firstEnter'
                        );
    function __construct()
    {

    }
}

?>