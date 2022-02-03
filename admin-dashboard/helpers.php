<?php

/**
 * دامین را به آدرس داده شده می چسباند
 * @param string $src
 * @return string
 */
function asset($src)
{
    $domain = trim(CURRENT_DOMAIN, "/"); 
    $src = $domain . "/" . trim($src, "/");
    return $src;
}
function url($url)
{
    $domain = trim(CURRENT_DOMAIN, "/");
    $url = $domain . "/" . trim($url, "/");
    return $url;
}
function protocol()
{
    return stripos($_SERVER["SERVER_PROTOCOL"], "https") ? "https://" : "http://";
}
function currnetDomain()
{
    return protocol() . $_SERVER["HTTP_HOST"]; // قسمت دوم در واقع دامین ما را می دهد
}
function currentUrl()
{
    return currnetDomain() . $_SERVER["REQUEST_URI"]; // قسمت دوم هر چه بعد از دامین هست را بر می گرداند
    // حتی اسلش هم بر می گردد به این ترتیب ما آدرس کامل را داریم
}
function methodFiled()
{
    return $_SERVER["REQUEST_METHOD"]; // get or post مشخص می کند
}
