<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2015
 * Time: 10:58 PM
 */

    require_once("Database.php");
    class Category {
        public static function addCategory($categoryName,$categoryType){
            $sql = 'INSERT INTO  tbl_cateogry(categoryName,categoryType) VALUES (?,?) ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("si", $categoryName, $categoryType);
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
                $res = $stmt->get_result();
                return $res;
            }
            return false;
        }
        public static function getCategoryByType($type){
            $sql = 'SELECT * FROM tbl_category WHERE categoryType = ?';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("i", $type);
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