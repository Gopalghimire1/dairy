@extends('admin.layouts.app')
@section('title','Supplier Bill')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Supplier Bill')
@section('toobar')

<div class="p-2">
    <div class="card">
        <div class="body">
            <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label for="name">Choose Supplier</label>
                                <select name="user_id" id="supplier" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                    <option></option>
                                    @foreach(\App\Models\User::where('role',3)->get() as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Bill No.</label>
                                <div class="form-group">
                                    <input type="text" id="billno" name="billno" class="form-control next" data-next="nepali-datepicker" placeholder="Enter supplier bill no." required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="text" name="date" id="nepali-datepicker" class="form-control" placeholder="Date" required>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="ptr"> Particular Items </label>
                                    <select name="" id="ptr" class="form-control show-tick ms select2" data-placeholder="Select">
                                        <option></option>
                                        @foreach(\App\Models\Item::all() as $i)
                                            <option value="{{ $i->toJson() }}"> {{ $i->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-top: 26px;">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#createItems">New Item</button>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="from-group">
                                    <label for="rate"> Rate </label>
                                    <input type="number" onkeyup="singleItemTotal();" class="form-control next" data-next="qty" id="rate" value="0" min="0.001" step="0.001">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="from-group">
                                    <label for="qty"> Quantity </label>
                                    <input type="number" onkeyup="singleItemTotal();" class="form-control next" data-next="total" id="qty" value="1" min="0.001" step="0.001">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="from-group">
                                    <label for="rate"> Total </label>
                                    <input type="number" class="form-control" id="total" value="0" min="0.001" step="0.001">
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-top: 26px;">
                                <div class="from-group">
                                    <span class="btn btn-primary btn-block" id="additem" onclick="addItems();">Add</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <input type="hidden" name="counter" id="counter" val=""/>
                            <div class="col-md-12 mt-4 mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Particular</th>
                                            <th>Rate</th>
                                            <th>Qty</th>
                                            <Th>Total</Th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item_table">

                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    <div style="margin-top: 4px; margin-right: 5px;"><strong> Item Total :</strong></div>
                                    <input type="text" value="0" id="itotal">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="trp">Transportation Charge</label>
                                    <input type="number" name="t_charge" class="form-control next" data-next="_totamt" step="0.001" min="0" placeholder="Enter transportation charge" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total">Total Amount</label>
                                    <input type="number" name="total" id="_totamt" class="form-control next" data-next="paidamt" step="0.001" min="0" placeholder="Enter total bill amount" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total">Paid Amount</label>
                                    <input type="number" name="paid" id="paidamt" class="form-control" value="0" step="0.001" min="0" placeholder="Enter paid amount" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-raised btn-primary waves-effect btn-block" type="submit">Submit Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Supplier Name</th>
                <th>Bill No.</th>
                <th>Transport Charge (Rs.)</th>
                <th>Total (Rs.)</th>
                <th>Paid (Rs.)</th>
                <th>Due (Rs.)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="supplierBillData">

        </tbody>
    </table>
</div>


<!-- edit modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Bill Items</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <div class="table-responsive">
                        <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Rate</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="billitems">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- modal of create new items -->

<div class="modal fade" id="createItems" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create New Item</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="createItem" onsubmit="return createNewItem(event);">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Item Name</label>
                                <div class="form-group">
                                    <input type="text" id="iname" name="name" class="form-control" placeholder="Enter item name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Item Number</label>
                                <div class="form-group">
                                    <input type="number" id="inumber" name="number" class="form-control" min="0" placeholder="Enter item number" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="cprice">Cost Price</label>
                                <div class="form-group">
                                    <input type="number" id="cprice" name="cost_price" min="0" class="form-control" placeholder="Enter cost price" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="sprice">Sell Price</label>
                                <div class="form-group">
                                    <input type="number" id="sprice" name="sell_price" min="0" class="form-control" placeholder="Enter sell price" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="stock">Stock</label>
                                <div class="form-group">
                                    <input type="number" id="stock" name="stock" min="0" class="form-control" placeholder="Enter stock" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="unit">Unit Type</label>
                                <div class="form-group">
                                    <input type="text" id="unit" name="unit" class="form-control" placeholder="Enter unit type" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="unit">Reward (%)</label>
                                <div class="form-group">
                                    <input type="number" id="reward" name="reward" class="form-control" value="0" placeholder="Enter reward" required>
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
@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>

    function showItems(ele) {
        axios({
            method: 'post',
            url: '{{ route("admin.sup.bill.item.list")}}',
            data: {
                bill_id : ele
            }
        })
        .then(function(response) {
            // console.log(response.data);
            $('#billitems').html(response.data);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });
        $('#editModal').modal('show');
    }

    function saveData(e) {
        e.preventDefault();
        if ($('#supplier').val() == '') {
            alert('Please select supplier.');
            $('#supplier').focus();
            return false;
        } else {
            var bodyFormData = new FormData(document.getElementById('form_validation'));
            axios({
                    method: 'post',
                    url: '{{ route("admin.sup.bill.add")}}',
                    data: bodyFormData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    console.log(response);
                    showNotification('bg-success', 'Supplier bill added successfully!');
                    $('#largeModal').modal('toggle');
                    $('#form_validation').trigger("reset")
                    $('#supplierBillData').prepend(response.data);
                    $('#item_table').empty();
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                });
        }
    }

    // edit data
    function editData(e) {
        if ($('#esupplier').val() == '') {
            alert('Please select supplier.');
            $('#supplier').focus();
            return false;
        }
        e.preventDefault();
        var rowid = $('#eid').val();
        var bodyFormData = new FormData(document.getElementById('editform'));
        axios({
                method: 'post',
                url: '{{ route("admin.sup.bill.update")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Updated successfully!');
                $('#editModal').modal('toggle');
                $('#supplier-bill-' + rowid).replaceWith(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    axios({
            method: 'get',
            url: '{{ route("admin.sup.bill.list")}}',
        })
        .then(function(response) {
            // console.log(response.data);
            $('#supplierBillData').html(response.data);
            initTableSearch('sid', 'supplierBillData', ['name', 'billno']);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });

    // delete
    function removeData(id) {
        var dataid = id;
        if (confirm('Are you sure?')) {
            axios({
                    method: 'get',
                    url: '/admin/supplier-bill-delete/' + dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#supplier-bill-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                });
        }
    }
    var i = 0;
    var itemKeys = [];
    // bill items js
    function singleItemTotal() {
        $('#total').val($('#rate').val() * $('#qty').val());
    }

    function addItems() {
        if ($('#ptr').val() == "" || $('#total').val() == 0) {
            alert('Please fill the above related field');
            $("#ptr").focus();
            return false;
        }
        var item = JSON.parse($('#ptr').val()) ;
        // console.log(item);
        html = "<tr id='row-" + i + "'>";
        html += "<td>" + item.title + "<input type='hidden' name='ptr_" + i + "' value='" + item.title + "' /> <input type='hidden' name='item_id_" + i + "' value='" + item.id + "' /></td>";
        html += "<td>" + $('#rate').val() + "<input type='hidden' name='rate_" + i + "' value='" + $('#rate').val() + "'/></td>";
        html += "<td>" + $('#qty').val() + "<input type='hidden' name='qty_" + i + "' value='" + $('#qty').val() + "'/></td>";
        html += "<td>" + $('#total').val() + "<input type='hidden' name='total_" + i + "' id='total_" + i + "' value='" + $('#total').val() + "'/></td>";
        html += "<td> <span class='btn btn-danger btn-sm' onclick='RemoveItem(" + i + ");'>Remove</span></td>";
        html += "</tr>";
        $("#item_table").append(html);
        $('#ptr').val('').change();
        $('#rate').val('0');
        $('#qty').val('1');
        $('#total').val('0');
        itemKeys.push(i);
        i+= 1;
        suffle();
    }

    function suffle(){
        $("#counter").val(itemKeys.join(","));
        calculateTotal();
    }

    function calculateTotal() {
        var itotal = 0;
        for (let index = 0; index < itemKeys.length; index++) {
            const element = itemKeys[index];
            itotal += parseInt($("#total_" + element).val());;
        }
        $('#itotal').val(itotal);
    }

    function RemoveItem(i){
            $('#row-'+i).remove();
             var index=$.inArray(i,itemKeys);
            if(index>-1){
                itemKeys.splice(index,1);
            }
            suffle();
        }

// create new Items

function createNewItem(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('createItem'));
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
                $('#createItems').modal('toggle');
                $('#createNewItem').trigger("reset")
                window.location.reload();
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    window.onload = function() {
        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();
        var edate = document.getElementById("enepali-datepicker");
        edate.nepaliDatePicker();
    };

    $('#total').bind('keydown',function(){
        addItems();
    });
</script>
@endsection
