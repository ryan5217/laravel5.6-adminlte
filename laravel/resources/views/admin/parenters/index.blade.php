@extends('adminlte::page')

@section('title', '留言列表')

@section('content_header')
    <h1>留言列表</h1>
@stop

@section('css')
    <!-- <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css"> -->
@stop

@section('content')
    <!-- Default box -->
    <div class="row">
        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">
                @include('admin.partials.errors')
                @include('admin.partials.success')
                {{--<div class="box-header with-border">--}}
                    {{--<a href="#" id="sendCode" style="float: left;" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"> 批量删除</span></a>--}}
                    {{--<a href="/admin/user/create" style="float: right;" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"> 添加</span></a>--}}
                    <!-- <div class="col-md-1"><a href="/admin/node/excel/A" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"> 导出A轮表格</span></a></div>
                    <div class="col-md-2">
                        <select class="form-control">
                            <option><a href="/admin/node/excel/A"><span class="ladda-label"> 导出A轮表格</span></a></option>
                            <option><a href="/admin/node/excel/B"><span class="ladda-label"> 导出B轮表格</span></a></option>
                            <option><a href="/admin/node/excel/C"><span class="ladda-label"> 导出C轮表格</span></a></option>
                        </select>
                    </div> -->
                {{--</div>--}}
                <div class="box-body table-responsive">

                    <table id="tags-table" class="table table-striped table-hover display responsive dataTable dtr-inline">
                        <thead>
                        <tr>
                            <th class="" width="5%">ID</th>
                            <th class="" width="10%">创建时间</th>
                            <th class="">昵称</th>
                            <th class="">邮箱</th>
                            <th class="">主题</th>
                            <th class="">信息</th>
                            {{--<th data-sortable="false">操作</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div><!-- /.box-body -->


            </div><!-- /.box -->
        </div>
    </div>

    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">提示</h4>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <i class="fa fa-question-circle fa-lg"></i>
                        确认要操作这比订单吗?
                    </p>
                </div>
                <div class="modal-footer">
                    <form class="deleteForm" method="POST" action="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="put">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i>确认
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> -->

    <script>
        $(function () {
            var table = $("#tags-table").DataTable({
                pageLength: 25,
                language: {
                    "sProcessing": "处理中...",
                    "sLengthMenu": "显示 _MENU_ 项结果",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                },
                order: [[0, "desc"]],
                serverSide: true,
                searching: false,
                ajax: {
                    url: '/admin/parenter/index',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },

                    // "data": function ( d ) {
                    //     //d.beginDate = $.trim($("#dtBegin").val());
                    //     //d.endDate = $.trim($("#dtEnd").val());
                    //     d.bname = $.trim($("#bname").val());
                    //     d.sname = $.trim($("#sname").val());
                    //     d.order_number = $.trim($("#order_number").val());
                    //     //d.vol_cid_num = $.trim($("#vol_cid_num").val());
                    //     //d.vol_price = $.trim($("#vol_price").val());
                    // }

                },
                columns: [
                    {"data": "id"},
                    {"data": "created_at"},
                    {"data": "nickname"},
                    {"data": "email"},
                    {"data": "position"},
                    {"data": "detail"}
                    // {"data": "action"}
                ],
                // columnDefs: [
                //     {
                //         'targets': -1, "render": function (data, type, row) {
                //             var caozuo = '';
                //             // caozuo += '<a style="margin:3px;" href="#" attr="' + row['mobile_phone'] + '" class="delBtn X-Small btn-xs text-danger "><i class="fa fa-times-circle-o"></i> 删除</a>';
                //             caozuo += '<a href="/admin/user/edit/'+row['id']+'" class="X-Small btn-xs text-primary ">修改</a>';
                //             caozuo += '| <a href="/admin/user/destroy/'+row['id']+'" class="X-Small btn-xs text-primary ">删除</a>'
                //             return caozuo;
                //         }
                //     }
                // ]
            });

            //自增排序
            // table.on('order.dt search.dt', function () {
            //     table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            //         cell.innerHTML = i + 1;
            //     });
            // }).draw();

            // table.on('preXhr.dt', function () {
            //     loadShow();
            // });

            // table.on('draw.dt', function () {
            //     loadFadeOut();
            // });

            $("table").delegate('.delBtn', 'click', function () {
                var id = $(this).attr('attr');
                $('.deleteForm').attr('action', '/admin/user/' + id);
                $("#modal-delete").modal();
            });

            $(".checkall").click(function () {
                var check = $(this).prop("checked");
                $(".checkchild").prop("checked", check);
            });

            $('#sendCode').click(function () {
                text = $("input:checkbox[name='id']:checked").map(function(index,elem) {
                    return $(elem).val();
                }).get().join(',');
                // senddata = $.parseJSON(text);

                if (text.length <= 0){
                    alert('请选择删除的对象');
                    return false
                }
                // $.parseJSON( jsonstr );
                // senddata = new Array(text);
                // console.log(text);
                // return false
                $.ajax({
                    url:'/admin/partenter/delalldata',
                    type:'post',
                    data: {'ids':text},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function (data) {
                        alert('发送成功');
                        // reload();
                        location.reload();
                    },
                    error:function () {

                    }
                })
            });

        });
    </script>
@endsection
