<!DOCTYPE html>
<html>
<head>
    <title>Appointment Declined</title>
</head>
<body>
    <h2>Appointment Declined</h2>
    <p>User: {{ $userName }},</p>
    <p>To: Dr. {{ $doctorName }} </p>
    <p>Scheduled for {{ $appointmentDate }} at {{ $appointmentTime }} </p></p>
    <p>Appointment Status: {{ $appointmentStatus }}</p>
</body>
</html>