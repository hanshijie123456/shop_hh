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


    	<form action="/admin/role/{{$rs->id}}" method='post' class="mws-form">
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label class="mws-form-label">角色名</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name='role_name' value="{{$rs->role_name}}">
    				</div>
    			</div>

    			
    		</div>
    		<div class="mws-button-row">
    			{{csrf_field()}}
                {{method_field('PUT')}}
    			<input type="submit" class="btn btn-primary" value="修改">
    			
    			
    		</div>
    	</form>
    </div>    	
</div>
@stop

@section('js')
<script>
	/*setTimeout(function(){

		$('.mws-form-message').fadeOut(2000);

	},5000)*/

	$('.mws-form-message').delay(3000).fadeOut(2000);
</script>

@stop
