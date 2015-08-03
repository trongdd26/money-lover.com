<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2015
 * Time: 7:43 PM
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
        $categoryId = ParamUtils::getParam('categoryId');
        $money = str_replace(',','',ParamUtils::getParam('money'));
        $category = Category::getCategoryById($categoryId);
        if (!is_null($category)){
            if ($category['categoryType'] == 1) $money = abs(floatval($money));
            else if ($category['categoryType'] == 2) $money = -abs(floatval($money));
        }
        $note = ParamUtils::getParam('note');
        $date = ParamUtils::getParam('date');
        $result = array( "result"=> Transaction::addTransaction($user['id'],$categoryId,$money,$note,$date));
    } catch (Exception $e){

    }
    header("Location: /index.html");
?>