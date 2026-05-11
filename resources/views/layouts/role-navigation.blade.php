@php
    $user = auth()->user();
    $role = $user?->role;

    $menu = match ($role) {
        'locataire' => [
            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'icon-speedometer'],
            ['label' => 'Paiement FedaPay', 'route' => 'paiements.fedapay.page', 'icon' => 'icon-credit-card'],
            ['label' => 'Mes paiements', 'route' => 'paiements.index', 'icon' => 'icon-wallet'],
            ['label' => 'Mon contrat', 'route' => 'contracts.index', 'icon' => 'icon-docs'],
            ['label' => 'Factures d eau', 'route' => 'consommations-eau.index', 'icon' => 'icon-drop'],
            ['label' => 'Messagerie', 'route' => 'chat.index', 'icon' => 'icon-bubbles'],
            ['label' => 'Profil', 'route' => 'profile.edit', 'icon' => 'icon-user'],
        ],
        'prestataire' => [
            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'icon-speedometer'],
            ['label' => 'Mes travaux', 'route' => 'travaux.index', 'icon' => 'icon-wrench'],
            ['label' => 'Messagerie', 'route' => 'chat.index', 'icon' => 'icon-bubbles'],
            ['label' => 'Profil', 'route' => 'profile.edit', 'icon' => 'icon-user'],
        ],
        default => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'icon-speedometer'],
            ['label' => 'Utilisateurs', 'route' => 'users.index', 'icon' => 'icon-people'],
            ['label' => 'Proprietes', 'route' => 'properties.index', 'icon' => 'icon-home'],
            ['label' => 'Paiements loyers', 'route' => 'payments.index', 'icon' => 'icon-wallet'],
            ['label' => 'Cautions', 'route' => 'cautions.index', 'icon' => 'icon-shield'],
            ['label' => 'Gestion eau', 'route' => 'consommations-eau.index', 'icon' => 'icon-drop'],
            ['label' => 'Travaux', 'route' => 'travaux.index', 'icon' => 'icon-wrench'],
            ['label' => 'Calendrier', 'route' => 'calendar.index', 'icon' => 'icon-calendar'],
            ['label' => 'Contrats', 'route' => 'contracts.index', 'icon' => 'icon-docs'],
            ['label' => 'Messagerie', 'route' => 'chat.index', 'icon' => 'icon-bubbles'],
            ['label' => 'Profil', 'route' => 'profile.edit', 'icon' => 'icon-user'],
        ],
    };
@endphp

<div class="wrapper role-layout-shell">
    <header class="main-header-top hidden-print">
        <a href="{{ route('dashboard') }}" class="logo">
            <img class="img-fluid able-logo" src="{{ asset('assets/images/loyer-logo.svg') }}" alt="Gestion Loyer">
        </a>

        <nav class="navbar navbar-static-top">
            <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>

            <ul class="top-nav lft-nav">
                <li class="pc-rheader-submenu">
                    <a href="{{ route('chat.index') }}" class="drop icon-circle" title="Messagerie">
                        <i class="icon-bubbles"></i>
                    </a>
                </li>
            </ul>

            <div class="navbar-custom-menu f-right">
                <ul class="top-nav">
                    <li class="pc-rheader-submenu">
                        <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                            <i class="icon-size-fullscreen"></i>
                        </a>
                    </li>

                    <li class="dropdown role-user-menu">
                        <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image role-user-toggle">
                            <span class="role-user-avatar-wrap">
                                <img class="img-circle role-user-avatar"
                                    src="{{ $user->photo_profil ? asset('storage/' . $user->photo_profil) : asset('assets/images/faces/default-avatar.jpg') }}"
                                    width="40" height="40" alt="Photo de profil">
                            </span>
                            <span class="role-user-name">{{ $user->nom }} <b>{{ $user->prenom }}</b> <i class="icofont icofont-simple-down"></i></span>
                        </a>
                        <ul class="dropdown-menu settings-menu">
                            <li><a href="{{ route('profile.edit') }}"><i class="icon-user"></i> Profil</a></li>
                            <li><a href="{{ route('chat.index') }}"><i class="icon-envelope-open"></i> Messagerie</a></li>
                            @if ($role === 'locataire')
                                <li><a href="{{ route('paiements.index') }}"><i class="icon-wallet"></i> Mes paiements</a></li>
                            @endif
                            <li class="p-0"><div class="dropdown-divider m-0"></div></li>
                            <li><a href="{{ route('logout') }}"><i class="icon-logout"></i> Deconnexion</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar hidden-print">
        <section class="sidebar role-sidebar" id="sidebar-scroll">
            <ul class="sidebar-menu">
                <li class="nav-level">Navigation</li>
                @foreach ($menu as $item)
                    <li class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <a class="waves-effect waves-dark" href="{{ route($item['route']) }}">
                            <i class="{{ $item['icon'] }}"></i><span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    </aside>
</div>

<style>
        .role-layout-shell .navbar-custom-menu .top-nav > li > a,
        .role-layout-shell .top-nav.lft-nav a {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .role-sidebar {
            overflow-y: auto;
            max-height: calc(100vh - 70px);
            padding-bottom: 16px;
            scrollbar-width: thin;
        }

        .role-sidebar .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: normal;
            min-height: 44px;
        }

        .role-sidebar .sidebar-menu li.active > a {
            background: #1f86ff;
            color: #fff;
            border-radius: 8px;
            margin: 4px 10px;
        }

        .role-sidebar .sidebar-menu li:not(.active) > a:hover {
            background: rgba(31, 134, 255, 0.08);
        }

        .settings-menu li a {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-user-menu {
            position: relative;
        }

        .role-user-toggle {
            width: auto !important;
            height: 50px;
            min-width: 0;
            max-width: 260px;
            overflow: visible;
            gap: 8px;
            padding: 0 14px;
            border-radius: 0;
            line-height: normal;
            white-space: nowrap;
        }

        .role-user-avatar-wrap {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            flex: 0 0 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .role-user-avatar {
            width: 36px !important;
            height: 36px !important;
            object-fit: cover;
            display: block;
        }

        .role-user-name {
            min-width: 0;
            max-width: 170px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
            line-height: 1.2;
        }

        .role-user-menu .settings-menu {
            right: 0;
            left: auto;
        }
</style>
