## 🚀 Laravel Aplication with Docker and Docker Compose

This project is a Laravel application configured to run inside a Dockerized environment for easy local development.

---

#### 🧰 Requirements

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)

---

## ▶️ Getting Started

1. Clone the repository:

```bash
git clone git@github.com:aleexbaratieri/task-manager.git
cd task-manager
```

2 . Copy the .env file:

```bash
cp .env.example .env
```

3 . Edit the variables as needed

```bash

SYS_USER=your-user
SYS_UID=1000

NGINX_PORT=80

DB_ROOT_PASSWORD=secret
DB_PASSWORD=secret
DB_USERNAME=laravel
DB_PORT=3306
DB_TIMEZONE=America/Sao_Paulo

REDIS_PORT=6379
REDIS_PASSWORD=secret
```

4 . Access the `app` folder

```bash
cd app
```

5 . Start the containers:

```bash
docker compose up -d
```

6. Install dependencies via Composer:

```bash
docker compose exec app composer install
```

7 . Generate the application key:

```bash
docker compose exec app php artisan key:generate
```

8 . Run the database migrations:

```bash
docker compose exec app php artisan migrate
```

## 🐳 Services
    - Api (Laravel)	    http://localhost/api
    - MySQL	            localhost:3306
    - Redis             localhost:6379

## 📦 Useful Commands

Access the app container:

```bash
docker compose exec app bash
```

Run tests:

```bash
docker compose exec app php artisan test
```

Stop and remove containers:

```bash
docker compose down
```

---
## Project Description:

Our clients operate in the real estate sector, managing multiple buildings within their accounts. We need to provide a tool that allows our owners to create tasks for their teams to perform within each building and add comments to their tasks for tracking progress.. These tasks should be assignable to any team member and have statuses such as Open, In Progress, Completed, or Rejected. 


#### Technical Requirements: 

- [x] Develop an application using Laravel 10 with REST architecture. 
- [x] Implement GET endpoint for listing tasks of a building along with their comments. 
- [x] Implement POST endpoint for creating a new task. 
- [x] Implement POST endpoint for creating a new comment for a task. 
- [x] Define the payload structure for task and comment creation, considering necessary relationships and information for possible filters. 
- [x] Implement filtering functionality, considering at least three filters such as date range of creation and assigned user, or task status and the building it belongs to.


#### Expected Deliverables: 


- [x] Provide the application in a public GitHub repository 
- [x] Include migrations for table construction. 
- [x] Organize code with clear separation of responsibilities. 
- [x] Implement unit tests to ensure code reliability. 
- [x] Provide detailed installation instructions in the readme. 
- [x] Ensure adherence to coding standards, specifically PSR-12.

#### Bonus: 

- [x] Containerize the application using Docker. 
- [x] Type methods and parameters for improved code clarity. 
- [x] Include descriptive PHPDoc in the methods.
