<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-gradient-white"
     id="sidenav-main">
    <div class="scrollbar-inner">
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand">
                <h3 class="my-auto">CAPS WEB</h3>
            </a>
            <div class="ml-auto">
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}" id="dashboard">
                            <i class="fas fa-home"></i>
                            <span class="nav-link-text">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inventories.index') }}" id="inventories">
                            <i class="fas fa-th"></i>
                            <span class="nav-link-text">
                                Inventories
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-transactions" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-products">
                            <i class="fas fa-dolly-flatbed"></i>
                            <span class="nav-link-text">Transactions</span>
                        </a>
                        <div class="collapse" id="navbar-transactions">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('product_sales.index') }}" class="nav-link">
                                        <span class="sidenav-mini-icon"> S </span>
                                        <span class="sidenav-normal"> Product Sales </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('product_orders.index') }}" class="nav-link">
                                        <span class="sidenav-mini-icon"> O </span>
                                        <span class="sidenav-normal"> Product Orders </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-products" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-products">
                            <i class="fas fa-box-open"></i>
                            <span class="nav-link-text">Product Management</span>
                        </a>
                        <div class="collapse" id="navbar-products">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('products.index') }}" class="nav-link">
                                        <span class="sidenav-mini-icon"> P </span>
                                        <span class="sidenav-normal"> Products </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('product_types.index') }}" class="nav-link">
                                        <span class="sidenav-mini-icon"> T </span>
                                        <span class="sidenav-normal"> Product Types </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('branches.index') }}" id="branch_management">
                            <i class="fas fa-warehouse"></i>
                            <span class="nav-link-text">
                                Branch Management
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('newsletter_subscriptions.index') }}" id="subscriptions">
                            <i class="far fa-newspaper"></i>
                            <span class="nav-link-text">
                                Newsletter Subscriptions
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.index') }}" id="reports">
                            <i class="fas fa-chart-area"></i>
                            <span class="nav-link-text">
                                Reports
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="nav-link-text">Logout</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
