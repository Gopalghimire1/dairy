<div class="table-responsive">
    <table id="newstable1" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Paid By</th>
                <th>Amount (Rs.)</th>
                <th>Payment Detail</th>
                <th>Remarks</th>
            </tr>
        </thead>
        @php
            $total = 0;
        @endphp
        <tbody>
            @foreach ($data as $d)
                <tr>
                    <td>{{ $d->title }}</td>
                    <td>{{ _nepalidate($d->date) }}</td>
                    <td>{{ $d->payment_by }}</td>
                    <td>{{ $d->amount }}</td>
                    <td>{{ $d->payment_detail}}</td>
                    <td>{{ $d->remark }}</td>
                </tr>
                @php
                    $total += $d->amount;
                @endphp
            @endforeach
        </tbody>
        <tr>
            <td colspan="3" class="text-right"><strong>Total</strong></td>
            <td colspan="3"><strong> {{ $total }} </strong></td>
        </tr>
    </table>
</div>
