  <!-- ======= Footer ======= -->
  <footer class="main-footer footer-style-one">
      <div class="widgets-section">
          <div class="auto-container">
              <div class="row">
                  <div class="footer-column col-lg-4 col-sm-6">
                      <div class="footer-widget about-widget wow fadeInLeft">
                          <div class="widget-content">
                              <div class="logo"><a href="{{ route('index') }}"> <img
                                          src="{{ asset('backend/images/app_setup/' . appSetupValue('logo')) }}"
                                          onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/logo-white.png') }}'"></a>
                              </div>
                              <div class="text">
                                  @if (!empty(appSetupValue('about-footer')))
                                      @if (session()->get('pooja_language') == 'English')
                                          {!! appSetupValue('about-footer') !!}
                                      @else
                                      {!! appSetupValue('about-hindi') !!}
                                      @endif
                                  @endif
                              </div>
                          </div>
                      </div>
                  </div>
                  @if (session()->get('pooja_language') == 'English')
                      <div class="footer-column col-lg-3 col-sm-6 mb-0">
                          <div class="footer-widget links-widget wow fadeInLeft" data-wow-delay="200ms">
                              <h4 class="widget-title">Quick Links</h4>
                              <div class="widget-content">
                                  <ul class="user-links">

                                      <li><a href="{{ route('login') }}"><i class="far fa-dot-circle"></i>Login</a></li>
                                      <li><a href="{{ route('pujari-login') }}"><i class="far fa-dot-circle"></i>Pujari Ji
                                              Login</a></li>
                                      <li><a href="{{ route('pujari.register') }}"><i
                                                  class="far fa-dot-circle"></i>Pujari Ji
                                              Register</a></li>
                                      <li><a href="{{ route('puja') }}"><i class="far fa-dot-circle"></i>Puja</a></li>
                                      <li><a href="{{ route('teerth_puja') }}"><i class="far fa-dot-circle"></i>Teerth
                                              Puja</a></li>
                                      @if (appSetupValue('kundali_matching_show'))
                                          <li><a href="{{ route('astrology') }}"><i
                                                      class="far fa-dot-circle"></i>Kundali
                                                  Making
                                                  Service</a></li>
                                      @endif
                                      @if (appSetupValue('more_show'))
                                          <li><a href="{{ route('panchang') }}"><i
                                                      class="far fa-dot-circle"></i>Panchang</a>
                                          </li>
                                          <li><a href="{{ route('daily-horoscope') }}"><i
                                                      class="far fa-dot-circle"></i>Today
                                                  Horoscope</a></li>
                                          <li><a href="{{ route('weekly-horoscope') }}"><i
                                                      class="far fa-dot-circle"></i>Weekly
                                                  Horoscope</a></li>
                                          <li><a href="{{ route('yearly-horoscope') }}"><i
                                                      class="far fa-dot-circle"></i>Yearly
                                                  Horoscope</a></li>
                                      @endif
                                  </ul>
                              </div>
                          </div>
                      </div>
                      <div class="footer-column col-lg-3 col-sm-6">
                          <div class="footer-widget links-widget wow fadeInLeft" data-wow-delay="300ms">
                              <h4 class="widget-title">Policy Info</h4>
                              <div class="widget-content">
                                  <ul class="user-links">
                                      <li><a href="{{ route('about') }}"><i class="far fa-dot-circle"></i>About Us</a>
                                      </li>
                                      <li><a href="{{ route('how-work') }}"><i class="far fa-dot-circle"></i>How We
                                              Work</a></li>
                                      <li><a href="{{ route('privacy') }}"><i class="far fa-dot-circle"></i>Privacy
                                              Policy</a></li>
                                      <li><a href="{{ route('terms') }}"><i class="far fa-dot-circle"></i>Terms of
                                              Conditions</a>
                                      </li>
                                      <li><a href="{{ route('return') }}"><i class="far fa-dot-circle"></i>Cancellation
                                              &
                                              Refund Policy</a></li>
                                      <li><a href="{{ route('blog') }}"><i class="far fa-dot-circle"></i>Blogs</a></li>
                                      <li>
                                          <a href="{{ route('contact_us') }}">
                                              <i class="far fa-dot-circle"></i>Contact Us
                                          </a>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                      <div class="footer-column col-lg-2 col-sm-6">
                          <div class="footer-widget news-widget about-widget wow fadeInLeft" data-wow-delay="400ms">
                              <h4 class="widget-title">Information</h4>
                              <div class="widget-content">
                                  <article class="recent-post">
                                      <div class="inner">
                                          <div class="post-info"><i class="far fa-map-marker-alt"></i>
                                              @if (!empty(appSetupValue('address')))
                                                  {{ appSetupValue('address') }}
                                              @endif
                                          </div>
                                          <div class="post-info"><i class="far fa-phone-volume"></i>
                                              @if (!empty(appSetupValue('contact_number')))
                                                  <a
                                                      href="tel:+91-{{ appSetupValue('contact_number') }}">+91-{{ appSetupValue('contact_number') }}</a>
                                              @endif
                                          </div>
                                          <div class="post-info"><i class="far fa-envelope-open"></i>
                                              @if (!empty(appSetupValue('email')))
                                                  <a
                                                      href="mailto:{{ appSetupValue('email') }}">{{ appSetupValue('email') }}</a>
                                              @endif
                                          </div>
                                      </div>

                                      <ul class="social-icon-two">
                                          @if (!empty(appSetupValue('facebook')))
                                              <li>
                                                  <a href="{{ appSetupValue('facebook') }}" target="_blank"><i
                                                          class="fab fa-facebook"></i></a>
                                              </li>
                                          @endif
                                          @if (!empty(appSetupValue('twitter')))
                                              <li>
                                                  <a href="{{ appSetupValue('twitter') }}" target="_blank"><i
                                                          class="fab fa-twitter"></i></a>
                                              </li>
                                          @endif
                                          @if (!empty(appSetupValue('instagram')))
                                              <li>
                                                  <a href="{{ appSetupValue('instagram') }}" target="_blank"><i
                                                          class="fab fa-instagram"></i></a>
                                              </li>
                                          @endif
                                          @if (!empty(appSetupValue('youtube')))
                                              <li>
                                                  <a href="{{ appSetupValue('youtube') }}" target="_blank"><i
                                                          class="fab fa-youtube"></i></a>
                                              </li>
                                          @endif
                                          @if (!empty(appSetupValue('linkedin')))
                                              <li>
                                                  <a href="{{ appSetupValue('linkedin') }}" target="_blank"><i
                                                          class="fab fa-linkedin-in"></i></a>
                                              </li>
                                          @endif
                                      </ul>
                                  </article>
                              </div>
                          </div>
                      </div>
                  @else
                      <div class="footer-column col-lg-3 col-sm-6 mb-0">
                          <div class="footer-widget links-widget wow fadeInLeft" data-wow-delay="200ms">
                              <h4 class="widget-title">त्वरित लिंक</h4>
                              <div class="widget-content">
                                  <ul class="user-links">
                                      <li><a href="{{ route('login') }}"><i class="far fa-dot-circle"></i>लॉगिन</a>
                                      </li>
                                      <li><a href="{{ route('pujari-login') }}"><i
                                                  class="far fa-dot-circle"></i>पुजारी जी लॉगिन</a></li>
                                      <li><a href="{{ route('pujari.register') }}"><i
                                                  class="far fa-dot-circle"></i>पुजारी जी रजिस्टर</a></li>
                                      <li><a href="{{ route('puja') }}"><i class="far fa-dot-circle"></i>पूजा</a>
                                      </li>
                                      <li><a href="{{ route('teerth_puja') }}"><i class="far fa-dot-circle"></i>तीर्थ
                                              पूजा</a></li>
                                      @if (appSetupValue('kundali_matching_show'))
                                          <li><a href="{{ route('astrology') }}"><i
                                                      class="far fa-dot-circle"></i>कुंडली
                                                  मिलान सेवा</a></li>
                                      @endif
                                      @if (appSetupValue('more_show'))
                                          <li><a href="{{ route('panchang') }}"><i
                                                      class="far fa-dot-circle"></i>पंचांग</a></li>
                                          <li><a href="{{ route('daily-horoscope') }}"><i
                                                      class="far fa-dot-circle"></i>आज का राशिफल</a></li>
                                          <li><a href="{{ route('weekly-horoscope') }}"><i
                                                      class="far fa-dot-circle"></i>साप्ताहिक राशिफल</a></li>
                                          <li><a href="{{ route('yearly-horoscope') }}"><i
                                                      class="far fa-dot-circle"></i>वार्षिक राशिफल</a></li>
                                      @endif
                                  </ul>
                              </div>
                          </div>
                      </div>
                      <div class="footer-column col-lg-3 col-sm-6">
                          <div class="footer-widget links-widget wow fadeInLeft" data-wow-delay="300ms">
                              <h4 class="widget-title">नीति जानकारी</h4>
                              <div class="widget-content">
                                  <ul class="user-links">
                                      <li><a href="{{ route('about') }}"><i class="far fa-dot-circle"></i>हमारे बारे
                                              में</a></li>
                                      <li><a href="{{ route('how-work') }}"><i class="far fa-dot-circle"></i>हम कैसे
                                              काम करते हैं</a></li>
                                      <li><a href="{{ route('privacy') }}"><i class="far fa-dot-circle"></i>गोपनीयता
                                              नीति</a></li>
                                      <li><a href="{{ route('terms') }}"><i class="far fa-dot-circle"></i>नियम और
                                              शर्तें</a></li>
                                      <li><a href="{{ route('return') }}"><i class="far fa-dot-circle"></i>रद्दीकरण
                                              और रिफंड नीति</a></li>
                                      <li><a href="{{ route('blog') }}"><i class="far fa-dot-circle"></i>ब्लॉग्स</a>
                                      </li>
                                      <li>
                                          <a href="{{ route('contact_us') }}">
                                              <i class="far fa-dot-circle"></i>हमसे संपर्क करें
                                          </a>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                      <div class="footer-column col-lg-2 col-sm-6">
                          <div class="footer-widget news-widget about-widget wow fadeInLeft mt-0"
                              data-wow-delay="400ms">
                              <h4 class="widget-title">जानकारी</h4>
                              <div class="widget-content">
                                  <article class="recent-post">
                                      <div class="inner">
                                          <div class="post-info"><i class="far fa-map-marker-alt"></i>
                                              @if (!empty(appSetupValue('address')))
                                                  {{ appSetupValue('address') }}
                                              @endif
                                          </div>
                                          <div class="post-info"><i class="far fa-phone-volume"></i>
                                              @if (!empty(appSetupValue('contact_number')))
                                                  <a
                                                      href="tel:+91-{{ appSetupValue('contact_number') }}">+91-{{ appSetupValue('contact_number') }}</a>
                                              @endif
                                          </div>
                                          <div class="post-info"><i class="far fa-envelope-open"></i>
                                              @if (!empty(appSetupValue('email')))
                                                  <a
                                                      href="mailto:{{ appSetupValue('email') }}">{{ appSetupValue('email') }}</a>
                                              @endif
                                          </div>
                                      </div>

                                      <ul class="social-icon-two">
                                          @if (!empty(appSetupValue('facebook')))
                                              <li>
                                                  <a href="{{ appSetupValue('facebook') }}" target="_blank"><i
                                                          class="fab fa-facebook"></i></a>
                                              </li>
                                          @endif
                                          @if (!empty(appSetupValue('twitter')))
                                              <li>
                                                  <a href="{{ appSetupValue('twitter') }}" target="_blank"><i
                                                          class="fab fa-twitter"></i></a>
                                              </li>
                                          @endif
                                          @if (!empty(appSetupValue('instagram')))
                                              <li>
                                                  <a href="{{ appSetupValue('instagram') }}" target="_blank"><i
                                                          class="fab fa-instagram"></i></a>
                                              </li>
                                          @endif
                                          @if (!empty(appSetupValue('youtube')))
                                              <li>
                                                  <a href="{{ appSetupValue('youtube') }}" target="_blank"><i
                                                          class="fab fa-youtube"></i></a>
                                              </li>
                                          @endif
                                          @if (!empty(appSetupValue('linkedin')))
                                              <li>
                                                  <a href="{{ appSetupValue('linkedin') }}" target="_blank"><i
                                                          class="fab fa-linkedin-in"></i></a>
                                              </li>
                                          @endif
                                      </ul>
                                  </article>
                              </div>
                          </div>
                      </div>
                  @endif
              </div>
          </div>
      </div>
      <div class="footer-bottom wow slideInUp">
          <div class="auto-container">
              <div class="inner-container">
                  <div class="copyright-text">© <?php echo date("Y"); ?>&nbsp;<a
                          href="https://pujariji.com//" target="_blank">{{ env('APP_NAME') }} </a> |  All Right Reserved.</div>
                  <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-arrow-up"></span>
                  </div>
              </div>
          </div>
      </div>
  </footer>

  @if (!empty(appSetupValue('whats_app_number')))
      {{-- <a href="https://wa.me/+91{{ appSetupValue('whats_app_number') }}?text=" class="float" target="_blank">
          <i class="fab fa-whatsapp my-float"></i></a> --}}
  @endif
