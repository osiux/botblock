<div class="hero-unit">
    <h2>¿Por qué?</h2>
    <p>Todos odiamos el spam. Peor el spam político. Al encontrar un bot podemos reportarlo, pero... ¿por qué no hacerlo más sencillo? Partiendo de la colección de bots obtenida por <a href="http://www.reddit.com/user/santiesteban">santiesteban</a> y publicada <a href="http://santiesteban.org/adiosbots/">aquí</a>, me di a la tarea de crear este sitio que hace todo el proceso más sencillo.</p>
    <h2>¿Cómo funciona?</h2>
    <p>Primero tienes que conectar tu cuenta de twitter con el sitio. Una vez hecho esto, debes escribir una lista de usuarios y/o listas de usuarios usando cualquiera de los siguientes formatos:</p>
    <ul>
        <li><strong>usuario</strong>: El usuario. Puede llevar el símbolo @ antepuesto.</li>
        <li><strong>https://twitter.com/#!/usuario</strong>: La url de el usuario tal cual la copias de la barra de direcciones.</li>
        <li><strong>usuario/nombrelista</strong>: La lista compuesta de usuario/nombredelalista. Puede llevar el símbolo @ antepuesto.</li>
        <li><strong>https://twitter.com/#!/usuario/nombrelista</strong>: La url de la lista tal cual la copias de la barra de direcciones.</li>
    </ul>
    <p>Una vez hecho esto, envías el formulario y un ejército de monos altamente capacitados se encargaran de tratar todo ese texto y obtener todos los usuarios, para entonces usando la <a href="https://dev.twitter.com/docs/api">API</a> de twitter, proceder a bloquearlos y reportarlos como spam desde tu cuenta.</p>
    <h2>¿Es seguro?</h2>
    <p>Cuando conectas tu cuenta con el sitio, te pedimos permisos de lectura y escritura. El de lectura es el permiso mínimo necesario de cualquier aplicación que usa la API de twitter, y el de escritura es solamente para poder reportar los bots como spam. En ningun momento guardamos tus credenciales. En teoría tampoco debes preocuparte porque twitter haga algo a tu cuenta, la <a href="https://dev.twitter.com/docs/api/1/post/report_spam">función</a> usada por el momento no tiene ninguna restricción de uso.</p>
</div>