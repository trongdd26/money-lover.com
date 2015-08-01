<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2015
 * Time: 7:43 PM
 */
    require_once("../util/ParamUtils.php");
    require_once("../database/Transaction.php");
    session_start();
    $result = array("result"=>false);
    try{
        $user = $_SESSION['user'];
        if ($user == null) throw new Exception("");
        $categoryId = ParamUtils::getParam($_POST,$_GET,'categoryId');
        $money = ParamUtils::getParam($_POST,$_GET,'money');
        $note = ParamUtils::getParam($_POST,$_GET,'note');
        $date = ParamUtils::getParam($_POST,$_GET,'date');
        $result = array("result"=> Transaction::addTransaction($user['id'],$categoryId,$money,$note,$date));
    } catch (Exception $e){

    }
    json_encode($result);
?>