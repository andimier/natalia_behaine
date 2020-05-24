<?php
    function phpMethods($method, $param) {
		global $connection;

		if (phpversion() < 6) {
			switch ($method) {
				case 'query':
					return mysql_query($param, $connection);
					break;
				case 'error':
					return mysql_error();
					break;
				case 'fetch':
					return mysql_fetch_array($param);
					break;
				case 'num-rows':
					return mysql_num_rows($param);
					break;
				case 'close':
					return mysql_close($connection);
					break;
			}
		} 
		else {
			switch ($method) {
				case 'query':
					return mysqli_query($connection, $param);
					break;
				case 'error':
					return mysqli_error($connection);
					break;
				case 'fetch':
					return mysqli_fetch_array($param);
					break;
				case 'num-rows':
					return mysqli_num_rows($param);
					break;
				case 'close':
					return mysqli_close($connection);
					break;
			}
		}
    }
?>
