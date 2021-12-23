<?php
$targetFolder = '/home/your_account/your_project_src/storage/app/public';
$linkFolder = '/home/your_account/your_domain.com/storage';
symlink($targetFolder, $linkFolder);
echo 'Symlink process successfully completed';
?>
