<?php
	require_once("Database.php");
    class ChartReport{
    	public static function getIncomeByMonth($userId,$startDate,$endDate){
            $sql = "SELECT month,year,SUM(money) AS money FROM( SELECT month,year,ifnull(money,0) AS money FROM(select MONTH(str_to_date(m1,\"%Y-%m-%d\")) AS month, YEAR(str_to_date(m1,\"%Y-%m-%d\")) AS year from(select (? - INTERVAL DAYOFMONTH(?)-1 DAY) +INTERVAL m MONTH as m1 from(select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2 where m1<=? order by m1 ) AS time LEFT OUTER JOIN (SELECT * FROM tbl_transaction WHERE money > 0 AND userId = ? ) AS trans ON time.month = MONTH(trans.date) AND time.year = YEAR(trans.date) ) AS t GROUP BY month , year ORDER BY year, month";
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
            $sql = "SELECT month,year,SUM(money) AS money FROM( SELECT month,year,ifnull(money,0) AS money FROM(select MONTH(str_to_date(m1,\"%Y-%m-%d\")) AS month, YEAR(str_to_date(m1,\"%Y-%m-%d\")) AS year from(select (? - INTERVAL DAYOFMONTH(?)-1 DAY) +INTERVAL m MONTH as m1 from(select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2 where m1<=? order by m1 ) AS time LEFT OUTER JOIN (SELECT * FROM tbl_transaction WHERE money < 0 AND userId = ? ) AS trans ON time.month = MONTH(trans.date) AND time.year = YEAR(trans.date) ) AS t GROUP BY month , year ORDER BY year, month";
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

        public static function getIncomeByDay($userId,$startDate,$endDate){
            $sql = "SELECT day,month,year,SUM(money) AS money FROM( SELECT day,month,year,ifnull(money,0) AS money FROM(select MONTH(str_to_date(m1,\"%Y-%m-%d\")) AS month, YEAR(str_to_date(m1,\"%Y-%m-%d\")) AS year, DAY(str_to_date(m1,\"%Y-%m-%d\")) AS day from(select (?) +INTERVAL m DAY as m1 from(select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2 where m1<=? order by m1 ) AS time LEFT OUTER JOIN (SELECT * FROM tbl_transaction WHERE money > 0 AND userId = ? ) AS trans ON time.month = MONTH(trans.date) AND time.year = YEAR(trans.date) AND time.day = DAY(trans.date) ) AS t GROUP BY day, month, year ORDER BY year, month, day";
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("ssi",$startDate,$endDate,$userId);
            $arr = array();
            if($stmt->execute()){
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()){
                    array_push($arr,$row);
                }
            }
            return $arr;
        }
        public static function getOutcomeByDay($userId,$startDate,$endDate){
            $sql = "SELECT day,month,year,SUM(money) AS money FROM( SELECT day,month,year,ifnull(money,0) AS money FROM(select MONTH(str_to_date(m1,\"%Y-%m-%d\")) AS month, YEAR(str_to_date(m1,\"%Y-%m-%d\")) AS year, DAY(str_to_date(m1,\"%Y-%m-%d\")) AS day from(select (?) +INTERVAL m DAY as m1 from(select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2 where m1<=? order by m1 ) AS time LEFT OUTER JOIN (SELECT * FROM tbl_transaction WHERE money < 0 AND userId = ? ) AS trans ON time.month = MONTH(trans.date) AND time.year = YEAR(trans.date) AND time.day = DAY(trans.date) ) AS t GROUP BY day, month, year ORDER BY year, month, day";
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("ssi",$startDate,$endDate,$userId);
            $arr = array();
            if($stmt->execute()){
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()){
                    array_push($arr,$row);
                }
            }
            return $arr;
        }

        public static function getIncomeSum($userId,$startDate,$endDate){
            $sql = "select c.*, IFNULL(sum(money),0) AS total from tbl_category c left join (SELECT * from tbl_transaction where date BETWEEN ? AND ?) t on c.id = t.categoryId where c.categoryType = 1 AND c.userId = ? group by c.id";
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("ssi",$startDate,$endDate,$userId);
            $arr = array();
            if($stmt->execute()){
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()){
                    array_push($arr,$row);
                }
            }
            return $arr;
        }

        public static function getOutcomeSum($userId,$startDate,$endDate){
            $sql = "select c.*, IFNULL(abs(sum(money)),0) AS total from tbl_category c left join (SELECT * from tbl_transaction where date BETWEEN ? AND ?) t on c.id = t.categoryId where c.categoryType = 2 AND c.userId = ? group by c.id";
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bind_param("ssi",$startDate,$endDate,$userId);
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