# MySQL Database Setup for Keuzedeel System

## Database Configuration

To use MySQL instead of SQLite, follow these steps:

### 1. Create the Database

```sql
-- Execute this in MySQL (phpMyAdmin, MySQL Workbench, or command line)
CREATE DATABASE IF NOT EXISTS keuzedeel_db;
```

### 2. Import the Schema

```bash
# Import the SQL file
mysql -u root -p keuzedeel_db < database_mysql.sql
```

Or import through phpMyAdmin:
1. Select the `keuzedeel_db` database
2. Click "Import"
3. Choose `database_mysql.sql` file
4. Click "Go"

### 3. Update Laravel Configuration

Update your `.env` file to use MySQL:

```env
# Change from SQLite to MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=keuzedeel_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Clear Configuration Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### 5. Test the Connection

```bash
php artisan tinker
# Then run:
echo \DB::connection()->getDatabaseName();
```

## Database Details

- **Database Name:** keuzedeel_db
- **Tables:** 5 main tables + Laravel system tables
- **Test Accounts:** 
  - Student: student@example.com / password
  - Admin: admin@example.com / password
  - SLBer: slb@example.com / password

## Tables Created

1. `users` - User accounts and roles
2. `periods` - Academic periods
3. `keuzedelen` - Available courses
4. `inscriptions` - Student enrollments
5. `completed_keuzedelen` - Completed courses

## Sample Data

The SQL file includes:
- 3 test users with different roles
- 3 academic periods
- 4 sample keuzedelen (courses)
- Proper relationships and constraints

## Troubleshooting

If you get connection errors:

1. Check MySQL service is running
2. Verify database name: `keuzedeel_db`
3. Check username/password in `.env`
4. Ensure MySQL user has privileges on the database
5. Run `php artisan migrate:status` to verify tables exist
