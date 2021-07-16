<tr id="advancerow-{{$advance->id}}">
    <td><input type="text" name="title" class="form-control" id="title-{{$advance->id}}" value="{{$advance->title}}"></td>
    <td>
        {{$advance->employee->user->name}}

    </td>
    <td>
        <input class="form-control" type="numneric" id="amount-{{$advance->id}}" value="{{$advance->amount}}">
    </td>
    <td>
        <button class="btn btn-sm btn-success" onclick="update({{$advance->id}})">Update</button>
        <button class="btn btn-sm btn-danger" onclick="del({{$advance->id}})">Delete</button>
    </td>
</tr>
