<header class="top-navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php?controller=home&action=index">
                <img src="assets/images/logo.png" alt="" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbars-rs-food">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=home&action=index">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=sach&action=index">Sách</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=detail&id=<?php echo $_SESSION['user']['id']?>">Tài khoản</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

