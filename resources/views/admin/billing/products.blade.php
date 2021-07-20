<div class="prodviwer">
    <table class="w-100 prodtable">
        <tr>
            <th>Itemno</th>
            <th>Name</th>
            <th>Rate</th>
        </tr>
        @foreach (\App\Models\Item::all() as $product)
        <tr  class="hovertr" id="prod_{{$product->number}}" data-product="{{$product->toJson()}}">
            <td>{{$product->number}}</td>
            <td>{{$product->title}}</td>
            <td>{{$product->sell_price}}</td>
        </tr>
        @endforeach
    </table>
</div>
