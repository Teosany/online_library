<?php
global $dbh;
session_start();

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:../index.php');
} else {
    $sql = "SELECT CategoryName, id, Status FROM tblcategory";
    $sql1 = "SELECT AuthorName, id, Status FROM tblauthors";

    $query = $dbh->query($sql);
    $query1 = $dbh->query($sql1);

    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
    if (TRUE === isset($_POST['add'])) {
        $sql = "INSERT INTO tblbooks (BookName, CatId, AuthorId, ISBNNumber, BookPrice) 
                VALUES (?, ?, ?, ?, ?)";
        $query = $dbh->prepare($sql);

        $tab = array(
            $_POST['name'],
            $_POST['cat'],
            $_POST['auteur'],
            $_POST['isbn'],
            $_POST['price'],
        );

        $query->execute($tab);

        succesOrNot();
        header('location:add-book.php');
    }
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliothèque en ligne | Ajout de livres</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/font-awesome.css" rel="stylesheet"/>
        <link href="assets/css/style.css" rel="stylesheet"/>
    </head>

    <body class="d-flex flex-column min-vh-100">
    <?php include('includes/header.php'); ?>
    <div id="succes" class="alert alert-success d-none" role="alert">Succes!</div>
    <div id="insucces" class="alert alert-danger d-none" role="alert">Insucces!</div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
                <div class="mb-3 mt-3">
                    <h3>AJOUTER UN LIVRE</h3>
                </div>
                <hr>
            </div>
        </div>
        <div class="card border-primary-subtle rounded-3">
            <h5 class="card-header text-primary-emphasis bg-primary-subtle">Information livre</h5>
            <div class="card-body">
                <form method="post" action="add-book.php">
                    <div class="mb-3">
                        <label for="inputText" class="form-label required">Titre</label>
                        <input type="text" class="form-control" name="name" id="inputText" aria-describedby="emailHelp"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="inputState" class="form-label required">Categorie</label>
                        <select name="cat" id="inputState" class="form-select" required="required">
                            <option value="" selected disabled>Choose...</option>
                            <?php foreach ($results as $result) : if ($result->Status === 1) : ?>
                                <option value="<?php echo $result->id; ?>"><?php
                                    echo $result->CategoryName; ?></option>
                            <?php endif; endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="inputState" class="form-label required">Auteur</label>
                        <select name="auteur" id="inputState" class="form-select" required="required">
                            <option value="" selected disabled>Choose...</option>
                            <?php foreach ($results1 as $result) : if ($result->Status === 1) : ?>
                                <option value="<?php echo $result->id; ?>"><?php echo $result->AuthorName; ?></option>
                            <?php endif; endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="inputText" class="form-label required">ISBN</label>
                        <input type="number" class="form-control" name="isbn" id="inputText"
                               aria-describedby="emailHelp"
                               required>
                        <div id="passwordHelpBlock" class="form-text">
                            Le numero ISBN doit etre unique
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputText" class="form-label required">Prix</label>
                        <input type="number" class="form-control" name="price" id="inputText"
                               aria-describedby="emailHelp" required>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>

    </div>
    <?php include('includes/footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    </body>

    </html>
    <?php verifSucces();
} ?>
