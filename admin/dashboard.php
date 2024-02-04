<?php
// On démarre (ou on récupère) la session courante
// On inclue le fichier de configuration et de connexion à la base de données
// Si l'utilisateur est déconnecté
// sinon on récupère les informations à afficher depuis la base de données
// On récupère le nombre de livres depuis la table tblbooks
// On récupère le nombre de livres en prêt depuis la table tblissuedbookdetails
// On récupère le nombre de livres retournés  depuis la table tblissuedbookdetails
// Ce sont les livres dont le statut est à 1
// On récupère le nombre de lecteurs dans la table tblreaders
// On récupère le nombre d'auteurs dans la table tblauthors
// On récupère le nombre de catégories dans la table tblcategory

global $dbh;
session_start();

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:../index.php');
} else {
    $sql = "SELECT (SELECT COUNT(*) FROM tblbooks) as table0Count,  
    (SELECT COUNT(*) FROM tblissuedbookdetails) as table1Count,
    (SELECT COUNT(*) FROM tblissuedbookdetails WHERE ReturnStatus = 1) as table2Count,
    (SELECT COUNT(*) FROM tblreaders) as table3Count,
    (SELECT COUNT(*) FROM tblauthors) as table4Count,
    (SELECT COUNT(*) FROM tblcategory) as table5Count";
    $query = $dbh->query($sql);
    $results = $query->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT BookName FROM tblbooks";
    $query = $dbh->query($sql);
    $results0 = $query->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT BookName, BookId FROM tblissuedbookdetails ti left outer JOIN tblbooks tb ON BookId = tb.id";
    $query = $dbh->query($sql);
    $results1 = $query->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT BookName, BookId FROM tblissuedbookdetails left outer JOIN tblbooks ON BookId = ISBNNumber WHERE ReturnStatus = 1";
    $query = $dbh->query($sql);
    $results2 = $query->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT FullName, EmailId FROM tblreaders";
    $query = $dbh->query($sql);
    $results3 = $query->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT AuthorName FROM tblauthors";
    $query = $dbh->query($sql);
    $results4 = $query->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT CategoryName FROM tblcategory";
    $query = $dbh->query($sql);
    $results5 = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <title>Gestion de bibliothèque en ligne | Tab bord administration</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet"/>
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet"/>
    </head>

    <body>
    <!--On inclue ici le menu de navigation includes/header.php-->
    <?php include('includes/header.php'); ?>
    <!-- On affiche le titre de la page : TABLEAU DE BORD ADMINISTRATION-->
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
                <div class="mb-3 mt-3">
                    <h3>TABLEAU DE BORD ADMINISTRATEUR</h3>
                </div>
                <hr>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nombreBooks-tab" data-bs-toggle="tab"
                                data-bs-target="#nombreBooks-tab-pane"
                                type="button" role="tab" aria-controls="nombreBooks-tab-pane" aria-selected="true">
                            Nombre de livres
                            <span class="badge bg-primary"><?php echo $results['table0Count']; ?></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="leasedBooks-tab" data-bs-toggle="tab"
                                data-bs-target="#leasedBooks-tab-pane"
                                type="button" role="tab" aria-controls="leasedBooks-tab-pane" aria-selected="true">
                            Livres en prêt
                            <span class="badge bg-secondary"><?php echo $results['table1Count']; ?></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="returnedBooks-tab" data-bs-toggle="tab"
                                data-bs-target="#returnedBooks-tab-pane"
                                type="button" role="tab" aria-controls="returnedBooks-tab-pane" aria-selected="true">
                            Livres retournes
                            <span class="badge bg-success"><?php echo $results['table2Count']; ?></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="readers-tab" data-bs-toggle="tab"
                                data-bs-target="#readers-tab-pane"
                                type="button" role="tab" aria-controls="readers-tab-pane" aria-selected="true">Lecteurs
                            <span class="badge bg-warning"><?php echo $results['table3Count']; ?></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="author-tab" data-bs-toggle="tab"
                                data-bs-target="#author-tab-pane"
                                type="button" role="tab" aria-controls="author-tab-pane" aria-selected="true">Auteurs
                            <span class="badge bg-info"><?php echo $results['table4Count']; ?></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="category-tab" data-bs-toggle="tab"
                                data-bs-target="#category-tab-pane"
                                type="button" role="tab" aria-controls="category-tab-pane" aria-selected="true">
                            Categories
                            <span class="badge bg-dark"><?php echo $results['table5Count']; ?></span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="tab-content ms-3" id="myTabContent">
                <div class="tab-pane fade show active" id="nombreBooks-tab-pane" role="tabpanel"
                     aria-labelledby="nombreBooks-tab"
                     tabindex="0">
                    <p></p>
                    <?php foreach ($results0 as $result) : ?>
                        <p class="h5"><?php
                            echo $result['BookName']; ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="tab-pane fade active" id="leasedBooks-tab-pane" role="tabpanel"
                     aria-labelledby="leasedBooks-tab"
                     tabindex="1">
                    <p></p>
                    <?php foreach ($results1 as $result) : ?>
                        <p class="h5"><?php if ($result['BookName'] != '') :
                                echo $result['BookName'];
                            else : echo "This book doesn't have a name. ISBN: " . $result['BookId']; endif ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="tab-pane fade active" id="returnedBooks-tab-pane" role="tabpanel"
                     aria-labelledby="returnedBooks-tab"
                     tabindex="2">
                    <p></p>
                    <?php foreach ($results2 as $result) : ?>
                        <p class="h5"><?php if ($result['BookName'] != '') :
                                echo $result['BookName'];
                            else : echo "This book doesn't have a name. ISBN: " . $result['BookId']; endif ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="tab-pane fade active" id="readers-tab-pane" role="tabpanel"
                     aria-labelledby="readers-tab"
                     tabindex="3">
                    <p></p>
                    <?php foreach ($results3 as $result) : ?>
                        <p class="h5"><?php echo 'Name: ' . $result['FullName']. '<br>'. 'Email: ' . $result['EmailId'] . '<br><br>';?></p>
                    <?php endforeach; ?>
                </div>
                <div class="tab-pane fade active" id="author-tab-pane" role="tabpanel"
                     aria-labelledby="author-tab"
                     tabindex="4">
                    <p></p>
                    <?php foreach ($results4 as $result) : ?>
                        <p class="h5"><?php echo 'Name: ' . $result['AuthorName']?></p>
                    <?php endforeach; ?>
                </div>
                <div class="tab-pane fade active" id="category-tab-pane" role="tabpanel"
                     aria-labelledby="category-tab"
                     tabindex="5">
                    <p></p>
                    <?php foreach ($results5 as $result) : ?>
                        <p class="h5"><?php echo $result['CategoryName']?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    </body>

    </html>
<?php } ?>