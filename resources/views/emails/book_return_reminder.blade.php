<!DOCTYPE html>
<html>
<head>
    <title>Book Return Reminder</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    <p>This is a friendly reminder that the book <strong>{{ $book->title }}</strong> is due in 2 days.</p>
    <p>Please return it on time to avoid any penalties.</p>
    <p>Thank you for using our library.</p>
</body>
</html>
