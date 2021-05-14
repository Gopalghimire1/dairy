@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
    <div class="row">
        <div class="col-md-2 section href" data-target="{{route('admin.farmer')}}">
            <span class="icon">
                <i class="zmdi zmdi-accounts"></i>
            </span>
            <span class="divider"></span>
            <span class="text">
                Farmers ({{ \App\Models\User::where('role',1)->count() }})
            </span>
        </div>

        <div class="col-md-2 section href" data-target="{{route('admin.farmer.advance')}}">
            <span class="icon">
                <i class="zmdi zmdi-money"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Farmer <br> Advance
            </span>
        </div>

        <div class="col-md-2 section href" data-target="{{route('admin.collection')}}">
            <span class="icon">
                <i class="zmdi zmdi-pin"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Collection <br> Center
            </span>
        </div>

        <div class="col-md-2 section href" data-target="{{route('admin.milk')}}">
            <span class="icon">
                <i class="zmdi zmdi-dns"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Milk <br> Collection
            </span>
        </div>

        <div class="col-md-2 section href" data-target="{{route('admin.snf.fat')}}">
            <span class="icon">
                <i class="zmdi zmdi-dns"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Snf & Fats
            </span>
        </div>

        <div class="col-md-2 section href" data-target="{{route('admin.item')}}">
            <span class="icon">
                <i class="zmdi zmdi-view-module"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Items
            </span>
        </div>

        <div class="col-md-2 section href" data-target="{{route('admin.sell.item')}}">
            <span class="icon">
                <i class="zmdi zmdi-view-compact"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Sell Item
            </span>
        </div>

        @if (env('tier',1)==1)
        <div class="col-md-2 section href" data-target="{{route('admin.exp')}}">
            <span class="icon">
                <i class="zmdi zmdi-balance-wallet"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Expenses
            </span>
        </div>

        <div class="col-md-2 section href" data-target="{{route('admin.exp')}}">
            <span class="icon">
                <i class="zmdi zmdi-accounts"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Suppliers ({{ \App\Models\User::where('role',3)->count() }})
            </span>
        </div>

        <div class="col-md-2 section href" data-target="{{route('admin.exp')}}">
            <span class="icon">
                <i class="zmdi zmdi-book"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Supplier <br> Bills
            </span>
        </div>
        @endif
        <div class="col-md-2 section href" data-target="{{route('report.home')}}">
            <span class="icon">
                <i class="zmdi zmdi-markunread-mailbox"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Reports
            </span>
        </div>

        <div class="col-md-2 section href" data-target="{{route('cash.flow.index')}}">
            <span class="icon">
                <i class="zmdi zmdi-money"></i>
            </span>
            <span class="divider"></span>
            <span class="text text-center">
                Cash <br> Flow
            </span>
        </div>
    </div>
@endsection
