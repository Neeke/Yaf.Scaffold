<?php
class rest_Code
{
    /**
     * ErrorCode < 1000 ,没有进入正常处理逻辑
     */
    const STATUS_ERROR = 900; //开发者末定义错误
    const STATUS_ERROR_VESION = 901; //版本错误
    const STATUS_ERROR_API_EXISTS = 909; //接口不存在

    const STATUS_ERROR_TIMEOUT = 910; //请求超时
    const STATUS_ERROR_TIMEOUT_DB = 911; //数据库连接失败
    const STATUS_ERROR_TIMEOUT_KV = 912; //KV连接失败

    const STATUS_ERROR_FILE = 920; //资源权限错误
    const STATUS_ERROR_DIR_EXISTS = 921; //目录权限不足
    const STATUS_ERROR_FILE_EXISTS = 922; //文件权限不足

    const STATUS_ERROR_PARAMS = 930; //参数错误
    const STATUS_ERROR_PARAMS_MUST = 931; //参数丢失(同时列举需要的参数)
    const STATUS_ERROR_PARAMS_CAN = 932; //参数超出范围(同时列举超出的参数)
    const STATUS_ERROR_METHOD = 939; //不接受的请求类型

    const STATUS_ERROR_PARAMS_VALIDE = 940; //参数验证非法

    const STATUS_ERROR_FILE_VALIDE = 950; //文件验证失败
    const STATUS_ERROR_FILE_VALIDE_TYPE = 951; //不接受的文件类型
    const STATUS_ERROR_FILE_VALIDE_MAX = 952; //文件过大
    const STATUS_ERROR_FILE_VALIDE_MIN = 953; //文件过小

    const STATUS_ERROR_API_QUENCY = 960; //请求频次预警
    const STATUS_ERROR_API_QUENCY_M = 961; //api/单位时间超出频次　分
    const STATUS_ERROR_API_QUENCY_H = 962; //api/单位时间超出频次　小时
    const STATUS_ERROR_API_QUENCY_IP_M = 963; //api/单位时间&IP请求超出频次 分
    const STATUS_ERROR_API_QUENCY_IP_H = 964; //api/单位时间&IP请求超出频次　小时

    const STATUS_ERROR_API_VALIDE = 990; //api权限不足
    const STATUS_ERROR_API_VALIDE_TIME = 991; //时间戳错误
    const STATUS_ERROR_API_VALIDE_SIGN = 992; //sign算法不合法
    const STATUS_ERROR_API_VALIDE_AUTH = 993; //auth拒绝请求
    const STATUS_ERROR_API_VALIDE_SESSION = 998; //session失效
    const STATUS_ERROR_API_VALIDE_TOKEN = 999; //token失效

    /**
     * ErrorCode >= 1000 ,成功请求,并进入正常逻辑
     */
    const STATUS_SUCCESS = 1000; //请求成功,逻辑处理成功

    const STATUS_SUCCESS_DO_ERROR = 1001; //请求成功,逻辑处理失败,末定义错误
    const STATUS_SUCCESS_DO_ERROR_DB = 1100; //请求成功,数据库错误
    const STATUS_SUCCESS_DO_ERROR_DB_REPEAT = 1101; //记录重复
    const STATUS_SUCCESS_DO_ERROR_DB_NULL = 1102; //记录不存在
    const STATUS_SUCCESS_DO_ERROR_DB_UFALSE = 1103; //更新失败
    const STATUS_SUCCESS_DO_ERROR_DB_RFALSE = 1104; //查询失败
    const STATUS_SUCCESS_DO_ERROR_DB_DFALSE = 1105; //删除失败
    const STATUS_SUCCESS_DO_ERROR_DB_TIMEOUT = 1106; //响应超时

    const STATUS_SUCCESS_DO_ERROR_KV = 1200; //KV操作错误
    const STATUS_SUCCESS_DO_ERROR_KV_TIMEOUT = 1201; //KV响应超时

    const STATUS_SUCCESS_DO_ERROR_FILE = 1300; //文件操作失败
    const STATUS_SUCCESS_DO_ERROR_FILE_DODIR = 1301; //目录权限不足
    const STATUS_SUCCESS_DO_ERROR_FILE_DOFILE = 1302; //文件权限不足

