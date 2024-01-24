<?php if (isset($_SESSION['login'])) : ?>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">TABLEAU DE BORD</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my-profile.php">MON COMPTE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="issued-books.php">LIVRES EMPRUNTES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="change-password.php">CHANGER MON MOT DE PASSE</a>
                    </li>
                </ul>
            </div>
            <div class="right-div">
                <a href="logout.php" class="btn btn-danger pull-right">DECONNEXION</a>
            </div>
        </div>
    </nav>
<?php ; else : ?>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="adminlogin.php">ADMINISTRATION</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">CREER UN COMPTE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">LOGIN LECTEUR</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php endif ?>