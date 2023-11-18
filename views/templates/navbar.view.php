<nav class="container navbar navbar-expand-lg navbar-light">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <a class="navbar-brand mt-2 mt-lg-0 mx-auto row d-flex" href="<?= BASEURL ?>/">
            <strong class='navbar-title col'>
                <?= WEB_TITLE ?>
            </strong>
        </a>
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span>&#9776;</span>
        </button>
        <!-- Toggle button -->
        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left links -->
            <ul class="navbar-nav me-auto ms-lg-5 mb-2 mb-lg-0 w-100">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL ?>/Transaksi/">Transaksi</a>
                </li>
            </ul>
            <!-- Left links -->
        </div>
        <!-- Right elements -->
        <div class="d-flex align-items-center">
            <a class="nav-link" href="<?= BASEURL ?>/Logout/">Logout</a>
        </div>
        <!-- Right elements -->
    </div>
</nav>