<!DOCTYPE html>
<html lang="en">
<head>
  <title>ACME Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <h3 style>ACME Login</h3>
    <form action="verify.php" method="post">
      <div class="form-group">
        <label for="name">Email</label>
        <input type="text" class="form-control" name="email" placeholder="Email">
      </div>
      <div class="form-group">
        <label for="name">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
      </div>
      <button type="submit" class="btn btn-primary" name="login">Login</button>
    </form>
  </div>
</body>
</html>