# Review Management Portal

A Laravel application for managing customer reviews through an authenticated admin area. Reviews include a name, position, message, and an optional image. The public home page can present the published review content, while authenticated users can create and update reviews from the dashboard.

## Features

- Laravel authentication, registration, password reset, email verification, and profile management
- Authenticated admin dashboard
- Create, list, edit, and update reviews
- Optional review image uploads with image validation
- SQLite development database by default
- Vite-powered frontend assets with Tailwind CSS and Alpine.js
- Pest feature and unit tests

## Requirements

- PHP 8.3 or newer
- Composer
- Node.js and npm
- SQLite, or another database supported by Laravel

## Installation

Clone the repository and enter the project directory:

```bash
git clone <repository-url>
cd basic
```

Create the SQLite database file first:

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

Then install the PHP and JavaScript dependencies, create the local environment file, generate the application key, run migrations, and build the frontend assets:

```bash
composer run setup
```

## Running Locally

Start the Laravel server, queue listener, and Vite development server together:

```bash
composer run dev
```

The application is available at `http://localhost:8000` by default. To run the services separately, use:

```bash
php artisan serve
npm run dev
```

For a production-style frontend build:

```bash
npm run build
```

## Main Routes

| Method | Path | Purpose | Access |
| --- | --- | --- | --- |
| GET | `/` | Public home page | Public |
| GET | `/login` | Login form | Public |
| GET | `/register` | Registration form | Public |
| GET | `/dashboard` | Admin dashboard | Authenticated |
| GET | `/all/review` | List reviews | Authenticated |
| GET | `/add/review` | New review form | Authenticated |
| POST | `/store/review` | Save a review | Authenticated |
| GET | `/edit/review/{id}` | Edit a review | Authenticated |
| POST | `/update/review` | Update a review | Authenticated |
| GET | `/profile` | Manage the profile | Authenticated |
| GET | `/verify` | Custom verification form | Public |

Use the named routes in `routes/web.php` when linking to these pages from application code.

## Review Images

Uploaded review images are validated as images up to 2 MB and stored in `public/upload/review`. The database stores the relative path in the `reviews.image` column. Make sure this directory is writable by the web server in deployed environments.

## Database and Configuration

Copy `.env.example` to `.env` when setting up manually, then configure the database and mail settings for your environment. The default local configuration uses:

- SQLite for the database
- Database-backed sessions, cache, and queues
- The log mail driver, which writes outgoing mail to the application log

After changing configuration values, clear cached configuration if needed:

```bash
php artisan config:clear
```

## Testing

Run the full Pest test suite with:

```bash
php artisan test --compact
```

The test environment must point to an available database. For a local SQLite test database, configure the testing environment accordingly before running the suite.

## Project Structure

- `app/Http/Controllers` - application and admin controllers
- `app/Models` - Eloquent models, including `Review`
- `database/migrations` - database schema definitions
- `database/seeders` - development seed data
- `resources/views` - Blade templates
- `resources/js` and `resources/css` - frontend source assets
- `routes` - web, authentication, and console routes
- `tests` - Pest feature and unit tests

## Useful Commands

```bash
php artisan migrate              # Apply database migrations
php artisan migrate:fresh --seed # Rebuild and seed the database
php artisan route:list            # Inspect registered routes
php artisan storage:link          # Create the public storage link when needed
vendor/bin/pint                   # Format PHP files
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
