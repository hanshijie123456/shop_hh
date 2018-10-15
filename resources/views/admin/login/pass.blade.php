@extends('layout.admins')


@section('title',$title)


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


    	<form action="/admin/dopass" method='post' class="mws-form">
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label class="mws-form-label">原密码</label>
    				<div class="mws-form-item">
    					<input type="password" class="small" name='oldpass'>
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">新密码</label>
    				<div class="mws-form-item">
    					<input type="password" class="small" name='password'>
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">确认新密码</label>
    				<div class="mws-form-item">
    					<input type="password" class="small" name='repass'>
    				</div>
    			</div>
    			
    		</div>
    		<div class="mws-button-row">
    			{{csrf_field()}}
    			<input type="submit" class="btn btn-primary" value="修改">
    			
    			
    		</div>
    	</form>
    </div>    	
</div>

@stop