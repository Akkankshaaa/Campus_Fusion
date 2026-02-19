<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="../extra/logo.png" width="150" height="80" alt="Logo">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNav" aria-controls="navbarNav"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

      <!-- 🔍 Search form -->
      <form class="d-flex ms-auto me-3" role="search" action="../service/search.php" method="get">
        <input class="form-control me-2" type="search" name="query" placeholder="Search for posts..." aria-label="Search">
        <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
      </form>

      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="../service/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="../service/category.php">Category</a></li>
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="../service/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="../service/contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
