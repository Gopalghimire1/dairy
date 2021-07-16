<style>
    td,th{
        border:1px solid black !important;
        padding:2px !important;
        font-weight: 600 !important;
    }
</style>
<hr>
@php
    $track=0;
@endphp
<div class="p-2">
    <table class="table">
        <tr>
            <th>Date</th>
            <th>Title</th>
            <th>CR</th>
            <th>DR</th>
            <th>Balance</th>
        </tr>
        @foreach ($ledgers as $l)
            <tr>
                <td>
                    {{_nepalidate($l->date)}}
                </td>
                <td>
                    {{$l->title}}
                </td>
                <td>
                    @if ($l->type==1)
                        {{ $l->amount }}
                        @php
                            $track-=$l->amount;
                        @endphp
                    @endif
                </td>
                <td>
                    @if($l->type==2)
                    {{ $l->amount }}
                    @php
                        $track+=$l->amount;
                    @endphp
                    @endif
                </td>
                <td>
                    {{ (($l->dr == null)|| ($l->dr<=0))?"":"Dr. ".$l->dr }}
                    {{(($l->cr == null)|| ($l->cr<=0))?"":"Cr. ".$l->cr }}
                </td>
            </tr>
        @endforeach
        @if ($empSession==null)
        @php
            $remaning=$employee->salary + $track;
        
        @endphp
        <tr>
            <td></td>
            <td>
                Salary For This Month
            </td>
            <td>

            </td>
            <td>
                {{$employee->salary}}
            </td>
            <td>
                @if ($remaning==0)
                    No Payable and Transfarable 
                @else
                    {{ $remaning>=0?"Dr.":"Cr."}} {{ $remaning<0?(-1*$remaning):$remaning}} 
                @endif
                
            </td>
        </tr>
        @endif
    </table>
</div>
<hr>
@if ($empSession==null)


@if ($remaning>0)  
    <div class="p-2">
        <div class="row">
            <div class="col-md-4">
                <label for="date">Date</label>
                <input readonly type="text" name="date" id="nepali-datepicker" class="form-control" placeholder="Date">
            </div>
            <div class="col-md-4">
                <label for="total"> Monthly Salary </label>
                <input type="text" id="salary" class="form-control" value="{{ $employee->salary }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="pay">Pay Salary </label>
                <input type="text" class="form-control" id="p_amt" name="salary" min="0" step="0.001"  value="{{$remaning}}">
            </div>
            <div class="col-md-9 mt-1">
                <label for="detail">Payment Detail</label>
                <input type="text" class="form-control" id="p_detail" placeholder="Payment details">
            </div>
            <div class="col-md-3" >
                <span class="btn btn-primary btn-block" style="margin-top:35px;" onclick="salaryPayment();"> Pay Now </span>
            </div>
        </div>
    </div>
   
@endif
<div class="p-2">
    <hr>
    <button class="btn btn-primary w-25" onclick="closeMonth()">Close Month</button>
</div>
@else
    <h4>Month already Closed</h4>
@endif