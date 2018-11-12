<div class="btn-group">
 <button class="{{$class}}" id="{{$id}}" href="{{$url}}"><i class="fa {{$icon}}"></i> {{$text}}</button>
</div>
<script>
    //审批通过
    $('#approved').unbind('click').click(function() {
        // $.pjax.reload('#pjax-container');

        var id = $("*[name='id']").val();
        var module = $("*[name='module']").val();
        var approv_state = $("*[name='approv_state']").val();
        var but_name = '';

        switch(approv_state){
            case '' : but_name = '提交审批';
                break;
            case '-1' : but_name = '审批通过';
                break;
            case '2' : but_name = '重新提交审批';
                break;
            default : but_name = '审批通过';
        }

        swal({
                title: "确认执行审批?",
                text: "审批通过后,将进入下一环节！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: but_name,
                cancelButtonText: "取消审批",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: '/admin/workflow.approval',
                        data: {
                            m:module,
                            id:id,
                            state:approv_state
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                if (data.code == '0000' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                                $.pjax.reload('#pjax-container');
                            }
                        }
                    });
                } else {
                    swal("取消！", "您取消了审批操作","error");
                }
            });

    });
    //审批驳回
    $('#reject').unbind('click').click(function() {
        // var url = "$url".replace('_gender_', $(this).val());
        var id = $("*[name='id']").val();
        var module = $("*[name='module']").val();

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
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: '/admin/workflow.reject',
                        data: {
                            m:module,
                            id:id
                        },
                        success: function (data) {
                            console.info(data);
                            if (typeof data === 'object') {
                                if (data.code == '0000' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                                $.pjax.reload('#pjax-container');
                            }
                        }
                    });
                } else {
                    swal("取消！", "您取消了驳回操作","error");
                }
            });

    });

    //用户升级
    $('#userupgrade').unbind('click').click(function() {
        // var url = "$url".replace('_gender_', $(this).val());

        var id = $("*[name='id']").val();
        var module = $("*[name='module']").val();
        var approv_state = $("*[name='approv_state']").val();
        var href = $(this).attr("href");

        swal({
                title: "用户升级提交审核?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认提交",
                cancelButtonText: "取消提交",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: href,
                        data: {
                            m:module,
                            id:id
                        },
                        success: function (data) {
                            console.info(data);
                            if (typeof data === 'object') {
                                if (data.code == '0000' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                                $.pjax.reload('#pjax-container');
                            }
                        }
                    });
                } else {
                    swal("取消！", "用户升级已取消","error");
                }
            });

    });

    //用户撤回
    $('#withdraw').unbind('click').click(function() {
        // var url = "$url".replace('_gender_', $(this).val());

        var id = $("*[name='id']").val();
        var module = $("*[name='module']").val();
        var approv_state = $("*[name='approv_state']").val();
        var href = $(this).attr("href");

        swal({
                title: "用户升级撤回审核?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认撤回",
                cancelButtonText: "取消撤回",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: href,
                        data: {
                            m:module,
                            id:id
                        },
                        success: function (data) {
                            console.info(data);
                            if (typeof data === 'object') {
                                if (data.code == '0000' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                                $.pjax.reload('#pjax-container');
                            }
                        }
                    });
                } else {
                    swal("取消！", "用户升级撤回","error");
                }
            });

    });

    //审核通过
    $('#examineadopt').unbind('click').click(function() {
        // var url = "$url".replace('_gender_', $(this).val());

        var id = $("*[name='id']").val();
        var module = $("*[name='module']").val();
        var approv_state = $("*[name='approv_state']").val();
        var href = $(this).attr("href");
        swal({
                title: "通过审核?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认提交",
                cancelButtonText: "取消提交",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: href,
                        data: {
                            m:module,
                            id:id
                        },
                        success:function (data) {
                            console.info(data);
                            if (typeof data === 'object') {
                                if (data.code == '0000' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                                $.pjax.reload('#pjax-container');
                            }
                        }
                    });
                } else {
                    swal("取消！", "审核已取消","error");
                }
            });

    });

    //审核驳回
    $('#examinereject').unbind('click').click(function() {
        // var url = "$url".replace('_gender_', $(this).val());

        var id = $("*[name='id']").val();
        var module = $("*[name='module']").val();
        var approv_state = $("*[name='approv_state']").val();
        var href = $(this).attr("href");

        swal({
                title: "驳回审核?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认提交",
                cancelButtonText: "取消提交",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: href,
                        data: {
                            m:module,
                            id:id
                        },
                        success: function (data) {
                            console.info(data);
                            if (typeof data === 'object') {
                                if (data.code == '0000' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                                $.pjax.reload('#pjax-container');
                            }
                        }
                    });
                } else {
                    swal("取消！", "驳回审核已取消","error");
                }
            });

    });
</script>