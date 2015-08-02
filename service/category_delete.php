<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/2/2015
 * Time: 5:01 PM
 */
// Allow all user can delete transaction
    require_once("../util/ParamUtils.php");
    require_once("../database/Category.php");
    session_start();
    $result = array("result"=>false);
    try{
//        $user = $_SESSION['user'];
        $user = array("id"=>1);
        if ($user == null) throw new Exception("");
        $categoryId = ParamUtils::getParam('categoryId');
        $result = array("result"=> Category::deleteCategory($categoryId));
    } catch (Exception $e){

    }
    echo json_encode($result);
    header("Location: /Category.html");
?>