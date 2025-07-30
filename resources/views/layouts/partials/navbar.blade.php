<!-- Navbar SAFIR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            SAFIR
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house"></i> Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="bi bi-info-circle"></i> À propos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">
                        <i class="bi bi-grid"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('encadreurs.*') ? 'active' : '' }}" href="{{ route('encadreurs.index') }}">
                        <i class="bi bi-people"></i> Encadreurs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">
                        <i class="bi bi-images"></i> Galerie
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="bi bi-envelope"></i> Contact
                    </a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Tableau de bord</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Administration</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>