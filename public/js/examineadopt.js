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