# Barangay Bulletin: Purok Flores

**Student Name:** Kauri Lorraine Flores  
**Repository:** `LabActivity11-Flores`  

---

## Seeded Accounts
- **Kagawad Account (Can create posts & comment):**
  - **Email:** `kagawad.flores@bulletin.test`
  - **Password:** `bulletin2026`
- **Resident Account (Can comment only):**
  - **Email:** `lola.flores@bulletin.test`
  - **Password:** `bulletin2026`

---

## Personalized Tags
- `Purok Flores`
- `Urgent`
- `Libre`
- `Schedule`
- `Bayanihan` (Custom tag)

---

## Eloquent Relationships Used
- **User `hasOne` Author / Author `belongsTo` User:** Links a login account (`users.id`) to an official Kagawad author profile (`authors.user_id`) so only officials can publish announcements while residents remain standard users.
- **Author `hasMany` Post / Post `belongsTo` Author:** Connects each Kagawad author to the announcements they wrote via `posts.author_id`.
- **Post `hasMany` Comment / Comment `belongsTo` Post:** Connects each bulletin post to its resident comments via `comments.post_id`.
- **User `hasMany` Comment / Comment `belongsTo` User:** Tracks which logged-in resident or official wrote each comment via `comments.user_id`.
- **Post `belongsToMany` Tag / Tag `belongsToMany` Post:** Connects posts and tags in a many-to-many relationship through the alphabetical `post_tag` pivot table (`post_id`, `tag_id`).
- **Author `hasManyThrough` Comment (via Post):** Allows an author's profile page (`/authors/{author}`) to count and access all comments received across all of their published posts.

---

## How to Run Locally

1. **Install PHP dependencies:**
   ```bash
   composer install

3. **Configure Environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate

    Configure MySQL in ```.env:
    ```DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=barangay_bulletin_lab11_db
    DB_USERNAME=root
    DB_PASSWORD=

4. **Run Migrations & Seeders:**
    ```bash
    php artisan migrate:fresh --seed

5. **Install & Build Frontend Assets:**
    ```bash
    npm install
    npm run dev

5. **Start Dev Server:**
    ```bash
    php artisan serve