<tr id="ledger-{{$ledger->id}}">
    <td>
        {{$ledger->name}}
    </td>
    <td>
        {{(float)$ledger->amount}} {{$ledger->type==1?"CR":"DR"}}
    </td>
    <td>
        <button onclick="delData({{$ledger->id}})">
            Delete
        </button>
    </td>
</tr>
