<?php
use yii\helpers\Url;
?>
<!-- Page Navigation -->
<nav class="navbar custom-navbar navbar-expand-lg navbar-dark" data-spy="affix" data-offset-top="20">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="<?=Url::to(['web/front/imgs/logo 4.png'])?>" alt="The sacred journey starts with us, we take you there">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#service">Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#portfolio">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#team">Team</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testimonial">Testimonial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#blog">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=Url::to(['login'])?>">Portal</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Of Page Navigation -->

<!-- Page Header -->
<header class="header">
    <div class="overlay">
        <h6 class="subtitle">The sacred journey</h6>
        <h1 class="title">Starts with us</h1>
        <div class="buttons text-center">
            <a href="#contact" class="btn btn-outline-light rounded w-lg btn-lg my-1">Book now</a>
        </div>
    </div>
</header>
<!-- End Of Page Header -->

<!-- About Section -->
<section id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5 col-lg-4">
                <img src="<?=Url::to(['web/front/imgs/about.jpg'])?>" alt="The sacred journey starts with us, we take you there" class="w-100 img-thumbnail mb-3">
            </div>
            <div class="col-md-7 col-lg-8">
                <h6 class="section-subtitle mb-0">Maqam Travels</h6>
                <h6 class="section-title mb-3">We take you there</h6>
                <p>Maqam Travels, we specialize in providing unparalleled Hajj and Umrah services, meticulously crafted to fulfill the spiritual aspirations of pilgrims.</p>
                <p>Incorporated in 2022, we have swiftly emerged as the fastest-growing company in the industry, driven by our unwavering commitment to excellence and customer satisfaction.</p>
            </div>
        </div>
    </div>
</section>
<!-- End of About Section -->

<!-- Service Section -->
<section id="service">
    <div class="container">
        <h6 class="section-subtitle text-center">What we do</h6>
        <h5 class="section-title text-center mb-6">Our Services</h5>
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="mb-4"><i class="fa-solid fa-kaaba"></i></h2>
                        <h6 class="card-title">Hajj & Umrah</h6>
                        <p>We prioritize safety, convenience, and peace of mind, offering round-the-clock assistance and support to ensure that your journey proceeds smoothly and seamlessly.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="mb-4"><i class="fa-solid fa-id-card"></i></h2>
                        <h6 class="card-title">Visa processing</h6>
                        <p>Our visa services are precisely designed to alleviate the burden of paperwork and logistics, allowing you to focus whole heartedly on your journey.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="mb-4"><i class="fa-solid fa-plane"></i></h2>
                        <h6 class="card-title">Air ticketing</h6>
                        <p>With our expertise and partnerships with reputable airlines, we facilitate hassle-free booking of return air tickets tailored to your travel preferences and schedules.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="mb-4"><i class="fa-solid fa-hotel"></i></h2>
                        <h6 class="card-title">Hotel reservations</h6>
                        <p>Spiritual comfort and convenience with our 5 star hotel accommodations tailored for pilgrims in the heart of Makkah and Madinah.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="mb-4"><i class="fa-solid fa-bus-simple"></i></h2>
                        <h6 class="card-title">Ground transport</h6>
                        <p>We offer comprehensive ground transport services for pilgrims during their stay in the holy cities of Makkah and Madinah.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="mb-4"><i class="fa-solid fa-map-location-dot"></i></h2>
                        <h6 class="card-title">Historical sites tour</h6>
                        <p>We offer enriching historical sites tours of Madinah and Makkah, allowing pilgrims to delve deeper into the rich cultural and religious.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="mb-4"><i class="fa-solid fa-passport"></i></h2>
                        <h6 class="card-title">Passport processing</h6>
                        <p>We work closely with the relevant authorities to expedite the processing of your Passport, minimizing wait times. </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="mb-4"><i class="fa-solid fa-handshake-angle"></i></h2>
                        <h6 class="card-title">Sonda Mpola</h6>
                        <p>Deposit small amounts over a certain period and gradually build up the total amount of money required to perform Umrah.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End of Service Section -->

