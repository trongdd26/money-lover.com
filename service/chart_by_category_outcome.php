<?php
/**
 * Created by PhpStorm.
 * User: Administrato
 * Date: 8/4/2015
 * Time: 12:47 AM
 */

    require_once("../util/ParamUtils.php");
    require_once("../database/ChartReport.php");
    session_start();
    $result = array("result"=>false);
    try{
        //        $user = $_SESSION['user'];
        $user = array("id"=>1);
        if ($user == null) throw new Exception("");
        $startDate = ParamUtils::getParam('startDate');
        $endDate = ParamUtils::getParam('endDate');
        $result = array(
            "result"=> ChartReport::getOutcomeSum($user['id'],$startDate,$endDate)
        );

    } catch (Exception $e){

    }
    echo json_encode($result);

?>