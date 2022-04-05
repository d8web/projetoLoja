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
                <span class="material-icons-sharp">category</span>
                <h3>Categorias</h3>
            </a>
        <?php endif; ?>
        
        <?php if(AdminHandler::hasPermission("brands_view", $permissions)): ?>
            <a href="<?=$base?>/admin/brands" class="<?=$activeMenu === "brands" ? "active" : ""?>">
                <span class="material-icons-sharp">loyalty</span>
                <h3>Marcas</h3>
            </a>
        <?php endif; ?>
        
        <?php if(AdminHandler::hasPermission("pages_view", $permissions)): ?>
            <a href="<?=$base?>/admin/pages" class="<?=$activeMenu === "pages" ? "active" : ""?>">
                <span class="material-icons-sharp">description</span>
                <h3>Páginas</h3>
            </a>
        <?php endif; ?>
        
        <?php if(AdminHandler::hasPermission("products_view", $permissions)): ?>
            <a href="<?=$base?>/admin/products" class="<?=$activeMenu === "products" ? "active" : ""?>">
                <span class="material-icons-sharp">inventory_2</span>
                <h3>Produtos</h3>
            </a>
        <?php endif; ?>

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