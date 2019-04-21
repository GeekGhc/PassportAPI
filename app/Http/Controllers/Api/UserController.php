<?php
namespace App\Http\Controllers\Api;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;

class UserController extends Controller
{
    /**
     * 单个用户
     * @return UserResource
     */
    public function user(){
        return new UserResource(User::find(1));
    }

    /**
     * 用户列表(扩展列表字段基于UserCollection)
     * @return mixed
     */
    public function users(){
        //用户集合
//        $data = UserResource::collection(User::all());

        //用户集合 自定义格式
//        $data =  new UserCollection(User::all());

        //用户分页
        $data = new UserCollection(User::paginate());
        return $data;
    }

}