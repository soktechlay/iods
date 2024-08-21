<?php $current_page = basename($_SERVER['REQUEST_URI']); ?>
<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl h-100">
                <div class="row flex-fill align-items-center justify-content-between">
                    <div class="col d-flex align-items-center">
                        <ul class="navbar-nav">
                            <!-- Dashboard Menu Item -->
                            <li class="nav-item <?= ($current_page == 'dashboard') ? 'active' : '' ?>">
                                <a class="nav-link" href="/iods/dashboard">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Home</span>
                                </a>
                            </li>

                            <!-- Account Dropdown Menu -->
                            <li class="nav-item dropdown <?= ($current_page == 'account') ? 'active' : '' ?>">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 3l8 4.5v9l-8 4.5l-8-4.5v-9l8-4.5" />
                                            <path d="M12 12l8-4.5" />
                                            <path d="M12 12v9" />
                                            <path d="M12 12l-8-4.5" />
                                            <path d="M16 5.25l-8 4.5" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Account</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/iods/createuser">Manage Users Account</a></li>
                                    <li><a class="dropdown-item" href="./accordion.html">Manage Departments</a></li>
                                    <li><a class="dropdown-item" href="./blank.html">Manage Offices</a></li>
                                    <li>
                                        <a class="dropdown-item" href="./badges.html">
                                            Manage Positions
                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                        </a>
                                    </li>
                                    <li><a class="dropdown-item" href="./buttons.html">Role & Permissions</a></li>
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                            Role & Permission
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="./sign-in.html" class="dropdown-item">Role</a></li>
                                            <li><a href="./sign-in-link.html" class="dropdown-item">Permission</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- Form Elements Menu Item -->
                            <li class="nav-item <?= ($current_page == 'form-elements') ? 'active' : '' ?>">
                                <a class="nav-link" href="./form-elements.html">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 11l3 3l8-8" />
                                            <path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h9" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">Form elements</span>
                                </a>
                            </li>                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
