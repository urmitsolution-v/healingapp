<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>404 Not Found</title>

  <style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background: linear-gradient(135deg, #2c3e50, #4ca1af);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: white;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container {
  text-align: center;
  animation: fadeIn 1s ease-in-out;
}

h1 {
  font-size: 8rem;
  margin-bottom: 20px;
  color: #ff6b6b;
}

.message {
  font-size: 2rem;
  margin-bottom: 10px;
}

.subtext {
  font-size: 1rem;
  margin-bottom: 30px;
  opacity: 0.8;
}

.home-btn {
  padding: 12px 24px;
  background-color: #ff6b6b;
  color: white;
  text-decoration: none;
  border-radius: 6px;
  font-size: 1rem;
  transition: background 0.3s ease;
}

.home-btn:hover {
  background-color: #ff4757;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

  </style>

</head>
<body>


    <div class="container">
    <h1>404</h1>
    <p class="message">Oops! Page not found</p>
    <p class="subtext">The page you are looking for doesn't exist or has been moved.</p>
    <a href="/" class="home-btn">Go Back Home</a>
  </div>

</body>
</html>