    /**
     * ErrorCode => ErrorMsg
     */
    protected static $status_msgs = array(
        self::STATUS_ERROR                        => 'unknown error',
        self::STATUS_ERROR_VESION                 => 'api vesion error',
        self::STATUS_ERROR_API_EXISTS             => '接口不存在',
        self::STATUS_ERROR_TIMEOUT                => '请求超时',
        self::STATUS_ERROR_TIMEOUT_DB             => '数据库连接失败',
        self::STATUS_ERROR_TIMEOUT_KV             => 'KV连接失败',
        self::STATUS_ERROR_FILE                   => '资源权限错误',
        self::STATUS_ERROR_DIR_EXISTS             => '目录权限不足',
        self::STATUS_ERROR_FILE_EXISTS            => '文件权限不足',
        self::STATUS_ERROR_PARAMS                 => '参数错误',
        self::STATUS_ERROR_PARAMS_MUST            => '必要参数丢失',
        self::STATUS_ERROR_PARAMS_CAN             => '参数超出允许范围',
        self::STATUS_ERROR_METHOD                 => '不接受的请求类型',
        self::STATUS_ERROR_PARAMS_VALIDE          => '参数验证非法',
        self::STATUS_ERROR_FILE_VALIDE            => '文件验证失败',
        self::STATUS_ERROR_FILE_VALIDE_TYPE       => '不接受的文件类型',
        self::STATUS_ERROR_FILE_VALIDE_MAX        => '文件过大',
        self::STATUS_ERROR_FILE_VALIDE_MIN        => '文件过小',
        self::STATUS_ERROR_API_QUENCY             => '请求频次预警',
        self::STATUS_ERROR_API_QUENCY_M           => 'api/单位时间超出频次　分',
        self::STATUS_ERROR_API_QUENCY_H           => 'api/单位时间超出频次　小时',
        self::STATUS_ERROR_API_QUENCY_IP_M        => 'api/单位时间&IP请求超出频次 分',
        self::STATUS_ERROR_API_QUENCY_IP_H        => 'api/单位时间&IP请求超出频次　小时',
        self::STATUS_ERROR_API_VALIDE             => 'api权限不足',
        self::STATUS_ERROR_API_VALIDE_TIME        => '时间戳错误',
        self::STATUS_ERROR_API_VALIDE_SIGN        => 'sign算法不合法',
        self::STATUS_ERROR_API_VALIDE_AUTH        => 'auth拒绝请求',
        self::STATUS_ERROR_API_VALIDE_SESSION     => 'session失效',
        self::STATUS_ERROR_API_VALIDE_TOKEN       => 'token失效',
        self::STATUS_SUCCESS                      => 'success',
        self::STATUS_SUCCESS_DO_ERROR             => '请求成功,逻辑处理失败,末定义错误',
        self::STATUS_SUCCESS_DO_ERROR_DB          => '请求成功,数据库错误',
        self::STATUS_SUCCESS_DO_ERROR_DB_REPEAT   => '记录重复',
        self::STATUS_SUCCESS_DO_ERROR_DB_NULL     => '记录不存在',
        self::STATUS_SUCCESS_DO_ERROR_DB_UFALSE   => '更新失败',
        self::STATUS_SUCCESS_DO_ERROR_DB_RFALSE   => '查询失败',
        self::STATUS_SUCCESS_DO_ERROR_DB_DFALSE   => '删除失败',
        self::STATUS_SUCCESS_DO_ERROR_DB_TIMEOUT  => '响应超时',
        self::STATUS_SUCCESS_DO_ERROR_KV          => 'KV操作错误',
        self::STATUS_SUCCESS_DO_ERROR_KV_TIMEOUT  => 'KV响应超时',
        self::STATUS_SUCCESS_DO_ERROR_FILE        => '文件操作失败',
        self::STATUS_SUCCESS_DO_ERROR_FILE_DODIR  => '目录权限不足',
        self::STATUS_SUCCESS_DO_ERROR_FILE_DOFILE => '文件权限不足',
    );

    public static function getCodes()
    {
        return self::$status_msgs;
    }
}