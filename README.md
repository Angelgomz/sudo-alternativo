

## Acerca de SudoCalendar:

<p>SudoCalendar en un sistema para administrar eventos de calendario, que esta sincornizado con la Api de Google, Google Calendar. 
Posee autenticación Oauth 2.0 de Google Auth y también cuenta con parametros OAuth 2.0 para el consumo de las api creadas para el mismo sistema.  </p>

### Requerimientos de Instalacion: 
 
 <p>Para el el despliegue de este sistema, se necesita ejecutar las migraciones de la BBDD. Y también a su vez la implementación de el paquete de Laravel conocido como Passport. 
 Para el comienzo debemos conectar nuestro sistema a la BBDD en nuestra caso utilizamos MySQL a traves de PHPmyadmin. (El archivo .env proporcionado cuenta con los parametros necesarios).
 Despues de asegurarse que la BBDD este creado y conectada a nuestro sistema, ejecutamos por consola (cmd) los siguientes comandos: </p>

 `` php artisan migrate 
 Vamos a nuestro gestor de bases de datos web y verificamos que las tablas de la bbdd esten creadas correctamente y proseguimos con el comando que instala el paquete de passport en nuestro proyecto
 ``  php artisan passport:install 

## License
MIT.