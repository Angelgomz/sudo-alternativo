

## Acerca de SudoCalendar:

<p>SudoCalendar en un sistema para administrar eventos de calendario, que esta sincornizado con la Api de Google, Google Calendar. 
Posee autenticación Oauth 2.0 de Google Auth y también cuenta con parametros OAuth 2.0 para el consumo de las api creadas para el mismo sistema.  </p>



### Requerimientos de Instalacion: 
 
 <p>Para el el despliegue de este sistema, se necesita ejecutar las migraciones de la BBDD. Y también a su vez la implementación de el paquete de Laravel conocido como Passport. 
 Para el comienzo debemos conectar nuestro sistema a la BBDD en nuestra caso utilizamos MySQL a traves de PHPmyadmin. (El archivo .env proporcionado cuenta con los parametros necesarios).
 Despues de asegurarse que la BBDD este creado y conectada a nuestro sistema, ejecutamos por consola (cmd) los siguientes comandos: </p>

 ` php artisan migrate ` 
 <br>
 Vamos a nuestro gestor de bases de datos web y verificamos que las tablas de la bbdd esten creadas correctamente y proseguimos con el comando que instala el paquete de passport en nuestro proyecto
 <br>
 ` php artisan passport:install` 



Por acá el link de documentación con postman de las apis:
https://bold-escape-707955.postman.co/workspace/My-Workspace~682717e6-09b5-42d2-8a00-2474eae87593/documentation/8925996-41bd5082-e346-4e3d-9cfd-1fff988c9a45
