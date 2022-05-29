<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dimg/admin/<?= $_SESSION['admin']['adminFile'] ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $_SESSION['admin']['adminName'] . " " . $_SESSION['admin']['adminSurname'] ?></p>
                <small> Yönetici</small>
            </div>
        </div>

        <hr>
        <ul class="sidebar-menu" data-widget="tree">
        <li><a href="index"><i class="fa fa-home"></i><span>Panel</span> </a></li>
            <li class="header">Menüler</li>
            
            <li><a href="account"><i class="fa fa-users"></i><span> Hesaplar</span></a></li>
            <li><a href="product"><i class="fa fa-barcode"></i><span> Ürün & Hizmet</span></a></li>
            <li><a href="sales"><i class="fa fa-check-square"></i><span> Satışlar</span></a></li>
            <li><a href="operation"><i class="fa fa-exchange"></i><span> Gelir, Gider</span></a></li>

            <li class="header">Yönetim</li>
            <li class="treeview">
                <a href="#"><i class="fa fa-key"></i><span> Yöneticiler & Ayarlar</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="admin"><i class="fa fa-user-circle"></i><span>Yöneticiler</span>  </a></li>
                    <li><a href="setting"><i class="fa fa-cog"></i><span>Ayarlar</span>  </a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>