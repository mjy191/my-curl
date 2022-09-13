## 1.基本介绍
### 1.1 项目介绍
> 基于laravel框架 curl请求，记录请求日志、返回数据日志，错误日志

### 1.2 配置
新建app/Exceptions/ApiException.php
捕获ApiException抛出的异常进行处理
```
namespace App\Exceptions;

use Mjy191\Tools\Tools;
use Exception;

class ApiException extends Exception
{
    /**
     * 转换异常为 HTTP 响应
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json(Tools::returnData(null,$this->getCode(),$this->getMessage()))->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
```

## 1.3 请求日志查询
日志均保存在logs目录下
通过logid aaaaaa 查询
```$xslt
grep aaaaaa *
2082207.log:2022-08-22 07:24:50 uri[/api/order/payInfo?sign=xxx] logid[aaaaaa] curl[url[https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi] method[post] params[{"appid":"xxx","mchid":"xxx","description":"xxxx","out_trade_no":"testxxx","notify_url":"https:\/\/xxx.xxx.com\/api\/wx\/paynotify\/111111","amount":{"total":9000},"payer":{"openid":"xxxxx"}}] header[["Content-Type:application\/json; charset=UTF-8","Accept:application\/json","User-Agent:*\/*","Authorization: WECHATPAY2-SHA256-RSA2048 mchid=\"xxxx\",serial_no=\"xxxxx\",nonce_str=\"xxxx\",timestamp=\"xxxx\",signature=\"xxxxx\""]]]
2022082207.log:2022-08-22 07:24:50 uri[/api/order/payInfo?sign=xxx] logid[aaaaaa] curl response[{"prepay_id":"xxxxxxxxx"}]
2022082207.log:2022-08-22 07:24:50 uri[/api/order/payInfo?sign=xxx] logid[aaaaaa] response[{"code":1,"msg":"success","data":{"appId":"xxxx","timeStamp":"xxxx","nonceStr":"xxxxxx","package":"prepay_id=xxxxx","signType":"RSA","paySign":"xxxx"},"timestamp":xxxx}]

```

### 1.4 安装
```
composer require mjy191/my-curl
```
