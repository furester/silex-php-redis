<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SilexPhpRedis;

use Silex\Application;
use Pimple\Container;
use SilexPhpRedis\Container\ClientsContainer;

/**
 * Description of RedisClientsProvider
 *
 * @author igor.scabini
 */
class RedisClientsProvider extends RedisClientProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getProviderHandler(Application $app, $prefix)
    {
        return function () use ($app, $prefix) {
            $clients = $app["{$prefix}.clients_container"]($prefix);
            foreach ($app["$prefix.clients"] as $alias => $args) {
                $clients[$alias] = function () use ($app, $prefix, $args) {
                    $initializer = $app["$prefix.client_initializer"];
                    if (is_string($args)) {
                        $args = array('parameters' => $args);
                    } elseif (!isset($args['parameters']) && !isset($args['options'])) {
                        $args = array('parameters' => $args);
                    }
                    return $initializer($args);
                };
            }
            return $clients;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app["{$this->prefix}.clients"] = array();
        $app["{$this->prefix}.clients_container"] = $app->protect(function ($prefix) use ($app) {
            return new ClientsContainer($app, $prefix);
        });
        parent::register($app);
    }
}
