# Invitación Digital Interactiva de 15 Años — Bianca 🌸✨

Este proyecto es un sistema premium completo para invitaciones digitales interactivas de cumpleaños de 15, desarrollado bajo una arquitectura MVC limpia y escalable. Consta de una landing page pública (Mobile-first, elegante y emotiva) y un panel administrativo completo protegido para moderar y configurar todo el contenido en tiempo real sin tocar código.

---

## 🚀 Características Principales

### 🌟 Sitio Público (Invitados)
* **Portada Impactante (Hero)**: Imagen de Bianca con efecto Parallax, cuenta regresiva dinámica en tiempo real y monograma personalizado.
* **Información del Evento**: Tarjetas elegantes (glassmorphism) con fecha, hora, salón y dress code.
* **Mapa Interactivo**: Google Maps embebido con redirección directa a la aplicación GPS ("Cómo llegar").
* **Música de Fondo**: Reproductor musical flotante con animación de ondas de sonido que se adapta a las políticas de reproducción automática de los navegadores.
* **Galería Oficial**: Visualizador lightbox de fotos de Bianca (cero dependencias externas).
* **Confirmación RSVP**: Formulario interactivo con validación de datos en tiempo real (evita duplicados de teléfono).
* **Libro de Dedicatorias**: Muro de mensajes autorizados por el administrador con diseño elegante.
* **Muro de Fotos**: Sección Polaroid donde los invitados pueden cargar capturas tomadas durante la fiesta (requiere aprobación).
* **Regalos y Alias**: Datos de CBU/Alias y código QR de Mercado Pago para transferencias bancarias de regalos, de activación opcional.
* **Compartir**: Generador de código QR dinámico integrado con opción de descarga directa.

### 🛡️ Panel de Administración (`/admin/login`)
* **Dashboard Estadístico**: Métricas rápidas (Asistencias confirmadas, total personas, invitados rechazados y elementos pendientes).
* **Ajustes Generales**: Formularios interactivos para cambiar nombres, direcciones, fechas y textos principales.
* **Diseño y Estilos**: Selector de paletas de colores (colores hexadecimales), fuentes (Google Fonts premium) e interruptores de animación.
* **Administrador de Música**: Sube archivos `.mp3`, activa o desactiva la ambientación sonora e interactúa con el autoplay.
* **Galería Oficial**: Sube múltiples imágenes oficiales en masa, elimina fotos y destaca la portada.
* **RSVP Manager**: Listado completo de confirmados, buscador en tiempo real por nombre/teléfono y **Exportación directa a planilla CSV** (Excel-friendly en español con BOM UTF-8).
* **Moderador de Mensajes y Fotos**: Paneles visuales rápidos para aprobar, rechazar o eliminar contenido subido por los invitados antes de hacerlo público.

---

## 🛠️ Stack Tecnológico
* **Core**: PHP 8.2+ & Laravel 11/12
* **Base de Datos**: MySQL / MariaDB (Compatible con SQLite)
* **Diseño Frontend**: Bootstrap 5 + Bootstrap Icons (v1.11+) + Custom CSS (Glassmorphism & Parallax)
* **Lógica Frontend**: JavaScript Vanilla (Sin jQuery ni frameworks pesados para un rendimiento ultrarrápido).

---

## 📥 Requisitos Previos (XAMPP local)
1. Tener **PHP 8.2 o superior** (XAMPP).
2. Tener **MySQL** instalado y activo en XAMPP.
3. Tener **Composer** (hemos descargado `composer.phar` en la raíz para que no necesites instalarlo globalmente).

---

## 💻 Instrucciones de Instalación Local

Sigue estos sencillos pasos para poner en marcha el proyecto en tu máquina local:

### 1. Iniciar los Servidores en XAMPP
Abre el panel de control de XAMPP e inicia los módulos:
* **Apache**
* **MySQL**

