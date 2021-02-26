<?php

function __autoload($classname) {
	if (substr($classname, - 4) == 'Ctrl')
		include BASE_DIR . 'controllers/' . str_replace('Ctrl', '', $classname) . '.php';
	else {
		$filename = BASE_DIR . 'core/' . 'class.' . strtolower($classname) . '.php';
		if (is_readable($filename))
			require $filename;
		else
			include BASE_DIR . 'core/' . $classname . '.php';
	}
}
function getBrowser() {
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version = "";

	//First get the platform?
	if (preg_match('/linux/i', $u_agent)) {
		$platform = 'linux';
	} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		$platform = 'mac';
	} elseif (preg_match('/windows|win32/i', $u_agent)) {
		$platform = 'windows';
	}

	// Next get the name of the useragent yes seperately and for good reason
	if ((preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) || preg_match('<Trident/7.0; rv:11.0>i', $u_agent)) {
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	} elseif (preg_match('/Firefox/i', $u_agent)) {
		$bname = 'Mozilla Firefox';
		$ub = "Firefox";
	} elseif (preg_match('/Chrome/i', $u_agent)) {
		$bname = 'Google Chrome';
		$ub = "Chrome";
	} elseif (preg_match('/Safari/i', $u_agent)) {
		$bname = 'Apple Safari';
		$ub = "Safari";
	} elseif (preg_match('/Opera/i', $u_agent)) {
		$bname = 'Opera';
		$ub = "Opera";
	} elseif (preg_match('/Netscape/i', $u_agent)) {
		$bname = 'Netscape';
		$ub = "Netscape";
	} else {
		$bname = 'Other';
		$ub = "Other";
	}

	// finally get the correct version number
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (preg_match_all($pattern, $u_agent, $matches)) {
		// we have no matching number just continue
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
				$version = isset($matches['version'][0]) ? $matches['version'][0] : '';
			} else {
				$version = isset($matches['version'][1]) ? $matches['version'][1] : '';
			}
		} else {
			$version = isset($matches['version'][0]) ? $matches['version'][0] : '';
		}
	}
	// see how many we have
	// check if we have a number
	if ($version == null || $version == "") {
		if (preg_match('<Trident/7.0; rv:11.0>i', $u_agent))
			$version = "11.0";
		else
			$version = "?";
	}

	return array(
		'userAgent' => $u_agent,
		'name' => $bname,
		'version' => $version,
		'platform' => $platform,
		'pattern' => $pattern
	);
}

function logtxt($var1, $var2 = '',$var3 = '',$var4 = '',$var5 = '') {
	// Ouvre un fichier pour lire un contenu existant
	$file = fopen(BASE_DIR . 'log.txt', "a");
	// Ajoute
	fwrite($file, '=======================================================================================' . PHP_EOL);
	fwrite($file, date('d/m/Y - H:i:s') . PHP_EOL);
	fwrite($file, '=======================================================================================' . PHP_EOL);
	fwrite($file, print_r($var1, true) . PHP_EOL);
	if (!empty($var2)) {
		fwrite($file, "--------------------------------------------------------------------------------------" . PHP_EOL);
		fwrite($file, print_r($var2, true) . PHP_EOL);
	}
	if (!empty($var3)) {
		fwrite($file, "--------------------------------------------------------------------------------------" . PHP_EOL);
		fwrite($file, print_r($var3, true) . PHP_EOL);
	}
	if (!empty($var4)) {
		fwrite($file, "--------------------------------------------------------------------------------------" . PHP_EOL);
		fwrite($file, print_r($var4, true) . PHP_EOL);
	}
	if (!empty($var5)) {
		fwrite($file, "--------------------------------------------------------------------------------------" . PHP_EOL);
		fwrite($file, print_r($var5, true) . PHP_EOL);
	}
	fclose($file);
}

function logsql($sql) {
	// Ouvre un fichier pour lire un contenu existant
	$file = fopen(BASE_DIR . 'logsql.txt', "a");
	// Ajoute
	fwrite($file, date('d/m/Y - H:i:s') . " -> " . $sql . PHP_EOL);
	fclose($file);
}

function debug($var, $var2 = '') {
	$_SESSION ['debugs'] = print_r($var, true);
	if (isset($var2))
		$_SESSION ['debugs'] .= '     ' . print_r($var2, true);
}

function sql_escape($string) {
	$chars = array('NULL', '\x00', '\n', '\r', '\\', "'", '"', '\x1a');
	$escapes = array('\NULL', '\\x00', '\\n', '\\r', '\\\\', "''", '\"', '\\x1a');
	return str_replace($chars, $escapes, $string);
}

function dateverssql($string, $formatorigine = 'd/m/Y', $formatdestination = 'Y-m-d') {
	$date = date_create_from_format($formatorigine, $string);
	if (is_object($date))
		return $date->format($formatdestination);
	else
		return $string;
}

