<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    @yield('styles')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body>

    <div class="main-wrapper">
        @include('layouts.toolbar')

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                @include('layouts.menu')
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            
                            <div class="page-sub-header">
                                <h3 class="page-title"><?= @$title ?></h3>
                                <!-- <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active">Admin</li>
                                </ul> -->
                            </div>
                        </div>
                    </div>
                </div>
                @if (session('success'))
                    <h1>{{ session('success') }}</h1>
                @endif
                @yield('content')

            </div>
            {{-- <footer>
                <p>Copyright © 2022 Dreamguys.</p>
            </footer> --}}
        </div>
    </div>
    @include('layouts.scripts')
    @yield('scripts')
</body>

</html>
