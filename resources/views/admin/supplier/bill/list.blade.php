@foreach($bills as $bill)
<tr id="supplier-bill-{{$bill->id}}" data-name="{{ $bill->user->name }}" data-billno="{{ $bill->billno }}" class="searchable">
    <td>{{ _nepalidate($bill->date) }}</td>
    <td>{{ $bill->user->name }}</td>
    <td>{{ $bill->billno }}</td>
    <td>{{ $bill->transport_charge }}</td>
    <td>{{ $bill->total }}</td>
    <td>{{ $bill->paid }}</td>
    <td>{{ $bill->total - $bill->paid }}</td>
    <td>
        <button  type="button" class="btn btn-primary btn-sm editfarmer" onclick="showItems({{$bill->id}});" >View Items</button>
        <a  type="a" class="btn btn-primary btn-sm editfarmer" target="_blank" href="{{route('admin.supplier.bill.item.detail',['bill'=>$bill->id])}}">Detail</a>
        <button class="btn btn-danger btn-sm" onclick="removeData({{$bill->id}});">Delete</button>
    </td>
</tr>
@endforeach
