<!doctype html>
<html>

<body style="font-family: Arial, sans-serif;">
    <h2>Thank You!</h2>
    <p>We have received your appointment request and will contact you soon.</p>
    <p><strong>Summary:</strong></p>
    <ul>
        <li>{{ $a->first_name }} {{ $a->last_name }}</li>
        <li>{{ $a->email }}</li>
        <li>{{ $a->phone }}</li>
        <li>Language: {{ $a->language ?? '-' }}</li>
    </ul>
</body>

</html>
