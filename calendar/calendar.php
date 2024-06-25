<?php
setcookie('doctor', $_POST['doctor'], time() + 60*60*24);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make an appointment with a doctor</title>
    <link rel="stylesheet" href="calendarStyle.css">
</head>
<body>
<form class="calendarForm" method="post" action="hours.php">
    <label for="date">Choose a visit date:</label>
    <input class="calendar" type="date" id="date" name="date" min="<?php echo strftime("%Y-%m-%d", time() + 60*60*24); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>">
    <input type="submit" value="Choose">
</form>
</body>
</html>