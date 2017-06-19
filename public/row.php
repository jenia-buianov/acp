<?php
error_reporting(0);
$hosts = $_POST['host'];
$users = $_POST['user'];
$db = $_POST['db'];
$pass = $_POST['pass'];
$sel = $_POST['sel'];
$table = $_POST['table'];
$RESP = array();

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

$sqlAllRows = "SELECT COLUMN_NAME as `name` FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = '".$sel."'";
$allRowsQuery = mysqli_query($connection,$sqlAllRows);
$rw = '<option value="">--- SELECT ROW ---</option>';
while($r = mysqli_fetch_array($allRowsQuery)){
    $rw.='<option value="'.$r['name'].'">'.$r['name'].'</option>';
}

for($i=0;$i<count($needColumns[$table]);$i++){
    $ROWS[] = '<div class="form-group col-xs-12" style="background: #f1f2f7">
                    <label class="col-xs-12 col-sm-12 col-md-6 col-lg-6">ROW '.$needColumns[$table][$i].'</label>
                    <select name="row_'.$needColumns[$table][$i].'" class="form-control col-xs-12 col-sm-12 col-md-6 col-lg-6" style="height:34px">
                    '.$rw.'
                    </select>
                   </div>';
}

$RESP['r'] = implode('<br>',$ROWS);

echo json_encode($RESP);

?>