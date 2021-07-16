<tr id="ledger-{{$ledger->id}}">
    <td>
        {{$ledger->name}}
    </td>
    <td>
        {{(float)$ledger->amount}} {{$ledger->type==1?"CR":"DR"}}
    </td>
    <td>
        <button class="btn btn-primary" onclick="initEditLedger('Edit Account Opening',{{$ledger->id}});">Edit</button>
        <button class="btn btn-danger" onclick="deleteLedger({{$ledger->id}},delData)">
            Delete
        </button>
    </td>
</tr>
