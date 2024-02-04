<?php
global $dbh;
session_start();
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] === 'edit') {
            $sql = "UPDATE tblbooks SET Bookname = ?, CatId = ?, AuthorId = ?,
                    ISBNNumber = ?, BookPrice = ? WHERE id = ?";
            $query = $dbh->prepare($sql);

            $tab = array(
                $_POST['cont'],
                $_POST['cat'],
                $_POST['auteur'],
                $_POST['cont1'],
                $_POST['cont2'],
                $_POST['id'],
            );

            $query->execute($tab);
        } elseif ($_POST['submit'] === 'del') {
            error_log($_POST['submit']);
            $id = $_POST['id'];

            $sql = "DELETE FROM tblbooks WHERE id = :id";

            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
        }
        succesOrNot();
        header('location:manage-books.php');
    }


    $sql = "SELECT b.id, Bookname, CategoryName, CatId, AuthorId, AuthorName, ISBNNumber, BookPrice FROM tblbooks b 
    LEFT JOIN tblcategory c ON CatId = c.id
    LEFT JOIN tblauthors a ON AuthorId = a.id";

    $query = $dbh->query($sql);
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    $sql1 = "SELECT CategoryName, id, Status FROM tblcategory";
    $sql2 = "SELECT AuthorName, id, Status FROM tblauthors";

    $query1 = $dbh->query($sql1);
    $query2 = $dbh->query($sql2);

    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
    $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliothèque en ligne | Gestion livres</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet"/>
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet"/>
    </head>
    <!-- MENU SECTION END-->
    <!-- On affiche le titre de la page-->
    <!-- On prevoit ici une div pour l'affichage des erreurs ou du succes de l'operation de mise a jour ou de suppression d'une categorie-->
    <!-- On affiche le formulaire de gestion des categories-->
    <body class="d-flex flex-column min-vh-100">
    <?php include('includes/header.php'); ?>
    <div id="succes" class="alert alert-success d-none" role="alert">Succes!</div>
    <div id="insucces" class="alert alert-danger d-none" role="alert">Insucces!</div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
                <div class="mb-3 mt-3">
                    <h3>GESTION DES LIVRES</h3>
                </div>
                <hr>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Livres
            </div>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Catégorie</th>
                            <th scope="col">Nom de l'auteur</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach ($results as $result) : ?>
                            <form method="POST" action="manage-books.php"
                                  onsubmit="return getContent(<?php echo $result->id ?>)">
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td contenteditable="true" onkeydown="preventDef(event, 50)"
                                        id="titre<?php echo $result->id ?>"
                                        class="content" type="radio"><?php echo $result->Bookname; ?><i
                                                class="fa-regular fa-pen-to-square"></i></td>
                                    <td>
                                        <select name="cat" id="inputState" class="form-select" required="required">
                                            <option value="<?php echo $result->CatId; ?>"
                                                    selected><?php echo $result->CategoryName; ?>
                                            </option>
                                            <?php foreach ($results1 as $result1) : if ($result->CategoryName !== $result1->CategoryName && $result1->Status === 1) : ?>
                                                <option value="<?php echo $result1->id; ?>"><?php echo $result1->CategoryName; ?></option>
                                            <?php endif; endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="auteur" id="inputState" class="form-select" required="required">
                                            <option value="<?php echo $result->AuthorId; ?>"
                                                    selected><?php echo $result->AuthorName; ?>
                                            </option>
                                            <?php foreach ($results2 as $result2) : if ($result->AuthorName !== $result2->AuthorName && $result2->Status === 1) : ?>
                                                <option value="<?php echo $result2->id; ?>"><?php echo $result2->AuthorName; ?></option>
                                            <?php endif; endforeach; ?>
                                        </select>
                                    </td>
                                    <td onkeydown="preventDef(event, 17)" contenteditable="true"
                                        id="titre_1<?php echo $result->id ?>"
                                        class="content onlyInt" type="radio"> <?php echo $result->ISBNNumber; ?>
                                    </td>
                                    <td onkeydown="preventDef(event, 3)" contenteditable="true"
                                        id="titre_2<?php echo $result->id ?>"
                                        class="content onlyInt" type="radio"> <?php echo $result->BookPrice; ?>
                                    </td>
                                    <td>
                                    <textarea name="cont" id="my-textarea<?php echo $result->id ?>"
                                              style="display:none">
                                    </textarea>
                                        <textarea name="cont1" id="my-textarea_1<?php echo $result->id ?>"
                                                  style="display:none">
                                    </textarea>
                                        <textarea name="cont2" id="my-textarea_2<?php echo $result->id ?>"
                                                  style="display:none">
                                    </textarea>
                                        <textarea name="id"
                                                  style="display:none"><?php echo $result->id ?>
                                    </textarea>
                                        <button type="submit" name="submit" value="edit"
                                                class="btn btn-primary btn-sm">
                                            Editer
                                        </button>
                                        <button type="submit" name="submit" value="del"
                                                class="btn btn-danger btn-sm">
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            </form>
                            <?php $i++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
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
