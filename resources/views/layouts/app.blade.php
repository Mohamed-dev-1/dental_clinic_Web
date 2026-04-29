<!-- this file is like the main frame of the UI -->

<!DOCTYPE html>

<html>

<head>
    <title> AL-NADJAH ODF </title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Spline 3D Viewer -->
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.27/build/spline-viewer.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>


<!-- HERO section: Text 1| middle (image) | Text 2-->

<section
    class="hero relative min-h-screen h-screen w-full overflow-hidden"
    style="background-image: url('{{ asset('images/hero_back.png') }}')"
>

    <header class="hero-header"> <!-- Top bar of the web -->
        <div class="hero-brand">AL-NADJAH DENTAL</div>

        <nav class="hero-nav" aria-label="Primary navigation">
            <ul class="hero-nav-list">
                <li><a href="#">Home</a></li>
                <li><a href="#about-section">About us</a></li>
                <li><a href="#services-section">Services</a></li>
                <li><a href="#specialists-section">Specialists</a></li>
                <li><a href="#testimonials-section">Testimonials</a></li>
            </ul>
        </nav>

        <div class="hero-auth">
            <a href="/login" class="hero-auth-login">Log in</a>
            <a href="/register" class="hero-auth-signup">Sign up</a>
        </div>

    </header>

    <div class="hero-text-wrapper" style="position: absolute; left: 50%; top: 13%; z-index: 2;" data-aos="zoom-in" data-aos-duration="1500">
        <div class="hero-text-back" style="position: relative; left: -50%; top: -60%; transform: none;">AL-NADJAH DENTAL</div>
    </div>
    <p class="hero-subtitle hero-subtitle-left" data-aos="fade-right" data-aos-delay="500">COMFORTABLE DENTISTRY</p>
    <p class="hero-subtitle hero-subtitle-right" data-aos="fade-left" data-aos-delay="500">FOR EVERYONE</p>

    <img class="hero-tooth" src="{{ asset('images/tooth3d.png') }}" loading="eager" fetchpriority="high" decoding="async" alt="Tooth model">

    <a href="#booking-section" class="bookButton" data-aos="zoom-in" data-aos-delay="1000">Book online</a>
</section>

@yield('content')


<!-- the hero section finishes here -->


<section class="about" id="about-section">



    <p id="aboutUsTopRight">ABOUT US</p> <br> <br> <br>

    <h1 data-aos="fade-up"> Crafting confident SMILES <br> Through advanced OrthoDontics </h1>

    <p data-aos="fade-up" data-aos-delay="200"> AL-NADJAH ODF is a specialized orthodontic clinic dedicated to delivering <br>
        modern, precise, and personalized treatments. Our mission is to create
        healthy<br> and confident smiles through advanced techniques and exceptional patient care. </p>

    <br> <br> <br> <br> <br>



    <div class="windows">

        <div class="experience glass-panel" data-aos="zoom-in" data-aos-delay="100">
            <h2> +14 </h2> <br>
            <h4 style="font-weight: 400;"> Years of excellence </h4>
        </div>

        <div class="satisfaction glass-panel" data-aos="zoom-in" data-aos-delay="200">
            <h2> 91% </h2><br>
            <h4 style="font-weight: 400;">Patient Satisfaction </h4>
        </div>

        <div class="smiles glass-panel" data-aos="zoom-in" data-aos-delay="300">
            <h2> +5842 </h2><br>
            <h4 style="font-weight: 400;"> Smiles transformed </h4>
        </div>

        <div class="experts glass-panel" data-aos="zoom-in" data-aos-delay="400">
            <h2 > 21 </h2><br>
            <h4 style="font-weight: 400;"> Certified experts  </h4>
        </div>

    </div>

    <br><br><br><br>

</section>

<br>

<!-- the About us section finishes here  -->



<section class="services" id="services-section">

    <div class="services-shell">
        <div class="services-panel">
            <p class="services-kicker">SERVICES</p>
            <h1 class="services-title">Expert care for every smile</h1>
            <p class="services-subtitle">
                We offer a complete range of treatments tailored for oral health,
                comfort, and long-term confidence.
            </p>

            <div class="services-grid">
                <article class="service-card glass-panel" data-aos="flip-up" data-aos-delay="100">
                    <img src="{{ asset('images/teeth_aesthetic.jpeg') }}" alt="Aesthetic dentistry">
                    <h3>aesthetics</h3>
                </article>
                <article class="service-card glass-panel" data-aos="flip-up" data-aos-delay="200">
                    <img src="{{ asset('images/teeth_orthodontics.jpeg')}}" alt="Orthodontics" >
                    <h3>Orthodontics</h3>
                </article>
                <article class="service-card glass-panel" data-aos="flip-up" data-aos-delay="300">
                    <img src="{{ asset('images/teeth_implantology.jpeg')}}" alt="Implantology">
                    <h3>Implantology</h3>
                </article>
                <article class="service-card glass-panel" data-aos="flip-up" data-aos-delay="400">
                    <img src="{{ asset('images/teeth_whitening.jpeg') }}" alt="Whitening">
                    <h3>Whitening</h3>
                </article>
                <article class="service-card glass-panel" data-aos="flip-up" data-aos-delay="500">
                    <img src="{{ asset('images/teeth_surgery.jpeg') }}" alt="Surgical dentistry">
                    <h3>Surgical dentistry</h3>
                </article>
            </div>

            <a href="#booking-section" class="services-cta">Schedule a visit</a>
        </div>
    </div>
