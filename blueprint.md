# Project Blueprint

## Overview

This project is a Laravel-based license management system. It allows users to manage software licenses, including creating, viewing, updating, and archiving them.

## Features & Design

### Implemented

*   **License Management:**
    *   CRUD functionality for licenses.
    *   Batch upload of licenses.
    *   Filtering and sorting of licenses.
    *   Archiving and permanent deletion of licenses.
*   **User Management:**
    *   CRUD functionality for users.
*   **Styling:**
    *   The application uses a modern design with a blue and green color scheme.
    *   It features a responsive layout with a sidebar for navigation.
    *   Interactive elements like buttons and forms are styled for a user-friendly experience.

### Current Task

*   **Remove "Vendo Machine" Field:**
    *   Remove the "Vendo Machine" column from the licenses table view.
    *   Remove the "Vendo Machine" field from the database.
    *   Update the controller and model to remove references to "vendo_machine".
