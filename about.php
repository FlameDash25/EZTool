 <!-- Masthead-->
 <header class="masthead">
     <div class="container h-100">
         <div class="row h-100 align-items-center justify-content-center text-center">
             <div class="col-lg-10  mb-4 py-5" style="background: #0000002e;">
                 <h1 class="text-uppercase text-white font-weight-bold">KNOW US</h1>
                 <hr class="divider my-4" />
             </div>

         </div>
     </div>
 </header>

 <section class="page-section">
     <div class="container">
         <?= html_entity_decode($_SESSION['setting_about_content']) ?>
         <p><i class="fas fa-mobile-alt"></i>  Contact : <a href="tel:<?= html_entity_decode($_SESSION['setting_contact']) ?>"><?= html_entity_decode($_SESSION['setting_contact']) ?></a></p>
         <p><i class="fas fa-at"></i> Email : <a href="mailto:<?= html_entity_decode($_SESSION['setting_email']) ?>"><?= html_entity_decode($_SESSION['setting_email']) ?></a></p>
     </div>
 </section>