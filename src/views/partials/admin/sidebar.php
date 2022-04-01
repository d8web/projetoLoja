<?php use src\handlers\Admin\AdminHandler; ?>
<!-- Aside start -->
<aside>
    <div class="top">
        <div class="logo">
            <img src="<?= $base ?>/assets/images/favicon.ico" alt="logo" />
            <h2><span class="text-primary">Store</span>Admin</h2>
        </div>
        <div class="close" id="close-btn">
            <span class="material-icons-sharp">close</span>
        </div>
    </div>

    <div class="sidebar">
        
        <a href="<?=$base?>/admin" class="<?=$activeMenu === "dashboard" ? "active" : ""?>">
            <span class="material-icons-sharp">grid_view</span>
            <h3>Dashboard</h3>
        </a>

        <?php if(AdminHandler::hasPermission("permissions_view", $permissions)): ?>
            <a href="<?=$base?>/admin/permissions" class="<?=$activeMenu === "permissions" ? "active" : ""?>">
                <span class="material-icons-sharp">key</span>
                <h3>Permissões</h3>
            </a>
        <?php endif; ?>
        
        <?php if(AdminHandler::hasPermission("categories_view", $permissions)): ?>
        <a href="<?=$base?>/admin/categories" class="<?=$activeMenu === "categories" ? "active" : ""?>">
            <span class="material-icons-sharp">
                category
            </span>
            <h3>Categorias</h3>
        </a>
        <?php endif; ?>

        <a href="<?=$base?>/admin/brands" class="<?=$activeMenu === "brands" ? "active" : ""?>">
            <span class="material-icons-sharp">loyalty</span>
            <h3>Marcas</h3>
        </a>

        <a href="#">
            <span class="material-icons-sharp">mail_outline</span>
            <h3>Messages</h3>
        </a>

        <a href="#">
            <span class="material-icons-sharp">inventory</span>
            <h3>Products</h3>
        </a>

        <a href="#">
            <span class="material-icons-sharp">report_gmailerrorred</span>
            <h3>Reports</h3>
        </a>

        <a href="#">
            <span class="material-icons-sharp">settings</span>
            <h3>Settings</h3>
        </a>

        <a href="#">
            <span class="material-icons-sharp">add</span>
            <h3>Add product</h3>
        </a>

        <a href="<?= $base ?>/admin/logout">
            <span class="material-icons-sharp">logout</span>
            <h3>Logout</h3>
        </a>

    </div>
</aside>
<!-- End aside -->