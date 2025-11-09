<!-- Navbar Start -->
<nav id="mainNavbar" class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0"
    style="top: 0; transition: top 0.3s;">
    <a href="#" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img src="/Guest/img/um.png" alt="UM Logo" style="height: 50px; margin-right: 10px;">
        <span class="fw-bold text-primary">Excellence in Learning Innovation</span>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
        <a href="{{ route(\App\Constants\Routes::routeSignin) }}" class="btn btn-primary py-4 px-lg-5">Join Now<i
                class="fa fa-arrow-right ms-3"></i></a>
    </div>
</nav>
<!-- Navbar End -->
