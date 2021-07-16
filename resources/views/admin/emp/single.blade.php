<tr id="employee-{{$user->id}}" data-name="{{ $user->name }}" class="searchable">
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->phone }}</td>
    <td>{{ $user->address }}</td>
    <td>{{ $user->employee()->salary }}</td>
    <td>
        <button  type="button" data-employee="{{$user->toJson()}}" data-acc="{{ $user->employee()->acc }}" data-salary="{{ $user->employee()->salary }}" class="btn btn-primary btn-sm" onclick="initEdit(this);" >Edit</button>
        |
        <a href="{{ route('admin.employee.detail',$user->id) }}" class="btn btn-primary btn-sm">View</a>
        |
        <button class="btn btn-danger btn-sm" onclick="removeData({{$user->id}});">Delete</button></td>
</tr>
