<nav class="navbar navbar-expand-lg navbar-dark gemah-bg-primary mb-3">
    <a class="navbar-brand" href="{{ route('web.index') }}">GEMAH</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse w-100 order-3 collapse" id="navbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('web.index') }}">
                    <i class="fas fa-home"></i> Acceuil
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#navbarTemp">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </li>
        </ul>
    </div>
</nav>