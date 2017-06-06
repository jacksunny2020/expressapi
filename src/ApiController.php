<?php

namespace Jacksunny\ExpressApi;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Log;

/**
 * 错误:签名失败
 */
define("ERROR_CODE_SIG_FAIL", 8010);
/**
 * 错误:创建订单失败
 */
define("ERROR_CODE_CREATE_ORDER_FAIL", 8020);
/**
 * 错误:查询订单失败
 */
define("ERROR_CODE_QUERY_ORDER_FAIL", 8030);
/**
 * 错误:缺少必须的输入参数
 */
define("ERROR_CODE_MISSING_INPUT_PARAMS", 8050);
/**
 * 错误:缺少必须的输入参数
 */
define("ERROR_CODE_MISSING_QUERY_PARAMS", 8060);
/**
 * appkey对应参数名
 */
define("PARAM_APPKEY", "appkey");
/**
 * 签名对应参数名
 */
define("PARAM_SIGNATURE", "sign");
/**
 * 下单数据对应参数名
 */
define("PARAM_DATA_ORDER_INPUT", "data");
/**
 * 查单数据对应参数名
 */
define("PARAM_DATA_ORDER_QUERY", "data");

class ApiController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    //提供签名验证的服务
    protected $security_service;
    //提供订单创建与查询的服务
    protected $order_service;
    //提供记录日志的服务
    protected $log_service;
    //提供参数转换的服务
    protected $param_trans_service;

    public function __construct(SecurityServiceContract $security_service, OrderServiceContract $order_service, LogServiceContract $log_service, ParamTransServiceContract $param_trans_service = null) {
        $this->security_service = $security_service;
        $this->order_service = $order_service;
        $this->log_service = $log_service;
        $this->param_trans_service = $param_trans_service;
    }

