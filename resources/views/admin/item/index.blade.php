@extends('admin.layouts.app')
@section('title','Items')
@section('head-title','Items')
@section('toobar')
<button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">Create New Item</button>
@endsection
@section('content')
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Item Number</th>
                <th>Cost Price</th>
                <th>sell Price </th>
                <th>Stock </th>
                <th>Unit Type</th>
                <th>Reward (%)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="itemData">
            @foreach($items as $item)
            <tr id="item-{{ $item->id }}" data-name="{{ $item->title }}">
                <td>{{$item->title}}</td>
                <td>{{$item->number}}</td>
                <td>{{$item->cost_price}}</td>
                <td>{{$item->sell_price}}</td>
                <td>{{$item->stock}}</td>
                <td>{{$item->unit}}</td>
                <td>{{ $item->reward_percentage }}</td>
                <td>
                    <button class="btn btn-primary btn-sm" data-item="{{$item->toJson()}}" onclick="initEdit(this);">Edit</button>
                    @if(env('multi_stock',false))
                        <a href="{{route('center-stock',['id'=>$item->id])}}" class="btn btn-primary btn-sm"  >Stock</a>
                    @endif
                    <button class="btn btn-danger btn-sm" onclick="removeData({{$item->id}});">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- modal -->

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" data-ff="iname">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create New Item</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="form_validation" onsubmit="return saveData(event);">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Item Name</label>
                                <div class="form-group">
                                    <input type="text" id="iname" name="name" class="form-control next" data-next="inum" placeholder="Enter item name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Item Number</label>
                                <div class="form-group">
                                    <input type="text" id="inum" name="number" class="form-control next" data-next="cprice" placeholder="Enter unique item number" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="cprice">Cost Price</label>
                                <div class="form-group">
                                    <input type="number" id="cprice" name="cost_price" min="0" class="form-control next" data-next="sprice" placeholder="Enter cost price" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="sprice">Sell Price</label>
                                <div class="form-group">
                                    <input type="number" id="sprice" name="sell_price" min="0" class="form-control next" data-next="stock" placeholder="Enter sell price" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="stock">Stock</label>
                                <div class="form-group">
                                    <input type="number" id="stock" name="stock" min="0" class="form-control next" data-next="unit" placeholder="Enter stock" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="unit">Unit Type</label>
                                <div class="form-group">
                                    <input type="text" id="unit" name="unit" class="form-control next" data-next="reward" placeholder="Enter unit type" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="unit">Reward (%)</label>
                                <div class="form-group">
                                    <input type="number" id="reward" name="reward" step="0.001" min="0" value="0" class="form-control" placeholder="Enter item reward percentage" >
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-raised btn-primary waves-effect" type="submit">Submit Data</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- edit modal -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-ff="ename">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Edit Item</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="editform" onsubmit="return editData(event);">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Item Name</label>
                                <input type="hidden" name="id" id="eid">
                                <div class="form-group">
                                    <input type="text" id="ename" name="name" class="form-control next" data-next="einum" placeholder="Enter item name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Item Number</label>
                                <div class="form-group">
                                    <input type="text" id="einum" name="number" class="form-control next" data-next="ecprice" placeholder="Enter unique item number" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="cprice">Cost Price</label>
                                <div class="form-group">
                                    <input type="number" id="ecprice" name="cost_price" min="0" class="form-control next" data-next="esprice" placeholder="Enter cost price" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="sprice">Sell Price</label>
                                <div class="form-group">
                                    <input type="number" id="esprice" name="sell_price" min="0" class="form-control next" data-next="estock" placeholder="Enter sell price" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="stock">Stock</label>
                                <div class="form-group">
                                    <input type="number" id="estock" name="stock" min="0" class="form-control next" data-next="eunit" placeholder="Enter stock" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="stock">Unit Type</label>
                                <div class="form-group">
                                    <input type="text" id="eunit" name="unit" class="form-control" placeholder="Enter unit type" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="unit">Reward (%)</label>
                                <div class="form-group">
                                    <input type="number" id="ereward" name="reward" step="0.001" min="0" class="form-control" placeholder="Enter item reward percentage" >
                                </div>
                            </div>

                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-raised btn-primary waves-effect" type="submit">Update Data</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    initTableSearch('sid', 'itemData', ['name']);
    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("admin.item.save")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Item added successfully!');
                $('#largeModal').modal('toggle');
                $('#form_validation').trigger("reset")
                $('#itemData').prepend(response.data);
            })
            .catch(function(response) {
                showNotification('bg-danger','Item Number already exist!');
                //handle error
                console.log(response);
            });
    }

    function initEdit(e) {
        var item = JSON.parse(e.dataset.item);
        console.log(item);
        $('#eid').val(item.id);
        $('#ename').val(item.title);
        $('#ecprice').val(item.cost_price);
        $('#esprice').val(item.sell_price);
        $('#estock').val(item.stock);
        $('#eunit').val(item.unit);
        $('#einum').val(item.number);
        $('#ereward').val(item.reward_percentage);
        $('#editModal').modal('show');
    }

    function editData(e) {
        e.preventDefault();
        var trid = $('#eid').val();
        var dataBody = new FormData(document.getElementById('editform'));
        axios({
                method: 'post',
                url: '/admin/item-update',
                data: dataBody,
            })
            .then(function(response) {
                showNotification('bg-success', 'Item updated successfully!');
                $('#editModal').modal('toggle');
                $('#item-' + trid).replaceWith(response.data);
            })
            .catch(function(response) {
                console.log(response);
            })
    }

    // delete item
    function removeData(id) {
        if (confirm('Are you sure?')) {
            axios({
                    method: 'get',
                    url: '/admin/item-delete/' + id,
                })
                .then(function(response) {
                    showNotification('bg-danger', 'Item deleted successfully!');
                    $('#item-' + id).remove();
                })
                .catch(function(response) {
                    showNotification('bg-danger','You do not have authority to delete!');

                    console.log(response)
                })
        }
    }
</script>
@endsection
