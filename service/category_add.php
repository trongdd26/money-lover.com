<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2015
 * Time: 7:43 PM
 */
    require_once("../util/ParamUtils.php");
    require_once("../database/Category.php");
    session_start();
    $result = array("result"=>false);
    try{
    //        $user = $_SESSION['user'];
        $user = array("id"=>1);
        if ($user == null) throw new Exception("");
        $categoryName = ParamUtils::getParam('categoryName');
        $categoryType = ParamUtils::getParam('categoryType');
        $result = array( "result"=> Category::addCategory($categoryName,$categoryType,$user['id']));
    } catch (Exception $e){

    }
    header("Location: /Category.html");
?>