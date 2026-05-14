<!doctype html>
<html>

<body style="font-family: Arial, sans-serif;">
    <h2>New Appointment Request</h2>
    <ul>
        <li><strong>First Name:</strong> {{ $a->first_name }}</li>
        <li><strong>Last Name:</strong> {{ $a->last_name }}</li>
        <li><strong>Email:</strong> {{ $a->email }}</li>
        <li><strong>Phone:</strong> {{ $a->phone }}</li>
        <li><strong>Language:</strong> {{ $a->language ?? '-' }}</li>
        <li><strong>Consent 1:</strong> {{ $a->consent1 ? 'Yes' : 'No' }}</li>
        <li><strong>Consent 2:</strong> {{ $a->consent2 ? 'Yes' : 'No' }}</li>
    </ul>
</body>

</html>
