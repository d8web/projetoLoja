<?php use src\handlers\Store; ?>
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
                <h1>Permissões</h1>
    
                <?php if(!empty($success)): ?>
                    <div class="success">
                        <?=$success?>
                    </div>
                <?php endif ?>
    
                <div class="box">
                    <div class="box-header">
                        <h3>Editar grupo de permissões <?=$id?></h3>
                        <div>
                            <a
                                class="btn btn-lg"
                                href="<?=$base?>/admin/permissions"
                            >Voltar</a>
                        </div>
                    </div>
                    <div class="box-body">
    
                        <form action="<?=$base?>/admin/permissions/editSubmit" method="post" class="form-post">
                            <div class="form-item">
                                <label>Nome do grupo</label>
                                <?= (key_exists("name", $errorItems)) ? '<span class="error-text">'.$errorItems["name"].'</span>' : "" ?>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="<?=$permissionGroupName?>"
                                    placeholder="Digite o nome do grupo de permissões"
                                    class="<?= (key_exists("name", $errorItems)) ? "error" : "" ?>"
                                />
                            </div>
    
                            <?php foreach($permission_items as $item): ?>
                                <div class="flex-item-form">
                                    <input
                                        type="checkbox"
                                        name="items[]"
                                        value="<?=$item["id"]?>"
                                        id="item-<?=$item["id"]?>"
                                        <?php if(in_array($item["slug"], $permissionGroupSlugs)): ?>
                                            checked="checked"
                                        <?php endif ?>
                                    />
                                    <label for="item-<?=$item["id"]?>"><?=$item["name"]?></label>
                                </div>
                            <?php endforeach ?>
                            
                            <input type="hidden" name="id" value="<?=$id?>"/>
                            <input type="submit" class="btn btn-lg fs-16 mt-10" value="Salvar"/>
                        </form>
    
                    </div>
                </div>
            </div>

        </main>

    </section>

<?=$render("admin/footer")?>