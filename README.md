Project Title: Entries Management System
========================================

This project is a simple Entries Management System built with PHP, supporting image upload and basic CRUD functionality. Users can create, view, and paginate through entries with attached images and metadata (such as titles, dates, and messages).

Features
--------

*   **CRUD Operations**: Add, view, and paginate entries with title, date, message, and optional image.
    
*   **Image Upload & Resizing**: Users can upload images, which are automatically resized to a specific dimension (400x400) for optimized storage and display.
    
*   **Pagination**: Entries are paginated with links to navigate between pages.
    
*   **Date Formatting**: Displays the date in dd/mm/yyyy format for consistency and readability.
    
*   **Error Handling**: Basic error handling to manage image upload issues and database errors.
    
*   **Sanitization**: Utilizes prepared statements in SQL to prevent SQL injection.
    

Technologies Used
-----------------

*   **PHP**: Core scripting language used for backend logic.
    
*   **PDO**: Database access is handled with PDO for secure and efficient data management.
    
*   **HTML/CSS**: Basic frontend templating for entry display and form styling.
    
*   **JavaScript**: Minor JS for pagination and form interactions (if applicable).
    
*   **SQL Database**: Stores entries with metadata (title, date, message, and image path).
