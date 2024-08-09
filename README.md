# Chat Admin Panel
This project is an admin panel built with Laravel 10, PHP 8.1, and Vite. The main feature is a chat system where users can send and receive messages, including the ability to create group chats. The application uses a microservice architecture, with a Go WebSocket server handling real-time messaging.
## Features

- <b>User Authentication:</b> Implemented using Jetstream and Inertia.js.
- <b>Real-Time Messaging:</b> Messages are sent and received in real time via a Go WebSocket server.
- <b>Group Chats:</b> Users can create and participate in group chats.
- <b>Admin Panel:</b> Admins can manage users and monitor chat activities.

## Technologies Used

- <b>Backend:</b> Laravel 10, PHP 8.1
- <b>Frontend:</b> Vite, Inertia.js, Vue 3
- <b>Database:</b> MySql 8.0
- <b>Real-Time Messaging:</b> Go WebSocket server (link to repository)
- <b>Containerization: Docker</b>
    - <b>App Service:</b> Runs the Laravel application, built from a custom Dockerfile, with PHP configuration tailored via php.ini.
    - <b>Webserver:</b> Nginx serves the application, with ports 8080 (HTTP) and 443 (HTTPS) exposed.
    - <b>Database:</b> MySQL 8.0, with data stored in a Docker volume and configuration via my.cnf.
    - <b>Vite:</b> Handles frontend assets with Node.js, serving the development build on port 5173.
  
## Status: In Development
This project is currently in active development. Some features may be incomplete or subject to change.

## Contributing
Contributions and feedback are welcome as we work towards a stable release.


