@extends('admin.layouts.app')
@section('title','Salary Pay')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Employee Salary Payment')
@section('toobar')
@endsection
@section('content')
<div class="row">
<div class="col-lg-12">

    <form id="form_validation" method="POST" >
        @csrf
        <div class="row">
            <div class="col-lg-2">
                <label for="date">For Year</label>
                <select name="year" id="year" class="form-control show-tick ms select2">

               </select>
            </div>

            <div class="col-lg-2">
                <label for="date">For Month</label>
                <select name="month" id="month" class="form-control show-tick ms select2">

               </select>
            </div>

            <div class="col-lg-6">
                <label for="u_number">For Employee</label>

                <div class="form-group">
                   <select name="employee_id" id="employee_id" class="form-control show-tick ms select2">
                        <option value="-1"></option>
                        @foreach (\App\Models\Employee::all() as $employee)
                            @if (isset($employee->user))
                                <option value="{{$employee->id}}">
                                    {{ $employee->user->name }}
                                </option>
                            @endif
                        @endforeach
                   </select>
                </div>
            </div>

            <div class="col-lg-2">
                <span class="btn btn-primary" onclick="loadEmployeeData();" style="margin-top:30px;">Load Data</span>
            </div>

        </div>
    </form>
</div>
</div>

<div class="table-responsive">
    <div id="paid">

    </div>
    <div id="employeeData">

    </div>
</div>




@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    // initTableSearch('searchid', 'farmerforData', ['name']);
    // load by date

    var month = Array.from(NepaliFunctions.GetBsMonths());
    var i =1;
    month.forEach(element => {
        $('#month').append('<option value="'+i+'">'+element+'</option>');
        i++;
    });

    var start_y = 2070;
    var now_yr = NepaliFunctions.GetCurrentBsYear();
    var now_yr1 = now_yr;
    for (let index = start_y; index < now_yr; index++) {
        $('#year').append('<option value="'+now_yr1+'">'+now_yr1+'</option>');
        now_yr1--;
    }


    function loadEmployeeData(){
        var emp_id = $('#employee_id').val();
        var year = $('#year').val();
        var month = $('#month').val();
        if(emp_id == -1){
            alert('Please select employee first');
            $('#employee_id').focus();
        }else{
            axios({
                    method: 'post',
                    url: '{{ route("salary.load.emp.data")}}',
                    data : {'emp_id':emp_id,'year':year,'month':month}
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#employeeData').empty();
                    $('#employeeData').html(response.data);
                    var mainInput = document.getElementById("nepali-datepicker");
                    mainInput.nepaliDatePicker();
                    var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
                    var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
                    $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);
                    $('#p_amt').val($('#salary').val() - $('#tot-adv').val());
                    paidList();
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                });
        }
    }


    function salaryPayment(){
            var date = $('#nepali-datepicker').val();
            var emp_id = $('#employee_id').val();
            var year = $('#year').val();
            var month = $('#month').val();
            var pay = $('#p_amt').val();
            var desc = $('#p_detail').val();
            if(pay<=0){
                alert('You can not perform further action');
                return false;
            }else{
                if(confirm('Are you sure ?')){
                  axios({
                    method: 'post',
                    url: '{{ route("salary.save")}}',
                    data : {'date' : date,'emp_id':emp_id,'year':year,'month':month,'pay':pay,'desc':desc}
                    })
                    .then(function(response) {
                        // console.log(response.data);
                        if(response.data == 'ok'){
                            showNotification('bg-success', 'Salary paid successfully!');
                        }else{
                            showNotification('bg-danger', 'Already paid !');
                        }
                        $('#p_amt').val(0);
                        paidList();
                    })
                    .catch(function(response) {
                        //handle error
                        console.log(response);
                    });
                }
            }
    }

// amount transfer
function transferAmt(){
            var date = $('#nepali-datepicker').val();
            var emp_id = $('#employee_id').val();
            var year = $('#year').val();
            var month = $('#month').val();
            var transfer_amount = $('#transfer_amount').val();
            var desc = $('#p_detail').val();
            if(transfer_amount<=0){
                alert('please enter transfer amount');
                return false;
            }else{
            if(confirm('Are you sure ?')){
                  axios({
                    method: 'post',
                    url: '{{ route("amount.transfer")}}',
                    data : {'date' : date,'emp_id':emp_id,'year':year,'month':month,'transfer_amount':transfer_amount,'desc':desc}
                    })
                    .then(function(response) {
                        // console.log(response.data);
                        if(response.data == 'ok'){
                            showNotification('bg-success', 'Salary paid successfully!');
                        }else{
                            showNotification('bg-danger', 'Already paid !');
                        }
                        $('#p_amt').val(0);
                        $('#transfer_amount').val(0);
                        paidList();
                    })
                    .catch(function(response) {
                        //handle error
                        console.log(response);
                    });
                }
            }
}

    function paidList(){
            var year = $('#year').val();
            var month = $('#month').val();
            var emp_id = $('#employee_id').val();
                axios({
                    method: 'post',
                    url: '{{ route("salary.list")}}',
                    data : {'year':year,'month':month,'emp_id':emp_id}
                    })
                    .then(function(response) {
                        // console.log(response.data);
                        $('#paid').empty();
                        $('#paid').html(response.data);
                    })
                    .catch(function(response) {
                        //handle error
                        console.log(response);
                    });
    }

    window.onload = function() {
        var month = NepaliFunctions.GetCurrentBsDate().month;
        var year = NepaliFunctions.GetCurrentBsDate().year;
        $('#year').val(year).change();
        $('#month').val(month).change();
        paidList();
    };


    $('#month').change(function() {
        paidList();
        if($('#employee_id').val() != -1){
            loadEmployeeData();
        }
    });

    $('#employee_id').change(function(){
        loadEmployeeData();
    })





</script>
@endsection
