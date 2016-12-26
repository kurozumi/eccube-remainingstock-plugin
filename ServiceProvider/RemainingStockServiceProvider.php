<?php

/*
 * This file is part of the RemainingStock
 *
 * Copyright (C) 2016 kurozumi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\RemainingStock\ServiceProvider;

use Plugin\RemainingStock\Form\Type\RemainingStockConfigType;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

class RemainingStockServiceProvider implements ServiceProviderInterface
{

    public function register(BaseApplication $app)
    {
        // プラグイン用設定画面
        $app->match('/'.$app['config']['admin_route'].'/plugin/RemainingStock/config', 'Plugin\RemainingStock\Controller\ConfigController::index')->bind('plugin_RemainingStock_config');

        // 独自コントローラ
        $app->match('/plugin/remainingstock/hello', 'Plugin\RemainingStock\Controller\RemainingStockController::index')->bind('plugin_RemainingStock_hello');

        // Form
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new RemainingStockConfigType();

            return $types;
        }));

        // Repository

        // Service
        $app['eccube.service.cart'] = $app->share($app->extend('eccube.service.cart', function() use ($app) {
            return new \Plugin\RemainingStock\Service\CartService($app);
        }));

        // メッセージ登録
//         $file = __DIR__ . '/../Resource/locale/message.' . $app['locale'] . '.yml';
//         $app['translator']->addResource('yaml', $file, $app['locale']);

        // load config
        // プラグイン独自の定数はconfig.ymlの「const」パラメータに対して定義し、$app['remainingstockconfig']['定数名']で利用可能
//         if (isset($app['config']['RemainingStock']['const'])) {
//             $config = $app['config'];
//             $app['remainingstockconfig'] = $app->share(function () use ($config) {
//                 return $config['RemainingStock']['const'];
//             });
//         }

    }

    public function boot(BaseApplication $app)
    {
    }

}
