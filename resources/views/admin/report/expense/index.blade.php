@extends('admin.layouts.app')
@section('title','Report - Expense')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title')
    <a href="{{route('report.home')}}">Report</a> / Expenses

@endsection
@section('toobar')

@endsection
@section('content')
{{-- <div class="row">
    <div class="col-md-4">
        <label for="date">Year</label>
        <select name="year" id="year" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-4">
        <label for="date">Month</label>
        <select name="month" id="month" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-4">
        <label for="date">Session</label>
        <select name="session" id="session" class="form-control show-tick ms select2">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
    </div>

</div> --}}
<div class="row">
    <div class="col-md-3 ">
        <label for="type">
            Report Duration
        </label>
        <select name="type" id="type" onchange="manageDisplay(this)" class="form-control show-tick ms select2">
            <option value="-1"></option>
            <option value="1">Daily</option>
            <option value="2">Weekly</option>
            <option value="3">Monthly</option>
            <option value="4">Yearly</option>
            <option value="5">Custom</option>
        </select>

    </div>
    <div class="col-md-3 ct ct-0 ct-2 ct-3 ct-4 d-none">
        <label for="date">Year</label>
        <select name="year" id="year" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-3 ct ct-0  ct-2 ct-3 d-none">
        <label for="date">Month</label>
        <select name="month" id="month" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-3 ct ct-2 d-none">
        <label for="week">Week</label>
        <select name="week" id="week" class="form-control show-tick ms select2">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="col-md-3 ct ct-0 d-none">
        <label for="date">Session</label>
        <select name="session" id="session" class="form-control show-tick ms select2">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
    </div>
    <div class="col-md-3 ct ct-1 ct-5 d-none">
        <label for="Date1">Date1</label>
        <input type="text" id="date1" class="form-control calender">
    </div>
    <div class="col-md-3 ct ct-5 d-none">
        <label for="Date1">Date2</label>
        <input type="text" id="date2" class="form-control calender">
    </div>

    <div class="col-md-3">
        <label for="week">Expense Category</label>
        <select name="category_id" id="category_id" class="form-control show-tick ms select2">
            <option value="-1"></option>
           @foreach (\App\Models\Expcategory::all() as $item)
               <option value="{{ $item->id }}">{{$item->name}}</option>
           @endforeach
        </select>
    </div>


</div>
<div class="row">
    <div class="col-md-6">
        <span class="btn btn-primary" onclick="loadData()"> Load Report</span>

        <span class="btn btn-success" onclick="printDiv('allData');"> Print</span>
    </div>
</div>
<div id="allData">

</div>
@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>

<script>
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

    function loadData(){

        if($('#center_id').val()==""){
            alert('Please Select Collection ceter');
            return;
        }

        var d={
            'year':$('#year').val(),
            'month':$('#month').val(),
            'session':$('#session').val(),
            'week':$('#week').val(),
            'center_id':$('#center_id').val(),
            'date1':$('#date1').val(),
            'date2': $('#date2').val(),
            'type':$('#type').val(),
            'category_id':$('#category_id').val(),
        };
        axios.post("{{route('report.expense')}}",d)
        .then(function(response){
            $('#allData').html(response.data);

        })
        .catch(function(error){
            alert('some error occured');
        });
    }

    window.onload = function() {

        var month = NepaliFunctions.GetCurrentBsDate().month;
        var year = NepaliFunctions.GetCurrentBsDate().year;
        var day =  NepaliFunctions.GetCurrentBsDate().day;

        $('#year').val(year).change();
        $('#month').val(month).change();
        if(day>15){
            $('#session').val(2).change();
        }else{
            $('#session').val(1).change();
        }
        $('.calender').each(function(){
            this.nepaliDatePicker();
            var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
            var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
            $(this).val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);
        });
        $('#type').val(0).change();

    };

    function printDiv(id)
    {
        var divToPrint=document.getElementById(id);
        var newWin=window.open('','Report');
        newWin.document.open();
        newWin.document.write('<html><head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset("backend/css/print.css") }}"></head><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();

    }

    function manageDisplay(element){
        type=$(element).val();
        $('.ct').addClass('d-none');
        $('.ct-'+type).removeClass('d-none');
    }
</script>
@endsection
