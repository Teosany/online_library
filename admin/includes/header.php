<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a href="dashboard.php" class="nav-link">TABLEAU DE BORD</a></li>
                <li class="nav-item dropdown">
                    <a href="#" aria-expanded="false" class="nav-link dropdown-toggle" id="ddlmenuItem" role="button" data-bs-toggle="dropdown"> Categories</a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                        <li><a class="dropdown-item" href="add-category.php">Ajouter une catégorie</a></li>
                        <li><a class="dropdown-item" href="manage-categories.php">Gérer les catégories</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" aria-expanded="false" class="nav-link dropdown-toggle" id="ddlmenuItem" role="button" data-bs-toggle="dropdown"> Auteurs</a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                        <li><a class="dropdown-item" href="add-author.php">Ajouter un auteur</a></li>
                        <li><a class="dropdown-item" href="manage-authors.php">Gérer les auteurs</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" aria-expanded="false" class="nav-link dropdown-toggle" id="ddlmenuItem" role="button" data-bs-toggle="dropdown"> Livres</a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                        <li><a class="dropdown-item" href="add-book.php">Ajouter un livre</a></li>
                        <li><a class="dropdown-item" href="manage-books.php">Gérer les livres</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" aria-expanded="false" class="nav-link dropdown-toggle" id="ddlmenuItem" role="button" data-bs-toggle="dropdown"> Sorties</a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                        <li><a class="dropdown-item" href="add-issue-book.php">Ajouter une sortie</a></li>
                        <li><a class="dropdown-item" href="manage-issue-book.php">Gérer les sorties</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" aria-expanded="false" class="nav-link dropdown-toggle" id="ddlmenuItem" role="button" data-bs-toggle="dropdown"> Lecteurs</a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                        <li><a class="dropdown-item" href="add-category.php">Ajouter un lecteur</a></li>
                        <li><a class="dropdown-item" href="manage-categories.php">Gérer les lecteurs</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="reg-students.php">Lecteurs</a></li>
                <li class="nav-item"><a class="nav-link" href="change-password.php">Modifier le mot de passe</a></li>
            </ul>
        </div>
        <div class="right-div">
            <a href="logout.php" class="btn btn-danger pull-right">DECONNEXION</a>
        </div>
    </div>
</nav>