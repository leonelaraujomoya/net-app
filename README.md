# net-app

## Contenido

### Trabajo práctico de la materia Desarrollo de Software - Universidad de Oriente

Este proyecto corresponde a una aplicación para la visualización de videos educativos de youtube.

##### Elaborado por:

- Leonel Araujo
- Robson Gutierrez
- Federico Texeira

La aplicación está desarrollada en ****Laravel 8**** (backend) y ****VueJS 3**** (frontend), consumiendo la api ****Youtube Data API v3**** de ****Google****, y la base de datos ****MySQL**** para el registro de los usuarios.

### Cómo clonar
Si deseas hacer una copia de este proyecto en tu equipo, escribe el siguiente comando desde tu consola ****git clone https://github.com/leonelaraujomoya/net-app.git****

### Instalación
Para instalar y ejecutar este proyecto de forma local, es necesario seguir los siguientes pasos:

1.  Clonamos el repositorio en la carpeta de su preferencia.
2. Crea una base de datos con el nombre ****net_app****.
3. Entra desde la consola a la carpeta ***net-app***.
4. renombra el archivo ****env.example**** a ****.env**** y configura en su interior las credenciales necesarias para conectarte a la base de datos (***DB_USERNAME*** y ***DB_PASSWORD***).
5.  Para ejecutar el siguiente paso es necesario tener instalado ****Composer**** en su computadora. Estando en la carpeta ***/net-app*** ejecute ****composer install****.
6. Ejecuta ahora ****php artisan key:generate****
7.  Para ejecutar el siguiente paso es necesario tener instalado ****NodeJS**** en su computadora. Ejecute ****npm install****.
8. Ejecuta ****npm run dev****
9. Ejecuta ****php artisan migrate**** para que se creen las tablas necesarias en la base de datos ****net_app****.

### Ejecutar la aplicación
Debes tener dos (2) consolas abiertas, una para ejecutar el backend y la otra para el frontend.

****Backend:**** desde la carpeta ***net-app*** ejecutas ****php artisan serve****

****Frontend:**** Desde la carpeta ***net-app*** ejecutas ****npm start****

Desde el navegador vas a http://localhost:8000/, te registras para poder loguearte.
