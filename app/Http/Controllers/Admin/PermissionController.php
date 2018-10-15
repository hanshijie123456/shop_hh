<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Admin\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $rs = Permission::where('per_name','like','%'.$request->per_name.'%')->
        paginate($request->input('num',5));

        return view('admin.permission.index',[

            'title'=>'角色权限列表页面',
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
        //
        return view('admin.permission.add',[
            'title'=>'角色权限的添加页面'

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rs = $request->except('_token');

        try{
           
            $data = Permission::create($rs);


            if($data){

                return redirect('/admin/permission')->with('success','添加成功');
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
        $rs = Permission::find($id);

        return view('admin.permission.edit',[
            'title'=>'角色权限修改页面',
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
        $rs = $request->except('_token','_method');
       
        try{
           
            $data = Permission::where('id',$id)->update($rs);

            if($data){

                return redirect('/admin/permission')->with('success','修改成功');
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
           
            $data = Permission::where('id',$id)->delete();

            if($data){

                return redirect('/admin/permission')->with('success','删除成功');
            }
        }catch(\Exception $e){

            return back()->with('error','删除失败');

        }

    }
}
