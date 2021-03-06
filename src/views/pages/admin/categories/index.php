<?=$render("admin/header")?>

    <section class="container-site">

        <?=$render("admin/sidebar", [
            "activeMenu" => $activeMenu,
            "loggedAmin" => $loggedAdmin,
            "permissions" => $permissions
        ])?>

        <main>
            <?=$render("admin/navbar", ["loggedAdmin" => $loggedAdmin])?>

            <div class="content">
                <div class="box">
                    <div class="box-header">
                        <h3>Lista de categorias</h3>
    
                        <?php if(!empty($flash)): ?>
                            <div class="flash">
                                <?=$flash?>
                            </div>
                        <?php endif ?>
    
                        <?php if(!empty($success)): ?>
                            <div class="success">
                                <?=$success?>
                            </div>
                        <?php endif ?>
    
                        <div class="button-content">
                            <a
                                class="btn btn-lg"
                                href="<?=$base?>/admin/categories/new"
                            >Adicionar</a>
                        </div>
                    </div>
                    <div class="box-body">
    
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome da permissão</th>
                                    <th width="200" style="text-align: end;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?=$render("admin/categoriesItem", [
                                    "items" => $list,
                                    "level" => 0
                                ])?>
                            </tbody>
                        </table>
    
                    </div>
                </div>
            </div>

        </main>

    </section>

<?=$render("admin/footer")?>