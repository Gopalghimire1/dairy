<tr id="ledger-{{$ledger->id}}">
    <th>
        {{$ledger->name}}
    </th>
    <td>
        {{$ledger->amount}} {{$ledger->type==1?"CR":"DR"}}
    </td>
    <td>
        <button class="btn btn-primary" onclick="initEditLedger('Edit Account Opening',{{$ledger->id}});">Edit</button>
        <button class="btn btn-danger" onclick="deleteLedger({{$ledger->id}},removeData);">Delete</button>
    </td>
</tr>