<?php
require_once 'header.php';
require_once 'sidebar.php';
?>

<div class="content-wrapper">
    <section class="content">

        <?php

        if (isset($_POST['addaccount'])) {
            $result = $db->insert("account", $_POST, ["formName" => "addaccount"]);

            if ($result['status']) {   ?>
                <div class="alert alert-success">
                    <h4 align="center">Hesap başarıyla eklendi! <i class="icon fa fa-check"></i></h4>
                </div>
            <?php   } else {  ?>
                <div class="alert alert-danger">
                    <h4 align="center">Hesap eklenemedi! <i class="icon fa fa-ban"></i>
                        <?= "<hr>" . $result['error'] ?>
                    </h4>
                </div>
        <?php }
        }


        if (isset($_GET['deleteaccount'])) {
            $result = $db->delete("account", "accId", $_GET['accId']);
        }

        ?>

        <div class="box">
            <div class="box-header">
                <h2 class="box-title"><b><i> Hesaplar </i></b></h2>
                <div align="center">
                    <button" class="btn btn-primary" data-toggle="modal" data-target="#addaccount" type="submit">Yeni hesap ekle</button>
                </div>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th width="5">#</th>

                            <th>Firma Adı</th>
                            <th>Yetkili Kişi</th>
                            <th>E-Posta</th>
                            <th>Telefon Numarası</th>
                            <th>Vergi Dairesi</th>
                            <th>Vergi Numarası</th>
                            <th>IBAN</th>
                            <th>Adres</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $sql = $db->read("account", [
                            "columnsName" => "accId",
                            "columnsSort" => "DESC"
                        ]);
                        $count = 1;
                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>

                            <tr>
                                <td><?= $count++ ?></td>

                                <td><?= $row['accCompany'] ?></td>
                                <td><?= $row['accAuthorizedFullName']  ?></td>
                                <td><?= $row['accMail'] ?></td>
                                <td><?= $row['accPhone']  ?></td>
                                <td><?= $row['accTaxOffice'] ?></td>
                                <td><?= $row['accTaxNumber']  ?></td>
                                <td><?= $row['accIban'] ?></td>
                                <td><?= $row['accAddress']  ?></td>


                                <td><a href="account-details?accId=<?= $row['accId'] ?>"><button class="btn btn-warning btn-xs text-black">Hesap Detayı</button></a></td>
                                <td width="5"><a title="Düzenle" class="btn btn-primary btn-xs" href="edit-account?accId=<?= $row['accId'] ?>"><i class="fa fa-edit"></i></a></td>
                                <td width="5"><a title="Sil" class="btn btn-primary btn-xs" href="?deleteaccount=true&accId=<?= $row['accId'] ?>"><i class="fa fa-trash"></i></a></td>
                            </tr>

                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
</div>


<!-- Add account Modal Start -->
<div class="modal fade" id="addaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 align="center" class="modal-title" id="exampleModalLabel"><b>Yeni hesap ekle</b> </h3>
            </div>
            <div class="modal-body">
                <form method="POST">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Firma Adı</label>
                        <input type="text" class="form-control" name="accCompany" id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Yetkili Adı Soyadı *</label>
                        <input type="text" class="form-control" name="accAuthorizedFullName" required id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">E-Posta</label>
                        <input type="email" class="form-control" name="accMail" required id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Telefon Numarası</label>
                        <input type="text" class="form-control" name="accPhone" required id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Vergi Dairesi</label>
                        <input type="text" class="form-control" name="accTaxOffice" id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Vergi Numarası</label>
                        <input type="text" class="form-control" name="accTaxNumber" id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">IBAN</label>
                        <input type="text" class="form-control" name="accIban" required id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Adres</label>
                        <textarea name="accAddress" required class="form-control"></textarea>
                    </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-success" name="addaccount">Ekle</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once 'footer.php'; ?>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>