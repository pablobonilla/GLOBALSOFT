# GlobalSoft

## **Instalación**

Sigue las siguientes instrucciones para clonar el repositorio

Clone el repositorio

` https://github.com/pablobonilla/GLOBALSOFT.git`

Instale todas las dependencias del Proyecto con

`composer install`

Actualize las dependencias de Composer con

`composer update`

Como el proyecto tiene dependencias en JS instalelas con

`npm install`

Actualize las dependencias de NPM con

`npm update`

Copie el Archivo .env.example en un archivo nuevo .env con

`cp .env.example .env`

### **Configure la base de datos y las demas variables de entorno en el archivo .env**

Genere una nueva Key para el protecto con

`php artisan key:generate`

Corra las migraciones del proyecto con

`php artisan migrate`

Corra los seeder del proyecto con

`php artisan db:seed`

Corra el proyecto con

`php artisan serve`
`npm install && npm run dev`

Si todo está correcto puede acceder al proyecto en la dirección http://localhost:8000 con el 
Usuario: admin@admin.com
Contraseña: admin@admin.com
