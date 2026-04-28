# ID Sports 🏟️

Plataforma de reservaciones deportivas para Querétaro, México. PHP MVC puro, MySQL, Tailwind CSS.

## Requisitos
- PHP 7.4+ con extensiones: pdo, pdo_mysql, json, mbstring, session, fileinfo
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

# 3. Aplicar migración de onboarding (si actualizas desde versión anterior)
mysql -u root -p id_sports < database/migration_onboarding.sql

# 4. Configurar credenciales DB
nano config/config.php   # editar DB_HOST, DB_USER, DB_PASS, DB_NAME

# 5. Verificar entorno
curl http://localhost/test_connection.php

# 6. Iniciar sesión
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

---

## Changelog

### v1.1 — Sistema de diseño Glassmorphism + Onboarding

#### 🎨 Sistema de diseño (Design System)

Se adoptó un motor de temas de acento único con las siguientes reglas:

| Regla | Detalle |
|-------|---------|
| **Paleta base inmutable** | Fondos: `#060B19 → #111827`. Textos: blanco `#fff` y pizarra `#94a3b8`. Nunca alterables por admin. |
| **Color de acento único** | Solo `--primary` / `--btn-color` son configurables por el Super Admin. |
| **Uso restringido del acento** | Solo en: botones CTA, indicadores activos, bordes hover, resplandores (glow). **Nunca** en fondos ni textos de lectura. |
| **Texto en botones primarios** | Siempre `color: #ffffff !important` para garantizar contraste WCAG AA sin importar el color elegido. |
| **Glassmorphism** | `backdrop-filter: blur(24px) saturate(1.6)` en la tarjeta de login y panel de controles del onboarding. Bordes `1px solid rgba(255,255,255,0.08)`. |
| **Tipografía** | Títulos: `Jockey One` (uppercase). Cuerpo: `Poppins` 300/400/500/600/700 (reemplaza Inter). |

#### 🚀 Onboarding (`/auth/onboarding`)

- Carrusel de 3 slides a pantalla completa con degradados profundos `#060B19`
- **Fix crítico**: el texto de descripción ya no queda oculto detrás del panel de controles. El `padding-bottom` del contenido se aumentó a `230px` para despejarse completamente del panel fijo inferior.
- Panel de controles con **glassmorphism** (`backdrop-filter: blur(24px)` + borde `rgba(255,255,255,0.07)`)
- Orbe de resplandor de color primario en cada slide (`ob-slide-bg-glow`) — reacciona al color elegido por el admin
- Indicadores (dots) con glow effect al activarse (`box-shadow: 0 0 10px var(--primary-color)`)
- Logo en pastilla glassmorphism (no usa color primario como fondo)
- Accesible directamente en `/auth/onboarding` en cualquier momento (sin auto-redirect si ya fue visto)
- Link "🎬 Ver introducción" en la pantalla de login para volver al onboarding

#### 🔐 Pantalla de Login / Registro

- **Fondo**: gradiente profundo `#060B19 → #111827` + resplandor radial superior basado en el color primario del admin (calculado desde PHP como `rgba(R,G,B,0.22)`)
- **Título "ID SPORTS"**: texto gigante (Jockey One, `clamp(5rem, 20vw, 13rem)`) en el fondo con glow del color primario — imposing watermark
- **Logo**: pastilla glassmorphism neutral (blanco/transparente, sin usar el color primario)
- **Tarjeta inferior** (`auth-sheet-inner`): glassmorphism con `backdrop-filter: blur(28px)`, fondo `rgba(15,18,30,0.82)`, borde `rgba(255,255,255,0.08)`
- Botón "Entrar" / "Registrarme": siempre texto blanco forzado (`!important`)
- Botones sociales (Google/Apple/Facebook): glassmorphism neutral, sin color primario
- Campos de formulario: glass sutil `rgba(255,255,255,0.05)` con focus ring del color primario

#### 🖼️ Logo de empresa (subida de archivo)

Los Super Admins pueden subir el logo de la empresa desde **Config → General**:

- Formatos aceptados: PNG, JPG, SVG, WEBP (verificado por MIME type, no extensión)
- Máximo 2 MB
- Se guarda como `public/assets/logo_custom.<ext>` y se registra en `config` como `app_logo_path`
- El logo aparece automáticamente en la pantalla de login y en el onboarding
- Ruta: `POST /config/upload-logo`

#### 🗃️ Base de datos

- `ALTER TABLE users ADD COLUMN state VARCHAR(100) DEFAULT NULL` — campo Estado/Provincia opcional
- Migración: `database/migration_onboarding.sql`
- Contraseña mínima: 6 → **8 caracteres**
- Expiración OTP: 10 → **15 minutos**

#### ⚙️ Config Panel (Super Admin)

| Ruta | Descripción |
|------|-------------|
| `config/general` | Configuración general + **subida de logo** |
| `config/colors` | Colores + URL imagen de fondo del login |
| `config/onboarding` | Editar títulos, descripciones e imágenes de cada slide |
