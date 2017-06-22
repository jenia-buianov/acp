<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model{

    protected static $table_ = 'acp_notifications';
    protected static $notificationId = 'notificationId';
    protected static $rows = array(
        'title'=>'titleKey',
        'text'=>'textKey',
        'user'=>'userId',
        'link'=>'link',
        'seen'=>'seen',
        'datetime'=>'datetime',
        'type'=>'type'
    );

    public static function myNewNotifications($id){
        return DB::table(self::$table_)->where([[self::$rows['user'],'=',$id],[self::$rows['seen'],'=',0]])->count();
    }

    public static function getLastNotifications($id,$count){
        return DB::table(self::$table_)->select(
            self::$rows['title'].' as title',
            self::$rows['link'].' as link',
            self::$rows['seen'].' as seen',
            self::$rows['datetime'].' as date',
            self::$rows['type'].' as model'
        )
            ->where(self::$rows['user'],$id)
            ->orderBy(self::$notificationId,'desc')
            ->limit($count)
            ->get();
    }


}