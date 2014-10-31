<?php

/**
 * Copyright (C) 2012 Vizualizer All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author    Naohisa Minagawa <info@vizualizer.jp>
 * @copyright Copyright (c) 2010, Vizualizer
 * @license http://www.apache.org/licenses/LICENSE-2.0.html Apache License, Version 2.0
 * @since PHP 5.3
 * @version   1.0.0
 */

/**
 * 商品情報を更新するためのバッチです。
 *
 * @package VizualizerAffiliate
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerAffiliate_Batch_AutoContract extends Vizualizer_Plugin_Batch
{

    public function getName()
    {
        return "Update Product";
    }

    public function getFlows()
    {
        return array("updateProduct");
    }

    /**
     * 自動提携処理を実施。
     *
     * @param $params バッチ自体のパラメータ
     * @param $data バッチで引き回すデータ
     * @return バッチで引き回すデータ
     */
    protected function updateProduct($params, $data)
    {
        $loader = new Vizualizer_Plugin("Amazon");
        $key = $loader->loadModel("Key");
        $keys = $key->findAllBy(array(), "RAND()");
        if ($keys->count() > 0) {
            $key = $keys->current();
            $result = $key->itemLookup("182086489");
            print_r($result);
        }

        return $data;
    }
}
