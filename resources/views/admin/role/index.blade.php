@extends('layout.admins')

@section('title',$title)

@section('content')

<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>
            <i class="icon-table">
            </i>
            {{$title}}
        </span>
    </div>
    <div class="mws-panel-body no-padding">
        <div role="grid" class="dataTables_wrapper" id="DataTables_Table_1_wrapper">

        	<form action="/admin/role" method='get'>
            <div id="DataTables_Table_1_length" class="dataTables_length">
                <label>
                    显示
                    <select name="num" size="1" aria-controls="DataTables_Table_1">
                        <option value="5" @if($request->num == 5)  selected="selected"  @endif >
                            5
                        </option>
                        <option value="10" @if($request->num == 10)  selected="selected"  @endif>
                            10
                        </option>
                        <option value="15" @if($request->num == 15)  selected="selected"  @endif>
                            15
                        </option>
                       
                    </select>
                    条数据
                </label>
            </div>
            <div class="dataTables_filter" id="DataTables_Table_1_filter">
                <label>
                    角色名:
                    <input type="text" name='role_name' value='{{$request->role_name}}' aria-controls="DataTables_Table_1">
                   
                </label>

                <button class='btn btn-info'>搜索</button>
            </div>

            </form>


            <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1"
            aria-describedby="DataTables_Table_1_info">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 30px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                            ID
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 160px;" aria-label="Browser: activate to sort column ascending">
                            角色名
                        </th>
                       

                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 97px;" aria-label="CSS grade: activate to sort column ascending">
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
					
					@foreach($rs as $k => $v)
                    <tr class="@if($k % 2 == 0)odd @else even @endif">
                        <td class="">
                            {{$v->id}}
                        </td>
                        <td class=" ">
                            {{$v->role_name}}
                        </td>
                        
                         <td class=" ">

                            <a class='btn btn-info' href="/admin/role_per/{{$v->id}}" title='添加权限'><i class='icon-key-2'></i></a>

                            <a class='btn btn-primary' href="/admin/role/{{$v->id}}/edit">修改</a>

                            <form action="/admin/role/{{$v->id}}" method='post' style='display:inline'>
                                
                                {{csrf_field()}}
                                {{method_field('DELETE')}}

                                <button class='btn btn-danger'>删除</button>

                            </form>

                        </td>
                    </tr>
                    @endforeach

                  
                </tbody>
            </table>
            <div class="dataTables_info" id="DataTables_Table_1_info">
                <a class='btn btn-primary' href="/admin/role/create" title="返回"><i class='icon-bended-arrow-left'></i></a>
                
            </div>
            
            <style>
                .pagination li{
                    float: left;
                    height: 20px;
                    padding: 0 10px;
                    display: block;
                    font-size: 12px;
                    line-height: 20px;
                    text-align: center;
                    cursor: pointer;
                    outline: none;
                    background-color: #444444;
                    color: #fff;
                    text-decoration: none;
                    border-right: 1px solid #232323;
                    border-left: 1px solid #666666;
                    border-right: 1px solid rgba(0, 0, 0, 0.5);
                    border-left: 1px solid rgba(255, 255, 255, 0.15);
                    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.5), inset 0px 1px 0px rgba(255, 255, 255, 0.15);}

                    .pagination li a{
                         color: #fff;
                    }


                    .pagination .active{
                            background-color: #c5d52b;
                            color: #323232;
                    border: none;
                    background-image: none;
                    box-shadow: inset 0px 0px 4px rgba(0, 0, 0, 0.25);
                    }

                    .pagination .disabled{
                        color: #666666;
                        cursor: default;
                    }

                    .pagination{
                        margin:0px;
                    }

            </style>


            <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1paginate">
				
				{{$rs->appends($request->all())->links()}}
            </div>
        </div>
    </div>
</div>
@stop