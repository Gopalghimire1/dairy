@extends('admin.layouts.app')
@section('title','Supplier Details')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title')
<a href="{{route('admin.sup')}}">Suppliers</a> / Details / {{$user->name}}
@endsection
@section('toobar')
@endsection
@section('content')
<div >
    <div class="row">
        <div class="col-md-3 ">
            <label for="type">
                Report Duration
            </label>
            <select name="type" id="type" onchange="manageDisplay(this)" class="form-control show-tick ms select2">
                <option value="-1"></option>
                <option value="0">Session</option>
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
    </div>
    <div class="row">
        <div class="col-md-3">
            <span class="btn btn-primary" onclick="loadData()"> Load </span>
        </div>

    </div>
    {{-- <div class="col-md-3">
        <select name="year" id="year" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-3">
        <select name="month" id="month" class="form-control show-tick ms select2">
        </select>
    </div>
    <div class="col-md-3">
        <select name="session" id="session" class="form-control show-tick ms select2">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
    </div>
     --}}
</div>
<div id="allData">

</div>
@include('admin.distributer.balance.change')
@include('admin.distributer.balance.sellitem_change')
@include('admin.distributer.balance.payment_change')
@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    function manageDisplay(element){
        type=$(element).val();
        $('.ct').addClass('d-none');
        $('.ct-'+type).removeClass('d-none');
    }
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
        var user = {{ $user->id }};
        console.log(user);
        var data={
            'year':$('#year').val(),
            'month':$('#month').val(),
            'session':$('#session').val(),
            'week':$('#week').val(),
            'center_id':$('#center_id').val(),
            'date1':$('#date1').val(),
            'date2': $('#date2').val(),
            'type':$('#type').val(),
            'user_id':{{$user->id}}
        };
        axios({
                method: 'post',
                url: '{{ route("distributer.detail.load") }}',
                data:data ,
        })
        .then(function(response) {
            $('#allData').html(response.data);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
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
        $('#type').val(0).change();
        $('.calender').each(function(){
            this.nepaliDatePicker();
            var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
            var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
            $(this).val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);
        });
        loadData();
    };


    // XXX simple ledger change
    initlock=false;
    function initLedgerChange(ele){
        data=$(ele).data('ledger');
        console.log(data);
        $('#title').html(data.title);
        // debugger;
        $('#amount').val(data.amount);
        // debugger;

        $('#id').val(data.id);
        // debugger;

        $('#l_type').val(data.type).change();
        // debugger;

        $('#change').modal('show');
    }

    function saveLedgerChange(){
        if(!initlock){
            if(confirm('Do You Want TO Update Ledger ')){

                data={
                    id:$('#id').val(),
                    amount:$('#amount').val(),
                    type:$('#l_type').val(),
                };

                initlock=true;
                axios.post("{{route('ledger.update')}}",data)
                .then(function(response){
                    console.log(response);
                    initlock=false;
                    $('#change').modal('hide');
                    loadData();
                })
                .catch(function(err){
                    initlock=false;
                    alert('Ledger Cannot be Updated');
                })
            }
        }
    }

    // XXX sell item change
    selllock=false;
    function sellLedgerChange(ele){
        data=$(ele).data('ledger');
        selldata=$(ele).data('foreign');
        console.log(data);
        $('#s_title').html(data.title);
        // debugger;
        $('#s_amount').val(selldata.total);
        // debugger;

        $('#id').val(data.id);
        // debugger;

        $('#s_rate').val(selldata.rate).change();
        $('#s_qty').val(selldata.qty).change();
        // debugger;

        $('#sellitem_change').modal('show');
    }

    function s_calculate(){
        $('#s_amount').val($('#s_rate').val()*$('#s_qty').val());
    }

    function saveSellLedgerChange(){
        if(!selllock){
            if(confirm('Do You Want TO Update Ledger ')){

                data={
                    id:$('#id').val(),
                    amount:$('#s_amount').val(),
                    rate:$('#s_rate').val(),
                    qty:$('#s_qty').val(),
                };

                selllock=true;
                axios.post("{{route('ledger.sellupdate')}}",data)
                .then(function(response){
                    console.log(response);
                    selllock=false;
                    $('#sellitem_change').modal('hide');
                    loadData();
                })
                .catch(function(err){
                    selllock=false;
                    alert('Ledger Cannot be Updated');
                })
            }
        }
    }

      // XXX payment change
      paylock=false;
    function payLedgerChange(ele){
        data=$(ele).data('ledger');
        selldata=$(ele).data('foreign');
        console.log(data);
        $('#p_title').html(data.title);
        // debugger;
        $('#p_amount').val(selldata.paid);
        // debugger;

        $('#id').val(data.id);
        // debugger;

        $('#pay_change').modal('show');
    }



    function savePayLedgerChange(){
        if(!paylock){
            if(confirm('Do You Want TO Update Ledger ')){

                data={
                    id:$('#id').val(),
                    amount:$('#p_amount').val(),

                };

                paylock=true;
                axios.post("{{route('ledger.payupdate')}}",data)
                .then(function(response){
                    console.log(response);
                    paylock=false;
                    $('#payment_change').modal('hide');
                    loadData();
                })
                .catch(function(err){
                    paylock=false;
                    alert('Ledger Cannot be Updated');
                })
            }
        }
    }
</script>
@endsection
