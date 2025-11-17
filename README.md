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

---

### Tecnologías utilizadas
- Laravel 11.x
- Laravel Sanctum (API tokens)
- MySQL + phpMyAdmin
- Postman / Thunder Client (pruebas)
- Git & GitHub

---

### Estructura final de la tabla `users`

```sql
id              bigint unsigned AUTO_INCREMENT PRIMARY KEY
nombre          varchar(255)
email           varchar(255) UNIQUE
password        varchar(255)
perfil          enum('administrador','editor','usuario') DEFAULT 'usuario'
remember_token  varchar(100) NULL
created_at      timestamp NULL
updated_at      timestamp NULL

Endpoints ImplementadosMétodo
URL
Cuerpo (x-www-form-urlencoded)
Header Requerido
Descripción
POST
/api/register
nombre, email, password, password_confirmation, perfil (opcional)
—
Crea usuario y devuelve token inmediatamente
POST
/api/login
email, password
—
Autentica usuario y genera nuevo token
GET
/api/user
(sin cuerpo)
Authorization: Bearer <token>
Devuelve datos del usuario autenticado + su perfil
POST
/api/logout
(sin cuerpo)
Authorization: Bearer <token>
Revoca todos los tokens del usuario autenticado

##Flujo Completo de Autenticación
El flujo de trabajo diseñado es el siguiente:
**Registro o inicio de sesión:** El cliente envía las credenciales a las rutas públicas /register o /login.  
**Validación y generación de token:** El controlador verifica los datos, crea o recupera el usuario y genera un token con $user->createToken('auth_token')->plainTextToken.  
**Almacenamiento seguro del token:** El cliente guarda el token (localStorage, SecureStorage, etc.).  
**Consumo de rutas protegidas:** Todas las peticiones posteriores incluyen el header Authorization: Bearer <token>.  
**Validación automática:** El middleware auth:sanctum verifica la validez del token y carga el usuario en $request->user().  
**Cierre de sesión:** Al ejecutar /logout, se borran todos los tokens del usuario ($request->user()->tokens()->delete()), garantizando que ningún token anterior siga siendo válido.

