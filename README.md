# Task Manager

## Project Overview

This is a secure RESTful API built with Laravel for managing projects and tasks. It provides endpoints for creating, assigning, and tracking projects and tasks, with support for user authentication, project membership, and advanced features like sorting and filtering. Designed with flexibility and maintainability in mind, the API can be easily integrated into other systems to support team collaboration and project organization.

## Features

* Users can register and log in using secure authentication.
* Logged-in users can create new projects.
* Registered users can join existing projects as members.
* Both project creators and members can view the project.
* Only the project creator can update or delete a project.
* Project creators and members can add tasks to the project.
* Project creators and members can view all tasks within the project.
* The creator of a task is the only one who can update or delete it.
* For simplicity, the project creator is automatically added as a member upon creation.
* Users can view a list of tasks they have created.
* Tasks support sorting and filtering via query parameters.
* Project and task listings are paginated for better performance and usability.
* By default, tasks and members are not included in the project view — they can be included via optional query parameters.

## Base URL

[https://project-manager.nebojsatasic.com](https://project-manager.nebojsatasic.com)

## Public Routes

| Method | Endpoint    | Description       |
| :----- | :---------- | :---------------- |
| POST   | `/login`    | User login        |
| POST   | `/register` | User registration |

## Technologies Used

* PHP 8.2 (Object-Oriented Programming, MVC structure)
* HTML 5 for semantic markup
* Bootstrap 5 for responsive design
* MySQL for database management

## Future Updates

* Product categories for better product organization
* Email confirmation upon registration

## Live Demo
Check out the live demo of the webshop [here](https://carmelita.nebojsatasic.com)

## License

No license

## Author

Nebojsa Tasic
Email: [nele.tasic@gmail.com](nele.tasic@gmail.com)
Website: [https://nebojsatasic.com](https://nebojsatasic.com)

Feel free to reach out if you need admin login details or any other information.
