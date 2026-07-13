# API Rules

## Purpose

Standar API REST.

---

## Style

RESTful

JSON

---

## Version

/api/v1/

---

## Response

Success

{
status,
message,
data
}

Error

{
status,
message
}

---

## Validation

Semua endpoint:

FormRequest

---

## Authentication

Gunakan:

Sanctum

---

## Status Code

200

201

400

401

403

404

422

500

---

## Never

Return Model langsung.

Gunakan Resource.
