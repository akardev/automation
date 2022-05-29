<?php
require_once 'header.php';
require_once 'sidebar.php';

$sql = $db->wread("account", "accId", htmlspecialchars($_GET['accId']));
$row = $sql->fetch(PDO::FETCH_ASSOC);

?>



<div class="content-wrapper">
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Hesap Detayı</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> <?= empty($row['accCompany']) ? $row['accAuthorizedFullName'] : $row['accCompany'] ?>
                <small class="pull-right"><?= $db->tDate("j F Y", $row['accDate']) ?></small>
              </h2>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">

              <address>
                <strong> <?= empty($row['accCompany']) ? $row['accAuthorizedFullName'] : $row['accCompany'] ?></strong><br>
                <?= $row['accAuthorizedFullName'] ?><br>
                <?= $row['accAddress'] ?><br>
                <?= $row['accPhone'] ?><br>
                <?= $row['accMail'] ?>
              </address>
            </div>

          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <h2 align="center" class="page-header"><b> Satışlar</b> </h2>
              <table class="table table-bordered">

                <thead>
                  <tr>
                    <th width="5">#</th>

                    <th>Tarih</th>
                    <th>Ürün & Hizmet</th>
                    <th>Tutar</th>
                    <th>Tahsilat</th>
                    <th>Kalan</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $sql = $db->qSql("SELECT * FROM sales INNER JOIN account ON sales.accId = account.accId INNER JOIN product ON sales.productId = product.productId WHERE sales.accId = '{$_GET['accId']}' ORDER BY sales.salesDate DESC");
                  $count = 1;
                  while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>

                    <tr>
                      <td><?= $count++ ?></td>

                      <td><?= $db->tDate("j F Y", $row['salesDate']) ?></td>
                      <td><?= $row['productTitle']  ?></td>

                      <td><?= number_format($row['productPrice'], 2) ?></td>
                      <td>
                        <?php
                        $sqlRevenue = $db->qSql("SELECT SUM(opPrice) as revenue FROM operation WHERE opType='Gelir' AND accId='{$_GET['accId']}' AND productId='{$row['productId']}'");
                        $revenue = $sqlRevenue->fetch(PDO::FETCH_ASSOC);
                        echo number_format($revenue['revenue'], 2);
                        ?>
                      </td>
                      <td><?= $row['productPrice'] - $revenue['revenue']; ?></td>
                    </tr>

                  <?php } ?>
                </tbody>

              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 table-responsive">
              <h2 align="center" class="page-header"><b> Gelir, Gider Hareketleri</b> </h2>
              <table class="table table-bordered">

                <thead>
                  <tr>
                    <th width="5">#</th>
                    <th width="5">Tip</th>
                    <th>Tarih</th>

                    <th>Açıklama</th>
                    <th>Tutar</th>



                  </tr>
                </thead>

                <tbody>
                  <?php
                  $sql = $db->qSql("SELECT * FROM operation INNER JOIN account ON operation.accId = account.accId WHERE operation.accId = '{$_GET['accId']}' ORDER BY operation.opId DESC");
                  $count = 1;
                  while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>

                    <tr>
                      <td><?= $count++ ?></td>
                      <td><?= ($row['opType'] == 'Gelir') ? "<span class='label label-success'>Gelir</span>" : "<span class='label label-danger'>Gider</span>"  ?></td>
                      <td><?= $db->tDate("j F Y", $row['opDate']) ?></td>

                      <td><?= $row['opDescription']  ?></td>
                      <td><?= $row['opPrice'] ?></td>



                    </tr>

                  <?php } ?>
                </tbody>

              </table>
            </div>
          </div>
          <hr>
          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
              <p class="lead">Bilgi:</p>

              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta lectus at leo condimentum auctor. Nulla et purus aliquam, lacinia est sit amet, tristique felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed eu lobortis neque. Suspendisse a urna tincidunt, vestibulum odio tristique, aliquet diam. In vestibulum lectus nec vulputate ultrices. Proin laoreet leo nec nisi pellentesque, id facilisis nisi luctus. Morbi tincidunt sem lacus, et ultricies tortor lacinia nec. Sed varius turpis auctor nibh interdum, ut pretium dui tempor. Vestibulum et rhoncus sem. Integer lobortis ut felis et ornare. Vestibulum consequat purus id enim hendrerit ornare. Curabitur venenatis libero in tellus congue pulvinar et posuere dui. Ut et dui eu magna ullamcorper tincidunt sit amet eget magna.
              </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
              <p class="lead">Hesap Özeti</p>

              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <th style="width:50%">Toplam Satış:</th>
                      <td>
                        <?php
                        $sql = $db->qSql("SELECT SUM(productPrice) as totalSales FROM sales INNER JOIN account ON sales.accId = account.accId INNER JOIN product ON sales.productId = product.productId WHERE sales.accId = '{$_GET['accId']}'");
                        $totalSales = $sql->fetch(PDO::FETCH_ASSOC);
                        echo number_format($totalsales = $totalSales['totalSales'], 2);
                          
                        ?> ₺
                      </td>
                    </tr>
                    <tr>
                      <th>Gelir (Tahsil):</th>
                      <td>
                        <?php
                        $sql = $db->qSql("SELECT SUM(opPrice) as revenue FROM operation WHERE opType='Gelir' AND accId = '{$_GET['accId']}'");
                        $revenue = $sql->fetch(PDO::FETCH_ASSOC);
                        echo number_format($revenue = $revenue['revenue'], 2);

                        ?> ₺
                      </td>
                    </tr>
                    <tr>
                      <th>Gider:</th>
                      <td>
                        <?php
                        $sql = $db->qSql("SELECT SUM(opPrice) as expense FROM operation WHERE opType='Gider' AND accId = '{$_GET['accId']}'");
                        $expense = $sql->fetch(PDO::FETCH_ASSOC);
                        echo number_format($expense = $expense['expense'], 2);

                        ?> ₺
                      </td>
                    </tr>
                    <tr>
                      <th>Bakiye:</th>
                      <td><?= number_format($revenue - $expense, 2); ?> ₺</td> 


                    </tr>
                    <tr>
                      <th>Kâr:</th>
                      <td><?= number_format($totalsales -  $expense, 2); ?> ₺</td> 

                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- this row will not appear when printing -->
          <!-- <div class="row no-print">
            <div class="col-xs-12">
              <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
              <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
              </button>
              <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                <i class="fa fa-download"></i> Generate PDF
              </button>
            </div>
          </div> -->
        </section>
      </div>
      <!-- <div class="box-footer">
        Footer
      </div> -->
    </div>
  </section>
</div>

<?php require_once 'footer.php'; ?>