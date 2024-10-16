<template>
    <!--============================
        FOOTER START
    =============================-->
    <footer class="mt_120 xs_mt_100 pt_75" style="background: url(/assets/images/footer_bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <ul class="footer_top">
                        <li>
                            <div class="icon">
                                <img src="/assets/images/call_icon_blue.svg" alt="Call" class="img-fluid">
                            </div>
                            <div class="text">
                                <span>Call us</span>
                                <a href="calto:1234567890">+112 (789) 568 25</a>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <img src="/assets/images/mail_icon_blue.svg" alt="Mail" class="img-fluid">
                            </div>
                            <div class="text">
                                <span>Send Email</span>
                                <a href="mailto:example@gmail.com">example@gmail.com</a>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <img src="/assets/images/location_icon_blue.svg" alt="Location" class="img-fluid">
                            </div>
                            <div class="text">
                                <span>Our Address</span>
                                <p>6391 Elgin St. Celina </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-md-6 col-lg-3 col-xl-3 wow fadeInUp">
                    <div class="footer_info">
                        <a href="index-2.html" class="footer_logo">
                            <img src="/assets/images/custom/logo.jpeg" alt="Handy home service" class="img-fluid">
                        </a>
                        <ul class="footer_social d-flex flex-wrap mt-4">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3 col-xl-2 wow fadeInUp">
                    <div class="footer_link">
                        <h3>Services</h3>
                        <ul>
                            <li><a href="#">Plumbing</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-2 col-xl-2 wow fadeInUp">
                    <div class="footer_link footer_link_padding">
                        <h3>Quick links</h3>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_copyright">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer_copyright_text d-flex flex-wrap">
                            <p>© {{ appName }} {{ new Date().getFullYear() }}. All Rights Reserved.</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="#">Privacy Policy </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--============================
        FOOTER END
    =============================-->
</template>

<script>
export default {
  data() {
    return {
      appName: process.env.APP_NAME,
    }
  },
}
</script>