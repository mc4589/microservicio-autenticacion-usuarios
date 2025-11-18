# Implementación de Autenticación con Laravel Sanctum  
## Microservicio de Gestión de Usuarios

### GRUPO 4

**Integrantes del grupo:**
1. Sandy Mariño  
2. Carlos Fernández  
3. Jonathan Hernández
4. Marco Chacón
5. Carlos Cantuña  
6. Sergio Condo



---

### Objetivo
Implementar un sistema de autenticación basado en tokens utilizando **Laravel Sanctum** en el microservicio de Gestión de Usuarios, permitiendo que otros microservicios validen solicitudes según el perfil del usuario:  
`administrador` | `editor` | `usuario`
Este microservicio será consumido por otros módulos del sistema para validar permisos y autenticar solicitudes.

---

### Tecnologías utilizadas
- Laravel 11.x
- Laravel Sanctum (API tokens)
- MySQL + phpMyAdmin
- Postman / Thunder Client (pruebas)
- Git & GitHub

---

### Estructura Final de la Tabla `users`

Campo | Tipo | Descripción
------|------|------------
`id` | BIGINT UNSIGNED (PK) | Identificador del usuario
`name` | VARCHAR(255) | Nombre del usuario
`email` | VARCHAR(255) UNIQUE | Correo electrónico
`email_verified_at` | TIMESTAMP NULL | Fecha de verificación
`password` | VARCHAR(255) | Contraseña en hash
`perfil` | ENUM('administrador','editor','usuario') DEFAULT 'usuario' | Rol del usuario
`remember_token` | VARCHAR(100) NULL | Token de sesión
`created_at` | TIMESTAMP NULL | Fecha de creación
`updated_at` | TIMESTAMP NULL | Fecha de actualización


**POST:**
/api/login
email, password
—Autentica usuario y genera nuevo token

**GET:**
/api/user
Authorization: Bearer <token>
Devuelve datos del usuario autenticado
-id             bigint unsigned AUTO_INCREMENT PRIMARY KEY
- nombre          varchar(255)
- email           varchar(255) UNIQUE
- password + su perfil

  
**POST:**
/api/logout
Authorization: Bearer <token>
Revoca todos los tokens del usuario autenticado 

---

### 1. Clonar el repositorio
git clone https://github.com/TU-USUARIO/microservicio-autenticacion-usuarios.git
cd microservicio-autenticacion-usuarios

### 2. Instalar dependencias
composer install

### 3. Crear archivo .env
cp .env.example .env

Configurar MySQL:
DB_DATABASE=usuarios
DB_USERNAME=root
DB_PASSWORD=

### 4. Generar la APP_KEY
php artisan key:generate

### 5. Ejecutar migraciones
php artisan migrate

---

### Endpoints principales (Laravel Sanctum)

### Registro
POST /api/register

### Inicio de sesión
POST /api/login

### Cerrar sesión
POST /api/logout

### Obtener usuario autenticado
GET /api/user

---

### Flujo Completo de Autenticación
El flujo de trabajo diseñado es el siguiente:

**Registro o inicio de sesión:** El cliente envía las credenciales a las rutas públicas /register o /login.  
**Validación y generación de token:** El controlador verifica los datos, crea o recupera el usuario y genera un token con $user->createToken('auth_token')->plainTextToken.  
**Almacenamiento seguro del token:** El cliente guarda el token (localStorage, SecureStorage, etc.).  
**Consumo de rutas protegidas:** Todas las peticiones posteriores incluyen el header Authorization: Bearer <token>.  
**Validación automática:** El middleware auth:sanctum verifica la validez del token y carga el usuario en $request->user().  
**Cierre de sesión:** Al ejecutar /logout, se borran todos los tokens del usuario ($request->user()->tokens()->delete()), garantizando que ningún token anterior siga siendo válido.

---

### Ubicación de los Archivos

ClaveModelo del usuario → app/Models/User.php  
Controlador de autenticación → app/Http/Controllers/Api/UserController.php  
Definición de rutas API → routes/api.php  
Migración base de usuarios → database/migrations/2014_10_12_000000_create_users_table.php  
Migración que agrega el campo perfil → database/migrations/*_create_perfil_table.php  

---

### Resultados de las Pruebas:

Registro exitoso → HTTP 201 + token válido  
Login correcto → HTTP 200 + nuevo token  
Acceso a ruta protegida con token válido → HTTP 200  
Acceso sin token o con token inválido → HTTP 401 Unauthorized  
Logout → todos los tokens revocados correctamente

---

### Conclusiones

Este microservicio permite:

-Crear usuarios

-Generar tokens de acceso

-Validar tokens en otros microservicios

-Gestionar sesiones con Sanctum

-Asignar y verificar roles (perfil)

Está diseñado para integrarse dentro de un sistema de microservicios, sirviendo únicamente como autoridad de autenticación.



