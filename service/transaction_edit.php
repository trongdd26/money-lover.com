<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2015
 * Time: 6:51 AM
 */
    require_once("../util/ParamUtils.php");
    require_once("../database/Transaction.php");
    session_start();
    $result = array("result"=>false);
    try{
        $user = $_SESSION['user'];
        if ($user == null) throw new Exception("");
        $transactionId = ParamUtils::getParam($_POST,$_GET,'transactionId');
        $categoryId = ParamUtils::getParam($_POST,$_GET,'categoryId');
        $money = ParamUtils::getParam($_POST,$_GET,'money');
        $note = ParamUtils::getParam($_POST,$_GET,'note');
        $date = ParamUtils::getParam($_POST,$_GET,'date');
        $result = array("result"=> Transaction::editTransaction($user['id'],$transactionId,$categoryId,$money,$note,$date));
    } catch (Exception $e){

    }
    json_encode($result);
?>