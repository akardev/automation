<?php
require_once 'header.php';
require_once 'sidebar.php';
?>

<div class="content-wrapper">
    <section class="content">

        <?php

        if (isset($_POST['addproduct'])) {
            $result = $db->insert("product", $_POST, ["formName" => "addproduct"]);

            if ($result['status']) {   ?>
                <div class="alert alert-success">
                    <h4 align="center">Ürün & Hizmet başarıyla eklendi! <i class="icon fa fa-check"></i></h4>
                </div>
            <?php   } else {  ?>
                <div class="alert alert-danger">
                    <h4 align="center">Ürün & Hizmet eklenemedi! <i class="icon fa fa-ban"></i>
                        <?= "<hr>" . $result['error'] ?>
                    </h4>
                </div>
        <?php }
        }


        if (isset($_GET['deleteproduct'])) {
            $result = $db->delete("product", "productId", $_GET['productId']);
        }

        ?>

        <div class="box">
            <div class="box-header">
                <h2 class="box-title"><b><i> Ürünler & Hizmetler </i></b></h2>
                <div align="center">
                    <button" class="btn btn-primary" data-toggle="modal" data-target="#addproduct" type="submit">Yeni ürün ekle</button>
                </div>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th width="5">#</th>

                            <th>Ürün & Hizmet Adı</th>
                            <th>Ürün & Hizmet Detayı</th>
                            <th>Ürün & Hizmet Fiyatı</th>


                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $sql = $db->read("product", [
                            "columnsName" => "productId",
                            "columnsSort" => "DESC"
                        ]);
                        $count = 1;
                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>

                            <tr>
                                <td><?= $count++ ?></td>

                                <td><?= $row['productTitle'] ?></td>
                                <td><?= $row['productContent']  ?></td>
                                <td><?= number_format($row['productPrice'], 2)  ?> ₺</td>




                                <td width="5"><a title="Düzenle" class="btn btn-primary btn-xs" href="edit-product?productId=<?= $row['productId'] ?>"><i class="fa fa-edit"></i></a></td>
                                <td width="5"><a title="Sil" class="btn btn-primary btn-xs" href="?deleteproduct=true&productId=<?= $row['productId'] ?>"><i class="fa fa-trash"></i></a></td>
                            </tr>

                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
</div>


<!-- Add product Modal Start -->
<div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 align="center" class="modal-title" id="exampleModalLabel"><b>Yeni ürün & hizmet ekle</b> </h3>
            </div>
            <div class="modal-body">
                <form method="POST">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Ürün & Hizmet Adı</label>
                        <input type="text" class="form-control" required name="productTitle" id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Ürün & Hizmet Detayı</label>
                        <textarea id="editor" class="form-control" name="productContent" rows="25" cols="30"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Ürün & Hizmet Fiyatı </label>
                        <input type="number" min="1" step="any" class="form-control" required name="productPrice" id="recipient-name">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-success" name="addproduct">Ekle</button>
                </form>
            </div>
        </div>
    </div>
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
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>