<?php
    require_once("../util/ParamUtils.php");
    require_once("../database/Transaction.php");
    session_start();
    $result = array("result"=>false);
    try{
//        $user = $_SESSION['user'];
        $user = array("id"=>1);
        if ($user == null) throw new Exception("");
        $result = array(
            "result"=> Transaction::get10LastTransaction($user['id'])
        );

    } catch (Exception $e){

    }
    echo json_encode($result);
?>