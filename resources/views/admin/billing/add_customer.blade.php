<div class="modal fade" id="addModal" tabindex="-1" role="dialog" data-ff="name">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create Customer</h4>
            </div>
            
            <div class="card p-3">
                <div class="body">
                    <form id="addCustomer" method="POST" onsubmit="return saveData(event);">
                        @csrf
                        <input type="hidden" name="json" value="1">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Customer Name</label>
                                <div class="form-group">
                                    <input type="text" id="name" name="name" class="form-control next" data-next="phone" placeholder="Enter customer name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Customer Phone</label>
                                <div class="form-group">
                                    <input type="number" id="phone" name="phone" class="form-control next" data-next="address" placeholder="Enter customer phone" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Customer Address</label>
                                <div class="form-group">
                                    <input type="text" id="address" name="address" class="form-control " data-next="rate" placeholder="Enter customer address" required>
                                </div>
                            </div>

                            {{-- <div class="col-lg-6">
                                <label for="rate">Rate</label>
                                <div class="form-group">
                                    <input type="number" id="rate" name="rate" step="0.001" min="0.001" class="form-control next" data-next="amt" placeholder="Enter rate" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="amt">Amount(Qty)</label>
                                <div class="form-group">
                                    <input type="number" id="amt" name="amount" step="0.001" min="0.001" class="form-control" placeholder="Enter amount" required>
                                </div>
                            </div> --}}
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-raised btn-primary waves-effect" type="submit">Submit Data</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

@section('scripts1')
    

    <script>
        function saveData(e) {
            e.preventDefault();
            if(!lock){
                lock=true;
                showProgress('Adding Customer');
                var data=new FormData(document.getElementById('addCustomer'));
                axios.post('{{route('admin.customer.add')}}',data)
                .then((res)=>{
                    $('#data').append(res.data);
                    hideProgress();
                    lock=false;
                    $('#addModal').modal('hide');
                    document.getElementById('addCustomer').reset();
                   
                    html='<tr  class="hovertr" id="distri_'+res.data.id+'" " onclick="selectCustomer('+res.data.id+',\''+res.data.user.name+'\')"> <td>'+res.data.id+'</td><td>'+res.data.user.name+'</td></tr>';
                    $('#customers').append(html);
                    if(state==2){
                        selectCustomer(res.data.id,res.data.user.name);
                    }
                })
                .catch((err)=>{
                    hideProgress();
                    lock=false;
                })
            }
        }
    </script>
@endsection