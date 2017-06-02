<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace  jacksunny\expressapi;

use Log;

/**
 * Description of MockSecurityService
 *
 * @author 施朝阳
 * @date 2017-6-1 16:17:48
 */
class MockLogService implements LogServiceContract {

    public function apiLog($url, $data, $message, $tag = null) {
        Log::info("$url:".json_encode($data).":$message");
    }

}
