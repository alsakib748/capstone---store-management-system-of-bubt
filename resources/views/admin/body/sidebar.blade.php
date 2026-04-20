<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="" height="24">
                    </span>
                </a>
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>


                <li class="menu-title">Pages</li>

                {{-- @if (Auth::guard('web')->user()->can('brand.menu'))  --}}
                <li>
                    <a href="#sidebarAuth" data-bs-toggle="collapse">
                        <i data-feather="tag"></i>
                        <span> Brand Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAuth">
                        <ul class="nav-second-level">
                            {{-- @if (Auth::guard('web')->user()->can('all.brand')) --}}
                            <li>
                                <a href="{{ route('all.brand') }}" class="tp-link">All Brand</a>
                            </li>
                            {{-- @endif --}}

                        </ul>
                    </div>
                </li>
                {{-- @endif --}}

                {{-- @if (Auth::guard('web')->user()->can('warehouse.menu')) --}}

                {{-- <li>
                    <a href="#WareHouse" data-bs-toggle="collapse">
                        <i data-feather="archive"></i>
                        <span> WareHouse Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="WareHouse">
                        <ul class="nav-second-level"> --}}
                {{-- @if (Auth::guard('web')->user()->can('all.warehouse')) --}}
                {{-- <li>
                                <a href="{{ route('all.warehouse') }}" class="tp-link">All WareHouse</a>
                            </li> --}}
                {{-- @endif --}}

                {{-- </ul>
                    </div>
                </li> --}}

                {{-- @endif --}}

                {{-- @if (Auth::guard('web')->user()->can('supplier.menu')) --}}
                <li>
                    <a href="#Supplier" data-bs-toggle="collapse">
                        <i data-feather="truck"></i>
                        <span> Supplier Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Supplier">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.supplier') }}" class="tp-link">All Supplier</a>
                            </li>

                        </ul>
                    </div>
                </li>
                {{-- @endif --}}

                {{-- @if (Auth::guard('web')->user()->can('customer.menu')) --}}
                {{-- <li>
                    <a href="#Customer" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Customer Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Customer">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.customer') }}" class="tp-link">All Customer</a>
                            </li>

                        </ul>
                    </div>
                </li> --}}
                {{-- @endif --}}

                <li>
                    <a href="#Product" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> Product Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Product">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.category') }}" class="tp-link">All Category</a>
                            </li>

                            <li>
                                <a href="{{ route('all.subcategory') }}" class="tp-link">All Subcategory</a>
                            </li>

                            <li>
                                <a href="{{ route('all.product') }}" class="tp-link">All Product</a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#Purchase" data-bs-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Purchase Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Purchase">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.purchase') }}" class="tp-link">All Purchase</a>
                            </li>
                            <li>
                                <a href="{{ route('all.return.purchase') }}" class="tp-link">Purchase
                                    Return</a>
                            </li>

                        </ul>
                    </div>
                </li>

                {{-- <li>
                    <a href="#Transfers" data-bs-toggle="collapse">
                        <i data-feather="repeat"></i>
                        <span> Transfers Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Transfers">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.transfer') }}" class="tp-link">Transfers </a>
                            </li>


                        </ul>
                    </div>
                </li> --}}


                <li>
                    <a href="#Report" data-bs-toggle="collapse">
                        <i data-feather="bar-chart-2"></i>
                        <span> Reports </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Report">
                        <ul class="nav-second-level">

                            <li>
                                <a href="{{ route('purchase.report') }}" class="tp-link">Purchase Report </a>
                            </li>

                            <li>
                                <a href="{{ route('all.report') }}" class="tp-link">All Reports </a>
                            </li>

                        </ul>
                    </div>
                </li>




                <li class="menu-title mt-2">General</li>

                <li>
                    <a href="#Semester" data-bs-toggle="collapse">
                        <i data-feather="book-open"></i>
                        <span> Semester Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Semester">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.semester') }}" class="tp-link">All Semester</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#Department" data-bs-toggle="collapse">
                        <i data-feather="book"></i>
                        <span> Department Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Department">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.department') }}" class="tp-link">All Department</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#role&permissions" data-bs-toggle="collapse">
                        <i data-feather="shield"></i>
                        <span> Role & Permission </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="role&permissions">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.permission') }}" class="tp-link">All
                                    Permission</a>
                            </li>
                            <li>
                                <a href="{{ route('all.roles') }}" class="tp-link">All Roles</a>
                            </li>

                            <li>
                                <a href="{{ route('add.roles.permission') }}" class="tp-link">Role In
                                    Permission</a>
                            </li>
                            <li>
                                <a href="{{ route('all.roles.permission') }}" class="tp-link">All Role
                                    Permission</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#manageUser" data-bs-toggle="collapse">
                        <i data-feather="user-check"></i>
                        <span> Manage User </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="manageUser">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.admin') }}" class="tp-link">All User</a>
                            </li>

                        </ul>
                    </div>
                </li>

                {{-- <li>
                    <a href="#sidebarAdvancedUI" data-bs-toggle="collapse">
                        <i data-feather="layers"></i>
                        <span> Extended UI </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAdvancedUI">
                        <ul class="nav-second-level">
                            <li>
                                <a href="extended-carousel.html" class="tp-link">Carousel</a>
                            </li>
                            <li>
                                <a href="extended-notifications.html" class="tp-link">Notifications</a>
                            </li>

                        </ul>
                    </div>
                </li> --}}

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
