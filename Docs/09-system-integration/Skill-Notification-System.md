# NOTIFICATION SYSTEM — COWFARM SAAS

## Purpose
Mengatur sistem notifikasi multi-channel (email, database, WhatsApp).

---

## CORE PRINCIPLE
- Semua notifikasi harus terstruktur
- Tidak boleh hardcode pesan
- Harus bisa multi-channel

---

## NOTIFICATION CHANNELS

### 1. Email
- Laravel Mail
- SMTP / Mailgun

### 2. Database
- In-app notification
- Tersimpan di tabel notifications

### 3. WhatsApp (optional)
- API gateway external

---

## FLOW SYSTEM

Event Trigger →
Notification Class →
Channel Selection →
Queue →
Send Notification

---

## LARAVEL STRUCTURE

- app/Notifications
- database/notifications table

---

## RULES
- Gunakan Notification class
- Semua notifikasi harus queued
- Tidak boleh kirim langsung di controller

---

## BEST PRACTICES
- Gunakan multi-channel fallback
- Gunakan template message
- Gunakan queue untuk email/WA

---

## EXAMPLE USE CASE
- Cow sakit → notify admin
- Milk record added → log notification
- User registered → welcome email

---

## ANTI PATTERNS
- Hardcoded message ❌
- Send email langsung ❌
- No queue ❌

---

## KEY PRINCIPLE
> "Notification is a system, not a function"
