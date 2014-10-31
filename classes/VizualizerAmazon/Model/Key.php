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
 * APIキーのモデルです。
 *
 * @package VizualizerAmazon
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerAmazon_Model_Key extends Vizualizer_Plugin_Model
{
    const AWS_BASE_URL = "http://webservices.amazon.co.jp/onca/xml";
    const AWS_API_VERSION = "2013-08-01";

    /**
     * コンストラクタ
     *
     * @param $values モデルに初期設定する値
     */
    public function __construct($values = array())
    {
        $loader = new Vizualizer_Plugin("amazon");
        parent::__construct($loader->loadTable("Keys"), $values);
    }

    /**
     * 主キーでデータを取得する。
     *
     * @param $key_id キーID
     */
    public function findByPrimaryKey($key_id)
    {
        $this->findBy(array("key_id" => $key_id));
    }

    /**
     * オペレータIDでデータを取得する。
     *
     * @param $operator_id オペレータID
     */
    public function findByOperatorId($operator_id)
    {
        $this->findBy(array("operator_id" => $operator_id));
    }

    /**
     * Amazon APIにアクセスしてデータを取得する。
     */
    public function call($operation, $response, $params)
    {
        $url = AWS_BASE_URL."?Service=AWSECommerceService";
        $url .= "&Operation=".$operation;
        $url .= "&ResponseGroup=".$response;
        $url .= "&AWSAccessKeyId=".$this->access_key;
        $url .= "&Version=".self::AWS_API_VERSION;
        $url .= "&Timestamp=".urlencode(gmdate("Y-m-d")."T".gmdate("H:i:s")."Z");
        foreach($params as $key => $value){
            $url .= "&".$key."=".$value;
        }
        $signature = hash_hmac("sha256", $url, $this->secret_key, true);

        $result = file_get_contents($url."&Signature=".urlencode($signature));
    }

    /**
     * ItemLookupを実行する。
     */
    public function itemLookup($itemIds, $response = "Large")
    {
        if (!is_array($itemIds)) {
            $itemIds = array($itemIds);
        }
        return $this->call("ItemLookup", $response, array("ItemId" => implode(",", $itemIds)));
    }
}
