<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class OnlineConsultantModel extends Model{

    use UserModelFields;
    protected static $table_ = 'acp_online';
    protected static $messageId = 'onlineId';
    protected static $rowsOnline = array(
        'user'=>'userId',
        'email'=>'email',
        'text'=>'text',
        'datetime'=>'datetime',
        'seen'=>'seen',
        'name'=>'name',
        'token'=>'token',
        'from'=>'from'
    );

    public static function myNewOnlineConsultantMessages(){
        return DB::table(self::$table_)->where([[self::$rowsOnline['from'],'=',0],[self::$rowsOnline['seen'],'=',0]])->count();
    }

    public static function getLastMessages($count){
       return
           DB::table(self::$table_.' as c')->select(
               'c.'.self::$messageId.' as id',
               'c.'.self::$rowsOnline['user'].' as user',
               'c.'.self::$rowsOnline['name'].' as name',
               'c.'.self::$rowsOnline['seen'].' as seen',
               'c.'.self::$rowsOnline['datetime'].' as date',
               'c.'.self::$rowsOnline['text'].' as text',
            DB::raw('(CASE '.self::$rowsOnline['user'].' WHEN 0 THEN "" ELSE (SELECT `u`.`'.UserModelFields::$rows['avatar'].'` FROM `'.UserModelFields::$usersTable.'` as `u` WHERE `u`.`'.UserModelFields::$userId.'`=`c`.`'.self::$rowsOnline['user'].'`)  END) as avatar'),
            DB::raw("(CASE ".self::$rowsOnline['user']." WHEN 0 THEN '' ELSE (SELECT CONCAT_WS(' ',`u`.`".UserModelFields::$rows['name']."`,`u`.`".UserModelFields::$rows['lastname']."`) FROM `".UserModelFields::$usersTable."` as `u` WHERE `u`.`".UserModelFields::$userId."`=`c`.`".self::$rowsOnline['user']."`)  END) as username")
        )
            ->orderBy('c.'.self::$messageId,'desc')
            ->groupBy('c.'.self::$rowsOnline['token'])
            ->limit($count)
            ->get();
    }


}