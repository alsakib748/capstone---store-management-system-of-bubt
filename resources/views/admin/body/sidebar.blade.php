<style>
    .user-info-box {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 10px;
    }

    .user-info-box h6 {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
    }

    .user-info-box .avatar-xs {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 600;
    }

    [data-sidebar="dark"] .user-info-box {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        margin: 0 10px 15px 10px;
    }
</style>
<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="/dashboard" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="" height="24">
                    </span>
                </a>
                <a href="/dashboard" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="" height="48">
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

                <li class="menu-title">Module</li>

                @can('Brand::menu')
                    <li>
                        <a href="#sidebarAuth" data-bs-toggle="collapse">
                            <i data-feather="tag"></i>
                            <span> Brand Manage </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAuth">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('all.brand') }}" class="tp-link">All Brand</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Supplier::menu')
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
                @endcan


                @can('Product::menu')
                    <li>
                        <a href="#Product" data-bs-toggle="collapse">
                            <i data-feather="package"></i>
                            <span> Product Manage </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Product">
                            <ul class="nav-second-level">
                                @can('Category::menu')
                                    <li>
                                        <a href="{{ route('all.category') }}" class="tp-link">All Category</a>
                                    </li>
                                @endcan
                                @can('SubCategory::menu')
                                    <li>
                                        <a href="{{ route('all.subcategory') }}" class="tp-link">All Subcategory</a>
                                    </li>
                                @endcan
                                @can('Product::menu')
                                    <li>
                                        <a href="{{ route('all.product') }}" class="tp-link">All Product</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Damage Product::menu')
                    <li>
                        <a href="#DamageProduct" data-bs-toggle="collapse">
                            <i data-feather="alert-triangle"></i>
                            <span>Damage Product</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="DamageProduct">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('all.damage.product') }}" class="tp-link">All Damage Product</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Purchase::menu')
                    <li>
                        <a href="#Purchase" data-bs-toggle="collapse">
                            <i data-feather="shopping-cart"></i>
                            <span> Purchase Manage </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Purchase">
                            <ul class="nav-second-level">
                                @can('Purchase::menu')
                                    <li>
                                        <a href="{{ route('all.purchase') }}" class="tp-link">All Purchase</a>
                                    </li>
                                @endcan
                                @can('Purchase Return::menu')
                                    <li>
                                        <a href="{{ route('all.return.purchase') }}" class="tp-link">Purchase Return</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Requisition::menu')
                    <li>
                        <a href="#Requisition" data-bs-toggle="collapse">
                            <i data-feather="file-text"></i>
                            <span> Requisition Manage</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Requisition">
                            <ul class="nav-second-level">
                                @can('Requisition::my requisitions')
                                    <li>
                                        <a href="{{ route('my.requisition') }}" class="tp-link">My Requisitions</a>
                                    </li>
                                @endcan
                                @can('Requisition::all requisitions')
                                    <li>
                                        <a href="{{ route('all.requisition') }}" class="tp-link">All Requisitions</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Issue::menu')
                    <li>
                        <a href="#Issue" data-bs-toggle="collapse">
                            <i data-feather="send"></i>
                            <span> Issue Manage</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Issue">
                            <ul class="nav-second-level">
                                @can('Issue::my issues')
                                    <li>
                                        <a href="{{ route('my.issue') }}" class="tp-link">My Issues</a>
                                    </li>
                                @endcan
                                @can('Issue::all issues')
                                    <li>
                                        <a href="{{ route('all.issue') }}" class="tp-link">All Issues</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Issue Return::menu')
                    <li>
                        <a href="#IssueReturn" data-bs-toggle="collapse">
                            <i data-feather="rotate-ccw"></i>
                            <span> Issue Return Manage</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="IssueReturn">
                            <ul class="nav-second-level">
                                @can('Issue Return::menu')
                                    <li>
                                        <a href="{{ route('all.issue.return') }}" class="tp-link">All Issue Return</a>
                                    </li>
                                @endcan
                                @can('Issue Return::add')
                                    <li>
                                        <a href="{{ route('add.issue.return') }}" class="tp-link">Add Issue Return</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Quotation::menu')
                    <li>
                        <a href="#Quotation" data-bs-toggle="collapse">
                            <i data-feather="file-text"></i>
                            <span> Quotation Manage</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Quotation">
                            <ul class="nav-second-level">
                                @can('Quotation::menu')
                                    <li>
                                        <a href="{{ route('all.quotation') }}" class="tp-link">All Quotation</a>
                                    </li>
                                @endcan
                                @can('Quotation::add')
                                    <li>
                                        <a href="{{ route('add.quotation') }}" class="tp-link">Add Quotation</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Report::menu')
                    <li>
                        <a href="#Report" data-bs-toggle="collapse">
                            <i data-feather="bar-chart-2"></i>
                            <span> Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Report">
                            <ul class="nav-second-level">
                                @can('Report::purchase report')
                                    <li>
                                        <a href="{{ route('purchase.report') }}" class="tp-link">Purchase Report </a>
                                    </li>
                                @endcan
                                @can('Report::damage product report')
                                    <li>
                                        <a href="{{ route('damage.product.report') }}" class="tp-link">Damage Product
                                            Report</a>
                                    </li>
                                @endcan
                                @can('Report::issue report')
                                    <li>
                                        <a href="{{ route('issue.report') }}" class="tp-link">Issue Report </a>
                                    </li>
                                @endcan
                                @can('Report::issue return report')
                                    <li>
                                        <a href="{{ route('issue.return.report') }}" class="tp-link">Issue Return Report </a>
                                    </li>
                                @endcan
                                @can('Report::stock report')
                                    <li>
                                        <a href="{{ route('stock.report') }}" class="tp-link">Stock Report </a>
                                    </li>
                                @endcan
                                @can('Report::fixed asset report')
                                    <li>
                                        <a href="{{ route('fixed.asset.report') }}" class="tp-link">Fixed Asset Report </a>
                                    </li>
                                @endcan
                                @can('Report::product trx report')
                                    <li>
                                        <a href="{{ route('product.trx.report') }}" class="tp-link">Product TRX Report </a>
                                    </li>
                                @endcan
                                @can('Report::product trx report')
                                    <li>
                                        <a href="{{ route('product.lifetime.report') }}" class="tp-link">Product Lifetime
                                            History </a>
                                    </li>
                                @endcan
                                @can('Report::all reports')
                                    <li>
                                        <a href="{{ route('all.report') }}" class="tp-link">All Reports </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Chat::menu')
                    <li class="menu-title mt-2">Chat</li>

                    <li>
                        <a href="{{ route('chatify') }}" class="tp-link">
                            <i data-feather="message-circle"></i>
                            <span> Chat </span>
                        </a>
                    </li>
                @endcan

                @can('Semester::menu')
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
                @endcan

                @can('Department::menu')
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
                @endcan

                @can('Role Permission::menu')
                    <li>
                        <a href="#role&permissions" data-bs-toggle="collapse">
                            <i data-feather="shield"></i>
                            <span> Role & Permission </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="role&permissions">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('all.permission') }}" class="tp-link">All Permission</a>
                                </li>
                                <li>
                                    <a href="{{ route('all.roles') }}" class="tp-link">All Roles</a>
                                </li>
                                <li>
                                    <a href="{{ route('add.roles.permission') }}" class="tp-link">Role In Permission</a>
                                </li>
                                <li>
                                    <a href="{{ route('all.roles.permission') }}" class="tp-link">All Role Permission</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('Manage User::menu')
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
                @endcan

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
