<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!doctype html>
<html lang="en">

<head>
    <?php
    $this->load->view('commons/header_meta');
    $this->load->view('commons/css_links');
    ?>
    <!-- about css -->

    <link rel="stylesheet" href="<?= base_url('assets/css/about.css'); ?>">

</head>

<body>

    <?php
    $this->load->view('commons/js_links');
    $this->load->view('commons/header');
    ?>

    <main id="content">

        <section class="hero-section">
            <div class="hero-bg-text parallax-bg">INNOVATION</div>
            <div class="container hero-content">
                <p class="hero-subtitle">Who We Are</p>
                <h1 class="hero-title">
                    <span class="d-block">We Reimagine</span>
                    <span class="d-block text-white-50">Tomorrow.</span>
                </h1>
            </div>
            <div class="scroll-indicator"></div>
        </section>

        <section class="leadership-section">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <h2 class="display-4 fw-bold text-white">Our Leadership</h2>
                        <p class="text-muted">Driving the future of technology with experience and passion.</p>
                    </div>
                </div>
                <div class="swiper leaderSwiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/ceo.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">CEO & Founder</p>
                                            <h4 class="text-white">Owais Meer</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/cto.jpeg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Chief Technology Officer</p>
                                            <h4 class="text-white">Aqeel Ahmed</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/iba.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">International Business Advisor</p>
                                            <h4 class="text-white">Abu Bakar</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bhe.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, Eastern USA</p>
                                            <h4 class="text-white">Awais Bajwa</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bhw.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, Western USA</p>
                                            <h4 class="text-white">Muhammad Ilyas</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bhs.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, Southern USA</p>
                                            <h4 class="text-white">Yusaf Bhuriwala</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bha.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, USA</p>
                                            <h4 class="text-white">Shamroz Khan</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bha.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, Australia</p>
                                            <h4 class="text-white">Mansoor</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bha.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, Middle East</p>
                                            <h4 class="text-white">Ahmed Ghafoor</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bhk.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, KSA, ANZ</p>
                                            <h4 class="text-white">Burhan Sheikh</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bha.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, UAE</p>
                                            <h4 class="text-white">Muhammad Khizer</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bha.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, Qatar</p>
                                            <h4 class="text-white">Muhammad Riaz</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bha2.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, Azerbaijan</p>
                                            <h4 class="text-white">Shafiq</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bha.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, Turkey</p>
                                            <h4 class="text-white">Kadir Tuncel</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/bhc2.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Business Head, Canada</p>
                                            <h4 class="text-white">Nuzhat Khan</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="leader-card-wrapper">
                                <div class="leader-card-3d">
                                    <div class="leader-card-inner">
                                        <img src="<?= base_url('assets/img/dbd.jpg') ?>" class="leader-img" alt="CEO">
                                        <div class="leader-info">
                                            <p class="badge bg-light text-dark rounded-pill">Director Business Development</p>
                                            <h4 class="text-white">Muhammad Ahmed</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Navigation buttons -->
                    <div class="btn rounded-circle text-dark swiper-button-next"></div>
                    <div class="btn rounded-circle text-dark swiper-button-prev"></div>
                </div>

            </div>
        </section>

        <section class="global-section-wrapper">
            <div class="global-progress-container">
                <div class="global-progress-bar"></div>
            </div>
            <div class="global-track">

                <div class="global-panel">
                    <div class="panel-content">
                        <div class="panel-text">
                            <span class="text-danger fw-bold">GLOBAL REACH</span>
                            <h2 class="split-anim">Connecting<br>Worlds.</h2>
                            <p class="lead text-muted">A presence in over 16 countries, delivering localized expertise on a global scale.</p>
                        </div>
                        <div class="panel-image">
                            <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800" alt="World">
                        </div>
                    </div>
                </div>

                <div class="global-panel">
                    <div class="panel-content">
                        <div class="panel-text">
                            <span class="text-danger fw-bold">01 - MIDDLE EAST</span>
                            <h2 class="split-anim">The Digital<br>Desert Hub.</h2>
                            <p class="text-muted">Leading-edge transformations across the MENA region.</p>
                        </div>
                        <div class="panel-image">
                            <img src="<?= base_url('assets/img/dubai.png'); ?>" alt="Dubai">
                        </div>
                    </div>
                </div>

                <div class="global-panel">
                    <div class="panel-content">
                        <div class="panel-text">
                            <span class="text-danger fw-bold">02 - ASIA PACIFIC</span>
                            <h2 class="split-anim">Growth &<br>Innovation.</h2>
                            <p class="text-muted">Capturing the pulse of the world's most dynamic markets.</p>
                        </div>
                        <div class="panel-image">
                            <img src="<?= base_url('assets/img/singapore.jpg'); ?>" alt="Singapore">
                        </div>
                    </div>
                </div>
                <div class="global-panel">
                    <div class="panel-content">
                        <div class="panel-text">
                            <span class="text-danger fw-bold">03 - NORTH AMERICA</span>
                            <h2 class="split-anim">Silicon Valley<br>Synergy.</h2>
                            <p class="text-muted">Bridging the gap between legacy systems and disruptive cloud-native technologies in the heart of innovation.</p>
                        </div>
                        <div class="panel-image">
                            <img src="<?= base_url('assets/img/sanfrancisco.jpg'); ?>" alt="San Francisco">
                        </div>
                    </div>
                </div>

                <div class="global-panel">
                    <div class="panel-content">
                        <div class="panel-text">
                            <span class="text-danger fw-bold">04 - EUROPE</span>
                            <h2 class="split-anim">The Industrial<br>Renaissance.</h2>
                            <p class="text-muted">Leading the charge in smart manufacturing and sustainable tech across the EU's strongest economies.</p>
                        </div>
                        <div class="panel-image">
                            <img src="<?= base_url('assets/img/europe.jpg'); ?>" alt="Europe Tech">
                        </div>
                    </div>
                </div>

                <div class="global-panel">
                    <div class="panel-content">
                        <div class="panel-text">
                            <span class="text-danger fw-bold">05 - UNITED KINGDOM</span>
                            <h2 class="split-anim">Fintech &<br>Future-Proof.</h2>
                            <p class="text-muted">Mastering the intersection of traditional finance and modern digital banking in London's square mile.</p>
                        </div>
                        <div class="panel-image">
                            <img src="<?= base_url('assets/img/london.jpg'); ?>" alt="London">
                        </div>
                    </div>
                </div>

                <div class="global-panel">
                    <div class="panel-content">
                        <div class="panel-text">
                            <span class="text-danger fw-bold">06 - LATIN AMERICA</span>
                            <h2 class="split-anim">Emerging<br>Horizons.</h2>
                            <p class="text-muted">Capturing growth in the fastest-growing mobile-first economies of Brazil and Mexico.</p>
                        </div>
                        <div class="panel-image">
                            <img src="<?= base_url('assets/img/brazil.jpg'); ?>" alt="Brazil">
                        </div>
                    </div>
                </div>

                <div class="global-panel">
                    <div class="panel-content">
                        <div class="panel-text">
                            <span class="text-danger fw-bold">07 - AFRICA</span>
                            <h2 class="split-anim">Mobile-First<br>Movement.</h2>
                            <p class="text-muted">Empowering financial inclusion and connectivity through decentralized tech hubs across Nigeria and Kenya.</p>
                        </div>
                        <div class="panel-image">
                            <img src="<?= base_url('assets/img/nairobi.jpg'); ?>" alt="Nairobi">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="clients-section">
            <div id="canvas-container"></div>

            <div class="container">
                <div class="text-center mb-5 pb-5">
                    <span class="section-sub gs-reveal">The Ecosystem</span>
                    <h2 class="text-dark display-3 fw-bold gs-reveal" style="font-family: 'Playfair Display', serif; font-style: italic;">Our Elite Clients</h2>
                </div>

                <div class="row g-4">
                    <div class="col-md-4 premium-card-wrapper gs-reveal-card">
                        <div class="premium-card">
                            <div class="card-sheen"></div>
                            <div class="card-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#ff3b30" stroke-width="1.5">
                                    <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                                </svg>
                            </div>
                            <h4>Soul Konnection</h4>
                            <p>Soul Konnection is a unique matchmaking platform that blends expert matchmakers with smart algorithms.</p>
                            <a class="card-footer-tag" href="<?= site_url('Contact'); ?>">Contact Us</a>

                        </div>
                    </div>

                    <div class="col-md-4 premium-card-wrapper gs-reveal-card">
                        <div class="premium-card">
                            <div class="card-sheen"></div>
                            <div class="card-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#ff3b30" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z" />
                                </svg>
                            </div>
                            <h4>Quizoon</h4>
                            <p>Challenge yourself with fun Trivia questions and boost your knowledge accros various categories.</p>
                            <a class="card-footer-tag" href="<?= site_url('Contact'); ?>">Contact Us</a>

                        </div>
                    </div>

                    <div class="col-md-4 premium-card-wrapper gs-reveal-card">
                        <div class="premium-card">
                            <div class="card-sheen"></div>
                            <div class="card-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#ff3b30" stroke-width="1.5">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                </svg>
                            </div>
                            <h4>Blaze</h4>
                            <p>Discover a world of mature and meaningful connections.</p>
                            <a class="card-footer-tag" href="<?= site_url('Contact'); ?>">Contact Us</a>

                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>
    <?php $this->load->view('commons/footer'); ?>



    <script>
        const lenis = new Lenis();

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
        gsap.registerPlugin(ScrollTrigger);

        const heroTl = gsap.timeline();

        // Initial Reveal
        heroTl.to(".hero-subtitle", {
                opacity: 1,
                duration: 1,
                delay: 0.5
            })
            .to(".hero-title", {
                opacity: 1,
                y: 0,
                duration: 1.2,
                ease: "power3.out"
            }, "-=0.5");

        // Parallax Effect on Scroll
        gsap.to(".hero-bg-text", {
            yPercent: 50, // Moves down slower than scroll
            ease: "none",
            scrollTrigger: {
                trigger: ".hero-section",
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });
        // --- 3D CARD LOGIC ---
        const cards = document.querySelectorAll('.leader-card-3d');
        cards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const {
                    left,
                    top,
                    width,
                    height
                } = card.getBoundingClientRect();
                const x = (e.clientX - left) / width - 0.5;
                const y = (e.clientY - top) / height - 0.5;

                gsap.to(card, {
                    rotationY: x * 30, // 30 degree max tilt
                    rotationX: -y * 30,
                    ease: "power2.out",
                    duration: 0.6
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    rotationX: 0,
                    rotationY: 0,
                    ease: "elastic.out(1, 0.3)",
                    duration: 1.2
                });
            });
        });

        // --- STEPPED HORIZONTAL SCROLL ---
        const track = document.querySelector('.global-track');
        const panels = gsap.utils.toArray('.global-panel');
        const progressBar = document.querySelector('.global-progress-bar');

        let scrollTween = gsap.to(track, {
            xPercent: -100 * (panels.length - 1),
            ease: "none",
            scrollTrigger: {
                trigger: ".global-section-wrapper",
                pin: true,
                scrub: 1.8,
                start: "top top",
                // Increase this number (e.g., 4000) to make it "stickier"
                end: () => "+=" + 4500,
                snap: {
                    snapTo: 1 / (panels.length - 1),
                    duration: {
                        min: 0.2,
                        max: 0.6
                    },
                    delay: 0.1,
                    ease: "power1.inOut"
                },
                onUpdate: (self) => {
                    gsap.to(progressBar, {
                        width: (self.progress * 100) + "%",
                        overwrite: true
                    });
                }
            }
        });

        // --- PANEL CONTENT ANIMATIONS ---
        panels.forEach((panel) => {
            const h2 = panel.querySelector('h2');
            const img = panel.querySelector('.panel-image');

            // Text slides up as panel becomes active
            gsap.from(h2, {
                y: 50,
                opacity: 0,
                duration: 1,
                scrollTrigger: {
                    trigger: panel,
                    containerAnimation: scrollTween,
                    start: "left 60%",
                    toggleActions: "play none none reverse"
                }
            });

            // Image scales up slightly for a premium reveal
            gsap.from(img, {
                scale: 0.9,
                opacity: 0,
                duration: 1.2,
                scrollTrigger: {
                    trigger: panel,
                    containerAnimation: scrollTween,
                    start: "left 60%",
                    toggleActions: "play none none reverse"
                }
            });
        });



        // --- THREE.JS BACKGROUND ---
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({
            alpha: true,
            antialias: true
        });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('canvas-container').appendChild(renderer.domElement);

        // Create floating crystal-like objects
        const geometry = new THREE.IcosahedronGeometry(1, 0);
        const material = new THREE.MeshNormalMaterial({
            wireframe: true,
            transparent: true,
            opacity: 0.1
        });
        const crystals = [];

        for (let i = 0; i < 15; i++) {
            const mesh = new THREE.Mesh(geometry, material);
            mesh.position.set((Math.random() - 0.5) * 15, (Math.random() - 0.5) * 15, (Math.random() - 0.5) * 15);
            mesh.rotation.set(Math.random() * 2, Math.random() * 2, Math.random() * 2);
            scene.add(mesh);
            crystals.push(mesh);
        }
        camera.position.z = 5;

        function animateThree() {
            requestAnimationFrame(animateThree);
            crystals.forEach(c => {
                c.rotation.x += 0.002;
                c.rotation.y += 0.002;
            });
            renderer.render(scene, camera);
        }
        animateThree();

        // --- MOUSE & SHEEN LOGIC ---
        document.querySelectorAll('.premium-card').forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                // Update Sheen CSS Variables
                card.style.setProperty('--mouse-x', `${(x / rect.width) * 100}%`);
                card.style.setProperty('--mouse-y', `${(y / rect.height) * 100}%`);

                // 3D Tilt
                const rotateX = ((y / rect.height) - 0.5) * -20;
                const rotateY = ((x / rect.width) - 0.5) * 20;

                gsap.to(card, {
                    rotationX: rotateX,
                    rotationY: rotateY,
                    duration: 0.4,
                    ease: "power2.out"
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    rotationX: 0,
                    rotationY: 0,
                    duration: 0.8,
                    ease: "elastic.out(1, 0.3)"
                });
            });
        });

        // Handle Resize
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });


        const swiper = new Swiper(".leaderSwiper", {
            loop: true,
            slidesPerView: 4,
            spaceBetween: 30,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                576: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 4
                }
            }
        });
    </script>
</body>

</html>