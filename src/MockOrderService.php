<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jacksunny\ExpressApi;

use Illuminate\Http\Request;

/**
 * Description of MockOrderService
 *
 * @author 施朝阳
 * @date 2017-6-1 16:18:09
 */
class MockOrderService implements OrderServiceContract {

    //put your code here
    public function apiCreateOrderReturnWaybillid($key, $order) {
        $waybill_info = [
            'waybill' => "11111111111111111111"
        ];
        return $waybill_info;
    }

    public function apiQueryOrders($key, $query) {
        $order = [
            'waybill_id' => '11111111111111111',
            'external_number' => '2222222222',
        ];
        return array($order);
    }

    public function apiCheckRequiredCreateParams($data) {
        return true;
    }

    public function apiCheckRequiredQueryParams($data) {
        return true;
    }

    public function findMissingCreateParams($input_param_array) {
        return array();
    }

    public function findMissingQueryParams($input_param_array) {
        return array();
    }

}
