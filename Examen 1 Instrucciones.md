# Examen 1: Instrucciones

Aplicacion Laravel para registrar, listar y enfrentar humanos farmeadores de aura.

## Requisitos

- PHP 8.3 o superior.
- Composer.
- MySQL con MAMP u otro servidor MySQL, o SQLite.
- El proyecto debe ejecutarse desde `C:\Arqui\laravelcourse`.

No es necesario ejecutar NPM, Vite ni `npm install`. Los estilos se cargan mediante Bootstrap CDN.

## Instalacion

Abrir PowerShell y ejecutar:

```powershell
cd C:\Arqui\laravelcourse
composer install
```

Si el archivo `.env` no existe, crearlo a partir del ejemplo:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

## Opcion 1: MySQL con MAMP

El archivo `.env` esta configurado para MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelcourse
DB_USERNAME=root
DB_PASSWORD=root
```

1. Abrir MAMP.
2. Iniciar MySQL.
3. Crear una base de datos llamada `laravelcourse`.
4. Confirmar que el puerto, usuario y contrasena coincidan con `.env`.

Apache de MAMP no es necesario si se utiliza el servidor integrado de Laravel.

Ejecutar las migraciones y los datos de prueba:

```powershell
php artisan optimize:clear
php artisan migrate:fresh --seed
```

`migrate:fresh` elimina y vuelve a crear las tablas. `--seed` ejecuta `DatabaseSeeder`, que crea productos y cinco humanos ficticios.

## Opcion 2: SQLite

Esta alternativa no necesita MAMP ni MySQL.

Crear el archivo de base de datos:

```powershell
New-Item database\database.sqlite -ItemType File -Force
```

Modificar `.env`:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
CACHE_STORE=file
SESSION_DRIVER=file
```

Luego ejecutar:

```powershell
php artisan optimize:clear
php artisan migrate:fresh --seed
```

## Iniciar la aplicacion

Desde la carpeta del proyecto:

```powershell
php artisan serve
```

Abrir en el navegador:

```text
http://127.0.0.1:8000
```

## Rutas principales

| Metodo | Ruta | Nombre | Funcion |
|---|---|---|---|
| GET | `/` | `home.index` | Muestra la zona de inicio con los tres enlaces del examen. |
| GET | `/humans/create` | `human.create` | Muestra el formulario para registrar un humano. |
| POST | `/humans` | `human.store` | Valida y guarda un humano en la base de datos. |
| GET | `/humans` | `human.index` | Lista los humanos ordenados por aura descendente. |
| GET | `/humans/battle` | `human.battle` | Muestra los dos humanos con mayor aura y el resultado de la batalla. |

Tambien se puede acceder directamente mediante:

```text
http://127.0.0.1:8000/
http://127.0.0.1:8000/humans/create
http://127.0.0.1:8000/humans
http://127.0.0.1:8000/humans/battle
```

## Como probar el ejercicio

### 1. Zona de inicio

Entrar a `/` y comprobar que aparecen tres enlaces:

1. Registrar humanos.
2. Listar humanos.
3. Batalla de humanos.

### 2. Registrar un humano

Entrar a `/humans/create` y completar:

- Nombre.
- Cantidad de aura, como entero mayor o igual a cero.
- Jerarquia: `común`, `moderado` o `legendario`.

El formulario utiliza `@csrf` y la validacion se ejecuta en `StoreHumanRequest`. Al guardar correctamente, redirige al listado.

### 3. Listar humanos

Entrar a `/humans` y comprobar que:

- Se muestran id, nombre, cantidad de aura y jerarquia.
- Los humanos aparecen de mayor a menor cantidad de aura.
- Los humanos `legendario` muestran `Boff` junto al nombre.
- La cantidad de aura de los humanos `común` aparece en azul.

### 4. Batalla de humanos

Entrar a `/humans/battle` y comprobar que:

- Se muestran dos humanos.
- Se muestra el nombre y aura de cada uno.
- Gana el humano con mayor aura.
- Si ambos tienen la misma aura, aparece el mensaje de empate.
- Si hay menos de dos humanos, aparece un mensaje indicando que no se puede iniciar la batalla.

La implementacion selecciona los dos humanos con mayor aura. Si tienen la misma aura, se prioriza el registro con menor `id`.

## Comandos de verificacion

Ejecutar las pruebas funcionales:

```powershell
php artisan test
```

Ejecutar solamente las pruebas del examen:

```powershell
php artisan test --filter=HumanTest
```

Verificar las rutas de Humanos:

```powershell
php artisan route:list --name=human
```

El resultado esperado incluye:

```text
GET|HEAD  humans          human.index
POST      humans          human.store
GET|HEAD  humans/battle   human.battle
GET|HEAD  humans/create   human.create
```

Verificar que las vistas Blade compilen correctamente:

```powershell
php artisan view:cache
```

Verificar el formato de los archivos principales:

```powershell
vendor\bin\pint --test app\Models\Human.php app\Http\Requests\StoreHumanRequest.php app\Services\HumanService.php app\Http\Controllers\HumanController.php database\migrations\2026_09_09_000000_create_humans_table.php database\factories\HumanFactory.php tests\Feature\HumanTest.php
```

## Archivos principales

- `database/migrations/2026_09_09_000000_create_humans_table.php`: crea la tabla `humans`.
- `app/Models/Human.php`: representa un humano mediante Eloquent.
- `app/Http/Requests/StoreHumanRequest.php`: contiene las validaciones del formulario.
- `app/Services/HumanService.php`: contiene la logica de ordenamiento, registro y batalla.
- `app/Http/Controllers/HumanController.php`: coordina las solicitudes y respuestas.
- `resources/views/home/index.blade.php`: zona inicial.
- `resources/views/human/create.blade.php`: formulario de registro.
- `resources/views/human/index.blade.php`: listado de humanos.
- `resources/views/human/battle.blade.php`: pantalla de batalla.
- `database/factories/HumanFactory.php`: genera datos ficticios.
- `database/seeders/DatabaseSeeder.php`: ejecuta los datos iniciales.
- `tests/Feature/HumanTest.php`: pruebas funcionales del examen.
