<div class="row mt-4 ">
    <div class="col-md-12">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Paid Salary List For This Month</strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Date</th>
                    <th>Employee</th>
                    <th>Amount (Rs.)</th>
                </tr>
                @if (count($salary)>0)
                @php
                    $total = 0;
                @endphp
                @foreach ($salary as $item)
                    <tr>
                        <td>{{ _nepalidate($item->date) }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->amount }}</td>
                        <input type="hidden" value="{{ $item->amount }}" id="paid_salary">
                    </tr>
                    @php
                        $total += $item->amount;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="2" class="text-right"><strong>Total</strong> </td>
                    <td><strong> {{$total}} </strong></td>
                </tr>
                @else
                    <tr>
                        <td colspan="3" class="text-center">Not Paid Yet !</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    </div>


