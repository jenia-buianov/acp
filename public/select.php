<?php
error_reporting(0);
$hosts = $_POST['host'];
$users = $_POST['user'];
$db = $_POST['db'];
$pass = $_POST['pass'];
$lang = $_POST['lang'];
$RESP = array('tables');
$found = array();

$connection = mysqli_connect($hosts,$users,$pass,$db);
if (!$connection){
    $RESP['noTables'] = 1;
    echo json_encode($RESP);
}
$needTables = array('users','groups','adminlogs','adminlanguages');
$needColumns = array(
    'users'=>array(
        'userId', 'login', 'name', 'lastname', 'regDate', 'regTime', 'isEnabled','avatar','groupId','password','adminLangId'
    ),
    'groups'=>array(
        'groupId','titleKey','isEnabled'
    ),
    'adminlogs'=>array(
        'logId', 'page', 'userId', 'timeInteger', 'dateTime','os','langId'
    ),
    'adminlanguages'=>array(
        'langId','code','title'
    )

);



$sqlAllTables = "SELECT TABLE_NAME as `table`
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='".$db."'";
$allTablesQuery = mysqli_query($connection,$sqlAllTables);
if (mysqli_num_rows($allTablesQuery)==0) $RESP['noTables'] = 1;
else{
    while ($r = mysqli_fetch_array($allTablesQuery)){
        $RESP['found'][] = $r['table'];
        $found[$r['table']] = 1;
    }
}

for($i=0;$i<count($needTables);$i++){
    $TABLES = '<option value="">---- SELECT TABLE ----</option>';
    $ROWS = array();
    foreach($found as $k=>$v)
        $TABLES.='<option value="'.$k.'">'.$k.'</option>';

    $RESP['tables'].= '<div class="form-group" style="margin-top: 1.5em">
                    <font style="float:right">
                        <input type="checkbox" name="ct_'.$needTables[$i].'" value="'.$needTables[$i].'" onclick="checkedTable(this)"> Create table  '.strtoupper($needTables[$i]).'
                    </font>
                    <label>'.strtoupper($needTables[$i]).'</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-table" aria-hidden="true"></i>
                        </div>
                        <select class="form-control" name="table_'.$needTables[$i].'" data-placeholder="'.strtoupper($needTables[$i]).'" style="height:34px" onchange="selectRow(this)">
                        '.$TABLES.'
                        </select>
                    </div>
                </div>
                <div class="rows_'.$needTables[$i].'" style="display:none">
                </div>
                ';

}

$RESP['tables'].='<input type="hidden" id="create_table" must="0" name="ct">';

echo json_encode($RESP);

?>