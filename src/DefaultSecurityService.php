<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace  Jacksunny\Expressapi;

/**
 * Description of MockSecurityService
 *
 * @author 施朝阳
 * @date 2017-6-1 16:17:48
 */
class DefaultSecurityService implements SecurityServiceContract {

    /**
     * key和请求数据连接后经过md5加密然后再通过base64编码得到签名字符串
     */
    public function makeSignature($key, $data) {
        $result = "";

        if (empty($key)) {
            throw new \Exception("缺少appkey,请提供非空appkey生成签名");
        }
        if (empty($data)) {
            throw new \Exception("缺少请求数据,请提供至少一个请求数据");
        }
        $result = base64_encode(md5(trim($key) . trim($data)));

        return $result;
    }

}
