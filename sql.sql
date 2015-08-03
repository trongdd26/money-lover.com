SELECT month,year,SUM(money) AS money FROM(	SELECT month,year,ifnull(money,0) AS money FROM
		(
			select MONTH(str_to_date(m1,"%Y-%m-%d")) AS month, YEAR(str_to_date(m1,"%Y-%m-%d")) AS year
			from
			(
			select 
			('2013-01-23' - INTERVAL DAYOFMONTH('2013-01-23')-1 DAY) 
			+INTERVAL m MONTH as m1
			from
			(
			select @rownum:=@rownum+1 as m from
			(select 1 union select 2 union select 3 union select 4) t1,
			(select 1 union select 2 union select 3 union select 4) t2,
			(select 1 union select 2 union select 3 union select 4) t3,
			(select 1 union select 2 union select 3 union select 4) t4,
			(select @rownum:=-1) t0
			) d1
			) d2 
			where m1<='2016-04-01'
			order by m1
		) AS time 
		LEFT OUTER JOIN (SELECT * FROM tbl_transaction WHERE money > 0 AND userId = 1 ) AS trans ON time.month = MONTH(trans.date) AND time.year = YEAR(trans.date)
) AS t 
GROUP BY month , year
ORDER BY year, month
/*
WHERE tbl_transaction.money > 0

GROUP BY time.month and time.year*/