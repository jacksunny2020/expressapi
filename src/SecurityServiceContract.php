<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jacksunny\ExpressApi;

/**
 *
 * @author 施朝阳
 * @date 2017-6-1 16:17:09
 */
interface SecurityServiceContract {

    /**
     * 根据提供的key 和 数据 data 生成对应的签名字符串并返回
     */
    function makeSignature($key, $data);
}
