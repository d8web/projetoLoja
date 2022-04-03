<?php
    if(!isset($selected)) {
        $selected = ""; 
    }
?>
<?php foreach($list as $item): ?>
    <option <?=($item["id"]===$selected) ? 'selected="selected"':''?> value="<?=$item["id"]?>">
        <?php
            for($q = 0; $q < $level; $q++) echo "-- ";
            echo $item["name"]
        ?>
    </option>

    <?php if(count($item["subs"]) > 0): ?>
        <?=$render("admin/categoriesItemAdd", [
            "list" => $item["subs"],
            "level" => $level + 1,
            "selected" => $selected
        ])?>
    <?php endif ?>
<?php endforeach ?>