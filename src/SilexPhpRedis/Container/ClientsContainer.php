<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SilexPhpRedis\Container;

use BadMethodCallException;
use Pimple\Container;
use Silex\Application;

/**
 * Description of ClientsContainer
 *
 * @author igor.scabini
 */
class ClientsContainer extends Container
{
    protected $application;
    protected $prefix;

    /**
     * {@inheritdoc}
     */
    public function __construct(Application $app, $prefix)
    {
        $this->application = $app;
        $this->prefix = $prefix;
    }

    public function keys()
    {
        $args = func_get_args();
        if (0 === count($args)) {
            return parent::keys();
        }
        else {
            return $this->__call("keys", $args);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $arguments)
    {
        if (isset($this->application["{$this->prefix}.default_client"])) {
            $default = $this->application["{$this->prefix}.default_client"];
            $value = call_user_func_array(array($this[$default], $method), $arguments);
            return $value;
        }
        throw new BadMethodCallException("Undefined method `$method`.");
    }
}
