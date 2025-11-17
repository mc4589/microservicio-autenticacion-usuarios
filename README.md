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
