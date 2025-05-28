
# Sweatify

## Overview
Sweatify is a fitness application designed for gym lovers and newcomers alike who want to transform their lifestyle. This registration-based app provides intelligent workout plans, personalized coaching, and progress tracking to help users achieve their fitness goals, whether it be losing weight, building muscle, or maintaining a healthy lifestyle. Sweatify consolidates all essential fitness features into one platform, eliminating the need for multiple fitness apps.

## Features
- **User Authentication**: Secure authentication with Laravel Breeze and Sanctum.
- **Custom Workout Plans**: Personalized exercise routines based on user preferences.
- **Progress Tracking**: Monitor and analyze fitness progress over time.
- **Exercise Library**: Extensive database of exercises categorized by body part, equipment, and target muscle.
- **Responsive UI**: Built using Blade templates for a seamless experience across devices.

## Tech Stack
- **Backend**: Laravel (PHP) with Eloquent ORM for database management
- **Frontend**: Blade templates
- **Authentication**: Laravel Breeze and Sanctum
- **Database**: MySQL with Eloquent ORM
- **API**: Custom-built REST API
- **Containerization**: Docker (optional for deployment)

## Installation
### Prerequisites
- **PHP** >= 8.0
- **Composer** (PHP dependency manager)
- **MySQL** (or Dockerized MySQL instance)
- **Node.js & NPM** (for frontend assets)

### Setup Steps
1. Clone the repository:
    ```bash
    git clone https://github.com/CodecoolGlobal/el-proyecte-grande-prototype-general-schuschii
    cd sweatify
    ```
2. Install dependencies:
    ```bash
    composer install
    npm install && npm run dev
    ```
3. Set up environment variables:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4. Configure the database in `.env` and run migrations:
    ```bash
    php artisan migrate --seed
    ```
5. Start the local development server:
    ```bash
    php artisan serve
    ```
6. (Optional) Run tests:
    ```bash
    php artisan test
    ```

## Business Model
Sweatify operates on a free-to-use model where users gain full access to the platform upon registration. The app is designed to provide value without requiring subscriptions or in-app purchases.

## Contribution
Contributions are welcome! If you'd like to improve Sweatify, please submit a pull request following the contribution guidelines.

## License
This project is licensed under the MIT License.

## Contact
For any inquiries or support, reach out:
- **GitHub**: [github.com/CodecoolGlobal/el-proyecte-grande-prototype-general-schuschii](https://github.com/CodecoolGlobal/el-proyecte-grande-prototype-general-schuschii)

---
### Additional Documentation
For API endpoints and in-depth product details, refer to the **[Product Design Document (PDD)](sweatify/docs/PDD.md)**.

## Screenshots

### Welcome Page
![Welcome](sweatify/docs/screenshots/welcome.png)

### Login Page
![Login](sweatify/docs/screenshots/login.png)

### Registration Page
![Register](sweatify/docs/screenshots/register.png)

### Dashboard
![Dashboard](sweatify/docs/screenshots/dashboard.png)

### Home Page
![Home](sweatify/docs/screenshots/home.png)

### Create Custom Workout
![Create Custom Workout](sweatify/docs/screenshots/createCustomWorkout.png)

### Filter Exercises by Target
![Filtered By Target](sweatify/docs/screenshots/filteredByTarget.png)

### Edit Profile
![Profile Edit](sweatify/docs/screenshots/profileEdit.png)

### Password Reset & Delete
![Password Reset/Delete](sweatify/docs/screenshots/passwordResetDelete.png)
