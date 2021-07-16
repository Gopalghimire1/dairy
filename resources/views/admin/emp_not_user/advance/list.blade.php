@foreach ($advances as $advance)
    @include('admin.emp.advance.single',['advance'=>$advance]);
@endforeach
