<?php

/*
 * This file is part of the RemainingStock
 *
 * Copyright (C) 2016 kurozumi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\RemainingStock\Controller;

use Eccube\Application;
use Symfony\Component\HttpFoundation\Request;

class RemainingStockController
{

    /**
     * RemainingStock画面
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Application $app, Request $request)
    {

        // add code...

        return $app->render('RemainingStock/Resource/template/index.twig', array(
            // add parameter...
        ));
    }

}
