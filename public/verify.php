<?php
error_reporting(0);
$hosts = $_POST['hosts'];
$users = $_POST['users'];
$db = $_POST['db'];
$pass = $_POST['pass'];
$FAILS = array();
$RESP = array();

for($i=0;$i<count($hosts);$i++){
    $k = $i*4;
    $connection = mysqli_connect($hosts[$i],$users[$i],$pass[$i],$db[$i]);
    if (!$connection) {
        $FAILS[] = $i;
        $RESP[] = array('#databases .form-group:eq("' . $k . '")', 0);
        $RESP[] = array('#databases .form-group:eq("' . ($k + 1) . '")', 0);
        $RESP[] = array('#databases .form-group:eq("' . ($k + 2) . '")', 0);
        $RESP[] = array('#databases .form-group:eq("' . ($k + 3) . '")', 0);
    }
    else{
        $RESP[] = array('#databases .form-group:eq("' . $k . '")',1);
        $RESP[] = array('#databases .form-group:eq("'.  ($k + 1). '")',1);
        $RESP[] = array('#databases .form-group:eq("' . ($k + 2)  . '")',1);
        $RESP[] = array('#databases .form-group:eq("' . ($k + 3)  . '")',1);
    }
}

echo json_encode(array('resp'=>$RESP,'fails'=>$FAILS));

?>