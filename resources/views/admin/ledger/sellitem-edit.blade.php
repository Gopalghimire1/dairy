<form action="{{route('ledger1.update')}}" method="post" id="xp_1">
    <div class="p-5">
        @csrf
        <div class="row m-0">
            <input type="hidden"  name="id" value="{{$ledger->id}}">

            <div class="col-md-3">
                <label for="s_rate">Rate</label>
                <input type="number" name="rate" value="{{$sellitem->rate}}" id="s_rate" class="form-control" step="0.01" oninput="s_calculate();">
            </div>
            <div class="col-md-3">
                <label for="s_qty">Qty</label>
                <input type="number" name="qty" value="{{$sellitem->qty}}" id="s_qty" class="form-control" step="0.01" oninput="s_calculate();">
            </div>
            <div class="col-md-6">
                <label for="s_total">Total</label>
                <input type="number" name="amount" value="{{$ledger->amount}}" id="s_amount" class="form-control" step="0.01" readonly>
            </div>
            <div class="col-md-12 text-right pt-2">
                <span type="button" class="btn btn-secondary mr-2" onclick="win.hide()">Close</span>
                <span type="button" class="btn btn-primary" onclick="updateLedger();">Save changes</span>
            </div>
        </div>
    </div>
</form>
