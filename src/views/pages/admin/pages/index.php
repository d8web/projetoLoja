<?php use src\handlers\Store; ?>
<?=$render("admin/header")?>

    <section class="container-site">

        <?=$render("admin/sidebar", [
            "activeMenu" => $activeMenu,
            "loggedAmin" => $loggedAdmin,
            "permissions" => $permissions
        ])?>

        <main>
            <?=$render("admin/navbar", [
                "loggedAdmin" => $loggedAdmin
            ])?>

            <div class="content">
                <h1>Páginas</h1>
    
                <div class="box">
                    <div class="box-header">
                        <h3>Lista de páginas</h3>
    
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
                                href="<?=$base?>/admin/pages/new"
                            >Adicionar</a>
                        </div>
                    </div>
                    <div class="box-body">
    
                        <table>
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th width="200" style="text-align: end;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list as $item): ?>
                                    <tr>
                                        <td><?=$item["title"]?></td>
                                        <td style="text-align: end;">
                                            <a
                                                class="btn btn-sm btn-edit"
                                                href="<?=$base?>/admin/pages/edit/<?=Store::aesEncrypt($item["id"])?>"
                                            >Editar</a>
                                            <a
                                                onclick="return confirm('Você tem certeza que deseja excluir?')"
                                                class="btn btn-sm btn-del"
                                                href="<?=$base?>/admin/pages/del/<?=Store::aesEncrypt($item["id"])?>"
                                            >Excluir</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
    
                    </div>
                </div>
            </div>

        </main>

    </section>

<?=$render("admin/footer")?>