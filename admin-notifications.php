<!DOCTYPE html>
<html lang=”en”>
<head>
    <meta charset=”UTF-8”>
    <meta name=”viewport” content=”width=device-width, initial-scale=1.0”>
    <title>Admin Notification Panel</title>
    <link rel=”stylesheet” href=”styles.css”>
    <style>
       /* Basic Reset */
•	{
    Margin: 0;
    Padding: 0;
    Box-sizing: border-box;
}

Body {
    Font-family: Arial, sans-serif;
    Background-color: #f4f4f4;
    Color: #333;
}

Header {
    Background-color: #333;
    Color: white;
    Padding: 10px 20px;
    Text-align: center;
}

Header nav ul {
    List-style: none;
    Display: flex;
    Justify-content: center;
}

Header nav ul li {
    Margin: 0 15px;
}

Header nav ul li a {
    Color: white;
    Text-decoration: none;
}

Section {
    Margin: 20px;
    Padding: 20px;
    Background-color: white;
    Border-radius: 5px;
}

#notification-form {
    Margin-bottom: 30px;
}

#notification-form form {
    Display: flex;
    Flex-direction: column;
}

#notification-form label {
    Margin-bottom: 5px;
}

#notification-form input, #notification-form textarea {
    Margin-bottom: 15px;
    Padding: 10px;
    Border: 1px solid #ddd;
    Border-radius: 5px;
}

Button {
    Padding: 10px 15px;
    Background-color: #4CAF50;
    Color: white;
    Border: none;
    Border-radius: 5px;
    Cursor: pointer;
}

Button:hover {
    Background-color: #45a049;
}

#notification-list table {
    Width: 100%;
    Border-collapse: collapse;
}

#notification-list th, #notification-list td {
    Padding: 10px;
    Border: 1px solid #ddd;
    Text-align: left;
}

#notification-list th {
    Background-color: #f2f2f2;
}

Footer {
    Text-align: center;
    Padding: 10px;
    Background-color: #333;
    Color: white;
    Position: fixed;
    Bottom: 0;
    Width: 100%;
}
 

    </style>
</head>
<body>
     <!-- Sidebar -->
     <?php include 'admin_nav.php' ?>

    <!—Notification Form Section 
    <section id=”notification-form”>
        <h2>Create New Notification</h2>
        <form action=”/submit-notification” method=”POST”>
            <label for=”title”>Notification Title:</label>
            <input type=”text” id=”title” name=”title” required>

            <label for=”content”>Notification Content:</label>
            <textarea id=”content” name=”content” rows=”4” required></textarea>

            <button type=”submit”>Post Notification</button>
        </form>
    </section>

    <!—Notification List Section 
    <section id=”notification-list”>
        <h2>Posted Notifications</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!—Example Notification Row 
                <tr>
                    <td>System Maintenance</td>
                    <td>Scheduled maintenance on January 10th, 2025 from 2 AM to 4 AM.</td>
                    <td>
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
                </tr>
                <!—More notification rows will be added dynamically 
            </tbody>
        </table>
    </section>

    <!—Footer Section 
    <footer>
        <p>&copy; 2025 Admin Panel. All rights reserved.</p>
    </footer>
</body>
</html>
