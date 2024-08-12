<?php
$target = '/home/dnqs6c6cqvgb/public_html/storage/app/public'; 
$shortcut = '/home/dnqs6c6cqvgb/public_html/public/storage'; //Check this for shortcut
symlink($target, $shortcut);
?>