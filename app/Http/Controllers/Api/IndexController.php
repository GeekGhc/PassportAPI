<?php
namespace App\Http\Controllers\Api;

class IndexController extends Controller
{
    public function index(){
        return $this->message("请求成功");
    }

}