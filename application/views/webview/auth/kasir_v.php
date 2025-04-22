 <!-- main-area -->
 <main class="fix">
     <!-- about-area -->
     <section class="login__area-one">
         <div class="container">
             <div class="text-center mb-55">
                 <h1 class="text-48-bold">Welcome back!</h1>
             </div>
             <div class="box-form-login">
                 <div class="head-login">
                     <h3>Sign in</h3>
                     <p>Sign in with your username and password</p>
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
                         <form id="login_form" onsubmit="login(event)">
                             <div class="form-group">
                                 <input type="text" class="form-control account" placeholder="Username" id="username" name="username" />
                             </div>
                             <div class="form-group">
                                 <input type="password" class="form-control" placeholder="Password" id="password" name="password" />
                                 <span class="view-password" onclick="changePassword()" style="cursor: pointer;"></span>
                             </div>
                             <div class="box-forgot-pass">
                                 <label>
                                     <input type="checkbox" class="cb-remember" value="1" /> Remember me
                                 </label>
                                 <a href="forgot-password.html">Forgot Password ?</a>
                             </div>
                             <div class="form-group">
                                 <!-- <input type="submit" onclick="login()" class="btn btn-login" value="Sign In" /> -->
                                 <input type="submit" class="btn btn-login" value="Sign In" />
                             </div>
                         </form>
                         <!-- <p>Don’t have an account? <a href="<?= base_url('auth/register') ?>" class="link-bold">Sign up</a> now</p> -->
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- about-area-end -->
 </main>
 <!-- main-area-end -->