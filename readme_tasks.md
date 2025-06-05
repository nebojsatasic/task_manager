#### `GET /tasks`

Retrieves a list of all tasks of projects that the authenticated user is a member of.

**Example Request:**  
`GET https://task-mng.nebojsatasic.com/api/tasks`

**Response:**
```json
{
  "data": [
    {
      "id": 5,
      "title": "Write Posts for Social Networks",
      "description": "Create short, engaging text content for Facebook, Instagram, and LinkedIn to promote the campaign.",
      "project_title": "Company Marketing Campaign",
      "assigned_to": {
        "id": 3,
        "name": "Bob Smith",
        "email": "bob@gmail.com",
        "job_title": "Content Writer"
      },
      "status": "open",
      "creation-date": "2025-05-21"
    },
    // more tasks
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
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/tasks?page=1",
    // more links
  },
  "meta": {
    "current_page": 1,
    // more meta data
    "total": 5
  }
}
```

#####Sorting

By default, tasks are sorted by `created_at` (newest first).

You can override this using the `sort` query parameter. Multiple fields can be combined, separated by commas.

**Allowed sort fields:**
- `title`
- `is_done`
- `created_at`

**Prefix a field with `-` to sort in descending order.**

**Examples:**
- `GET /tasks?sort=title` – Sort by title (ascending)
- `GET /tasks?sort=-created_at` – Sort by creation date (descending)
- `GET /tasks?sort=title,created_at` – Sort by title, then by creation date
- `GET /tasks?sort=-title,-created_at` – Sort by title and creation date (both descending)

##### Filtering

You can filter tasks by their `is_done` status using the `filter[is_done]` query parameter.

**Accepted values:** `true`, `1`, `false`, `0` (as strings)

**Examples:**
- `GET /tasks?filter[is_done]=true` – Returns only **completed** tasks
- `GET /tasks?filter[is_done]=false` – Returns only **incomplete** tasks

**👉 Note:** You can combine filtering and sorting.

Example:  
`GET /tasks?filter[is_done]=true&sort=title`

#### `GET /tasks/{task}`

Retrieves a specific task by its ID.

Access is restricted to users who are members of the project to which the task belongs.

**Path Parameters:**
- `{task}` – required, numeric ID of the task

**Example Request:**  
`GET https://task-mng.nebojsatasic.com/api/tasks/1`

**Response:**
```json
{
  "data": {
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
  }
}
```

#### `POST /tasks`

Creates a new task.

Tasks belong to a specific project. Only members of a project are allowed to create tasks within that project.

To create a task, the authenticated user must be a member of the project specified in the request body.

**Fields:**
- `title` – string (max 255 characters), **required**
- `description` – text, optional
- `is_done` – boolean, optional
- `project_id` – integer, optional

**Example Request:**  
`POST https://task-mng.nebojsatasic.com/api/tasks`

**Request Body:**
```json
{
  "title": "Plan New Layout",
  "description": "Sketch new homepage and contact page.",
  "project_id": 1
}
```

**Response:**
```json
{
  "data": {
    "id": 1,
    "title": "Plan New Layout",
    "description": "Sketch new homepage and contact page.",
    "project_title": "Company Website Redesign",
    "assigned_to": null,
    "status": "open",
    "creation-date": "2025-05-19"
  }
}
```

#### `PUT /tasks/{task}` or `PATCH /tasks/{task}`

Updates a specific task by its ID.

Only the creator of a task can update it.

**Path Parameters:**
- `{task}` – required, numeric ID of the task

**Optional Fields:**
- `title` – string (max 255 characters)
- `description` – text
- `is_done` – boolean
- `project_id` – integer

**Example Request:**  
`PATCH https://task-mng.nebojsatasic.com/api/task/1`

**Request Body:**
```json
{
  "is_done": true
}
```

**Response:**
```json
{
  "data": {
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
  }
}
```

#### `DELETE /task/{task}`

Deletes a specific task by its ID.

Only the creator of a task can delete it.

**Path Parameters:**
- `{task}` – required, numeric ID of the task

**Example Request:**  
`DELETE https://task-mng.nebojsatasic.com/api/tasks/1`

**Response:**
- Status: `204 No Content`
- Time: `689 ms`
- Size: `0 B`

#### `GET /me/tasks`

Retrieves all tasks created by the authenticated user.

**Example Request:**  
`GET https://task-mng.nebojsatasic.com/api/me/tasks`

**Response:**
```json
{
  "data": [
    {
      "id": 4,
      "title": "Create Campaign Strategy",
      "description": "Plan goals, target audience, and platforms.",
      "project_title": "Company Marketing Campaign",
      "assigned_to": {
        "id": 5,
        "name": "Emma Clark",
        "email": "emma@gmail.com",
        "job_title": "Marketing Manager"
      },
      "status": "finished",
      "creation-date": "2025-05-21"
    },
    {
      "id": 5,
      "title": "Write Posts for Social Networks",
      "description": "Create short, engaging text content for Facebook, Instagram, and LinkedIn to promote the campaign.",
      "project_title": "Company Marketing Campaign",
      "assigned_to": {
        "id": 3,
        "name": "Bob Smith",
        "email": "bob@gmail.com",
        "job_title": "Content Writer"
      },
      "status": "open",
      "creation-date": "2025-05-21"
    }
  ]
}
```

#### `PATCH /tasks/{task}/assign/{user}`

Assigns the project member to the task.

Each task can be assigned to only one member; assigning multiple users is not supported.

Only the creator of the task is authorized to perform this action.

**Path Parameters:**
- `{task}` – required, numeric ID of the task
- `{user}` – required, numeric ID of the user

**Example Request:**  
`PATCH https://task-mng.nebojsatasic.com/api/tasks/1/assign/2`

**Response:**
```json
{
  "data": {
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
    "status": "open",
    "creation-date": "2025-05-19"
  }
}
```

#### `PATCH /tasks/{task}/unassign`

Unassign the project member from the task.

Only the creator of the project is authorized to perform this action.

**Path Parameters:**
- `{task}` – required, numeric ID of the task

**Example Request:**  
`PATCH https://task-mng.nebojsatasic.com/api/tasks/1/unassign`

**Response:**
```json
{
  "data": {
    "id": 1,
    "title": "Plan New Layout",
    "description": "Sketch new homepage and contact page.",
    "project_title": "Company Website Redesign",
    "assigned_to": null,
    "status": "open",
    "creation-date": "2025-05-19"
  }
}
```

#### `GET /me/tasks/assigned`

Retrieves all tasks assigned to the authenticated user.

**Example Request:**  
`GET https://task-mng.nebojsatasic.com/api/me/tasks/assigned`

**Response:**
```json
{
  "data": [
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
      "id": 5,
      "title": "Write Posts for Social Networks",
      "description": "Create short, engaging text content for Facebook, Instagram, and LinkedIn to promote the campaign.",
      "project_title": "Company Marketing Campaign",
      "assigned_to": {
        "id": 3,
        "name": "Bob Smith",
        "email": "bob@gmail.com",
        "job_title": "Content Writer"
      },
      "status": "open",
      "creation-date": "2025-05-21"
    }
  ]
}
```
