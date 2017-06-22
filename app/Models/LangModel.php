<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class LangModel extends Model{

    private static $table_ = 'acp_languages';
    private static $rows = array('langId'=>'langId','code'=>'code','title'=>'title');

    public static function getLanguages(){
        return DB::table(self::$table_)->select(self::$rows['code'].' as code',self::$rows['title'].' as title')->get();
    }

    public static function getLanguageTitle($code){
        return DB::table(self::$table_)->select(self::$rows['title'].' as title')->where(self::$rows['code'],$code)->first()->title;
    }

}