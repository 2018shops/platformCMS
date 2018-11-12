<div class="btn-group">
    <button class="{{$class}}" id="{{$id}}" href="{{$url}}"><i class="fa {{$icon}}"></i> {{$text}}</button>
</div>
<script>
    //发起审批
    $('#initiate').unbind('click').click(function () {
        var id = $("*[name='id']").val();
        var total_price = $("*[name='total_price']").val();
        var status = $("*[name='status']").val();
        var purl = $(this).attr("href");
        var but_name = '';
        swal({
                title: "确认发起审批?",
                text: "发起审批成功!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: but_name,
                cancelButtonText: "取消发起",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: '/admin/api/codeLaunchApi',
                        data: {
                            detailId: id,
                            trans_amt: total_price,
                            status: status,
                            url: purl,
                        },
                        success: function (data) {
                            if (data.code === '0000') {
                                swal(data.message, '', 'success');
                            } else {
                                swal(data.message, '', 'error');
                            }

                            $.pjax.reload('#pjax-container');
                        }
                    });
                } else {
                    swal("取消！", "您取消了审批操作", "error");
                }
            });

    });
    //审批通过
    $('#approved').unbind('click').click(function () {
        var id = $("*[name='id']").val();
        var user_id = $("*[name='user_id']").val();
        var status = $("*[name='status']").val();
        var code_type = $("*[name='code_type']").val();
        var purl = $(this).attr("href");
        var but_name = '';
        swal({
                title: "确认执行审批?",
                text: "审批成功!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: but_name,
                cancelButtonText: "取消审批",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: '/admin/api/codeGrantApi',
                        data: {
                            detailId: id,
                            user_id: user_id,
                            status: status,
                            code_type: code_type,
                            result: 'true',
                            url: purl,
                        },
                        success: function (data) {
                            if (data.code === '0000') {
                                swal(data.message, '', 'success');
                            } else {
                                swal(data, '', 'error');
                            }
                            $.pjax.reload('#pjax-container');
                        }
                    });
                } else {
                    swal("取消！", "您取消了审批操作", "error");
                }
            });

    });
    //审批驳回
    $('#reject').unbind('click').click(function () {
        var id = $("*[name='id']").val();
        var user_id = $("*[name='user_id']").val();
        var status = $("*[name='status']").val();
        var code_type = $("*[name='code_type']").val();
        var reason = $("*[name='reason']").val();
        var purl = $(this).attr("href");
        var but_name = '';

        swal({
                title: "确认执行驳回?",
                text: "审批驳回后,将进入审批重新提交环节！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认驳回",
                cancelButtonText: "取消驳回",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: '/admin/api/codeGrantApi',
                        data: {
                            detailId: id,
                            user_id: user_id,
                            status: status,
                            code_type: code_type,
                            reason: reason,
                            result: 'false',
                            url: purl,
                        },
                        success: function (data) {
                            if (data.code === '0000') {
                                swal(data.message, '', 'success');
                            } else {
                                swal(data, '', 'error');
                            }
                            $.pjax.reload('#pjax-container');
                        }
                    });
                } else {
                    swal("取消！", "您取消了审批操作", "error");
                }
            });

    });
    //使用激活码审批通过
    $('#allow').unbind('click').click(function () {
        var id = $("*[name='id']").val();
        var user_id = $("*[name='user_id']").val();
        var reason = $("*[name='reason']").val();
        var status = $("*[name='status']").val();
        var purl = $(this).attr("href");
        swal({
                title: "确认执行审批?",
                text: "审批成功!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "取消审批",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: '/admin/api/codeGrantApi',
                        data: {
                            code_id: id,
                            user_id: user_id,
                            reason: reason,
                            status: status,
                            result: 'true',
                            url: purl,
                        },
                        success: function (data) {
                            if (data.code === '0000') {
                                swal(data.message, '', 'success');
                            } else {
                                swal(data, '', 'error');
                            }
                            $.pjax.reload('#pjax-container');
                        }
                    });
                } else {
                    swal("取消！", "您取消了审批操作", "error");
                }
            });

    });
    //使用激活码审批不通过
    $('#refuse').unbind('click').click(function () {
        var id = $("*[name='id']").val();
        var user_id = $("*[name='user_id']").val();
        var reason = $("*[name='reason']").val();
        var status = $("*[name='status']").val();
        var purl = $(this).attr("href");
        var but_name = '';
        swal({
                title: "确认执行驳回?",
                text: "审批驳回!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: but_name,
                cancelButtonText: "取消驳回",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: '/admin/api/codeGrantApi',
                        data: {
                            code_id: id,
                            user_id: user_id,
                            reason: reason,
                            status: status,
                            result: 'false',
                            url: purl,
                        },
                        success: function (data) {
                            if (data.code === '0000') {
                                swal(data.message, '', 'success');
                            } else {
                                swal(data, '', 'error');
                            }
                            $.pjax.reload('#pjax-container');
                        }
                    });
                } else {
                    swal("取消！", "您取消了驳回操作", "error");
                }
            });

    });
</script>