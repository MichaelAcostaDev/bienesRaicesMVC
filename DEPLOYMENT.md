# Bienes Raíces MVC

Aplicación web de Bienes Raíces construida con PHP 8.3, MVC Pattern, MySQL, Composer e Intervention Image.

## Características

- ✅ MVC Pattern con PHP Puro
- ✅ Sistema de autenticación
- ✅ Gestión de propiedades y vendedores
- ✅ Procesamiento de imágenes con Intervention Image
- ✅ Envío de emails con PHPMailer
- ✅ Responsive Design con Sass y Gulp
- ✅ Compatible con Wasmer Edge
- ✅ PHP 8.3

## Stack Tecnológico

- **PHP**: 8.3
- **Base de Datos**: MySQL/MariaDB
- **ORM/Query Builder**: Custom ORM (ActiveRecord Pattern)
- **Image Processing**: Intervention Image 2.7
- **Email**: PHPMailer 6.10
- **Environment Variables**: PHPDotenv 5.6
- **Frontend**: Vanilla JavaScript, Sass, Gulp

## Estructura del Proyecto

```
├── app.yaml                 # Configuración para Wasmer Edge
├── database.sql             # Schema y datos iniciales
├── .env.example             # Variables de entorno (ejemplo)
├── composer.json            # Dependencias PHP
├── package.json             # Dependencias Node (dev)
│
├── public/                  # Document Root
│   ├── index.php            # Front Controller
│   ├── build/               # Assets compilados (CSS, JS)
│   ├── imagenes/            # Imágenes de propiedades
│   └── img/                 # Imágenes estáticas
│
├── includes/                # Configuración
│   ├── app.php              # Bootstrap
│   ├── funciones.php        # Funciones de utilidad
│   ├── config/
│   │   └── database.php     # Configuración MySQL
│   └── templates/           # Templates compartidos
│
├── controllers/             # Controladores MVC
│   ├── PaginasController.php
│   ├── PropiedadController.php
│   ├── VendedorController.php
│   └── LoginController.php
│
├── models/                  # Modelos MVC
│   ├── ActiveRecord.php     # Base ORM
│   ├── Propiedad.php
│   ├── Vendedores.php
│   └── Admin.php
│
├── views/                   # Vistas MVC
│   ├── paginas/
│   ├── propiedades/
│   ├── vendedores/
│   ├── auth/
│   └── layaut.php           # Layout principal
│
├── src/                     # Fuentes (Sass, JS original)
│   ├── scss/
│   └── js/
│
└── vendor/                  # Dependencias Composer (regenerado en deploy)
```

## Instalación Local

### Requisitos

- PHP 8.3+
- MySQL 8.0+ o MariaDB
- Composer
- Node.js 18+ (solo para desarrollo)

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/MichaelAcostaDev/bienesRaicesMVC.git
cd bienesRaicesMVC
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Configurar variables de entorno**
```bash
cp .env.example .env
# Editar .env con tus credenciales locales
```

4. **Crear base de datos**
```bash
mysql -u root -p < database.sql
```

5. **Iniciar servidor local**
```bash
cd public
php -S localhost:8000
```

Acceder a `http://localhost:8000`

### Credenciales de Prueba (Local)

- **Email**: admin@admin.com
- **Contraseña**: password123 (cambiar en producción)

**Nota**: La contraseña almacenada está hasheada con bcrypt.

## Deployment en Wasmer Edge

### Configuración Automatizada

El proyecto incluye `app.yaml` con toda la configuración necesaria para Wasmer:

```yaml
- PHP 8.3
- MySQL con variables de entorno automáticas
- Document Root: /app/public
- Instalación automática de dependencias Composer
```

### Variables de Entorno Requeridas

**Wasmer proporciona automáticamente:**
- `DB_HOST` - Host de MySQL
- `DB_PORT` - Puerto de MySQL
- `DB_USER` - Usuario de MySQL
- `DB_PASSWORD` - Contraseña de MySQL
- `DB_NAME` - Nombre de base de datos

