<!DOCTYPE html>
<html>
<head>
    <title>Appointment Declined</title>
</head>
<body>
    <h2>Appointment Declined</h2>
    <p>Dear {{ $userName }},</p>
    <p>We want to inform you that appointment with Dr. {{ $doctorName }} scheduled for {{ $appointmentDate }} at {{ $appointmentTime }} has been upadted.</p>
    <p>Appointment Status: {{ $appointmentStatus }}</p>
    <p>Please contact our support team for further assistance.</p>
    <p>Thank you.</p>
</body>
</html>