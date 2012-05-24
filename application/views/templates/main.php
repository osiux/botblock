
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>BotBlock</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <?php print_css(array('bootstrap', 'bootstrap-responsive','core')); ?>

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
         <script type="text/javascript">
         var RecaptchaOptions = {
            theme : 'clean',
            lang: 'es'
         };
         </script>

        <?php print_js(array('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', 'bootstrap.min','jquery.form', 'core')); ?>
    </head>

    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="<?php echo site_url('/'); ?>">BotBlock</a>
                    <div class="">
                        <ul class="nav">
                            <li<?php echo !$this->uri->segment(1) ? ' class="active"': '' ; ?>><a href="<?php echo site_url('/'); ?>">Inicio</a></li>
                            <li<?php echo $this->uri->segment(1) == 'about' ? ' class="active"': '' ; ?>><a href="<?php echo site_url('about'); ?>">Acerca de</a></li>
                        </ul>
                        <?php if ($user) : ?>
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img height="20" src="<?php echo $user->profile_image_url; ?>" alt="<?php echo $user->name; ?>" />&nbsp;<?php echo $user->name; ?>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo site_url('logout'); ?>">Cerrar Sesión</a><li>
                                </ul>
                            </li>
                        </ul>
                        <?php endif; ?>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">
            <?php echo $content; ?>
        </div> <!-- /container -->
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-32104919-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </body>
</html>
