# API DESIGN — COWFARM SAAS

## Purpose
Standar desain API agar konsisten, scalable, dan mudah diintegrasikan.

---

## API Style
- RESTful API
- JSON response standard

---

## Response Format

### Success
```json
{
  "status": "success",
  "message": "Data retrieved",
  "data": {}
}

{
  "status": "error",
  "message": "Something went wrong"
}
Rules
Tidak boleh return model langsung
Harus pakai Resource class
Harus pakai HTTP status code

HTTP Status Code
200 OK
201 Created
400 Bad Request
401 Unauthorized
403 Forbidden
500 Server Error

API Structure

/api/v1/module/resource

Contoh:

/api/v1/cows
/api/v1/milk-records

Best Practices
Gunakan API Resource
Gunakan pagination
Gunakan validation request
Anti Patterns
Response tidak konsisten ❌
Return model langsung ❌
Logic di controller ❌
