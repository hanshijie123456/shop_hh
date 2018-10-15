<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Admin\Role;
use App\Model\Admin\Permission;

use DB;

class RoleController extends Controller
{

    /**
     *  添加角色权限页面
     *
     *  @return \Illuminate\Http\Response
     */
    public function role_per($id)
    {
        $role = Role::find($id);

        $per = Permission::all();

        //获取角色的权限
        $permis = $role->permissions;

        //dump($permis);

        $arr = [];
        foreach($permis as $k => $v){
            $arr[] = $v->id;
        }


        return view('admin.role.role_per',[
            'title'=>'添加角色权限的页面',
            'role'=>$role,
            'per'=>$per,
            'arr'=>$arr


        ]);
    }

    /**
     *  处理橘色权限的方法
     *
     *  @return \Illuminate\Http\Response
     */
    public function do_role_per(Request $request)
    {
        $role_id = $request->input('id');

        $per_id = $request->input('per_id');

        if(!$per_id){

            return back()->with('error','请选择权限!!');
        }

        DB::table('role_permission')->where('role_id',$role_id)->delete();

        $res = [];
        foreach($per_id as $k => $v){
            $rs = [];
            $rs['role_id'] = $role_id;
            $rs['per_id'] = $v;

            $res[] = $rs;
        }

        $data = DB::table('role_permission')->insert($res);

        if($data){

            return redirect('/admin/role')->with('success','添加成功');
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
        //
        $data = Role::where('role_name','like','%'.$request->role_name.'%')->

        paginate($request->input('num',5));

        return view('admin.role.index',[
            'title'=>'用户角色列表页面',
            'request'=>$request,
            'rs'=>$data


        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.add',['title'=>'用户角色的添加页面']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rs = $request->except('_token');

        try{
           
            $data = Role::create($rs);


            if($data){

                return redirect('/admin/role')->with('success','添加成功');
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
        //
        $rs = Role::find($id);

        return view('admin.role.edit',[
            'title'=>'用户角色修改的页面',
            'rs'=>$rs

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
        //
        $rs = $request->only('role_name');

        try{
           
            $data = Role::where('id',$id)->update($rs);

            if($data){

                return redirect('/admin/role')->with('success','修改成功');
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
        //
        try{
            $data= Role::where('id',$id)->delete();

            if($data){

                return redirect('/admin/role')->with('success','删除成功');
            }
        }catch(\Exception $e){

            return back()->with('error','删除失败');
        }


    }
}
