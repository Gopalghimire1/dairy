<tr id="item-{{ $item->id }}" data-name="{{ $item->title }}">
    <td>{{$item->title}}</td>
    <td>{{$item->number}}</td>
    <td>{{$item->cost_price}}</td>
    <td>{{$item->sell_price}}</td>
    <td>{{$item->stock}}</td>
    <td>{{$item->unit}}</td>
    <td>{{$item->reward_percentage}}</td>
    <td>
        <button  class="btn btn-primary btn-sm" data-item="{{$item->toJson()}}" onclick="initEdit(this);" >Edit</button>
        @if(env('multi_stock',false))
            <a href="{{route('center-stock',['id'=>$item->id])}}" class="btn btn-primary btn-sm"  >Stock</a>
        @endif
        <button class="btn btn-danger btn-sm" onclick="removeData({{$item->id}});">Delete</button>
    </td>
</tr>
