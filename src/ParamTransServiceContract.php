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
interface ParamTransServiceContract {

    /**
     * 将请求的参数转换成创建订单必须的参数格式和名称,返回转换后的请求参数
     */
    function TransInputOrderRequest(array $data);
    
    /**
     * 将请求的参数转换成查询订单必须的参数格式和名称,返回转换后的请求参数
     */
    function TransQueryOrderRequest(array $data);

    
}
