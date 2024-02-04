<?php
global $dbh;
session_start();

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_POST['add'])) {
        $name = strtoupper($_POST['name']);
        $isbn = $_POST['isbn'];

        $sql = "INSERT INTO tblissuedbookdetails (ReaderID, BookId, ReturnStatus) 
        SELECT '$name', id, '0' FROM tblbooks WHERE ISBNNumber = '$isbn'";
        $query = $dbh->query($sql);

        succesOrNot();
        header('location:add-issue-book.php');
    }
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliothèque en ligne | Ajout de sortie</title>
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
                    <h3>SORTIE D'UN LIVRE</h3>
                </div>
                <hr>
            </div>
        </div>
        <div class="card border-primary-subtle rounded-3">
            <h5 class="card-header text-primary-emphasis bg-primary-subtle">Sortie d'un livre</h5>
            <div class="card-body">
                <form method="post" action="add-issue-book.php">
                    <div class="mb-2">
                        <label for="inputText" class="form-label required">Identifiant lecteur</label>
                        <input type="text" class="form-control" name="name" id="inputText" aria-describedby="emailHelp"
                               required onkeyup="checkId(this.value)">
                    </div>
                    <div class="mb-4">
                        <div id="messageId" class="alert alert-primary d-none" role="alert"></div>
                    </div>
                    <div class="mb-2">
                        <label for="inputInt" class="form-label required">ISBN</label>
                        <input type="tel" class="form-control" name="isbn" id="inputInt"
                        required onkeyup="checkIsbn(this.value)">
                    </div>
                    <div class="mb-4">
                        <div id="messageIsbn" class="alert alert-primary d-none" role="alert">df</div>
                    </div>
                    <button id="button" type="submit" name="add" class="btn btn-primary" disabled>Creer la sortie</button>
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
}?>
