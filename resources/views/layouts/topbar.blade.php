<div class="wrapper">

    <!-- Navbar-->
    <header class="main-header-top hidden-print">
        <a href="{{ route('dashboard') }}" class="logo"><img class="img-fluid able-logo"
                src="{{ asset('assets/images/loyer-logo.svg') }}" alt="Gestion Loyer"></a>

        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>
            <ul class="top-nav lft-nav">
                {{-- <li>
                    <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        class="dropdown-toggle drop icon-circle drop-image">
                        <i class="ti-files"> </i><span> Files</span>
                    </a>
                </li> --}}
                {{-- <li class="dropdown">
                    <a href="{{ route('messages.index') }}" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                        <span>Messages </span><i class="fas fa-envelope me-1"></i>
                        @auth
                            <span class="badge bg-danger" id="nav-unread-count">
                                {{ auth()->user()->unread_messages_count }}
                            </span>
                        @endauth
                    </a>
                    <ul class="dropdown-menu settings-menu">
                        <li><a href="{{ route('messages.index') }}"><i class="fas fa-inbox"></i> Réception</a></li>
                        <li><a href="{{ route('messages.sent') }}"><i class="fas fa-share-square"></i> Envoyés</a></li>
                        <li><a href="{{ route('messages.unread.list') }}"><i class="fas fa-envelope-open-text"></i> Non
                                lus</a></li>
                        <li><a href="{{ route('messages.create') }}"><i class="fas fa-paper-plane"></i> Nouveau</a></li>

                    </ul>
                </li> --}}
                <li class="dropdown pc-rheader-submenu message-notification search-toggle">
                    {{-- <a href="#!" id="morphsearch-search" class="drop icon-circle txt-white">
                        <i class="ti-search"></i>
                    </a> --}}

                    {{-- <a href="{{ route('chat.index') }}"
                        class="nav-link position-relative d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">

                        <i class="fas fa-comments" style="font-size: 18px;"></i>

                        @if (auth()->user()->unread_messages_count > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 10px; padding: 6px 6px;">
                                {{ auth()->user()->unread_messages_count }}
                            </span>
                        @endif
                    </a> --}}
                </li>
            </ul>

            <!-- Navbar Right Menu-->
            <div class="navbar-custom-menu f-right">
                {{-- <div class="upgrade-button">
                    <a href="#" class="icon-circle txt-white btn btn-sm btn-primary upgrade-button">
                        <span>Upgrade To Pro</span>
                    </a>
                </div> --}}

                <ul class="top-nav">
                    <!--Notification Menu-->

                    {{-- <li class="dropdown notification-menu">
                        <a href="#!" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <i class="icon-bell"></i>
                            <span class="badge badge-danger header-badge">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="not-head">You have <b class="text-primary">4</b> new notifications.</li>
                            <li class="bell-notification">
                                <a href="javascript:;" class="media">
                                    <span class="media-left media-icon">
                                        <img class="img-circle" src="assets/images/avatar-1.png" alt="User Image">
                                    </span>
                                    <div class="media-body"><span class="block">Lisa sent you a mail</span><span
                                            class="text-muted block-time">2min ago</span></div>
                                </a>
                            </li>
                            <li class="bell-notification">
                                <a href="javascript:;" class="media">
                                    <span class="media-left media-icon">
                                        <img class="img-circle" src="assets/images/avatar-2.png" alt="User Image">
                                    </span>
                                    <div class="media-body"><span class="block">Server Not Working</span><span
                                            class="text-muted block-time">20min ago</span></div>
                                </a>
                            </li>
                            <li class="bell-notification">
                                <a href="javascript:;" class="media"><span class="media-left media-icon">
                                        <img class="img-circle" src="assets/images/avatar-3.png" alt="User Image">
                                    </span>
                                    <div class="media-body"><span class="block">Transaction xyz
                                            complete</span><span class="text-muted block-time">3 hours ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="not-footer">
                                <a href="#!">See all notifications.</a>
                            </li>
                        </ul>
                    </li> --}}
                    <!-- chat dropdown -->
                    <li class="pc-rheader-submenu ">
                        {{-- <a href="#!" class="drop icon-circle displayChatbox">
                            <i class="icon-bubbles"></i>
                            <span class="badge badge-danger header-badge">5</span>
                        </a> --}}

                    </li>

                    {{-- Mode sombre --}}
                    {{-- <li class="nav-item">
                        <div class="nav-link theme-toggle-container" style="cursor: pointer;">
                            <div class="theme-toggle-btn" id="themeToggle">
                                <i class="fas fa-moon theme-icon" id="themeIcon"></i>
                                <span class="theme-text d-none d-md-inline" id="themeText">Mode Sombre</span>
                            </div>
                        </div>
                    </li> --}}

                    {{-- <button class="theme-toggle" id="themeToggle">🌙</button> --}}





                    <!-- window screen -->
                    <li class="pc-rheader-submenu">
                        <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                            <i class="icon-size-fullscreen"></i>
                        </a>

                    </li>
                    <!-- User Menu-->
                    <li class="dropdown topbar-user-menu">
                        <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image topbar-user-toggle">
                            <span class="topbar-user-avatar-wrap"><img class="img-circle topbar-user-avatar"
                                    src="{{ Auth::user()->photo_profil
                                        ? asset('storage/' . Auth::user()->photo_profil)
                                        : asset('assets/images/faces/default-avatar.jpg') }}"
                                    width="40" height="40" alt="Photo de profil"></span>
                            <span class="topbar-user-name">{{ Auth::user()->nom }} <b>{{ Auth::user()->prenom }}</b> <i
                                    class=" icofont icofont-simple-down"></i></span>
                        </a>
                        <ul class="dropdown-menu settings-menu">
                            <li><a href="#!"><i class="icon-settings"></i> Settings</a></li>
                            <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                            <li><a href="#"><i class="icon-envelope-open"></i> My Messages</a></li>
                            <li class="p-0">
                                <div class="dropdown-divider m-0"></div>
                            </li>
                            <li><a href="#"><i class="icon-lock"></i> Lock Screen</a></li>
                            <li><a href="{{ route('logout') }}"><i class="icon-logout"></i> Logout</a></li>

                        </ul>
                    </li>
                </ul>

                <!-- search -->
                <div id="morphsearch" class="morphsearch">
                    <form class="morphsearch-form">

                        <input class="morphsearch-input" type="search" placeholder="Search..." />

                        <button class="morphsearch-submit" type="submit">Search</button>

                    </form>
                    <div class="morphsearch-content">
                        <div class="dummy-column">
                            <h2>People</h2>
                            <a class="dummy-media-object" href="#!">
                                <img class="round"
                                    src="http://0.gravatar.com/avatar/81b58502541f9445253f30497e53c280?s=50&d=identicon&r=G"
                                    alt="Sara Soueidan" />
                                <h3>Sara Soueidan</h3>
                            </a>

                            <a class="dummy-media-object" href="#!">
                                <img class="round"
                                    src="http://1.gravatar.com/avatar/9bc7250110c667cd35c0826059b81b75?s=50&d=identicon&r=G"
                                    alt="Shaun Dona" />
                                <h3>Shaun Dona</h3>
                            </a>
                        </div>
                        <div class="dummy-column">
                            <h2>Popular</h2>
                            <a class="dummy-media-object" href="#!">
                                <img src="assets/images/avatar-1.png" alt="PagePreloadingEffect" />
                                <h3>Page Preloading Effect</h3>
                            </a>

                            <a class="dummy-media-object" href="#!">
                                <img src="assets/images/avatar-1.png" alt="DraggableDualViewSlideshow" />
                                <h3>Draggable Dual-View Slideshow</h3>
                            </a>
                        </div>
                        <div class="dummy-column">
                            <h2>Recent</h2>
                            <a class="dummy-media-object" href="#!">
                                <img src="assets/images/avatar-1.png" alt="TooltipStylesInspiration" />
                                <h3>Tooltip Styles Inspiration</h3>
                            </a>
                            <a class="dummy-media-object" href="#!">
                                <img src="assets/images/avatar-1.png" alt="NotificationStyles" />
                                <h3>Notification Styles Inspiration</h3>
                            </a>
                        </div>
                    </div>
                    <!-- /morphsearch-content -->
                    <span class="morphsearch-close"><i class="icofont icofont-search-alt-1"></i></span>
                </div>
                <!-- search end -->
            </div>
        </nav>
    </header>
    <!-- Side-Nav-->
    <aside class="main-sidebar hidden-print ">
        <section class="sidebar" id="sidebar-scroll">
            <!-- Sidebar Menu-->
            <ul class="sidebar-menu">
                <li class="nav-level">--- Navigation</li>
                <li class="active treeview">
                    <a class="waves-effect waves-dark" href="{{ route('admin.dashboard') }}">
                        <i class="icon-speedometer"></i><span> Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('acceuil') }}">
                        <i class="fas fa-file-contract me-1"></i> Messagerie
                    </a>
                </li>

                <li class="">
                    <a href="{{ route('chat.index') }}"
                        class="nav-link position-relative d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">Messages

                        <i class="fas fa-comments" style="font-size: 18px;"></i>

                        @if (auth()->user()->unread_messages_count > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 10px; padding: 4px 6px;">
                                {{ auth()->user()->unread_messages_count }}
                            </span>
                        @endif
                    </a>


                </li>

                <li class="nav-level">--- Components</li>
                <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i
                            class="icon-briefcase"></i><span> Utilisateurs</span><i class="icon-arrow-down"></i></a>
                    <ul class="treeview-menu">
                        <li><a class="waves-effect waves-dark" href="{{ route('users.create') }}"><i
                                    class="icon-arrow-right"></i>
                                Création d'Utilisateurs</a></li>
                        <li><a class="waves-effect waves-dark" href="{{ route('users.index') }}"><i
                                    class="icon-arrow-right"></i>
                                Liste des Utilisateurs</a></li>
                        {{-- <li><a class="waves-effect waves-dark" href="{{ route('password.email') }}"><i
                                    class="icon-arrow-right"></i> Changement de mot de passe</a></li>
                        <li> --}}
                        {{-- <a href="{{ route('chat.index') }}"
                                class="nav-link position-relative d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">Messages

                                <i class="fas fa-comments" style="font-size: 18px;"></i>

                                @if (auth()->user()->unread_messages_count > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="font-size: 10px; padding: 4px 6px;">
                                        {{ auth()->user()->unread_messages_count }}
                                    </span>
                                @endif
                            </a> --}}
                </li>
                {{-- <li><a class="waves-effect waves-dark" href="box-shadow.html"><i
                                    class="icon-arrow-right"></i> Box Shadow</a></li> --}}
                <li><a class="waves-effect waves-dark" href="{{ route('profile.edit') }}"><i
                            class="icon-arrow-right"></i>
                        Profil</a></li>
                <li><a class="waves-effect waves-dark" href="light-box.html"><i class="icon-arrow-right"></i>
                        Light Box</a></li>
                <li><a class="waves-effect waves-dark" href="notification.html"><i class="icon-arrow-right"></i>
                        Notification</a></li>
                <li><a class="waves-effect waves-dark" href="panels-wells.html"><i class="icon-arrow-right"></i>
                        Panels-Wells</a></li>
                <li><a class="waves-effect waves-dark" href="tabs.html"><i class="icon-arrow-right"></i>
                        Tabs</a></li>
                <li><a class="waves-effect waves-dark" href="tooltips.html"><i class="icon-arrow-right"></i>
                        Tooltips</a></li>
                <li><a class="waves-effect waves-dark" href="typography.html"><i class="icon-arrow-right"></i>
                        Typography</a></li>
            </ul>
            </li>

            <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icon-chart"></i><span>
                        Propriétés</span><span class="label label-success menu-caption">New</span><i
                        class="icon-arrow-down"></i></a>
                <ul class="treeview-menu">
                    <li><a class="waves-effect waves-dark" href="{{ route('properties.create') }}"><i
                                class="icon-arrow-right"></i> Création de Propriétés</a></li>
                    <li><a class="waves-effect waves-dark" href="{{ route('properties.index') }}"><i
                                class="icon-arrow-right"></i> Liste des Propriétés</a></li>

                    {{-- <li><a class="waves-effect waves-dark" href="{{ route('cautions.create') }}"><i
                                    class="icon-arrow-right"></i> Paiement de caution</a></li> --}}
                </ul>
            </li>

            <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i
                        class="icon-book-open"></i><span> Paiements Loyers </span><i class="icon-arrow-down"></i></a>
                <ul class="treeview-menu">
                    <li><a class="waves-effect waves-dark" href="{{ route('payments.create') }}"><i
                                class="icon-arrow-right"></i> Nouveau paiement</a></li>

                    <li><a class="waves-effect waves-dark" href="{{ route('payments.index') }}"><i
                                class="icon-arrow-right"></i> Liste des paiements</a></li>

                    <li><a class="waves-effect waves-dark" href="{{ route('paiements.index') }}"><i
                                class="icon-arrow-right"></i> Paiements locataire</a></li>
                    <li><a class="waves-effect waves-dark" href="{{ route('paiements.fedapay.page') }}"><i
                                class="icon-arrow-right"></i> Paiements loyer en ligne</a></li>
                </ul>
            </li>

            <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i
                        class="icon-book-open"></i><span> Paiements Cautions </span><i
                        class="icon-arrow-down"></i></a>
                <ul class="treeview-menu">
                    <li><a class="waves-effect waves-dark" href="{{ route('cautions.create') }}"><i
                                class="icon-arrow-right"></i> Paiement de caution</a></li>

                    <li><a class="waves-effect waves-dark" href="{{ route('cautions.index') }}"><i
                                class="icon-arrow-right"></i> Liste de caution</a></li>
                </ul>
            </li>


            <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i
                        class="icon-book-open"></i><span> Gestion eau </span><i class="icon-arrow-down"></i></a>
                <ul class="treeview-menu">
                    <li><a class="waves-effect waves-dark" href="{{ route('consommations-eau.create') }}"><i
                                class="icon-arrow-right"></i> Enregistrement</a></li>

                    <li><a class="waves-effect waves-dark" href="{{ route('consommations-eau.index') }}"><i
                                class="icon-arrow-right"></i> Liste </a></li>
                </ul>
            </li>

            <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i
                        class="icon-book-open"></i><span> Travaux </span><i class="icon-arrow-down"></i></a>
                <ul class="treeview-menu">
                    <li><a class="waves-effect waves-dark" href="{{ route('travaux.create') }}"><i
                                class="icon-arrow-right"></i> Enregistrement</a></li>

                    <li><a class="waves-effect waves-dark" href="{{ route('travaux.index') }}"><i
                                class="icon-arrow-right"></i> Liste </a></li>
                </ul>
            </li>

            {{-- <li class="">
                    <a href="{{ route('chat.index') }}"
                        class="nav-link position-relative d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">Messages

                        <i class="fas fa-comments" style="font-size: 18px;"></i>

                        @if (auth()->user()->unread_messages_count > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 10px; padding: 4px 6px;">
                                {{ auth()->user()->unread_messages_count }}
                            </span>
                        @endif
                    </a>


                </li> --}}



            <li class="nav-item">
                <a class="nav-link" href="{{ route('calendar.index') }}">
                    <i class="fas fa-calendar-alt me-1"></i> Calendrier
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('contracts.index') }}">
                    <i class="fas fa-file-contract me-1"></i> Contrats
                </a>
            </li>

            {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('acceuil') }}">
                        <i class="fas fa-file-contract me-1"></i> Acceuil
                    </a>
                </li> --}}

            {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('travaux.create') }}">
                        <i class="fas fa-file-contract me-1"></i> Travaux
                    </a>
                </li> --}}

            {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('travaux.depenses.store') }}">
                        <i class="fas fa-file-contract me-1"></i>Enregistrement Travaux
                    </a>
                </li> --}}


            <li class="nav-level">--- More</li>

            <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i
                        class="icon-docs"></i><span>Pages</span><i class="icon-arrow-down"></i></a>
                <ul class="treeview-menu">
                    <li class="treeview"><a href="#!"><i class="icon-arrow-right"></i><span>
                                Authentication</span><i class="icon-arrow-down"></i></a>
                        <ul class="treeview-menu">
                            <li><a class="waves-effect waves-dark" href="register1.html" target="_blank"><i
                                        class="icon-arrow-right"></i> Register 1</a></li>

                            <li><a class="waves-effect waves-dark" href="login1.html" target="_blank"><i
                                        class="icon-arrow-right"></i><span> Login 1</span></a></li>
                            <li><a class="waves-effect waves-dark" href="forgot-password.html" target="_blank"><i
                                        class="icon-arrow-right"></i><span> Forgot
                                        Password</span></a></li>

                        </ul>
                    </li>

                    <li><a class="waves-effect waves-dark" href="404.html" target="_blank"><i
                                class="icon-arrow-right"></i> Error 404</a></li>
                    <li><a class="waves-effect waves-dark" href="sample-page.html"><i class="icon-arrow-right"></i>
                            Sample Page</a></li>

                </ul>
            </li>


            <li class="nav-level">--- Menu Level</li>

            <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i
                        class="icofont icofont-company"></i><span>Menu Level 1</span><i
                        class="icon-arrow-down"></i></a>
                <ul class="treeview-menu">
                    <li>
                        <a class="waves-effect waves-dark" href="#!">
                            <i class="icon-arrow-right"></i>
                            Level Two
                        </a>
                    </li>
                    <li class="treeview">
                        <a class="waves-effect waves-dark" href="#!">
                            <i class="icon-arrow-right"></i>
                            <span>Level Two</span>
                            <i class="icon-arrow-down"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a class="waves-effect waves-dark" href="#!">
                                    <i class="icon-arrow-right"></i>
                                    Level Three
                                </a>
                            </li>
                            <li>
                                <a class="waves-effect waves-dark" href="#!">
                                    <i class="icon-arrow-right"></i>
                                    <span>Level Three</span>
                                    <i class="icon-arrow-down"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a class="waves-effect waves-dark" href="#!">
                                            <i class="icon-arrow-right"></i>
                                            Level Four
                                        </a>
                                    </li>
                                    <li>
                                        <a class="waves-effect waves-dark" href="#!">
                                            <i class="icon-arrow-right"></i>
                                            Level Four
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            </ul>
        </section>

        {{-- <script>
            themeToggle.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                themeToggle.textContent = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';
            });
        </script> --}}
    </aside>

    <style>
        .topbar-user-menu {
            position: relative;
        }

        .main-header-top .top-nav > li.topbar-user-menu > a.topbar-user-toggle {
            width: auto !important;
            height: 50px;
            max-width: 260px;
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 8px;
            padding: 0 14px;
            border-radius: 0;
            line-height: normal;
            overflow: hidden;
            white-space: nowrap;
        }

        .topbar-user-avatar-wrap {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            flex: 0 0 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-user-avatar {
            width: 36px !important;
            height: 36px !important;
            object-fit: cover;
            display: block;
        }

        .topbar-user-name {
            min-width: 0;
            max-width: 170px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
            line-height: 1.2;
        }

        .topbar-user-menu .settings-menu {
            right: 0;
            left: auto;
        }
    </style>
