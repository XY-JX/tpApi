<?php

class openssl
{
    protected static $private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC3//sR2tXw0wrC2DySx8vNGlqt3Y7ldU9+LBLI6e1KS5lfc5jl
TGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2klBd6h4wrbbHA2XE1sq21ykja/
Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o2n1vP1D+tD3amHsK7QIDAQAB
AoGBAKH14bMitESqD4PYwODWmy7rrrvyFPEnJJTECLjvKB7IkrVxVDkp1XiJnGKH
2h5syHQ5qslPSGYJ1M/XkDnGINwaLVHVD3BoKKgKg1bZn7ao5pXT+herqxaVwWs6
ga63yVSIC8jcODxiuvxJnUMQRLaqoF6aUb/2VWc2T5MDmxLhAkEA3pwGpvXgLiWL
3h7QLYZLrLrbFRuRN4CYl4UYaAKokkAvZly04Glle8ycgOc2DzL4eiL4l/+x/gaq
deJU/cHLRQJBANOZY0mEoVkwhU4bScSdnfM6usQowYBEwHYYh/OTv1a3SqcCE1f+
qbAclCqeNiHajCcDmgYJ53LfIgyv0wCS54kCQAXaPkaHclRkQlAdqUV5IWYyJ25f
oiq+Y8SgCCs73qixrU1YpJy9yKA/meG9smsl4Oh9IOIGI+zUygh9YdSmEq0CQQC2
4G3IP2G3lNDRdZIm5NZ7PfnmyRabxk/UgVUWdk47IwTZHFkdhxKfC8QepUhBsAHL
QjifGXY4eJKUBm3FpDGJAkAFwUxYssiJjvrHwnHFbg0rFkvvY63OSmnRxiL4X6EY
yI9lblCsyfpl25l7l5zmJrAHn45zAiOoBrWqpM5edu7c
-----END RSA PRIVATE KEY-----';

    protected static $public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o
2n1vP1D+tD3amHsK7QIDAQAB
-----END PUBLIC KEY-----';

    protected static $private_key1 = '-----BEGIN PRIVATE KEY-----
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
Huy+sJHznPYpWjX7VYh5nbpgHABH8g==
-----END PRIVATE KEY-----
';
    protected static $public_key1 = '-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAy4s/UyUjWUKdM0dQhvBV
EZXJcKFvjJ3j9pNZJvMdtpZsncRFG8hH/tatzQiThX7tKhNy7fJAKqBXZ0t/yClo
awoIPq7WP+OrsxUew8z5IXAUxEERn4CZtZM6OoNH7QJp6BJbCFvWvXi8H1YqWb0H
MWn2ZbxSqY/Eq0Ik3oHp0+6EMgY7kr1ovzC0Gw2GPIRUV36g1ljpoCkTQQsgS6T3
DNzNAyyQI4xSjHnmZMrCAfsAv46do8cH2WwF37L8MqBtddINnO267Bp0V/AUq93n
E0jbNG1V0P/U67BazdRpmhTqXti95yhYpAhnMPun5sgx2ld1rsy25hzHyQxQEx4m
z7xohh+HzGz07kC9+tw5EMJWXfeyXnU5fQKVPgD85atX+J4d/DJMzZUhG8Z4h4Rw
3YMW2Nkutk1leRkk2s4/hbw2+wH2v+q89NhlGftvEC/ntUO3TPqIft2v1lR5FqhG
b5MKsWAAEeUnm4pkWMuOPxnak96itPcBwBkRrWc6c+Tas2t++ylbugBVFP85TLBa
ufZa0tCqX+rYwm2riNlneks5okhvxZ8G6biiCEVwj4PjxFx3e/6e6I8gdtyEbsF3
jjGzmOG14vHmMGqKK4tjhat0sE9YmgFDXwItV8xgxZtPNxYcvzQStPp1zXUE9gbc
tCu7Hh2/kGFNQmB+oj09auMCAwEAAQ==
-----END PUBLIC KEY-----';

//    1024   117   128
//    2048   245   256
//    4096   501   512

    protected static function level($level = 1024)
    {
        $array = [
            1024 => [117, 128],//1024字节密钥  1024/8-11  1024/8
            2048 => [245, 256],//2048字节密钥  2048/8-11  2048/8
            4096 => [501, 512],//4096字节密钥  4096/8-11  4096/8
        ];
        return $array[$level];
    }

    /**
     * 公钥加密
     * @param array $data
     * @param int $level
     * @return string
     */
    public static function encrypt(array $data, int $level = 1024)
    {
        $crypto = '';
        foreach (str_split(json_encode($data), self::level($level)[0]) as $chunk) {
            openssl_private_encrypt(($chunk), $encrypted, self::$private_key1);//私钥加密
            $crypto .= $encrypted;
        }
        return base64_encode($crypto);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
    }

    /**
     * 私钥解密
     * @param string $encrypted
     * @param int $level
     * @return mixed
     */
    public static function decrypt(string $encrypted, int $level = 1024)
    {
        $crypto = '';
        foreach (str_split(base64_decode($encrypted), self::level($level)[1]) as $chunk) {
            openssl_public_decrypt($chunk, $decrypted, self::$public_key1);//私钥加密的内容通过公钥可用解密出来
            $crypto .= $decrypted;
        }
        return json_decode($crypto);
    }
}