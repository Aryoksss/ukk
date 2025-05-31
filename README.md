<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  
  # 🎓 UKK Project
  
  **Uji Kompetensi Keahlian (UKK) - Competency Assessment System**
  
  ![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php&logoColor=white)
  ![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
  ![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)
</div>

---

## 📋 About This Project

A comprehensive Laravel-based application designed for **Competency Assessment and Management**. This system streamlines the UKK (Uji Kompetensi Keahlian) process with modern web technologies and user-friendly interfaces.

### ✨ Key Features

- 🔐 **Authentication & Authorization** - Secure user management with role-based access
- 📊 **Progress Tracking** - Monitor PKL (Praktik Kerja Lapangan) progress
- 📈 **Interactive Dashboard** - Real-time insights and analytics
- 🛡️ **Security** - Built with Filament Shield for robust permission management

## 🛠️ Tech Stack

| Technology | Purpose |
|------------|---------|
| **Laravel** | Backend Framework |
| **Filament** | Admin Panel & UI Components |
| **Livewire** | Dynamic Frontend Interactions |
| **Jetstream** | Authentication Scaffolding |
| **MySQL** | Database Management |

## 📋 Requirements

- ![PHP](https://img.shields.io/badge/-PHP%208.1+-777BB4?style=flat-square&logo=php) **PHP >= 8.1**
- ![Composer](https://img.shields.io/badge/-Composer-885630?style=flat-square&logo=composer) **Composer**
- ![MySQL](https://img.shields.io/badge/-MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white) **MySQL**
- ![Node.js](https://img.shields.io/badge/-Node.js-339933?style=flat-square&logo=node.js&logoColor=white) **Node.js & NPM**

## 🚀 Quick Start

### 1️⃣ Clone Repository
```bash
git clone <repository-url>
cd ukk
```

### 2️⃣ Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3️⃣ Environment Setup
```bash
# Copy environment configuration
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4️⃣ Database Configuration
```bash
# Run database migrations
php artisan migrate

# Install and configure Shield permissions
php artisan shield:install
php artisan shield:generate --all

# Seed the database with initial data
php artisan db:seed
```

### 5️⃣ Build Assets
```bash
npm run build
```

## 📝 License

This project is open-sourced software licensed under the **[MIT License](https://opensource.org/licenses/MIT)**.

---

