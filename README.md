# Backend AfterWorkFun
[![Afterworkfun.gif](https://i.postimg.cc/mZ0gmyd1/Afterworkfun.gif)](https://postimg.cc/ThJxwgvT)

## Table of contents
  - [API Afterworkfun](#api-afterworkfun)
  - [Tech Stack🛠](#Tech-Stack)
  - [Requisitos 📋](#Descripcion-y-usabilidad)
  - [Relaciones🥨](#Relaciones)
  - [Endpoints⛩](#Endpoints)
  - [Variables de entorno🥑](#Variables-de-entorno)
  - [Middlewares🔐�](#Middlewares)
  - [Bases de datos🔗](#Comandos-utiles-iniciales)
  - [Como instalarlo 🥷](#Instalacion)
  - [Tareas Pendientes 🧙](#Tareas-pendientes)
  - [Autor🤘](#Autor)
  - [Como Ayudar🤝](#Como-ayudar)
  - [Agradecimientos💖](#Agradecimientos)

# Tech Stack 🛠

Se han utilizado las siguientes tecnologías:

<p align="left">     

  <a href="https://git-scm.com/" target="_blank" rel="noreferrer"> <img src="https://www.vectorlogo.zone/logos/git-scm/git-scm-icon.svg" alt="git" width="40" height="40"/> </a> 
  <a href="https://heroku.com" target="_blank" rel="noreferrer"> <img src="https://www.vectorlogo.zone/logos/heroku/heroku-icon.svg" alt="heroku" width="40" height="40"/> </a> 
  <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img height="50" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/mysql/mysql.png"> </a> 
  <a href="https://postman.com" target="_blank" rel="noreferrer"> <img src="https://www.vectorlogo.zone/logos/getpostman/getpostman-icon.svg" alt="postman" width="40" height="40"/> </a>
  <p align="left"> <a href="https://laravel.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain-wordmark.svg" alt="laravel" width="40" height="40"/> </a> <a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a>  </p>
  
</p>

# Descripción y usabilidad 📋

Proyecto del bootcamp en GeeksHubs dónde desde producción nos piden que realicemos el backend de una web app dónde los jugadores pueden crear salas de los videojuegos más famosos del mercado con el fin de chatear con otros jugadores que quieran jugar, unirse a otras salas ya creadas, escribir mensajes...
He seguido la filosofia git Flow creante una rama `develop` que ha sido dónde he desarrollado todo el backend, y ramas auxiliares como features para añadir funcionalidades sin afectar a la rama de desarrollo, una vez finalizada y comprobada la nueva funcionalidad, he mergeado a develop. Además, para organizarme mejor he utilizado `Trello` como metodologia Kanban, la cuál me ha ayudado mucho a organizar objetivos MVP, extras y tareas en progreso y ya realizadas.
A continuación cito los objetivos MVP del proyecto:

 - Los usuarios se tienen que poder registrar a la aplicación, estableciendo un usuario/contraseña.
 - Los usuarios tienen que autenticarse a la aplicación haciendo login.
 - Los usuarios tienen que poder crear Partídas (grupos) para un determinado videojuego.
 - Los usuarios tienen que poder buscar Partídas seleccionando un videojuego.
 - Los usuarios pueden entrar y salir de una Party.
 - Los usuarios tienen que poder enviar mensajes a la Party. Estos mensajes tienen que poder ser editados y borrados por su   usuario creador.
 - Los mensajes que existan en una Party se tienen que visualizar como un chat común.
 - os usuarios pueden introducir y modificar sus datos de perfil, por ejemplo, su usuario de Steam.
 - Los usuarios tienen que poder hacer logout de la aplicación web.
 
Extra: 
 - Middleware para los roles de usuario

Estos objetivos son los que he cumplido con este proyecto, y a continuación empiezo mostrando el diagrama Entidad-Relación utilizado:

[![ER-Afterworkfun.jpg](https://i.postimg.cc/tgcCx3w5/ER-Afterworkfun.jpg)](https://postimg.cc/zLnrmgJb)

Cómo podéis observar he realizado 5 entidades referenciadas como Users, Roles, Games, Parties y Messages, más dos tablas intermedias entre Users_roles y entre Users_parties.
- Tabla `Users`:  
Contiene los datos necesarios de los jugadores para registrarse en el sistema, que está relacionada con Roles, Parties y Messages.
- Tabla `Roles`:
Contiene los roles de los usuarios registrados en la base de datos, que son `player` y `admin`, al registrarse un usuario se le añade el role por defecto de player, mientras que solo los admins pueden asignar el role admin a otro player. He realizado un middleware del role admin para ese caso. Entre Roles y Users al ser una relacion N:M se genera una tabla intermedia dónde existen dos claves foráneas, una de users y otra de roles.
- Tabla `Games`:
Esta tabla es muy sencilla ya que solo contiene el nombre del videojuego popular al que se realiza la búsqueda de partidas, tiene un campo isActive para que en un futuro se pueda activar o desactivar el videojuego si no funciona o deja de estar en producción.
- Tabla `Parties`:
Contiene la información sobre las salas o "Parties", que es dónde se desarrolla la parte más importante, dónde los players pueden unirse o dejar la party, escribir, editar y borrar mensajes, y visualizar los mensajes de otros players que esten unidos a la misma. Como en roles, Parties tiene una relacion N:M con Users, por lo que se genera la tabla intermedia con las foráneas correspondientes, y además he realizado otra relación entre Users y Parties de 1:N para poder enlazar el usuario que ha creado la party.
- Tabla `Messages`:
Esta tabla contiene los mensajes que crean los usuarios, contiene la clave foránea de Users y de Parties, solo se pueden crear y visualizar mensajes los usuarios que estén unidos a esa party.

# Relaciones 🥨

Las relaciones entre las tablas son las siguientes:

```
- Users vs Roles N:M
- Users vs Parties 1:N
- Users vs Parties N:M
- Users vs Messages 1:N
- Games vs Parties 1:N
- Parties vs Messages 1:N 
```

# Endpoints ⛩

A continuación los endpoints de cada entidad y su modelo json para atacarlos con `Postman`: 

## Users

```json
{
      "nick": "userNick",
      "email": "userEmail@userDomain.com",
      "password": "userPassword",
      "steamUserName": "userName of Steam"
} 
```

* Get('/profile', [AuthController::class, 'profile']); Devuelve los datos del perfil del usuario que está logeado. 
* Get('/users', [UserController::class, 'getAllUsers']); Devuelve todos los usuarios registrados. / Sólo puede hacerlo un admin.
* Post('/register', [AuthController::class, 'register']); Introduciento el JSON modelo de arriba puedes registrarte. 
* Post('/login', [AuthController::class, 'login']); Introduciendo el email y la password en el body te devuelve un token.
```
{ 
  "email": "userEmail@userDomain.com",
  "password": "userPassword",
}
```
* Post('/logout', [AuthController::class, 'logout']); Introduciento el token por body te invalida el token, y te deslogea. { "token": "exampleToken"}
* Put('/profile/{id}', [UserController::class, 'updateUserProfile']); Introduciendo el id por path params te actualiza sólo el perfil del usuario logado.
* Delete('/users/{id}', [UserController::class, 'deleteUser']); Introduciento el id del usuario por path Params te borra el usuario. Solo puede hacerlo un admin.


## Games
```json
{
    "name": "League of legends"
}
```

* Get('/games', [GameController::class, 'getAllGames']); Devuelve todos los games.
* Post('/games', [GameController::class, 'createGame']); Introduciento el JSON modelo de arriba creas un nuevo game.
* Put('/games/{id}', [GameController::class, 'updateGame']); Introduciento el JSON de arriba y el id en path params puedes actualizar el nombre del juego
* Delete('/games/{id}', [GameController::class, 'deleteGame']); Introduciento el id por path params borras el juego. Solo lo puede hacer un admin.

## Parties

```json 
{
    "name": "PartyName",
    "game_id": 2 -> example game_id
}
```
* Post('/parties', [PartyController::class, 'createParty']); Introduciendo el modelo JSON en el body creas una nueva party.
* Get('/partiesbyuser', [PartyController::class, 'getPartiesByUserId']); Devuelve todas las parties del usuario logeado.
* Get('/partiesbygame/{id}', [PartyController::class, 'getPartiesByGame']); Introduciendo por path params el id del videojuego devuelve todas las parties de un videojuego
* Put('/parties/{id}', [PartyController::class, 'updateParty']); Introduciento el JSON y el id de la party por path params puedes actualizar la party, solo puedes actualizar las del propietario.
* Delete('/parties/{id}', [PartyController::class, 'deleteParty']); Introduciento el id de la party por path params la borras.
* Post('/joinparty/{id}', [PartyController::class, 'joinParty']); Introduciendo el id de la party por path params te unes.
* Post('/leaveparty/{id}', [PartyController::class, 'leaveParty']); Introduciento el id de la party por path params abandonas de la party.

## Messages
```json
{
    "message": "¿Jugamos unas partiditas?",
    "party_id": 18 <- ejemplo de partyId
}
```
* Get('/messagesfromparty/{id}', [MessageController::class, 'getAllMessagesFromParty']); Introduciendo el id de la party como path param te devuelve los mensajes de esa party, es necesario estar unido en la party.
* Post('/messages', [MessageController::class, 'createMessage']); Con el JSON de arriba obtienes todos los mensajes de la party, solo pueden hacerlo los players que esten unidos e la party en question.
* Put('/messages/{id}', [MessageController::class, 'updateMessage']); Introduciendo el id como path params puedes actualizar el mensaje, solo puede hacerlo el propietario del mensaje.
* Delete('/messages/{id}', [MessageController::class, 'deleteMessage']); Introduciendo el id del mensaje por path params borras el mensaje, solo puede hacerlo el propietario del mensaje.

## Admin

Estos endpoints solo pueden acceder si tienes el role admin:

* Post('/create-admin/{id}', [UserController::class, 'createAdmin']); Introduciendo el id del usuario le asignas el role admin.
* Delete('/delete-admin/{id}', [UserController::class, 'deleteRoleAdmin']); Introduciendo el id del usuario por path params le borras el role admin.

# Variables de entorno 🥑
Variables de entorno que he cambiado:
```
DB_PORT=3306
DB_DATABASE=afterworkfun
LOG_CHANNEL=daily
JWT_SECRET=[ExampleSecretKey]
```

# Middlewares 🔐

Hemos aislado funcionalidades para mejorar la organización y limpieza del código en una carpeta aparte llamada shared que contiene:

* He añadido de momento el middleware de IsAdmin para verificar en ciertos endpoints que el usuario tiene el role admin, para añadirle seguridad a los mismos y evitar que un usuario normal (player) pueda realizar acciones que perjudiquen a los demás jugadores o al administrador.



# Base de datos 🔗

He utilizado Eloquent como ORM para interactuar con la base de datos Mysql, en el caso de Laravel ya viene integrado por defecto en el framework.


# Comandos útiles iniciales 👀

Al clonar el repositorio, para poder probarlo sin problemas lo ideal es ejecutar primero las migraciones con el comando:
`php artisan migrate`

Este comando ejecutara las siguientes migraciones, con sus respectivas claves foráneas: 
- Creación de tabla usuarios
- Creación de tabla games
- Creación de tabla roles
- Creacion de tabla intermedia users_roles
- Creación de tabla parties
- Creación de tabla intermedia users_parties
- Creación de tabla messages

Además puedes utilizar el siguiente comando para ejecutar los siguientes Seeders para poblar la BD:
`php artisan db:seed`

Con este comando se crearán 5 players, 1 usuario con role admin, 5 games y 5 parties, únicamente será necesario escribir mensajes.

# Instalación 🥷

Para poder consumir el backend es necesario lo siguiente:
- Clonar o forkear el repositorio si deseas, **Alejandro:** _(https://github.com/AlexMonPe/AfterWorkFun)_.
- Instalar Composer: `https://getcomposer.org/download/`
- Hacer _composer install_ para cargar las dependencias del composer.json
- Atacar al API publicada en PONER ENLACE HEROKU o como localhost si lo prefieres (es necesario cambiarlo en el .env)
- Revisar esta documentación.
- Es necesario utilizar Postman para probar el Api ya que carece de Frontend.
- Conexión a internet

# Tareas pendientes 🧙

  - [ ] Crear el FrontEnd del API
  - [ ] Crear middleware del campo isActive.
  - [ ] Documentar con swagger.

# Autor 🤟

* public function Alejandro (Portfolio) => https://github.com/AlexMonPe ⭕

# Como ayudar 🤝
  
  - Si deseas colaborar con éste proyecto u otro no dudes en contactar con nosotros o solicitar una pull request.
  - Mi correo electrónico _alex_bcn10@hotmail.es_
  - Cualquier aporte se puede recompensar con una cerveza o café, prefiero cerveza.

# Agradecimientos 💖

  * A nuestro profesor Dani Tarazona, por su paciencia y su dedicación.
  * Repositorio público con código libre con el fin de seguir promoviendo compartir conocimientos y ayudar a otros programadores.
