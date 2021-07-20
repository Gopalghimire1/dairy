<div class="distviwer">
    <div class="pb-3 d-flex justify-content-between">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">New Customer</button>
        <span class="btn btn-danger btn-sm" onclick="hideCustomer();">X</span>
    </div>

    <table class="w-100 prodtable">
        <tr>
            <th>Itemno</th>
            <th>Name</th>
        </tr>
        <tbody id="customers">
            @foreach (\App\Models\Customer::with('user')->get() as $dis)
            <tr  class="hovertr" id="distri_{{$dis->id}}" data-distributor="{{$dis->toJson()}}" onclick="selectCustomer({{$dis->id}},'{{$dis->user->name}}')">
                <td>{{$dis->id}}</td>
                <td>{{$dis->user->name}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
