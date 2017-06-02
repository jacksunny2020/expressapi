<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jacksunny\ExpressApi;

/**
 * Description of MockOrderService
 *
 * @author 施朝阳
 * @date 2017-6-1 16:18:09
 */
class MockOrderService implements OrderServiceContract {

    //put your code here
    public function apiCreateOrderReturnWaybillid($order) {
        return "11111111111111111111";
    }

    public function apiQueryOrders($query) {
        $order = [
            'waybill_id' => '11111111111111111',
            'external_number' => '2222222222',
        ];
        return array($order);
    }

    public function apiRequiredInputParams() {
        return [
            'waybill_type',
            'goods_type', //'goods_type_id',
            'order_orignal_number', //'order_orignal_id',
            'agent_name', //'agent_id',
            'sender_user_name', //'sender_user_id',
            'sender_country',
            'sender_province',
            'sender_city',
            'sender_district',
            'sender_community',
            'sender_name',
            'sender_address',
            'sender_telephone',
            'sender_remark',
            'sender_book_date',
            'sender_book_time',
            'target_name',
            'target_country',
            'target_province',
            'target_city',
            'target_district',
            'target_community',
            'target_address',
            'target_telephone',
            'target_book_date',
            'target_book_time',
            'weight',
            'distance',
            'volume',
            'boxes',
        ];
    }

    public function apiRequiredOutputParams() {
        return [
            'waybill',
            'waybill_type',
            'goods_type_id',
            'order_orignal_id',
            'agent_id',
            'sender_user_id',
            'sender_country',
            'sender_province',
            'sender_city',
            'sender_district',
            'sender_community',
            'sender_name',
            'sender_address',
            'sender_telephone',
            'sender_remark',
            'sender_book_date',
            'sender_book_time',
            'target_name',
            'target_country',
            'target_province',
            'target_city',
            'target_district',
            'target_community',
            'target_address',
            'target_telephone',
            'target_book_date',
            'target_book_time',
            'weight',
            'distance',
            'volume',
            'boxes',
        ];
    }

}
