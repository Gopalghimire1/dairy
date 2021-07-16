@extends('admin.layouts.app')
@section('title','Distributers')
@section('head-title','Distributers')
@section('toobar')
<button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">Create Distributer</button>
@endsection
@section('content')
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Distributer Name</th>
                <th>Distributer phone</th>
                <th>Distributer Address</th>
                {{-- <th>Rate</th>
                <th>Amount</th> --}}
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="distributerData">

        </tbody>
    </table>
</div>

<!-- modal -->

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" data-ff="name">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create Distributer</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Distributer Name</label>
                                <div class="form-group">
                                    <input type="text" id="name" name="name" class="form-control next" data-next="phone" placeholder="Enter distributer name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Distributer Phone</label>
                                <div class="form-group">
                                    <input type="number" id="phone" name="phone" class="form-control next" data-next="address" placeholder="Enter distributer phone" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Distributer Address</label>
                                <div class="form-group">
                                    <input type="text" id="address" name="address" class="form-control " data-next="rate" placeholder="Enter distributer address" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="credit_days">Credit Days</label>
                                <div class="form-group">
                                    <input type="number" id="credit_days" name="credit_days" min="0" step="0.01" class="form-control next" data-next="address" placeholder="Enter Credit Days" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="credit_limit">Credit Limit</label>
                                <div class="form-group">
                                    <input type="number" id="credit_limit" name="credit_limit" min="0" step="0.01" class="form-control next" data-next="address" placeholder="Enter Credit Days" required>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <label for="rate">Rate</label>
                                <div class="form-group">
                                    <input type="number" id="rate" name="rate" step="0.001" min="0.001" class="form-control next" data-next="amt" placeholder="Enter rate" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="amt">Amount(Qty)</label>
                                <div class="form-group">
                                    <input type="number" id="amt" name="amount" step="0.001" min="0.001" class="form-control" placeholder="Enter amount" required>
                                </div>
                            </div> --}}
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
                <h4 class="title" id="largeModalLabel">Edit Distributer</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="editform" onsubmit="return editData(event);">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Distributer Name</label>
                                <div class="form-group">
                                    <input type="text" id="ename" name="name" class="form-control next" data-next="ephone" placeholder="Enter distributer name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Distributer Phone</label>
                                <div class="form-group">
                                    <input type="number" id="ephone" name="phone" class="form-control next" data-next="eaddress" placeholder="Enter distributer phone" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Distributer Address</label>
                                <div class="form-group">
                                    <input type="text" id="eaddress" name="address" value="" class="form-control next" data-next="erate" placeholder="Enter distributer address" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="ecredit_days">Credit Days</label>
                                <div class="form-group">
                                    <input type="number" id="ecredit_days" name="credit_days" min="0" step="0.01" class="form-control next" data-next="address" placeholder="Enter Credit Days" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="ecredit_limit">Credit Limit</label>
                                <div class="form-group">
                                    <input type="number" id="ecredit_limit" name="credit_limit" min="0" step="0.01" class="form-control next" data-next="address" placeholder="Enter Credit Days" required>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <label for="rate">Rate</label>
                                <div class="form-group">
                                    <input type="number" id="erate" name="rate" step="0.001" min="0.001" class="form-control next" data-next="eamt" placeholder="Enter rate" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="amt">Amount(Qty)</label>
                                <div class="form-group">
                                    <input type="number" id="eamt" name="amount" step="0.001" min="0.001" class="form-control" placeholder="Enter amount" required>
                                </div>
                            </div> --}}
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
<script>
    function initEdit(ele) {
        var distributer = JSON.parse(ele.dataset.distributer);
        console.log(distributer);
        $('#ename').val(distributer.name);
        $('#ephone').val(distributer.phone);
        $('#eaddress').val(distributer.address);
        // $('#erate').val(ele.dataset.rate);
        // $('#eamt').val(ele.dataset.amount);
        $('#eid').val(distributer.id);
        $('#editModal').modal('show');
    }

    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("admin.dis.add")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Distributer added successfully!');
                $('#largeModal').modal('toggle');
                $('#form_validation').trigger("reset")
                $('#distributerData').prepend(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    // edit data
    function editData(e) {
        e.preventDefault();
        var rowid = $('#eid').val();
        var bodyFormData = new FormData(document.getElementById('editform'));
        axios({
                method: 'post',
                url: '{{ route("admin.dis.update")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Updated successfully!');
                $('#editModal').modal('toggle');
                $('#distributer-' + rowid).replaceWith(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    axios({
            method: 'get',
            url: '{{ route("admin.dis.list")}}',
        })
        .then(function(response) {
            // console.log(response.data);
            $('#distributerData').html(response.data);
            initTableSearch('sid', 'distributerData', ['name']);
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
                    url: '/admin/distributer/delete/' + dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#distributer-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    //handle error
                    showNotification('bg-danger','You do not have authority to delete!');

                    console.log(response);
                });
        }
    }


</script>
@endsection
