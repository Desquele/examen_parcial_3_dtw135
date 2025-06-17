
# Parcial 3 - Proyecto Laravel DTW135 GT02

Integrantes:  
- Douglas Enrique Siguenza Quele  
- Salvador Isaías Juárez Alcántara  
- Guillermo Alexander Rodríguez Cortez  

---

## Requisitos

Asegúrate de tener instalado lo siguiente:

1. **Herd** → [Descargar Herd](https://herd.laravel.com/)  
2. **Git** → [Descargar Git](https://git-scm.com/)  
3. **Node.js y npm** → [Descargar Node.js](https://nodejs.org/)  
4. **MySQL Workbench** u otro cliente de base de datos  
5. **Visual Studio Code** u otro IDE compatible  

---

## Clonación del Proyecto

```bash
git clone <URL_DEL_REPOSITORIO>
cd nombre_del_proyecto
```

---

## Instalación de Dependencias

### Dependencias PHP (Laravel)

```bash
composer install
```

### Dependencias de Node

```bash
npm install
```

---

## Configuración del Entorno

1. Crear un archivo `.env` a partir de `.env.example`
2. Configurar la base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=root
DB_PASSWORD=1234
```

3. Generar clave de la aplicación:

```bash
php artisan key:generate
```

---

## Migraciones y Datos

```bash
php artisan migrate
php artisan db:seed
```

---

## Levantar el Proyecto

Opción 1: Usar Herd (recomendado)  
Opción 2: Servidor embebido de PHP

```bash
php -S 127.0.0.1:8081 -t public
```

Luego abrir en el navegador:

```
http://127.0.0.1:8081
```

---

## Acceso al Proyecto

Puedes acceder usando:

- **Usuario:** `usuario`
- **Contraseña:** `1234`
- **Usuario:** `admin`
- **Contraseña:** `1234`

---

## Funcionalidades Implementadas

### Parte 1: API de Geolocalización

- Vista: `apis.blade.php`
- Obtención automática de coordenadas (latitud, longitud)

![geolocalización](![image](https://github.com/user-attachments/assets/dc21bc2a-b061-48f1-b7af-62bc43666afa)
)

---

### Parte 2: API de Canvas

- Área de dibujo libre con mouse (líneas negras)
- Botón para guardar dibujo como `.png` (cliente)

![canvas](![image](https://github.com/user-attachments/assets/78f05b52-2dd6-4c70-9f55-ec2dbe8d0743)
)

---

### Parte 3: API de Video

- Controles personalizados: reproducir, pausar, adelantar/retroceder 10s
- Indicador de tiempo actual y duración total
- Control de volumen y velocidad

![video](![image](https://github.com/user-attachments/assets/42ec9986-5cf6-4656-9478-d3de418afdab)
)

---

### Parte 4: Web Workers

- Entrada de número límite para generar números primos

![web worker](![image](https://github.com/user-attachments/assets/471a0c19-a50c-4823-8b66-0bef489ec549)
)
