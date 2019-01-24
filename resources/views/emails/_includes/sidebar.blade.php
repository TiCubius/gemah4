<div class="sidebar-nav-fixed affix text-center h-100" id="sidebar">
    <a href="{{ route('gemah.index') }}">
        <div class="d-none d-lg-block">
            <img id="logo" src="{{ asset('assets/images/logo.png') }}">
        </div>
    </a>
    @yield('sidebar')
</div>