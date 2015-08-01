<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2015
 * Time: 6:53 AM
 */
    require_once("../util/ParamUtils.php");
    require_once("../database/Transaction.php");
    session_start();
    $result = array("result"=>false);
    try{
        $user = $_SESSION['user'];
        if ($user == null) throw new Exception("");
        $result = array("result"=> Transaction::get10LastTransaction($user['id']));
    } catch (Exception $e){

    }
    json_encode($result);
?>