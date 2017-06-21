<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 20.06.2017
 * Time: 12:47
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model{

    use UserModelFields, GroupModelFields;

    public static function loginUser($email){
        return DB::table(UserModelFields::$usersTable)->select(UserModelFields::$rows['password'].' as password',UserModelFields::$userId.' as id')->where([[UserModelFields::$rows['email'],'=',$email],[UserModelFields::$rows['isEnabled'],'=',1]])->first();
    }

    public static function getUserById($id){
        return DB::table(UserModelFields::$usersTable.' as u')->select(
            'u.'.UserModelFields::$rows['name'].' as name',
            'u.'.UserModelFields::$rows['lastname'].' as lastname',
            'u.'.UserModelFields::$rows['avatar'].' as avatar',
            'g.'.GroupModelFields::$rowsGroup['title'].' as group'
        )->join(GroupModelFields::$groupsTable.' as g','u.'.UserModelFields::$rows['groupId'],'=','g.'.GroupModelFields::$groupId)
            ->where('u.'.UserModel::$userId,$id)->first();
    }

}
