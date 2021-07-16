@extends('admin.layouts.app')
@section('title','Employess')
@section('head-title','Employees')
@section('toobar')
<button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">Create Employee</button>
@endsection
@section('content')
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>S.n</th>
                <th>Employee Name</th>
                <th>Employee phone</th>
                <th>Employee Address</th>
                <th>Salary (Rs.)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="employeeData">

        </tbody>
    </table>
</div>

<!-- modal -->

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" data-ff="name">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create Employee</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Employee Name</label>
                                <div class="form-group">
                                    <input type="text" id="name" name="name" class="form-control next" data-next="phone" placeholder="Enter employee name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Employee Phone</label>
                                <div class="form-group">
                                    <input type="number" id="phone" name="phone" class="form-control next" data-next="address" placeholder="Enter employee phone" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Employee Address</label>
                                <div class="form-group">
                                    <input type="text" id="address" name="address" class="form-control next" data-next="salary" placeholder="Enter employee address" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Employee Salary</label>
                                <div class="form-group">
                                    <input type="number" id="salary" name="salary" class="form-control next" data-next="acc" placeholder="Enter employee salary" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Bank/Account Number</label>
                                <div class="form-group">
                                    <input type="text" id="acc" name="acc" class="form-control" placeholder="Enter Bank Detail" required>
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
                <h4 class="title" id="largeModalLabel">Edit Employee</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="editform" onsubmit="return editData(event);">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Employee Name</label>
                                <div class="form-group">
                                    <input type="text" id="ename" name="name" class="form-control next" data-next="ephone" placeholder="Enter Employee name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Employee Phone</label>
                                <div class="form-group">
                                    <input type="number" id="ephone" name="phone" class="form-control next" data-next="eaddress" placeholder="Enter Employee phone" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Employee Address</label>
                                <div class="form-group">
                                    <input type="text" id="eaddress" name="address" value="" class="form-control next" data-next="esalary" placeholder="Enter Employee address" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Employee Salary</label>
                                <div class="form-group">
                                    <input type="number" id="esalary" name="salary" class="form-control next" data-next="eacc" placeholder="Enter employee salary" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Bank/Account Number</label>
                                <div class="form-group">
                                    <input type="text" id="eacc" name="acc" class="form-control" placeholder="Enter Bank Detail" required>
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
        var employee = JSON.parse(ele.dataset.employee);
        console.log(employee);
        $('#ename').val(employee.name);
        $('#ephone').val(employee.phone);
        $('#eaddress').val(employee.address);
        $('#esalary').val(ele.dataset.salary);
        $('#eid').val(employee.id);
        $('#eacc').val(ele.dataset.acc);
        $('#editModal').modal('show');
    }

    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("admin.emp.add")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Employee added successfully!');
                $('#largeModal').modal('toggle');
                $('#form_validation').trigger("reset")
                $('#employeeData').prepend(response.data);
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
                url: '/admin/employee/update',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Updated successfully!');
                $('#editModal').modal('toggle');
                $('#employee-' + rowid).replaceWith(response.data);
            })
            .catch(function(response) {
                //handle error
                showNotification('bg-danger', 'You have no authority!');
                console.log(response);
            });
    }

    axios({
            method: 'get',
            url: '{{ route("admin.emp.list")}}',
        })
        .then(function(response) {
            // console.log(response.data);
            $('#employeeData').html(response.data);
            initTableSearch('sid', 'employeeData', ['name']);
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
                    url: '/admin/employee/delete/' + dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#employee-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    showNotification('bg-danger','You do not have authority to delete!');
                    //handle error
                    console.log(response);
                });
        }
    }
</script>
@endsection
