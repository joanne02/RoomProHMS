<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">🏨 ROOMPRO Hostel Management System (Laravel)</h1>

<p align="center">
  A web application built with Laravel for managing hostel operations, designed for both administrators and residents. The system not only simplifies tasks such as room allocation, resident information, and user access control, but also introduces an advanced room allocation algorithm (based on genetic algorithms) to optimize room assignments according to resident preferences. 
</p>

---

## 🔑 Key Features
- **Role-based Access Control** using Laravel Bouncer (admin & resident roles)
- **Admin Panel**: Manage rooms, resident details, applications, visitors, facilities, complaints, and announcements
- **Resident Portal**: Submit applications, view room assignments, and manage personal data
- **Room Allocation System**: 
  - Uses a **Genetic Algorithm** to optimize room assignments based on applicant preferences
  - Processes applications in **batches of 50** for efficiency
- **Background Job Processing** with Laravel Workers for time-consuming tasks (e.g., room allocation)

---

## 🛠️ Technologies Used
- **Backend**: Laravel (PHP)
- **Database**: MySQL
- **Frontend**: Blade, Bootstrap, jQuery
- **Authentication & Authorization**: Laravel Bouncer
- **Task Queue**: Laravel Workers
- **Algorithm**: Genetic Algorithm (for room allocation)

---

## 📌 Scope of the System
1. **Hostel CRUD Functionalities**
   - Resident & housing management  
   - Application management  
   - Facilities management  
   - Visitor tracking  
   - Complaint & feedback handling  
   - Announcement notices  

2. **Room Allocation**
   - Optimized assignments through a **Genetic Algorithm**
   - Batch processing (50 applications per run) for performance  

---

## 🚀 Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/hostel-management-system.git
   cd hostel-management-system
