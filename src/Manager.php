<?php

namespace Qklin\Notify;

class Manager
{
    private static $_instance = [];

    private static $_configs = [];

    private $_biz;

    /**
     * 获取notify具体的driver实例
     * @param string $configName
     * @return mixed
     * @throws \Exception
     */
    public static function bizs($configName = 'default')
    {
        // 获取默认配置名
        if ($configName == 'default') {
            $notifyConfigs = config('notify');
            $configName = $notifyConfigs['default'];
        }

        // 获取设置配置唯一key
        if (!isset(self::$_configs[$configName])) {
            $notifyConfigs = config('notify');
            self::$_configs[$configName] = $notifyConfigs['bizs'][$configName];
        }

        $driverName = self::$_configs[$configName]['driver'];
        $class = "\\Qklin\\Notify\\Driver\\" . ucfirst($driverName);
        if (!class_exists($class)) {
            throw new \Exception("不存在的类: " . $class);
        }

        $guid = strtolower($driverName);
        if (!isset(self::$_instance[$guid])) {
            self::$_instance[$guid] = new $class(self::$_configs[$configName]);
        }

        return self::$_instance[$guid];
    }

    /**
     * 恢复默认的biz
     */
    public function resetBiz()
    {
        $this->_biz = 'default';
    }

    /**
     * 设置当前biz
     * @param $biz
     */
    public function setBiz($biz)
    {
        $this->_biz = $biz;
    }

    /**
     * 获取当前biz
     */
    public function getBiz()
    {
        return $this->_biz;
    }

    /**
     * 调用
     * @param $method
     * @param $arguments
     */
    public function __call($method, $arguments)
    {
        if (empty($this->_biz)) {
            $this->_biz = 'default';
        }
        if ($arguments[0] instanceof \Closure) {
            $this->_biz = call_user_func($arguments[0]);
            $arguments = array_slice($arguments, 1);
        }

        try {
            $notifyInstance = self::bizs($this->_biz);
            $result = call_user_func_array([$notifyInstance, $method], $arguments);

            app()->bound('Psr\Log\LoggerInterface') && app('Psr\Log\LoggerInterface')->info('notify call result', [
                'biz'     => $this->_biz,
                'method'  => $method,
                'args'    => $arguments,
                'errcode' => $result,
            ]);

        } catch (\Exception $e) {
            app()->bound('Psr\Log\LoggerInterface') && app('Psr\Log\LoggerInterface')->info('notify call 失败', [
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage(),
            ]);
        }
    }
}