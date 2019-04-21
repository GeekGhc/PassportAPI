<?php
namespace App\Api\Helpers;


use Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ApiResponse
{
    /**
     * 200 (默认)
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;
    /**
     * @return int
     */
    public function getStatusCode(){
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
        return $this;
    }
    /**
     * @param $message
     * @param string $status
     * @return mixed
     */
    public function message($message,$status = 'success'){
        return $this->status($status,[
            'message'=>$message
        ]);
    }
    /**
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($status,array $data,$code = null){
        if($code){
            $this->setStatusCode($code);
        }
        $status = [
            'status'=>$status,
            'code'=>$this->statusCode
        ];
        $data = array_merge($status,$data);
        return $this->response($data);
    }
    /**
     * 统一response
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function response($data,$header = []){
        return response()->json($data,$this->getStatusCode(),$header);
    }
    /**
     * 200 成功返回实体数据
     * @param $data
     * @param string $status
     * @return mixed
     */
    public function success($data,$status = "success"){
        return $this->status($status,compact('data'));
    }

    /**
     * 201 (创建成功 无数据体返回)
     * @param string $message
     * @return mixed
     */
    public function created($message = "created"){
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)->message($message);
    }


    /**
     * 400 (请求异常)
     * @param $message
     * @param int $code
     * @param string $status
     * @return mixed
     */
    public function failed($message,$code = FoundationResponse::HTTP_BAD_REQUEST,$status = 'error'){
        return $this->setStatusCode($code)->message($message,$status);
    }
    /**
     * 500 (服务器内部错误)
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!"){
        return $this->failed($message,FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
    /**
     * 404 (不存在的资源)
     * @param string $message
     * @return mixed
     */
    public function notFound($message = "Not Found!"){
        return $this->failed($message,FoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * 204(delete 不会反悔响应体)
     * @param string $message
     * @return mixed
     */
    public function noContent($message = "No Content!"){
        return $this->failed($message,FoundationResponse::HTTP_NO_CONTENT);
    }

    /**
     * 401 用户未认证
     * @param string $message
     * @return mixed
     */
    public function unauthorized($message = "Unauthorized!"){
        return $this->failed($message,FoundationResponse::HTTP_UNAUTHORIZED);
    }
}