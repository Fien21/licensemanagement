<!--
This file is managed by Gemini AI. It is not recommended to modify this file manually.
-->

# Project Blueprint

## Overview

This project is a full-stack web application built with Laravel, designed to serve as a comprehensive license management system. The application allows administrators to manage software licenses, including creating, importing, exporting, and archiving them. It also includes user management functionalities, enabling administrators to oversee user accounts.

## Key Features

- **Dashboard:** Provides a central overview of the license and user data, featuring key statistics such as the total number of licenses and a summary of recent activities.
- **License Management:**
    - **CRUD Operations:** Administrators can create, read, update, and delete licenses.
    - **Bulk Actions:** Supports bulk archiving and deleting of licenses for efficient management.
    - **Import/Export:** Licenses can be imported from a CSV file and exported to a CSV file.
    - **Archiving:** Licenses can be archived (soft-deleted) and restored, or permanently deleted from the archive.
- **User Management:**
    - **User Accounts:** Administrators can manage user accounts.
    - **Archiving:** Users can be archived (soft-deleted) and restored, or permanently deleted from the archive.
- **Search Functionality:** A search bar allows for easy filtering of licenses and users based on various attributes.

## Design and Styling

- **Layout:** A two-column layout is used, with a fixed sidebar for navigation and a main content area for the application's features.
- **Sidebar:** The sidebar provides access to the main sections of the application, including the Dashboard, License Management, and User Management. It also includes expandable dropdown menus for sub-sections.
- **Styling:** The application uses Tailwind CSS for a modern and responsive design. The color scheme is based on a combination of gray tones for the background and sidebar, with vibrant colors for interactive elements and notifications.
- **Notifications:** Success and error messages are displayed using styled alerts to provide clear feedback to the user.

## Current Task: Implement Archived Users Feature

### Plan

1.  **Update Sidebar:** Add a new link to the user dropdown menu in the sidebar for accessing the "Archived Users" page.
2.  **Create Archived Users View:** Develop a new view that displays a table of archived users, with options to restore or permanently delete each user.
3.  **Define Routes:** Add new routes in `routes/web.php` to handle the display of the archived users page, as well as the logic for restoring and deleting users.
4.  **Implement Controller Logic:** Create the necessary methods in the `UserController` to fetch archived users and handle the restore and delete actions.
5.  **Enable Soft Deletes for Users:** Add the `SoftDeletes` trait to the `User` model and create a database migration to add the `deleted_at` column to the `users` table.
