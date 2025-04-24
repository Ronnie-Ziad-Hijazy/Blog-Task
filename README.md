# 📘 API Documentation

## Overview
This API provides endpoints for managing posts, categories, and activity logs. It supports full CRUD operations and logs all actions for audit purposes.

---

## Endpoints

### `POST /api/posts`
**Create a new post.**

**Controller:** `PostController@store`
**Service:** `PostService::createPost($data)`

#### Validation Rules
- `title`: required, string, max:255
- `content`: required, string
- `author`: required, string
- `category_id`: optional, must exist in categories

#### Response (201)
```json
{
  "status": true,
  "message": "Post Created Successfully.",
  "post": {
    "id": 1,
    "title": "My First Post"
  }
}
```

---

### `GET /api/posts/{id}`
**Retrieve a post by ID.**

**Controller:** `PostController@show`

#### Response (200)
```json
{
    "status": true,
    "message": "Post retrieved successfully.",
    "post": {
        "id": 48,
        "title": "ronnie hijazy 1",
        "content": "ronnie hijazy content 2",
        "author": "Ronnie hijazy 2",
        "created_at": "2025-04-23T10:34:33.000000Z",
        "updated_at": "2025-04-24T12:34:07.000000Z"
    }
}
```

---

### `PUT /api/posts/{id}`
**Update a post.**

**Controller:** `PostController@update`
**Service:** `PostService::updatePost($id, $data)`

#### Request Body
```json
{
  "title": "Updated Title",
  "content": "Updated content.",
  "author" : "Ronnie",
  "category_id" : 13
}
```

#### Response (200)
```json
{
  "status": true,
  "message": "Post Updated Successfully.",
  "post": {
    "id": 1,
    "title": "Updated Title",
    "content": "Deleted Content Post",
    "author": "Ronnie",
    "created_at": "2025-04-23T10:34:33.000000Z",
    "updated_at": "2025-04-24T12:34:07.000000Z"
  }
}
```

---

### `DELETE /api/posts/{id}`
**Delete a post.**

**Controller:** `PostController@destroy`
**Service:** `PostService::deletePost($id)`
**Logging:** `ActivityLogService::log('DELETE', 'Post', $post->id)`

#### Response
```json
{
  "status": true,
  "message": "Post Deleted.",
  "post": {
    "id": 1,
    "title": "Deleted Post",
    "content": "Deleted Content Post",
    "author": "Ronnie",
    "created_at": "2025-04-23T10:34:33.000000Z",
    "updated_at": "2025-04-24T12:34:07.000000Z"
  }
}
```

---

### `GET /api/categories`
**Retrieve all categories.**

**Controller:** `CategoryController@index`

#### Response
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "Breaking News",
      "slug": "breaking-news",
      "description": "Description 1",
      "created_at": "2025-04-24T13:05:19.000000Z",
      "updated_at": "2025-04-24T21:24:42.000000Z"
    },
    {
      "id": 2,
      "name": "Events",
      "slug": "events",
      "description": "Description 2",
      "created_at": "2025-04-24T13:05:19.000000Z",
      "updated_at": "2025-04-24T21:24:42.000000Z"
    }
  ],
  "first_page_url": "http://localhost:8000/api/categories?page=1",
  "from": 1,
  "last_page": 5,
  "last_page_url": "http://localhost:8000/api/categories?page=5",
  "next_page_url": "http://localhost:8000/api/categories?page=2",
  "path": "http://localhost:8000/api/categories",
  "per_page": 2,
  "prev_page_url": null,
  "to": 2,
  "total": 10
}
```

---

### `GET /api/activity-logs`
**Retrieve activity logs with filtering.**

**Controller:** `ActivityLogController@index`

#### Query Parameters
- `action_type`: e.g. CREATE, UPDATE, DELETE, READ
- `entity_type`: e.g. Post, Category
- `entity_id`: e.g. 1,2,3
- `sort`: e.g. desc, asc

#### Request
`http://localhost:8000/api/activity-logs?sort=desc&action_type=DELETE&entity_type=Post&entity_id=566`

#### Response
```json
{
    "success": true,
    "logs": {
        "current_page": 1,
        "data": [
            {
                "id": 5020,
                "action_type": "DELETE",
                "changed_fields": null,
                "entity_type": "Post",
                "entity_id": 566,
                "created_at": "2025-04-24T21:38:10.000000Z",
                "updated_at": "2025-04-24T21:38:10.000000Z"
            }
        ],
        "first_page_url": "http://localhost:8000/api/activity-logs?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/activity-logs?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8000/api/activity-logs?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost:8000/api/activity-logs",
        "per_page": 10,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```

---

## Services Overview

### PostService
- `createPost(array $data)`
- `updatePost(int $id, array $data)`
- `deletePost(int $id)`

### ActivityLogService
- `log(string $action, string $entityType, int $entityId, ?array $changedFields = null)`

---

## Notes
- Make sure to authenticate users if needed.
- All endpoints return JSON responses.
- All activity logs are automatically recorded via `ActivityLogService`.

---

## Testing
Use Postman or Swagger UI to test endpoints. All CRUD operations should be followed by appropriate activity logging.

---

## Setup Instructions
1. Clone the repo.
2. Run `composer install`
3. Configure `.env` file.
4. Run migrations: `php artisan migrate:fresh --seed`
5. Serve: `php artisan serve`

---

## Assumptions
- Categories exist before posts can be created with a category_id.
- Logging does not duplicate actions on the same day for the same entity/action.
