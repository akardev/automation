<?php
require_once 'header.php';
require_once 'sidebar.php';
?>

<div class="content-wrapper">
    <section class="content">

        <?php

        if (isset($_POST['addoperation'])) {
            $result = $db->insert("operation", $_POST, ["formName" => "addoperation"]);

            if ($result['status']) {   ?>
                <div class="alert alert-success">
                    <h4 align="center">Gelir, gider başarıyla eklendi! <i class="icon fa fa-check"></i></h4>
                </div>
            <?php   } else {  ?>
                <div class="alert alert-danger">
                    <h4 align="center">Gelir, gider eklenemedi! <i class="icon fa fa-ban"></i>
                        <?= "<hr>" . $result['error'] ?>
                    </h4>
                </div>
        <?php }
        }


        if (isset($_GET['deleteoperation'])) {
            $result = $db->delete("operation", "opId", $_GET['opId']);
        }

        ?>

        <div class="box">
            <div class="box-header">
                <h2 class="box-title"><b><i> Gelir, Gider </i></b></h2>
                <div align="center">
                    <button" class="btn btn-primary" data-toggle="modal" data-target="#addoperation" type="submit">Ekle</button>
                </div>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th width="5">#</th>
                            <th width="5">Tip</th>
                            <th>Tarih</th>
                            <th>Hesap</th>
                            <th>Açıklama</th>   
                            <th>Tutar</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $sql = $db->qSql("SELECT * FROM operation INNER JOIN account ON operation.accId = account.accId");
                        $count = 1;
                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>

                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= ($row['opType'] == 'Gelir') ? "<span class='label label-success'>Gelir</span>" : "<span class='label label-danger'>Gider</span>"  ?></td>
                                <td><?= $db->tDate("j F Y", $row['opDate']) ?></td>
                                <td> <?= empty($row['accCompany']) ? $row['accAuthorizedFullName'] : $row['accCompany'] ?></td>
                                <td><?= $row['opDescription']  ?></td>
                                <td><?= $row['opPrice'] ?></td>
                                <td width="5"><a title="Sil" class="btn btn-primary btn-xs" href="?deleteoperation=true&opId=<?= $row['opId'] ?>"><i class="fa fa-trash"></i></a></td>
                            </tr>

                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
</div>


<!-- Add operation Modal Start -->
<div class="modal fade" id="addoperation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 align="center" class="modal-title" id="exampleModalLabel"><b>Gelir, Gider Ekle</b> </h3>
            </div>
            <div class="modal-body">
                <form method="POST">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Açıklama</label>
                        <textarea class="form-control" required name="opDescription" rows="3" cols="30"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tarih</label>
                        <input type="date" class="form-control" required name="opDate" value="<?= date("Y-m-d") ?>" id="recipient-name">
                    </div>


                    <div id="accform" class="form-group">
                        <label for="recipient-name" class="col-form-label">Hesap</label>
                        <select class="form-control account" required name="accId">
                            <option value="">Hesap seçiniz...</option>

                            <?php
                            $sql = $db->read("account", [
                                "columnsName" => "accId",
                                "columnsSort" => "DESC"
                            ]);
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>
                                <option value="<?= $row['accId'] ?>">
                                    <?= empty($row['accCompany']) ? $row['accAuthorizedFullName'] : $row['accCompany'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>



                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">İşlem Tipi</label>
                        <select class="form-control" required name="opType">
                            <option value="">İşlem tipi seçiniz...</option>
                            <option value="Gelir">Gelir</option>
                            <option value="Gider">Gider</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tutar</label>
                        <input type="number" min="1" step="any" class="form-control" required name="opPrice" id="recipient-name">
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-success" name="addoperation">Ekle</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once 'footer.php'; ?>

<script>
    $("select.account").on('change', function() {

        var accId = $(this).children("option:selected").val();

        console.log(accId);

        $.ajax({

            type: 'POST',
            url: 'netting/order-ajax.php',
            data: {
                'accId': accId
            },
            success: function(data) {

                if (data != "FALSE") {
                    $('#accform').after(data);

                } else {
                    $('#productform').after(data);
                }
            }
        })
    })
</script>