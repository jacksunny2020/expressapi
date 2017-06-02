<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jacksunny\ExpressApi;

/**
 * Description of ArrayHelper
 *
 * @author 施朝阳
 * @date 2017-6-1 18:43:22
 */
class ArrayHelper {

    /**
     * 从输入参数数组中查找是否有不在参数名数组 $required_param_name_array 中的参数，如果有作为结果数组返回
     */
    public static function findMissingParams($input_param_array, $required_param_name_array) {
        $result = array();

        if (empty($required_param_name_array) || count($required_param_name_array) <= 0) {
            return $result;
        }
        if (empty($input_param_array) || count($input_param_array) <= 0) {
            $result = $required_param_name_array;
            return $result;
        }

        foreach ($required_param_name_array as $required_param_name) {
            if (!array_key_exists($required_param_name, $input_param_array)) {
                $result[] = $required_param_name;
            }
        }

        return $result;
    }

}
