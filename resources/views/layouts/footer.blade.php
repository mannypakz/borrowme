<!-- Main Footer -->
<footer>
  <div class="container">
  	<div class="footer-top">
		<div class="desktop-footer d-none d-sm-none d-md-block d-lg-block">
			<div class="row"> 
				<div class="col mx-1">
					<h4>About BorrowMe</h4>	
					<ul class="footer-menu list-unstyled">
						<li><a href="/pages/about-us">About Us</a></li>
						<li><a href="/pages/how-it-works">How it Works</a></li>
					</ul>
				</div> 
				<div class="col mx-1">
					<h4>Questions</h4>
					<ul class="footer-menu list-unstyled">
						<li><a href="/pages/faqs">FAQs</a></li>
						<li><a href="/pages/contact">Contact Us</a></li>
					</ul>	
				</div> 
				<div class="col mx-1">
					<h4>Legal</h4>
					<ul class="footer-menu list-unstyled">
						<li><a href="/pages/terms-of-use">Terms & Conditions</a></li>
						<li><a href="/pages/privacy-policy">Privacy Policy</a></li>
						<!-- <li><a href="#">Cookie Policy</a></li> -->
					</ul>		
				</div> 
				<div class="col mx-1">
					<h4>Other</h4>	
					<ul class="footer-menu list-unstyled">
						<li><a href="/pages/sitemap">Site Map</a></li>
						<li><a href="/pages/career">Career</a></li>
						<li><a href="/pages/invitation">Invitation</a></li>
					</ul>	
				</div> 
				<div class="col mx-1">
					<h4>Follow BorrowMe</h4>
					<ul class="footer-social list-inline">
						<li class="list-inline-item"><a href="https://www.facebook.com/BorrowMeCOM" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
						<li class="list-inline-item"><a href="https://www.linkedin.com/company/borrowme-com/" target="_blank"><i class="fab fa-linkedin"></i></i></a></li>
						<li class="list-inline-item"><a href="https://instagram.com/borrowme_com" target="_blank"><i class="fab fa-instagram"></i></a></li>
					</ul>	
				</div>
			</div>
        </div> 
		<div class="mobile-footer d-block d-sm-block d-md-none d-lg-none">
			<div class="row">
				<div class="col-12 mb-3">
					<h4 class="accordion">About BorrowMe</h4>	 
					<div class="panel">
                      <ul class="footer-menu list-unstyled">
						<li><a href="/pages/about-us">About Us</a></li>
						<li><a href="/pages/how-it-works">How it Works</a></li>
                      </ul>
                    </div>
				</div>
				<div class="col-12 mb-3">
					<h4 class="accordion">Questions</h4>	 
					<div class="panel">
                      <ul class="footer-menu list-unstyled">
					  	<li><a href="/pages/faqs">FAQs</a></li>
						<li><a href="/pages/contact">Contact Us</a></li>
                      </ul>
                    </div>
				</div>
				<div class="col-12 mb-3">
					<h4 class="accordion">Legal</h4>	 
					<div class="panel">
                      <ul class="footer-menu list-unstyled">
					  	<li><a href="/pages/terms-of-use">Terms & Conditions</a></li>
						<li><a href="/pages/privacy-policy">Privacy Policy</a></li>
                      </ul>
                    </div>
				</div>
				<div class="col-12 mb-3">
					<h4 class="accordion">Other</h4>	 
					<div class="panel">
                      <ul class="footer-menu list-unstyled">
					  	<li><a href="/pages/sitemap">Site Map</a></li>
						<li><a href="/pages/career">Career</a></li>
						<li><a href="/pages/invitation">Invitation</a></li>
                      </ul>
                    </div>
				</div>
			</div>
		</div>
  	</div>
  	<div class="footer-bottom">
  		<div class="text-right">
  	  		<small class="d-none d-sm-none d-md-block d-lg-block">Copyright &copy; {{date('Y')}} Borrow Me. All rights reserved.</small>
  		</div>
		<div class="d-block d-sm-block d-md-none d-lg-none text-center">
			<div class="footer-logo">
				<img src="{{ asset('images/footer-logo.png') }}" alt="Footer Logo" />
			</div>
			<div class="mobile-social-icons">
				<h6>Follow BorrowMe</h6>
				<ul class="footer-social list-inline">
					<li class="list-inline-item"><a href="https://www.facebook.com/BorrowMeCOM" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
					<li class="list-inline-item"><a href="https://www.linkedin.com/company/borrowme-com/" target="_blank"><i class="fab fa-linkedin"></i></i></a></li>
					<li class="list-inline-item"><a href="https://instagram.com/borrowme_com" target="_blank"><i class="fab fa-instagram"></i></a></li>
				</ul>	
			</div>
			<p class="location"><i class="fas fa-globe"></i> Dubai</p>
		</div>
  	</div>
  </div>
</footer>

<style>
 .accordion {
    background: transparent url({{ asset('images/right-arrow.png') }}) no-repeat center right;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 18px;
    /*transition: 0.4s;*/
  }
  .active{
    background: transparent url({{ asset('images/down-arrow.png') }}) no-repeat center right;
  }
  .sidenav .accordion{
	background: transparent url({{ asset('images/arrow-down.png') }}) no-repeat center right!important;
	}
	.sidenav .accordion.active{
	background: transparent url({{ asset('images/arrow-up.png') }}) no-repeat center right!important;
	}
  .panel {
    padding: 0 18px;
    display: none;
    background-color: white;
    overflow: hidden;
  }
  @media only screen and (max-width:767px){
	  .mobile-footer{
		  padding: 0 1rem;
	  }
	  .mobile-footer button{
		border: 0;
    	background: transparent;
	  }
	  .footer-top .mobile-footer h4{
		margin-bottom: 0;
    	padding: 5px 0;
	  }
	  .mobile-social-icons .footer-social li{
		  margin: 0 10px!important;
	  }
  }
</style>

<script src="{{ asset('js/jquery.easing.js') }}" defer="defer"></script>
  
<script>
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if (panel.style.display === "block") {
			panel.style.display = "none";
		} else {
			panel.style.display = "block";
		}
		});
	}
</script>