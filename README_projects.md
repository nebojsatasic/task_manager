## Endpoints

Base URL: `https://task-mng.nebojsatasic.com/api`

### Public Routes

These routes are accessible without authentication. No token or authorization header is required.

#### `POST /register`

Registers a new user and retrieves a token.

**Required Fields:**
- `name` – string, required
- `email` – string (valid email format), required, unique
- `job_title` – string, required
- `password` – string (min 6 characters), required
- `password_confirmation` – string (must match password), required

**Example Request:**  
`POST https://task-mng.nebojsatasic.com/api/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@gmail.com",
  "job_title": "Software Engineer",
  "password": "secret",
  "password_confirmation": "secret"
}
```

**Response:**
```json
{
  "user": {
    "name": "John Doe",
    "email": "john@gmail.com",
    "job_title": "Software Engineer",
    "updated_at": "2025-05-19T13:22:41.000000Z",
    "created_at": "2025-05-19T13:22:41.000000Z",
    "id": 1
  },
  "access-token": "access_token_here",
  "token-type": "bearer token"
}
```

#### `POST /login`

Authenticates a user and returns an access token for future requests.

**Required Fields:**
- `email` – string (valid email format), required
- `password` – string (min 6 characters), required

**Example Request:**  
`POST https://task-mng.nebojsatasic.com/api/login`

**Request Body:**
```json
{
  "email": "john@gmail.com",
  "password": "secret"
}
```

**Response:**
```json
{
  "access-token": "access_token_here",
  "token-type": "bearer token"
}
```

### Authenticated Routes

All routes below require a valid Bearer token in the `Authorization` header.

**Example Header:**  
`Authorization: Bearer your_access_token_here`

#### `GET /user`

Retrieves the authenticated user's data.

**Example Request:**  
`GET https://task-mng.nebojsatasic.com/api/user`

**Response:**
```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@gmail.com",
    "job_title": "Software Engineer"
  }
}
```

#### `POST /logout`

Logs out the authenticated user by revoking the current access token.

**Example Request:**  
`POST https://task-mng.nebojsatasic.com/api/logout`

**Response:**
```json
{
  "message": "Logged out"
}
```

#### `GET /projects`

Retrieves a list of all projects the currently authenticated user is a member of.

Optionally includes related `tasks`, `members`, or both using the `include` query parameter.

**Query Parameters:**
- `include=tasks` – include related tasks
- `include=members` – include project members
- `include=tasks,members` – include both tasks and members

**Example Request:**  
`GET https://task-mng.nebojsatasic.com/api/projects?include=tasks,members`

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Company Website Redesign",
      "description": "Redesign the company website to improve UX, update branding, and optimize for performance and SEO.",
      "creator": {
        "id": 1,
        "name": "John Doe",
        "email": "john@gmail.com",
        "job_title": "Software Engineer"
      },
      "creation-date": "2025-05-19",
      "tasks": [
        {
          "id": 1,
          "title": "Plan New Layout",
          "description": "Sketch new homepage and contact page.",
          "project_title": "Company Website Redesign",
          "assigned_to": {
            "id": 2,
            "name": "Alice Johnson",
            "email": "alice@gmail.com",
            "job_title": "Web Designer"
          },
          "status": "finished",
          "creation-date": "2025-05-19"
        },
        // More tasks
      ],
      "members": [
        {
          "id": 1,
          "name": "John Doe",
          "email": "john@gmail.com",
          "job_title": "Software Engineer"
        },
        // more members
      ]
    },
    // more projects
  ],
  "links": {
    "first": "http://localhost:8000/api/projects?page=1",
    // more links
  },
  "meta": {
    "current_page": 1,
    // more meta data
  }
}
```

#### `GET /projects/{project}`

Retrieves a specific project by its ID.

Access is restricted to users who are members of the project.

The response always includes the project's tasks and members.

**Path Parameters:**
- `{project}` – required, numeric ID of the project

**Example Request:**  
`GET https://task-mng.nebojsatasic.com/api/projects/1`

