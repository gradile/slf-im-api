<!doctype html>
<html>

<body style="font-family: Arial, sans-serif;">
    <h2>New Contact Request</h2>
    <ul>
        <li><strong>First Name:</strong> {{ $a->first_name }}</li>
        <li><strong>Last Name:</strong> {{ $a->last_name }}</li>
        <li><strong>Email:</strong> {{ $a->email }}</li>
        <li><strong>Phone:</strong> {{ $a->phone }}</li>
        <li><strong>Question:</strong> {{ $a->question ?? '-' }}</li>
    </ul>
</body>

</html>
