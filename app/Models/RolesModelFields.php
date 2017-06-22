<?php
namespace App\Models;

trait  RolesModelFields
{

    public static $rolesTable = 'acp_roles';
    public static $roleId = 'roleId';

    public static $rowsRole = array(
                        'user' => 'userId',
                        'groupId' => 'groupId',
                        'access' => 'access',
                        'email' => 'email',
                        'type' => 'type',
                        'value' => 'value'
                        );
}

?>