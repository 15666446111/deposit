<?php

/**
 *  支付宝配置
 */

return [
    //app_id
    'app_id'        =>  env('ALIPAY_APPID', '2017122001013151'),

    //商户私钥
    'private_key'   =>  env('ALIPAY_PRI_KEY', 'MIIEpAIBAAKCAQEAqfpn6X/xBiXal2foVhyECOjncUy2dg0TE3bnqJnT1DOUvZU5wgpquNH+q4E0WIRaGzAG/5IfMk5/FNu9xKF208hBupFV1w2TxHrIzw4dTDne1ew6W9ZoIkTUk4JD0OWwsCsdv0A0P24F8uCfjBncI05lsKCWDAY1vI0lLWoS8Qf7kg/IOajJ/dzwkPu+eUrztx9dm0rxh19oOUG7whLXi5eBWiUDgSjbHdqqYNb3VxEM9NQu+6XJTREkCvHZszDEyxLEUP0dotT8D0M9tiX1BmCjzHnVxTp7jZyR6KsyGYhk1XsIXNLh9bK7sNeCX8M4AcPysdoNGpy2BIJ8fLr75QIDAQABAoIBAQCPYhaTpoQ3bmkVPOaE9Sr/pQ/OyCpGLMNBsRS7aX+Byj0XKzD8mPLrkuCj5aq1XHfx5TKSFb3RHtweSTqsCpQFFDE14vEpJl/W5shLuRlHuq1ZgRq9a4COH8e94q24InlIMia2tL8eHn5QIeEUOqAy/CfVtbC81eQweFO7GnZ98J/muwXsibpovM8IxQeOJtqtbrxeMNicvrmQi1Y2t4I9KyWmImisRy/QAAFvn98utHxZyQ9K/Dto61uO+Ao6+byi+UXh6vWXjVBr0g90kJxnsPShcXaTgnzh9EZWZQeICFsRfvqp12NUP4VhXGCU1X/SW45PHdBc54A8hfXa6VuFAoGBAOGiBeVaHB21uIz/kNZAiGiDtCW4lXIyhzygMObCYhvnc65uTQOFzkGmszvHRvDZAYRD9kMgJRJhGtMeN0qTHv6b/gESZo/cgSJOJpKn+P80uobbvLon7MroAun1Vff0lEETWB94IKZOH/5awx7PhJ1zCRUlWb5vfZXFdOtmlywjAoGBAMDa2UsGVofmlfaGnSTvKXsUeqTm/Jy71tu+m4Ev6nudHQSBdRWEIdADsnoBzHPW68s2623DRI9HBr0y27NBClDcgt0BGPdjyBrbY5rZfwtjLnHNE70/89j/NWGR2/Z9QLLpviBEr6cmLX/60r1PeD0/zV8OwhM+ZcfjMBnT2tRXAoGAKlmr+6GPN3BdZHGvsNdKAzv9OztLKbUcNx/mLdn8ajpmNy5S3D9oOGBesfC0ew5wP3A2L+E/tBRv4YKBZEj6/1UuNutKPuRnhJXgnZRToys1e4yQ/uvxgSBNM7at3S2WCiTkXHvCvRRa4vYMO6M9xAPMh6CMGLd6ffsi9/A4nbsCgYEAt+u+0SsROPgySnKkyUWA1M16DWvwu/Tz+ot0OCcfQ5ZZxyNDKyrhKEVuX6b5efwc0aflrL9N0iqVhbhMCE7d7LHv558VVVGG0/4optQHsi97arJ+wbyM7ISvPwbgtNlM65O5a4K11f215NirRDnW3OrNDHvBoKKgZJoJFIiTqG8CgYB7NlVOqkHVwXEAL6hw7q0dAWTU4K/0m8/uEdJnvYsfcaqHeCwjimSElcvO45saHqN5Npzv6u0PvDbJQ7iNF108vb3plg1qswtN063/PhspAMLFvqmW+CRBis/3le3bIPxJEmwMnmRvfTwlQDucX5nXalsmIlHao+RS0YBLYivbxw=='),

    // 商户公钥
    'public_key'    =>  env('ALIPAY_PUB_KEY', 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqfpn6X/xBiXal2foVhyECOjncUy2dg0TE3bnqJnT1DOUvZU5wgpquNH+q4E0WIRaGzAG/5IfMk5/FNu9xKF208hBupFV1w2TxHrIzw4dTDne1ew6W9ZoIkTUk4JD0OWwsCsdv0A0P24F8uCfjBncI05lsKCWDAY1vI0lLWoS8Qf7kg/IOajJ/dzwkPu+eUrztx9dm0rxh19oOUG7whLXi5eBWiUDgSjbHdqqYNb3VxEM9NQu+6XJTREkCvHZszDEyxLEUP0dotT8D0M9tiX1BmCjzHnVxTp7jZyR6KsyGYhk1XsIXNLh9bK7sNeCX8M4AcPysdoNGpy2BIJ8fLr75QIDAQAB'),

    // 支付宝公钥
    'alipay_pub_key'=>  env('ALIPAY_PUB_KEY_Ali', "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAt0UwDpyne+hDFjS7PzAZgPompNwimVU/Fhzpz+HQF3RTWvbirV28pt+hX9eyL+Y+cUBT0tLr4gG2tQS+vmN5ZqSbTBKkV38G/QFqdLV/6U8+opWzKMkt9HoD3+22Idk/9uL4v5dKqBRDe5D5dnRcVuUxpMFVbLZZv+O4VuU1KKd/AfJbcSGANrLcO7FVgjAfl59VWSI/3UWz2+M+de6csRGWso3H3wQ9KeaO82+USQu2120OSux+ghgifbIvT4dLZyfOvr6/oDX8+KgR6etsQ+DtQFzD+8S9HGDivtEex4PASbepxj4pCpoDtJno9N23eKLGjkMrngTybE9dLcO6qwIDAQAB"),

    //网关地址
    'gatewayUrl'    =>  env('ALIPAY_GATWAY', 'https://openapi.alipay.com/gateway.do'),

    //字符编码
    'charset'       =>  env('ALIPAY_CHARSET', 'UTF-8'),

    //签名方式
    'sign_type'     =>  'RSA2',
    'amounts' => [
        'default'=>100,
        'ls'=>100,
        'jr'=>1000,
        'rx'=>5000,
    ],

];
