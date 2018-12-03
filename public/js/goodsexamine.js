//审核通过
$('#examine_pass').unbind('click').click(function() {
    // var url = "$url".replace('_gender_', $(this).val());

    var id = $("*[name='id']").val();
    var href = $(this).attr("href");

    swal({
            title: "审核商品通过?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    method: 'get',
                    url: href,
                    data: {
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
                swal("取消！", "取消审核","error");
            }
        });
});

//审核拒绝
$('#examine_refuse').unbind('click').click(function() {
    // var url = "$url".replace('_gender_', $(this).val());

    var id = $("*[name='id']").val();
    var href = $(this).attr("href");

    swal({
            title: "拒绝商品通过!",
            text: "",
            type: "input",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: false,
            inputPlaceholder: "请填写拒绝理由",
            // showLoaderOnConfirm:true
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    method: 'get',
                    url: href,
                    data: {
                        id:id,
                        text:isConfirm
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
                swal("取消！", "取消复制","error");
            }
        });

});