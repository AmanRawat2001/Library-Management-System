<!DOCTYPE html>
<html>
<head>
    <title>Library Due Date Reminder</title>
</head>
<body>
    <p>Dear {{ $userName }},</p>

    <p>This is a friendly reminder that the book <strong>"{{ $bookTitle }}"</strong> you borrowed from the library is due on <strong>{{ $dueDate }}</strong>.</p>

    <p>Please return the book on or before the due date to avoid penalties.</p>

    <p>Thank you for using our library services.</p>

    <p>Best regards,<br>Library Management Team</p>
</body>
</html>