### 2. Crear la Base de Datos
Accede a phpMyAdmin (`http://localhost/phpmyadmin/`) o mediante consola y crea una base de datos vacía llamada:
```sql
CREATE DATABASE bianca15 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Instalar Dependencias de Composer
Abre una terminal (PowerShell o CMD) en la carpeta raíz del proyecto (`C:\xampp\htdocs\fiesta de 15 Bianca`) y ejecuta:
```bash
# Si usas PHP de XAMPP y el composer.phar local:
C:\xampp\php\php.exe composer.phar install
```
*Esto descargará e instalará todas las dependencias y librerías del framework.*

### 4. Configurar el Entorno
El archivo `.env` ya se encuentra preconfigurado para apuntar a MySQL local con los siguientes datos por defecto:
* **Database**: `bianca15`
* **Username**: `root`
* **Password**: *(vacío)*

*Si tu base de datos tiene contraseña, puedes editar el archivo `.env` con un editor de textos.*

### 5. Ejecutar Migraciones y Cargar Datos Iniciales (Seeders)
Ejecuta el siguiente comando para estructurar las tablas de la base de datos y sembrar el usuario administrador por defecto y los textos de demostración:
```bash
C:\xampp\php\php.exe artisan migrate --seed
```

### 6. Crear Enlace de Almacenamiento (Storage Link)
Laravel requiere un enlace simbólico entre el directorio de almacenamiento privado y el público para visualizar fotos y música cargadas:
```bash
C:\xampp\php\php.exe artisan storage:link
```

### 7. Ejecutar y Probar la Aplicación
¡Listo! Ya puedes ver tu sitio web interactivo ingresando desde el navegador a:
* **Sitio Público**: `http://localhost/fiesta de 15 Bianca/public/`
* **Panel Administrativo**: `http://localhost/fiesta de 15 Bianca/public/admin/login`

---

## 🔐 Credenciales del Administrador por Defecto
* **Usuario**: `admin@bianca15.com`
* **Contraseña**: `admin1234`

> [!WARNING]
> Recuerda cambiar esta contraseña o el correo electrónico del administrador al realizar el despliegue en producción para garantizar la seguridad del panel.

---

## 🌐 Guía de Despliegue en Producción (Shared Hosting / VPS)

Para subir esta invitación digital a un hosting compartido (como Hostinger, DonWeb, Neolo, etc.):

1. **Subir Archivos**: Sube todos los archivos del proyecto al servidor.
2. **Apuntar al directorio Public**:
   * En hostings compartidos, la carpeta raíz pública suele llamarse `public_html`.
   * Mueve el contenido de la carpeta `public` de Laravel dentro de `public_html`, y el resto de carpetas en la raíz del hosting (un nivel arriba de `public_html`).
   * Edita el archivo `public_html/index.php` para corregir las rutas relativas a `bootstrap/app.php` y `vendor/autoload.php`.
3. **Configurar Base de Datos en Producción**:
   * Crea una base de datos MySQL en el panel del hosting (cPanel).
   * Edita el archivo `.env` en la raíz de tu hosting con las credenciales de tu base de datos en producción y pon:
     ```env
     APP_ENV=production
     APP_DEBUG=false
     APP_URL=https://tudominio.com
     ```
4. **Ejecutar Migraciones**:
   * Si tienes acceso SSH en tu hosting, ejecuta: `php artisan migrate --seed`
   * Si no tienes SSH, puedes importar las tablas locales exportando la base de datos MySQL desde phpMyAdmin local e importándola en el phpMyAdmin del hosting.
5. **Crear el enlace de storage**:
   * En hosting compartido sin SSH, puedes crear un script temporal PHP en la carpeta pública llamado `link.php` con el siguiente código:
     ```php
     <?php symlink('/home/usuario/storage/app/public', '/home/usuario/public_html/storage'); ?>
     ```
   * Ejecútalo visitando `tudominio.com/link.php` y luego bórralo de inmediato.

---

¡Disfruta del evento y felicidades a Bianca! 🎂🎈🎉
# tarjetas
