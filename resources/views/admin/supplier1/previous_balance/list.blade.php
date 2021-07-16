@foreach ($ledgers as $ledger)
    @include('admin.supplier.previous_balance.single',['ledger'=>$ledger])
@endforeach
