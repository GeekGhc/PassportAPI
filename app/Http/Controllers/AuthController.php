<?php
namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Zend\Diactoros\Response as Psr7Response;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends Controller
{

    /**
     * 自定义客户端登录
     * @param AuthorizationRequest $request
     * @param AuthorizationServer $server
     * @param ServerRequestInterface $serverRequest
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store(AuthorizationRequest $request,AuthorizationServer $server,ServerRequestInterface $serverRequest){
        try{
            return $server->respondToAccessTokenRequest($serverRequest,new Psr7Response)->withStatus(201);
        }catch(OAuthServerException $e){
            return $this->unauthorized($e->getMessage());
        }
    }

    /**
     * 刷新token
     * @param AuthorizationServer $server
     * @param ServerRequestInterface $serverRequest
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function update(AuthorizationServer $server,ServerRequestInterface $serverRequest){
        try{
            return $server->respondToAccessTokenRequest($serverRequest,new Psr7Response());
        }catch(OAuthServerException $e){
            return $this->unauthorized($e->getMessage());
        }
    }

    /**
     * 用户注册
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(RegisterRequest $request){
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return $this->created("用户注册成功");
    }

    /**
     * 用户登录 发放个人访问令牌
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return $this->unauthorized("用户认证失败");

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();
        $data = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];
        return $this->success($data);
    }

    /**
     * 用户退出 清楚个人令牌
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return $this->message("用户退出成功");
    }

    /**
     * 当前用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request){
        return response()->json($request->user());
    }

}