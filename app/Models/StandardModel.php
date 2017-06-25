<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class StandardModel extends Model{

    public static $standardTable = 'acp_settings';
    public static $standardId = 'settingId';
    public static $standardRows = array(
        'key'=>'key',
        'value'=>'value',
        'type'=>'type'
    );

    public static function getEmailSettings(){
        return DB::table(self::$standardTable)->select(self::$standardRows['value'].' as value')->whereIn(self::$standardRows['key'],array('smtp_host', 'smtp_type', 'smtp_username', 'smtp_password', 'smtp_port'))->get();
    }

    public static function insertValue($key,$v,$type = ''){
        DB::table(self::$standardTable)->insert(array(self::$standardRows['key']=>$key,self::$standardRows['value']=>$v,self::$standardRows['type']=>$type));
    }

}