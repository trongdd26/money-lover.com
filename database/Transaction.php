<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2015
 * Time: 7:56 PM
 */
    require_once("Database.php");
    class Transaction{
        public static function addTransaction($userId,$categoryId,$money,$note,$date){
            $sql = 'INSERT INTO  tbl_transaction(userId,categoryId,money,note,date) VALUES (?,?,?,?,?) ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("iidss", $userId, $categoryId, $money, $note, $date);
            if($stmt->execute()){
                $res = $stmt->get_result();
                return $res;
            }
            return false;
        }
        public static function editTransaction($userId,$transactionId,$categoryId,$money,$note,$date){
            $sql = 'UPDATE tbl_transaction SET userId = ?, categoryId = ?, money = ?,note = ?,date = ? WHERE id = ? ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("iidssi", $userId, $categoryId, $money, $note, $date,$transactionId);
            if($stmt->execute()){
                $res = $stmt->get_result();
                return $res;
            }
            return false;
        }
        public static function deleteTransaction($transactionId){
            $sql = 'DELETE FROM tbl_transaction WHERE id = ? ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("i", $transactionId);
            if($stmt->execute()){
                $res = $stmt->get_result();
                return $res;
            }
            return false;
        }
        public static function get10LastTransaction($userId){
            $sql = 'SELECT *, (SELECT categoryName FROM tbl_category WHERE id = categoryId) AS categoryName,(SELECT categoryType FROM tbl_category WHERE id = categoryId) AS categoryType, DATE_FORMAT(date, "%Y/%m/%d %H:%i") AS dateFormat FROM tbl_transaction WHERE userId = ? ORDER BY date DESC LIMIT 10 ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("i", $userId);
            $arr = array();
            if($stmt->execute()){
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()){
                    array_push($arr,$row);
                }
            }
            return $arr;
        }
        public static function getStatistic($userId){
            $sql = "SELECT p AS PAY,q AS GAINT, (p+q) AS TOTALS FROM (SELECT COALESCE((SELECT SUM(money) AS p FROM tbl_transaction WHERE money < 0 AND userId = ? GROUP BY userId),0) AS p)  AS PAY, (SELECT COALESCE((SELECT SUM(money) AS q FROM tbl_transaction WHERE money > 0 AND userId = ? GROUP BY userId),0) AS q)  AS GAINT";
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("ii", $userId,$userId);
            $arr = array();
            if($stmt->execute()){
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()){
                    array_push($arr,$row);
                }
            }
            return $arr;
        }
    }
?>