@php
    $t=0;$bt=0;$pt=0;

@endphp
{{-- <table id="newstable1" class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Product</th>
            <th>Rate</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Due</th>

        </tr>
    </thead>
    <tbody >

        @foreach ($bills as $bill)
            <tr>
                <td>
                    {{_nepalidate($bill->date)}}
                </td>
                <td>
                    {{$bill->product->name}}
                </td>
                <td>
                    {{$bill->rate}}
                </td>
                <td>
                    {{$bill->qty}}
                </td>
                <td>
                    {{$bill->total}}
                    @php
                        $bt+=$bill->total;
                    @endphp
                </td>
                <td>
                    {{$bill->paid}}
                    @php
                        $pt+=$bill->paid;
                    @endphp
                </td>
                <td>
                    {{$bill->deu}}
                    @php
                        $t+=$bill->deu
                    @endphp
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-right">
                Total
            </td>
            <td>
                {{$bt}}
            </td>
            <td>
                {{$pt}}
            </td>
            <td>
                {{$t}}
            </td>
        </tr>
    </tbody>
</table> --}}

<div class="card py-4 px-2 my-3 shadow" style="font-size:2rem;font-weight:600;">
    <strong>
        Current Balance :
    </strong>
    {{rupee((float)$supplier->amount )}}
    {{$supplier->amounttype==1?"CR":"DR" }}
</div>
<div class="card py-4 px-2 my-3 shadow">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input readonly type="text" name="date" id="nepali-datepicker" class="form-control next" data-next="user_id" placeholder="Date">
            </div>
        </div>
        <div class="col-md-6">
            {{-- <input type="hidden" id="u_id" value="{{$id}}"> --}}
            <input  placeholder="Enter Payment Amount" type="number" id="amount" class="form-control" min="1" step="=0.01" >
        </div>
        <div class="col-md-12 py-2">
            <label>
                Payment Method
            </label>
            <textarea id="method" class="form-control"></textarea>
        </div>
        <div class="col-md-4">
            <button class="btn btn-success" onclick="pay()">Pay</button>
        </div>

    </div>
</div>
