<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace  Jacksunny\ExpressApi;

/**
 *
 * @author 施朝阳
 * @date 2017-6-1 16:17:22
 */
interface LogServiceContract {

    /**
     * 记录请求地址，请求的数据，该日志的描述以及该日志的标记
     */
    function apiLog($url, $data, $message, $tag = null);
}
