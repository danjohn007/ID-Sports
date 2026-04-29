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

---

### v1.2 — Módulos 2 y 3: Dashboard de Usuario, Búsqueda, Detalle de Cancha y Club

#### 📱 Módulo 2 — Dashboard / Inicio (Home)

| Sección | Descripción |
|---------|-------------|
| **RF2.1 Cabecera** | Avatar circular, saludo "Hola, [Nombre]" en Jockey One, campana de notificaciones con drawer |
| **RF2.2 Reserva de Hoy** | Solo aparece si hay reserva activa para **hoy** (status `confirmed`/`active`, end_time > NOW()). Botón "Ver QR de Acceso" abre un modal con el código QR generado al confirmar la reserva |
| **RF2.3 Reservar por Día** | 5 píldoras (hoy + 4 días) más grandes y llamativas; muestra espacios disponibles cruzando `spaces` y `schedules`; redirige a búsqueda filtrando por fecha |
| **RF2.4 Deportes** | Grid 6 columnas con iconos SVG por deporte; clic filtra búsqueda por `?sport=<tipo>` |
| **RF2.5 Clubes Seguidos** | Sustituye sección de ofertas; muestra clubes que el usuario sigue via `club_memberships`; estado vacío con CTA "Explorar clubes" |
| **RF2.6 Cerca de ti** | Glassmorphism cards; GPS via Web API → coordenadas al backend; orden por distancia |
| **Mis Reservaciones** | Solo muestra reservaciones activas/futuras (date >= hoy, status != cancelado); click en una fila abre modal QR con detalle completo; badges diferenciados: **En curso** (verde), **Próxima** (azul), **Pendiente** (amarillo) |

#### 🔍 Módulo 3 — Búsqueda de Canchas

- Cards sin botón "Reservar" — solo **"Ver detalle"** para flujo correcto
- Nombre del club es enlace directo al detalle del club
- Filtros: texto libre, tipo de deporte (chips), fecha
- Sin emojis; colores completamente via CSS variables

#### 🏟️ Detalle de Cancha (`/spaces/detail/{id}`)

- Hero con gradiente por deporte o foto de cancha
- Calendario de 5 días + slots de hora generados dinámicamente según horarios del club
- Selector de duración (1-3 h) con cálculo de precio en tiempo real
- Amenidades con selector de cantidad
- Botón **Seguir / Siguiendo** el club (AJAX `POST /clubs/toggle-follow/{id}`)
- Enlace al panel del club

#### 🏟️ Detalle de Club (`/clubs/detail/{id}`)

- Canchas agrupadas por deporte con cabecera de color por tipo
- Carrusel de fotos por cancha (hasta 5)
- Botón **Seguir / Siguiendo** (AJAX); estado guardado en `club_memberships`
- Reseñas de usuarios
- Botones de contacto: WhatsApp y Google Maps

#### 🔧 Backend

| Archivo | Cambio |
|---------|--------|
| `ClubController` | `toggleFollow` — AJAX endpoint `POST clubs/toggle-follow/{id}` |
| `ReservationModel` | `getActiveForUser()` — solo reservas activas/futuras (MySQL 5.7 compatible) |
| `ClubMembershipModel` | **Bug fix**: `isMember()` ahora compara `!== false` (PDO `fetch()` devuelve `false`, no `null`) |
| `SpaceModel` | `getAvailableSlots()` — cruza horarios y reservas existentes |
| `ReviewModel` | `findByClub()` — reseñas agrupadas por club |

#### 🗃️ Base de datos (MySQL 5.7 compatible)

Migración: `database/migration_v3_mysql57.sql`

- Usa `INFORMATION_SCHEMA` para verificar si columna ya existe antes de agregarla (MySQL 5.7 no soporta `ADD COLUMN IF NOT EXISTS`)
- Agrega: `clubs.latitude`, `clubs.longitude`, `promotions.club_id`, `users.last_lat`, `users.last_lng`
- Crea: tabla `notifications`, tabla `club_memberships` (si no existen)
- Segura para ejecutar múltiples veces

```bash
mysql -u root -p id_sports < database/migration_v3_mysql57.sql
```

---

### v1.3 — Carruseles de Días/Deportes, Variable `--secondary`, Gestión de Deportes

#### 🎠 Carruseles en el Home

| Sección | Cambio |
|---------|--------|
| **Reservar por Día** | Convertido a carrusel horizontal con flechas prev/next; píldoras ampliadas (`min-width: 96px`, número en `2rem`) |
| **Deportes** | Convertido a carrusel; tarjetas más compactas (`78–88 px`), centradas; cada deporte tiene su color distintivo; soporte para imagen PNG subida por Super Admin |

#### 🎨 Variable CSS `--secondary`

- `main.php` ahora expone `--secondary` y `--secondary-rgb` calculados desde `config.color_secondary`
- Todos los degradados que antes usaban `#6366f1` hardcodeado ahora usan `var(--secondary)`, incluyendo: tarjeta "Reserva de Hoy", placeholder de cobertura de clubs, degradados de canchas en `/spaces/detail`, `/reservations/search`, `/clubs/detail`
- El Super Admin puede cambiar el color secundario desde **Config → Colores** y el cambio se refleja en toda la aplicación al instante

#### ⚽ Gestión de Tipos de Deporte (`/config/sports`)

Nueva sección en el panel Super Admin:

