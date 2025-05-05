
# SmartWaste


## Requirements

Before running the application, ensure you have the following installed:

- PHP 8.x or above
- Composer
- Node.js (v16.x or higher) and npm
- Laravel 10.x (or higher)
- MySQL or SQLite database (SQLite is recommended for local development)

## Installation Steps

Follow the steps below to set up the project on your local machine.

### Step 1: Clone the Repository

First, clone the repository to your local machine:

```bash
git clone https://github.com/ast4rt3/IT38-A_Enterprise_System/
cd IT38-A_Enterprise_System
```
### Step 2: Install PHP Dependencies

Install the PHP dependencies required for the Laravel application:
```
composer install
```
### Step 3: Install Node.js Dependencies

Install the Node.js dependencies for front-end assets
```
npm install
```
### Step 4: Build Frontend Assets

Build the front-end assets with the following command:
```
npm run dev
```
### Step 5: Run the Application

You can now run the Laravel development server:
```
npm run dev
```

Install the PHP dependencies required for the Laravel application:
```
php artisan serve
```
This will start the application at 
```
http://localhost:8000/login
```

##Troubleshooting

Missing PHP Extensions
If you see errors related to missing extensions, ensure that your PHP installation has the necessary extensions, such as pdo and pdo_sqlite.

Database File Not Found
If you're using SQLite, ensure that the database/database.sqlite file exists. You can manually create an empty SQLite file if necessary:

