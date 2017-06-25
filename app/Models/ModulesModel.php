<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ModulesModel extends Model{

    use RolesModelFields;

    private static $moduleTable = 'acp_modules';
    private static $moduleId = 'moduleId';
    private static $moduleRows = array(
        'title'=>'titleKey',
        'page'=>'page',
        'control'=>'controller',
        'enabled'=>'isEnabled'
    );

    public static function getModuleByPage($page,$groupId,$userId){
        $query =  DB::table(self::$moduleTable.' as m')->select(
            'm.'.self::$moduleRows['title'].' as title',
            'm.'.self::$moduleRows['control'].' as controller')->where('m.'.self::$moduleRows['page'],$page);
        if ($groupId>1) $query->where(DB::raw("(SELECT COUNT(`r`.".RolesModelFields::$rowsRole['groupId'].") FROM `".RolesModelFields::$rolesTable."` as `r` WHERE (`r`.`".RolesModelFields::$rowsRole['groupId']."`='".$groupId."' AND `r`.`".RolesModelFields::$rowsRole['user']."`=0) or `r`.`".RolesModelFields::$rowsRole['user']."`='".$userId."')"),'>',0);
        return $query->first();
    }

}