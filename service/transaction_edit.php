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
//        $user = $_SESSION['user'];
        $user = array("id"=>1);
        if ($user == null) throw new Exception("");
        $transactionId = ParamUtils::getParam('transactionId');
        $categoryId = ParamUtils::getParam('categoryId');
        $money = str_replace(',','',ParamUtils::getParam('money'));
        $note = ParamUtils::getParam('note');
        $date = ParamUtils::getParam('date');
        $result = array("result"=> Transaction::editTransaction($user['id'],$transactionId,$categoryId,$money,$note,$date));
    } catch (Exception $e){

    }
    json_encode($result);
    header("Location: /index.html");
?>