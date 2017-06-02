<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace  jacksunny\expressapi;

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
     * 创建订单时订单必填参数的检查，返回true或false
     */
    function apiCheckRequiredCreateParams();
    
    /**
     * 查询订单时必须提供的的查询参数名称的检查，返回true或false
     */
    function apiCheckRequiredQueryParams();
    
    /**
     * 从输入参数找到缺失的必填参数名称列表，如果有作为结果数组返回
     */
    function findMissingCreateParams($input_param_array);
    
    /**
     * 从输入参数找到缺失的必填参数名称列表，如果有作为结果数组返回
     */
    function findMissingQueryParams($input_param_array);
    
    
}
