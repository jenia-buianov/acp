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

    use UserModelFields;

    public static function loginUser($email){
        return DB::table(UserModelFields::$usersTable)->select(UserModelFields::$rows['password'].' as password',UserModelFields::$userId.' as id')->where([[UserModelFields::$rows['email'],'=',$email],[UserModelFields::$rows['isEnabled'],'=',1]])->first();
    }

}
