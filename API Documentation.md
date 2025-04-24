# 📘 API Documentation

## Overview
This API provides endpoints for managing posts, categories, and activity logs. It supports full CRUD operations and logs all actions for audit purposes.

---

## Endpoints

### 📌 `POST /api/posts`
**Create a new post.**

**Controller:** `PostController@store`
**Service:** `PostService::createPost($data)`

#### Request Body
```json
{
  "title": "My First Post",
  "content": "Hello World!",
  "category_id": 1
}
```

#### Validation Rules
- `title`: required, string, max:255
- `content`: required, string
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
  "id": 1,
  "title": "My First Post",
  "content": "Hello World"
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
  "content": "Updated content."
}
```

#### Response (200)
```json
{
  "status": true,
  "message": "Post Updated Successfully.",
  "post": {
    "id": 1,
    "title": "Updated Title"
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
    "title": "Deleted Post"
  }
}
```

---

### `GET /api/categories`
**Retrieve all categories.**

**Controller:** `CategoryController@index`

#### Response
```json
[
  {"id": 1, "name": "News"},
  {"id": 2, "name": "Events"}
]
```

---

### `GET /api/activity-logs`
**Retrieve activity logs with filtering.**

**Controller:** `ActivityLogController@index`

#### Query Parameters
- `action_type`: e.g. CREATE, UPDATE, DELETE, READ
- `entity_type`: e.g. Post, Category
- `actor_id`: integer
- `date`: `YYYY-MM-DD`

#### Response
```json
[
  {
    "id": 1,
    "action_type": "DELETE",
    "entity_type": "Post",
    "entity_id": 10,
    "actor_id": 1,
    "created_at": "2025-04-24T08:23:00Z"
  }
]
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
4. Run migrations: `php artisan migrate`
5. Serve: `php artisan serve`

---

## Assumptions
- Users are authenticated via middleware.
- Categories exist before posts can be created with a category_id.
- Logging does not duplicate actions on the same day for the same entity/action.

