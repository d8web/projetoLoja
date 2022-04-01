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
                <h1>Categorias</h1>
    
                <?php if(!empty($success)): ?>
                    <div class="success">
                        <?=$success?>
                    </div>
                <?php endif ?>
    
                <div class="box">
                    <div class="box-header">
                        <h3>Editar categoria</h3>
                        <div>
                            <a
                                class="btn btn-lg"
                                href="<?=$base?>/admin/categories"
                            >Voltar</a>
                        </div>
                    </div>
                    <div class="box-body">
    
                        <form action="<?=$base?>/admin/categories/editSubmit" method="post" class="form-post">
                            <div class="form-item">
                                <label>Nome da categoria</label>
                                <?=(key_exists("name", $errorItems)) ? '<span class="error-text">'.$errorItems["name"].'</span>' : "" ?>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="<?=$categoryData["name"]?>"
                                    placeholder="Digite o nome da categoria"
                                    class="<?= (key_exists("name", $errorItems)) ? "error" : "" ?>"
                                />
                            </div>

                            <div class="form-item">
                                <label for="sub">Categoria pai</label>
                                <select name="sub" title="sub" id="sub">
                                    <option value="">Nenhuma (opcional)</option>
                                    <?=$render("admin/categoriesItemAdd", [
                                        "list" => $list,
                                        "level" => 0,
                                        "selected" => $categoryData["sub"]
                                    ])?>
                                </select>
                            </div>
                            
                            <input type="hidden" name="id" value="<?=$id?>"/>
                            <input type="submit" class="btn btn-lg fs-16 mt-10" value="Salvar"/>
                        </form>
    
                    </div>
                </div>
            </div>

        </main>

    </section>

<?=$render("admin/footer")?>