**Response:**
```json
{
  "data": {
    "id": 1,
    "title": "Company Website Redesign",
    "description": "Redesign the company website to improve UX, update branding, and optimize for performance and SEO.",
    "creator": {
      "id": 1,
      "name": "John Doe",
      "email": "john@gmail.com",
      "job_title": "Software Engineer"
    },
    "creation-date": "2025-05-19",
    "tasks": [
      {
        "id": 1,
        "title": "Plan New Layout",
        "description": "Sketch new homepage and contact page.",
        "project_title": "Company Website Redesign",
        "assigned_to": {
          "id": 2,
          "name": "Alice Johnson",
          "email": "alice@gmail.com",
          "job_title": "Web Designer"
        },
        "status": "finished",
        "creation-date": "2025-05-19"
      },
      {
        "id": 2,
        "title": "Update Text Content",
        "description": "Write new About and Services page content.",
        "project_title": "Company Website Redesign",
        "assigned_to": {
          "id": 3,
          "name": "Bob Smith",
          "email": "bob@gmail.com",
          "job_title": "Content Writer"
        },
        "status": "open",
        "creation-date": "2025-05-20"
      },
      {
        "id": 3,
        "title": "Build New Pages",
        "description": "Code homepage and contact page with new layout.",
        "project_title": "Company Website Redesign",
        "assigned_to": {
          "id": 4,
          "name": "Carla Reyes",
          "email": "carla@gmail.com",
          "job_title": "Frontend Developer"
        },
        "status": "open",
        "creation-date": "2025-05-20"
      }
    ],
    "members": [
      {
        "id": 1,
        "name": "John Doe",
        "email": "john@gmail.com",
        "job_title": "Software Engineer"
      },
      {
        "id": 2,
        "name": "Alice Johnson",
        "email": "alice@gmail.com",
        "job_title": "Web Designer"
      },
      {
        "id": 3,
        "name": "Bob Smith",
        "email": "bob@gmail.com",
        "job_title": "Content Writer"
      },
      {
        "id": 4,
        "name": "Carla Reyes",
        "email": "carla@gmail.com",
        "job_title": "Frontend Developer"
      }
    ]
  }
}
```

#### `POST /projects`

Creates a new project.

**Fields:**
- `title` – string (max 255 characters), **required**
- `description` – text, optional

**Example Request:**  
`POST https://task-mng.nebojsatasic.com/api/projects`

**Request Body:**
```json
{
  "title": "Website Redesign",
  "description": "Redesign the company website to improve UX, update branding, and optimize for performance and SEO."
}
```

**Response:**
```json
{
  "data": {
    "id": 1,
    "title": "Website Redesign",
    "description": "Redesign the company website to improve UX, update branding, and optimize for performance and SEO.",
    "creator": {
      "id": 1,
      "name": "John Doe",
      "email": "john@gmail.com",
      "job_title": "Software Engineer"
    },
    "creation-date": "2025-05-19"
  }
}
```

#### `PUT /projects/{project}` or `PATCH /projects/{project}`

Updates a specific project by its ID.

Only the creator of a project can update it.

**Path Parameters:**
- `{project}` – required, numeric ID of the project

**Optional Fields:**
- `title` – string (max 255 characters)
- `description` – text

**Example Request:**  
`PATCH https://task-mng.nebojsatasic.com/api/projects/1`

**Request Body:**
```json
{
  "title": "Company Website Redesign"
}
```

**Response:**
```json
{
  "data": {
    "id": 1,
    "title": "Company Website Redesign",
    "description": "Redesign the company website to improve UX, update branding, and optimize for performance and SEO.",
    "creator": {
      "id": 1,
      "name": "John Doe",
      "email": "john@gmail.com",
      "job_title": "Software Engineer"
    },
    "creation-date": "2025-05-19"
  }
}
```

#### `DELETE /projects/{project}`

Deletes a specific project by its ID.

Only the creator of a project can delete it.

**Path Parameters:**
- `{project}` – required, numeric ID of the project

**Example Request:**  
`DELETE https://task-mng.nebojsatasic.com/api/projects/1`

**Response:**
- Status: `204 No Content`
- Time: `984 ms`
- Size: `0 B`

#### `POST /projects/{project}/members/{user}`

Attach a user as a member to the given project.

Only the creator of the project is authorized to perform this action.

If the user is already a member of the project, no duplicate entries will be made in the database.

**Path Parameters:**
- `{project}` – required, numeric ID of the project
- `{user}` – required, numeric ID of the user

**Example Request:**  
`POST https://task-mng.nebojsatasic.com/api/projects/1/members/2`

**Response:**
```json
{
  "message": "Member attached successfully."
}
```

#### `DELETE /projects/{project}/members/{user}`

Detach a user from the given project.

Only the creator of the project is authorized to perform this action.

If the user is not a member of the project, no action will be performed.

**Path Parameters:**
- `{project}` – required, numeric ID of the project
- `{user}` – required, numeric ID of the user

**Example Request:**  
`DELETE https://task-mng.nebojsatasic.com/api/projects/1/members/2`

**Response:**
```json
{
  "message": "Member detached successfully."
}
```

