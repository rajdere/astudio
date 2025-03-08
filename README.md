# Laravel Project Management System

## 🚀 Introduction
This is a comprehensive Laravel-based project management system with dynamic EAV attributes, RESTful API endpoints, and Passport authentication.

---

## 📋 Features
- User, Project, and Timesheet models with appropriate relationships.
- Dynamic EAV (Entity-Attribute-Value) system for Projects.
- RESTful API endpoints for CRUD operations.
- Flexible filtering for both regular and EAV attributes.
- Secure authentication using Laravel Passport.
- Includes migrations, seeders, and proper validation.

---

## 🛠️ Installation

1. **Clone the repository:**
```bash
git clone <repository-url>
cd <project-folder>
```

2. **Install dependencies:**
```bash
composer update
```

3. **Set environment variables:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Run Migrations & Seeders:**
```bash
php artisan migrate --seed
```

5. **Install Laravel Passport:**
```bash
php artisan passport:install
```

6. **Run the application:**
```bash
php artisan serve
```

---

## 🔐 Authentication Endpoints

| Endpoint         | Method | Description |
|------------------|--------|--------------|
| `/api/register`   | `POST` | Register new users |
| `/api/login`      | `POST` | Login and receive an access token |
| `/api/logout`     | `POST` | Logout users and revoke tokens |

**Sample Login Request**
```json
{
    "email": "user@example.com",
    "password": "password123"
}
```

**Response**
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6InhpVGp2RE0wOGF3"
}
```

---

## 📋 CRUD Endpoints

| Endpoint               | Method | Description |
|------------------------|--------|--------------|
| `/api/projects`         | `GET`  | Get all projects |
| `/api/projects/{id}`    | `GET`  | Get project details by ID |
| `/api/projects`         | `POST` | Create a new project |
| `/api/projects/{id}`    | `PUT`  | Update a project |
| `/api/projects/{id}`    | `DELETE`| Delete a project |

---

## 🔍 Filtering Example
To filter projects by both standard and dynamic attributes:
```
GET /api/projects?filters[name]=ProjectA&filters[department]=IT
```
**Supported Operators:** `=`, `>`, `<`, `LIKE`

---

## 📂 Database Structure
### Users Table
- `id`, `first_name`, `last_name`, `email`, `password`

### Projects Table
- `id`, `name`, `status`

### Timesheets Table
- `id`, `task_name`, `date`, `hours`, `user_id`, `project_id`

### Attributes Table (EAV)
- `id`, `name`, `type`

### AttributeValues Table (EAV)
- `id`, `attribute_id`, `entity_id`, `value`

---

## 🧪 Sample Test Credentials
- **Email:** `admin@example.com`
- **Password:** `password123`

---

## 📄 Sample API Requests
**Login Request**
```
POST /api/login
```
**Headers:**
```
Content-Type: application/json
```
**Body:**
```json
{
    "email": "user@example.com",
    "password": "password123"
}
```

**Authenticated Request**
```
GET /api/projects
```
**Headers:**
```
Authorization: Bearer {{token}}
```

---

## 📜 License
This project is open-source under the [MIT License](LICENSE).

---

## 🤝 Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

---

## 📧 Contact
For any questions or suggestions, please reach out at **admin@example.com**.

