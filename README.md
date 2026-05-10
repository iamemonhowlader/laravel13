# Laravel 13 JWT Auth & Admin Panel

এটি একটি আধুনিক এবং প্রিমিয়াম লাভরেল ১৩ প্রজেক্ট যাতে **JWT Authentication API** (OTP সহ) এবং একটি সুন্দর **Tailwind CSS Admin Panel** রয়েছে।

## ✨ Features
- **Laravel 13** Core
- **JWT Auth** (tymon/jwt-auth)
- **OTP System** (Login এবং Password Reset এর জন্য)
- **Modern Admin UI** (Tailwind CSS, Inter Font, Slate Theme)
- **User Management** (Admin ড্যাশবোর্ড থেকে ইউজার কন্ট্রোল)
- **SQLite Database** (সহজ সেটআপের জন্য ডিফল্ট করা হয়েছে)

---

## 🛠 Installation Requirements
- PHP 8.2 or higher
- Composer
- Node.js & NPM (Asset compilation এর জন্য)

---

## 🚀 How to Install and Run

### ১. ক্লোন বা কপি করার পর ডিপেন্ডেন্সি ইনস্টল করুন:
```bash
composer install
npm install
```

### ২. .env ফাইল কনফিগার করুন:
একটি `.env` ফাইল তৈরি করুন (যদি না থাকে) এবং নিচের কমান্ড দিয়ে অ্যাপ কি (Key) জেনারেট করুন:
```bash
php artisan key:generate
```

### ৩. JWT Secret জেনারেট করুন:
API সিকিউরিটির জন্য এটি আবশ্যক:
```bash
php artisan jwt:secret
```

### ৪. ডাটাবেস সেটআপ এবং মাইগ্রেশন:
প্রজেক্টটি ডিফল্টভাবে **SQLite** ব্যবহার করছে। তাই আলাদা কোনো MySQL ডাটাবেস তৈরি করতে হবে না। শুধু মাইগ্রেশন রান করুন:
```bash
php artisan migrate --seed
```
> **Note:** `--seed` কমান্ডটি আপনার এডমিন অ্যাকাউন্ট তৈরি করে দিবে।

---

## 🔑 Admin Credentials
এডমিন প্যানেলে লগইন করতে নিচের তথ্যগুলো ব্যবহার করুন:
- **URL:** `http://laravel13.test/admin/login` (অথবা আপনার লোকাল URL)
- **Email:** `admin@admin.com`
- **Password:** `12345678`

---

## 📡 API Endpoints (Postman)
সবগুলো API এর জন্য প্রজেক্টের রুট ডিরেক্টরিতে একটি পোস্টম্যান কালেকশন দেওয়া আছে:
- **File:** `Auth_API_Collection.json`
- এটিকে Postman-এ ইমপোর্ট করুন এবং `base_url` ভেরিয়েবলটি আপনার লোকাল URL অনুযায়ী সেট করুন।

### প্রধান API লিস্ট:
- `POST /api/auth/register` - ইউজার রেজিস্ট্রেশন
- `POST /api/auth/login` - লগইন (OTP পাঠাবে)
- `POST /api/auth/login/verify-otp` - OTP ভেরিফাই করে JWT টোকেন দিবে
- `POST /api/auth/forgot-password` - পাসওয়ার্ড রিসেট OTP পাঠাবে
- `GET /api/auth/me` - প্রোফাইল তথ্য (টোকেন আবশ্যক)

---

## 💻 Running the Project
আপনি যদি Laravel Herd ব্যবহার করেন তবে সরাসরি ব্রাউজারে সাইটটি পাবেন। অন্যথায় কমান্ড লাইনে রান করতে:
```bash
php artisan serve
```
এবং এসেট (CSS/JS) ডেভেলপমেন্টের জন্য:
```bash
npm run dev
```

---

## 📄 License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
