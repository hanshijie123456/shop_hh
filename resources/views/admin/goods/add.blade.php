@extends('layout.admins')



@section('title', $title)

@section('content')
<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>{{$title}}</span>
    </div>
    <div class="mws-panel-body no-padding">

        @if (count($errors) > 0)
            <div class="mws-form-message error">
                错误信息
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="/admin/goods" method='post' enctype='multipart/form-data' class="mws-form">
            <div class="mws-form-inline">
                <div class="mws-form-row">
                    <label class="mws-form-label">分类名</label>
                    <div class="mws-form-item">
                        <select class="small" name='catid'>
                            <option value='0'>请选择</option>

                            @foreach($rs as $k => $v)
                            <option value='{{$v->id}}'>{{$v->catename}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mws-form-row">
                    <label class="mws-form-label">商品名</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" name='gname'>
                    </div>
                </div>

                <div class="mws-form-row">
                    <label class="mws-form-label">价格</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" name='price'>
                    </div>
                </div>

                <div class="mws-form-row">
                    <label class="mws-form-label">库存</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" name='stock'>
                    </div>
                </div>

                <div class="mws-form-row">
                    <label class="mws-form-label">商品图片</label>
                    <div class="mws-form-item">
                        <div style="position: relative;" class="fileinput-holder">

                            <input type="file" name='gimg[]' multiple style="position: absolute; top: 0px; right: 0px; margin: 0px; cursor: pointer; font-size: 999px; opacity: 0; z-index: 999;">
                        </div>
                    </div>
                </div>

                <div class="mws-form-row">
                    <label class="mws-form-label">商品详情</label>
                    <div class="mws-form-item">
                        <script id="editor" name='content' type="text/plain" style="width:800px;height:400px;"></script>
                    </div>
                </div>
                
                <div class="mws-form-row">
                    <label class="mws-form-label">商品状态</label>
                    <div class="mws-form-item clearfix">
                        <ul class="mws-form-list inline">
                            <li><label><input type="radio" name='status' value='1' checked='checked'> 上架</label></li>
                            <li><label><input type="radio" name='status' value='0'> 下架</label></li>
                        
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mws-button-row">
                {{csrf_field()}}
                <input type="submit" class="btn btn-primary" value="添加">
            </div>
        </form>
    </div>      
</div>
@stop

@section('js')
<script>

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

    /*setTimeout(function(){

        $('.mws-form-message').fadeOut(2000);

    },5000)*/

    $('.mws-form-message').delay(3000).fadeOut(2000);
</script>

@stop
