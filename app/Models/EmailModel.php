<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EmailModel extends Model{

    protected static $table_ = 'acp_emails';
    protected static $MessagesTable_ = 'acp_emailMessages';
    protected static $emailId = 'emailId';
    protected static $messageId = 'messageId';
    protected static $rows = array(
        'user'=>'userId',
        'name'=>'name',
        'dates'=>'dates',
        'default'=>'default'
    );

    protected static $MessageRows = array(
        'email'=>'emailId',
        'text'=>'text',
        'attach'=>'attach',
        'subject'=>'subject',
        'seen'=>'seen',
        'type'=>'type',
        'dateAdd'=>'dateAdd',
        'datecreate'=>'datecreate',
        'from'=>'from'
    );

    public static function getMyListEmails($id){
        return DB::table(self::$table_)->select(self::$rows['name'].' as name',self::$emailId.' as id')->where(self::$rows['user'],$id)->get();
    }

    public static function myNewEmailMessages($id){
        $arrayEmailId = array();
        foreach (self::getMyListEmails($id) as $k=>$v){
            $arrayEmailId[] = $v->id;
        }
        if(count($arrayEmailId)) return DB::table(self::$table_)->whereIn(self::$rows['email'],$arrayEmailId)->where(self::$rows['seen'],0)->count();
        else return 0;
    }

    public static function getLastMessages($id,$count){
        $arrayEmailId = array();
        foreach (self::getMyListEmails($id) as $k=>$v){
            $arrayEmailId[] = $v->id;
        }
        if (!count($arrayEmailId)) return null;
        return DB::table(self::$table_)->select(
            self::$messageId.' as id',
            self::$MessageRows['subject'].' as subject',
            self::$MessageRows['from'].' as from',
            self::$MessageRows['datecreate'].' as date',
            self::$MessageRows['seen'].' as seen'
        )
            ->whereIn(self::$rows['email'],$arrayEmailId)
            ->where(self::$MessageRows['type'],'INBOX')
            ->orderBy(self::$MessageRows['datecreate'],'desc')
            ->limit($count)
            ->get();
    }


}