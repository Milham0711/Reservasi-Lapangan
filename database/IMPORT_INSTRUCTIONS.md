# Importing `reservasilapangan_232112.sql` into this Laravel app

This project ships with a MySQL dump: `database/reservasilapangan_232112.sql`.
Below are step-by-step instructions to connect that database to the app and import the SQL dump.

## 1) Choose the database server

-   Recommended: MySQL / MariaDB (dump was created with MySQL 8.x syntax and utf8mb4 collation).
-   Alternative: import via phpMyAdmin or MySQL Workbench GUI.

## 2) Create the database (PowerShell)

Open PowerShell (or use MySQL client) and run:

```powershell
# create database (adjust user and password as needed)
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS reservasilapangan_232112 CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;"
```

You will be prompted for the MySQL root password.

## 3) Import the SQL dump (PowerShell)

Make sure you run this from the project root (where the `database` folder is). If MySQL client is in PATH, run:

```powershell
mysql -u root -p reservasilapangan_232112 < "database\reservasilapangan_232112.sql"
```

If you get errors about foreign keys or charset, try importing from a MySQL client (Workbench or phpMyAdmin) which shows more details.

## 4) Configure Laravel `.env` to use the MySQL database

Copy `.env.example` to `.env` if you haven't already, then edit (example values):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reservasilapangan_232112
DB_USERNAME=root
DB_PASSWORD=your_db_password_here
```

Then generate the app key (if not present):

```powershell
php artisan key:generate
```

## 5) Clear config cache (if any) and test connection

```powershell
php artisan config:clear
php artisan migrate:status
```

`migrate:status` won't reflect imported tables (it only shows migrations), but you can test DB connection with tinker or a quick route.

Example quick check (Tinker):

```powershell
php artisan tinker
>>> DB::connection()->getPdo(); // should not throw
>>> DB::table('lapangan_232112')->count();
```

## 6) If you prefer SQLite

The dump is MySQL-specific. To use SQLite you'd need to recreate schema via migrations or convert the SQL file. Simpler approach is to keep using MySQL locally.

## 7) Troubleshooting

-   If import fails due to `utf8mb4_0900_ai_ci` not recognized, use a compatible MySQL 8 server or change COLLATE in the SQL file to `utf8mb4_unicode_ci` and re-import.
-   If MySQL client isn't installed, use phpMyAdmin or MySQL Workbench GUI to import the `database/reservasilapangan_232112.sql` file.

---

If you want, I can:

-   Update `.env.example` with a ready-to-edit MySQL block (already added),
-   Create an artisan command to automate import from `database/reservasilapangan_232112.sql` (requires confirmation), or
-   Modify the app to map the legacy table names into Eloquent models (helpful if you want to use them directly).

Tell me which next step you prefer.