- **Lista maestra** de 20 deportes pre-cargada: Fútbol, Fútbol Sala, Fútbol 7, Fútbol Rápido, Pádel, Tenis, Basketball, Voleibol, Natación, Béisbol, Softbol, Squash, Badminton, Rugby, Handball, Gimnasio, Yoga/Pilates, CrossFit, Ciclismo Indoor, Otro
- **Icono PNG**: cada deporte puede tener una imagen PNG/JPG/WEBP subida (≤ 1 MB) almacenada en `public/assets/sports/`; si no hay imagen se usa el SVG inline correspondiente
- **Degradado editable**: color de inicio y fin del degradado de la tarjeta de cada deporte
- **Activar/desactivar** deportes (ocultar del Home y buscador)
- **Crear nuevos deportes** con validación de slug único

#### 🗃️ Base de datos (MySQL 5.7 compatible)

Migración: `database/migration_v4_sports.sql`

- Crea tabla `sport_types` con: `id`, `slug`, `name`, `color_from`, `color_to`, `image_path`, `sort_order`, `is_active`
- Pre-carga los 20 deportes usando `INSERT IGNORE` (idempotente)
- No requiere `ADD COLUMN IF NOT EXISTS` — 100% MySQL 5.7 compatible

```bash
mysql -u root -p id_sports < database/migration_v4_sports.sql
```

---

### v1.4 — Flujo de Reserva End-to-End (Detail-First, Grid 2×2, QR Ticket con Desglose)

#### 🔄 Flujo de navegación
`Buscar cancha → Detalle → Reserva → Pago → Ticket QR`

#### 🏟️ Pantalla 1 — Detalles de Cancha (`spaces/detail`)

Vista **estrictamente informativa** antes de reservar:
- Hero con imagen o SVG fallback por deporte
- Tarjeta info: nombre, club, precio/hr, badge de deporte, capacidad, **superficie** (nuevo), rating, dirección + Maps
- Tarjeta descripción (si tiene)
- **Tarjeta Reglas** (nuevo — campo `spaces.rules`)
- **Tarjeta Horario** (nuevo — tabla Lun–Dom con hora apertura/cierre o "Cerrado"; incluye duración máxima)
- Tarjeta amenidades: **solo lectura** (Disponible/Agotado), sin selección de cantidad
- Tarjeta reseñas
- **Barra sticky inferior**: botón "Reservar esta cancha →" con overlay de carga suave

#### 📅 Pantalla 2 — Configuración de Reserva (`reservations/create`)

Grid 2×2 en escritorio, 1 columna en móvil:
- **Celda 1** — Calendario mensual; días sin horario deshabilitados (via `getClosedDays()`)
- **Celda 2** — Selector en 2 pasos: ① Hora de Inicio → ② Botones de Duración (30 min, 1 h, 1.5 h…). Cada botón muestra "hasta HH:MM". Se detiene si hay un bloque reservado o si supera `max_duration_minutes`.
- **Celda 3** — Amenidades filtradas por `space_amenities` con buscador de texto, +/− con tope de stock
- **Celda 4** — Resumen vivo: Cancha + Amenidades + IVA 16%; botón "Proceder al Pago" habilitado solo al seleccionar fecha, inicio y duración

#### 💳 Flujo de Pago y Ticket

1. Modal de pago → loader → `POST reservations/pay` (AJAX)
2. Ráfaga de confeti (`canvas-confetti`)
3. Grid se oculta; aparece el Ticket QR con **Desglose de Pago**:

| Línea | ID del elemento |
|-------|----------------|
| Cancha (precio × horas) | `ticket-cancha-cost` |
| Amenidades extra (oculto si $0) | `ticket-amenities-cost` / fila `ticket-amenities-row` |
| Subtotal | `ticket-subtotal` |
| IVA (16%) | `ticket-iva` |
| **Total Pagado** | `ticket-total` |

Montos formateados con `Intl.NumberFormat('es-MX', { style:'currency', currency:'MXN' })`.

#### 🔐 Check-in Admin (`reservations/scan-qr`)

- Escanea QR → valida ventana de tiempo (15 min antes hasta fin de reserva)
- Actualiza status: `confirmed` → `in_progress`
- Endpoint `reservations/complete` (admin) → `completed` + restaura stock amenidades

#### 🗃️ Migraciones

| Archivo | Descripción |
|---------|-------------|
| `migration_v5_reservations.sql` | ENUM `status` agrega `pending` e `in_progress`; crea `reservation_amenities` |
| `migration_v6_space_amenities.sql` | Tabla pivote `space_amenities(space_id, amenity_id)` con FK; instalaciones limpias parten vacía |
| `migration_v7_spaces_extra.sql` | Agrega `surface_type`, `rules`, `max_duration_minutes` a `spaces` |
| `migration_v8_reset_space_amenities.sql` | `TRUNCATE TABLE space_amenities` — limpiar instalaciones previas con datos cruzados entre deportes |

```bash
mysql -u root -p id_sports < database/migration_v5_reservations.sql
mysql -u root -p id_sports < database/migration_v6_space_amenities.sql
mysql -u root -p id_sports < database/migration_v7_spaces_extra.sql
# Solo si instalación existente con amenidades cruzadas entre deportes:
mysql -u root -p id_sports < database/migration_v8_reset_space_amenities.sql
```

#### 🐛 Fixes
- Avatar del usuario ahora aparece correctamente en la barra lateral de **todas** las páginas (Buscar, Detalle, Reservar), no solo en Home — se normaliza la ruta relativa con `BASE_URL`
- `AmenityModel::findBySpace()` envuelto en `try/catch(PDOException)` para fallback gracioso si `space_amenities` aún no existe en producción

