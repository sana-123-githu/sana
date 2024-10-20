<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Officer Change</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #007BFF;
            margin-bottom: 20px;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        label {
            font-weight: bold;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 8px;
            margin-bottom: 20px;
            resize: none; /* Prevent resizing */
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Request Officer Change</h2>
    <form action="process_request.php" method="post">
        <input type="hidden" name="complaint_id" value="<?php echo htmlspecialchars($_POST['complaint_id']); ?>">
        <input type="hidden" name="officer_id" value="<?php echo htmlspecialchars($_POST['officer_id']); ?>">
        <label for="reason">Reason for Officer Change:</label><br>
        <textarea id="reason" name="reason" required></textarea><br><br>
        <button type="submit">Submit Request</button>
    </form>
</body>
</html>
