@php
    $mtotal = 0;
    $etotal = 0;
@endphp
@foreach($milkdatas as $d)
@if ($d->user()!=null)
@php
    $mtotal += $d->m_amount;
    $etotal += $d->e_amount;
@endphp

    <tr  id="milk-{{$d->user()->no}}" data-m_amount="{{ $d->m_amount??0 }}" data-e_amount="{{ $d->e_amount??0 }}">
        <td>{{ $d->user()->no }}</td>
        <td id="m_milk-{{$d->user()->no}}"  >{{ $d->m_amount??0}}</td>
        <td id="e_milk-{{$d->user()->no}}" >{{ $d->e_amount??0 }}</td>
    </tr>
@endif
@endforeach
<tr>
    <td><strong>Total</strong></td>
    <td><strong>{{ $mtotal }}</strong></td>
    <td><strong>{{ $etotal }}</strong></td>
</tr>
