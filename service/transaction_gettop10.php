<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2015
 * Time: 6:53 AM
 */
    require_once("../util/ParamUtils.php");
    require_once("../database/Transaction.php");
    require_once("../database/Category.php");
    session_start();
    $result = array("result"=>false);
    try{
//        $user = $_SESSION['user'];
        $user = array("id"=>1);
        if ($user == null) throw new Exception("");
        $result = array(
            "result"=> Transaction::get10LastTransaction($user['id']),
            "categoryResult" => Category::getCategoryByUserId($user['id'])
        );

    } catch (Exception $e){

    }
    echo json_encode($result);
?>