//    public function index($timezone){
//        echo "hello";
//    }

    /**
     * 返回当前组件的状态比如是否正常工作
     */
    public function status(Request $request) {
        $this->logRequest($request);
        return view('expressapi::status', [
            'status' => 'good'
        ]);
    }

    /**
     * 检查指定的key和data生成的签名$sig是否符合系统标准
     */
    public function checkSig(Request $request) {
        $this->logRequest($request);
        $key = $request->input(PARAM_APPKEY);
        $data = $request->input(PARAM_DATA_ORDER_INPUT);
        $sig = $request->input(PARAM_SIGNATURE);
        $success = $this->checkSigResult($key, $data, $sig);
        return $this->jsonResponse($success);
    }

    /**
     * 录入创建一个订单到系统中
     */
    public function inputOrder(Request $request) {
        $this->logRequest($request);
        $data = $request->except(['_url', '_method']);
        if (!isset($data[PARAM_APPKEY])) {
            return $this->jsonResponse($data, ERROR_CODE_MISSING_INPUT_PARAMS, "缺少输入的参数，请在输入时提供参数key即" . PARAM_APPKEY);
        }
        $key = $data[PARAM_APPKEY];
        if (!isset($data[PARAM_DATA_ORDER_INPUT])) {
            return $this->jsonResponse($data, ERROR_CODE_MISSING_INPUT_PARAMS, "缺少输入的参数，请在输入时提供参数" . PARAM_DATA_ORDER_INPUT . "即订单数据");
        }
        $order = $data[PARAM_DATA_ORDER_INPUT];
        if (!isset($data[PARAM_SIGNATURE])) {
            return $this->jsonResponse($data, ERROR_CODE_MISSING_INPUT_PARAMS, "缺少输入的参数，请在输入时提供参数" . PARAM_SIGNATURE . "即签名数据");
        }
        $sig = $data[PARAM_SIGNATURE];
        $sigSuccess = $this->checkSigResult($key, $order, $sig);
        if ($sigSuccess == false) {
            return $this->jsonResponse($order, ERROR_CODE_SIG_FAIL, "签名失败，请按规则生成对应的签名，可通过checkSig验证生成签名是否正确");
        }
        if (isset($this->param_trans_service)) {
            $data = $this->param_trans_service->TransInputOrderRequest($data);
        }
        $requiredInputParams = $this->order_service->apiCheckRequiredCreateParams($data);
        if (isset($requiredInputParams) && $requiredInputParams == false) {
            $missingParams = $this->order_service->findMissingCreateParams($data);
            if (!isset($missingParams) || !is_array($missingParams)) {
                $missingParams = [];
            }
            return $this->jsonResponse($order, ERROR_CODE_MISSING_INPUT_PARAMS, "缺少输入的参数，请在输入时提供以下参数名称和对应的参数值:" . implode(",", $missingParams));
        }
        try {
            //根据提交的订单数据在系统中创建订单并返回这个订单的运单号等信息
            $waybill_info = $this->order_service->apiCreateOrderReturnWaybillid($key, $data);
            if (isset($this->param_trans_service)) {
                $waybill_info = $this->param_trans_service->TransInputOrderResponse($waybill_info);
            }
            return $this->jsonResponse($waybill_info);
        } catch (Exception $ex) {
            return $this->jsonResponse($order, ERROR_CODE_CREATE_ORDER_FAIL, "创建订单失败，请检查提供的订单数据是否完整并且符合规范，调整后请再尝试创建订单");
        }
    }

    /**
     * 查询符合条件的订单列表返回
     */
    public function queryOrders(Request $request) {
        $this->logRequest($request);
        $data = $request->except(['_url', '_method']);

        if (!isset($data[PARAM_APPKEY])) {
            return $this->jsonResponse($data, ERROR_CODE_MISSING_INPUT_PARAMS, "缺少输入的参数，请在输入时提供参数key即" . PARAM_APPKEY);
        }
        $key = $data[PARAM_APPKEY];
        if (!isset($data[PARAM_DATA_ORDER_QUERY])) {
            return $this->jsonResponse($data, ERROR_CODE_MISSING_INPUT_PARAMS, "缺少输入的参数，请在输入时提供参数" . PARAM_DATA_ORDER_QUERY . "即订单查询条件");
        }
        $query = $data[PARAM_DATA_ORDER_QUERY];
        if (!isset($data[PARAM_SIGNATURE])) {
            return $this->jsonResponse($data, ERROR_CODE_MISSING_INPUT_PARAMS, "缺少输入的参数，请在输入时提供参数sig即签名数据");
        }
        $sig = $data[PARAM_SIGNATURE];
        $sigSuccess = $this->checkSigResult($key, $query, $sig);
        if ($sigSuccess == false) {
            return $this->jsonResponse($query, ERROR_CODE_SIG_FAIL, "签名失败，请按规则生成对应的签名，可通过checkSig验证生成签名是否正确");
        }
        try {
            if (isset($this->param_trans_service)) {
                $data = $this->param_trans_service->TransQueryOrderRequest($data);
            }
            $requiredQueryParams = $this->order_service->apiCheckRequiredQueryParams($key, $data);
            if (!isset($requiredQueryParams) && $requiredQueryParams == false) {
                $missingParams = $this->order_service->findMissingQueryParams($data);
                if (!isset($missingParams) || !is_array($missingParams)) {
                    $missingParams = [];
                }
                return $this->jsonResponse($order, ERROR_CODE_MISSING_QUERY_PARAMS, "缺少输入的参数，请在输入时提供以下参数名称和对应的参数值:" . implode(",", $missingParams));
            }
            //根据提交的查询条件返回多个符合条件的订单列表
            $orders = $this->order_service->apiQueryOrders($key, $data);

//            $requiredOutputParams = $this->order_service->apiRequiredOutputParams();
//            $missingParams = $this->findMissingParams($orders,$requiredOutputParams);
//            if(!empty($missingParams) && count($missingParams)>0){
//                return $this->jsonResponse($query, ERROR_CODE_MISSING_INPUT_PARAMS, "查询订单中缺少指定参数，请联系管理员提供指定参数:".$this->getParamsNamesStr());
//            }
            if (isset($this->param_trans_service)) {
                $orders = $this->param_trans_service->TransQueryOrderResponse($orders);
            }
            return $this->jsonResponse($orders);
        } catch (Exception $ex) {
            return $this->jsonResponse($query, ERROR_CODE_QUERY_ORDER_FAIL, "查询订单失败，请检查提供的查询条件是否完整有效,调整后再尝试查询订单");
        }
    }

    /**
     * 生成json响应
     */
    private function jsonResponse($data, $error = 0, $msg = '') {
        $response = array();
        if (is_array($data)) {
            $response['response_rows'] = $data;
        } else {
            $response['response_rows'] = [$data];
        }
        $response['response_error'] = $error;
        $response['response_message'] = $msg;
        return response()->json($response);
    }

    /**
     * 检查指定的key和data生成的签名$sig是否符合系统标准
     */
    private function checkSigResult($key, $data, $sig) {
        try {
            $correct_sig = $this->security_service->makeSignature($key, $data);
        } catch (Exception $exception) {
            return false;
        }
        $success = ($correct_sig == $sig);
        return $success;
    }

    /**
     * 为指定的请求创建日志记录，为了不影响正确请求处理当发生异常时应该方法内捕获处理掉
     */
    private function logRequest(Request $request, $message = "", $tag = "") {
        try {
            $url = $request->fullUrl();
            $data = $request->all();
            return $this->log_service->apiLog($url, $data, $message, $tag);
        } catch (Exception $error) {
            Log::error($error);
        }
    }

}
