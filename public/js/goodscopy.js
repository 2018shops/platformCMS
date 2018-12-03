//审核通过
$('#goods_copy').unbind('click').click(function() {
    // var url = "$url".replace('_gender_', $(this).val());

    var id = $("*[name='id']").val();
    var href = $(this).attr("href");

    swal({
            title: "复制该商品?",
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
                            // $.pjax.reload('#pjax-container');
                            // window.open('http://shopping.com/admin/goods/info/'+data.id+'/edit');
                            window.location.href = '/admin/goods/info/'+data.id+'/edit';
                            // {{redirect('/admin/goods/info/' + data.id + edit);}}
                        }
                    }
                });
            } else {
                swal("取消！", "取消复制","error");
            }
        });

});