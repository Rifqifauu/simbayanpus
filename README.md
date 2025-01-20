# SIMBAYANPUS

## Prerequisites
- PHP >= 8.0
- Composer
- Node.js & NPM
- Git
- MySQL/MariaDB

## Installation Steps

1. Clone the repository
```bash
git clone https://github.com/Rifqifauu/simbayanpus.git
```

2. Navigate to project directory
```bash
cd simbayanpus
```

3. Install PHP dependencies
```bash
composer install
```

4. Install Node.js dependencies
```bash
npm install
```

5. Create symbolic link for storage
```bash
php artisan storage:link
```

6. Environment Setup
- Copy `.env.example` to `.env`
- Configure your database settings
- Set APP_URL according to your local PHP server path

7. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed the database with admin and superadmin accounts
php artisan db:seed
```

8. Build Assets
```bash
npm run dev
```

9. Start the development server
```bash
php artisan serve
```

The application should now be running at `http://localhost:8000`

## Default Accounts
After running the seeder, you'll have access to the following accounts:
- Admin account (email: admin@example.com, password: iamadmin)
- Superadmin account (email: superadmin@example.com, password: iamsuper)

