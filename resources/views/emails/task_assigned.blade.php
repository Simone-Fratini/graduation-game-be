<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mission Assigned</title>
</head>
<body>
    <h2>Hello {{ $guest->full_name }}!</h2>
    <p>You’ve been assigned a mission for the graduation party 🎓</p>
    <p><strong>Title:</strong> {{ $task->title }}</p>
    <p><em>{{ $task->description }}</em></p>
    <p>Good luck and have fun! 😄</p>
</body>
</html>
