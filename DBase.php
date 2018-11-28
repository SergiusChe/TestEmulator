<?php
	class DBase
	{
		public static function open($fname)
		{
			$file = $fname;
			fclose(fopen($file, "a+b"));
			$f = fopen($file, "r+b");
			flock($f, LOCK_EX);
			return $f;
		}
	
		public static function close($f)
		{
			fflush($f);
			flock($f,LOCK_UN);
			fclose($f);
		}

		public static function getStr($f)
		{
			$arr = array();
			while (($buffer = fgets($f, 4096)) !== false) $arr[] = $buffer;
			return $arr;		
		}

		public static function calls($f)
		{
			$arr = array();
			$strs = self::getStr($f);
			foreach ($strs as $str)
			{
				$words = explode("	", $str);
				$i = $words[0];
				$arr[$i]['id'] = $i;
				$arr[$i]['calls'] =  trim($words[1]);
			}		
			return $arr;
		}

		public static function putCalls($f, $arr)
		{
			ftruncate($f, 0);
			rewind($f);
			foreach ($arr as $el)
			{	
				$str = $el['id'] . "\t" . $el['calls'] . "\n";
				fwrite($f, $str);
			}
		}
	
		public static function stat($f)
		{
			$stat = array();
			$strs = self::getStr($f);
			$num = 1;
			foreach ($strs as $str)
			{
				$words = explode("	", $str);
				$i = $words[0];
				$stat[$i]['num'] = $i;
				$stat[$i]['iq'] =  $words[1];
				$stat[$i]['range'] =  $words[2];
				$stat[$i]['X'] =  trim($words[3]);
				$num++;
			}
			return array($num, $stat);
		}

		public static function putStat($f, $stat)
		{
			ftruncate($f, 0);
			rewind($f);
			foreach ($stat as $el)
			{	
				$str = $el['num'] . "\t" . $el['iq'] . "\t" . $el['range'] . "\t" . $el['X'] . "\n";
				fwrite($f, $str);
			}
		}
	}
?>
