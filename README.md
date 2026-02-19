# RestoranKu

![Preview](docs/preview-react.png)

Restoranku is simple react app project with backend using Laravel. This project is to fullfill the assignment to apply as fullstack engineer in Goers company.

## Table of Contents

-   [Features](#features)
-   [Installation](#installation)
-   [Usage](#usage)

## Features

-   Login as Admin and Register New Admin
-   Restaurant management for user with role admin: Easily add, edit, and delete restaurant.
-   View all restaurant and do filter based on name, date, or time.

## Installation

1. Clone the repository:

    ```bash
    https://github.com/ThobyGitHub/goers-laravel-backend.git
    ```

    For UI project:

    ```bash
    https://github.com/ThobyGitHub/goers-react-frontend.git
    ```

2. Navigate to the project directory:

    ```bash
    cd your-project
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Copy the `.env.example` file to `.env` and configure your database:

    ```bash
    cp .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Create symlink

    ```bash
    php artisan storage:link
    ```

7. Migrate the database:

    ```bash
    php artisan migrate --seed
    ```

8. Start the development server:

    ```bash
    php artisan serve
    ```

### Usage

Visit `http://localhost:8000` in your browser to access the web-based app.

### To do

(soon)
