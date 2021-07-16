@extends('admin.layouts.app')
@section('title','Supplier Details')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title')
<a href="{{route('admin.supplier.index')}}">Suppliers</a> / Details / {{$user->name}}
@endsection
@section('toobar')
@endsection
@section('content')
<div >
   @include('admin.layouts.daterange')
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
@include('admin.js')
<script>




    function loadData(){
        var user = {{ $user->id }};
        console.log(user,'loading data');
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
                url: '{{ route("admin.supplier.load-detail") }}',
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

        $('#type').val(0).change();
        loadData();
    };



</script>
@endsection
