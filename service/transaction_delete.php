<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2015
 * Time: 6:48 AM
 */
    // Allow all user can delete transaction
    require_once("../util/ParamUtils.php");
    require_once("../database/Transaction.php");
    session_start();
    $result = array("result"=>false);
    try{
//        $user = $_SESSION['user'];
        $user = array("id"=>1);
        if ($user == null) throw new Exception("");
        $transactionId = ParamUtils::getParam('transactionId');
        $result = array("result"=> Transaction::deleteTransaction($transactionId));
    } catch (Exception $e){

    }
    json_encode($result);
    header("Location: /index.html");
?>