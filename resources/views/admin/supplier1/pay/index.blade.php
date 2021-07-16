@extends('admin.layouts.app')
@section('title','Supplier Payment')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Supplier Payment')
@section('toobar')

@endsection
@section('content')
<div class="row">
    <div class="col-md-12 bg-light pt-2">
        <form action="" id="sellitemData">
            @csrf
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="unumber">Suppliers</label>
                        <select name="user_id" id="u_id" class="form-control show-tick ms " data-placeholder="Select" required>
                            <option value="-1"></option>
                            @foreach(\App\Models\User::where('role',3)->get() as $d)
                                <option value="{{ $d->id }}" id="opt-{{ $d->id }}" >{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mt-4">
                    <input type="button" value="Load" class="btn btn-primary btn-block" onclick="loaddata();" id="save">
                    {{-- <span class="btn btn-primary btn-block" >Save</span> --}}
                </div>

            </div>
        </form>


        <div class="row">
            <div class="col-md-12">
                <div class="mt-5">
                    <div id="data">

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->

@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    // $( "#x" ).prop( "disabled", true );
    initTableSearch('sId', 'sellDisDataBody', ['name']);







    function calTotal() {
        $('#total').val($('#rate').val() * $('#qty').val());
        $('#due').val($('#rate').val() * $('#qty').val());
        $('#etotal').val($('#erate').val() * $('#eqty').val());
        $('#edue').val($('#erate').val() * $('#eqty').val());
    }

    function paidTotal() {
        var total = parseFloat($('#total').val());
        var paid = parseFloat($('#paid').val());
        $('#due').val(total - paid);
        var etotal = parseFloat($('#etotal').val());
        var epaid = parseFloat($('#epaid').val());
        $('#edue').val(etotal - epaid);
    }


    $('#u_id').change(function() {
        if($(this).val()!=-1){
            loaddata();
        }
   });

   function pay(){
       if($('#amount').val() == ""){
        alert('Please enter paid amount');
        return false;
       }else{
        axios.post('{{ route("supplier.due.pay")}}',{
            'id': $('#u_id').val(),
            'amount':$('#amount').val(),
            'method':$('#method').val(),
            'date': $('#nepali-datepicker').val()
        })
        .then(function(response) {
            // console.log(response.data);
            $('#data').html(response.data);
            showNotification('bg-success', 'Payment successfully!');
            setDate();
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });
       }
   }

    function loaddata(){
        // $('#data').html();
        // list
        axios.post('{{ route("supplier.due")}}',{
            'id': $('#u_id').val()

            })
        .then(function(response) {
            // console.log(response.data);
            $('#data').html(response.data);
            setDate();
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });
    }

    function checkAmount(ele){
        if(ele.max<$(ele).val()){
            alert('The Due Is Only '+ele.max);
            $(ele).val(ele.max);
        }
    }

    function setDate(){

        var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
        var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
        $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);
        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();
    }

    window.onload = function() {
        // var mainInput = document.getElementById("nepali-datepicker");
        // mainInput.nepaliDatePicker();
        // var edit = document.getElementById("enepali-datepicker");
        // edit.nepaliDatePicker();
        // $('#u_id').focus();
        // loaddata();
    };


    $('#paid').bind('keydown', 'return', function(e){
        saveData();
    });

</script>
@endsection
