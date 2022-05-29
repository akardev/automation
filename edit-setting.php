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
              <h3 class="box-title"><b><i>Edit Setting</i></b></h3>
            </div>
          </div>
          <div class="box-body">

            <?php

            if (isset($_POST['editsetting'])) {
              $result = $db->update(
                "setting",
                $_POST,
                [
                  "formName" => "editsetting",
                  "columns" => "setId",
                  "dir" => "setting",
                  "fileName" => "setValue",
                  "fileDelete" => "oldPhoto"
                ]
              );
              if ($result['status']) {   ?>
                <div class="alert alert-success">
                  <h4 align="center">Ayar başarıyla güncellendi! <i class="icon fa fa-check"></i></h4>
                </div>
              <?php   } else {  ?>
                <div class="alert alert-danger">
                  <h4 align="center">Güncelleme hatası! <i class="icon fa fa-ban"></i>
                    <?= "<hr>" . $result['error'] ?>
                  </h4>
                </div>
            <?php  }
            }

            if (isset($_GET['setId'])) {
              $sql = $db->wread("setting", "setId", $_GET['setId']);
              $row = $sql->fetch(PDO::FETCH_ASSOC);
            }


            ?>

            <form method="POST" enctype="multipart/form-data">

              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Ayar</label>
                <p style="font-size: 20px;"><?= $row['setDescription'] ?></p>
              </div>

              <?php

              if ($row['setType'] == "file") {   ?>

                <div class="form-group">
                  <label for="recipient-name" class="col-form-label" style="border: 2px solid #ccc;  display: inline-block; padding: 6px 12px; cursor: pointer;">
                    Fotoğrafı değiştir
                  </label>
                  <input style="display: none;" type="file" class="form-control" name="setValue" id="recipient-name">
                </div>

              <?php   }   ?>

              <div class="form-group">
                <label for="recipient-name" class="col-form-label">İçerik</label>

                <?php
                if ($row['setType'] == "text") { ?>

                  <input type="text" class="form-control" name="setValue" value="<?= $row['setValue'] ?>" required id="recipient-name">

                <?php  } else if ($row['setType'] == "textarea") { ?>

                  <textarea class="form-control" name="setValue" cols="30" rows="3"><?= $row['setValue'] ?></textarea>

                <?php  } else if ($row['setType'] == "ckeditor") { ?>

                  <textarea id="editor" class="form-control" name="setValue" cols="30" rows="3"><?= $row['setValue'] ?></textarea>

                <?php  } else if ($row['setType'] == "file") { ?>
                  <br>
                  <a href="dimg/setting/<?= $row['setValue'] ?>" target="_blank"><img width="200" src="dimg/setting/<?= $row['setValue'] ?>" alt=""></a>

                <?php  } ?>

              </div>



              <div class="modal-footer">

                <input type="hidden" name="setId" value="<?= $row['setId'] ?>">
                <input type="hidden" name="oldPhoto" value="<?= $row['setValue'] ?>">



                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.href='setting'">Geri Dön</button>
                <button type="submit" class="btn btn-success" name="editsetting">Güncelle</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>




<?php require_once 'footer.php'; ?>

<script>
  ClassicEditor
    .create(document.querySelector('#editor'))
    .then(editor => {
      console.log(editor);
    })
    .catch(error => {
      console.error(error);
    });
</script>