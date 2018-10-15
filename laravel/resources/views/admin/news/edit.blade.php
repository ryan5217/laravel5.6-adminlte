@include('UEditor::head')
@extends('adminlte::page')

@section('title', '权限添加')

@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">新闻添加</h3>
                        </div>
                        <div class="panel-body">

                            @include('admin.partials.errors')
                            @include('admin.partials.success')

                            <form class="form-horizontal" role="form" method="POST" action="/admin/news/update/{{$data->id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">语言</label>
                                    <div class="col-md-5">
                                        <label class="radio-inline">
                                            <input type="radio" name="lang" id="tag" value="1" {{$data->lang ==2?'':'checked'}}> 中文
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="lang" id="tag" value="2" {{$data->lang ==2?'checked':''}}> English
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag1" class="col-md-3 control-label">标签</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="tag_name" id="tag1" value="{{$data->tag_name}}" autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag2" class="col-md-3 control-label">标题</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="title" id="tag2" value="{{$data->title}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag3" class="col-md-3 control-label">内容</label>
                                    <div class="col-md-9">
                                    {{--<textarea class="form-control" name="content" id="tag3"></textarea>--}}
                                    <!-- 加载编辑器的容器 -->
                                        <script id="container" name="content" type="text/plain">{!! $data->content !!}</script>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag4" class="col-md-3 control-label">链接</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="link" id="tag4" value="{{$data->link}}">
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
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        });
    </script>
@endsection