</section>

<section class="specialists" id="specialists-section">

    <div class="specialistsContainer">

        <p id="specialists_pageTitle"> SPECIALISTS </p> <br>

        <div class="title1">

            <h1 id="sentence1"> Meet the minds</h1>

        </div>

        <h1 class="sentence2"> behind your smile </h1> <br> <br> <br> <br>


        <p id="teamDescription">
            Our team is composed of highly qualified orthodontic specialists and dedicated dental professionals
            committed to delivering precise<br>and personalized, and compassionate care.
            Through continuous training and the use of advanced technologies, we ensure exceptional<br> treatment quality and outstanding patient experience.
        </p>

        <br>

        <!-- now the doctors cards and the ability to go next or previous -->

        <div class="cardsContainer">

            <div class="card" data-aos="fade-up" data-aos-delay="100">

                <img src="{{asset('images/doctor1.png')}}" class="imgCard" alt="doctor1 image">

                <h3 id="cardsH"> Dr.Ahmed </h3>

                <p id="cardsParagraph">Expert in advanced OrthoDontics</p>

                <h5 class="card-since"> since 2000 </h5>

            </div>



            <div class="card" data-aos="fade-up" data-aos-delay="200">

                <img src="{{asset('images/doctor2.png')}}" class="imgCard">

                <h3 id="cardsH"> Dr.Imane </h3>

                <p id="cardsParagraph">Expert in dento-facial orthopedics</p>


                <h5 class="card-since"> since 2016 </h5>

            </div>



            <div class="card" data-aos="fade-up" data-aos-delay="300">

                <img src="{{asset('images/doctor3.png')}}" class="imgCard">

                <h3 id="cardsH" > Dr.Malak</h3>

                <p id="cardsParagraph"> Specialized in Cosmetic Dentistry </p>

                <h5 class="card-since"> since 2017 </h5>

            </div>


            <div class="card" data-aos="fade-up" data-aos-delay="400">

                <img src="{{asset('images/doctor4.jpg')}}" class="imgCard">

                <h3 id="cardsH"> Dr.John </h3>

                <p id="cardsParagraph">Expert in Pediatric OrthoDontics</p>

                <h5 class="card-since"> since 2010 </h5>

            </div>

        </div>


    </div>

</section>

<!-- the specialists section ends here . -->

<section class="testimonials" id="testimonials-section">

    <p id="pageTitle"> TESTIMONIALS </p> <br> <br>

    <h1 id="bigTitle" data-aos="fade-up"> Real Stories. Real smiles </h1>

    <p id="text1P" data-aos="fade-up" data-aos-delay="100"> Patients consistently praised AL-NAJAH Dental Clinic for its welcoming staff, </p>

    <p id="text2P" data-aos="fade-up" data-aos-delay="200"> modern facilities, and excellent quality of care. </p>


    <div class="beforeAfterShow">


        <div class="introText" data-aos="fade-right">

            <h1 class="introTitle"> Cristina's smile:</h1>

            <p id="introP"> Cristina felt self-concious about
                the shape  <br> of her teeth. She wanted a natural ,
                brighter <br>smile that felt like her own - just more balanced,<br> natural and confidently adorable smile . </p>

            <h3 id="whatwedid"> What we did : </h3>

            <ul class="introText-list-ul">
                <li class="introlist"> smile design planning </li>
                <li class="introlist"> tooth preparation </li>
                <li class="introlist"> placement of vaneers </li>
            </ul>

        </div>



        <div class="show glass-panel" data-aos="fade-left">


            <img class="showimage"  src="{{asset('images/before_braces.png')}}" >
            <img class="showimage"  src="{{asset('images/withBraces.png')}}" >
            <img class="showimage"  src="{{asset('images/afterBraces.png')}}" >


        </div>


    </div>

    <br> <br> <br> <br>


</section>

<section class="booking" id="booking-section">

    <p id="consultation_page" data-aos="fade-up"> CONTACT US </p>
    <h1 id="consultationBigTitle" data-aos="fade-up"> Let's get in touch </h1>

    <p id="sentence1_consultation" data-aos="fade-up" data-aos-delay="100"> Have questions about our services or need to book an appointment? </p>
    <p id="sentence2_consultation" data-aos="fade-up" data-aos-delay="200"> Send us a message and our team will reply as soon as possible. </p>



    <div class="form" data-aos="zoom-in" data-aos-delay="300">

        <form method="post" action="contact.php">

            <div class="part1">

                <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>

            </div>

            <div class="part-text">
                <textarea id="message" name="message" rows="5" placeholder="How can we help you?" required></textarea>
            </div>

            <input type="submit" value="Send Message" id="submit">

        </form>

    </div>

</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <h2>AL-NADJAH DENTAL</h2>
            <p>Comfortable dentistry for everyone.</p>
        </div>
        <div class="footer-links">
            <div>
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#about-section">About</a></li>
                    <li><a href="#services-section">Services</a></li>
                    <li><a href="#specialists-section">Specialists</a></li>
                </ul>
            </div>
            <div>
                <h3>Contact</h3>
                <ul>
                    <li>123 Dental Street, City</li>
                    <li>+123 456 7890</li>
                    <li>info@alnadjah.clinic</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} AL-NADJAH DENTAL. All rights reserved.</p>
    </div>
</footer>
































<!-- AOS JS Initialization -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 50
    });
</script>
</body>




</html>
