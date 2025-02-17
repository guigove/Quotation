# Project Setup Guide

This guide provides step-by-step instructions to set up and run the application using the `setup.sh` script.

## Prerequisites

Ensure you have the following installed:

- **Docker & Docker Compose**
- **Git**
- **PHP >= 8.3**
- **Composer**

## Setup Instructions

1. **Clone the repository**:

   ```sh
   git clone https://github.com/guigove/Quotation.git
   cd Quotation
   ```
2. **Run the setup script**:

   ```sh
   ./setup.sh
   ```

   This script will:

   - Create the .env file if it doesn't exists
   - Create the vendor folder if it doesn't exists
   - Start Laravel Sail containers
   - Install backend dependencies
   - Generate application keys
   - Run database migrations and seeders
   - Install frontend dependencies and build the Angular application
   - Create a default user with the following credentials:
     - **Email:** airo@airo.com
     - **Password:** password
3. **Access the application**:

   - Backend API: `http://localhost`
   - Frontend: `http://localhost:4200`

## Manual Setup (If not using setup.sh)

If you prefer to set up manually, follow these steps:

```sh
cp .env.example .env
composer install
./vendor/bin/sail up -d --build
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan jwt:secret
```

> **Note:** Even when setting up manually, the default user with the following credentials will be created:

* **Email:** [airo@airo.com]()
* **Password:** password
