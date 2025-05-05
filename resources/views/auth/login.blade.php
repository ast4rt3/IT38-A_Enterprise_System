<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Eco Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    /* Same CSS as earlier answer, pasted directly here for simplicity */
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f0fff4;
      color: #2f4f4f;
      display: flex;
      height: 100vh;
    }
    .container {
      display: flex;
      width: 100%;
    }
    .left {
      flex: 1;
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .form-box {
      width: 80%;
    }
    h1 {
      font-size: 2.5rem;
      color: #2e7d32;
      margin-bottom: 2rem;
    }
    .input-group {
      margin-bottom: 1.5rem;
      position: relative;
      border-bottom: 2px solid #c8e6c9;
      transition: border-color 0.3s ease;
    }
    .input-group input {
      width: 100%;
      padding: 10px 5px;
      border: none;
      outline: none;
      background: transparent;
      font-size: 1rem;
    }
    .input-group label {
      position: absolute;
      top: 10px;
      left: 5px;
      color: #388e3c;
      font-size: 14px;
      pointer-events: none;
      transition: 0.2s ease all;
    }
    .input-group input:focus ~ label,
    .input-group input:not(:placeholder-shown) ~ label {
      top: -10px;
      font-size: 12px;
      color: #1b5e20;
    }
    .btn {
      width: 100%;
      background-color: #4caf50;
      border: none;
      padding: 15px;
      font-size: 1rem;
      border-radius: 25px;
      color: white;
      cursor: pointer;
      margin-top: 1rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .btn:hover {
      background-color: #388e3c;
    }
    .socials {
      display: flex;
      gap: 15px;
      margin-top: 1.5rem;
    }
    .socials img {
      width: 40px;
      height: 40px;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .right {
      flex: 1;
      background-color: #a5d6a7;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .right img {
      width: 200px;
      border-radius: 50%;
    }
    .signup {
      margin-top: 20px;
      color: #2e7d32;
      font-size: 0.9rem;
    }
    .signup a {
      color: #1b5e20;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <div class="form-box">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="input-group">
            <input type="email" name="email" required placeholder=" " />
            <label>Email</label>
          </div>
          <div class="input-group">
            <input type="password" name="password" required placeholder=" " />
            <label>Password</label>
          </div>
          <button type="submit" class="btn">Login</button>
        </form>
        <p class="signup">No account? <a href="{{ route('register') }}">Sign up</a></p>
        <div class="socials">
          <img src="https://mailmeteor.com/logos/assets/PNG/Gmail_Logo_512px.png" alt="Gmail">
          <img src="https://static.vecteezy.com/system/resources/previews/018/930/476/original/facebook-logo-facebook-icon-transparent-free-png.png" alt="Facebook">
          <img src="https://cdn-icons-png.flaticon.com/512/281/281764.png" alt="Other">
        </div>
      </div>
    </div>
    <div class="right">
      <img src="https://i.pinimg.com/736x/aa/ec/16/aaec16b6c7fcd29d1d42d950265c5447.jpg" alt="Eco Logo">
    </div>
  </div>
</body>
</html>
