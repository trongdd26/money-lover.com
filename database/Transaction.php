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
            $sql = 'SELECT *, (SELECT categoryName FROM tbl_category WHERE id = categoryId) AS categoryName, DATE_FORMAT(date, "%Y/%m/%d %H:%i") AS dateFormat FROM tbl_transaction WHERE userId = ? ORDER BY date DESC LIMIT 10 ';
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
            $sql = "SELECT p AS PAY,q AS GAINT, (p+q) AS TOTALS FROM (SELECT COALESCE((SELECT SUM(money) AS p FROM tbl_transaction WHERE money < 0 AND userId = ? GROUP BY money),0) AS p)  AS PAY, (SELECT COALESCE((SELECT SUM(money) AS q FROM tbl_transaction WHERE money > 0 AND userId = ? GROUP BY money),0) AS q)  AS GAINT";
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
        public static function getIncomeByMonth($userId,$startDate,$endDate){
            $sql = "SELECT month,year,SUM(money) AS money FROM( SELECT month,year,ifnull(money,0) AS money FROM(select MONTH(str_to_date(m1,"%Y-%m-%d")) AS month, YEAR(str_to_date(m1,"%Y-%m-%d")) AS year from(select (? - INTERVAL DAYOFMONTH(?)-1 DAY) +INTERVAL m MONTH as m1 from(select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2 where m1<=? order by m1 ) AS time LEFT OUTER JOIN LEFT OUTER JOIN (SELECT * FROM tbl_transaction WHERE money > 0 AND userId = ? ) AS trans ON time.month = MONTH(trans.date) AND time.year = YEAR(trans.date) ) AS t GROUP BY month , year ORDER BY year, month";
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("sssi", $startDate,$startDate,$endDate,$userId);
            $arr = array();
            if($stmt->execute()){
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()){
                    array_push($arr,$row);
                }
            }
            return $arr;
        }
        public static function getOutcomeByMonth($userId,$startDate,$endDate){
            $sql = "SELECT month,year,SUM(money) AS money FROM( SELECT month,year,ifnull(money,0) AS money FROM(select MONTH(str_to_date(m1,"%Y-%m-%d")) AS month, YEAR(str_to_date(m1,"%Y-%m-%d")) AS year from(select (? - INTERVAL DAYOFMONTH(?)-1 DAY) +INTERVAL m MONTH as m1 from(select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2 where m1<=? order by m1 ) AS time LEFT OUTER JOIN LEFT OUTER JOIN (SELECT * FROM tbl_transaction WHERE money < 0 AND userId = ? ) AS trans ON time.month = MONTH(trans.date) AND time.year = YEAR(trans.date) ) AS t GROUP BY month , year ORDER BY year, month";
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("sssi", $startDate,$startDate,$endDate,$userId);
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