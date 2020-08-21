<!DOCTYPE html>
<html>
<head>
    <title>Successful Registration</title>
    <style type="text/css">
        :root {
  --color: #4973ff;
}

body {
  font-size: 16px;
  font-family: 'Montserrat', sans-sherif;
  margin: 0;
  padding: 0;
}

.content {
  max-width: 600px;
  margin: 0 auto;
  padding: 0 20px;
}

.hero {
  position: relative;
  background: #333333;
  color: white;
  height: 100vh;
  display: flex;
  align-items: center;
  overflow: hidden;
}

.hero h2 {
  position: relative;
  z-index: 1;
  font-size: 4.5rem;
  margin: 0 0 10px;
  line-height: 1;
  color: rgba(255, 255, 255, 0.9);
}

.hero p {
  position: relative;
  z-index: 1;
  font-size: 1.1rem;
  color: rgba(255, 255, 255, 0.5);
  line-height: 1.4;
}

/* ========================= */

.waves {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 200px;
  background-color: var(--color);
  box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.5);
  transition: 500ms;
}



.myButton {
    box-shadow: 0px 0px 0px 2px #485d96;
    background:linear-gradient(to bottom, #5487de 5%, #476e9e 100%);
    background-color:#5487de;
    border-radius:10px;
    border:1px solid #4e6096;
    display:inline-block;
    cursor:pointer;
    color:#ffffff;
    font-family:Arial;
    font-size:19px;
    padding:12px 37px;
    text-decoration:none;
    text-shadow:0px 1px 0px #283966;
}
.myButton:hover {
    background:linear-gradient(to bottom, #476e9e 5%, #5487de 100%);
    background-color:#476e9e;
}
.myButton:active {
    position:relative;
    top:1px;
}

    </style>
</head>
<body>
<section class="hero">
  <div class="content">
    <h2>Your registration is successful.</h2>
    <a href="signinPage.php" class="myButton">Click here to sign in</a>



        
    </div>
  <div class="waves"></div>
</section>
</body>
</html>>