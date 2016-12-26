<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Plugin\RemainingStock\Service;

use Eccube\Service\CartService as BaseCartService;

class CartService extends BaseCartService
{
    /**
     *
     * @param  string $productClassId
     * @param  integer $quantity
     * @return \Eccube\Service\CartService
     */
    public function addProduct($productClassId, $quantity = 1)
    {
        $quantity += $this->getProductQuantity($productClassId);
        $this->setProductQuantity($productClassId, $quantity);

        $this->getRestStock($productClassId, $quantity);

        return $this;

    }

    /**
     * @param  string $productClassId
     * @return \Eccube\Service\CartService
     */
    public function upProductQuantity($productClassId)
    {
        $quantity = $this->getProductQuantity($productClassId) + 1;
        $this->setProductQuantity($productClassId, $quantity);

        $this->getRestStock($productClassId, $quantity);

        return $this;

    }

    /**
     * カートに入れたあとの在庫数を計算
     * 
     * @param type $productClassId
     * @param type $quantity
     */
    public function getRestStock($productClassId, $quantity)
    {
        $ProductClass = $this->app['eccube.repository.product_class']->find($productClassId);

        if (!$ProductClass->getStockUnlimited() && count($this->getErrors()) == 0) {
            $stock = $ProductClass->getStock() - $quantity;
            $this->addError(sprintf("在庫はあと%sです。", $stock));
        }

    }

}
