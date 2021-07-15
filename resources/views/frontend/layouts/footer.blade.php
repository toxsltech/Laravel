<footer id="footer-main" class="footer">
  <div class="footer-1">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="footer-widget">
            <a href="{{url('our-mission')}}"><h3 class="footer-widget-title">Our mission</h3></a>
            <p class="">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type</p>
          </div>

        </div>
        <div class="col-md-3 offset-md-1 mb-4 mb-md-0">
          <div class="footer-widget">
            <h3 class="footer-widget-title">Contact</h3>
            <p class="mb-3"><a href="mailto:info@aery.com"><i class="fal fa-envelope-open-text mr-2"></i> aery.travel@gmail.com</a></p>
          </div>
        </div>
        <div class="col-md-3 offset-md-1 mb-4 mb-md-0">
          <div class="footer-widget">
            <h3 class="footer-widget-title">Follow us</h3>
            <ul class="footer-social d-flex align-items-center flex-wrap">
              <li>
                <a href="#0">
                  <i class="fab fa-pinterest-p"></i>
                </a>
              </li>
              <li>
                <a href="#0">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
              <li>
                <a href="#0">
                  <i class="fab fa-youtube"></i>
                </a>
              </li>
              <li>
                <a href="#0">
                  <i class="fab fa-twitter"></i>
                </a>
              </li>
              <li>
                <a href="#0">
                  <i class="fab fa-instagram"></i>
                </a>
              </li>
            </ul>
          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="footer-2">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 my-3 my-md-0">
          <div class="footer-widget">
            <div class="styled-select" id="lang-selector">
              <select class="custom-select">
                <option value="English" selected="">English</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="footer-widget">
            <ul class="footer-nav d-flex align-items-center justify-content-center justify-content-lg-end">
              <li><a href="{{url('privacy-policy')}}">Privacy Policy</a></li>
              <li><a href="{{url('term-condition')}}">Terms & Conditions</a></li>
              <li><a href="{{url('contact-us')}}">Contact-Us</a></li>
              <li><p class="text-center text-md-left">© Aery 2020</p></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

</footer>

<script src="{{ asset('public/frontend/js/jquery-3.5.1.slim.min.js') }}"></script>

<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>    

<script src="{{ asset('public/frontend/js/popper.min.js') }}"></script>

<script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('public/frontend/js/owl.carousel.min.js') }}"></script>

<script src="{{ asset('public/frontend/js/wow.min.js') }}"></script>

<script src="{{ asset('public/frontend/js/custom.js') }}"></script>

<script src="{{ asset('public/assets/js/toastr.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" type="text/javascript"></script>
<script>
    jQuery(function($){
       $(document).on('blur', '.search_bar', function(e){
          $(this).closest('form').submit()
      })     
   })

</script>
