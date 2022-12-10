

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
                                        @if(!blank(shopper_setting('shop_facebook_link')))
                                            <li><a class="facebook ion-social-facebook" title="Facebook" href="{{shopper_setting('shop_facebook_link')}}"><span>facebook</span></a></li>
                                        @endif
                                        @if(!blank(shopper_setting('shop_twitter_link')))
                                            <li><a class="twitter ion-social-twitter" title="Twitter" href="{{shopper_setting('shop_twitter_link')}}"><span>twitter</span></a></li>
                                        @endif
                                        @if(!blank(shopper_setting('shop_instagram_link')))
                                            <li><a class="instagram ion-social-instagram-outline" title="Instagram" href="{{shopper_setting('shop_instagram_link')}}"><span>instagram </span></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="single-wedge">
                                <h4 class="footer-herading">CUSTOM LINKS</h4>
                                <div class="footer-links">
                                    <div class="footer-row">
                                        {!! $customMenu()->footer() !!}
                                        {!! $customMenu()->footer(true) !!}
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
                            {{-- Application Links --}}
                            {{-- <div class="footer-social-icon d-flex">
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
                            </div> --}}
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
                                {!! $customMenu()->footer_horizontal() !!}
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
