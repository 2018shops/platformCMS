<div class="btn-group">
 <button class="{{$class}}" id="{{$id}}" href="{{$url}}"><i class="fa {{$icon}}"></i> {{$text}}</button>
</div>
<script>
    //审批通过
    $('#approved').unbind('click').click(function() {
        var id = $("*[name='id']").val();
        var business_code = $("*[name='business_code']").val();
        var trans_amt = $("*[name='trans_amt']").val();
        var remark = $("*[name='remark']").val();
        var user_id = $("*[name='user_id']").val();
        var oldstatus = $("*[name='status']").val();
        var destination = $("*[name='remark']").val();
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
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: '/admin/api/postApi',
                        data: {
                            detailId:id,
                            Id:id,
                            card_id:remark,
                            trans_amt:trans_amt,
                            business_code:business_code,
                            status:'2',
                            url:purl,
                            oldstatus:oldstatus,
                            destination:destination
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                if (data.code == '1004' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                            }else{
                                swal('该流水不满足审批条件', '', 'error');
                            }
                            $.pjax.reload('#pjax-container');
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
        var business_code = $("*[name='business_code']").val();
        var trans_amt = $("*[name='trans_amt']").val();
        var remark = $("*[name='remark']").val();
        var user_id = $("*[name='user_id']").val();
        var purl = $(this).attr("href");
        var oldstatus = $("*[name='status']").val();
        var reason = $("#reason").val();
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
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        method: 'get',
                        url: '/admin/api/postApi',
                        data: {
                            detailId:id,
                            Id:id,
                            card_id:remark,
                            trans_amt:trans_amt,
                            business_code:business_code,
                            status:'9',
                            url:purl,
                            oldstatus:oldstatus,
                            reason:reason
                        },
                        success: function (data) {
//                            console.info(typeof data);
//                            alert(data.code);

                            if (typeof data === 'object') {
                                if (data.code == '1004' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                            }else{
                                swal('该流水不满足审批条件', '', 'error');
                            }
                            $.pjax.reload('#pjax-container');
                        }
                    });
                } else {
                    swal("取消！", "您取消了驳回操作","error");
                }
            });

    });
</script>