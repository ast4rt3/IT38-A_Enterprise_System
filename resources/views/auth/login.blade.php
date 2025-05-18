<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Eco Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Preload critical fonts -->
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" as="style">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    /* Critical CSS */
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
      position: relative;
    }
    .btn.loading {
      pointer-events: none;
      opacity: 0.8;
    }
    .btn.loading::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      top: 50%;
      left: 50%;
      margin: -10px 0 0 -10px;
      border: 2px solid #ffffff;
      border-top-color: transparent;
      border-radius: 50%;
      animation: button-loading-spinner 1s linear infinite;
    }
    @keyframes button-loading-spinner {
      from {
        transform: rotate(0turn);
      }
      to {
        transform: rotate(1turn);
      }
    }
    .error-message {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.5rem;
      display: none;
    }
    .error-message.show {
      display: block;
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
      text-align: center;
      flex-direction: column;
    }
    .right-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }
    .right-content h1 {
      font-size: 2.5rem;
      color: #1b5e20;
      margin: 0;
    }
    .right-content h2 {
      font-size: 1rem;
      color: #2e7d32;
      margin: 0;
      font-style: italic;
    }
    .right-content img {
      width: 200px;
      border-radius: 50%;
      margin-top: 1rem;
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
      color: blue;
      text-decoration: none;
    }
    /* Footer Styles */
    .footer {
      position: absolute;
      bottom: 20px;
      width: 100%;
      text-align: center;
      font-size: 0.8rem;
      color: #388e3c;
    }
    .footer a {
      color: #1b5e20;
      text-decoration: none;
      margin: 0 10px;
    }
    .footer a:hover {
      text-decoration: underline;
    }
    .popup {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
      padding: 1rem;
      border-radius: 5px;
      z-index: 1000;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      animation: fadeIn 0.3s ease-out;
    }
    .popup-content {
      position: relative;
      text-align: left;
    }
    .close-btn {
      position: absolute;
      top: 5px;
      right: 10px;
      font-size: 20px;
      cursor: pointer;
      color: #721c24;
    }
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
  padding: 1rem;
  border-radius: 5px;
  z-index: 1000;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
  animation: fadeIn 0.3s ease-out;
}

.popup-content {
  position: relative;
  text-align: left;
}

.close-btn {
  position: absolute;
  top: 5px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
  color: #721c24;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
  to { opacity: 1; transform: translateX(-50%) translateY(0); }
}

  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <div class="form-box">
        <h1>Welcome back!</h1>
        <h2>Login</h2>
        @if ($errors->any())
  <div id="errorPopup" class="popup">
    <div class="popup-content">
      <span class="close-btn" onclick="document.getElementById('errorPopup').style.display='none'">&times;</span>
      @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
  </div>
@endif

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
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/Facebook_Logo_2023.png/1200px-Facebook_Logo_2023.png" alt="Facebook">
          <img src="https://cdn-icons-png.flaticon.com/512/281/281764.png" alt="Other">
        </div>
      </div>
    </div>

    <div class="right">
  <div class="right-content">
    <h1>Smart Waste Pick-Up</h1>
    <h2>Optimizing Waste Collection with Real-Time Tracking & Smart Routing!</h2>
    <img src="https://static.vecteezy.com/system/resources/previews/025/952/160/non_2x/map-icon-design-free-vector.jpg" alt="Eco Logo">
  </div>
</div>
  </div>
</body>
</html>
