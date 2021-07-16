@foreach ($billItem as $item)
    <tr>
        <td>{{ $item->title}}</td>
        <td>{{ $item->rate}}</td>
        <td>{{ $item->qty}}</td>
        <td>{{ $item->rate * $item->qty}}</td>
    </tr>
@endforeach
