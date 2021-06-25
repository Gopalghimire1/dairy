

@foreach ($data1 as $key=>$milkdatas)
    <div id="center-{{$key}}" class="p-4 shadow m-3">
        <div>
            <button class="btn success" style="float: right;" onclick="printDiv('center-data-{{$key}}')">Print</button>
        </div>

        <div id="center-data-{{$key}}">
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
            <h2 style="text-align: center;margin-bottom:0px;font-weight:800;font-size:2rem;">
                Collection Center : {{\App\Models\Center::find($key)->name}}
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>
                            Farmer No
                        </th>

                        <th>
                            Farmer Name
                        </th>

                        <th>
                            Milk Amount
                        </th>
                    </tr>

                </thead>
                <tbody>
                    @php
                        $mtotal = 0;
                    @endphp
                    @foreach ($milkdatas as $milkdata)
                    @php
                        $mtotal += $milkdata->milk;
                    @endphp
                        <tr>
                            <td>
                                {{$milkdata->no}}
                            </td>
                            <td>
                                {{$milkdata->name}}
                            </td>
                            <td>
                                {{$milkdata->milk}}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2"><strong>Total</strong></td>
                        <td>{{ $mtotal }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endforeach
