# Assignment URL Shortener

A  URL shortening assignment built with Laravel and MySQL

## Features

- Role-based authentication for SuperAdmin, Admin, and Member.
- SuperAdmin can invite an Admin to a new company.
- Admin can invite another Admin or Member within their company.
- Admin and Member can create short URLs.
- SuperAdmin can view short URLs across all companies.
- Admin can view short URLs created within their own company.
- Member can view only their own short URLs.
- Public short URLs redirect to their original destinations.

## Requirements

- PHP 8.2 or compatible version required by the installed Laravel dependencies
- Composer
- MySQL
- A compatible PHP environment for Laravel 12

## Local Setup

1. Clone this repository.
2. Install dependencies:

   ```bash
   composer install
   ```

3. Create the environment file:

   ```bash
   cp .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Create a MySQL database and configure the `DB_*` values in `.env`.

6. Configure the SuperAdmin credentials using the environment variables supported by the seeder.

7. Run database migrations:

   ```bash
   php artisan migrate
   ```

8. Seed the SuperAdmin account:

   ```bash
   php artisan db:seed --class=SuperAdminSeeder
   ```

9. Start the application:

   ```bash
   php artisan serve
   ```

10. Open the local URL displayed by Artisan and sign in using the SuperAdmin credentials configured in `.env`.

## Usage

- SuperAdmin creates a company by inviting its first Admin.
- Admins invite users into their own company.
- Admins and Members create short URLs according to their permissions.
- Public short links redirect visitors to the saved original URL.

## AI Assistance Disclosure

ChatGPT was used as a supporting tool for Laravel syntax clarification, debugging, and understanding implementation concepts during development. The project implementation, integration, and final decisions were handled by me. 
