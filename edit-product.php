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
                            <h2><b><i>Ürün & Hizmet bilgilerini düzenle</i></b></h2>
                        </div>
                    </div>
                    <div class="box-body">

                        <?php

                        if (isset($_POST['editproduct'])) {
                            $result = $db->update("product", $_POST, ["formName" => "editproduct", "columns" => "productId"]);

                            if ($result['status']) {   ?>
                                <div class="alert alert-success">
                                    <h4 align="center">Ürün & Hizmet bilgileri başarıyla güncellendi! <i class="icon fa fa-check"></i></h4>
                                </div>
                            <?php   } else {  ?>
                                <div class="alert alert-danger">
                                    <h4 align="center">Güncelleme hatası! <i class="icon fa fa-ban"></i>
                                        <?= "<hr>" . $result['error'] ?>
                                    </h4>
                                </div>
                        <?php  }
                        }

                        if (isset($_GET['productId'])) {
                            $sql = $db->wread("product", "productId", $_GET['productId']);
                            $row = $sql->fetch(PDO::FETCH_ASSOC);
                        }
                        ?>

                        <form method="POST">

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Ürün & Hizmet Adı</label>
                                <input type="text" required class="form-control" value="<?= $row['productTitle'] ?>" name="productTitle" id="recipient-name">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Ürün & Hizmet Detayı</label>
                                <textarea id="editor" class="form-control" name="productContent" rows="3" cols="30"><?= $row['productContent'] ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Ürün & Hizmet Fiyatı </label>
                                <input type="number" min="1" step="any" value="<?= $row['productPrice'] ?>" class="form-control" name="productPrice" required id="recipient-name">
                            </div>
                    </div>
                    <div class="modal-footer">

                        <input type="hidden" name="productId" value="<?= $row['productId'] ?>">

                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.href='product'">Geri Dön</button>
                        <button type="submit" class="btn btn-success" name="editproduct">Güncelle</button>
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