@extends('admin.layouts.app')
@section('title','Report')
@section('css')

@endsection
@section('head-title','Report')
@section('toobar')

@endsection
@section('content')
<div class="row">
    <div class="col-md-2 section href" data-target="{{route('report.farmer')}}">
        <span class="icon">
            <i class="zmdi zmdi-accounts"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
            Farmer Report
        </span>
    </div>
    <div class="col-md-2 section href" data-target="{{route('report.milk')}}">
        <span class="icon">
            <i class="zmdi zmdi-view-agenda"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
            Milk Report
        </span>
    </div>
    <div class="col-md-2 section href" data-target="{{route('report.sales')}}">
        <span class="icon">
            <i class="zmdi zmdi-money-box"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
            Sales Report
        </span>
    </div>
    @if (env('tierlevel',1)==1)
    <div class="col-md-2 section href" data-target="{{route('report.pos.sales')}}">
        <span class="icon">
            <i class="zmdi zmdi-money-box"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
           POS Sales Report
        </span>
    </div>
    @endif

    <div class="col-md-2 section href" data-target="{{route('report.dis')}}">
        <span class="icon">
            <i class="zmdi zmdi-truck"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
            Distributor
            <br>
            Report
        </span>
    </div>
    <div class="col-md-2 section href" data-target="{{route('report.emp')}}">
        <span class="icon">
            <i class="zmdi zmdi-truck"></i>
        </span>
        <span class="divider"></span>
        <span class="text">
            Employee <br> Report
        </span>
    </div>
    <div class="col-md-2 section href" data-target="{{route('report.credit')}}">
        <span class="icon">
            <i class="zmdi zmdi-money-off"></i>

        </span>
        <span class="divider"></span>
        <span class="text">
            Credit <br> Report
        </span>
    </div>

    <div class="col-md-2 section href" data-target="{{route('report.expense')}}">
        <span class="icon">
            <i class="zmdi zmdi-money-off"></i>

        </span>
        <span class="divider"></span>
        <span class="text">
            Expenses <br> Report
        </span>
    </div>
</div>
@endsection
@section('js')

@endsection
