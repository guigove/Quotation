# Project Setup Guide

This guide provides step-by-step instructions to set up and run the application using the `setup.sh` script.

## Prerequisites
Ensure you have the following installed:
- **Docker & Docker Compose**
- **Git**

## Setup Instructions

1. **Clone the repository**:
   ```sh
   git clone git@github.com:guigove/Quotation.git
   cd Quotation
   ```

2. **Run the setup script**:
   ```sh
   ./setup.sh
   ```
   This script will:
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

## Manual Setup (If Not Using setup.sh)
If you prefer to set up manually, follow these steps:

### Backend (Laravel)
```sh
./vendor/bin/sail up -d --build
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan jwt:secret
```

### Frontend (Angular)
```sh
cd frontend
npm install
npm start
```