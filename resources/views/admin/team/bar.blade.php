<div id="look-user-up"></div>

@if(isset($groups['data']))
    @foreach($groups['data'] as $val)
        <div class="form-group">
            <lable class="col-sm-2 control-label">{{$val['level_name']}}</lable>
            <div style = "float:left;margin-left: 25px;">
                <span style="color:#3c8dbc;">{{$val['user_id']}}</span>
                <br>
                <span style="display:inline-block;color:#3c8dbc;"> {{$val['user_name']}} </span>
            </div>
        </div>
        <hr>
    @endforeach
@else
    <h1>无上级信息</h1>
@endif