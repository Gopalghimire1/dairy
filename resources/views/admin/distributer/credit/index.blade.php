@extends('admin.layouts.app')
@section('title','Distributer Credit List')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
@endsection
@section('head-title','Distributer Credit List')
@section('toobar')

@endsection
@section('content')
<div class="p-3">
    <form action="{{route('admin.sms.distributer.credit')}}" method="POST" onsubmit="return check();">
        @csrf
        <table class="table table-bordered">
            <tr>
                <th>
                    <input type="checkbox"  onchange="selectChange(this)">
                </th>
                <th>Name</th>
                <th>
                    Address
                </th>
                <th>
                    Phone
                </th>
                <th>
                    Limit (Rs.)
                </th>
                <th>
                    Credit (Rs.)
                </th>
                <th>
                    last Transaction /<br> Payment
                </th>
                <th>
                    Last SMS
                </th>
                
            </tr>
            @foreach ($data as $user)
                <tr>
                    <td>
                        <input type="checkbox" name="ids[]" value="{{$user->id}}" class="selectable">
                        <input type="hidden" name="amount_{{$user->id}}" value="{{$user->amount}}">
                        <input type="hidden" name="name_{{$user->id}}" value="{{$user->name}}">
                        <input type="hidden" name="phone_{{$user->id}}" value="{{$user->phone}}">

                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->address}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->dis->credit_limit}}</td>
                    <td>{{$user->amount}}</td>
                    <td>{{_nepalidate($user->date)}}</td>
                    <td>
                        {{$user->dis->lastsms!=null?$user->dis->lastsms->diffForhumans():"N/A"}}
                    </td>
                    {{-- <td>
                        <form action="{{route('admin.sms.distributer.credit')}}" method="POST">
                            @csrf 
                            <input type="hidden" name="ids[]" value="{{$user->id}}">
                            <input type="hidden" name="credit_{{$user->id}}" value="{{$user->amount}}">
                            <button class="btn btn-sucess">Send Sms</button>
                        </form>
                    </td> --}}
                </tr>
            @endforeach
        </table>
        <div class="py-2">
            <button class="btn btn-sucess">Send Sms</button>
        </div>
    </form>
</div>
@endsection
@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
<script>
    function selectChange(ele){
        $('.selectable').each(function(){
            this.checked=ele.checked;
        });
    }

    function check(){
        eles=document.querySelectorAll('.selectable');
        for (let index = 0; index < eles.length; index++) {
            const element = eles[index];
            if(element.checked){
                return true;
            }
        }
        alert('Please Select At least One Distributer');
        return false;
    }
</script>
@endsection