<!-- Portfolio section -->
<section id="portfolio">
    <div class="container text-center">
        <h6 class="section-subtitle">Journey with Maqam</h6>
        <h6 class="section-title mb-5">Featured Photos</h6>
        <div class="row">
            <div class="col-sm-4">
                <div class="img-wrapper">
                    <img src="<?=Url::to(['web/front/imgs/folio-1.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    <div class="overlay">
                        <div class="overlay-infos">
                            <h5>January Umrah 2024</h5>
                            <a href="javascript:void(0)"><i class="ti-zoom-in"></i></a>
                            <a href="javascript:void(0)"><i class="ti-link"></i></a>
                        </div>
                    </div>
                </div>
                <div class="img-wrapper">
                    <img src="<?=Url::to(['web/front/imgs/folio-2.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    <div class="overlay">
                        <div class="overlay-infos">
                            <h5>December Umrah 2023</h5>
                            <a href="javascript:void(0)"><i class="ti-zoom-in"></i></a>
                            <a href="javascript:void(0)"><i class="ti-link"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="img-wrapper">
                    <img src="<?=Url::to(['web/front/imgs/folio-3.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    <div class="overlay">
                        <div class="overlay-infos">
                            <h5>August Umrah 2023</h5>
                            <a href="javascript:void(0)"><i class="ti-zoom-in"></i></a>
                            <a href="javascript:void(0)"><i class="ti-link"></i></a>
                        </div>
                    </div>
                </div>
                <div class="img-wrapper">
                    <img src="<?=Url::to(['web/front/imgs/folio-4.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    <div class="overlay">
                        <div class="overlay-infos">
                            <h5>October Umrah 2023</h5>
                            <a href="javascript:void(0)"><i class="ti-zoom-in"></i></a>
                            <a href="javascript:void(0)"><i class="ti-link"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="img-wrapper">
                    <img src="<?=Url::to(['web/front/imgs/folio-5.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    <div class="overlay">
                        <div class="overlay-infos">
                            <h5>Ramadhan Umrah 2023</h5>
                            <a href="javascript:void(0)"><i class="ti-zoom-in"></i></a>
                            <a href="javascript:void(0)"><i class="ti-link"></i></a>
                        </div>
                    </div>
                </div>
                <div class="img-wrapper">
                    <img src="<?=Url::to(['web/front/imgs/folio-6.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    <div class="overlay">
                        <div class="overlay-infos">
                            <h5>Hajj 2023</h5>
                            <a href="javascript:void(0)"><i class="ti-zoom-in"></i></a>
                            <a href="javascript:void(0)"><i class="ti-link"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of portfolio section -->

<!-- Team Section -->
<section id="team">
    <div class="container">
        <h6 class="section-subtitle text-center">Meet With</h6>
        <h6 class="section-title mb-5 text-center">Maqam Team</h6>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="card text-center mb-4">
                    <img class="card-img-top inset" src="<?=Url::to(['web/front/imgs/avatar.jpg'])?>">
                    <div class="card-body">
                        <h6 class="small text-primary font-weight-bold">Managing Director</h6>
                        <h5 class="card-title">MAFO SHAFIK</h5>
                        <p>As the Managing Director, He oversees the strategic direction and overall management of the company.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-center mb-4">
                    <img class="card-img-top inset" src="<?=Url::to(['web/front/imgs/avatar-1.jpg'])?>">
                    <div class="card-body">
                        <h6 class="small text-primary font-weight-bold">Head of Corporate Affairs</h6>
                        <h5 class="card-title">KASIRYE NASIF NALUMOSO</h5>
                        <p>Responsible for managing relationships with stakeholders, government agencies, and regulatory bodies.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-center mb-4">
                    <img class="card-img-top inset" src="<?=Url::to(['web/front/imgs/avatar-2.jpg'])?>">
                    <div class="card-body">
                        <h6 class="small text-primary font-weight-bold">Senior Accountant</h6>
                        <h5 class="card-title">KASIRYE SHAMIM</h5>
                        <p>She ensures our financial processes are efficient, transparent, and in accordance with industry standards and regulations.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-center mb-4">
                    <img class="card-img-top inset" src="<?=Url::to(['web/front/imgs/avatar-3.jpg'])?>">
                    <div class="card-body">
                        <h6 class="small text-primary font-weight-bold">Digital Media Specialist</h6>
                        <h5 class="card-title">KALANZI IBRAHIM</h5>
                        <p>Enhance our online presence & ensures that our digital footprint aligns with our brand values and objectives.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-center mb-4">
                    <img class="card-img-top inset" src="<?=Url::to(['web/front/imgs/avatar-4.jpg'])?>">
                    <div class="card-body">
                        <h6 class="small text-primary font-weight-bold">Operations Manager</h6>
                        <h5 class="card-title">MUS’AB MUSTAFA</h5>
                        <p>Oversees the day-to-day operations and ensuring seamless execution and exceptional customer experiences.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-center mb-4">
                    <img class="card-img-top inset" src="<?=Url::to(['web/front/imgs/avatar-5.jpg'])?>">
                    <div class="card-body">
                        <h6 class="small text-primary font-weight-bold">Public Relations 0fficer</h6>
                        <h5 class="card-title">SSEKIKUBO YASIN KISULE</h5>
                        <p>Managing communication and fostering positive relationships with the media and the public.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End of Team Section -->