**Debe configurar en Dashboard de Wasmer:**
- `EMAIL_HOST` - SMTP Server (ej: smtp.gmail.com)
- `EMAIL_USER` - Email del remitente
- `EMAIL_PASS` - Contraseña de aplicación SMTP
- `EMAIL_PORT` - Puerto SMTP (ej: 587)

### Steps para Deploy

1. **Preparar el repositorio**
```bash
git add .
git commit -m "chore: Actualización para Wasmer Edge - PHP 8.3 compatible"
git push origin main
```

2. **En Wasmer Dashboard**
   - Conectar repositorio GitHub
   - Seleccionar rama `main`
   - Las variables de BD se crean automáticamente
   - Configurar variables de EMAIL manualmente
   - Iniciar deployment

3. **Importar datos (primera vez)**
   - Acceder al terminal de Wasmer
   - Ejecutar: `mysql -h $DB_HOST -u $DB_USER -p$DB_PASSWORD $DB_NAME < database.sql`

## API de Rutas

### Públicas

- `GET /` - Home
- `GET /nosotros` - About
- `GET /propiedades` - Listado de propiedades
- `GET /propiedad?id=1` - Detalle de propiedad
- `GET /blog` - Blog
- `GET /entrada` - Entrada del blog
- `POST /contacto` - Enviar mensaje de contacto
- `GET/POST /login` - Autenticación

### Protegidas (requieren login)

- `GET /admin` - Dashboard administrativo
- `GET/POST /propiedades/crear` - Crear propiedad
- `GET/POST /propiedades/actualizar?id=1` - Editar propiedad
- `POST /propiedades/eliminar` - Eliminar propiedad
- `GET/POST /vendedores/crear` - Crear vendedor
- `GET/POST /vendedores/actualizar?id=1` - Editar vendedor
- `POST /vendedores/eliminar` - Eliminar vendedor
- `GET /logout` - Cerrar sesión

## Modelo de Datos

### usuarios
```sql
id (PK)
email (VARCHAR 60)
password (CHAR 60 - bcrypt)
```

### vendedores
```sql
id (PK)
nombre (VARCHAR 45)
apellido (VARCHAR 45)
telefono (VARCHAR 10)
```

### propiedades
```sql
id (PK)
titulo (VARCHAR 60)
precio (DECIMAL 10,2)
imagen (VARCHAR 200)
descripcion (LONGTEXT)
habitaciones (INT)
wc (INT)
estacionamiento (INT)
vendedorId (FK → vendedores.id)
creado (DATE)
```

## Desarrollo

### Compilar Assets (Sass/JS)

```bash
npm install
npm run dev
```

Genera:
- `public/build/css/app.css`
- `public/build/js/bundle.min.js`

## Seguridad

✅ **Implementado:**
- Validación de entrada en formularios
- Sanitización de HTML output
- Escape de SQL strings
- Protección de rutas admin con sesión
- Validación de CSRF implícita en MVC
- Contraseñas hasheadas con bcrypt
- Variables de entorno para credenciales

⚠️ **Consideraciones de Producción:**
- Mantener .env fuera del repositorio
- Usar HTTPS en producción
- Configurar CORS si es necesario
- Implementar rate limiting para login
- Usar prepared statements para queries complejas
- Configurar headers de seguridad (CSP, X-Frame-Options)

## Troubleshooting

### Error: "Operation timed out" (Database)

**Problema**: Las credenciales de DB son incorrectas o el host no es accesible.

**Solución**:
1. Verificar `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASSWORD` en el entorno
2. En Wasmer, verificar que MySQL está habilitado en `app.yaml`
3. Usar el host proporcionado por Wasmer (no localhost)

### Error: "Tabla no encontrada"

**Problema**: Database.sql no fue ejecutado.

**Solución**:
- En Wasmer: `mysql -h $DB_HOST -u $DB_USER -p$DB_PASSWORD $DB_NAME < database.sql`
- En local: `mysql -u root < database.sql`

### Error: "No se puede escribir imagen"

**Problema**: La carpeta `public/imagenes/` no tiene permisos.

**Solución**:
- Local: `chmod 755 public/imagenes`
- Wasmer: Se crea automáticamente con permisos en app.yaml

## Licencia

Proprietary - Uso privado

## Autor

Michael Acosta - michaelacostafreelancer@gmail.com
