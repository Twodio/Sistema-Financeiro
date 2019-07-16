<?php

$url = "https://www.situacaocadastral.com.br/";

$doc = "435.896.168-14";
$id = "d6b82ff1638b3451c69fdd72564e7caf";
$us = "74be16979710d4c4e7c6647856088456";

$ckfile = tempnam ("/", "cookie.txt");
$target_host = "https://www.situacaocadastral.com.br";
$target_request = "/index.php";

$login = curl_init ();

curl_setopt($login, CURLOPT_COOKIESESSION, 1);

curl_setopt($login, CURLOPT_COOKIE, "$id=0;id=$id;USID=$us");

curl_setopt($login, CURLOPT_RETURNTRANSFER, 1);        
curl_setopt($login, CURLOPT_URL, $url);
curl_setopt($login, CURLOPT_HEADER, 1);        
curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($login, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($login, CURLOPT_POST, 1);
curl_setopt($login, CURLOPT_POSTFIELDS, [
    doc => $doc,
    $id => 0,
    USID => $us
]);

echo curl_exec($login);

curl_close($login);  