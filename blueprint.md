# Project Overview

This project is a full-stack web application for managing software licenses. It is built with Laravel and is designed to be developed within the Firebase Studio (formerly Project IDX) environment. The focus is on creating a fast, robust, and scalable application by leveraging Laravel's powerful features for routing, data handling, and backend logic.

# Implemented Features

- **License Data Table:** A styled table that displays a paginated list of licenses with sorting capabilities.
- **Modern UI:** A complete redesign of the user interface, including a sidebar, a main content area, and a modern table layout.
- **Database Seeding:** The database is seeded with 50 dummy licenses.
- **MVC Architecture:** The application follows the Model-View-Controller pattern, with a `LicenseController` to handle the business logic and a `License` model for database interactions.
- **Routing:** Web routes are configured for all license management actions.
- **Full CRUD and Archive Functionality:**
    -   **Add:** A redesigned, compact, and user-friendly modal with a form to add new licenses, with backend validation.
    -   **Edit/View:** (Placeholder buttons, functionality not fully implemented yet).
    -   **Archive (Soft Delete):** Functionality to archive licenses, moving them out of the main view.

# Current Task: Remove Student and Teacher-Related Features

The current task is to remove all features and database columns related to students and teachers, while preserving the license management functionality.

## Plan

1.  **Update `blueprint.md`**: Reflect the removal of student and teacher concepts.
2.  **Create Migration**: Generate a new migration to remove `student_id` and `assigned_teacher` columns from the `licenses` table.
3.  **Run Migration**: Run the new migration.
4.  **Clean up old migrations**: Delete the migrations that are now obsolete.
5.  **Update `License` Model**: Remove `student_id` and `assigned_teacher` from fillable properties.
6.  **Update `LicenseController`**: Remove logic for `student_id` and `assigned_teacher`.
7.  **Update Views**: Remove table columns and form fields for `student_id` and `assigned_teacher` in blade files.
8.  **Update `LicenseSeeder`**: Remove `student_id` and `assigned_teacher` from the seeded data.
9.  **Delete User-related files**: Delete `User` model, controller, seeder, factory, and migrations as they seem to represent students/teachers.
10. **Update `DatabaseSeeder`**: Remove call to `UserSeeder`.
11. **Remove related exports/imports**: Check `LicensesExport` and `LicensesImport` and remove student/teacher fields.
