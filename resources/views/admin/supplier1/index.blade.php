@extends('admin.layouts.app')
@section('title','Suppliers')
@section('head-title','Suppliers')
@section('toobar')
<button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">Create Supplier</button>
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
                <th>Supplier Name</th>
                <th>Supplier phone</th>
                <th>Supplier Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="supplierData">

        </tbody>
    </table>
</div>

<!-- modal -->

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" data-ff="name">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create Supplier</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Supplier Name</label>
                                <div class="form-group">
                                    <input type="text" id="name" name="name" class="form-control next" data-next="phone" placeholder="Enter supplier name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Supplier Phone</label>
                                <div class="form-group">
                                    <input type="number" id="phone" name="phone" class="form-control next" data-next="address" placeholder="Enter supplier phone" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Supplier Address</label>
                                <div class="form-group">
                                    <input type="text" id="address" name="address" class="form-control" placeholder="Enter supplier address" required>
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
                <h4 class="title" id="largeModalLabel">Edit Supplier</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="editform" onsubmit="return editData(event);">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Supplier Name</label>
                                <div class="form-group">
                                    <input type="text" id="ename" name="name" class="form-control next" data-next="ephone" placeholder="Enter supplier name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Supplier Phone</label>
                                <div class="form-group">
                                    <input type="number" id="ephone" name="phone" class="form-control next" data-next="eaddress" placeholder="Enter supplier phone" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Supplier Address</label>
                                <div class="form-group">
                                    <input type="text" id="eaddress" name="address" value="" class="form-control" placeholder="Enter supplier address" required>
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
<script>
    function initEdit(ele) {
        var supplier = JSON.parse(ele.dataset.supplier);
        $('#ename').val(supplier.name);
        $('#ephone').val(supplier.phone);
        $('#eaddress').val(supplier.address);
        $('#eid').val(supplier.id);
        $('#editModal').modal('show');
    }

    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("admin.sup.add")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Supplier added successfully!');
                $('#largeModal').modal('toggle');
                $('#form_validation').trigger("reset")
                $('#supplierData').prepend(response.data);
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
                url: '/admin/supplier/update',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Updated successfully!');
                $('#editModal').modal('toggle');
                $('#supplier-' + rowid).replaceWith(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }

    axios({
            method: 'get',
            url: '{{ route("admin.sup.list")}}',
        })
        .then(function(response) {
            // console.log(response.data);
            $('#supplierData').html(response.data);
            initTableSearch('sid', 'supplierData', ['name']);
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
                    url: '/admin/supplier-delete/'+ dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#supplier-' + dataid).remove();
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
