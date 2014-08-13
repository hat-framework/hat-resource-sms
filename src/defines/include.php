<?php

function simple_curl($url,$post=array(),$get=array(),$http=array(), $buildQuery = true, $timeout = 0){
	$url = explode('?',$url,2);
	if(count($url)===2){
            $temp_get = array();
            parse_str($url[1],$temp_get);
            $get = array_merge($get,$temp_get);
	}
	$ch = curl_init($url[0]."?".http_build_query($get));
        if($timeout > 0) {curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);}
        if(!empty($post)){
            $post = ($buildQuery)?http_build_query($post):$post;
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if(!empty($http)) {curl_setopt($ch, CURLOPT_HTTPHEADER, $http);}
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$var = curl_exec($ch);
        if($var === false){
            simple_curl_error(curl_error($ch));
        }
        curl_close($ch);
        return $var;
}
