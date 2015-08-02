<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/2/2015
 * Time: 4:14 PM
 */
    require_once("../util/ParamUtils.php");
    require_once("../database/Category.php");
    session_start();
    $result = array("result"=>false);
    try{
    //        $user = $_SESSION['user'];
        $user = array("id"=>1);
        if ($user == null) throw new Exception("");
        $result = array(
            "result" => Category::getCategoryByUserId($user['id'])
        );

    } catch (Exception $e){

    }
    echo json_encode($result);
?>