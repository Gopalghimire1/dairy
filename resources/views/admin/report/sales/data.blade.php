<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#data-1" role="tab" aria-controls="home" aria-selected="true">Farmer Sales</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#data-2" role="tab" aria-controls="profile" aria-selected="false">Normal Sales</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#data-3" role="tab" aria-controls="contact" aria-selected="false">Distributor Sales Single</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#data-4" role="tab" aria-controls="contact" aria-selected="false">Distributor Sales Group</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="data-1" role="tabpanel" aria-labelledby="home-tab">
      <div class="py-3">
        <span class="btn btn-success" onclick="printDiv('table-1');"> Print Report</span>

      </div>
    <div id="table-1">
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

        <table >
            <thead>
                @php
                    $i=1;
                @endphp
                <tr>

                    <th>
                        SN
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Farmer
                    </th>
                    <th>
                        Item Name
                    </th>
                    <th>
                        Rate
                    </th>
                    <th>
                        Qty
                    </th>
                    <th>
                        Total
                    </th>
                    <th>
                        Due
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['sellitem'] as $sellitem)
                    <tr>
                        <td>
                            {{$i++}}
                        </td>
                        <td>
                            {{_nepalidate($sellitem->date)}}

                        </td>
                        <td>
                            {{$sellitem->name}} ( {{$sellitem->no}} )
                        </td>
                        <td>
                            {{$sellitem->title}}
                        </td>
                        <td>
                            {{$sellitem->rate}}
                        </td>
                        <td>
                            {{$sellitem->qty}}
                        </td>
                        <td>
                            {{$sellitem->total}}
                        </td>
                        <td>
                            {{$sellitem->due}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

  </div>
  <div class="tab-pane fade" id="data-2" role="data-2" aria-labelledby="profile-tab">...</div>
  <div class="tab-pane fade" id="data-3" role="data-3" aria-labelledby="contact-tab">
    <div class="py-3">
        <span class="btn btn-success" onclick="printDiv('table-3');"> Print Report</span>

      </div>
    <div id="table-3">
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

        <table >
            <thead>
                @php
                    $i=1;
                @endphp
                <tr>

                    <th>
                        SN
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Distributor
                    </th>

                    <th>
                        Rate
                    </th>
                    <th>
                        Qty
                    </th>
                    <th>
                        Total
                    </th>

                </tr>
            </thead>
            <tbody>
                @php
                    $dqty=0;
                    $dtot=0;
                @endphp
                @foreach ($data['sellmilk'] as $sellmilk)
                    <tr>
                        <td>
                            {{$i++}}
                        </td>
                        <td>
                            {{_nepalidate($sellmilk->date)}}
                        </td>
                        <td>
                            {{$sellmilk->name}}
                        </td>

                        <td>
                            {{$sellmilk->rate}}
                        </td>
                        <td>
                            {{$sellmilk->qty}}
                            @php
                                $dqty+=$sellmilk->qty;
                            @endphp
                        </td>
                        <td>
                            {{$sellmilk->total}}
                            @php
                                $dtot+=$sellmilk->total
                            @endphp
                        </td>

                    </tr>
                @endforeach
                <tr style="Font-size:1.1rem;">
                    <th colspan="4">Total</th>
                    <th>{{$dqty}}</th>
                    <th>{{$dtot}}</th>
                </tr>
            </tbody>
        </table>
    </div>
  </div>
  <div class="tab-pane fade" id="data-4" role="data-4" aria-labelledby="contact-tab">
    <div class="py-3">
        <span class="btn btn-success" onclick="printDiv('table-4');"> Print Report</span>

      </div>
    <div id="table-4">
    <style>
        td,th{
            border:1px solid black;
            padding:3px 5px;
        }
        table{
            width:100%;
            border-collapse: collapse;
        }
        thead {display: table-header-group;}
        tfoot {display: table-header-group;}
    </style>

        <table >
            <thead>
                @php
                    $i=1;
                @endphp
                <tr>

                    <th>
                        SN
                    </th>

                    <th>
                        Distributor
                    </th>

                    <th>
                        Item
                    </th>
                    <th>
                        Qty
                    </th>
                    <th>
                        Total
                    </th>

                </tr>
            </thead>
            <tbody>
                @php
                    $productcatlog=[];
                    $dgqty=0;
                    $dgtot=0;
                @endphp
                @foreach ($maxdatas as $data)
                    <tr>
                        <th>
                            {{$i++}}
                        </th>

                        <th colspan="4">
                            {{$data->distributor->user->name}}
                        </th>
                        {{-- <td colspan="3"></td> --}}
                    </tr>
                    <tr style="background:#007ACC;color:white;">
                        @foreach ($data->products as $product)
                            @php
                                if(!isset($productcatlog['pro_'.$product->product->id])){
                                    $productcatlog['pro_'.$product->product->id]=[];
                                    $productcatlog['pro_'.$product->product->id]['name']=$product->product->name;
                                    $productcatlog['pro_'.$product->product->id]['amount']=0;
                                    $productcatlog['pro_'.$product->product->id]['qty']=0;

                                }
                            @endphp
                            {{-- <td colspan="2"></td> --}}
                            <th colspan="3" style="text-align:right;">
                                {{$product->product->name}}
                            </th>
                            <th>
                                {{$product->qty}}
                                @php
                                     $dgqty+=$product->qty;
                                     $productcatlog['pro_'.$product->product->id]['qty']=$productcatlog['pro_'.$product->product->id]['qty']+$product->qty;
                                @endphp
                            </th>
                            <th>
                                {{$product->total}}
                                @php
                                    $productcatlog['pro_'.$product->product->id]['amount']=$productcatlog['pro_'.$product->product->id]['amount']+$product->total;
                                    $dgtot+=$product->total;
                                @endphp
                            </th>
                        </tr>
                        @endforeach


                @endforeach
                    <tr>
                        <th colspan="3">Total</th>
                        <th>
                            {{$dgqty}}
                        </th>
                        <th>
                            {{$dgtot}}
                        </th>
                    </tr>
            </tbody>
        </table>
        <hr>
        <div >
            <table>
                <tr>
                    <th>product</th><th>Qty</th><th>Amount</th>
                </tr>
                    @foreach ($productcatlog as $catlog)
                    <tr>
                        <th>{{$catlog['name']}}</th><th>{{$catlog['qty']}}</th><th>{{$catlog['amount']}}</th>
                    </tr>
                    @endforeach
            </table>
        </div>
    </div>
  </div>
</div>
