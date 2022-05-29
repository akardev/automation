<?php
require_once 'header.php';
require_once 'sidebar.php';
?>

<div class="content-wrapper">
    <section class="content">

        <?php

        if (isset($_POST['addsales'])) {
            $result = $db->insert("sales", $_POST, ["formName" => "addsales"]);

            if ($result['status']) {   ?>
                <div class="alert alert-success">
                    <h4 align="center">Satış başarıyla eklendi! <i class="icon fa fa-check"></i></h4>
                </div>
            <?php   } else {  ?>
                <div class="alert alert-danger">
                    <h4 align="center">Satış eklenemedi! <i class="icon fa fa-ban"></i>
                        <?= "<hr>" . $result['error'] ?>
                    </h4>
                </div>
        <?php }
        }

        if (isset($_GET['deletesales'])) {
            $result = $db->delete("sales", "salesId", $_GET['salesId']);
        }

        ?>

        <div class="box">
            <div class="box-header">
                <h2 class="box-title"><b><i> Satışlar </i></b></h2>
                <div align="center">
                    <button" class="btn btn-primary" data-toggle="modal" data-target="#addsales" type="submit">Satış Ekle</button>
                </div>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th width="5">#</th>
                            <th>Tarih</th>
                            <th>Ürün & Hizmet</th>
                            <th>Hesap</th>
                            <th>Tutar</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $sql = $db->qSql("SELECT * FROM sales INNER JOIN account ON sales.accId = account.accId INNER JOIN product ON sales.productId = product.productId");
                        $count = 1;
                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>

                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $db->tDate("j F Y", $row['salesDate']) ?></td>
                                <td><?= $row['productTitle']  ?></td>
                                <td> <?= empty($row['accCompany']) ? $row['accAuthorizedFullName'] : $row['accCompany'] ?></td>
                                <td><?= $row['productPrice'] ?></td>
                                <td width="5"><a title="Sil" class="btn btn-primary btn-xs" href="?deletesales=true&salesId=<?= $row['salesId'] ?>"><i class="fa fa-trash"></i></a></td>
                            </tr>

                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
</div>


<!-- Add sales Modal Start -->
<div class="modal fade" id="addsales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 align="center" class="modal-title" id="exampleModalLabel"><b>Satış Ekle</b> </h3>
            </div>
            <div class="modal-body">
                <form method="POST">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Hesap</label>
                        <select class="form-control" required name="accId">
                            <option value="">Hesap seçiniz...</option>
                            <?php
                            $sql = $db->read("account", [
                                "columnsName" => "accId",
                                "columnsSort" => "DESC"
                            ]);
                            $count = 1;
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>
                                <option value="<?= $row['accId'] ?>">
                                    <?= empty($row['accCompany']) ? $row['accAuthorizedFullName'] : $row['accCompany'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Ürün & Hizmet</label>
                        <select class="form-control" required name="productId">
                            <option value="">Ürün & Hizmet seçiniz...</option>
                            <?php
                            $sql = $db->read("product", [
                                "columnsName" => "productId",
                                "columnsSort" => "DESC"
                            ]);
                            $count = 1;
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>
                                <option value="<?= $row['productId'] ?>">
                                    <?= $row['productTitle'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-success" name="addsales">Ekle</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once 'footer.php'; ?>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>