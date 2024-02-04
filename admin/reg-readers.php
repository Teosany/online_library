<?php
global $dbh;
session_start();
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_POST['active']) || isset($_POST['inactive']) || isset($_POST['del'])) {
        if (isset($_POST['active'])) {
            $status = 1;
            $id = $_POST['active'];
        } elseif ($_POST['inactive']) {
            $status = 0;
            $id = $_POST['inactive'];
        } else {
            $status = 2;
            $id = $_POST['del'];
        }

        $sql = "UPDATE tblreaders SET Status = ? WHERE id = ?";
        $query = $dbh->prepare($sql);
        $query->execute([$status, $id]);

        succesOrNot();
        header('location:reg-readers.php');
    }
    $sql = "SELECT ReaderId, FullName, EmailId, MobileNumber, RegDate, Status, id 
            FROM tblreaders ORDER BY CASE 
            WHEN Status = 1 THEN 0 
            WHEN Status = 0 THEN 1 
            WHEN Status = 2 THEN 3 
            END";

    $query = $dbh->query($sql);
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliothèque en ligne | Gestion du registre des lecteurs</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet"/>
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet"/>
    </head>

    <body class="d-flex flex-column min-vh-100">
    <?php include('includes/header.php'); ?>
    <div id="succes" class="alert alert-success d-none" role="alert">Succes!</div>
    <div id="insucces" class="alert alert-danger d-none" role="alert">Insucces!</div>
    <div class="container">
        <div class="row">
            <div class="col-xs-14 col-sm-7 col-md-7 col-lg-7 offset-md-3">
                <div class="mb-3 mt-3">
                    <h3>GESTION DU REGISTRE DES LECTEURS</h3>
                </div>
                <hr>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Registre lecteurs
            </div>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table class="table table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID Lecteurs</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Portable</th>
                            <th scope="col">Date de reg</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach ($results as $result) : ?>
                            <form method="POST" action="reg-readers.php">
                                <?php if ($result->Status == 2): ?>
                                <tr class="table-danger"> <?php
                                    elseif ($result->Status == 1) : ?>
                                <tr class="table-success"> <?php
                                    else : ?>
                                <tr class="table-warning"> <?php
                                    endif; ?>
                                    <th class="table-light" scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $result->ReaderId; ?></td>
                                    <td><?php echo $result->FullName; ?></td>
                                    <td><?php echo $result->EmailId; ?></td>
                                    <td><?php echo $result->MobileNumber; ?></td>
                                    <td><?php echo $result->RegDate; ?></td>
                                    <?php if ($result->Status == 2): ?>
                                    <td> <?php echo "Supprimé(e)";
                                        elseif ($result->Status == 1) : ?>
                                    <td> <?php echo 'Actif';
                                        else : ?>
                                    <td> <?php echo 'Bloqué(e)';
                                        endif; ?></td>
                                    <td>
                                        <?php if ($result->Status == 1) : ?>
                                            <button type="submit" name="inactive" value="<?php echo $result->id ?>"
                                                    class="btn btn-warning btn-sm">
                                                Inactif
                                            </button>
                                        <?php elseif ($result->Status == 0) : ?>
                                            <button type="submit" name="active" value="<?php echo $result->id ?>"
                                                    class="btn btn-primary btn-sm">
                                                &nbspActif &nbsp
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($result->Status == 0 || $result->Status == 1) : ?>
                                            <button type="submit" name="del" value="<?php echo $result->id ?>"
                                                    class="btn btn-danger btn-sm">
                                                Supprimer
                                            </button>
                                        <?php endif; ?>
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