<?php
#FILE INCLUDE URL
/* FUNCTION CURL */
function cURL($url){
    $cookies = 'log_curl.txt';
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
    curl_setopt($ch,CURLOPT_TCP_NODELAY,true);      
    curl_setopt($ch,CURLOPT_REFERER,'https://graph.fb.me/');                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/601.6.17 (KHTML, like Gecko) Version/9.1.1 Safari/601.6.17');
    curl_setopt($ch,CURLOPT_COOKIEFILE,$cookies);
    curl_setopt($ch,CURLOPT_COOKIEJAR,$cookies);
    // if($method == 'POST'){
    //     curl_setopt($ch, CURLOPT_POST, count($fields));
    //     curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);  
    // }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    return curl_exec($ch);
    curl_close($ch);
}
/* GET URL */
$url = $_GET['url'];
/* SHOW */
echo cURL($url);
