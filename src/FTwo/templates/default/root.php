<!DOCTYPE html>
<html lang="<?php echo $this->getVar('language'); ?>">
    <head>
        <?php $this->inc('head'); ?>
    </head>
    <?php $this->inc('body', ['title'=>'Super title']); ?>
    <?php $this->inc('tracking'); ?>
</html>
