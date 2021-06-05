@extends('admin.layouts.app')
@section('title','Farmer Advance')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection
@section('head-title','Farmer Advance')
@section('toobar')
@endsection
@section('content')
<div class="row">
<div class="col-lg-12">
    @include('admin.farmer.farmermodal')
    <form id="form_validation" method="POST" onsubmit="return saveData(event);">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="date">Collection Center</label>
                    <select name="center_id" id="center_id" class="form-control show-tick ms next">
                        <option></option>
                        @foreach(\App\Models\Center::all() as $c)
                        <option value="{{$c->id}}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <label for="date">Date</label>
                <input type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="u_id">
            </div>

            <div class="col-lg-4">
                <label for="u_number">Farmer Number</label>
                <span id="farmersearch"  data-toggle="modal" data-target="#farmermodal" style="cursor: pointer;">( search (alt+s) )</span>
                <div class="form-group">
                    <input type="number" id="u_id" name="no" min="0" class="form-control next checkfarmer" data-next="amount" placeholder="Enter farmer number" required>
                </div>
            </div>

            <div class="col-lg-3">
                <label for="amount">Advance Amount</label>
                <input type="number" id="amount" min="0" name="amount" class="form-control next" data-next="save" placeholder="Enter advance amount" value="0" required>
            </div>
            <div class="col-lg-2">
                <input type="submit" id="save" class="btn btn-raised btn-primary waves-effect btn-block" value="Add" style="margin-top:30px;">
            </div>

        </div>
    </form>
</div>
</div>
<div class="pt-2 pb-2">
    <input type="text" id="sid" placeholder="Search">
</div>
<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Farmer Number</th>
                <th>Amount (Rs.)</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="advanceData">

        </tbody>
    </table>
</div>


<!-- edit modal -->


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-ff="eamount">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Edit Farmer</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="editform" onsubmit="return editData(event);">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="u_number">Farmer Number</label>
                                <input type="text" name="date" id="enepali-datepicker">
                                <div class="form-group">
                                    <input type="number" id="eu_id" name="user_id" min="0" class="form-control next" data-next="amount" placeholder="Enter farmer number" required readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="amount">Advance Amount</label>
                                <input type="number" id="eamount" min="0" name="amount" class="form-control" placeholder="Enter advance amount" value="0" required>
                            </div>
                            <div class="col-lg-12">
                                <button class="btn btn-raised btn-primary waves-effect btn-block" type="submit">Submit Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    // initTableSearch('searchid', 'farmerforData', ['name']);
    // load by date
    $("input#nepali-datepicker").bind('click', function (e) {
        var date = $('#nepali-datepicker').val();
        var center_id = $('#center_id').val();
        axios({
                method: 'post',
                url: '{{ route("admin.farmer.advance.list")}}',
                data : {'date' : date,'center_id':center_id}
            })
            .then(function(response) {
                // console.log(response.data);
                $('#advanceData').empty();
                $('#advanceData').html(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    });

    function initEdit(ele) {
        var adv = JSON.parse(ele.dataset.advance);
        console.log(adv);
        $('#eid').val(adv.id);
        $('#eu_id').val(adv.user.no);
        $('#eamount').val(adv.amount);
        $('#editModal').modal('show');

    }

    function saveData(e) {
        e.preventDefault();
        var bodyFormData = new FormData(document.getElementById('form_validation'));
        axios({
                method: 'post',
                url: '{{ route("admin.farmer.advance.add")}}',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response.data);
                if(response.data == "notOk"){
                    showNotification('bg-danger', 'Previous session is not closed yet!');
                    return;
                }
                showNotification('bg-success', 'Farmer advance added successfully!');
                $('#largeModal').modal('toggle');
                $('#advanceData').prepend(response.data);
                $('#u_id').val('');
                $('#amount').val(0);
                $('#u_id').focus();
            })
            .catch(function(response) {
                //handle error
                console.log(response);
                showNotification('bg-danger','operation Faild!');
            });
    }

    // edit data
    function editData(e) {
        e.preventDefault();
        var rowid = $('#eid').val();
        var bodyFormData = new FormData(document.getElementById('editform'));
        axios({
                method: 'post',
                url: '/admin/farmer/update',
                data: bodyFormData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response);
                showNotification('bg-success', 'Updated successfully!');
                $('#editModal').modal('toggle');
                $('#farmer-' + rowid).replaceWith(response.data);
            })
            .catch(function(response) {
                //handle error
                console.log(response);
            });
    }


    // delete
    function removeData(id) {
        var dataid = id;
        console.log(dataid);
        if (confirm('Are you sure?')) {
            axios({
                    method: 'get',
                    url: '/admin/farmer-advance-delete/'+ dataid,
                })
                .then(function(response) {
                    // console.log(response.data);
                    $('#advance-' + dataid).remove();
                    showNotification('bg-danger', 'Deleted Successfully !');
                })
                .catch(function(response) {
                    showNotification('bg-danger','You do not have authority to delete!');
                    //handle error
                    console.log(response);
                });
        }
    }

    // load advance
   $('#center_id').change(function(){
        var datadate = $('#nepali-datepicker').val();
        var center_id = $('#center_id').val();
        // alert(center_id);
        // console.log(datadate);
        axios({
                method: 'post',
                url: '{{ route("admin.advance.list.by.date")}}',
                data:{'date':datadate,'center_id':center_id}
        })
        .then(function(response) {
            $('#advanceData').empty();
            $('#advanceData').html(response.data);
            // $('').html(response.data);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });
   })

    window.onload = function() {
        var mainInput = document.getElementById("nepali-datepicker");
        mainInput.nepaliDatePicker();
        $('#u_id').focus();
        // loadAdvance();
    };

    var month = ('0'+ NepaliFunctions.GetCurrentBsDate().month).slice(-2);
    var day = ('0' + NepaliFunctions.GetCurrentBsDate().day).slice(-2);
    $('#nepali-datepicker').val(NepaliFunctions.GetCurrentBsYear() + '-' + month + '-' + day);

    function farmerId(id){
        $('#u_id').val(id);
        $('#farmermodal').modal('hide');
        $('#u_id').focus();
    }

    $(document).bind('keydown', 'alt+s', function(e){
       $('#farmermodal').modal('show');
    });
    $('#u_id').bind('keydown', 'alt+s', function(e){
       $('#farmermodal').modal('show');
    });

    // load farmer data by center id
    $('#center_id').change(function(){
        var center_id = $('#center_id').val();
        axios({
            method: 'post',
            url: '{{ route("load.farmer.data")}}',
            data:{'center':center_id}
        })
        .then(function(response) {
            $('#_farmers').html(response.data);
            initTableSearch('sid', 'farmerData', ['name']);
        })
        .catch(function(response) {
            //handle error
            console.log(response);
        });
    })
</script>
@endsection
