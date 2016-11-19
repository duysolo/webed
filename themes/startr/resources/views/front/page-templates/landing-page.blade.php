@extends('webed-theme-startr::front._master')

@section('content')
    <!-- top pan -->
    <section class="top-pan">
        <div class="container">
            <ul class="row">
                <li class="col-xs-12 col-sm-3 col-md-2 col-lg-2 ">Trusted by</li>
                <li class="col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                    <a href="#"><img src="{{ asset('themes/startr/images/logoes/logoes-1.png') }}" alt=""
                                     class="img-responsive"/></a>
                </li>
                <li class="col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                    <a href="#"><img src="{{ asset('themes/startr/images/logoes/logoes-2.png') }}" alt=""
                                     class="img-responsive"/></a>
                </li>
                <li class="col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                    <a href="#"><img src="{{ asset('themes/startr/images/logoes/logoes-3.png') }}" alt=""
                                     class="img-responsive"/></a>
                </li>
                <li class="col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                    <a href="#"><img src="{{ asset('themes/startr/images/logoes/logoes-4.png') }}" alt=""
                                     class="img-responsive"/></a>
                </li>
                <li class="col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                    <a href="#"><img src="{{ asset('themes/startr/images/logoes/logoes-5.png') }}" alt=""
                                     class="img-responsive"/></a>
                </li>
            </ul>
        </div>
    </section>
    <!-- top pan -->

    <!-- section-one -->
    <section class="section-one text-center" id="section-one">
        <div class="container">
            <header role="title-page">
                <h4>What we do</h4>
                <h2>We make your business gain more<br/>revenue at a glance.</h2>
            </header>
            <article>
                <p>Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo risus, porta ac consectetur
                    ac, ves
                    <br/>
                    tibulum at eros. Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a
                    pharetra augue.
                    <br/>
                    Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Maecenas mollis
                    interdum!
                </p>
            </article>

            <!-- four boxes  -->
            <div class="row four-box-pan" role="four-box">
                <section class="col-xs-12 col-sm-6 col-md-3">
                    <figure><i class="fa fa-rocket" aria-hidden="true"></i></figure>
                    <h5>STARTUP FEATURE</h5>
                    <p>Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo orta felis euismod
                        semper.</p>
                </section>

                <section class="col-xs-12 col-sm-6 col-md-3">
                    <figure><i class="fa fa-magic" aria-hidden="true"></i></figure>
                    <h5>Higly customizable</h5>
                    <p>Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo orta felis euismod
                        semper.</p>
                </section>

                <section class="col-xs-12 col-sm-6 col-md-3">
                    <figure><i class="fa fa-paper-plane" aria-hidden="true"></i></figure>
                    <h5>Simplified workflow</h5>
                    <p>Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo orta felis euismod
                        semper.</p>
                </section>

                <section class="col-xs-12 col-sm-6 col-md-3">
                    <figure><i class="fa fa-television" aria-hidden="true"></i></figure>
                    <h5>Cross platform</h5>
                    <p>Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo orta felis euismod
                        semper.</p>
                </section>
            </div>
            <!-- four boxes -->
        </div>
    </section>
    <!-- section-one -->

    <!-- section-two -->
    <section class="section-two" id="section-two">
        <!-- image-content -->
        <section>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <article>
                    <h2>Get Maxium benifites by working with our experts.</h2>
                    <p>Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo orta felis euismod
                        semper.Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo orta felis
                        euismod semper.</p>
                    <ul>
                        <li>Maecenas sed diam eget risus varius</li>
                        <li>orta felis euismod semper.Maecenas sed diam</li>
                        <li>amet non magna. Morbi leo orta semper.</li>
                        <li>Maecenas sed diam eget risus</li>
                    </ul>
                </article>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <figure class="row" style="background-image:url('{{ asset('themes/startr/images/images-1.jpg') }}')"></figure>
            </div>
        </section>

        <!-- image-content -->
        <div class="clearfix"></div>
        <!-- image-content -->

        <section>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <figure class="row" style="background-image:url('{{ asset('themes/startr/images/images-2.jpg') }}')"></figure>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <article>
                    <h2>We even give you more than your expectation</h2>
                    <p>Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo orta felis euismod
                        semper.Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo orta felis
                        euismod semper.Maecenas sed diam eget risus varius blandit sit amet non magna. </p>
                    <p>Morbi leo orta felis euismod semper.Maecenas sed diam eget risus varius blandit sit amet non
                        magna. Morbi leo orta felis euismod semper.Morbi leo orta felis euismod semper.Maecenas sed diam
                        eget risus varius.</p>
                </article>
            </div>
        </section>
        <!-- image-content -->

        <div class="clearfix"></div>

        <!-- video -->
        <div class="video-pan text-center">
            <a id="video" class="player"
               data-property="{videoURL:'https://www.youtube.com/watch?v=0K-g84sK6R0',containment:'.bg-container-youtube', showControls:false,autoPlay:true, loop:true, startAt:0, opacity:1, addRaster:false, quality:'large'}"></a>
            <!-- 5.0 background container autoPlay:true,  -->

            <div class="bg-container-youtube"></div>
            <header>
                <a class="popup-vimeo video-button" href="https://vimeo.com/45830194">
                    <i class="fa fa-caret-right" aria-hidden="true"></i>
                </a>
                <h4>Video Preview Of Product</h4>
            </header>
        </div>
        <!-- video -->

        <!--slider pan -->
        <div class="slider-pan">
            <header role="title-page" class="text-center">
                <h4>Customer Voice</h4>
            </header>
            <!-- carousel -->
            <div id="owl-demo" class="owl-carousel text-center" role="slider">
                <section class="item">
                    <article>
                        Morbi leo orta felis euismod semper.Maecenas sed diam eget risus varius blandit sit <br/>
                        amet non magna felis euismod leo orta felis semper.
                    </article>
                    <header>
                        <h5>Antony Casalena</h5>
                        <h6>Vice president, IQTeam</h6>
                    </header>
                </section>

                <section class="item">
                    <article>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam quis tortor nec diam dapibus<br>
                        efficitur in quis sem. Morbi tristique purus at vestibulum malesuada.
                    </article>
                    <header>
                        <h5>Brain Rice</h5>
                        <h6>VP, Lexix Pvt Ltd</h6>
                    </header>
                </section>

                <section class="item">
                    <article>
                        Morbi leo orta felis euismod semper.Maecenas sed diam eget risus varius blandit sit <br/>
                        amet non magna felis euismod leo orta felis semper.
                    </article>
                    <header>
                        <h5>Antony Casalena</h5>
                        <h6>Vice president, IQTeam</h6>
                    </header>
                </section>

                <section class="item">
                    <article>
                        Morbi leo orta felis euismod semper.Maecenas sed diam eget risus varius blandit sit <br/>
                        amet non magna felis euismod leo orta felis semper.
                    </article>
                    <header>
                        <h5>Antony Casalena</h5>
                        <h6>Vice president, IQTeam</h6>
                    </header>
                </section>
            </div>
            <!-- carousel -->
        </div>
        <!--slider pan -->
    </section>
    <!-- section-two -->

    <!-- section-three -->
    <section class="section-three" id="section-three">

        <div class="container">

            <header role="title-page" class="text-center">

                <h4>Flexible Plans</h4>

                <h2>Select the plan that suits you. Upgrade,<br/> downgrade, or cancel anytime.</h2>

            </header>

            <!-- pricing -->

            <div class="pricing">

                <section>

                    <header><h4>Bronze</h4></header>

                    <h2><span>$10</span> /mo</h2>

                    <ul>

                        <li>Free Shipping</li>

                        <li>24/7 Support</li>

                        <li>Single Licence</li>

                    </ul>

                    <input name="" type="button" value="get Strated">

                </section>

                <section>

                    <header><h4>Silver</h4></header>

                    <h2><span>$20</span> /mo</h2>

                    <ul>

                        <li>Free Shipping</li>

                        <li>24/7 Support</li>

                        <li>Single Licence</li>

                    </ul>

                    <input name="" type="button" value="get Strated">

                </section>

                <section>

                    <header><h4>Gold</h4></header>

                    <h2><span>$50</span> /mo</h2>

                    <ul>

                        <li>Free Shipping</li>

                        <li>24/7 Support</li>

                        <li>Single Licence</li>

                    </ul>

                    <input name="" type="button" value="get Strated">

                </section>

            </div>

            <!-- pricing -->

        </div>

    </section>
    <!-- section-three -->

    <!-- section-four -->
    <section class="section-four" id="section-four">

        <div class="container">

            <header role="title-page" class="text-center">

                <h4>Meet The Team</h4>

                <h2>Our team is passionate about bringing the <br/>best for our customers.</h2>

            </header>

            <!-- Team -->

            <div class="team-pan row">


                <section class="col-xs-12 col-sm-6 col-md-3">

                    <figure><img src="{{ asset('themes/startr/images/team/image-1.jpg') }}" alt="" class=" img-responsive"/></figure>

                    <header>

                        <h5>Antony Casalena</h5>

                        <h6>Vice president</h6>

                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a>

                    </header>

                </section>

                <section class="col-xs-12 col-sm-6 col-md-3">

                    <figure><img src="{{ asset('themes/startr/images/team/image-1.jpg') }}" alt="" class=" img-responsive"/></figure>

                    <header>

                        <h5>Anaia Doe</h5>

                        <h6>Creative Head</h6>

                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a>

                    </header>

                </section>

                <section class="col-xs-12 col-sm-6 col-md-3">

                    <figure><img src="{{ asset('themes/startr/images/team/image-1.jpg') }}" alt="" class=" img-responsive"/></figure>

                    <header>

                        <h5>Johnathan Doe</h5>

                        <h6>Development Lead</h6>

                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a>

                    </header>

                </section>

                <section class="col-xs-12 col-sm-6 col-md-3">

                    <figure><img src="{{ asset('themes/startr/images/team/image-1.jpg') }}" alt="" class=" img-responsive"/></figure>

                    <header>

                        <h5>Julian Gulia</h5>

                        <h6>Marketing Head</h6>

                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>

                        <a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a>

                    </header>

                </section>


            </div>

            <!-- Team -->

        </div>

    </section>
    <!-- section-fore -->

    <!-- section-five -->
    <section class="section-five" id="section-five">

        <div class="container">

            <header role="title-page" class="text-center">

                <h4>Newsletter Subscribe</h4>

                <h2>Subscribe to get monthly products updates<br/>and exclusive offers</h2>

            </header>

            <!-- subscribe -->

            <div class="subscribe-form">

                <div class="ntify_form">

                    <form method="post" action="php/subscribe.php" name="subscribeform" id="subscribeform">

                        <input name="email" type="email" id="subemail" placeholder="Email Address">


                        <button type="submit" name="" value="Submit">

                            Subscribe <i class="fa fa-envelope" aria-hidden="true"></i></button>

                    </form>

                    <!-- subscribe message -->

                    <div id="mesaj"></div>

                    <!-- subscribe message -->

                </div>

            </div>

            <!-- subscribe -->

        </div>

    </section>
    <!-- section-five -->

    <!-- section-six -->
    <section class="section-six" id="section-six">

        <div class="container">

            <header role="title-page" class="text-center">

                <h4>Get in touch</h4>

                <h2>Have any questions? Our team will happy to<br/>answer your questionss.</h2>

            </header>

            <!-- contact-form -->

            <div class="contact-form">

                <div id="message"></div>

                <form method="post" action="php/contactfrom.php" name="cform" id="cform">

                    <div class="col-md-6 col-lg-6 col-sm-6">

                        <input name="name" id="name" type="text" placeholder="Full Name">

                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-6">

                        <input name="email" id="email" type="email" placeholder="Email Address">

                    </div>

                    <div class="clearfix"></div>

                    <textarea name="comments" id="comments" cols="" rows="" placeholder="Question in Detail"></textarea>

                    <div class="clearfix"></div>

                    <input name="" type="submit" value="Send mail">

                    <div id="simple-msg"></div>

                </form>

            </div>

            <!-- contact-form -->

            <div class="clearfix"></div>

        </div>

        <!-- map -->

        <div class="map-wrapper">

            <div id="surabaya"></div>

        </div>

        <!-- map -->

    </section>
    <!-- section-six -->
@endsection
