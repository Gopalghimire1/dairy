<form action="{{route('ledger1.update')}}" method="post" id="xp_1" class="p-5" onsubmit="event.preventDefault();updateLedger();">
    <div class="">
        @csrf
    <div class="row m-0">
        <input type="hidden"  name="id" value="{{$ledger->id}}">
        <div class="col-md-6">
            <label for="amount">amount</label>
            <input type="number" name="amount" id="amount" class="form-control" value="{{$ledger->amount}}">
        </div>
        <div class="col-md-6">
            <label for="l_type">type</label>
            <select  id="l_type" name="type" class="show-tick ms select2 form-control">
                <option value="1" {{$ledger->type==1?"selected":""}}>CR</option>
                <option value="2" {{$ledger->type==2?"selected":""}}>DR</option>
            </select>
        </div>
        <div class="col-md-12 text-right pt-2">
            <span  class="btn btn-secondary mr-2" onclick="win.hide()">Close</span>
            <span  class="btn btn-primary" onclick="updateLedger();">Save changes</span>
        </div>
    </div>
</div>
</form>
<div class="modal-footer">

</div>
