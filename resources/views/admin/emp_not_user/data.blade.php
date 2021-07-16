<div class="row mt-4 ">
    <div class="col-md-12">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Paid Salary List </strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Date</th>
                    <th>Employee</th>
                    <th>Amount (Rs.)</th>
                </tr>
                @foreach ($salary as $item)
                    <tr>
                        <td>{{ _nepalidate($item->date) }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->amount }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong> Advance List</strong>
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
                        <td colspan="3" class="text-center"> No any data available!</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>

{{-- <div class="row mt-4">
    <div class="col-md-12">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong> Ledger</strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Date</th>
                    <th>Particular</th>
                    <th>Cr. (Rs.)</th>
                    <th>Dr. (Rs.)</th>
                    <th>Balance (Rs.)</th>
                    <th></th>
                </tr>

            </table>
        </div>
    </div>
</div> --}}
