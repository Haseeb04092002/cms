body {
font-family: 'Inter', sans-serif;
background-color: #f8f9fa;
/* Light grey background like sc2.jpg */
margin: 0;
overflow-x: hidden;
}
.hero-section {
border-radius: 0 !important;
}

/* 🔹 MOBILE ONLY — Desktop remains unchanged */
@media (max-width: 768px) {

/* Fix 100vh issue on mobile browsers */
.hero-section {
height: auto;
min-height: 100vh;
}

/* Disable fixed background only on mobile */
.hero-section>div:first-child {
background-attachment: scroll !important;
}

/* Center align content vertically */
.hero-section .d-flex {
align-items: center !important;
}
}

.hero-text h1 {
font-size: 4.2rem;
font-weight: 900;
line-height: 1.1;
letter-spacing: 1px;
text-shadow: 2px 4px 12px rgba(0,0,0,0.7);
}

.hero-text p {
font-size: 1.2rem;
font-weight: 400;
max-width: 520px;
text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
}

/* 🔹 MOBILE ONLY */
@media (max-width: 768px) {

.hero-text {
text-align: center;
margin: 0 auto;
}

.hero-text h1 {
font-size: 2.2rem;
}

.hero-text p {
font-size: 1rem;
max-width: 100%;
}
}



.services-section {
position: relative;
height: 100vh;
display: flex;
flex-direction: column;
justify-content: center;
align-items: center;
text-align: center;
padding: 20px;
}

/* Gradient Text Effect for "Our Services" */
.gradient-title {
font-size: 8rem;
font-weight: 700;
letter-spacing: -3px;
margin-bottom: 2rem;
background: linear-gradient(90deg, #000000 35%, #e91e63 55%, #00bcd4 75%, #000000 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
}

.services-subtitle {
font-size: 1.1rem;
color: #333;
font-weight: 400;
max-width: 600px;
}

/* Floating Tilted Images */
.floating-img {
position: absolute;
width: 150px;
height: 150px;
object-fit: cover;
border-radius: 8px;
box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

/* Positions and Tilts based on sc2.jpg */
.img-1 {
top: 15%;
left: 8%;
transform: rotate(-5deg);
width: 120px;
height: 120px;
}

.img-2 {
bottom: 10%;
left: 5%;
transform: rotate(10deg);
width: 180px;
height: 180px;
}

.img-3 {
top: 20%;
right: 5%;
transform: rotate(12deg);
width: 160px;
height: 160px;
}

.img-4 {
bottom: 15%;
right: 10%;
transform: rotate(-8deg);
width: 130px;
height: 130px;
}

@media (max-width: 768px) {
.gradient-title {
font-size: 4rem;
}

.floating-img {
display: none;
}

/* Hide decorative images on small screens */
}