<!-- Fatcs Section -->
<section class="has-bg-img bg-img-2">
    <div class="container text-center">
        <h6 class="section-subtitle">We Are Awesome</h6>
        <h6 class="section-title mb-6">Maqam Objectives</h6>
        <div class="widget-2">
            <div class="widget-item">
                <i class="fa-solid fa-bullseye"></i>
                <h6 class="title">Mission</h6>
                <div class="subtitle">Our mission is to facilitate a transformative pilgrimage experience, ensuring every step of the journey is imbued with comfort, safety, and spiritual enrichment</div>
            </div>
            <div class="widget-item">
                <i class="fa-solid fa-eye"></i>
                <h6 class="title">Vision</h6>
                <div class="subtitle">We envision becoming the premier choice for pilgrims worldwide, recognized for our exceptional service, integrity, and dedication to upholding the sacred traditions of Hajj and Umrah.</div>
            </div>
            <div class="widget-item">
                <i class="fa-solid fa-coins"></i>
                <h6 class="title">Core Values</h6>
                <div class="subtitle">Integrity, Excellence, Respect, Compassion and Community Support</div>
            </div>
            <div class="widget-item">
                <i class="ti-cup"></i>
                <h6 class="title">Goals</h6>
                <div class="subtitle">To provide unmatched pilgrimage experiences while fostering sustainable growth, operational excellence, and community engagement.</div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section id="testimonial">
    <div class="container">
        <h6 class="section-subtitle text-center">Testimonials</h6>
        <h6 class="section-title text-center mb-6">What Our pilgrims Says</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="testimonial-wrapper">
                    <div class="img-holder">
                        <img src="<?=Url::to(['web/front/imgs/avatar-6.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    </div>
                    <div class="body">
                        <p class="subtitle">It was a pleasure performing Hajj with you. I am grateful for your care and patience and most importantly the duas. May Allah reward you with Janat firdous and accept our Hajj.</p>
                        <h6 class="title">Sumayyah Ssengendo</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="testimonial-wrapper">
                    <div class="img-holder">
                        <img src="<?=Url::to(['web/front/imgs/avatar-7.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    </div>
                    <div class="body">
                        <p class="subtitle">Thank you team Maqam for the life changing journey. I am forever grateful for all your efforts both personal and as a team towards all pilgrims.</p>
                        <h6 class="title">Moses Kaddu</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of Testimonial Section -->

<!-- Video Section -->
<section class="has-bg-img py-lg">
    <div class="container text-center">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary play-control" data-toggle="modal" data-target="#exampleModalCenter">
            <i class="ti-control-play" ></i>
        </button>
        <h6 class="section-title mt-4">Maqam experience | Watch video</h6>

    </div>
</section>
<!-- End of Video Section -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <iframe width="100%" height="475" src="https://www.youtube.com/embed/tLSNMC0ySDY?si=tzva-GV8j32prN7V&amp" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>
<!-- end of modal -->

<!-- Blog Section -->
<section id="blog">
    <div class="container">
        <h6 class="section-subtitle text-center">Whats new?</h6>
        <h6 class="section-title mb-6 text-center">Maqam Blog</h6>

        <div class="row">
            <div class="col-md-4">
                <div class="card blog-post my-4 my-sm-5 my-md-0">
                    <img src="<?=Url::to(['web/front/imgs/blog-1.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    <div class="card-body">
                        <div class="details mb-3">
                            <a href="javascript:void(0)"><i class="ti-comments"></i> 123</a>
                            <a href="javascript:void(0)"><i class="ti-eye"></i> 123</a>
                        </div>
                        <h5 class="card-title">We changed the Name!</h5>
                        <p>Former Multazam Travels changed to Maqam Travels through a compaign called "Tulina Ekipya" on December 21st 2023 joined with December Umrah 2023 send-off Ceremony</p>
                        <a href="javascript:void(0)" class="d-block mt-3">Read More...</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card blog-post my-4 my-sm-5 my-md-0">
                    <img src="<?=Url::to(['web/front/imgs/blog-2.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    <div class="card-body">
                        <div class="details mb-3">
                            <a href="javascript:void(0)"><i class="ti-comments"></i> 434</a>
                            <a href="javascript:void(0)"><i class="ti-eye"></i> 987</a>
                        </div>
                        <h5 class="card-title">Introducing Maqam App</h5>
                        <p>The future is digital, and we're here to guide you in every step of the way. We’re part of the digital transformation community with the first pilgrim mobile app in Uganda, Maqam App.</p>
                        <a href="javascript:void(0)" class="d-block mt-3">Read More...</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card blog-post my-4 my-sm-5 my-md-0">
                    <img src="<?=Url::to(['web/front/imgs/blog-3.jpg'])?>" alt="The sacred journey starts with us, we take you there">
                    <div class="card-body">
                        <div class="details mb-3">
                            <a href="javascript:void(0)"><i class="ti-comments"></i> 164</a>
                            <a href="javascript:void(0)"><i class="ti-eye"></i> 425</a>
                        </div>
                        <h5 class="card-title">Save for a sacred journey</h5>
                        <p>We introduced Sonda Mpola, the system which is to enable Muslims to invest small amounts over a certain period and gradually build up the total amount of money required to perform Umrah.</p>
                        <a href="javascript:void(0)" class="d-block mt-3">Read More...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of Blog Section -->

