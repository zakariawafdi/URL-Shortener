# URL Shortener

This project is a URL shortener built with **Laravel** and **Vue.js** using **Vite** as the build tool..


![Demo GIF](url-shortener.gif)


## Project Description

The URL shortener allows users to shorten long URLs into shorter, more manageable URLs. The application has the following features:

- Users can enter a long URL to be shortened.
- Users can view a list of previously shortened URLs.
- Users can view the statistics of URLs, including the most visited URLs, and all URLs with weekly, monthly, and yearly visits.

## Technologies Used

The following technologies were used to build this project:

- **Laravel**
- **Vue.js**

## Getting Started

To set up the project, follow these steps:

1. Clone the repository to your local machine.
2. Install the required dependencies by running the following command in the project root directory:

`composer install`

`npm install`

3. Create a new `.env` file by copying the `.env.example` file and updating the necessary configuration values.
4. Generate a new application key:

`php artisan key:generate`

5. Set up the database by updating the DB_DATABASE, DB_USERNAME, and DB_PASSWORD values in the .env file and running the following command:

`php artisan migrate`

6. Compile the assets using Vite:

`npm run dev`

7. Start the development server:

`php artisan serve`

8. Open the application in your web browser by navigating to [http://localhost:8000](http://localhost:8000).

## Conclusion

This README file provides a brief overview of the URL shortener project and how to set it up.


