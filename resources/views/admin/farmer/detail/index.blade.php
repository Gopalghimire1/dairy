<hr>
<div id="print" class="p-2">
    <div class="p-3">
        <div style="font-weight: 800" class="d-flex justify-content-start">
            <span class="mr-4">
                Farmer No : {{$farmer1->no}}
            </span>
            <span class="mr-4">

                 Name : {{$farmer1->name}}
            </span>
            <span class="mr-4">
                Phone no : {{$farmer1->phone}}
            </span>
        </div style="font-weight: 800">
        <div style="font-weight: 800" class="d-flex justify-content-start">
            <span class="mr-4">

                Year : {{$data['year']}}
            </span>
            <span class="mr-4">

                Month : {{$data['month']}}
            </span>
            <span class="mr-4">

                Session : {{$data['session']}}
            </span>
        </div style="font-weight: 800">
    </div>
    <div class="row ">
        <div class="col-md-6">
            <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
                {{-- <button class="btn btn-success" onclick="printDiv('milk-data');">Print</button> --}}
                <div id="milk-data">
                    <style>
                        td,th{
                            border:1px solid black;
                        }
                        table{
                            width:100%;
                            border-collapse: collapse;
                        }
                        thead {display: table-header-group;}
                        tfoot {display: table-header-group;}
                    </style>
                    <strong>Milk Data</strong>
                    <hr>
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <tr>
                            <th>Date</th>
                            <th>Morning (L)</th>
                            <th>Evening (L)</th>
                            <td class="d-print-none"></td>
                        </tr>
                        @php
                            $m = 0;
                            $e = 0;
                        @endphp
                            @foreach ($milkData as $milk)
                            <tr>
                                <td>{{ _nepalidate($milk->date) }}</td>
                                <td>{{ $milk->m_amount }}</td>
                                <td>{{ $milk->e_amount }}</td>
                                <td class="d-print-none">
                                    <button class="btn btn-primary btn-sm" data-milk="{{$milk->toJson()}}" onclick="showMilkUpdate(this)">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-milk="{{$milk->toJson()}}" onclick="delMilkData(this);">
                                        delete
                                    </button>
                                </td>
                            </tr>
                            @php
                                $m += $milk->m_amount;
                                $e += $milk->e_amount;
                            @endphp
                            @endforeach
                            <tr>
                                <td><strong>Total</strong></td>
                                <td>{{ $m }}</td>
                                <td>{{ $e }}</td>

                            </tr>
                    </table>
                        <strong>Grand Total : {{$farmer1->milkamount}}</strong> (Liter) <br>

                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">

                <div id="snffat-data">
                    <style>
                        td,th{
                            border:1px solid black;
                        }
                        table{
                            width:100%;
                            border-collapse: collapse;
                        }
                        thead {display: table-header-group;}
                        tfoot {display: table-header-group;}
                    </style>
                    <strong>Snf & Fats </strong>
                    <hr>
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <tr>
                            <th>Date</th>
                            <th>Snf (%)</th>
                            <th>Fats (%)</th>
                            <td class="d-print-none">

                            </td>
                        </tr>
                            @foreach ($snfFats as $sf)
                                <tr>
                                <td>{{ _nepalidate($sf->date) }}</td>
                                    <td>{{ $sf->snf }}</td>
                                    <td>{{ $sf->fat }}</td>
                                    <td class="d-print-none">
                                        <button class="btn btn-primary btn-sm" data-snffat="{{$sf->toJson()}}" onclick="showSnfFatUpdate(this)">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-snffat="{{$sf->toJson()}}" onclick="delSnfFat(this);">
                                            delete
                                        </button>
                                    </td>
                                </tr>

                            @endforeach
                    </table>
                    @php
                        if($milk_rate != null){
                            $rate_ = $milk_rate->rate;
                        }else{
                            $rate_ = round($farmer1->milkrate,2);
                        }
                    @endphp
                    <div style="display: flex">
                        <div style="flex:8;padding:10px;">
                            <strong>Snf Average : {{ round($farmer1->snfavg,2) }}</strong> <br>
                            <strong>Milk Total : {{ $farmer1->milkamount }} </strong><br>
                            <strong>Per Liter Rate : {{ $rate_ }} </strong> <br>
                                <strong>Amount : {{ $farmer1->totalamount }} </strong><br>
                                @if ($farmer1->farmer()->usetc)
                                    <strong>+TS Commission ({{(float)($center->tc)}}%) : {{ $farmer1->tc }}</strong> <br>
                                @endif
                                @if ($farmer1->farmer()->usecc)
                                    <strong>+Cooling Cost: {{ $farmer1->cc }}</strong>
                                @endif
                                <hr>
                                <strong>Total Amount: {{$farmer1->grandtotal}}</strong>
                        </div>
                        <div style="flex:4;padding:10px;">
                            <strong>Fat Average : {{ round($farmer1->fatavg,2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-12 mt-3">
            <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">
                <strong>Sold Items</strong>
                <hr>
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <tr>
                        <th>Date</th>
                        <th>Item Name</th>
                        <th>Item Number</th>
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
                       @foreach ($sellitem as $item)
                       <tr>
                           <td>{{ _nepalidate($item->date)}}</td>
                           <td>{{ $item->item->title }}</td>
                           <td>{{ $item->item->title }}</td>
                           <td>{{ $item->rate }}</td>
                           <td>{{ $item->qty }}</td>
                           <td>{{ $item->total }}</td>
                           <td>{{ $item->paid }}</td>
                           <td>{{ $item->due }}</td>
                       </tr>
                           @php
                               $total += $item->total;
                               $paid += $item->paid;
                               $due += $item->due;
                           @endphp
                       @endforeach
                        <tr>
                            <td colspan="7" class="text-right">Grand Total</td>
                            <td>{{ $total }}</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-right">Total Paid</td>
                            <td> {{ $paid }}</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-right">Total Due</td>
                            <td>{{ $due }}</td>
                        </tr>
                </table>
            </div>
        </div> --}}

        @if (count($farmer1->ledger)>0)
            <div class="col-md-12 mt-3">
                <div style="border: 1px solid rgb(136, 126, 126); padding:1rem;">

                    <div id="ledger-data">
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
                        </style>
                        <strong>Ledger</strong>
                        <hr>
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <tr>
                                <th>Date</th>
                                <th>Particular</th>
                                <th>Cr. (Rs.)</th>
                                <th>Dr. (Rs.)</th>
                                <th>Balance (Rs.)</th>
                                <th class="d-print-none"></th>
                            </tr>

                            @foreach ($farmer1->ledger as $l)
                                <tr>
                                    <td>{{ _nepalidate($l->date) }}</td>
                                    <td>{{ $l->title }}</td>

                                    <td>
                                        @if ($l->type==1)
                                            {{ (float)$l->amount }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($l->type==2)
                                        {{ (float)$l->amount }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $l->dr>0 ?"Dr. ".(float)$l->dr:""}}

                                        {{ $l->cr>0 ?"Cr. ".(float)$l->cr:"" }}

                                        {{($l->cr==0 || $l->cr==null) && ($l->dr==0 || $l->dr==null)?"--":""}}
                                    </td>
                                    <td class="d-print-none">
                                        @if ($l->identifire==103)
                                            @if($l->getForeign()!=null)
                                            <button data-ledger="{{$l->toJson()}}" data-data="{{$l->getForeign()->toJson()}}" onclick="sellLedgerChange(this);">Edit</button>
                                            <button data-ledger="{{$l->toJson()}}" data-data="{{$l->getForeign()->toJson()}}" onclick="sellLedgerDelete(this);">Delete</button>
                                            @else
                                            <button data-ledger="{{$l->toJson()}}"  onclick="initLedgerChange(this);">Edit</button>
                                            <button data-ledger="{{$l->toJson()}}"  onclick="delLedger({{$l->id}});">Delete</button>
                                            @endif
                                        @else
                                            <button data-ledger="{{$l->toJson()}}"  onclick="initLedgerChange(this);">Edit</button>
                                            <button data-ledger="{{$l->toJson()}}"  onclick="delLedger({{$l->id}});">Delete</button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-12">

            <hr>
            <h5 class="font-weight-bold">
                Session Summary
            </h5>
            <hr>

            <div class="report p-2">
                <table class="table">
                    <tr>
                        <th>
                            Total Milk
                        </th>
                        <th>
                            Fat
                        </th>
                        <th>
                            Snf
                        </th>
                        <th>
                            Rate
                        </th>
                        @if ($farmer1->cc>0 || $farmer1->tc>0)
                            <th>
                                Milk Total
                            </th>
                            @if($farmer1->farmer()->usetc)
                            <th>
                                TS
                            </th>
                            @endif
                            @if($farmer1->farmer()->usecc)
                            <th>
                                Cooling Cost
                            </th>
                            @endif
                            <th>
                                Total
                            </th>
                        @else
                            <th>
                                Total
                            </th>
                        @endif
                        @if (env('hasextra',0)==1)
                            <th>Bonus</th>
                        @endif
                        <th>Purchase</th>
                        <th>Payment</th>
                        <th>Avance</th>
                        <th>
                            Prev Balance
                        </th>
                        <th>
                            Prev Due
                        </th>
                        <th>
                            Paid
                        </th>
                        <th>Net Total</th>
                        <th>Due Balance</th>
                        <th>

                        </th>
                    </tr>
                    <tr>
                        <td>
                            {{$farmer1->milkamount}}
                        </td>
                        <td>
                            {{$farmer1->fatavg}}
                        </td>
                        <td>
                            {{$farmer1->snfavg}}
                        </td>
                        <td>
                            @if ($milk_rate != null)
                              {{ $milk_rate->rate }}
                            @else
                               {{ $farmer1->milkrate }}
                            @endif

                        </td>
                        @if ($farmer1->cc>0 || $farmer1->tc>0)
                            <th>
                                {{$farmer1->totalamount}}
                            </th>
                            @if($farmer1->farmer()->usetc)
                            <th>
                                {{$farmer1->tc}}
                            </th>
                            @endif
                            @if($farmer1->farmer()->usecc)
                            <th>
                                {{$farmer1->cc}}
                            </th>
                            @endif
                            <th>
                                {{$farmer1->grandtotal}}
                            </th>
                        @else
                            <th>
                                {{$farmer1->grandtotal}}

                            </th>
                        @endif
                        @if (env('hasextra',0)==1)
                            <td> {{$farmer1->bonus}}   </td>

                        @endif
                        <td>
                            {{$farmer1->due}}
                        </td>
                        <td>
                            {{$farmer1->fpaid}}
                        </td>
                        <td>
                            {{$farmer1->advance}}
                        </td>
                        <td>
                            {{$farmer1->prevbalance}}
                        </td>
                        <td>
                            {{$farmer1->prevdue}}
                        </td>
                        <td>{{$farmer1->paidamount}}</td>


                        <td>
                            {{$farmer1->nettotal}}
                        </td>
                        <td>
                            {{$farmer1->balance}}
                        </td>
                        <td>
                            @if ($farmer1->old==false)
                            <form action="{{route('report.farmer.single.session')}}" method="POST">
                                @csrf
                                <input type="hidden" name="year" value="{{$data['year']}}">
                                <input type="hidden" name="month" value="{{$data['month']}}">
                                <input type="hidden" name="session" value="{{$data['session']}}">
                                <input type="hidden" name="id" value="{{$farmer1->id}}">
                                <input type="hidden" name="snf" value="{{ $farmer1->snfavg }}">
                                <input type="hidden" name="fat" value="{{ $farmer1->fatavg }}">
                                <input type="hidden" name="rate" value=" {{ $farmer1->milkrate }}">
                                <input type="hidden" name="milk" value="{{ $farmer1->milkamount }}">
                                <input type="hidden" name="total" value=" {{ $farmer1->total }}">
                                <input type="hidden" name="grandtotal" value=" {{ $farmer1->grandtotal }}">
                                <input type="hidden" name="cc" value=" {{ $farmer1->cc }}">
                                <input type="hidden" name="tc" value=" {{ $farmer1->tc }}">
                                <input type="hidden" name="due" value=" {{ $farmer1->due}}">
                                <input type="hidden" name="bonus" value=" {{ $farmer1->bonus}}">
                                <input type="hidden" name="advance" value=" {{ $farmer1->advance }}">
                                <input type="hidden" name="prevdue" value=" {{ $farmer1->prevdue}}">
                                <input type="hidden" name="nettotal" value=" {{ $farmer1->nettotal }}">
                                <input type="hidden" name="balance" value=" {{ $farmer1->balance}}">
                                <input type="hidden" name="prevbalance" value=" {{ $farmer1->prevbalance}}">
                                <input type="hidden" name="paidamount" value=" {{ $farmer1->paidamount}}">
                                <input type="hidden" name="fpaid" value=" {{ $farmer1->fpaid}}">
                                <label for=>Session Close Date</label>
                                <input type="text" name="date" id="closedate" readonly required>
                                <button class="btn btn-sm btn-success">Close Session</button>
                            </form>
                             @else
                                Session Closed
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
