## ArtworkzPC

A comprehensive e-commerce platform built specifically for PC components and computer hardware, featuring a custom PC builder tool, dual authentication system, and complete order management.

## Features

### Customer Features
- ** Product Browsing**: Browse products by categories with advanced filtering
- ** PC Builder Tool**: Interactive tool to build custom PC configurations with component compatibility
- ** Shopping Cart**: Full-featured cart with quantity management and item selection
- ** Wishlist**: Save products for later purchase
- ** Product Comparison**: Compare multiple products side by side
- ** Order Management**: Track orders, view history, and download invoices
- ** User Authentication**: Secure registration, login, and email verification
- ** Email Verification**: Secure email verification system
- ** Customer Profile**: Manage personal information and addresses

### Admin Features
- **Dashboard**: Comprehensive analytics and overview
- **Product Management**: Create, edit, and manage products with specifications
- **Category Management**: Organize products into categories
- **Brand Management**: Manage product brands
- **Customer Management**: View customer details and order history
- **Order Management**: Process orders and update status
- **Employee Management**: Manage admin users and employees
- **Transaction Tracking**: Monitor sales and revenue

### Technical Features
- **Dual Authentication**: Separate auth systems for customers and administrators
- **Responsive Design**: Mobile-first design with Tailwind CSS
- **SPA Experience**: Seamless single-page application using Inertia.js
- **Charts & Analytics**: Interactive charts using Chart.js
- **PDF Generation**: Generate and download invoices
- **Modern UI**: Beautiful interface using Headless UI components
- **Search & Filter**: Advanced product search and filtering capabilities

##Technology Stack

### Backend
- **Laravel 11** - PHP Framework
- **PHP 8.2+** - Programming Language
- **MySQL/SQLite** - Database
- **Laravel Sanctum** - API Authentication
- **DomPDF** - PDF Generation

### Frontend
- **Vue.js 3** - JavaScript Framework
- **Inertia.js** - Modern Monolith
- **Tailwind CSS** - Utility-first CSS Framework
- **Headless UI** - Unstyled UI Components
- **Chart.js** - Data Visualization
- **Lucide Icons** - Beautiful Icons
- **Vue Datepicker** - Date Selection

### Build Tools
- **Vite** - Fast Build Tool
- **PostCSS** - CSS Processing
- **Autoprefixer** - CSS Vendor Prefixes

## Requirements

- **PHP** >= 8.2
- **Node.js** >= 16.0
- **NPM** or **Yarn**
- **Composer** - PHP Dependency Manager
- **MySQL** >= 8.0 or **SQLite** >= 3.35
- **Git** - Version Control

## Quick Start

### 1. Clone the Repository
```bash
git clone <repository-url>
cd pc-components-ecommerce
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
```

### 4. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Configuration
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pc_store
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Create Database
```bash
# For SQLite
touch database/database.sqlite

# For MySQL, create database manually in your MySQL client
```

### 7. Run Migrations
```bash
php artisan migrate
```

### 8. Seed Database (Optional)
```bash
php artisan db:seed
```

### 9. Build Assets
```bash
npm run build
```

### 10. Start Development Server
```bash
# Option 1: Laravel built-in server
php artisan serve

# Option 2: Full development environment with queue workers and hot reload
composer run dev

# Option 3: Manual setup (separate terminals)
php artisan serve           # Backend server
npm run dev                 # Frontend hot reload
php artisan queue:work       # Queue worker
```

The application will be available at `http://localhost:8000`

## 🔧 Development

### Frontend Development
```bash
# Start Vite development server with hot reload
npm run dev

# Build for production
npm run build
```

### Backend Development
```bash
# Run migrations
php artisan migrate

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Generate model/controller/migration
php artisan make:model Product -mcr

# Clear caches
php artisan optimize:clear
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.



## Changelog



---

**Built with using Laravel VueJS and InertiaJS**
