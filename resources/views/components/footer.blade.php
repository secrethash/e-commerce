

     <!-- Footer Area Start -->
     <div class="footer-area">
        <div class="footer-container">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-lg-4 mb-md-30px mb-lm-30px">
                            <div class="single-wedge">
                                <div class="footer-logo">
                                    <a href="index"><img class="img-responsive" src="{{asset('frontend/assets/images/logo/manarat-logo-dark.png')}}" alt="logo.png" /></a>
                                </div>
                                <div class="need_help">
                                <p class="add"><span class="address">Address</span>{{ Shopper\Framework\Models\System\Country::find(shopper_setting('shop_country_id'))->flag }} {{ shopper_setting('shop_street_address') }}, {{ shopper_setting('shop_city') }} - {{ shopper_setting('shop_zip_code') }}, {{ Shopper\Framework\Models\System\Country::find(shopper_setting('shop_country_id'))->name }}</p>
                                <p class="phone"><span class="call us">Need Help?</span> <a href="tel:{{ shopper_setting('shop_phone_number')}}"> Call: {{ shopper_setting('shop_phone_number')}}</a></p>
                                <p class="phone"><span class="call us">Products & Sales</span> <a href="tel:{{ shopper_setting('shop_phone_number')}}"> Call: {{ shopper_setting('shop_phone_number')}}</a></p>
                                </div>
                                <div class="contact-us-btn">
                                    <a href="contact">Contact us</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 mb-md-30px mb-lm-30px">
                            <div class="single-wedge">
                                <h4 class="footer-herading">JOIN OUR NEWSLETTER</h4>
                                <div class="footer-links">
                                    <p>Subscribe to receive inspiration, ideas and news in your inbox.</p>
                                        <!-- News letter area -->
                                    <div id="mc_embed_signup" class="subscribe-form">
                                        <form
                                            id="mc-embedded-subscribe-form"
                                            class="validate"
                                            novalidate=""
                                            target="_blank"
                                            name="mc-embedded-subscribe-form"
                                            method="post"
                                            action="http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef"
                                        >
                                            <div id="mc_embed_signup_scroll" class="mc-form">
                                                <input class="email" type="email" required="" placeholder="Enter your email here.." name="EMAIL" value="" />
                                                <div class="mc-news" aria-hidden="true">
                                                    <input type="text" value="" tabindex="-1" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef" />
                                                </div>
                                                <div class="clear">
                                                    <button id="mc-embedded-subscribe" class="button" type="submit" name="subscribe" value=""><i class="icon-mail"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- News letter area  End -->
                                </div>
                                <h4 class="footer-herading">Follow Us:</h4>
                                <div class="social-info">
                                    <ul class="link-follow">
                                        <li><a class="facebook ion-social-facebook" title="Facebook" href="#"><span>facebook</span></a></li>
                                        <li><a class="twitter ion-social-twitter" title="Twitter" href="#"><span>twitter</span></a></li>
                                        <li><a class="google ion-social-googleplus-outline" title="Google" href="#"><span>google </span></a></li>
                                        <li><a class="youtube ion-social-youtube" title="Youtube" href="#"><span>youtube </span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="single-wedge">
                                <h4 class="footer-herading">CUSTOM LINKS</h4>
                                <div class="footer-links">
                                    <div class="footer-row">
                                        <ul class="align-items-center">
                                            <li><a href="about">About Us</a></li>
                                            <li><a href="#">Delivery Information</a></li>
                                            <li><a href="#">Privacy Policy</a></li>
                                            <li><a href="#">Terms & Conditions</a></li>
                                            <li><a href="contact">Contact Us</a></li>
                                            <li><a href="#">Site Map</a></li>
                                            <li><a href="#">Order History</a></li>
                                        </ul>
                                        <ul class="align-items-center">
                                            <li><a href="#">Brands</a></li>
                                            <li><a href="#">Gift Certificates</a></li>
                                            <li><a href="#">Affiliate</a></li>
                                            <li><a href="#">Specials</a></li>
                                            <li><a href="#">Returns</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="footer-social-icon d-flex">
                                <div class="heading-info">free app:</div>
                                <div class="social-icon">
                                    <ul>
                                        <li class="apple-store">
                                            <a href="#"><i class="ion-social-apple"></i>Apple Store</a>
                                        </li>
                                        <li class="google-play">
                                            <a href="#"><i class="ion-social-android"></i>Google Play</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="footer-paymet-warp d-flex">
                                <div class="heading-info">Payment:</div>
                                <div class="payment-way"><img class="payment-img img-responsive" src="{{asset('frontend/assets/images/icons/payment.png')}}" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-tags">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tag-content">
                                <ul>
                                    <li><a href="#">Online Shopping</a></li>
                                    <li><a href="#">Promotions</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Site Map</a></li>
                                    <li><a href="#">Orders And Returns</a></li>
                                    <li><a href="#">Support</a></li>
                                    <li><a href="#">Contact Us </a></li>
                                    <li><a href="#">Most Populars</a></li>
                                    <li><a href="#">New Arrivals</a></li>
                                    <li><a href="#">Payments</a></li>
                                    <li><a href="#">Special</a></li>
                                    <li><a href="#">Products</a></li>
                                    <li><a href="#">Manufacturers</a></li>
                                    <li><a href="#">Shipping Payments</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="col-md-12 text-center">
                    <p class="copy-text">Copyright © 2022-23 Design & Developed By <a href="http://codezonesit.com/"> Codezones IT Services</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Area End -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-lm-100px mb-sm-30px">
                            <div class="quickview-wrapper">
                                 <!-- slider -->
                                  <div class="gallery-top">
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/8.jpg')}}" alt="">
                                      </div>
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/14.jpg')}}" alt="">
                                      </div>
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/15.jpg')}}" alt="">
                                      </div>
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/11.jpg')}}" alt="">
                                      </div>
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/19.jpg')}}" alt="">
                                      </div>
                                  </div>
                                  <div class=" gallery-thumbs">
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/8.jpg')}}" alt="">
                                      </div>
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/14.jpg')}}" alt="">
                                      </div>
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/15.jpg')}}" alt="">
                                      </div>
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/11.jpg')}}" alt="">
                                      </div>
                                      <div class="single-slide">
                                            <img class="img-responsive m-auto" src="{{asset('frontend/assets/images/product-image/19.jpg')}}" alt="">
                                      </div>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="product-details-content quickview-content">
                                <h2>Originals Kaval Windbr</h2>
                                <p class="reference">Reference:<span> demo_17</span></p>
                                <div class="pro-details-rating-wrap">
                                    <div class="rating-product">
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i>
                                    </div>
                                    <span class="read-review"><a class="reviews" href="#">Read reviews (1)</a></span>
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="old-price not-cut">€18.90</li>
                                    </ul>
                                </div>
                                <p class="quickview-para">Lorem ipsum dolor sit amet, consectetur adipisic elit eiusm tempor incidid ut labore et dolore magna aliqua. Ut enim ad minim venialo quis nostrud exercitation ullamco</p>
                                <div class="pro-details-size-color">
                                    <div class="pro-details-color-wrap">
                                        <span>Color</span>
                                        <div class="pro-details-color-content">
                                            <ul>
                                                <li class="blue"></li>
                                                <li class="maroon active"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-details-quality">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                                    </div>
                                    <div class="pro-details-cart btn-hover">
                                        <a href="#"> + Add To Cart</a>
                                    </div>
                                </div>
                                <div class="pro-details-wish-com">
                                    <div class="pro-details-wishlist">
                                        <a href="wishlist"><i class="ion-android-favorite-outline"></i>Add to wishlist</a>
                                    </div>
                                    <div class="pro-details-compare">
                                        <a href="compare"><i class="ion-ios-shuffle-strong"></i>Add to compare</a>
                                    </div>
                                </div>
                                <div class="pro-details-social-info">
                                    <span>Share</span>
                                    <div class="social-info">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="ion-social-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-social-twitter"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-social-google"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-social-instagram"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
