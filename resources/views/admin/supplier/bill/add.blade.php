<div class="window " id="addBill">
    <div class="inner-window">
        <div class="top-bar">
            <span id="wt">
                Add Bill
            </span>
            <span id="wcc" onclick="$('#addBill').removeClass('shown')">
                close
            </span>
        </div>
        <div class="content" id="wc">
            <div class="p-2">
                <div class="card">
                    <div class="body">
                        <form id="add-bill" method="POST" onsubmit="return saveData(event);">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <label for="name">Choose Supplier</label>
                                            <select name="user_id" id="supplier"
                                                class="form-control show-tick ms select2" data-placeholder="Select"
                                                required>
                                                <option></option>
                                                @foreach (\App\Models\User::where('role', 3)->get() as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="name">Bill No.</label>
                                            <div class="form-group">
                                                <input type="text" id="billno" name="billno" class="form-control next"
                                                    data-next="nepali-datepicker" placeholder="Enter supplier bill no."
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="text" name="date" id="nepali-datepicker"
                                                    class="calender form-control" placeholder="Date" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptr" class="d-flex justify-content-between"> 
                                                    <span>
                                                    
                                                        Particular Items 
                                                    </span> 
                                                    <span  class=" btn-link p-0"
                                                    data-toggle="modal" data-target="#createItems">New Item+</span></label>
                                                <select name="" id="ptr" class="form-control show-tick ms select2"
                                                    data-placeholder="Select">
                                                    <option></option>
                                                    @foreach (\App\Models\Item::select('id','title','cost_price')->get() as $i)
                                                        <option value="{{$i->id}}"> {{ $i->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="from-group">
                                                <label for="rate"> Rate </label>
                                                <input type="number" onkeyup="singleItemTotal();"
                                                    class="form-control next" data-next="qty" id="rate" value="0"
                                                     step="0.001">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="from-group">
                                                <label for="qty"> Quantity </label>
                                                <input type="number" onkeyup="singleItemTotal();"
                                                    class="form-control next" data-next="total" id="qty" value="1"
                                                     step="0.001">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="from-group">
                                                <label for="rate"> Total </label>
                                                <input type="number" class="form-control" id="total" value="0"
                                                     step="0.001" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <div class="from-group">
                                                <label for="has_expairy"><input type="checkbox" id="has_expairy"> Expairy </label>
                                                <input type="date" class="form-control" id="exp_date" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2" >
                                            <div class="from-group">
                                                <span class="btn btn-primary btn-block" id="additem"
                                                    onclick="addItems();">Add</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 b-1">
                                    <div class="row">
                                        <div class="col-md-12 mt-4 mb-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Particular</th>
                                                        <th>Rate</th>
                                                        <th>Qty</th>
                                                        <Th>Total</Th>
                                                        <th>exp_date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="item_table">

                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-end">
                                                <div style="margin-top: 4px; margin-right: 5px;">
                                                    <div style="display:flex;width:100%;justify-content: flex-end;">
                                                        <strong> Total:</strong>
                                                        <input type="number"  step="0.01" value="0" id="itotal" readonly>
                                                    </div>
                                                    <div style="display:flex;width:100%;justify-content: flex-end;">
                                                        <strong> Discount:</strong>
                                                        <input type="number"  oninput="calculateTotal()"  step="0.01" value="0" id="idiscount" name="idiscount">
                                                    </div>
                                                    <div style="display:flex;width:100%;justify-content: flex-end;">
                                                        <strong> Taxable:</strong>
                                                        <input type="number"  step="0.01" value="0" id="itaxable"  readonly>
                                                    </div>
                                                    <div style="display:flex;width:100%;justify-content: flex-end;">
                                                        <strong> Tax:</strong>
                                                        <input type="number"  oninput="calculateTotal()"  step="0.01" value="0" id="itax" name="itax">
                                                    </div>
                                                    <div style="display:flex;width:100%;justify-content: flex-end;">
                                                        <strong> Grand Total:</strong>
                                                        <input type="number"  step="0.01" value="0" id="igrandtotal"  readonly>
                                                    </div>
                                                    <div style="display:flex;width:100%;justify-content: flex-end;">
                                                        <strong> Paid:</strong>
                                                        <input type="number" oninput="calculateTotal()" step="0.01" value="0" id="ipaid" name="ipaid">
                                                    </div>
                                                    <div style="display:flex;width:100%;justify-content: flex-end;"  readonly>
                                                        <strong> Due:</strong>
                                                        <input type="number"  step="0.01" value="0" id="idue">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    
                                    </div>
                                </div>
                                <div class="col-md-6 b-1">
                                    @include('admin.supplier.bill.extracharge')
                                </div>
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary">Add Bill</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js2')
    <script>
          function saveData(e) {
            e.preventDefault();
            if ($('#supplier').val() == '') {
                alert('Please select supplier.');
                $('#supplier').focus();
                return false;
            } else {
                var bodyFormData = new FormData(document.getElementById('add-bill'));
                axios({
                        method: 'post',
                        url: '{{ route('admin.supplier.bill.add') }}',
                        data: bodyFormData,
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function(response) {
                        console.log(response);
                        showNotification('bg-success', 'Supplier bill added successfully!');
                        $('#largeModal').modal('toggle');
                        $('#add-bill').trigger("reset")
                        $('#supplierBillData').prepend(response.data);
                        $('#item_table').empty();
                        $('#expense-items').empty();
                        $('#addBill').removeClass('shown');
                        $('#itotal').val(0);
                        $('#itax').val(0);
                        $('#itaxable').val(0);
                        $('#idiscount').val(0);
                        $('#igrandtotal').val(0);
                        $('#ipaid').val(0);
                        $('#idue').val(0);
                        $('#supplier').val('').change();;
                    })
                    .catch(function(response) {
                        //handle error
                        console.log(response);
                    });
            }
        }

        
        var i = 0;
        var itemKeys = [];
        // bill items js
        function singleItemTotal() {
            $('#total').val($('#rate').val() * $('#qty').val());
        }

        function addItems() {
            if ($('#ptr').val() == "" || $('#total').val() == 0) {
                alert('Please fill the above related field');
                $("#ptr").focus();
                return false;
            }
            title=$( "#ptr option:selected" ).text();
            id=$('#ptr').val();
            // console.log(item);
            html = "<tr id='row-" + i + "'>";
            html += "<td>" + title + "<input type='hidden' name='ptr_" + i + "' value='" + title +
                "' /> <input type='hidden' name='item_id_" + i + "' value='" + id + "' /><input type='hidden' name='counter[]' value='" + i + "' /></td>";
            html += "<td>" + $('#rate').val() + "<input type='hidden' name='rate_" + i + "' value='" + $('#rate').val() +
                "'/></td>";
            html += "<td>" + $('#qty').val() + "<input type='hidden' name='qty_" + i + "' value='" + $('#qty').val() +
                "'/></td>";
            html += "<td>" + $('#total').val() + "<input type='hidden' name='total_" + i + "' id='total_" + i +
                "' value='" + $('#total').val() + "'/></td>";
            if(document.getElementById('has_expairy').checked){
                html += "<td>" + $('#exp_date').val() + "<input type='hidden' name='has_exp_" + i + "' id='has_exp_" + i +
                    "' value='1'/><input type='hidden' name='exp_date_" + i + "' id='exp_date_" + i +
                    "' value='"+$('#exp_date').val() +"'/></td>";
            }else{

            }
            html += "<td> <span class='btn btn-danger btn-sm' onclick='RemoveItem(" + i + ");'>Remove</span></td>";
            html += "</tr>";
            $("#item_table").append(html);
            $('#ptr').val('').change();
            $('#rate').val('0');
            $('#qty').val('1');
            $('#total').val('0')
          
            itemKeys.push(i);
            i += 1;
            suffle();
        }

        function suffle() {
            $("#counter").val(itemKeys.join(","));
            calculateTotal();
        }

        function calculateTotal() {
            var itotal = 0;
            
            for (let index = 0; index < itemKeys.length; index++) {
                const element = itemKeys[index];
                itotal += parseFloat($("#total_" + element).val());;
            }
            var idiscount =parseFloat( $('#idiscount').val());
            var itaxable =itotal-idiscount;
            var itax =parseFloat( $('#itax').val());
            var igrandtotal=itaxable+itax;
            var ipaid =parseFloat( $('#ipaid').val());
            var idue=igrandtotal-ipaid;
            if(idue<0){
                idue=0;
            }
            $('#itotal').val(itotal);
            $('#itaxable').val(itaxable);
            $('#igrandtotal').val(igrandtotal);
            $('#idue').val(idue);
        }

        function RemoveItem(i) {
            $('#row-' + i).remove();
            var index = $.inArray(i, itemKeys);
            if (index > -1) {
                itemKeys.splice(index, 1);
            }
            suffle();
        }

        // create new Items

        function createNewItem(e) {
            e.preventDefault();
            var bodyFormData = new FormData(document.getElementById('add-item'));
            axios({
                    method: 'post',
                    url: '{{ route('admin.item.save') }}',
                    data: bodyFormData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    console.log(response);
                    showNotification('bg-success', 'Item added successfully!');
                    $('#createItems').modal('toggle');
                    $('#add-bill').trigger("reset")
                    var newOption = new Option(response.data.title, response.data.id, false, false);
                    $('#ptr').append(newOption).trigger('change');
                    // window.location.reload();
                })
                .catch(function(response) {
                    //handle error
                    console.log(response);
                });
        }

        $('#total').bind('keydown', function(e) {
            if(e.which==13){
                addItems();
            }
        });

        $('#has_expairy').change(function(){
            if(this.checked){
                $('#exp_date').removeAttr('disabled');
            }else{
                $('#exp_date').attr('disabled', 'disabled');
            }
        });
    </script>
@endsection
