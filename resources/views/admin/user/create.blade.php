@extends('adminlte::page')

@section('title', '权限添加')



@section('css')
    <!-- <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css"> -->

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
                            <h3 class="panel-title">用户添加</h3>
                        </div>
                        <div class="panel-body">

                            @include('admin.partials.errors')
                            @include('admin.partials.success')

                            <form class="form-horizontal" role="form" method="POST" action="/admin/user/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label for="tag1" class="col-md-3 control-label">昵称</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="name" id="tag1" value="" autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag2" class="col-md-3 control-label">邮箱</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="email" id="tag2" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag3" class="col-md-3 control-label">密码</label>
                                    <div class="col-md-5">
                                        <input type="password" class="form-control" name="password" id="tag3" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag4" class="col-md-3 control-label">确认密码</label>
                                    <div class="col-md-5">
                                        <input type="password" class="form-control" name="r_password" id="tag4" value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="tag5" class="col-md-3 control-label"><h3>角色列表</h3></label>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            @foreach($roles_all as $v)
                                            <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;">
                                                <span class="checkbox-custom checkbox-default">
                                                    <i class="fa"></i>
                                                    <input class="form-actions"
                                                           @if(in_array($v['id'],$perms['roles']))
                                                           checked
                                                           @endif
                                                           id="inputChekbox{{$v['id']}}" type="Checkbox" value="{{$v['id']}}"
                                                           name="roles[]">
                                                   <label for="inputChekbox{{$v['id']}}">{{$v['display_name']}}
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label"><h3>权限列表</h3></label>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        @foreach($permissions_all as $v)
                                            @if(!empty($v['children']) )
                                            <div class="form-group">
                                                <label class="control-label col-md-3 all-check">
                                                    {{$v['display_name']}}：
                                                </label>
                                                <div class="col-md-6">
                                                    @foreach($v['children'] as $vv)
                                                    <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;">
                                                        <span class="checkbox-custom checkbox-default">
                                                            <i class="fa"></i>
                                                            <input class="form-actions"
                                                                   @if(in_array($vv['id'],$perms['permissions']))
                                                                   checked
                                                                   @endif
                                                                   id="inputChekbox{{$vv['id']}}" type="Checkbox" value="{{$vv['id']}}"
                                                                   name="permissions[]">
                                                           <label for="inputChekbox{{$vv['id']}}">{{$vv['display_name']}}
                                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>
                                            添加
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
    <!-- <script type="text/javascript" src="/vendor/adminlte/plugins/bootstrap-iconpicker-1.9.0/dist/js/bootstrap-iconpicker-iconset-all.min.js"></script> -->
    <!-- Bootstrap-Iconpicker -->
    <!-- <script type="text/javascript" src="/vendor/adminlte/plugins/bootstrap-iconpicker-1.9.0/dist/js/bootstrap-iconpicker.min.js"></script> -->

    <script>
        $(function () {
            $('.all-check').on('click', function () {

            });
        });
    </script>

@endsection
