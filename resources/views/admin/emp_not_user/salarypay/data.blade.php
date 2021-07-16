<div class="row mt-4">
    <div class="col-md-12">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Monthly Advance Amount</strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Advance Amount (Rs.)</th>
                </tr>
                @php
                    $totAdv = 0;
                @endphp
                @if (count($employee)>0)
                   @foreach ($employee as $emp)
                    <tr>
                        <td>{{ _nepalidate($emp->date) }}</td>
                        <td>{{ $emp->title }}</td>
                        <td>{{ $emp->amount }}</td>
                    </tr>

                    @php
                        $totAdv += $emp->amount;
                    @endphp
                    @endforeach
                    <tr>
                        <td colspan="2" class="text-right"><strong>Total</strong> </td>
                        <td>{{$totAdv}}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="3" class="text-center"> No any advance paid on this month!</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    </div>

    <div class="mt-4" style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
    <div class="row">
        <div class="col-md-4">
            <label for="date">Date</label>
            <input readonly type="text" name="date" id="nepali-datepicker" class="form-control" placeholder="Date">
        </div>
        <div class="col-md-4">
            <label for="total"> Monthly Salary </label>
            <input type="text" id="salary" class="form-control" value="{{ $salary->salary }}" readonly>
        </div>
        <div class="col-md-4">
            <label for="pay">Pay Salary </label>
            <input type="hidden" value="{{$totAdv}}" id="tot-adv">
            <input type="text" class="form-control" id="p_amt" name="salary" min="0" step="0.001" readonly>
        </div>

        <div class="col-md-9 mt-1">
            <label for="detail">Payment Detail</label>
            <input type="text" class="form-control" id="p_detail" placeholder="Payment details">
        </div>
        <div class="col-md-3" >
            <span class="btn btn-primary btn-block" style="margin-top:35px;" onclick="salaryPayment();"> Pay Now </span>
        </div>
        <hr>

        <div class="col-md-12 mt-5">
            <input type="checkbox" onchange="
            if(this.checked){
                $('.trans').removeClass('d-none');
            }else{
                $('.trans').addClass('d-none');
            }
            ">
            <label for="pay">Transfer Advance Amount </label>
        </div>
        <div class="col-md-4 trans d-none">
            <label for="transfer amt">Transfer Amount</label>
            <input type="number" id="transfer_amount" class="form-control" min="0" step="0.001">
        </div>
        <div class="col-md-3 trans d-none">
            <span class="btn btn-primary btn-block" style="margin-top:35px;" onclick="transferAmt();"> Transfer Now </span>
        </div>
      </div>
    </div>
