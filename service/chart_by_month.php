<?php
    require_once("../util/ParamUtils.php");
    require_once("../database/Transaction.php");
    session_start();
    $result = array("result"=>false);
    try{
//        $user = $_SESSION['user'];
        $user = array("id"=>1);
        if ($user == null) throw new Exception("");
        $startDate = ParamUtils::getParam('startDate');
        $endDate = ParamUtils::getParam('endDate');
        $result = array(
            "income"=> Transaction::getIncomeByMonth($user['id'],$startDate,$endDate),
            "outcome"=> Transaction::getOutcomeByMonth($user['id'],$startDate,$endDate)
        );

    } catch (Exception $e){

    }
    echo json_encode($result);
?>