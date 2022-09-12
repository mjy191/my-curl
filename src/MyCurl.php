<?php
namespace Mjy191\MyCurl;

use Mjy191\Enum\Enum;
use App\Exceptions\ApiException;
use Mjy191\MyLogs\MyLogs;

class MyCurl {

    /**
     * curl请求
     * @param $url
     * @param string $method
     * @param string $params
     * @param array|null $header
     * @param bool $resLog
     * @param bool $reqLog
     * @param bool $errLog
     * @return bool|string
     * @throws ApiException
     */
    public static function send($url, $method='get', $params='', array $header=null, $resLog=true, $reqLog=true, $errLog=true){
        $reqLog && (MyLogs::write('curl',"url[{$url}] method[{$method}] params[".MyLogs::toString($params)."] header[".MyLogs::toString($header)."]"));
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);     // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     // 获取的信息以文件流的形式返回
        if($header){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //模拟的header头
        }
        if($method=='post'){
            curl_setopt($ch, CURLOPT_POST, true); // 发送一个常规的Post请求
            if($params){
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);     // Post提交的数据包
            }
        }
        $result = curl_exec($ch);
        $resLog && (MyLogs::write('curl response',$result));
        $getInfo = curl_getinfo($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        if($errno!=0){
            $errLog && (MyLogs::write('curl error',"errno[".MyLogs::toString($errno)."] error[".MyLogs::toString($error)."] info[".MyLogs::toString($getInfo)."]"));
            throw new ApiException('系统错误',Enum::erCodeServer);
        }
        curl_close($ch);
        return $result;
    }
}
