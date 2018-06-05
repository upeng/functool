<?php


function curl_get($url)
{
    $ch = curl_init();
     
    curl_setopt($ch, CURLOPT_URL, $url);
    
    $header = [];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置头文件的信息作为数据流输出
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回，而不是直接输出。
    
    $data = curl_exec($ch);
    
    curl_close($ch);
    
    return $data;
}


function curl_post($url, $postData = array())
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, 1); //设置头文件的信息作为数据流输出
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回，而不是直接输出。
    
    curl_setopt($ch, CURLOPT_POST, 1);//设置post方式提交

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $data = curl_exec($ch);
    curl_close($ch);
    
    return $data;
}


//参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
function curl_request($url, $post = '', $cookie = '', $returnCookie = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_REFERER, "http://XXX");
    if($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    if($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    curl_setopt($ch, CURLOPT_HEADER, $returnCookie);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        return curl_error($ch);
    }
    curl_close($ch);
    if($returnCookie){
        list($header, $body) = explode("\r\n\r\n", $data, 2);
        preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
        $info['cookie']  = substr($matches[1][0], 1);
        $info['content'] = $body;
        return $info;
    }else{
        return $data;
    }
}
