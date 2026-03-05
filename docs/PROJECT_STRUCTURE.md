# Project Structure

## Overview
This project follows Laravel conventions with a feature-oriented admin layer.

## Routing
- `routes/web.php`: route bootstrapper (includes other route files)
- `routes/frontend.php`: public website routes
- `routes/admin.php`: admin/auth routes

## Controllers
- `app/Http/Controllers/Frontend/*`: public-facing controllers
- `app/Http/Controllers/Admin/Auth/*`: authentication controllers
- `app/Http/Controllers/Admin/Dashboard/*`: dashboard controllers
- `app/Http/Controllers/Admin/Content/*`: posts/categories controllers
- `app/Http/Controllers/Admin/Pages/*`: page management controllers
- `app/Http/Controllers/Admin/Settings/*`: settings controllers

## Services
- `app/Services/Admin/*`: business logic extracted from controllers

## Views
- `resources/views/admin/dashboard/index.blade.php`: dashboard entry view
- `resources/views/admin/dashboard/partials/*`: modular dashboard UI parts
- Existing admin and frontend views remain compatible with current route names.

## Naming Rules
- Keep route names stable unless migration is planned.
- Keep controllers thin; move query/composition logic into services.
- Keep blade pages modular by feature (`index + partials`).
