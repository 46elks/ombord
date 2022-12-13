<?php if($data['success']): ?>

  <h1 style="margin-bottom:0;">Success 🥳</h1>
  <p class="preamble" style="margin-bottom: 3rem;">Ditt lösenord är nu återställt.</p>
  <a href="/login" class="btn btn--lg">Logga in</a>

<?php else: ?>

<h1>Återställ lösenord</h1>
<p class="preamble">Ange ditt nya lösenord.</p>

<?php if($data['error']): ?>
  <p class="notice--error"><?=$data['message'];?></p>
<?php endif; ?>

<form action="" method="post">
  <input type="password" required name="password" value="" placeholder="Ditt nya lösenord">
  <input type="password" required name="password_again" value="" placeholder="Upprepa ditt nya lösenord">
  <input type="hidden" name="token" value="<?=htmlspecialchars($data['token']);?>">
  <button type="submit" class="btn">Uppdatera</button>
</form>

<?php endif; ?>