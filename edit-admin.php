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
              <h2><b><i>Yönetici bilgilerini düzenle</i></b></h2>
            </div>
          </div>
          <div class="box-body">

            <?php

            if (isset($_POST['editadmin'])) {
              $result = $db->update(
                "admin",
                $_POST,
                [
                  "formName" => "editadmin",
                  "columns" => "adminId",
                  "dir" => "admin",
                  "fileName" => "adminFile",
                  "fileDelete" => "oldPhoto"
                ]
              );

              if ($result['status']) {   ?>
                <div class="alert alert-success">
                  <h4 align="center">Başarıyla Güncellendi! <i class="icon fa fa-check"></i></h4>
                </div>
              <?php   } else {  ?>
                <div class="alert alert-danger">
                  <h4 align="center">Güncelleme hatası! <i class="icon fa fa-ban"></i>
                    <?= "<hr>" . $result['error'] ?>
                  </h4>
                </div>
            <?php  }
            }

            if (isset($_GET['adminId'])) {
              $sql = $db->wread("admin", "adminId", $_GET['adminId']);
              $row = $sql->fetch(PDO::FETCH_ASSOC);
            }

            ?>

            <form method="POST" enctype="multipart/form-data">
              <div class="row">
                <div align="center">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">
                        <!-- current photo -->
                      </label>
                      <img width="200" class="img-circle" src="dimg/admin/<?= $row['adminFile'] ?>" alt="">
                    </div>

                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label" style="border: 2px solid #ccc;  display: inline-block; padding: 6px 12px; cursor: pointer;">
                        Değiştir
                      </label>
                      <input style=" display: none;" type="file" class="form-control" name="adminFile" id="recipient-name">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Ad</label>
                    <input type="text" class="form-control" name="adminName" value="<?= $row['adminName'] ?>" required id="recipient-name">
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Soyad</label>
                    <input type="text" class="form-control" name="adminSurname" value="<?= $row['adminSurname'] ?>" required id="recipient-name">
                  </div>

                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Kullanıcı Adı</label>
                    <input type="text" class="form-control" name="adminUsername" value="<?= $row['adminUsername'] ?>" required id="recipient-name">
                  </div>

                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Durum</label>
                    <select class="form-control" name="adminStatus">
                      <option <?= $row['adminStatus'] == 1 ? 'selected' : '' ?> value="1">Aktif</option>
                      <option <?= $row['adminStatus'] == 0 ? 'selected' : '' ?> value="0">Pasif</option>
                    </select>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">

            <input type="hidden" name="adminId" value="<?= $row['adminId'] ?>">
            <input type="hidden" name="oldPhoto" value="<?= $row['adminFile'] ?>">

            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.href='admin'">Geri Dön</button>
            <button type="submit" class="btn btn-success" name="editadmin">Güncelle</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>





<?php require_once 'footer.php'; ?>