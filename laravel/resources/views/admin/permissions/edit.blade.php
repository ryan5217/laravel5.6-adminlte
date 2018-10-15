@extends('adminlte::page')

@section('title', '权限添加')



@section('css')

    <!-- Bootstrap-Iconpicker Iconset -->
    <link rel="stylesheet" type="text/css" href="/vendor/adminlte/plugins/bootstrap-iconpicker-1.9.0/dist/css/bootstrap-iconpicker.min.css">

@stop

@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">添加权限</h3>
                        </div>
                        <div class="panel-body">

                            @include('admin.partials.errors')
                            @include('admin.partials.success')

                            <form class="form-horizontal" role="form" method="POST" action="/admin/permissions/update/{{$data->id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" class="form-control" name="pid" id="tag" value="{{$data->pid}}">

                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">权限规则</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" id="tag" value="{{$data->name}}" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">权限名称</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="display_name" id="tag" value="{{$data->display_name}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">图标</label>
                                    <div class="col-md-6">
                                    <button class="btn btn-default" name="icon" data-iconset="fontawesome" data-icon="{{isset($data->icon)?$data->icon:'fa-wifi'}}" role="iconpicker"></button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">权限概述</label>
                                    <div class="col-md-6">
                                        <textarea name="description" class="form-control" rows="3">{{$data->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>
                                            修改
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <!-- Bootstrap-Iconpicker Iconset -->
    <script type="text/javascript" src="/vendor/adminlte/plugins/bootstrap-iconpicker-1.9.0/dist/js/bootstrap-iconpicker-iconset-all.min.js"></script>
    <!-- Bootstrap-Iconpicker -->
    <script type="text/javascript" src="/vendor/adminlte/plugins/bootstrap-iconpicker-1.9.0/dist/js/bootstrap-iconpicker.min.js"></script>

@endsection
