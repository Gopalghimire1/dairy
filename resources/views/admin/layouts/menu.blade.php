<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="index.html"><img src="{{ asset('backend/images/logo.svg') }}" width="25" alt="Aero"><span class="m-l-10">Dairy Management</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="#"><img src="{{ asset('backend/images/user.png') }}" alt="User"></a>
                    <div class="detail">
                        <h4>{{ Auth::user()->name }}</h4>
                        @if(env('authphone','9852059717')==Auth::user()->phone)
                            <small>Super Admin</small>
                        @else
                            <small>Admin</small>
                        @endif
                    </div>
                </div>
            </li>
            {{-- helloooo --}}

            <li class="active open"><a href="{{ route('admin.dashboard')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-apps"></i><span>Farmer</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.farmer') }}" class="waves-effect waves-block">Farmer List</a></li>
                    <li><a href="{{ route('admin.farmer.advance') }}" class="waves-effect waves-block">Advance</a></li>
                    <li><a href="{{ route('admin.farmer.due') }}" class="waves-effect waves-block">Paid By Former</a></li>
                    <li><a href="{{ route('admin.farmer.due.add.list') }}" class="waves-effect waves-block">Previous Balance</a></li>
                    <li><a href="{{ route('milk.payment.home') }}" class="waves-effect waves-block">Milk Payment</a></li>
                </ul>
            </li>

            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Milk Collection</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.collection') }}" class="waves-effect waves-block">Manage Collection Center</a></li>
                    <li><a href="{{ route('admin.milk') }}" class="waves-effect waves-block"> Milk Collection</a></li>
                    <li><a href="{{ route('admin.snf.fat') }}" class="waves-effect waves-block">Add Fat & Snf</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Items</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.item') }}" class="waves-effect waves-block">Add Item</a></li>
                    <li><a href="{{ route('admin.sell.item') }}" class="waves-effect waves-block">Sell Items</a></li>
                </ul>
            </li>
            @if (env('tier',1)==1)
            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Distributers</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.dis') }}" class="waves-effect waves-block">Distributer List</a></li>
                    <li><a href="{{ route('admin.dis.sell') }}" class="waves-effect waves-block">Distributer Sell</a></li>
                    <li><a href="{{ route('admin.dis.payemnt') }}" class="waves-effect waves-block">payment</a></li>
                    <li><a href="{{ route('distributer.detail.opening') }}" class="waves-effect waves-block">Account Opening</a></li>
                    <li><a href="{{ route('admin.distri.request') }}" class="waves-effect waves-block">Distributor Request</a></li>
                    <li><a href="{{ url('admin/distributer/credit-list') }}" class="waves-effect waves-block">Credit SMS</a></li>

                </ul>
            </li>

            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Suppliers</span></a>
                <ul class="ml-menu">
                    {{-- <li><a href="{{ route('admin.supplier.index') }}" class="waves-effect waves-block">Supplier List</a></li>
                    <li><a href="{{ route('admin.sup.bill') }}" class="waves-effect waves-block">Supplier Bill</a></li>
                    <li><a href="{{ route('supplier.pay') }}" class="waves-effect waves-block">Supplier Payment</a></li>
                    <li><a href="{{ route('supplier.previous.balance') }}" class="waves-effect waves-block">Previous Blance</a></li> --}}
                    <li><a href="{{ route('admin.supplier.index') }}" class="waves-effect waves-block">Supplier List</a></li>
                    <li><a href="{{ route('admin.supplier.bill') }}" class="waves-effect waves-block">Supplier Bill</a></li>
                    <li><a href="{{ route('admin.supplier.pay') }}" class="waves-effect waves-block">Supplier Payment</a></li>
                    <li><a href="{{ route('admin.supplier.previous.balance') }}" class="waves-effect waves-block">Previous Blance</a></li>
                </ul>
            </li>



            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Staff Manage</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.employee.index') }}" class="waves-effect waves-block">Employees </a></li>
                    <li><a href="{{ route('admin.employee.account.index') }}" class="waves-effect waves-block">Account Opening</a></li>
                    <li><a href="{{ route('admin.employee.advance') }}" class="waves-effect waves-block">Advance</a></li>
                    <li><a href="{{ route('admin.salary.pay') }}" class="waves-effect waves-block">Salary Pay</a></li>
                </ul>
            </li>

            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Expense Manage</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.exp.category') }}" class="waves-effect waves-block"><span>Expense Categories</span></a></li>
                    <li><a href="{{ route('admin.exp') }}" class="waves-effect waves-block"><span>Expenses</span></a></li>
                </ul>
            </li>

            <li><a href="{{route('product.home')}}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Products</span></a></li>
            @endif

            @if(env('tierlevel',1)==1)
               <li><a href="{{route('purchase.home')}}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Purchase Product</span></a></li>
            @endif
            <li><a href="{{ route('report.home') }}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Report</span></a></li>
            <li><a href="{{ route('user.users') }}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Users</span></a></li>
            @if (env('tierlevel',1)==1)
            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Manufacture</span></a>
                <ul class="ml-menu">
                   <li><a href="{{ route('manufacture.index') }}" class="waves-effect waves-block"><span>Manufacture</span></a></li>
                   <li><a href="{{ route('manufacture.list') }}" class="waves-effect waves-block"><span>Manufactured List</span></a></li>
                </ul>
            </li>
            <li><a href="{{ url('admin/billing') }}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Billing</span></a></li>
            @endif
            @if(env('tier',1) == 1)
            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Home Page Setting</span></a>
                <ul class="ml-menu">
                   <li><a href="{{ route('setting.about') }}" class="waves-effect waves-block"><span>AboutUs</span></a></li>
                   <li><a href="{{ route('setting.sliders') }}" class="waves-effect waves-block"><span>Sliders</span></a></li>
                   <li><a href="{{ route('setting.gallery') }}" class="waves-effect waves-block"><span>Gallery</span></a></li>
                </ul>
            </li>
            @endif
            <li><a href="{{ route('logout') }}" class="waves-effect waves-block" target="_top"><i class="zmdi zmdi-power"></i><span>Sign Out</span></a></li>
        </ul>
    </div>
</aside>
