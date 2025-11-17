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

### Endpoints Implementados

**POST:**
/api/register
nombre, email, password, password_confirmation, perfil (opcional)
— Crea usuario y devuelve token inmediatamente


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
Migración que agrega el campo perfil → database/migrations/*_add_perfil_to_users_table.php  
Migración de personalización (renombrado y eliminación de columnas) → database/migrations/*_modify_users_table_*.php  
Configuración de Sanctum → config/sanctum.php y registro en app/Http/Kernel.php

---

### Resultados de las Pruebas:

Registro exitoso → HTTP 201 + token válido  
Login correcto → HTTP 200 + nuevo token  
Acceso a ruta protegida con token válido → HTTP 200  
Acceso sin token o con token inválido → HTTP 401 Unauthorized  
Logout → todos los tokens revocados correctamente

---

### Conclusiones

Se implementó exitosamente un microservicio de autenticación seguro, escalable y completamente funcional.
El sistema permite diferenciar roles mediante el campo perfil, base para futuros middlewares de autorización.
Todos los endpoints están protegidos con el estándar Bearer Token y cumplen con buenas prácticas REST.
El proyecto está versionado, documentado y listo para ser consumido por cualquier otro microservicio del ecosistema.Este desarrollo sienta las bases sólidas para la arquitectura completa de microservicios del sistema, garantizando seguridad, mantenibilidad y escalabilidad.



