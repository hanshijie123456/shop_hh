<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Admin\Category;
use App\Model\Admin\Goods;
use App\Model\Admin\Goodsimg;
use DB;
use Config;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         //多条件查询
         $rs = Goods::orderBy('id','asc')
            ->where(function($query) use($request){
                //检测关键字
                $gname = $request->input('gname');
                $price = $request->input('price');
                //如果用户名不为空
                if(!empty($gname)) {
                    $query->where('gname','like','%'.$gname.'%');
                }
                //如果邮箱不为空
                if(!empty($price)) {
                    $query->where('price','like','%'.$price.'%');
                }
            })
            ->paginate($request->input('num', 10));

        return view('admin.goods.index',[
            'title'=>'用户名列表页',
            'rs'=>$rs,
            'request'=>$request

        ]);
        // return view('admin.goods.index',['title'=>'商品列表页']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $rs = Category::select(DB::raw('*,concat(path,id) as paths'))->
        orderBy('paths')->get();
        

         foreach($rs as $k => $v){
            //path  0,1,4

            $n = substr_count($v -> path, ',') - 1;

            $v->catename = str_repeat('&nbsp;', $n * 8).'|--'.$v -> catename;

            // $v->catename = str_repeat('|--', $n).$v -> catename;
        }
        return view('admin.goods.add',[
            'title'=>'商品添加页面',
            'rs'=>$rs

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
        //表单验证

        //
        $rs = $request->except('_token','gimg');

        $data = Goods::create($rs);

        $id = $data->id;

        $gd = $data::find($id);

        //处理图片
        if($request->hasFile('gimg')){

            $files = $request->file('gimg');

            //
            $gm = [];
            foreach($files as $k => $v){

                $info = [];

                $gname = time().rand(1111,9999);

                $suffix = $v->getClientOriginalExtension();

                $v->move(Config::get('app.uploads').'/goods/', $gname.'.'.$suffix);

                $info['gimg'] = '/uploads/goods/'.$gname.'.'.$suffix;

                $gm[] = $info;

            }
        }

        //添加数据
        try{
            //关联模型
            $cds = $gd->gimgs()->createMany($gm);

            if($cds){

                return redirect('/admin/goods')->with('success','添加成功');
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
        //根据id获取存储图片的路经信息

        //删除数据表里面的图片信息   还删除uploads信息吗??
        $info = Goodsimg::find($id);

        $path = $info->gimg;

        $data = unlink('.'.$path);

        if(!$data){

            return back()->with('error','删除图片失败');

        }

        $rs = Goodsimg::where('id',$id)->delete();

        if(!$rs){

            return back()->with('error','删除数据失败');
        }

        echo 1;
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

        $rs = Category::select(DB::raw('*,concat(path,id) as paths'))->
        orderBy('paths')->get();
        

         foreach($rs as $k => $v){
            //path  0,1,4

            $n = substr_count($v -> path, ',') - 1;

            $v->catename = str_repeat('&nbsp;', $n * 8).'|--'.$v -> catename;

            // $v->catename = str_repeat('|--', $n).$v -> catename;
        }

        $res = Goods::find($id);

        //根据id查询相关的商品图片信息
        $gimg = Goodsimg::where('gid',$id)->get();

        return view('admin.goods.edit',[
            'title'=>'商品的修改页面',
            'rs'=>$rs,
            'res'=>$res,
            'gimg'=>$gimg

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
        //表单验证

        //获取表单信息
        $res = $request->except('_token','_method','gimg');

        // dd($res);


      /*  $id = $data->id;

        $gd = $data::find($id);*/

        //处理图片
        if($request->hasFile('gimg')){

            $files = $request->file('gimg');

            //
            $gm = [];
            foreach($files as $k => $v){

                $info = [];

                $gname = time().rand(1111,9999);

                $suffix = $v->getClientOriginalExtension();

                $v->move(Config::get('app.uploads').'/goods/', $gname.'.'.$suffix);

                $info['gid'] = $id;

                $info['gimg'] = '/uploads/goods/'.$gname.'.'.$suffix;

                $gm[] = $info;

            }

         //文件上传   商品详情的图片
        DB::table('goodsimg')->insert($gm);

        }
          //添加数据
        try{
            //关联模型
            // $cds = $gd->gimgs()->saveMany($gm);
            $data = Goods::where('id',$id)->update($res);

            if($data){

                return redirect('/admin/goods')->with('success','修改成功');
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
        //根据id获取图片的路径 unlink
        $res = Goodsimg::where('gid',$id)->get();

        // dd($res);

        foreach($res as $k=>$v){

            $path = $v->gimg;
            $info = unlink('.'.$path);
        }
      

        //判断
        // if()

        //关联删除   删除商品的信息  goods 
        $goods = Goods::find($id);

        $goods->delete();
        //删除商品的图片的信息  goodsimg
        try{
            //关联模型
            $rs = $goods->gimgs()->delete();

            if($rs){

                return redirect('/admin/goods')->with('success','删除成功');
            }
        }catch(\Exception $e){

            return back()->with('error','删除失败');

        }

    }
}
