@extends('layout.admins')

@section('title',$title)

@section('content')
<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>{{$title}}</span>
    </div>
    <div class="mws-panel-body no-padding">

    <form action="/admin/user" id='art_form' method='post' enctype='multipart/form-data' class="mws-form">
        <div class="mws-form-inline">
            <div class="mws-form-row">
                <label class="mws-form-label">头像</label>
                <div class="mws-form-item">

                    <img src="{{$rs->profile}}" id='imgs' alt="">

                    <div style="position: relative;" class="fileinput-holder">
                        <input type="file" id='file_upload' name='profile' style="position: absolute; top: 0px; right: 0px; margin: 0px; cursor: pointer; font-size: 999px; opacity: 0; z-index: 999;">

                    </div>
                </div>
            </div>
        </div>
        <div class="mws-button-row">
            <!-- {{csrf_field()}}
            <input type="submit" class="btn btn-primary" value="添加"> -->
        </div>
    </form>
    </div>      
</div>

@stop

@section('js')
<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

$(function () {
    $("#file_upload").change(function () {
        uploadImage();
    })
})

function uploadImage() {
//  判断是否有选择上传文件
    var imgPath = $("#file_upload").val();

    if (imgPath == "") {
        alert("请选择上传图片！");
        return;
    }

    //判断上传文件的后缀名
    var strExtension = imgPath.substr(imgPath.lastIndexOf('.') + 1);
    if (strExtension != 'jpg' && strExtension != 'gif'
        && strExtension != 'png' && strExtension != 'bmp') {
        alert("选择图片文件类型错误");
        return;
    }

    var formData = new FormData($('#art_form')[0]);

    $.ajax({
        type: "POST",
        url: "/admin/doprofile",
        data: formData,
        contentType: false,
        processData: false,

        success: function(data) {

            // console.log(data);

            $('#imgs').attr('src',data);

            location.href = '/admin';

            // $('#art_thumb').val(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("上传失败，请检查网络后重试");
        }
    });
}
</script>


@stop