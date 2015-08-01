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
            $sql = 'SELECT * FROM tbl_transaction WHERE userId = ? ORDER BY date DESC LIMIT 10 ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("i", $userId);
            $arr = array();
            if($stmt->execute()){
                $res = $stmt->get_result();
                while($row = mysql_fetch_assoc($res)){
                    array_push($arr,$row);
                }
            }
            return $arr;
        }
    }
?>