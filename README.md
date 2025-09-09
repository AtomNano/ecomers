# E-commerce Application

This is a simple e-commerce application built with the Laravel framework.

## About The Project

This project is a skeleton application for an e-commerce platform. It includes basic features like user authentication, product display, and a settings page for users to manage their profiles.

### Built With

* [Laravel](https://laravel.com/)
* [Vite](https://vitejs.dev/)
* [Tailwind CSS](https://tailwindcss.com/)
* [Alpine.js](https://alpinejs.dev/)

## Getting Started

To get a local copy up and running follow these simple example steps.

### Prerequisites

* PHP >= 8.2
* Composer
* Node.js & npm

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/AtomNano/ecomers.git
   ```
2. Install PHP dependencies
   ```sh
   composer install
   ```
3. Install NPM packages
   ```sh
   npm install
   ```
4. Create a copy of your .env file
   ```sh
   cp .env.example .env
   ```
5. Generate an app encryption key
   ```sh
   php artisan key:generate
   ```
6. Create an empty database and add your database credentials to your .env file.

7. Run the database migrations
   ```sh
   php artisan migrate
   ```

### Usage

Use the following command to run the development server:

```sh
npm run dev
```

This will start the Vite development server and the Laravel development server.

## Features

* User registration and login
* Product display
* User profile settings page with the ability to:
    * Update profile information
    * Change password
    * Delete account

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

Distributed under the MIT License. See `LICENSE` for more information.

## Acknowledgements

* [Laravel](https://laravel.com/)
* [Laravel Breeze](https://laravel.com/docs/10.x/starter_kits#laravel-breeze)
* [Tailwind CSS](https://tailwindcss.com/)
* [Vite](https://vitejs.dev/)