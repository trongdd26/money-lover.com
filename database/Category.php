<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2015
 * Time: 10:58 PM
 */

    require_once("Database.php");
    class Category {
        public static function addCategory($categoryName,$categoryType,$userId){
            $sql = 'INSERT INTO  tbl_category(categoryName,categoryType,userId) VALUES (?,?,?) ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("sii", $categoryName, $categoryType, $userId);
            if($stmt->execute()){
                $res = $stmt->get_result();
                return $res;
            }
            return false;
        }
        public static function deleteCategory($categoryId){
            $sql = 'DELETE FROM tbl_category WHERE id = ? ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("i", $categoryId);
            if($stmt->execute()){
                return true;
            }
            return false;
        }
        public static function getCategoryByType($type,$userId){
            $sql = 'SELECT * FROM tbl_category WHERE categoryType = ? AND userId = ?';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("ii", $type,$userId);
            $arr = array();
            if($stmt->execute()){
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()){
                    array_push($arr,$row);
                }
            }
            return $arr;
        }
        public static function getCategoryByUserId($userId){
            $sql = 'SELECT * FROM tbl_category WHERE userId = ? ORDER BY categoryType DESC';
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
    }
?>