<?php
require_once 'header.php';
require_once 'sidebar.php';
?>
<div class="content-wrapper">
  <section class="content">


    <div  class="box">
      <div class="box-header with-border">
        <h3 align="center">Günlük Cari Rapor</h3>


        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3>
                  <?php
                  $sql = $db->qSql("SELECT SUM(productPrice) as total FROM sales INNER JOIN product ON sales.productId = product.productId WHERE DAY(salesDate) = DAY(CURDATE())");
                  $total = $sql->fetch(PDO::FETCH_ASSOC);
                  echo number_format($total['total'], 2);

                  ?> ₺</h3>

                <p>Toplam Satış</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">akardev </a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>
                  <?php
                  $sql = $db->qSql("SELECT SUM(opPrice) as totalRevenue FROM operation WHERE opType='Gelir' AND DAY(opDate) = DAY(CURDATE())");
                  $row = $sql->fetch(PDO::FETCH_ASSOC);
                  echo number_format($row['totalRevenue'], 2);

                  ?> ₺</h3>

                <p>Toplam Gelir (Tahsilat)</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"> akardev </a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3>
                  <?php
                  $sql = $db->qSql("SELECT SUM(opPrice) as totalExpense FROM operation WHERE opType='Gider' AND DAY(opDate) = DAY(CURDATE())");
                  $row = $sql->fetch(PDO::FETCH_ASSOC);
                  echo number_format($row['totalExpense'], 2);

                  ?> ₺</h3>

                <p>Toplam Gider</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"> akardev </a>
            </div>
          </div>


          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue">
              <div class="inner">
                <h3>
                  <?php
                  $sql = $db->qSql("SELECT
                   SUM(CASE WHEN opType='Gelir' then opPrice ELSE 0 END) - SUM(CASE WHEN opType='Gider' then opPrice ELSE 0 END)
                    as safe FROM operation WHERE DAY(opDate) = DAY(CURDATE())");
                  $row = $sql->fetch(PDO::FETCH_ASSOC);
                  echo number_format($row['safe'], 2);

                  ?> ₺</h3>

                <p>Kasa</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"> akardev </a>
            </div>
          </div>


        </div>
      </div>
    </div>

















    <div class="box">
      <div class="box-header with-border">
        <h3 align="center">Genel Cari Rapor</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3>
                  <?php
                  $sql = $db->qSql("SELECT SUM(productPrice) as total FROM sales INNER JOIN product ON sales.productId = product.productId");
                  $total = $sql->fetch(PDO::FETCH_ASSOC);
                  echo number_format($total['total'], 2);

                  ?> ₺</h3>

                <p>Toplam Satış</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">akardev </a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>
                  <?php
                  $sql = $db->qSql("SELECT SUM(opPrice) as totalRevenue FROM operation WHERE opType='Gelir'");
                  $row = $sql->fetch(PDO::FETCH_ASSOC);
                  echo number_format($row['totalRevenue'], 2);

                  ?> ₺</h3>

                <p>Toplam Gelir (Tahsilat)</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"> akardev </a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3>
                  <?php
                  $sql = $db->qSql("SELECT SUM(opPrice) as totalExpense FROM operation WHERE opType='Gider'");
                  $row = $sql->fetch(PDO::FETCH_ASSOC);
                  echo number_format($row['totalExpense'], 2);

                  ?> ₺</h3>

                <p>Toplam Gider</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"> akardev </a>
            </div>
          </div>


          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue">
              <div class="inner">
                <h3>
                  <?php
                  $sql = $db->qSql("SELECT
                   SUM(CASE WHEN opType='Gelir' then opPrice ELSE 0 END) - SUM(CASE WHEN opType='Gider' then opPrice ELSE 0 END)
                    as safe FROM operation ");
                  $row = $sql->fetch(PDO::FETCH_ASSOC);
                  echo number_format($row['safe'], 2);

                  ?> ₺</h3>

                <p>Kasa</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"> akardev </a>
            </div>
          </div>


        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once 'footer.php'; ?>