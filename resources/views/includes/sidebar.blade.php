<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{$siteSettings->logo}}" alt="{{$siteSettings->company_name}} Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{$siteSettings->company_name}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{Auth::user()->avatar}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->full_name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('albums.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-images"></i>
                        <p>
                            Albums
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('galleries.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-file-image"></i>
                        <p>
                            Galleries
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('services.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-camera-retro"></i>
                        <p>
                            Services
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{route('about.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-address-card"></i>
                        <p>
                            About Information
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('contact.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-address-book"></i>
                        <p>
                            Contact Information
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{route('reviews.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-comment"></i>
                        <p>
                            Reviews
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('pricing_plans.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-dollar-sign"></i>
                        <p>
                            Pricing Plans
                        </p>
                    </a>
                </li>

{{--                <li class="nav-item">--}}
{{--                    <a href="#" class="nav-link">--}}
{{--                        <i class="nav-icon fa fa-envelope-square"></i>--}}

{{--                        <p>--}}
{{--                            Messages--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="#" class="nav-link">--}}
{{--                        <i class="nav-icon fa fa-user-cog"></i>--}}
{{--                        <p>--}}
{{--                            Admins--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}

                <li class="nav-item">
                    <a href="{{route('slider_images.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-image"></i>
                        <p>
                            Slider Images
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('site_settings.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            Site Settings
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
