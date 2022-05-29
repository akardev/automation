<?php
require_once 'header.php';
require_once 'sidebar.php';
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div align="center">
                            <h2><b><i>Hesap bilgilerini düzenle</i></b></h2>
                        </div>
                    </div>
                    <div class="box-body">

                        <?php
                        if (isset($_POST['editaccount'])) {
                            $result = $db->update("account", $_POST, ["formName" => "editaccount", "columns" => "accId"]);

                            if ($result['status']) {   ?>
                                <div class="alert alert-success">
                                    <h4 align="center">Hesap bilgileri başarıyla güncellendi! <i class="icon fa fa-check"></i></h4>
                                </div>
                            <?php   } else {  ?>
                                <div class="alert alert-danger">
                                    <h4 align="center">Güncelleme hatası! <i class="icon fa fa-ban"></i>
                                        <?= "<hr>" . $result['error'] ?>
                                    </h4>
                                </div>
                        <?php  }
                        }

                        if (isset($_GET['accId'])) {
                            $sql = $db->wread("account", "accId", $_GET['accId']);
                            $row = $sql->fetch(PDO::FETCH_ASSOC);
                        }
                        ?>

                        <form method="POST">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Firma Adı</label>
                                <input type="text" value="<?= $row['accCompany'] ?>" class="form-control" name="accCompany" id="recipient-name">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Yetkili Adı Soyadı *</label>
                                <input type="text" value="<?= $row['accAuthorizedFullName'] ?>" class="form-control" name="accAuthorizedFullName" required id="recipient-name">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">E-Posta</label>
                                <input type="email" required value="<?= $row['accMail'] ?>" class="form-control" name="accMail" id="recipient-name">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Telefon Numarası</label>
                                <input type="text" required value="<?= $row['accPhone'] ?>" class="form-control" name="accPhone" id="recipient-name">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Vergi Dairesi</label>
                                <input type="text" value="<?= $row['accTaxOffice'] ?>" class="form-control" name="accTaxOffice" id="recipient-name">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Vergi Numarası</label>
                                <input type="text" value="<?= $row['accTaxNumber'] ?>" class="form-control" name="accTaxNumber" id="recipient-name">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">IBAN</label>
                                <input type="text" required value="<?= $row['accIban'] ?>" class="form-control" name="accIban" id="recipient-name">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Adres</label>
                                <textarea name="accAddress" required class="form-control"><?= $row['accAddress'] ?></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">

                        <input type="hidden" name="accId" value="<?= $row['accId'] ?>">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.href='account'">Geri Dön</button>
                        <button type="submit" class="btn btn-success" name="editaccount">Güncelle</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>





<?php require_once 'footer.php'; ?>