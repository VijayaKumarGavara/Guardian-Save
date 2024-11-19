# Guardian Save: Banking Transaction Prototype 🚀

## 📚 Project Overview  
*Guardian Save* is a web-based application designed for secure transaction requests between a guardian and a dependent. It demonstrates a simple yet effective account management system, making it a practical solution for educational and prototype use.

---

## 🛠️ Features  
- *Role-based Access*: Separate dashboards for guardians and dependents.
- *Transaction Validation*: Guardians approve or reject transaction requests.
- *Dynamic Data Handling*: Interacts with a MySQL database for user and transaction management.

---

## ⚙️ Prerequisites  

1. *Environment Setup*:  
   - Install a local server environment like [XAMPP](https://www.apachefriends.org/) or [WAMP](https://www.wampserver.com/).  
   - Ensure *PHP, **MySQL, and **Apache* are properly configured.

2. *Database Configuration*:  
   - Import the provided SQL file (guardian_safe.sql) into MySQL.  
   - Ensure the database is named test and contains the following tables:  
     - *parents*: For guardian data (e.g., token ID, UPI PIN).  
     - *children*: For dependent data (e.g., username, parent token ID).

---

## 🚀 How to Run  

### *Step-by-Step Flow*

1. *Home Page*  
   - Open index.html in your browser.  
   - *New User?*  
     - Navigate to the *Registration Page* to create a username and role (Guardian or Dependent).

2. *Login*  
   - Use your credentials to log in.  
     - *Guardian*: Redirects to dashboarda.php.  
     - *Dependent*: Redirects to dashboardb.php.

3. *Dependent Actions*  
   - After logging in, the dependent can submit transaction requests via dashboardb.php.  
   - Fill in required details (e.g., amount, reason) and send for guardian approval.

4. *Guardian Actions*  
   - Log in to dashboarda.php to view pending requests.  
   - Click on a request to navigate to approve.php.  
   - In approve.php, approve or reject requests.  
   - *Approval Flow*: If approved, you must validate the action using your UPI PIN.

5. *Approval and Completion*  
   - Upon UPI PIN validation, the request status is updated in the database, and the dependent is notified.

---

## 🗂️ File Structure  

 Guardian-Safe ├── index.html # Entry point of the application ├── register.php # User registration logic ├── dashboarda.php # Guardian dashboard ├── dashboardb.php # Dependent dashboard ├── approve.php # Guardian request approval page ├── transaction.php # Transaction completion page ├── error.php # Error handling page ├── guardian_safe.sql # Database schema


---

## 💡 Future Enhancements  
1. *Enhanced Security*: Hash UPI PINs and implement secure sessions.  
2. *Responsive Design*: Optimize for mobile and tablet devices.  
3. *Notifications*: Add email or SMS notifications for guardians.  
4. *Dashboard Features*: Include request history and visual analytics.

---

## 🎯 Key Takeaways  
- *Languages & Tools*: HTML, CSS, JavaScript, PHP, MySQL.  
- *Learning Outcome*: Gained hands-on experience in backend logic and database integration.  
- *Applications*: Demonstrates knowledge of transaction handling and user management.

---

## 👨‍💻 Author  
*Vijaya Kumar Gavara*  
Enthusiastic Computer Science student passionate about solving real-world problems through programming and development.

---
