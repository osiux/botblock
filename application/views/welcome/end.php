<div class="hero-unit">
    <?php if (isset($errors)) :?>
    <div class="alert alert-error"><p><?php echo implode('</p><p>', $errors); ?></p></div>
    <?php endif; ?>
    <h4>Resultado:</h4>
    <ul>
        <?php foreach ($result as $user => $success) : ?>
        <li><?php echo $user; ?>:<i class="icon-<?php echo $success ? 'ok' : 'remove' ; ?>"></i></li>
        <?php endforeach; ?>
    </ul>
    <p class="center"><a class="btn" href="<?php echo site_url('/'); ?>">Volver al inicio</a></p>
</div>