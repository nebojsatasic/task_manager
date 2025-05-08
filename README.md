## Endpoints

Base URL: `https://project-manager.nebojsatasic.com/api`

### Public Routes

These routes are accessible without authentication. No token or authorization header is required.

#### `POST /register`

Register a new user and retrieve a token.

**Required Fields:**
- `name` – string, required
- `email` – string (valid email format), required, unique
- `password` – string (min 6 characters), required
- `password_confirmation` – string (must match password), required

**Example Request:** `POST https://project-manager.nebojsatasic.com/api/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret123",
  "password_confirmation": "secret123"
}
```

**Response:**
```json
{
  "message": "User registered successfully",
  "token": "access_token_here"
}
```

#### `POST /login`

Authenticate a user and return an access token for future requests.

**Required Fields:**
- `email` – string (valid email format), required
- `password` – string (min 6 characters), required

**Example Request:** `POST https://project-manager.nebojsatasic.com/api/login`

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "secret123",
}
```

**Response:**
```json
{
  "message": "User logged successfully",
  "token": "access_token_here"
}
```

### Authenticated Routes

All routes below require a valid Bearer token in the `Authorization` header.

**Example Header:** `Authorization: Bearer your_access_token_here`

#### `GET /projects`

Retrieve a list of all projects. Optionally include related tasks, members, or both using the include query parameter.

**Query Parameters:**
- `include=tasks` – include related tasks
- `include=members` – include project members
- `include=tasks,members` – include both tasks and members

**Example Request:** `GET https://project-manager.nebojsatasic.com/api/projects?include=tasks,members`

**Response:**
```json
{
}
```
