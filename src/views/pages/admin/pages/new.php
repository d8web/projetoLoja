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
                <h1>Adicionar página</h1>
    
                <?php if(!empty($success)): ?>
                    <div class="success">
                        <?=$success?>
                    </div>
                <?php endif ?>
    
                <div class="box">
                    <div class="box-header">
                        <h3>Nova página</h3>
                        <div>
                            <a
                                class="btn btn-lg"
                                href="<?=$base?>/admin/pages"
                            >Voltar</a>
                        </div>
                    </div>
                    <div class="box-body">
    
                        <form action="<?=$base?>/admin/pages/newSubmit" method="post" class="form-post">
                            <div class="form-item">
                                <label>Nome da página</label>
                                <?= (key_exists("title", $errorItems)) ? '<span class="error-text">'.$errorItems["title"].'</span>' : "" ?>
                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    placeholder="Digite o nome da página"
                                    class="<?= (key_exists("title", $errorItems)) ? "error" : "" ?>"
                                />
                            </div>

                            <div class="form-item">
                                <label>Corpo</label>
                                <?= (key_exists("body", $errorItems)) ? '<span class="error-text">'.$errorItems["body"].'</span>' : "" ?>
                                <textarea
                                    name="body"
                                    id="textarea"
                                    placeholder="Digite o corpo da página"
                                    class="<?= (key_exists("body", $errorItems)) ? "error" : "" ?>"
                                ></textarea>
                            </div>
    
                            <input type="submit" class="btn btn-lg fs-16 mt-10" value="Adicionar"/>
                        </form>
    
                    </div>
                </div>
            </div>

        </main>

    </section>

<script src="https://cdn.tiny.cloud/1/bbckk8orf5zz7k60a6crudo1xwxu1sp0nbeoey6smjj4airx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        height: 500,
        menubar: false,
        plugins: [
            'image media lists'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | media image | alignleft aligncenter alignright alignjustify | bullist numlist | removeformat',
        automatic_uploads: true,
        file_picker_types: "image",
        images_upload_url: "<?=$base?>/admin/pages/upload",
        content_style: 'body { font-family:"Ping Pong",Helvetica,Arial,sans-serif; font-size:18px }'
    });
</script>
<?=$render("admin/footer")?>