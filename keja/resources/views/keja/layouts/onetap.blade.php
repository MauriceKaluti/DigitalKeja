<form method="POST" action="#">
   @csrf
   <div class="row">
      <div class="col-md-6 mb-3">
         <div class="form-group">
            <label class="text-site w-100">
               <div class="float-start">Username</div>
               <div class="spinner-border text-warning float-end username_loading" role="status">
                  <span class="visually-hidden">Loading...</span>
               </div>
            </label>
            <input id="username" type="text" name="username" class="form-control" placeholder="Use Your Phone No/Email/Username" required>
            <span id="username-error"></span>
         </div>
      </div>
      <div class="col-md-6 mb-3">
         <div class="form-group">
            <label class="text-site w-100">
               <div class="float-start">Enter PIN</div>
            </label>
            <input type="number" placeholder="E.g 4321" name="password" class="form-control" required>
         </div>
      </div>
   </div>
   <div class="accordion mb-3 keja-round" id="appToggleSlideOneTap">
      <div class="accordion-item">
         <h2 class="accordion-header" id="appToggleSlideOneTapHdr">
            <button class="accordion-button shadow-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#appSlideOneTap" aria-expanded="false" aria-controls="appSlideOneTap"> <i class="fa fa-user-plus me-2"></i> Create New Account?
            </button>
         </h2>
         <div id="appSlideOneTap" class="accordion-collapse collapse" aria-labelledby="appToggleSlideOneTapHdr" data-bs-parent="#appToggleSlideOneTap">
            <div class="accordion-body px-2 keja-bg">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="text-site keja-bold mb-1">Enter Fullname</label>
                        <input type="text" name="name" placeholder="E.g Juma Kamau" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="text-site keja-bold mb-1">Phone Number</label>
                        <input type="text" name="phone" placeholder="E.g 0712345678" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="text-site keja-bold mb-1">Email Address(Optional)</label>
                        <input id="email" type="text" name="email" placeholder="E.g juma@gmail.com" class="form-control">
                        <span id="email-error"></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <button id="expressLoginBtn" onClick="this.form.submit(); this.disabled=true; this.value='Sending…';" type="submit" class="btn btn-primary w-100">Login Express</button>
</form> 