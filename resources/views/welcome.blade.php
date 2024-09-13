<x-layout bodyClass="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-navbars.navs.guest signup='register' signin='login'></x-navbars.navs.guest>
            </div>
        </div>
    </div>
    <div class="page-header justify-content-center min-vh-100"
        style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <h1 class="text-light text-center">Welcome to Material Dashboard FREE Laravel Live Preview.</h1>
        </div>

    </div>
    <li class="nav-item d-flex justify-content-center align-items-center">
        <a class="nav-link me-2" href="{{ route('login') }}">
            <i class="fas fa-key opacity-6 text-dark me-1"></i>
            Sign In
        </a>
    </li>
    <x-footers.guest></x-footers.guest>
</x-layout>
