@extends('admin.layouts.app')
@section('title', 'Customer Payment')
@section('head-title', 'Customer Payment')

@section('content')
    <div class="row">
        <div class="col-md-3">

            <input type="text" id="sid" placeholder="Search Customer" class="form-control mb-2">
            <table class="table table-bordered  dataTable" style="cursor: pointer">
                @foreach ($customers as $customer)
                    <tbody id="data">
                        <tr data-name="{{ $customer->user->name }}" id="customer_{{ $customer->user_id }}" onclick="selectCustomer({{ $customer->user_id }},'{{ $customer->user->name }}')">
                            <td>
                                {{ $customer->user->name }}
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
        <div class="col-md-9" id="allData">

        </div>
    </div>




@endsection
@section('js')
@include('admin.js')

    <script>
        initTableSearch('sid', 'data', ['name']);
        lock = false;
        var _id=-1;
        var _name="";
        function selectCustomer(id,name){
            _id=id;
            _name=name;
            showProgress("Loading "+name+"'s Data")
            axios.post('{{route('admin.customer.payment.index')}}',{"id":id})
            .then((res)=>{
                $('#allData').html(res.data);
                hideProgress();
                setDate('date',true);
            })
            .catch((err)=>{
                hideProgress();

            });
        }

        function addPayment(e){
            e.preventDefault();
            if(!lock){
                lock=true;
                showProgress("Adding Payment for "+_name);
                data=new FormData(document.getElementById('addPayment'));
                axios.post("{{route('admin.customer.payment.add')}}",data)
                .then((res)=>{
                    $('#allData').html(res.data);
                    hideProgress();
                    setDate('date',true);
                })
                .catch((err)=>{
                    hideProgress();

                });
            }
        }
    </script>
@endsection
