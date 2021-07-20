@extends('admin.layouts.app')
@section('title','Customers')
@section('head-title','Customers')
@section('toobar')
<button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#addModal">New Customer</button>
@endsection
@section('content')
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
@include('admin.customer.add')
@include('admin.customer.edit')
<div class="table-responsive">
    <table  class="table table-bordered  dataTable">
        <thead>
            <tr>
                <th>#CUS Id</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Balance</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="data">
            @foreach($customers as $customer)
                @include('admin.customer.single',['customer'=>$customer])
            @endforeach

        </tbody>
    </table>
</div>





@endsection
@section('js')
<script>
    initTableSearch('sid', 'data', ['name']);
    lock=false;

    function del(id){
        if(!lock){
            if(prompt('Please Type Yes To Delete').toLowerCase()=="yes"){

                lock=true;
                showProgress('Updating Customer');
                var data={'id':id};
                axios.post('{{route('admin.customer.del')}}',data)
                .then((res)=>{

                    $('#customer_'+id).replaceWith(res.data);
                    hideProgress();
                    lock=false;
                    $('#editModal').modal('hide');
                    document.getElementById('editCustomer').reset();
                })
                .catch((err)=>{
                    hideProgress();
                    lock=false;
                })
            }
            }
    }
</script>
@endsection
@section('js')

@endsection
