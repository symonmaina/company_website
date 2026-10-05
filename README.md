# Review Management Portal

A Laravel 13 application that combines a public marketing landing page with an authenticated dashboard for managing customer reviews and user profiles. The project uses Blade templates, Laravel Breeze authentication, Vite, Tailwind CSS, Alpine.js, and prebuilt Bootstrap-based frontend and admin theme assets.

## Current Capabilities

- Public marketing homepage with hero, features, benefits, FAQs, testimonials, and app call-to-action sections
- User registration, login, logout, password reset, password changes, password confirmation, and email verification
- Authenticated dashboard with static analytics-style content
- Profile management for name, email, phone, address, and profile photo
- Review listing, creation, editing, and updating
- Optional review images with server-side validation and browser preview
- Database-backed sessions, cache, and queues in the default local configuration
- Pest 4 feature and unit tests

## Important Current Behavior

- The homepage testimonials are hard-coded in `resources/views/home/homelayout/review.blade.php`; records in the `reviews` table are currently managed in the dashboard but are not rendered on the public homepage.
- Dashboard figures are static template content rather than calculated application metrics.
- Review management is protected by `auth`, but there is no role middleware. Any authenticated user can access it, regardless of the `users.role` value.
- The custom six-digit email verification flow exists at `/verify`, but its code generation and email sending are commented out. The current login flow authenticates users immediately.
- There is no implemented review-delete route, although the review listing contains a delete control in the template.

## Requirements

- PHP 8.3 or newer
- Composer
- Node.js and npm
- SQLite for the default local setup, or another Laravel-supported database

## Installation

Clone the repository and enter the project directory:

```bash
git clone <repository-url>
cd basic
```

The default environment uses SQLite. Create the database file before running the setup script:

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

Install dependencies, create `.env`, generate the application key, run migrations, and build frontend assets:

```bash
composer run setup
```

For a manual setup, use the equivalent commands:

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

On macOS or Linux, replace `copy .env.example .env` with `cp .env.example .env`.

## Running Locally

Start the Laravel server, queue listener, and Vite development server together:

```bash
composer run dev
```

The application is available at `http://localhost:8000` by default. To run the server and asset watcher separately:

```bash
php artisan serve
npm run dev
```

Build production frontend assets with:

```bash
npm run build
```

## Application Routes

### Public and authentication routes

| Method | Path | Purpose |
| --- | --- | --- |
| GET | `/` | Public marketing homepage |
| GET | `/login` | Login form |
| GET | `/register` | Registration form |
| GET | `/forgot-password` | Password-reset request |
| GET | `/reset-password/{token}` | Password-reset form |
| GET | `/verify-email` | Email-verification notice |
| GET | `/verify-email/{id}/{hash}` | Signed email-verification endpoint |
| GET | `/confirm-password` | Password confirmation |
| GET | `/verify` | Custom verification-code form; currently dormant |

### Authenticated routes

| Method | Path | Purpose |
| --- | --- | --- |
| GET | `/dashboard` | Dashboard |
| GET | `/profile` | Profile management |
| POST | `/profile/store` | Save custom profile fields and photo |
| POST | `/admin/password/update` | Change password through the admin profile UI |
| GET | `/all/review` | List reviews |
| GET | `/add/review` | New review form |
| POST | `/store/review` | Create a review |
| GET | `/edit/review/{id}` | Edit a review |
| POST | `/update/review` | Update a review |

The route definitions are in `routes/web.php`; standard Breeze authentication routes are in `routes/auth.php`.

## Review and Profile Uploads

Uploads currently bypass Laravel's filesystem abstraction and are written directly to public directories:

- Profile photos: `public/upload/user_images` (maximum 10 MB)
- Review images: `public/upload/review` (maximum 2 MB)
- Placeholder image: `public/upload/no_image.jpg`

Review image paths are stored in `reviews.image`; profile photo filenames are stored in `users.photo`. The current implementation does not require `php artisan storage:link`, but the upload directories must be writable by the web server.

## Database

The main application tables are:

- `users` - authentication and profile data, including `photo`, `role`, `phone`, `address`, and `status`
- `reviews` - review name, position, message, image path, and timestamps
- `password_reset_tokens` and `sessions` - authentication support
- `cache`, `cache_locks`, `jobs`, `job_batches`, and `failed_jobs` - framework cache and queue support

The database schema is defined in `database/migrations`. There is no review factory or review seed data. The default `DatabaseSeeder` creates one user:

```text
Email: test@example.com
Password: password
```

Seed the development database with:

```bash
php artisan db:seed
```

Do not use the seeded credentials in a shared or production environment.

## Configuration

`.env.example` defaults to:

- SQLite database
- Database sessions, cache, and queues
- Log mailer, which writes outgoing messages to the application log
- `APP_DEBUG=true`
- `APP_URL=http://localhost`

For a deployed environment, set a unique `APP_KEY`, configure a real database and mail transport, set `APP_DEBUG=false`, and verify permissions for the upload directories. Clear cached configuration after changing environment values:

```bash
php artisan config:clear
```

## Frontend Architecture

The project contains two frontend asset layers:

- Vite entry points: `resources/css/app.css` and `resources/js/app.js`
- Prebuilt theme assets: `public/frontend/assets` and `public/backend/assets`

The Vite source uses Tailwind CSS and Alpine.js. The Blade templates also load Bootstrap-based theme assets and plugins such as jQuery, Slick, ApexCharts, DataTables, Feather icons, Toastr, and AOS from the public asset directories. `vite.config.js` defines the Vite entry points and `tailwind.config.js` defines Tailwind scanning.

## Testing

Run the full Pest suite with:

```bash
php artisan test --compact
```

The test configuration in `phpunit.xml` uses in-memory SQLite, array sessions/cache/mail, and synchronous queues. If the application has cached non-testing configuration, clear it first:

```bash
php artisan config:clear
php artisan test --compact
```

Current tests cover the homepage, registration, login/logout, password reset and update, password confirmation, email verification, standard profile update/deletion, and creating a review without an image. Custom admin login, the dormant verification-code flow, admin profile uploads, review updates/uploads/deletion, role authorization, and public database-backed reviews are not currently covered.

## Project Structure

```text
app/
	Http/Controllers/       Application, authentication, profile, and admin controllers
	Mail/                   Verification-code mail
	Models/                 User and Review models
database/
	factories/              Model factories
	migrations/             Database schema
	seeders/                Development seed data
public/
	backend/assets/         Admin theme assets
	frontend/assets/        Public theme assets
	upload/                 User and review uploads
resources/
	css/ and js/             Vite source assets
	views/                  Blade layouts, public pages, auth, admin, and profile pages
routes/                   Web, authentication, and console routes
tests/                    Pest feature and unit tests
```

## Useful Commands

```bash
php artisan migrate                # Apply migrations
php artisan migrate:fresh --seed   # Rebuild and seed the database
php artisan route:list              # Inspect registered routes
php artisan config:clear            # Clear cached configuration
vendor/bin/pint                     # Format PHP files
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
