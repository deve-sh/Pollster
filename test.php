<?php
   $url="http://localhost.com/encoe my string";

    function urlify($url){
    	$str="";
    	for($i=0;$i<strlen($url);$i++){
    		if($url[$i]==" ")
    		{
    			$str.="%20";
    			continue;
    		}
    		$str.=$url[$i];
    	}
    	return $str;
    }

	echo urlify($url);
?>