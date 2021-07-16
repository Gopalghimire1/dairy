@extends('admin.layouts.app')
@section('title','Supplier Balance')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
<style>
    td,th{
            border:1px solid black !important;
        }
        table{
            width:100%;
            border-collapse: collapse;
        }
        thead {display: table-header-group;}
        tfoot {display: table-header-group;}
</style>
@endsection
@section('head-title','Supplier Balance')
@section('toobar')

@endsection
@section('content')
<div class="row">
    {{-- @include('admin.distributer.sell.productmodal') --}}
    <div class="col-md-12 bg-light pt-2">
        <form action="" id="sellitemData">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input readonly type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="supplier_id" placeholder="Date" onchange="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Suppliers</label>
                        <select name="supplier_id" id="supplier_id" class="form-control show-tick ms next">
                            <option></option>
                            @foreach(\App\Models\User::where('role',3)->get() as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div id="alldata" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control next" data-next="product_id">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type"  class="form-control show-tick ms ">
                                <option value="1">CR</option>
                                <option value="2">DR</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-md-3 mt-4">
                        <input type="button" value="Save" class="btn btn-primary btn-block" onclick="saveData();" id="save">
                        {{-- <span class="btn btn-primary btn-block" >Save</span> --}}
                    </div>

                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5">
                    <div class="pt-2 pb-2">
                        <input type="text" id="sId" placeholder="Search" style="width: 200px;">
                    </div>
                    <table id="newstable1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="datas">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->

{{-- @include('admin.distributer.sell.editmodal') --}}
@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    // $( "#x" ).prop( "disabled", true );
    initTableSearch('sId', 'datas', ['name']);
    initTableSearch('s_dis', 'distributors', ['name']);
    initTableSearch('productsearch', 'products', ['name']);


    function saveData() {
        if ($('#nepali-datepicker').val() == '' || $('#supplier_id').val() == ""  || $('#amount').val()=="" || $('#amount').val()=="0") {
            alert('Please enter data in empty field !');
            $('#supplier_id').focus();
            return false;
        } else {
            var bodyFormData = new FormData(document.getElementById('sellitemData'));
            axios({
                    method: 'post',
                    url: '{{ route("supplier.previous.balance.add")}}',
                    data: bodyFormData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    console.log(response.data);
                    showNotification('bg-success', 'Balance added successfully !');
                    $('#datas').prepend(response.data);
                    $('#supplier_id').val('');
                    $('#amount').val('0');

                })
                .catch(function(response) {
                    showNotification('bg-danger', 'You have entered invalid data !');
                    //handle error
                    console.log(response);
                });
        }
    }

    // delete

    // function removeData(id) {
    //     if (confirm('Are you sure?')) {
    //         axios({
    //                 method: 'post',
    //                 url: '{{route("distributer.detail.ledger.update")}}',
    //                 data:{
    //                     'id':id
    //                 }
    //             })
    //             .then(function(response) {
    //                 showNotification('bg-danger', 'Sellitem deleted successfully!');
    //                 $('#ledger-' + id).remove();
    //             })
    //             .catch(function(err) {
    //                 showNotification('bg-danger', err.response.data);
    //             })
    //     }
    // }



    var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
    var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
    $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);
    $('#currentdate').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);

    window.onload = function() {
        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();
        // var edit = document.getElementById("enepali-datepicker");
        // edit.nepaliDatePicker();
        $('#id').focus();
        loadData();
    };

    function loadData(){
        $('#datas').html("");
        // list
        axios.post('{{ route("supplier.previous.balance.load")}}',{
            'date': $('#nepali-datepicker').val()
            })
        .then(function(response) {
            // console.log(response.data);
            $('#datas').html(response.data);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });
    }




    $('#nepali-datepicker').bind('changed', function() {
        loadData();
    });



    function delData(id){
        if(confirm('Do you Want To delete Ledger Data')){

            axios({
                method: 'post',
                url: '{{ route("ledger.del")}}',
                data:{'id':id}
            })
            .then(function(response) {
                $('#ledger-'+id).remove();

            })
            .catch(function(response) {
                //handle error
                console.log(response);
                showNotification('bg-danger', 'You hove no authority!');

            });
        }
    }
</script>
@endsection
