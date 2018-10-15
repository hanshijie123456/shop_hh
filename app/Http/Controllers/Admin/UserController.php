<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Hash;
use App\Model\Admin\User;
use App\Model\Admin\Role;
use DB;
use Config;


class UserController extends Controller
{
    /**
     * 用户添加角色
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_role($id)
    {
        //echo $id;
        //通过id 获取用户信息
        $user = User::find($id);
        //获取角色信息
        $role = Role::get();

        $user_role = $user->roles;
        $user_arr = [];
        foreach($user_role as $k => $v){
            $user_arr[] = $v->id;
        }

        return view('admin.user.user_role',[
            'title'=>'用户添加的页面',
            'user'=>$user,
            'role'=>$role,
            'res'=>$user_arr
        ]);
    }

     /**
     * 处理用户添加角色的方法
     * @return \Illuminate\Http\Response
     */
    public function do_user_role(Request $request)
    {
       
        $user_id = $request->input('id');

        $role_id = $request->input('role_id');

        //判断
        if(!$role_id){

            return back()->with('error','请选择角色');
        }

        //添加数据 $role_id  [1,2,3];
        DB::table('user_role')->where('user_id',$user_id)->delete();

        $arr = [];
        foreach($role_id as $k => $v){
            $res = [];
            $res['user_id'] = $user_id;
            $res['role_id'] = $v;
            $arr[] = $res;
        }

        $data = DB::table('user_role')->insert($arr);

        if($data){

            return redirect('/admin/user')->with('success','添加成功');
        } else {

            return back()->with('error','添加失败');
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $rs = User::all();
        // dd($rs);
        //多条件查询
        $rs = User::orderBy('id','asc')
            ->where(function($query) use($request){
                //检测关键字
                $username = $request->input('username');
                $email = $request->input('email');
                //如果用户名不为空
                if(!empty($username)) {
                    $query->where('username','like','%'.$username.'%');
                }
                //如果邮箱不为空
                if(!empty($email)) {
                    $query->where('email','like','%'.$email.'%');
                }
            })
            ->paginate($request->input('num', 10));
         return view('admin.user.index',[
            'title'=>'用户名列表页',
            'rs'=>$rs,
            'request'=>$request

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        //显示表单
        return view('admin.user.add',['title'=>'用户的添加页面']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        //表单验证
         $this->validate($request, [
            'username' => 'required|regex:/^\w{6,12}$/',
            'password' => 'required|regex:/^\S{6,12}$/',
            'repass' =>'same:password',
            'phone' =>'regex:/^1[3456789]\d{9}$/',
            'email' =>'email:email',


        ]

        );
         $res = $request->except('_token','profile','repass');
         //文件上传
        if($request->hasFile('profile')){

            //自定义名字
            $name = time().rand(1111,9999);

            //获取后缀
            $suffix = $request->file('profile')->getClientOriginalExtension(); 

            //移动
            $request->file('profile')->move(Config::get('app.uploads'),$name.'.'.$suffix);
        }

        $res['profile'] = '/uploads/'.$name.'.'.$suffix;

        // $res['password'] = Hash::make($request->input('password'));
        $res['password'] = encrypt($request->input('password'));

        //往数据库里面添加数据
        //dd($rs);
        // dump($res);
        try{
           
            $rs = User::create($res);


            if($rs){

                return redirect('/admin/user')->with('success','添加成功');
            }
        }catch(\Exception $e){

            return back()->with('error','添加失败');

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //echo $id;
        //根据id获取数据
        //第二种 方式
        $res = User::find($id);

        return view('admin.user.edit',[
            'title'=>'用户的修改页面',
            'res'=>$res
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $res = $request->except('_token','_method','profile');

         //文件上传
        if($request->hasFile('profile')){

            //自定义名字
            $name = time().rand(1111,9999);

            //获取后缀
            $suffix = $request->file('profile')->getClientOriginalExtension(); 

            //移动
            $request->file('profile')->move('uploads',$name.'.'.$suffix);

            $res['profile'] = '/uploads/'.$name.'.'.$suffix;

        }

        try{
           
            $rs = User::where('id',$id)->update($res);


            if($rs){

                return redirect('/admin/user')->with('success','修改成功');
            }
        }catch(\Exception $e){

            return back()->with('error','修改失败');

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          try{
           
            $res = User::where('id',$id)->delete();

            if($res){

                return redirect('/admin/user')->with('success','删除成功');
            }
        }catch(\Exception $e){

            return back()->with('error','删除失败');

        }

    }
}
