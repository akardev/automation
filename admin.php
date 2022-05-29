<?php
require_once 'header.php';
require_once 'sidebar.php';
?>

<div class="content-wrapper">
    <section class="content">

        <?php

        if (isset($_POST['addadmin'])) {
            $result = $db->insert(
                "admin",
                $_POST,
                [
                    "formName" => "addadmin",
                    "dir" => "admin",
                    "fileName" => "adminFile",
                    "pass" => "adminPass"
                ]
            );

            if ($result['status']) {   ?>
                <div class="alert alert-success">
                    <h4 align="center">Yönetici başarıyla eklendi! <i class="icon fa fa-check"></i></h4>
                </div>
            <?php   } else {  ?>
                <div class="alert alert-danger">
                    <h4 align="center">Yönetici eklenemedi! <i class="icon fa fa-ban"></i>
                        <?= "<hr>" . $result['error'] ?>
                    </h4>
                </div>
        <?php }
        }


        if (isset($_GET['deleteadmin'])) {
            $result = $db->delete("admin", "adminId", $_GET['adminId'], $_GET['deletefile']);
        }

        ?>

        <div class="box">
            <div class="box-header">
                <h2 class="box-title"><b><i> Yönetici Listesi </i></b></h2>
                <div align="center">
                    <button" class="btn btn-primary" data-toggle="modal" data-target="#addadmin" type="submit">Yönetici Ekle</button>
                </div>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th width="5">#</th>
                            <th>Kullanıcı Adı</th>
                            <th>Ad Soyad</th>
                            <th>Durum </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id="sortable">
                        <?php
                        $sql = $db->read("admin", [
                            "columnsName" => "adminMust",
                            "columnsSort" => "asc"
                        ]);
                        $count = 1;
                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>

                            <tr id="item-<?= $row['adminId'] ?>">
                                <td class="sortable"><?= $count++ ?></td>
                                <td><?= $row['adminUsername'] ?></td>
                                <td><?= $row['adminName'] . " " . $row['adminSurname'] ?></td>
                                <td>
                                    <?php
                                    if ($row['adminStatus'] == 1) {
                                        echo "Aktif";
                                    } else {
                                        echo "Pasif";
                                    }      ?>
                                </td>
                                <td width="5"><a title="Düzenle" class="btn btn-primary btn-xs" href="edit-admin?adminId=<?= $row['adminId'] ?>"><i class="fa fa-edit"></i></a></td>
                                <td width="5"><a title="Sil" class="btn btn-primary btn-xs" href="?deleteadmin=true&adminId=<?= $row['adminId'] ?>&deletefile=<?= $row['adminFile'] ?>"><i class="fa fa-trash"></i></a></td>
                            </tr>

                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
</div>


<!-- Add Admin Modal Start -->
<div class="modal fade" id="addadmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 align="center" class="modal-title" id="exampleModalLabel"><b>Yeni Yönetici Ekle</b> </h3>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Profil Resmi</label>
                        <input type="file" class="form-control" name="adminFile" id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Ad</label>
                        <input type="text" class="form-control" name="adminName" required id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Soyad</label>
                        <input type="text" class="form-control" name="adminSurname" required id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Kullanıcı Adı</label>
                        <input type="text" class="form-control" name="adminUsername" required id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Şifre</label>
                        <input type="password" class="form-control" name="adminPass" required id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Durum</label>
                        <select class="form-control" required name="adminStatus">
                            <option value="1">Aktif</option>
                            <option value="0">Pasif</option>
                        </select>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-success" name="addadmin">Ekle</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once 'footer.php'; ?>

<script type="text/javascript">
    $(function() {
        $("#sortable").sortable({
            revert: true,
            handle: ".sortable",
            stop: function(event, ui) {
                var data = $(this).sortable('serialize');
                console.log(data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: data,
                    url: "netting/order-ajax.php?adminMust=true",
                    success: function(msg) {
                        // alert("Sıralama Başarılı...");
                        // console.log(msg.processResult);
                        // console.log(msg.processMsg);
                    }
                });
            }



        });
        $("#sortable").disableSelection();
    });
</script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>