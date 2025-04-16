 <!-- main-area -->
 <main class="fix">
     <!-- about-area -->
     <section class="register__area-one">
         <div class="container">
             <div class="text-center mb-55">
                 <h1 class="text-48-bold">Create An Account</h1>
             </div>
             <div class="box-form-login">
                 <div class="head-login">
                     <h3>Register</h3>
                     <p>Create an account today and start using our platform</p>
                     <!-- <div class="box-login-with">
                         <div class="form-group">
                             <a href="#" class="btn btn-login-social">
                                 <img src="<?= base_url() ?>assets/img/login/google.svg" />
                                 Sign In With Google
                             </a>
                         </div>
                         <div class="form-group">
                             <a href="#" class="btn btn-login-social">
                                 <img src="<?= base_url() ?>assets/img/login/apple.png" />
                                 Sign In With Apple Id
                             </a>
                         </div>
                     </div>
                     <div class="text-or"><span>or</span></div> -->
                     <div class="form-login">
                         <form id="register_form" method="post">
                             <div class="form-group">
                                 <input type="text" class="form-control account" placeholder="Your Name" id="nama" name="nama" />
                             </div>
                             <div class="form-group">
                                 <input type="text" class="form-control email-address" placeholder="Email Address" id="email" name="email" />
                             </div>
                             <!-- <div class="form-group">
                                 <input type="text" class="form-control account" placeholder="Username" />
                             </div> -->
                             <div class="form-group">
                                 <input type="password" class="form-control" placeholder="Password" id="password1" name="password1" />
                                 <span class="view-password"></span>
                             </div>
                             <div class="form-group">
                                 <input type="password" class="form-control" placeholder="Confirm Password" id="password2" name="password2" />
                                 <span class="view-password"></span>
                             </div>
                             <div class="g-recaptcha" data-sitekey="6LdrlXUqAAAAAH2b5HCyPARILJdKDA9a5_scWnx_" style="margin-bottom:10px"></div>

                             <div class="box-forgot-pass">
                                 <label>
                                     <input type="checkbox" class="cb-remember" value="1" name="termandconds" id="termandconds" /> <span>I have read and agree to the Terms & Conditions and the Privacy Policy of this website.</span>
                                 </label>
                             </div>

                         </form>
                         <div class="form-group">
                             <input type="submit" onclick="register()" class="btn btn-login" value="Sign up now" />
                         </div>
                         <p>Already have an account? <a href="login.html" class="link-bold">Sign In</a> now</p>
                         <p>You are Cashier? <a href="<?= base_url('auth/cashier') ?>" class="link-bold">Login </a> Here</p>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- about-area-end -->
 </main>
 <!-- main-area-end -->