<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="contact-card">
            <div class="infos">
                <h6 class="section-subtitle">Get Here</h6>
                <h6 class="section-title mb-4">Contact Us</h6>
                <div class="item">
                    <i class="ti-location-pin"></i>
                    <div class="">
                        <h5>Location</h5>
                        <p> 1st Floor AAA Complex, Bukoto Kisasi Road, Kampala Uganda</p>
                    </div>
                </div>
                <div class="item">
                    <i class="ti-mobile"></i>
                    <div>
                        <h5>Phone Number</h5>
                        <p>+256 709 741486</p>
                    </div>
                </div>
                <div class="item">
                    <i class="ti-email"></i>
                    <div class="mb-0">
                        <h5>Email Address</h5>
                        <p>info@maqamtravels.com</p>
                    </div>
                </div>
                <div class="item">
                    <i class="fa-brands fa-whatsapp"></i>
                    <div class="mb-0">
                        <h5>WhatsApp us</h5>
                        <a href="https:wa.me/+256709741486" target=”_blank” class="link"><p>Click here to send a massage</p></a>
                    </div>
                </div>
            </div>
            <div class="form">
                <h6 class="section-subtitle">Available 24/7</h6>
                <h6 class="section-title mb-4">Get In Touch</h6>
                <form>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <textarea name="contact-message" id="" cols="30" rows="7" class="form-control form-control-lg" placeholder="Message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section -->

<section class="has-bg-img py-0">
    <div class="container">
        <div class="footer">
            <div class="footer-lists">
                <ul class="list">
                    <li class="list-head">
                        <h6 class="font-weight-bold">ABOUT US</h6>
                    </li>
                    <li class="list-body">
                        <a href="#" class="logo">
                            <img src="<?=Url::to(['web/front/imgs/logo.png'])?>" alt="The sacred journey starts with us, we take you there">
                            <h6>Maqam Travels</h6>
                        </a>
                        <p>we specialize in providing unparalleled Hajj and Umrah services, meticulously crafted to fulfill the spiritual aspirations of pilgrims.</p>
                        <p class="mt-3">
                            Copyright <script>document.write(new Date().getFullYear())</script> &copy; <a class="d-inline text-primary" href="https://www.facebook.com/ibra.kalanzi/" target=”_blank”>Kalanzi Ibrahim</a>
                        </p>
                    </li>
                </ul>
                <ul class="list">
                    <li class="list-head">
                        <h6 class="font-weight-bold">QUICK ACCESS</h6>
                    </li>
                    <li class="list-body">
                        <div class="row">
                            <div class="col">
                                <a href="#about">About</a>
                                <a href="#service">Service</a>
                                <a href="#team">Team</a>
                                <a href="#portfolio">Portfolio</a>
                                <a href="<?=Url::to(['cancellation-refund-policy'])?>">Cancellation Refund Policy</a>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="list">
                    <li class="list-head">
                        <h6 class="font-weight-bold">CONTACT INFO</h6>
                    </li>
                    <li class="list-body">
                        <p>Call or WhatsApp +256 709 741486</p>
                        <p><i class="ti-location-pin"></i> 1st Floor AAA Complex, Bukoto Kisasi Road, Kampala Uganda.</p>
                        <p><i class="ti-email"></i>  info@maqamtravels.com</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/maqamtravel" target=”_blank” class="link"><i class="fa-brands fa-facebook"></i></i></a>
                            <a href="https://twitter.com/maqam_travels" target=”_blank” class="link"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="https://www.instagram.com/maqam_travels" target=”_blank” class="link"><i target=”_blank” class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.tiktok.com/@maqamtravels" target=”_blank” class="link"><i target=”_blank” class="fa-brands fa-tiktok"></i></a>
                            <a href="https://www.youtube.com/@maqamtravels" target=”_blank” class="link"><i target=”_blank” class="fa-brands fa-youtube"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


