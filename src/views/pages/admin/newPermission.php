<?php use src\handlers\Store; ?>
<?=$render("admin/header")?>

    <section class="container-site">

        <?=$render("admin/sidebar", [
            "activeMenu" => $activeMenu,
            "loggedAmin" => $loggedAdmin,
            "permissions" => $permissions
        ])?>

        <main>
            <h1>Permissões</h1>

            <?php if(!empty($success)): ?>
                <div class="success">
                    <?=$success?>
                </div>
            <?php endif ?>

            <div class="box">
                <div class="box-header">
                    <h3>Novo grupo de permissões</h3>
                    <div>
                        <a
                            class="btn btn-lg"
                            href="<?=$base?>/admin/permissions"
                        >Voltar</a>
                    </div>
                </div>
                <div class="box-body">

                    <form action="<?=$base?>/admin/permissions/newSubmit" method="post" class="form-post">
                        <div class="form-item">
                            <label>Nome do grupo</label>
                            <?= (key_exists("name", $errorItems)) ? '<span class="error-text">'.$errorItems["name"].'</span>' : "" ?>
                            <input
                                type="text"
                                name="name"
                                id="name"
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
                                />
                                <label for="item-<?=$item["id"]?>"><?=$item["name"]?></label>
                            </div>
                        <?php endforeach ?>

                        <input type="submit" class="btn btn-lg fs-16 mt-10" value="Adicionar"/>
                    </form>

                </div>
            </div>

        </main>

    </section>

<?=$render("admin/footer")?>