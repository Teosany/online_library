<?php
global $dbh;
session_start();
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_POST['edit']) || isset($_POST['return'])) {
        if (isset($_POST['return'])) {
            $return = 1;
            $id = $_POST['return'];
        } else {
            $return = 0;
            $id = $_POST['edit'];
        }


        $sql = "UPDATE tblissuedbookdetails SET ReaderID = ?, BookId = ?, ReturnStatus = '$return' WHERE id = '$id'";
        $query = $dbh->prepare($sql);

        $tab = array(
            $_POST['name'],
            $_POST['isbn'],
        );

        $query->execute($tab);

        succesOrNot();
        header('location:manage-issued-books.php');
    }
    $sql = "SELECT ti.id, tr.id AS trid, tb.id AS tbid, FullName, BookName, ISBNNumber, 
        IssuesDate, ReturnDate, ReturnStatus, BookId, ti.ReaderID 
        FROM tblissuedbookdetails ti 
        LEFT JOIN tblbooks tb ON BookId = tb.id
        LEFT JOIN tblreaders tr ON ti.ReaderID = tr.ReaderID";

    $query = $dbh->query($sql);
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    $sql1 = "SELECT FullName, id, ReaderId FROM tblreaders";
    $query1 = $dbh->query($sql1);
    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);

    $sql2 = "SELECT ISBNNumber, id FROM tblbooks";
    $query2 = $dbh->query($sql2);
    $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliothèque en ligne | Gestion des sorties</title>
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
                    <h3>GESTION DES SORTIES</h3>
                </div>
                <hr>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Sorties
            </div>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Lecteur</th>
                            <th scope="col">Titre</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Sortie le</th>
                            <th scope="col">Retourne le</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach ($results as $result) : ?>
                            <form method="POST" action="manage-issued-books.php"
                                  onsubmit="return getContent(<?php echo $result->id ?>)">
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td>
                                        <select name="name" id="inputState" class="form-select" required="required">
                                            <option value="<?php echo $result->ReaderID; ?>"
                                                    selected><?php echo $result->FullName; ?>
                                            </option>
                                            <?php foreach ($results1 as $result1) : if ($result->FullName !== $result1->FullName) : ?>
                                                <option value="<?php echo $result1->ReaderId; ?>"><?php echo $result1->FullName; ?></option>
                                            <?php endif; endforeach; ?>
                                        </select>
                                    </td>
                                    <td><?php echo $result->BookName; ?></td>
                                    <td>
                                        <select name="isbn" id="inputState" class="form-select" required="required">
                                            <option value="<?php echo $result->BookId; ?>"
                                                    selected><?php echo $result->ISBNNumber; ?>
                                            </option>
                                            <?php foreach ($results2 as $result2) : if ($result->ISBNNumber !== $result2->ISBNNumber) : ?>
                                                <option value="<?php echo $result2->id; ?>"><?php echo $result2->ISBNNumber; ?></option>
                                            <?php endif; endforeach; ?>
                                        </select>
                                    </td>
                                    <td><?php echo $result->IssuesDate; ?></td>
                                    <td><?php if ($result->ReturnStatus == 0): echo "Non retourne"; else : echo $result->ReturnDate; endif; ?></td>
                                    <td>
                                <textarea name="cont" id="my-textarea<?php echo $result->id ?>"
                                          style="display:none">
                                </textarea>
                                        <button type="submit" name="edit" value="<?php echo $result->id ?>"
                                                class="btn btn-primary btn-sm">
                                            Editer
                                        </button>
                                        <?php if ($result->ReturnStatus == 0) : ?>
                                            <button type="submit" name="return" value="<?php echo $result->id ?>"
                                                    class="btn btn-success btn-sm">
                                                Returner
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