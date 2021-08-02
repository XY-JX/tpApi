<?php
declare (strict_types = 1);

namespace app;

use think\App;
use think\exception\ValidateException;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {}

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

      //  return $v->failException(true)->check($data);

        $v->failException(false)->check($data);

        if($v->getError())

        \Api::error($v->getError(),402);
    }

    /**
     * 获取请求数据并（过滤+默认值+验证）
     * @param array $params [['参数'，’默认值‘]]
     * @param array $validate ['api|API'=>'require|email'] 参考tp6手册验证器
     * @param array $message ['name.require' => '名称必须','name.max' => '名称最多不能超过25个字符','email' => '邮箱格式错误'];
     * @return array
     */
    protected function getData(array $params, array $validate = [], array $message = [])
    {
        if(config('app.is_it_encrypted') && $this->request->param('data')){
            $this->request->setRoute(\Openssl::decrypt($this->request->param('data')));//公钥解密并赋值给request
        }
        $p = [];
        foreach ($params as $key => $param) {
            if (is_array($param)) {
                if (!isset($param[1])) $param[1] = null;
                if (!isset($param[2])) $param[2] = '';
                $name = $param[0] ;
                if (strpos($param[0] , '/')) {
                    [$name, $type] = explode('/', $param[0]);
                }
                $p[$name] = $this->request->param($param[0], $param[1], $param[2]);
            } else if(is_int($key)){
                $p[$param] = $this->request->param($param);
            } else {
                $p[$key] = $this->request->param($key,$param);
            }
        }
        if ($validate) {
            $this->validate($p, $validate, $message);
        }
        return $p;
    }

}
