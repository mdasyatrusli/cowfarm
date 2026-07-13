# GIT WORKFLOW — COWFARM SAAS

## Purpose
Mengatur standar penggunaan Git agar tim atau AI bekerja dengan aman dan terstruktur.

---

## BRANCH STRUCTURE

- main → production
- develop → development
- feature/* → fitur baru
- fix/* → bug fix

---

## WORKFLOW

### 1. FEATURE DEVELOPMENT
1. Buat branch feature
2. Kerjakan fitur
3. Commit kecil dan jelas
4. Push ke remote
5. Pull request ke develop

---

### 2. BUG FIX
1. Buat branch fix/*
2. Perbaiki bug
3. Test ulang
4. Merge ke develop

---

## COMMIT RULES

Format:
type: message


Contoh:
- feat: add cow module
- fix: resolve login error
- refactor: clean controller

---

## RULES
- Commit harus kecil
- Jangan commit fitur besar sekaligus
- Jangan push langsung ke main

---

## BEST PRACTICES
- Gunakan branch terpisah
- Gunakan PR sebelum merge
- Selalu review code

---

## ANTI PATTERNS
- Commit besar ❌
- Push langsung ke main ❌
- Tidak pakai branch ❌

---

## KEY PRINCIPLE
> "Safe code is version controlled code"
