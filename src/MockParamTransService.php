<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace  Jacksunny\ExpressApi;

use Illuminate\Http\Request;
use Jacksunny\ExpressApi\ParamTransServiceContract;

/**
 * Description of MockOrderService
 *
 * @author 施朝阳
 * @date 2017-6-1 16:18:09
 */
class MockParamTransService implements ParamTransServiceContract {
    
    public function TransInputOrderRequest(array $data) {
        return $data;
    }
    
    public function TransInputOrderResponse(array $data) {
        return $data;
    }

    public function TransQueryOrderRequest(array $data) {
        return $data;
    }

    public function TransQueryOrderResponse(array $data) {
        return $data;
    }

}
