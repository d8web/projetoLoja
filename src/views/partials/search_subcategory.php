<?php foreach($subs as $sub): ?>
    <option value="<?=$sub['id'];?>" <?php echo ($category==$sub['id']?'selected="selected"':'');?>>
        <?php for($q=0;$q<$level;$q++) echo '- '; ?>
        <?=$sub['name'];?>
    </option>
    <?php if(count($sub['subs']) > 0): ?>
        <?=$render('search_subcategory', [
            'subs' => $sub['subs'],
            'level' => $level + 1,
            'category' => !empty($category) ? $category : ''
        ]);?>
    <?php endif; ?>
<?php endforeach; ?>