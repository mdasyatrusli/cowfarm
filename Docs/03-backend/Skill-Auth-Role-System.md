
---

# 📁 `Skill-Auth-Role-System.md`

```md id="auth-role-001"
# AUTH & ROLE SYSTEM — COWFARM SAAS

## Purpose
Mengatur sistem login, role, dan akses user.

---

## Role System
- super_admin
- admin_farm
- user

---

## Rules
- Role tidak boleh hardcoded di controller
- Harus pakai middleware
- Harus pakai policy untuk data access

---

## Authentication Flow
1. User login
2. System check credentials
3. Assign role
4. Redirect based on role

---

## Authorization Flow
Request →
Middleware →
Policy →
Allow / Deny

---

## Middleware Rules
- CheckRole middleware wajib
- Tenant middleware wajib

---

## Database Users Table
- id
- name
- email
- password
- role
- farm_id

---

## Best Practices
- Gunakan Laravel Auth
- Gunakan Gates/Policies
- Gunakan middleware layering

---

## Anti Patterns
- Role check di view ❌
- Role hardcoded ❌
- Bypass middleware ❌

---

## Key Principle
> "Access must always be controlled, never assumed"
