# ID Sports 🏟️

Plataforma de reservaciones deportivas para Querétaro, México. PHP MVC puro, MySQL, Tailwind CSS.

## Requisitos
- PHP 7.4+ con extensiones: pdo, pdo_mysql, json, mbstring, session
- MySQL 5.7+ / MariaDB 10.3+
- Apache 2.4+ con `mod_rewrite` habilitado

## Instalación rápida

```bash
# 1. Clonar en DocumentRoot (o configurar VirtualHost)
git clone https://github.com/danjohn007/ID-Sports.git /var/www/idsports
cd /var/www/idsports

# 2. Crear base de datos
mysql -u root -p -e "CREATE DATABASE id_sports CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p id_sports < database/schema.sql

# 3. Configurar credenciales DB
nano config/config.php   # editar DB_HOST, DB_USER, DB_PASS, DB_NAME

# 4. Verificar entorno
curl http://localhost/test_connection.php

# 5. Iniciar sesión
# admin@idsports.mx / Admin1234
# juan@gmail.com / User1234
```

## Apache VirtualHost

```apache
<VirtualHost *:80>
    ServerName idsports.local
    DocumentRoot /var/www/idsports
    <Directory /var/www/idsports>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Habilitar: `sudo a2enmod rewrite && sudo systemctl restart apache2`

## Roles
| Rol | Descripción |
|-----|-------------|
| `super_admin` | Gestión global, clubes, comisiones, config |
| `club_admin` | Dashboard del club, espacios, horarios, amenidades |
| `user` | Buscar, reservar, historial |

## Credenciales de prueba
| Email | Contraseña | Rol |
|-------|-----------|-----|
| admin@idsports.mx | Admin1234 | super_admin |
| club@deportivoqueretaro.mx | Admin1234 | club_admin |
| juan@gmail.com | User1234 | user |
App Móvil de control de acceso a espacios deportivos 
