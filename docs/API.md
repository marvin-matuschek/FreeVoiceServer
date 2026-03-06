# API endpoints

- [Identity](#Identity)
  - [Registration](#Registration)
  - [Login](#Login)

## Identity

### Registration

#### POST /register

Request body:

```json
{
  "username": "string",
  "email": "string",
  "password": "string"
}
```

Responses:

```json
201 Created
{
  "message": "User registered."
}
```

```json
400 Bad Request
{
  "message": "Missing or invalid data provided."
}
{
  "message": "User registration failed because the provided user data is invalid: [...]"
}
```

### Login

#### POST /login

Request body:

```json
{
  "username": "string",
  "password": "string"
}
```

Responses:

```json
200 OK
{
  "token": "string"
}
```

```json
400 Bad Request
{
  "message": "Missing or invalid data provided."
}
```
