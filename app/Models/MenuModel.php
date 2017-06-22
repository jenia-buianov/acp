<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model{

    use RolesModelFields;

    public static $menuTable = 'acp_menu';
    public static $menuId = 'menuId';
    public static $menuRows = array(
        'parent'=>'parentId',
        'order'=>'orderId',
        'user'=>'userId',
        'title'=>'titleKey',
        'link'=>'link',
        'tab'=>'tab',
        'icon'=>'icon'
    );

    public static function getLeftMenu($groupId, $userId){

        $query = "select `m`.".self::$menuRows['icon']." as `icon`, `m`.".self::$menuRows['title']." as `title`, `m`.`".self::$menuRows['link']."` as `link`, `m`.`".self::$menuRows['tab']."` as `tab` from `".self::$menuTable."` as `m` WHERE `m`.`".self::$menuRows['user']."`=".$userId." 
            OR (
           SELECT COUNT(`r`.`".RolesModelFields::$rowsRole['groupId']."`) FROM `".RolesModelFields::$rolesTable."` as `r` WHERE ";
        if($groupId>1) $query.="`r`.`".RolesModelFields::$rowsRole['groupId']."`=".$groupId." AND ";
        $query.=" `r`.`".RolesModelFields::$rowsRole['value']."`=1 AND `r`.`".RolesModelFields::$rowsRole['access']."`=`m`.`".self::$menuRows['title']."` AND `r`.`".self::$rowsRole['type']."`='leftMenu'
           ) ORDER BY `m`.`".self::$menuRows['order']."`";
        return DB::select( $query );


    }

}