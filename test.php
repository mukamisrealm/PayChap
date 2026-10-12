<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ChapChapPay - Backend API Test Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f9; }
        .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 400px; }
        input, select, button { width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background: #218838; }
        pre { background: #e9ecef; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>

    <h2>ChapChapPay - 30% Progress Backend Tester</h2>

    <!-- Register Test -->
    <div class="card">
        <h3>1. Test User Registration</h3>
        <form action="api/register.php" method="POST" target="responseFrame">
            <input type="text" name="full_name" placeholder="Full Name" value="Jane Doe" required>
            <input type="text" name="phone_number" placeholder="Phone (e.g. 0712345678)" value="0712345678" required>
            <input type="password" name="password" placeholder="Password" value="Password123" required>
            <select name="language_preference">
                <option value="eng">English</option>
                <option value="swa">Swahili</option>
            </select>
            <button type="submit">Register User</button>
        </form>
    </div>

    <!-- Login Test -->
    <div class="card">
        <h3>2. Test User Login</h3>
        <form action="api/login.php" method="POST" target="responseFrame">
            <input type="text" name="phone_number" placeholder="Phone Number" value="0712345678" required>
            <input type="password" name="password" placeholder="Password" value="Password123" required>
            <button type="submit" style="background: #007bff;">Login</button>
        </form>
    </div>

    <!-- Response Window -->
    <div class="card" style="width: 600px;">
        <h3>API JSON Output:</h3>
        <iframe name="responseFrame" style="width: 100%; height: 150px; border: 1px solid #ccc; background: #fff;"></iframe>
    </div>

</body>
</html>