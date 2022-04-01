<?php use src\handlers\Store; ?>
<?php foreach($items as $item): ?>
    <tr>
        <td>
            <?php
                for($q = 0; $q < $level; $q++) echo "-- ";
                echo $item["name"]
            ?>
        </td>
        <td style="text-align: end;">
            <a
                class="btn btn-sm btn-edit"
                href="<?=$base?>/admin/category/edit/<?=Store::aesEncrypt($item["id"])?>"
            >Editar</a>
            <a
                onclick="return confirm('Você tem certeza que deseja excluir?')"
                class="btn btn-sm btn-del"
                href="<?=$base?>/admin/category/del/<?=Store::aesEncrypt($item["id"])?>"
            >Excluir</a>
        </td>
    </tr>

    <?php if(count($item["subs"]) > 0): ?>
        <?=$render("admin/categoriesItem", [
            "items" => $item["subs"],
            "level" => $level + 1
        ])?>
    <?php endif ?>

<?php endforeach ?>