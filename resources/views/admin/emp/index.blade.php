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

<!-- add modal -->
@include('admin.emp.add')



<!-- edit modal -->
@include('admin.emp.edit')


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
                url: '{{ route("admin.employee.add")}}',
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
                url: '{{route('admin.employee.update')}}',
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
            url: '{{ route("admin.employee.list")}}',
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
                    method: 'post',
                    url: '{{route('admin.employee.delete')}}',
                    data:{"id":dataid}
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
