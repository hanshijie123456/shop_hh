<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder; 

use App\Model\Admin\User;
use Hash;
use Config;

class LoginController extends Controller
{
   	public function login()
    {
    	return view('admin.login.login');
    }

    public function dologin(Request $request)
    {
    	//表单验证

    	//检测验证码
        $code = session('code');
        if($code != $request->code){

            return back()->with('error','验证码错误!');
        }

    	//检测用户名
        $users = User::where('username',$request->username)->first();
        if(!$users){

            return back()->with('error','用户名或密码错误!');
        }
        //检测密码  加密解密   
       	if (decrypt($users->password) != $request->password) {
            
            return back()->with('error','用户名或密码错误!');

        }
        //存储用户id
        session(['uid'=>$users->id]);
        //提示信息
        return redirect('/admin')->with('success','登录成功');

        
    }

    //生成验证码方法
	public function captcha()
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(123, 203, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 90, $height = 35, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
      
        session(['code'=>$phrase]);

        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }
    /**
     *  Display a listing of the resource.
     *
     *  @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $rs = User::where('id',session('uid'))->first();

        return view('admin.login.profile',[
            'title'=>'修改头像信息',
            'rs'=>$rs

        ]);
    }

    /**
     *  Display a listing of the resource.
     *
     *  @return \Illuminate\Http\Response
     */
    public function doprofile(Request $request)
    {
        //获取上传的文件对象  $_FILES
        $file = $request->file('profile');
        //判断文件是否有效
        if($file->isValid()){
            //上传文件的后缀名
            $entension = $file->getClientOriginalExtension();
            //设置名字  32948324324832894.jpg
            $newName = date('YmdHis').mt_rand(1000,9999).'.'.$entension;

            $path = $file->move(Config::get('app.uploads'),$newName);

            $filepath = '/uploads/'.$newName;

            $res['profile'] = $filepath;

            User::where('id',session('uid'))->update($res);

            //返回文件的路径
            return  $filepath;
        }
    }
    // public function xiugai_touxiang(Request $request,$id){
    //     // dd($request->new_profile);
    //     $res = User::where('id',$id)->first();
    //     // $res[0]->
    //     $res->profile = $request->new_profile;
    //     $res->save();
    //     return back()->with('success','修改成功');
    // }

     /**
     *  Display a listing of the resource.
     *
     *  @return \Illuminate\Http\Response
     */
    public function pass()
    {
        return view('admin.login.pass',['title'=>'修改密码']);
    }

    /**
     *  Display a listing of the resource.
     *
     *  @return \Illuminate\Http\Response
     */
    public function dopass(Request $request)
    {
        //表单验证

        //获取数据库密码
        $pass = User::where('id',session('uid'))->first();

        //获取旧密码
        $oldpass = $request->oldpass;

        if(decrypt($pass->password) != $oldpass){

            return back()->with('error','原密码错误');
        }

        $rs['password'] = encrypt($request->password);

        try{
           
            $data = User::where('id',session('uid'))->update($rs);
            if($data){

                return redirect('/admin/login')->with('success','添加成功');
            }
        }catch(\Exception $e){

            return back()->with('error','修改密码失败');
        }

    }  

    public function logout()
    {
        //清空session uid
        session(['uid'=>'']);

        return redirect('/admin/login');
    } 
}
