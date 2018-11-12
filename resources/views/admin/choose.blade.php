<div class="form-group ">
    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <div class="col-sm-8">
        <input type ="text" id="img_id" name = "attr1" class="pull-left p-1" readonly="readonly"/>
        <input type ="hidden" id="hidden_id" name = "attr1" class="pull-left p-1"/>
        <button type="button"  id = "{{$id}}"><i class='fa fa-eye'>选择</i>&nbsp;&nbsp;</button>
    </div>
</div>
{{--<div>--}}
    {{--@if($data)--}}
        {{--@foreach($data as $val)--}}
            {{--<table class="table">--}}
                {{--<tr>--}}
                    {{--<td>id</td>--}}
                    {{--<td>name</td>--}}
                {{--</tr>--}}
                {{--<tr id = {{$val}} onclick="changetext(\'{{$val}}\')">--}}
                    {{--<td>{{$val}}</td>--}}
                    {{--<td>{{$val}}</td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--@endforeach--}}
    {{--@else--}}
        {{--<h1>--}}
    {{--@endif--}}
{{--</div>--}}


<script>$('#' + '{{$id}}').unbind('click').click(function() {
        var url = "$url".replace('_gender_', $(this).val());
        var id = $("*[name='id']").val();
        var module = $("*[name='module']").val();
        var approv_state = $("*[name='approv_state']").val();
        var but_name = '';



        $.get('/admin/api/getId',function(data){
            console.log(data);


            var htmlStr = '';
            htmlStr += '<table class="table"><tr><td>id</td><td>name</td></tr>';
            data.forEach(function(item,index){
                htmlStr += '<tr id = ' + item.id + ' onclick="changetext(\''+item.id+'\')"><td>' + item.id + ' </td><td>' + item.text + '</td></tr>';


                //                        console.log(item)
            });
            htmlStr += '</table>';



            swal({
                        title : '',
                        text : htmlStr,
                        html : true,
                        timer : 10000,
                        confirmButtonText: "确定",
                        cancelButtonText: "取消",
                        showCancelButton: true,
                    },
                    function(isConfirm){
                        if (isConfirm) {

                            $('#img_id').val($('#hidden_id').val());
                        }
                    });
        })
    });
    function changetext(id){
        console.log(id);
        console.log($(this));
//                $(this).css('background-color','green').siblings().css('background-color','#FFFFFF');
        $('#'+id).css('background-color','red').siblings().css('background-color','#FFFFFF');
        $('#hidden_id').val(id);

    }</script>
