# 📚 Library Management System - CodeIgniter 4

This is a **full-stack web application** built with **CodeIgniter 4**, starting with a RESTful API backend to manage data for a library system. It includes models, controllers, and migrations for managing books, authors, publishers, members, and borrow transactions. The project is designed to be modular and scalable, with a focus on clean architecture and best practices. This project uses AJAX for frontend interactions, allowing for a responsive user interface. and Datatables for displaying data.

---

## ✨ Features

- RESTful API for managing:

  - **Books** (linked to Authors and Publishers)
  - **Authors**
  - **Publishers**
  - **Members**
  - **Borrow Transactions** (linked to Books and Members)

- Input validation via model rules

- Foreign key checks (e.g., book, author, publisher, member must exist)

- Base API controller for reusable success/error response handling

- Modular and scalable project structure

---

## 🧱 Entity Structure

| Table                 | Description                           |
| --------------------- | ------------------------------------- |
| `authors`             | Stores book authors                   |
| `publishers`          | Stores book publishers                |
| `books`               | Linked to both authors and publishers |
| `members`             | Library members                       |
| `borrow_transactions` | Book borrowing records                |

---

## 🛠️ Requirements

- PHP 8.1 or higher
- SQL Server
- Composer
- PHP Extensions:

  - `intl`
  - `mbstring`
  - `json` (enabled by default)
  - `mysqlnd`

---

## 🚀 Getting Started

### 🔧 Installation (From Git Repository)

```bash
git clone https://github.com/Jonathan0823/library-management-ci
cd library-management-ci
composer install
cp env .env
php spark key:generate
php spark serve
```

> ⚠️ Make sure you configure the `.env` file with your correct `baseURL` and database credentials.

---

## ⚙️ Environment Setup

Update your `.env` file like this:

```
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = library_db
database.default.username = root
database.default.password =
database.default.DBDriver = SQLSRV
```

Then, create the database and run your migration or import the schema manually based on your ERD.

To run migrations, use:

```bash
php spark migrate
```

---

## 📱 API Endpoints

### 🔍 Books

| Method | Endpoint          | Description         |
| ------ | ----------------- | ------------------- |
| GET    | `/api/books`      | Get all books       |
| GET    | `/api/books/{id}` | Get a specific book |
| POST   | `/api/books`      | Create a new book   |
| PUT    | `/api/books/{id}` | Update a book       |
| DELETE | `/api/books/{id}` | Delete a book       |

Similar CRUD endpoints are available for:

- `/api/authors`
- `/api/publishers`
- `/api/members`

### ↻ Borrow Transactions

| Method | Endpoint            | Description                     |
| ------ | ------------------- | ------------------------------- |
| GET    | `/api/borrows`      | List all borrow transactions    |
| GET    | `/api/borrows/{id}` | Get a single borrow transaction |
| POST   | `/api/borrows`      | Create a new borrow record      |
| PUT    | `/api/borrows/{id}` | Update borrow record            |
| DELETE | `/api/borrows/{id}` | Delete borrow record            |

The controller checks whether the `book_id` and `member_id` exist before creating a borrow transaction.

---

## ✅ Validation

- Uses built-in model validation rules (`$validationRules`) for input checks
- Manual foreign key validation to ensure references to `authors`, `publishers`, and `members` are valid

---

## 🔐 Security & Best Practices

- `public/` directory is the only web-accessible folder (secure entry point)
- Use virtual host or configure your web server to serve from the `public/` directory only
- Consistent JSON response structure for errors and success messages

---

## 🚪 Frontend Page Routing

These are the planned frontend routes for managing the library system:

| Route         | Description                    |
| ------------- | ------------------------------ |
| `/`           | View and manage book data      |
| `/authors`    | Manage author list             |
| `/publishers` | Manage publisher list          |
| `/members`    | Manage library members         |
| `/borrows`    | View and manage borrow records |

> These pages will consume the API and provide a responsive UI for managing the library system.

---
