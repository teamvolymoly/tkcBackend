<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<title>theKawaCompany</title>

<style>

@font-face{
font-family:'Inter';
src:url('{{ asset('Inter-VariableFont_opsz,wght.ttf') }}') format('truetype');
font-weight:100 900;
font-style:normal;
font-display:swap;
}

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family: 'Inter', Arial, Helvetica, sans-serif;
}

body{
background:#0f172a;
color:white;
}

/* navbar */

.navbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:20px 80px;
border-bottom:1px solid rgba(255,255,255,0.1);
}

.logo{
font-size:24px;
font-weight:bold;
letter-spacing:1px;
}

.dev{
font-size:13px;
opacity:0.7;
}

.volymoly{
color:#3b82f6;
font-weight:bold;
}

.nav-links a{
color:white;
text-decoration:none;
margin-left:30px;
font-size:14px;
opacity:0.8;
transition:0.3s;
}

.nav-links a:hover{
opacity:1;
color:#3b82f6;
}

/* hero */

.hero{
height:80vh;
display:flex;
justify-content:center;
align-items:center;
text-align:center;
flex-direction:column;
padding:20px;
}

.hero h1{
font-size:60px;
margin-bottom:20px;
}

.hero p{
font-size:18px;
opacity:0.7;
max-width:600px;
margin-bottom:30px;
line-height:1.6;
}

.btn{
padding:12px 30px;
background:#3b82f6;
border:none;
border-radius:5px;
color:white;
font-size:16px;
cursor:pointer;
transition:0.3s;
}

.btn:hover{
background:#2563eb;
transform:scale(1.05);
}

/* footer */

.footer{
text-align:center;
padding:20px;
border-top:1px solid rgba(255,255,255,0.1);
font-size:14px;
opacity:0.8;
line-height:1.6;
}

</style>

</head>

<body>

<div class="navbar">

<div class="logo">
TheKawaCompany
</div>

<div class="nav-links">
<a href="#">Home</a>
<a href="#">About</a>
<a href="#">Products</a>
<a href="#">Contact</a>
</div>

<div class="dev">
Developed by <span class="volymoly">Volymoly</span>
</div>

</div>

<div class="hero">

<h1>TheKawaCompany</h1>

<p>
A premium eCommerce experience is currently under development.
Our team at <span class="volymoly">Volymoly</span> is building something amazing for you.
</p>

<button class="btn">
Launching Soon
</button>

</div>

<div class="footer">
© 2026 theKawaCompany. All rights reserved.<br>
Powered by <span class="volymoly">Volymoly</span>
</div>

</body>
</html>


