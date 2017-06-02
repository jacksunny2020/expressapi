<?php

//Route::get('api/{timezone}', 
//  'jacksunny\expressapi\ApiController@index');

Route::get('api/status', 
  'Jacksunny\Expressapi\ApiController@status');

//检查给定的签名是否正确
///api/check/sig?key=1&sig=11&data=hello
Route::any('api/check/sig', 
  'Jacksunny\Expressapi\ApiController@checkSig');

//录入创建订单
///api/order/input?key=1&sig=11&order=hello
Route::any('api/order/input', 
  'Jacksunny\Expressapi\ApiController@inputOrder');

//查询指定条件的订单列表
///api/order/query?key=1&sig=11&query=hello
Route::any('api/order/query', 
  'Jacksunny\Expressapi\ApiController@queryOrders');





