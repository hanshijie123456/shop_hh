@extends('layout.admins')

@section('title',$title)

@section('content')
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span>{{$title}}</span>
    </div>
    <div class="mws-panel-body no-padding">
    	<form action="/admin/category/{{$rs->id}}" method='post' class="mws-form">
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label class="mws-form-label">分类名</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name='catename' value='{{$rs->catename}}'>
    				</div>
    			</div>
    			
    			<div class="mws-form-row">
    				<label class="mws-form-label">父级分类</label>
    				<div class="mws-form-item">
    					<select class="small" name='pid' disabled>
    						<option value='0'>请选择</option>

    						@foreach($info as $k => $v)
                            @if($v->id  == $rs->pid)
    						<option value='{{$v->id}}' selected>{{$v->catename}}</option>
                            @endif

							@endforeach
    						
    					</select>
    				</div>
    			</div>
    			
    		</div>
    		<div class="mws-button-row">
                {{method_field('PUT')}}
    			{{csrf_field()}}
    			<input type="submit" class="btn btn-info" value="修改">
    			
    		</div>
    	</form>
    </div>    	
</div>
@stop