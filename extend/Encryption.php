<?php
class Encryption
{

    private static $method = 'aes-256-xts';
    private static $key = 'dd2b1fa5a39b9051fb1982';
    private static $iv = 'encrypt@decrypt@';//请保证16位
    private static $options = OPENSSL_ZERO_PADDING;

    /**
     * 解密
     * @param string $data
     * @param string $iv
     * @return array
     */
    public static function decrypt(string $data, string $iv = '')
    {
        $openssl_decrypt = openssl_decrypt($data, self::$method, self::$key, self::$options, $iv ?: self::$iv);
        if (false === $openssl_decrypt) {
            return ['code' => 0, 'data' => [], 'msg' => '解密失败'];
        } else {
            return ['code' => 1, 'data' => json_decode($openssl_decrypt, true), 'msg' => '解密成功'];
        }
    }

    /***
     * 加密
     * @param array $data
     * @param string $iv
     * @return array
     */
    public static function encrypt(array $data, string $iv = '')
    {
        $openssl_encrypt = openssl_encrypt(json_encode($data), self::$method, self::$key, self::$options, $iv ?: self::$iv);
        if (false === $openssl_encrypt) {
            return ['code' => 0, 'data' => [], 'msg' => '字符长度不能少于16位，目前长度' . strlen($data) . '位)'];
        } else {
            return ['code' => 1, 'data' => $openssl_encrypt, 'msg' => '加密成功'];
        }
    }

    /**
     * 解密
     * @param string $encryptedData
     * @param string $iv
     * @return array
     */
    public static function long_decrypt(string $encryptedData, $iv = '')
    {
        $result = '';
        foreach (str_split($encryptedData, 880) as $chunk) {
            $result .= openssl_decrypt($chunk, self::$method, self::$key, self::$options, $iv ?: self::$iv);
        }
        if ($result) {
            return ['code' => 1, 'data' => json_decode($result, true), 'msg' => '解密成功'];
        } else {
            return ['code' => 0, 'data' => [], 'msg' => '解密失败'];
        }
    }

    /**
     * 加密
     * @param array $encryptedData
     * @param string $iv
     * @return array
     */
    public static function long_encrypt(array $encryptedData, string $iv = '')
    {
        $result = '';
        foreach (str_split(json_encode($encryptedData), 660) as $chunk) {
            $result .= openssl_encrypt($chunk, self::$method, self::$key, self::$options, $iv ?: self::$iv); //第四参数OPENSSL_RAW_DATA输出原始数据
        }
        if ($result) {
            return ['code' => 1, 'data' => $result, 'msg' => '加密成功'];
        } else {
            return ['code' => 0, 'data' => [], 'msg' => '加密失败,加密内容太短了'];
        }
    }
}