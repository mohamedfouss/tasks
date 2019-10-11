<?php
$path = dirname(__FILE__);
$file = $path.'/scpi.txt';
$str = file_get_contents($file);
//echo '<pre>';
if($str)
{
	$ex = explode('__pp__', $str);
	foreach($ex as $k => $v)
	{
		//echo $v."\r\n";
		if(
			strstr($v, 'centraledesscpi.com')
			&& !strstr($v, 'facebook.com')
			&& !strstr($v, 'google.com')
		)
		{
			$ex2 = explode(',', $v);
			if($ex2[0] && $ex2[1])
			{
				$url1 = $ex2[0];
				$url2 = $ex2[1];
				$url1 = str_replace('"', '', $url1);
				$url2 = str_replace('"', '', $url2);
				
				echo $url1.";".$url2.";\r\n";
				
			}		
		}
	}
	
}