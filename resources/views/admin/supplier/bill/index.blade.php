@extends('admin.layouts.app')
@section('title', 'Supplier Bill')
@section('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title', 'Supplier Bill')
@section('toobar')
    <button class="btn btn-primary" onclick="$('#addBill').addClass('shown');">Add Bill</button>

@endsection
@section('content')
    <div class="row mb-2">
        <div class="col-md-12">
            <label for="name">Choose Supplier</label>
            <select name="user_id" id="supplier_id" class="form-control show-tick ms select2" data-placeholder="Select"
                required>
                <option value="-1">All</option>
                @foreach (\App\Models\User::where('role', 3)->get() as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @include('admin.supplier.bill.add')

    <div class="pt-2 pb-2">
        @include('admin.layouts.daterange')
    </div>
    <div class="row ">
        <div class="col-md-12">
            <button class="btn btn-primary" onclick="loadData()">Load Data</button>
        </div>
    </div>
    <hr>
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
                            <table id="newstable1"
                                class="table table-bordered table-striped table-hover js-basic-example dataTable">
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

    @include('admin.supplier.bill.addItem')
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
    @include('admin.js')
    <script>
        function showItems(ele) {
            axios({
                    method: 'post',
                    url: '{{ route('admin.supplier.bill.item.list') }}',
                    data: {
                        bill_id: ele
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
                    url: '{{ route('admin.supplier.bill.update') }}',
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

        function loadData() {

            var data={
                'year':$('#year').val(),
                'month':$('#month').val(),
                'session':$('#session').val(),
                'week':$('#week').val(),
                'center_id':$('#center_id').val(),
                'date1':$('#date1').val(),
                'date2': $('#date2').val(),
                'type':$('#type').val(),
                'user_id':$('#supplier_id').val()
            };
            axios({
                    method: 'post',
                    url: '{{ route('admin.supplier.bill.list') }}',
                    data:data
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
        }

        // delete
        function removeData(id) {
            var dataid = id;
            if (confirm('Are you sure?')) {
                axios({
                        method: 'get',
                        url: '{{ route('admin.supplier.bill.delete') }}',
                        data: {
                            "id": id
                        },
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

        window.onload = function() {
            $('#type').val(0).change();
            loadData();
        };



    </script>
@endsection
