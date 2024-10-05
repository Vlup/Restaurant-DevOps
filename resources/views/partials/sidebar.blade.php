<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column px-4">
            <li class="nav-item mb-3">
                <a class="nav-link {{ Request::is('profile*') ? 'active' : '' }}" aria-current="page" href="/profile">
                    <span data-feather="user"></span>
                    Profile
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link {{ Request::is('/')? 'active' : '' }}" href="/">
                    <span data-feather="book-open"></span>
                    Menu
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link {{ Request::is('baskets') ? 'active' : '' }}" href="/baskets">
                    <span data-feather="shopping-cart"></span>
                    Keranjang
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link" href="/order">
                    <span data-feather="file-text"></span>
                    Pesanan
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link" href="/history">
                    <span data-feather="shopping-bag"></span>
                    History
                </a>
            </li>
        </ul>
    </div>
    <form action="/logout" method="post" class="px-4">
        @csrf
        <button type="submit" class="nav-link position-absolute absolute-bottom border-0"><span data-feather="log-out"></span> Logout</button>
    </form>
</nav>