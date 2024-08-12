<?php
$target = '/home/meemcolart/public_html/storage/app/public'; 
$shortcut = '/home/meemcolart/public_html/public/cabuser/includes/uploads'; //Check this for shortcut
symlink($target, $shortcut);

// Custom server
// ln -s /home/forge/zogci.com/storage/app/public /home/forge/api.zogci.com/includes/uploads

// ln -s /home/forge/app.suaveapp.es/storage/app/public /home/forge/api.suaveapp.es/includes/uploads

// ln -s /home/forge/app.cheetahrides.com/storage/app/public /home/forge/api.cheetahrides.com/includes/uploads

// ln -s /home/forge/paikallistaksi.online/storage/app/public /home/forge/api.paikallistaksi.online/includes/uploads
?>