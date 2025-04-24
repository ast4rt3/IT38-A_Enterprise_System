<!DOCTYPE html>
<html>
<head>
	<title>Main Page</title>
	 <style type="text/css">

        body {
            background-color: rgb(174, 245, 252);
            border-color: white;
            border-width: 10px;
            padding: 20px; 
            font-family: Arial, sans-serif;
            color: #333; 
        }

        center {
            margin-top: 50px;
        }


        h1 {
            color: #00796b; 

        h3 {
            color: #00796b;
            font-weight: 300; 
        }

        
        .button {
            padding: 10px 20px;
            background-color: #00796b; 
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .button:hover {
            background-color: #004d40;
            transition: background-color 0.3s ease; 
        }

        .button:focus {
            outline: none; 
        }
    </style>
</head>
<body>
	<center>
	<br><h1>Welcome to our website</h1>
	<h3>You are logged in</h3>
	<form action='includes/logout.inc.php' method='post'>
		<button type='submit' class='button button3' name='logout-submit'>Log Out</button>

		
    </form>
</center>
</body>
</html>
