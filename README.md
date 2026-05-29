# Laravel Blog CMS

Responsive blog and content management system built with Laravel.  
You can browse posts, filter by category/tag/author, create user posts, manage profiles, write threaded comments, and control the whole site from an admin dashboard with content, user, page, contact, mail, and settings management.

Live demo: Laravel Blog CMS

![Preview](./public/assets/images/seed/coffee-at-home.png)

## Features

- Public blog homepage with featured and latest posts
- Blog listing with category, tag, and author pages
- Post detail page with SEO-ready metadata and responsive content layout
- User authentication (login, register, forgot password, reset password)
- Email verification and email change verification flow
- User profile page with avatar upload, phone, bio, social links, and password update
- Personal UI mode preference (light/dark)
- User post system (create post, save drafts, edit drafts, publish drafts)
- "My Posts" and "My Comments" user sections
- Threaded comment system with user replies
- Admin comment replies and reply editing/deleting
- Comment moderation (approved, pending, spam)
- Contact page with throttled form submission
- Admin contact inbox with read/unread state and reply workflow
- Admin dashboard with users, posts, comments, categories, and activity summaries
- Admin post management with image upload, SEO fields, featured status, tags, and categories
- User-submitted post approval/moderation from the admin panel
- Category management
- User management with role, status, password, and avatar controls
- Role and permission management
- Editable About, Contact, and Terms pages
- General site settings, logo/favicon upload, social settings, and mail settings
- Branded email templates for auth and contact workflows
- Responsive frontend and admin layouts for desktop and mobile
- Seeded demo posts, authors, comments, categories, tags, and unique male/female avatars

## Tech Stack

- PHP 8.2+
- Laravel 12
- MySQL
- Blade
- JavaScript
- CSS
- Vite
- Bootstrap / AdminLTE assets
- Tailwind CSS dependency via Vite
- Axios
- Laravel Mail
- PHPUnit

## Project Structure

```text
app/
  Http/
    Controllers/
      Admin/
        Auth/
        Content/
        Dashboard/
        Pages/
        Settings/
        Users/
      Frontend/
    Middleware/
  Mail/
    Auth/
    Contact/
    Concerns/
  Models/
  Services/
    Admin/
    Mail/
    Uploads/
  Support/

database/
  factories/
  migrations/
  seeders/

resources/
  css/
  js/
  views/
    admin/
      auth/
      content/
      dashboard/
      layouts/
      pages/
      settings/
      users/
    emails/
    layouts/
    pages/
      posts/
      profile/
    partials/
    vendor/

routes/
  admin.php
  frontend.php
  web.php
  console.php

public/
  adminlte/
  assets/
    css/
    images/
    js/
  uploads/
    profiles/
  vendor/

tests/
  Feature/
  Unit/
```

## Main Pages

- `/` - Home page
- `/blog` - Blog archive
- `/posts` - Post listing
- `/post/{slug}` - Post detail
- `/blog/kategori/{category}` - Category archive
- `/blog/etiket/{tag}` - Tag archive
- `/yazar/{user}` - Author profile/posts
- `/about` - About page
- `/contact` - Contact page
- `/login` - Login
- `/register` - Register
- `/profile` - User profile settings
- `/blog/create` - Create a user post
- `/blog/my-posts` - User posts
- `/blog/drafts` - User drafts
- `/blog/my-comments` - User comments

## Admin Panel

- `/admin/dashboard` - Dashboard
- `/admin/posts` - Admin posts
- `/admin/user-posts` - User-submitted posts
- `/admin/categories` - Categories
- `/admin/comments` - Comment moderation
- `/admin/contact-messages` - Contact inbox
- `/admin/about-us` - About page editor
- `/admin/contact-us` - Contact page editor
- `/admin/terms` - Terms page editor
- `/admin/users` - Users
- `/admin/users/roles` - Roles and permissions
- `/admin/settings/general` - General settings
- `/admin/settings/social` - Social settings
- `/admin/settings/mail` - Mail settings

## Demo Admin

```text
Email: admin@admin.com
Password: admin
```

## Getting Started

Clone the repository:

```bash
git clone <repository-url>
cd blog
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seed demo data:

```bash
php artisan migrate --seed
```

Start the Laravel server:

```bash
php artisan serve
```

Start Vite in another terminal:

```bash
npm run dev
```

The app will run locally at:

```text
http://localhost:8000
```

## Available Scripts

```bash
composer run dev
```

Runs the Laravel server, queue listener, and Vite development server together.

```bash
npm run dev
```

Runs Vite in development mode.

```bash
npm run build
```

Builds frontend assets for production.

```bash
php artisan test
```

Runs the Laravel test suite.

```bash
composer run test
```

Clears Laravel config and runs the test suite.

## Tests

The project includes feature and unit tests for core blog/admin behavior:

- Admin page security
- Auth throttling
- Contact message admin workflow
- Comment moderation
- Post comments and replies
- Post metadata
- Settings security
- Post content formatting

## How It Works

Frontend routes are defined in `routes/frontend.php` and handle the public blog, authentication screens, contact page, profile page, user post workflow, and comment actions.

Admin routes are defined in `routes/admin.php` and are protected by auth and admin role middleware. The admin dashboard controls posts, categories, comments, user-submitted posts, contact messages, pages, users, roles, permissions, and settings.

Mail flows are handled through Laravel mail classes and the `MailWorkflowService`. In development, mail can be logged so welcome, verification, password reset, email change, contact, and contact reply emails can be tested safely.

Uploaded profile avatars are stored under `public/uploads/profiles`. Seeded demo profiles use generated avatar assets so users and commenters have distinct male/female profile images.

## Notes

- PHP 8.2 or newer is required.
- If XAMPP is used, make sure the CLI PHP version also matches PHP 8.2+.
- The default local database name used in examples is `blog`.
- Public uploads are served from the `public/uploads` directory.
- Seeders include sample content, authors, categories, comments, roles, users, and avatar assignments.

## License

This project is for educational and portfolio purposes.
