<?php
namespace App\Models;

trait  GroupModelFields
{

    public static $groupsTable = 'acp_groups';
    public static $groupId = 'groupId';

    public static $rowsGroup = array(
        'title'=>'titleKey',
        'enabled'=>'isEnabled'
    );
}
