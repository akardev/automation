<?php
require_once 'header.php';
require_once 'sidebar.php';
?>

<div class="content-wrapper">
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><b><i> Ayarlar </i></b></h3>
                <!-- <div align="center">
          <button" class="btn btn-primary" data-toggle="modal" data-target="#addsetting" type="submit">Add Setting</button>
        </div> -->
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ayar</th>
                            <th>İçerik</th>
                            <th>Anahtar Kelimeler</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id="sortable">
                        <?php
                        $sql = $db->read("setting", [
                            "columnsName" => "setMust",
                            "columnsSort" => "asc"
                        ]);
                        $count = 1;
                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>

                            <tr id="item-<?= $row['setId'] ?>">
                                <td class="sortable"><?= $count++ ?></td>
                                <td><?= $row['setDescription'] ?></td>
                                <td>
                                    <?php

                                    if ($row['setType'] == "file") {  ?>
                                        <img width="100" src="dimg/setting/<?= $row['setValue'] ?>" alt="">
                                    <?php   } else {
                                        echo $row['setValue'];
                                    } ?>
                                </td>

                                <td> <?= $row['setKey'] ?>
                                <td width="5"><a class="btn btn-primary btn-xs" href="edit-setting?setId=<?= $row['setId'] ?>"><i class="fa fa-edit"></i></a></td>
                            </tr>

                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
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
                    url: "netting/order-ajax.php?setMust=true",
                    success: function(msg) {
                        // alert("Sıralama Başarılı...");
                        console.log(msg.processResult);
                        console.log(msg.processMsg);
                    }
                });
            }



        });
        $("#sortable").disableSelection();
    });
</script>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>