<?php $people = $data; ?>

<section id="header">
  <header class="pos-rel">
    <h2>Dina kollegor</h2>
    <div class="list__nav">
      <ul class="inline-list">
        <?php if(is_admin()): ?>
        <li><a href="/new-user">+ Ny älg</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </header>
  <p class="preamble">Det här är dina nya kollegor som du ska lära känna, vi finns alla här för frågor - Inga frågor är för små! Vi vill att du ska trivas hos oss.</p>

</section>

<section id="contacts" class="contact__list">
  <?php foreach ($people as $person) :?>
    <?php ui__view_module("users", "contact-card.php", $person);?>
  <?php endforeach;?>
</section>

<!-- <section id="add-new-person" class="">
  <h2>Har det börjat en ny kollega?</h2>
  <p>Här kan du lägga till din nya kollegas kontaktinformation, så att alla vi andra kan komma i kontakt med vår nya kollega.</p>
  <a href="/add-new-person" class="btn">Lägg till ny kollega</a>
  <form method="post" action="" id="form-add-user">
    <input type="text" name="firstname" class="new_person" placeholder="Kollegans förnamn">
    <input type="text" name="lastname" class="new_person" placeholder="Kollegans efternamn">
    <input type="text" name="email" class="new_person" placeholder="E-postadress">
    <input type="password" name="password" class="new_person" placeholder="Lösenord">
    <input type="hidden" name="_action" value="add_user">
    <button type="submit">Lägg till ny kollega</button>
  </form>
  <p class="form-message"></p>

</section>

<template id="new-user-template">
  <?php ui__view_module("users", "contact-card.php", []);?>
</template> -->


<!-- <script src="/js/users.js"></script>

<script>

  // Find form for adding new users
  let formAddUser = document.getElementById("form-add-user");
  if(formAddUser){

    formHandler.init(formAddUser,function(data){
      document.querySelector('.form-message').innerHTML = "Användaren skapad";
      formAddUser.firstname.value  = "";
      formAddUser.lastname.value  = "";
      formAddUser.email.value  = "";
      formAddUser.password.value = "";

      let userTemplate = document.getElementById("new-user-template");
      let parentElement = document.getElementById("contacts");

      // Render new user to DOM
      renderUser(data, userTemplate, parentElement, function(data){

      });
    });
  }

</script> -->