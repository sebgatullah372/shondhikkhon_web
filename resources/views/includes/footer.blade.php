<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 offset-1">
                <div class="mb-0">
                    <h3 class="footer-heading mb-4">{{$siteSettings->tagline}}</h3>
                    <!-- <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                      Saepe pariatur reprehenderit vero atque, consequatur id
                      ratione, et non dignissimos culpa? Ut veritatis, quos illum
                      totam quis blanditiis, minima minus odio!
                    </p> -->
                </div>
            </div>


            <div class="col-lg-5 offset-1 mb-0 mb-lg-0">
                <div>
                    <span class="footer-heading mb-0">Follow Us on</span>
                    <a href="{{$contactInformation->facebook_link}}" class="pl-4 pr-3"
                    ><span class="icon-facebook"></span
                        ></a>
                    <a href="{{$contactInformation->twitter_link}}" class="pl-3 pr-3"
                    ><span class="icon-twitter"></span
                        ></a>
                    <a href="{{$contactInformation->instagram_link}}" class="pl-3 pr-3"
                    ><span class="icon-instagram"></span
                        ></a>
                </div>
            </div>
        </div>
        <div class="row pt-2 mt-2 text-center">
            <div class="col-md-12">
                <p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;
                    <script
                        data-cfasync="false"
                        src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"
                    ></script>
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    All rights reserved by
                    <a href="#" target="_blank">{{$siteSettings->company_name}}</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
            </div>
        </div>
    </div>
</footer>
