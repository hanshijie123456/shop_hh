<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Admin\User;
use App\Model\Admin\Role;
use App\Model\Admin\Permission;

class HasRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //用户登录  获取用户信息
        $user = User::find(session('uid'));

        //知道我有哪些角色 1 2 3 4
        $role = $user->roles;

        //有了角色之后我就知道我有哪些权限
        $arr = [];
        foreach($role as $rl){          
            $per = $rl->permissions;
            foreach($per as $url){
               $arr[] = $url->per_url;
            }

        }

        //获取权限
        $arrs = array_unique($arr);

        //获取当前控制器方法的路径(url);

        //$urs = \Route::current()->getActionName();

        $uls = \Request::getRequestUri();

        //dump($uls);

        //判断
        if(in_array($uls,$arrs)){
               return $next($request);         
        } else {
            return redirect('/admin/login');
        }
        
    }

}
