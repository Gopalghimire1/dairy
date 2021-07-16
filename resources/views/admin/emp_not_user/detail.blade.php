@extends('admin.layouts.app')
@section('title','Employee Details')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title')
<a href="{{route('admin.emp')}}">Employee</a> / Details / {{$user->name}}
@endsection
@section('toobar')
@endsection
@section('content')
<div class="row">
<div class="col-lg-12">

    <form id="form_validation" method="POST" >
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <label for="type">Search Type</label>
                <select name="type" id="type" class="form-control show-tick ms select2">
                    <option value="1">Yearly</option>
                    <option value="2">Monthly</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label for="date">For Year</label>
                <select name="year" id="year" class="form-control show-tick ms select2">

               </select>
            </div>

            <div class="col-lg-2" id="formonth">
                <label for="date">For Month</label>
                <select name="month" id="month" class="form-control show-tick ms select2">
               </select>
            </div>

            <div class="col-lg-2">
                <span class="btn btn-primary" onclick="loadEmployeeData();" style="margin-top:30px;">Load Data</span>
            </div>

        </div>
    </form>
</div>
</div>

<div class="table-responsive">
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
        var user_id = {{ $user->id }}
        var year = $('#year').val();
        var month = $('#month').val();
        var type = $('#type').val();
            axios({
                    method: 'post',
                    url: '{{ route("admin.emp.load.data")}}',
                    data : {'user_id':user_id,'year':year,'month':month,'type':type}
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#employeeData').empty();
                    $('#employeeData').html(response.data);

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
        loadEmployeeData();
        $('#type').val(1).change();

    };

    $('#type').change(function(){
        var type = $('#type').val();
        if(type ==1){
            $('#formonth').addClass('d-none');
        }else{
            $('#formonth').removeClass('d-none');
        }
    });







</script>
@endsection
