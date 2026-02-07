# Project Blueprint

## Overview

This project is a full-stack web application built with Laravel. It is designed to be a license management system.

## Features

*   **Dashboard:** Displays statistics about licenses and users.
*   **License Management:** Allows users to create, read, update, and delete licenses.
*   **User Management:** Allows users to create, read, update, and delete users.

## Design

*   **Framework:** Laravel
*   **Database:** SQLite
*   **Frontend:** Blade templates with basic CSS.

## Current Task

### Fix Database Compatibility Issue

*   **Goal:** Resolve the `Illuminate\Database\QueryException` caused by using the `MONTH()` and `YEAR()` functions, which are not available in SQLite.
*   **Plan:**
    1.  Modify `app/Http/Controllers/DashboardController.php` to use the `strftime()` function for date extraction in the `getLicensesActivityData()` method.
    2.  Replace the `whereYear()` method with a `where()` clause that uses a raw DB expression with `strftime()` to ensure compatibility with SQLite.
