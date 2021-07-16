@extends('admin.layouts.app')
@section('head-title')
<a href="{{route('admin.employee.index')}}">Employees</a> / Account Opening
@endsection
@section('content')
<form id="addBalance" action="" onsubmit="return saveData(event);">
    <div class="row">
        <div class="col-md-3">
            <label for="date">Date</label>
            <input type="text" name="date" id="date" class="calender form-control" readonly required>
        </div>
        <div class="col-md-3">
            <label for="employee">Employee</label>
            <select type="text" name="employee" id="employee" class="form-control ms" required>
                @foreach ($emps as $emp)
                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="">Balance</label>
            <input type="text" id="amount" name="amount" class="form-control next" data-target="type" required step="0.01" min="1">
        </div>
        <div class="col-md-3">
            <label for="">Balance Type</label>
                <select name="type" id="type" class="form-control  ms" required>
                    <option value="1">CR</option>
                    <option value="2">DR</option>
                </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100" >Add Balance</button>
        </div>
    </div>
</form>
<hr>
<table class="table">
    <tr>
        <th>
            Name
        </th>
        <th>
            Amount
        </th>
        <th>

        </th>
    </tr>
    <tbody id="data">

    </tbody>
</table>

@endsection
@section('js')
@include('admin.js')
    <script>
        var lock=false;
        function saveData(e){
            e.preventDefault();
            if(!lock){
                data=new FormData(document.getElementById('addBalance'));
                axios.post('{{route('admin.employee.account.add')}}',data)
                .then((res)=>{
                    $('#data').prepend(res.data);
                    $('#amount').val("");
                })
                .catch((err)=>{
                    alert("Opening Balance Cannot Be added");
                })
            }
        }

        function loadData(){
            $('#data').html("");
            axios.post('{{route('admin.employee.account.index')}}',{"date":$('#date').val()})
            .then((res)=>{
                $('#data').html(res.data);
            });
        }

        window.onload=()=>{
            loadData();
        };

        function removeData(id){
            $('#ledger-'+id).remove();
        }

        // $('$date')
        // $(selector).on('change', function () {

        // });


    </script>
@endsection
