<?php if($data['success']): ?>

  <h1>Success 🥳</h1>
  <p class="preamble">Vi har skickat en återställningslänk till <span class="keep-together">din e-postadress.</span></p>

<?php else: ?>

  <h1>Återställ lösenord</h1>
  
  <?php if($data['error']): ?>
    <p class="notice--error"><?=$data['message'];?></p>
  <?php endif; ?>
  
  <form action="" method="post">
    <input type="text" required name="email" value="" placeholder="E-post">
    <button type="submit" class="btn">Skicka återställningslänk</button>
  </form>

<?php endif; ?>