function datevershtml($string, $formatorigine = 'Y-m-d', $formatdestination = 'd/m/Y') {
	if ($string=='0000-00-00') return '';
	$date = date_create_from_format($formatorigine, $string);
	if (is_object($date))
		return $date->format($formatdestination);
	else
		return $string;
}

function dat($date) {
	if (!empty($date) && $date != "1900-01-01")
		return strftime('%d/%m/%Y', strtotime($date));
	else
		return '';
}

function num($num, $n = 2) {
	if ($num != 0) {
		if ($n > 0)
			return str_replace('.', ',', sprintf('%.' . $n . 'f', $num));
		else
			return

					sprintf('%d', $num);
	} else
		return '';
}

function strtodate($datestr) {
	$datestr = str_replace('/', '-', $datestr);
	return strtotime($datestr);
}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir . "/" . $object) == "dir")
					rrmdir($dir . "/" . $object);
				else
					unlink($dir . "/" . $object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

function array_copie($array1, $array2) {
	foreach (array_keys($array1) as $key) {
		if (isset($array1 [$key]) && isset($array2 [$key]))
			$array1 [$key] = $array2 [$key];
	}
	return $array1;
}
function array_ajoute($array1, $array2) {
	foreach (array_keys($array2) as $key) {
		if (!isset($array1 [$key]))
			$array1 [$key] = $array2 [$key];
	}
	return $array1;
}

if (!function_exists('array_column')) {

	/**
	 * Returns the values from a single column of the input array, identified by
	 * the $columnKey.
	 *
	 * Optionally, you may provide an $indexKey to index the values in the returned
	 * array by the values from the $indexKey column in the input array.
	 *
	 * @param array $input
	 *        	A multi-dimensional array (record set) from which to pull
	 *        	a column of values.
	 * @param mixed $columnKey
	 *        	The column of values to return. This value may be the
	 *        	integer key of the column you wish to retrieve, or it
	 *        	may be the string key name for an associative array.
	 * @param mixed $indexKey
	 *        	(Optional.) The column to use as the index/keys for
	 *        	the returned array. This value may be the integer key
	 *        	of the column, or it may be the string key name.
	 * @return array
	 */
	function array_column($input = null, $columnKey = null, $indexKey = null) {
		// Using func_get_args() in order to check for proper number of
		// parameters and trigger errors exactly as the built-in array_column()
		// does in PHP 5.5.
		$argc = func_num_args();
		$params = func_get_args();
		if ($argc < 2) {
			trigger_error(" array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
			return null;
		}
		if (!is_array($params [0])) {
			trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params [0]) . ' given', E_USER_WARNING);
			return null;
		}
		if (!is_int($params [1]) && !is_float($params [1]) && !is_string($params [1]) && $params [1] !== null && !(is_object($params [1]) && method_exists($params [1], '__toString'))) {
			trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		if (isset($params [2]) && !is_int($params [2]) && !is_float($params [2]) && !is_string($params [2]) && !(is_object($params [2]) && method_exists($params [2], '__toString'))) {
			trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		$paramsInput = $params [0];
		$paramsColumnKey = ($params [1] !== null) ? (string) $params [1] : null;
		$paramsIndexKey = null;
		if (isset($params [2])) {
			if (is_float($params [2]) || is_int($params [2])) {
				$paramsIndexKey = (int) $params [2];
			} else {
				$paramsIndexKey = (string) $params [2];
			}
		} $resultArray = array();
		foreach ($paramsInput as $row) {
			$key = $value = null;
			$keySet = $valueSet = false;
			if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
				$keySet = true;
				$key = (string) $row [$paramsIndexKey];
			}
			if ($paramsColumnKey === null) {
				$valueSet = true;
				$value = $row;
			} elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
				$valueSet = true;
				$value = $row [$paramsColumnKey];
			}
			if ($valueSet) {
				if ($keySet) {
					$resultArray [$key] = $value;
				} else {
					$resultArray [] = $value;
				}
			}
		}
		return $resultArray;
	}

}

function fmt_numtel($numtel, $international = false) {
	/**
	 * *********************************************
	 * Format n° tel
	 * *********************************************
	 */
	// Supprimer tous les caractères qui ne sont pas des chiffres
	$numtel = preg_replace('/[^0-9]+/', '', $numtel);
	// Garder les 9 derniers chiffres
	$numtel = substr($numtel, - 9);
	// On ajoute +33 si la variable $international vaut true et 0 dans tous les autres cas
	$motif = $international ? '+33 (\1) \2 \3 \4 \5' : '0\1 \2 \3 \4 \5';
	$numtel = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $numtel);

	return $numtel;
}
