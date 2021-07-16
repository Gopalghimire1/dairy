<style>
    .d-print-show{
        display:none !important;
    }

</style>
<div class="row">
    {{-- <div class="col-md-12 mt-3">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Sold Items</strong>
            <hr>
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <tr>
                    <th>Date</th>
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                </tr>
                   @php
                       $total = 0;
                       $paid = 0;
                       $due = 0;
                   @endphp
                   @foreach ($sell as $item)
                   <tr>
                       <td>{{ _nepalidate($item->date)}}</td>
                       <td>{{ $item->rate }}</td>
                       <td>{{ $item->qty }}</td>
                       <td>{{ $item->total }}</td>
                       <td>{{ $item->paid }}</td>
                       <td>{{ $item->deu }}</td>
                   </tr>
                       @php
                           $total += $item->total;
                           $paid += $item->paid;
                           $due += $item->deu;
                       @endphp
                   @endforeach
                    <tr>
                        <td colspan="5" class="text-right">Grand Total</td>
                        <td>{{ $total }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">Total Paid</td>
                        <td> {{ $paid }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">Total Due</td>
                        <td>{{ $due }}</td>
                    </tr>
            </table>
        </div>
    </div> --}}

    <div class="col-md-12 mt-3">
        <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
            <strong>Ledger</strong> <span class="btn btn-success" onclick="printDiv('ledger');">Print</span>
            <hr>

            <div id="ledger">
                <div class="d-print-show">
                    <style>
                        @media print {
                            td{
                                font-size: 1.2rem !important;
                                font-weight: 600 !important;
                            }


                            th:last-child, td:last-child {
                                display: none;
                            }

                        }
                        td,th{
                            border:1px solid black !important;
                            padding:2px !important;
                            font-weight: 600 !important;
                        }

                        table{
                            width:100%;
                            border-collapse: collapse;
                        }
                        thead {display: table-header-group;}
                        tfoot {display: table-header-group;}
                        .d-show-rate{

                            @if(env('showdisrate',0)==1)
                                display:inline;
                            @else
                                display:none !important;
                            @endif
                        }
                    </style>
                    <h2 style="text-align: center;margin-bottom:0px;font-weight:800;font-size:2rem;">
                        {{env('APP_NAME','Dairy')}} <br>

                    </h2>

                    <div style="font-weight:800;text-align:center;">
                        <span class="mx-3">  Ledger For : {{$user->name}} , </span>
                        {!!$title!!}
                    </div>
                </div>
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" >
                    <tr>
                        <th>Date</th>
                        <th>Particular</th>
                        <th>Cr. (Rs.)</th>
                        <th>Dr. (Rs.)</th>
                        <th>Balance (Rs.)</th>

                    </tr>

                    @foreach ($ledgers as $l)
                        <tr data-id="ledger{{$l->id}}">
                            <td>{{ _nepalidate($l->date) }}</td>
                            <td>{!! $l->title !!}</td>

                            <td>
                                @if ($l->type==1)
                                    {{ $l->amount }}
                                @endif
                            </td>
                            <td>
                                @if($l->type==2)
                                {{ $l->amount }}
                                @endif
                            </td>
                            <td>
                                {{ (($l->dr == null)|| ($l->dr<=0))?"":"Dr. ".$l->dr }}
                                {{(($l->cr == null)|| ($l->cr<=0))?"":"Cr. ".$l->cr }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

