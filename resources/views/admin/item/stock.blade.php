@extends('admin.layouts.app')
@section('title','Items - Stock')
@section('head-title')
    <a href="{{route('admin.item')}}">Items</a> / {{$item->title}} / Center Stock
@endsection

@section('content')
    <div class="py-3">
        <form method="post" action="{{route('center-stock',['id'=>$item->id])}}">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    Collection Center
                </div>
                <div class="col-md-4">
                    Amount
                </div>
                <div class="col-md-4 d-none">
                    Rate
                </div>
            </div>
            @foreach ($centers as $center)
                @php
                    $stock=$item->stock($center->id);
                @endphp
            <hr>
                <div class="row">
                    <div class="col-md-4">
                        <b>
                            {{$center->name}}
                        </b>
                        <input type="hidden" name="center_ids[]" value="{{$center->id}}">
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" type="number" name="amount_{{$center->id}}" id="amount_{{$center->id}}" min="0" step="0.01" value="{{$stock==null?0:$stock->amount}}" required>
                    </div>
                    <div class="col-md-4 d-none">
                        <input class="form-control" type="number" name="rate_{{$center->id}}" id="rate_{{$center->id}}" min="0" step="0.01" value="{{$stock==null?$item->sell_price:$stock->rate}}" required>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-primary">Save Stock</button>
                </div>
            </div>
        </form>
    </div>
@endsection
