@extends('admin.layouts.app')
@section('title','Customer Details')
@section('css')
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title')
<a href="{{route('admin.customer.home')}}">Customers</a> / Details / {{$user->name}}
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

</div>
<div id="allData">

</div>
{{-- @include('admin.distributer.balance.change') --}}

{{-- @include('admin.farmer.snippet.updateledger') --}}

@endsection
@section('js')
@include('admin.js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>


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
                url: '{{ route("admin.customer.detail",['id'=>$user->id]) }}',
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
