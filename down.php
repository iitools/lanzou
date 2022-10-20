<?php
//取出中间文本
function getSubstr($str, $leftStr, $rightStr)
{
$left = strpos($str, $leftStr);
//echo '左边:'.$left;
$right = strpos($str, $rightStr,$left);
//echo '<br>右边:'.$right;
if($left < 0 or $right < $left) return '';
return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}
//构造http请求
function http_get($url){
$oCurl = curl_init();
$user_agent = "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1";
if(stripos($url,"https://")!==FALSE){
curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
}
curl_setopt($oCurl, CURLOPT_USERAGENT,$user_agent);
curl_setopt($oCurl, CURLOPT_URL, $url);
curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
$sContent = curl_exec($oCurl);
$aStatus = curl_getinfo($oCurl);
curl_close($oCurl);
if(intval($aStatus["http_code"])==200){
return $sContent;
}else{
return false;
}
}
if(isset($_GET['url'])){
$web = http_get(str_replace("com/","com/tp/",$_GET['url']));
$domianload = getSubstr($web,"domianload = '","';");
$downloads = getSubstr($web,"downloads = '","';");
$url = $domianload.$downloads;
//直接下载使用下面这句
//header("Location: ".$url);
//显示下载链接使用下面这句
echo $url;
}
?>
