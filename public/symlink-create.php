<?php
$targetFolder = '/home/validmag21f/laravel/mtserviciiexterne/storage/app/uploads';
$linkFolder = '/home/validmag21f/laravel/mtserviciiexterne/public/storage';
symlink($targetFolder, $linkFolder);
echo 'Symlink process successfully completed';
?>
