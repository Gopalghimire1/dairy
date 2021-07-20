<div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-ff="name">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create Customer</h4>
            </div>
            <hr>
            <div class="card">
                <div class="body">
                    <form id="editCustomer" method="POST" onsubmit="return updateData(event);">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">Customer Name</label>
                                <div class="form-group">
                                    <input type="text" id="ename" name="name" class="form-control next" data-next="phone" placeholder="Enter customer name" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Customer Phone</label>
                                <div class="form-group">
                                    <input type="number" id="ephone" name="phone" class="form-control next" data-next="address" placeholder="Enter customer phone" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="name">Customer Address</label>
                                <div class="form-group">
                                    <input type="text" id="eaddress" name="address" class="form-control " data-next="rate" placeholder="Enter customer address" required>
                                </div>
                            </div>
                         
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

@section('js2')
    

    <script>
        function initEdit(ele){
            data=JSON.parse( ele.dataset.info);
            console.log(data);
            $('#eid').val(data.id);
            $('#ename').val(data.name);
            $('#ephone').val(data.phone);
            $('#eaddress').val(data.address);
            $('#editModal').modal('show');
        }
        function updateData(e) {
            e.preventDefault();
            if(!lock){
                lock=true;
                showProgress('Updating Customer');
                var data=new FormData(document.getElementById('editCustomer'));
                axios.post('{{route('admin.customer.update')}}',data)
                .then((res)=>{
                    id=$('#eid').val();
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
    </script>
@endsection