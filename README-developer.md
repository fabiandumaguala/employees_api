# Nombre de tu Aplicación

Breve descripción de lo que hace tu aplicación.

## Requisitos

Antes de correr la aplicación, asegúrate de tener instalados los siguientes requisitos:

- [PHP](https://www.php.net/manual/es/install.php) (versión mínima recomendada)
- [Composer](https://getcomposer.org/doc/00-intro.md)
- [MySQL](https://dev.mysql.com/doc/mysql-getting-started/en/) (u otro sistema de gestión de bases de datos compatible)

## Instalación

Sigue estos pasos para configurar y correr la aplicación localmente:

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/fabiandumaguala/employees_api.git
   cd turepositorio
   ```

2. **Instala las dependencias con Composer:**

   ```bash
   composer install
   ```

3. **Copia el archivo `.env.example` a `.env`:**

   ```bash
   cp .env.example .env
   ```
4. **Configura la base de datos POSTGRESQL:**

    ```bash
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=laravel
    DB_USERNAME=laravel
    DB_PASSWORD=laravel
    ```

5. **Genera la clave de aplicación de Laravel:**

   ```bash
   php artisan key:generate
   ```

6. **Genera la clave de JWT:**

   ```bash
   php artisan jwt:secret
   ```

7. **Ejecuta las migraciones para crear las tablas en la base de datos:**

   ```bash
   php artisan migrate
   ```

8. **Corre el servidor de desarrollo:**

   ```bash
   php artisan serve
   ```

9. **Accede a la aplicación:**

   Abre tu navegador y ve a `http://localhost:8000`.

## Uso

Puedes usar las siguentes rutas:

POST api/auth/login             //iniciar sesion
POST api/auth/signup            //registro de usuarios
GET api/employee                //listar empleados
GET api/employee/{employee}     //ver 1 empleado
PUT api/employee/{employee}     //actualizar empleado
DELETE api/employee/{employee}  //eliminar empleado

o puedes usar el comando de artisan:
php artisan route:list
