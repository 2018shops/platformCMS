//创建邀请码
$('#createcode').unbind('click').click(function() {
    var href = $(this).attr("href");
    var str = '';
    str = "<select id='user_id' class='form-control roles '>";
    $.ajax({
        method: 'get',
        async: false,
        url: '../workflow.getUserInfo',
        data: {
        },
        success: function (data) {
            console.info(typeof data);

            if (typeof data === 'object') {
                if (data.code == '0000' || data.status) {
                    swal(data.message, '', 'success');
                } else {
                    swal(data.message, '', 'error');
                }
                data.forEach(function(item) {
                    str += "<option value ='"+item.id+"'>"+item.user_name+"</option>";
                })
            }
            str += "</select>";
        }
    });


    swal({
            title: "创建用户",
            // imageUrl: '',
            // title: "确认执行审批?",
            // text: "审批通过后,将进入下一环节！",
            type: "input",
            text: str,
            html:true,
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: '确定',
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: false,
            inputPlaceholder: '输入用户名称'
        },
        function(isConfirm){
            if (isConfirm === "" || isConfirm === '0') {
                swal.showInputError("输入用户名称！");
                return false
            }
            // if(isNaN(isConfirm)){
            //     swal.showInputError("请正确输入数量！");
            //     return false
            // }
            var user_id = $('#user_id').val();

            if (isConfirm) {
                $.ajax({
                    method: 'get',
                    url: href,
                    data: {
                        user_name: isConfirm,
                        recommend_id: user_id
                    },
                    success: function (data) {
                        console.info(typeof data);

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
                swal("取消！", "已取消","error");
            }
        });

});