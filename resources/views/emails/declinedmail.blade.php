<!DOCTYPE html>
<html>
<head>
    <title>Appointment Declined</title>
</head>
<body>
    <h2>Appointment Declined</h2>
    <p>changed for user: {{ $userName }},</p>
    <p>We want to inform you that appointment with Dr. {{ $doctorName }} scheduled for {{ $appointmentDate }} at {{ $appointmentTime }} has been declined.</p>
    <p>Appointment Status: {{ $appointmentStatus }}</p>
</body>
</html>