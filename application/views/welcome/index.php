<div class="hero-unit">
    <?php if ($template['user']) : ?>
    <form class="well" method="post" action="<?php echo site_url('/'); ?>">
        <?php if (isset($error)) : ?>
        <div class="alert alert-error"><p><?php echo implode('</p><p>', $error); ?></p></div>
        <?php endif; ?>
        <label for="users">Usuarios y/o listas</labeL>
        <span class="help-block">Escribe usuarios (<em>usuario</em>, <em>@usuario</em> o <em>https://twitter.com/#!/usuario</em>) y/o listas de twitter (<em>https://twitter.com/#!/usuario/nombrelista</em> o <em>usuario/nombrelista</em>), uno por linea, y seran bloqueados y reportados como spam desde tu cuenta.</span>
        <textarea cols="164" rows="20" name="users" id="users"><?php echo $users; ?></textarea>
        <!--<label class="checkbox" for="report">
            <input type="checkbox" name="report" value="1" id="report"<?php echo $report == 1 ? ' checked="checked"' : ''; ?>> Reportar como spam.
        </label>-->
        <?php echo recaptcha_get_html(config_item('recaptcha_public_key')); ?>
        <p class="right"><input type="submit" name="send" value="Enviar" class="btn btn-primary" /></p>
    </form>
    <?php else : ?>
    <p class="center"><a href="<?php echo site_url('auth'); ?>"><?php print_img('sign-in-with-twitter.png'); ?></a></p>
    <?php endif; ?>
</div>

<div class="row">
    <div class="span12">
        <h2>¿Por qué?</h2>
        <p>Todos odiamos el spam. Peor el spam político. Al encontrar un bot podemos reportarlo, pero... ¿por qué no hacerlo más sencillo? Partiendo de la colección de bots obtenida por <a href="http://www.reddit.com/user/santiesteban">santiesteban</a> y publicada <a href="http://santiesteban.org/adiosbots/">aquí</a>, me di a la tarea de crear este sitio que hace todo el proceso más sencillo.</p>
        <p><a class="btn" href="<?php echo site_url('about'); ?>">Ver detalles &raquo;</a></p>
    </div>
</div>