<?php defined('BASEPATH') OR exit('No direct script access allowed.');
	
	if(!function_exists('time_unix')){
		function time_unix()	{
			return strtotime(date('Y-m-d H:i:s'));
		}
	}

?>