<?php
global $dbh;
session_start();
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_POST['cont'])) {
        $titre = $_POST['cont'];
        $id = $_POST['edit'];

        if ($_POST['vbtn-radio'] == 'off') {
            $button = 0;
        } else {
            $button = 1;
        }

        $sql = "UPDATE tblauthors SET AuthorName = '$titre', Status = '$button' WHERE id = '$id'";
        $query = $dbh->query($sql);
    }

    $sql = "SELECT id, AuthorName, Status, CreationDate, UpdationDate FROM tblauthors";
    $query = $dbh->query($sql);

    $results = $query->fetchAll(PDO::FETCH_OBJ);
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliothèque en ligne | Gestion des auteurs</title>
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
                    <h3>GESTION DES AUTHORS</h3>
                </div>
                <hr>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Statut</th>
                <th scope="col">Cree le</th>
                <th scope="col">Mise à jour le</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($results as $result) : ?>
                <form method="POST" action="manage-authors.php" onsubmit="return getContent(<?php echo $result->id ?>)">
                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td onkeydown="preventDef(event)" contenteditable="true" id="titre<?php echo $result->id ?>"
                            class="content" type="radio"><?php echo $result->AuthorName; ?></td>
                        <td>
                            <?php if ($result->Status == 1) : ?>
                                <div class="btn-group-vertical" role="group"
                                     aria-label="Vertical radio toggle button group">
                                    <input type="radio" class="btn-check" name="vbtn-radio" value="on"
                                           id="vbtn-radio<?php echo $i; ?>" autocomplete="off" checked>
                                    <label class="btn btn-outline-success btn-sm"
                                           for="vbtn-radio<?php echo $i; ?>">Active</label>
                                    <input type="radio" class="btn-check" name="vbtn-radio" value="off"
                                           id="vbtn-radio<?php echo $i + 300; ?>" autocomplete="off">
                                    <label class="btn btn-outline-danger btn-sm"
                                           for="vbtn-radio<?php echo $i + 300; ?>">Inactive</label>
                                </div>
                            <?php else : ?>
                                <div class="btn-group-vertical" role="group"
                                     aria-label="Vertical radio toggle button group">
                                    <input type="radio" class="btn-check" name="vbtn-radio" value="on"
                                           id="vbtn-radio<?php echo $i; ?>" autocomplete="off">
                                    <label class="btn btn-outline-success btn-sm"
                                           for="vbtn-radio<?php echo $i; ?>">Active</label>
                                    <input type="radio" class="btn-check" name="vbtn-radio" value="off"
                                           id="vbtn-radio<?php echo $i + 300; ?>" autocomplete="off" checked>
                                    <label class="btn btn-outline-danger btn-sm"
                                           for="vbtn-radio<?php echo $i + 300; ?>">Inactive</label>
                                </div>
                            <?php endif ?>
                        </td>
                        <td><?php echo $result->CreationDate; ?></td>
                        <td><?php echo $result->UpdationDate; ?></td>
                        <td>
                            <textarea name="cont" id="my-textarea<?php echo $result->id ?>" style="display:none"></textarea>
                            <button type="submit" name="edit" value="<?php echo $result->id ?>"
                                    class="btn btn-primary btn-sm">
                                Editer
                            </button>
                        </td>
                    </tr>
                </form>

                <?php $i++; endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include('includes/footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    </body>

    </html>
<?php } ?>