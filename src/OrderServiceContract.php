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
 * @date 2017-6-1 16:17:22
 */
interface OrderServiceContract {

    /**
     * 根据提供的订单数据在系统中创建订单，并返回该订单对应的运单号
     */
    function apiCreateOrderReturnWaybillid($order);

    /**
     * 根据指定的查询条件返回对应的订单列表返回
     */
    function apiQueryOrders($query);
    
    /**
     * 创建订单时订单必填参数的参数名数组，比如['sender_name','sender_mobile']
     */
    function apiRequiredInputParams();
    
    /**
     * 查询订单输出时订单必须输出的字段名数组，比如['waybill','sender_name','target_address']
     */
    function apiRequiredOutputParams();
    
    
}
