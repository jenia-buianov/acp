<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model{

    use UserModelFields;

    protected static $table_ = 'acp_chat';
    protected static $messageId = 'messageId';
    protected static $rowsChat = array(
        'u1'=>'userId1',
        'u2'=>'userId2',
        'text'=>'text',
        'datetime'=>'datetime',
        'seen'=>'seen',
        'pair'=>'pair'
    );

    public static function myNewChatMessages($id){
        return DB::table(self::$table_)->where([[self::$rowsChat['u2'],'=',$id],[self::$rowsChat['seen'],'=',0]])->groupBy(self::$rowsChat['pair'])->count();
    }

    public static function getLastMessages($id,$count){
        return DB::table(self::$table_.' as  chat')->select(
            'chat.'.self::$rowsChat['pair'].' as id',
            'chat.'.self::$rowsChat['seen'].' as seen',
            'chat.'.self::$rowsChat['datetime'].' as date',
            DB::raw('(CASE chat.'.self::$rowsChat['u1'].' WHEN '.$id.' THEN (SELECT `u`.`'.UserModelFields::$rows['avatar'].'` FROM `'.UserModelFields::$usersTable.'` as `u` WHERE `u`.`'.UserModelFields::$userId.'`=chat.`'.self::$rowsChat['u2'].'`) ELSE (SELECT `u`.`'.UserModelFields::$rows['avatar'].'` FROM `'.UserModelFields::$usersTable.'` as `u` WHERE `u`.`'.UserModelFields::$userId.'`=chat.`'.self::$rowsChat['u1'].'`)  END) as avatar'),
            DB::raw("(CASE chat.".self::$rowsChat['u1']." WHEN ".$id." THEN (SELECT CONCAT_WS(' ',`u`.`".UserModelFields::$rows['name']."`,`u`.`".UserModelFields::$rows['lastname']."`) FROM `".UserModelFields::$usersTable."` as `u` WHERE `u`.`".UserModelFields::$userId."`=chat.`".self::$rowsChat['u2']."`) ELSE (SELECT CONCAT_WS(' ',`u`.`".UserModelFields::$rows['name']."`,`u`.`".UserModelFields::$rows['lastname']."`) FROM `".UserModelFields::$usersTable."` as `u` WHERE `u`.`".UserModelFields::$userId."`=chat.`".self::$rowsChat['u1']."`)  END) as username"),
            DB::raw("(SELECT COUNT(`c`.`".self::$messageId."`) FROM  `".self::$table_."` as `c` WHERE `c`.`".self::$rowsChat['seen']."`=0 AND `c`.`".self::$rowsChat['u2']."`='".$id."' AND `c`.`".self::$rowsChat['pair']."`=chat.".self::$rowsChat['pair'].") as count")
        )
            ->where('chat.'.self::$rowsChat['u1'],$id)
            ->orWhere('chat.'.self::$rowsChat['u2'],$id)
            ->orderBy('chat.'.self::$messageId,'desc')
            ->groupBy('chat.'.self::$rowsChat['pair'])
            ->limit($count)
            ->get();

    }


}