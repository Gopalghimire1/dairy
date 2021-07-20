<tr id="customer_{{$customer->id}}" >
    <td>
        {{$customer->id}}
    </td>
    <td>
        {{$customer->user->name}}
    </td>
    <td>
        {{$customer->user->phone}}
    </td>
    <td>
        {{$customer->user->address}}
    </td>
    <td>
        @if ($customer->user->amount>0)
            {{ $customer->user->amount}} {{$customer->user->amounttype==1?"CR":"DR"}}
        @else
            --
        @endif
    </td>
    <td>
        <button class="btn btn-sm btn-primary" data-info="{{$customer->basicInfo()}}" onclick="initEdit(this)">Edit</button>
        <a  target="_blank" href="{{ route("admin.customer.detail",['id'=>$customer->user_id]) }}" class="btn btn-sm btn-secondary">Detail</a>
        <button class="btn btn-sm btn-danger">Del</button>
    </td>
    
</tr>