@extends('layout.app')

@section('content')

    <div class="container-fluid d-md-none">
        <div class="row align-items-center">
            <div class="col-12 text-center">
                <img src="/images/lp/breezer/clever_main_mobile.jpg" class="img-fluid">
                <h1>TION CLEVER</h1>
                <p class="subtitle product">Air cleaning and disinfection device</p>
            </div>
        </div>
    </div>

    <div class="container mb-3">
        <div class="row">
            <div class="col-12 d-none d-md-block">
                <h1>TION CLEVER</h1>
                <p class="subtitle">Air cleaning and disinfection device</p>
            </div>
        </div>
    </div>

    <div class="container-fluid d-none d-md-block p-0">
        <div class="product-clever-bg"></div>
    </div>

    <div class="container d-none d-sm-block">
        <h2 class="product"></h2>
        <p class="subtitle long">The Tion Clever device kills microorganisms, makes the air healthy, and protects you from a variety of potentially dangerous contaminants, including allergens, fine dust, and bacteria. Tion Clever is compatible with MagicAir can be controlled from a smartphone.</p>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="what d-flex col-md-4 col-12">
                <img class="mr-3" src="/images/lp/breezer/without_sick.svg" alt="">
                <div>
                    <div class="what-title">NO DISEASES</div>
                    <p>Due to the inactivation feature, viruses and allergens are captured inside Tion Clever and completely destroyed.</p>
                </div>
            </div>

            <div class="what d-flex col-md-4 col-12">
                <img class="mr-3" src="/images/lp//breezer/stop_allergy.svg" alt="">
                <div>
                    <div class="what-title">NO ALLERGY</div>
                    <p>Due to the special design and high capacity of the filters, Tion Clever captures several times more allergens than most other air cleaners</p>
                </div>
            </div>

            <div class="what d-flex col-md-4 col-12">
                <img class="mr-3" src="/images/lp//breezer/full_protection.svg" alt="">
                <div>
                    <div class="what-title">FULL PROTECTION</div>
                    <p>Integrated purification technology. The air is cleaned not only of dust, allergens, and viruses, but also of hazardous gases and odors.</p>
                </div>
            </div>

        </div>
    </div>

    <div class="container product-clever-configuration mb-5">
        <h2 class="product">TION CLEVER CONFIGURATIONS</h2>
        <div class="row justify-content-md-center">
            <div class="flex-column col-12 col-md-6 col-lg-4 product-clever-configuration_item mr-4">
                <h3>Clever MAC</h3>
                <div class="text-center"><img src="/images/lp/breezer/clever_shop.png" alt=""></div>
                <ul>
                    <li>Filters: G4+HEPA+AC against gases</li>
                    <li>Air disinfection</li>
                    <li>Inactivation/destruction of viruses</li>
                    <li>Protection from hazardous gases according to the MPC standards.</li>
                    <li>Filter replacement indication, remote controller</li>
                    <li>Wall placement</li>
                    <li><a href="/magicair">MagicAir</a> Compatible</li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-4 product-clever-configuration_item">
                <h3>Clever MAC-M</h3>
                <div class="text-center"><img src="/images/lp/breezer/clever_shop_m.png" alt=""></div>
                <ul>
                    <li>Filters: G4+HEPA+AC against gases</li>
                    <li>Air disinfection</li>
                    <li>Inactivation/destruction of viruses</li>
                    <li>Protection from hazardous gases according to the MPC standards.</li>
                    <li>Filter replacement indication, remote controller</li>
                    <li>Movable device (wheeled base)</li>
                    <li><a href="/magicair">MagicAir</a> Compatible</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid product-bg-video mt-5">
        <div class="d-none d-lg-block">
            <div class="col-12">
                <video id="v_desktop" class="product-video" width="100%" height="auto" autoplay="autoplay" loop="loop" src="/images/lp/breezer/clever_new.mp4" type="video/mp4"></video>
            </div>
        </div>

        <div class="no-gutters d-lg-none">
            <div class="col-12">
                <video id="v_mobile" class="product-video" width="100%" height="auto" controls autoplay="autoplay" loop="loop" src="/images/lp/breezer/clever_mob.mp4" type="video/mp4"></video>
            </div>
        </div>
    </div>

    <div class="container-fluid text-center mt-5">
        <h2 class="product">SMARTPHONE CONTROL</h2>
        <p class="subtitle">The MagicAir base station measures the air quality, transmits the data to the mobile app, and manages the air Tion Clever cleaning and disinfection device.</p>
        <img class="img-fluid" src="/images/lp/breezer/control-smart-eng.jpg" alt="Tion Clever Mac and Magicair system">
    </div>

    <div class="container mt-5 product-before-ma text-center">
        <img src="/images/lp/breezer/ma-e.svg" class="my-3">
    </div>

    <div class="container-fluid product-ma">
        <div class="row">
            <div class="container">

                <h2 class="product mt-5">TION CLEVER MAC AND MAGICAIR SYSTEM</h2>
                <p class="subtitle">Tion Clever MAC air purifier is connected to Magicair Base Station and can be operated with your smartphone.</p>

                <div class="row text-center align-items-center">
                    <div class="col-12 col-sm-4 indent">
                        <img src="/images/lp/breezer/upp-scheme.svg" class="img-fluid product-ma-phone" alt="Magicair">
                    </div>

                    <div class="col-12 col-sm-8 indent">
                        <img src="/images/lp/breezer/shema-clever-en.svg" class="img-fluid" alt="Tion Breezer 3S and Magicair system">
                    </div>
                </div>

                <div class="row product-ma-description">
                    <div class="col-12 col-lg-4">
                        <p>1. Establish connection between your Tion Clever and MagicAir Base Station. Now you have full information on the device’s operation in the palm of your hand!</p>
                    </div>

                    <div class="col-12 col-lg-4">
                        <p>2. Set power on/off time and Base Station will turn the device on and off accordingly.</p>
                    </div>

                    <div class="col-12 col-lg-4">
                        <p>3. Guide Tion Clever MAC air purifier as you want with manual control via smartphone.</p>
                    </div>
                </div>

                <div class="product-before-ma text-center my-3">
                    <img src="/images/lp/breezer/ma-e-white.svg">
                </div>

                <h2 class="product">HANDY MOBILE APPLICATION AND MAGICAIR WEB INTERFACE</h2>
                <p class="subtitle">Use free mobile application or MagicAir web interface to control your Tion Clever. The interface allows easy and fast connection and setup!</p>

                <div class="row text-center align-items-center mt-5">
                    <div class="col-4">
                        <img src="/images/lp/breezer/phone.svg" class="img-fluid product-ma-phone" alt="MagicAir application for IOS and Android">
                    </div>

                    <div class="col-8">
                        <img src="/images/lp/breezer/computer.svg" class="img-fluid product-ma-computer" alt="Web interface MagicAir for PC users">
                    </div>
                </div>

                <div class="row product-ma-caption">
                    <div class="col-12 col-sm-12 col-md-6">
                        <p>Free mobile app <a href="https://itunes.apple.com/ru/app/magicair/id1111104830?l=en&mt=8">IOS</a> and <a href="https://play.google.com/store/apps/details?id=com.tion.magicair&hl=ru">Android</a> compatible.</p>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6">
                        <p>Web interface for PC users.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="product">TION CLEVER FILTRATION</h2>
        <div class="row">
            <div class="col-12 col-lg-6 text-center">
                <img src="/images/lp/breezer/clever-filtration.svg" class="img-fluid" alt="Tion Clever filtration">
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="mb-5">
                    <h3 class="text-left">HEPA-filters</h3>
                    <p>In combination with an electrostatic unit, these filters provide protection from dust, viruses, and allergens with HEPA H10 grade efficiency. Due to the inactivation feature, the bulk HEPA filters are permanently sterile.</p>
                </div>
                <div class="mb-5">
                    <h3 class="text-left">Adsorption-catalytic filters</h3>
                    <p>Provide effective air cleaning from gases, harmful substances and odors. Totally decompose the ozone produced by an electrostatic unit for decontamination, and turn it into oxygen.</p>
                </div>
                <div class="mb-5">
                    <h3 class="text-left">Electrostatic unit</h3>
                    <p>Ionizes the particles and microorganisms for reliable absorption on the fibers of bulk HEPA filters. Produces ozone for inactivation (destruction) of the captured viruses, bacteria and allergens.</p>
                </div>
                <div class="mb-5">
                    <h3 class="text-left">Pre-filter G4</h3>
                    <p>Captures the larger particles (coarse dust, hair, etc.) with the G4 grade filtration efficiency, thus increasing the service life of the other components of the filtration system.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container product-advantage">
        <h2 class="product">ADVANTAGES</h2>
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-center"><img src="/images/lp/breezer/icon_06.svg" alt=""></div>
                <h3 class="text-left">CAPTURE AND KILL</h3>
                <p>Most air cleaners capture viruses and bacteria, but do not kill them. Microorganisms can survive and spawn on the filters. Tion Clever not only captures, but also kills the hazardous microorganisms.</p>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-center"><img src="/images/lp/breezer/icon_07.svg" alt=""></div>
                <h3 class="text-left">REAL EFFICIENCY</h3>
                <p>Many infections have become resistant to UV disinfection: they can mutate and become even more dangerous. Tion Clever inactivates (destroys) all types of viruses, bacteria and allergens. The efficiency of the technology has been confirmed by scientific research.</p>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-center"><img src="/images/lp/breezer/icon_08.svg" alt=""></div>
                <h3 class="text-left">SAFE FOR KIDS</h3>
                <p>The device does not contain UV lamps or mercury, does not emit harmful irradiation. It is totally safe for children and can work 24/7 in the presence of people. The filters are sterile and do not require special disposal.</p>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-center"><img src="/images/lp/breezer/icon_11.svg" alt=""></div>
                <h3 class="text-left">MONEY-SAVING FILTERS</h3>
                <p>The capacity of the Tion Clever bulk HEPA filters is 8-10 times higher than that of the regular HEPA filters. The period of effective work is longer, and filter replacement is required less often, 1-2 times per year.</p>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-center"><img src="/images/lp/breezer/icon_10.svg" alt=""></div>
                <h3 class="text-left">ENERGY-SAVING TECHNOLOGY</h3>
                <p>The device has a low power consumption — just 25 W/h (about 50 RUR/month). By comparison, an air cleaning and disinfection device with one UV-lamp consumes 6-8 times more power.</p>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-center"><img src="/images/lp/breezer/icon_09.svg" alt=""></div>
                <h3 class="text-left">USER-FRIENDLY APP</h3>
                <p>Connect Tion Clever to the smart microclimate system MagicAir and control it using a free mobile app. Use your smartphone as a remote controller or create a schedule for automatic operation of the device. The app will show the device status and remind you to replace filters.</p>
            </div>
        </div>
    </div>

    <div class="container got-questions mt-5">
        Got questions?
        <a class="email-link">Email us!</a>
    </div>


@endsection


