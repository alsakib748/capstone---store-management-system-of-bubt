<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title> Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."/>
        <meta name="author" content="Zoyothemes"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico')}}">

        <!-- Datatables css -->
        <link href="{{ asset('backend/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="{{ asset('backend/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons -->
        <link href="{{ asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Responsive CSS -->
        <link href="{{ asset('backend/assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

    </head>

    <!-- body start -->
    <body data-menu-color="light" data-sidebar="default">

        <!-- Begin page -->
        <div id="app-layout">

            <!-- Sidebar Overlay (Mobile) -->
            <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

            <!-- Topbar Start -->
    @include('admin.body.header')
            <!-- end Topbar -->

            <!-- Left Sidebar Start -->
    @include('admin.body.sidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

    <div class="content-page">

     @yield('admin')

     <!-- content -->

                <!-- Footer Start -->
    @include('admin.body.footer')
                <!-- end Footer -->

            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Vendor -->
        <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{ asset('backend/assets/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
        <script src="{{ asset('backend/assets/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
        <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js')}}"></script>

        <!-- Apexcharts JS -->
        <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="{{ asset('backend/assets/js/code.js') }}"></script>
        <script src="{{ asset('backend/assets/js/custome.js') }}"></script>

        <script src="{{ asset('backend/assets/js/validate.min.js') }}"></script>
        <!-- App js-->
        <script src="{{ asset('backend/assets/js/app.js')}}"></script>

        <!-- Datatables js -->
        <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>

        <!-- dataTables.bootstrap5 -->
        <script src="{{ asset('backend/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
        <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>

         <!-- Datatable Demo App Js -->
         <script src="{{ asset('backend/assets/js/pages/datatable.init.js')}}"></script>


        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        {{-- Page specific scripts (runs after jQuery is loaded) --}}
        @stack('scripts')

        <script>
         @if(Session::has('message'))
         var type = "{{ Session::get('alert-type','info') }}"
         switch(type){
            case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

            case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

            case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

            case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
         }
         @endif
        </script>

        <!-- Global Select2 Initialization -->
        <script>
            $(document).ready(function() {
                $('.select2').each(function () {
                    var $el = $(this);
                    $el.select2({
                        allowClear: true,
                        placeholder: $el.data('placeholder') || 'Select an option',
                        width: '100%'
                    });
                });
            });
        </script>

        <!-- Sidebar Toggle for Mobile -->
        <script>
            function toggleSidebar() {
                var sidebar = document.querySelector('.app-sidebar');
                var overlay = document.querySelector('.sidebar-overlay');
                var body = document.body;

                if (sidebar && overlay) {
                    sidebar.classList.toggle('sidebar-enable');
                    overlay.classList.toggle('show');
                    body.classList.toggle('sidebar-open');
                }
            }

            // Mobile menu toggle button handler
            $(document).on('click', '.button-toggle-menu', function() {
                toggleSidebar();
            });

            // Close sidebar when pressing Escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    var sidebar = document.querySelector('.app-sidebar');
                    if (sidebar && sidebar.classList.contains('sidebar-enable')) {
                        toggleSidebar();
                    }
                }
            });

            // Close sidebar when clicking outside on mobile
            $(document).on('click', '.sidebar-overlay', function() {
                toggleSidebar();
            });
        </script>

        <!-- Grab to Scroll for Tables -->
        <script>
            (function() {
                function initGrabScroll() {
                    var containers = document.querySelectorAll('.table-responsive');

                    containers.forEach(function(container) {
                        // Prevent adding multiple listeners
                        if (container.dataset.grabScrollInit) return;
                        container.dataset.grabScrollInit = 'true';

                        var isDragging = false;
                        var startX;
                        var scrollLeft;
                        var containerRect;

                        // Mouse events (desktop)
                        container.addEventListener('mousedown', function(e) {
                            isDragging = true;
                            container.classList.add('grabbing');
                            startX = e.pageX - container.offsetLeft;
                            scrollLeft = container.scrollLeft;
                            containerRect = container.getBoundingClientRect();
                            container.style.cursor = 'grabbing';
                        });

                        container.addEventListener('mouseleave', function() {
                            isDragging = false;
                            container.classList.remove('grabbing');
                            container.style.cursor = 'grab';
                        });

                        container.addEventListener('mouseup', function() {
                            isDragging = false;
                            container.classList.remove('grabbing');
                            container.style.cursor = 'grab';
                        });

                        container.addEventListener('mousemove', function(e) {
                            if (!isDragging) return;
                            e.preventDefault();
                            var x = e.pageX - container.offsetLeft;
                            var walk = (x - startX) * 1.5; // Scroll speed
                            container.scrollLeft = scrollLeft - walk;
                        });

                        // Touch events (mobile/tablet)
                        container.addEventListener('touchstart', function(e) {
                            startX = e.touches[0].pageX - container.offsetLeft;
                            scrollLeft = container.scrollLeft;
                            containerRect = container.getBoundingClientRect();
                        }, { passive: true });

                        container.addEventListener('touchmove', function(e) {
                            var x = e.touches[0].pageX - container.offsetLeft;
                            var walk = (x - startX) * 1.5;
                            container.scrollLeft = scrollLeft - walk;
                        }, { passive: true });
                    });
                }

                // Initialize on DOM ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initGrabScroll);
                } else {
                    initGrabScroll();
                }

                // Re-initialize after DataTables reload
                $(document).on('draw.dt', function() {
                    initGrabScroll();
                });
            })();
        </script>

    </body>
</html>
