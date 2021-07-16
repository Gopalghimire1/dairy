@foreach ($ledgers as $ledger)
    @include('admin.emp.account.single',['ledger'=>$ledger])
@endforeach