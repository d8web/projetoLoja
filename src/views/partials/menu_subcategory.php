<?php foreach($subs as $sub): ?>
    <li>
        <a class="dropdown-item" href="<?=$base;?>/categories/<?=$sub['id'];?>">
            <?php for($q=0;$q<$level;$q++) echo '- '; ?>
            <?=$sub['name'];?>
        </a>
    </li>
    <?php if(count($sub['subs']) > 0): ?>
        <?=$render('menu_subcategory', [
            'subs' => $sub['subs'],
            'level' => $level + 1
        ]);?>
    <?php endif; ?>
<?php endforeach; ?>