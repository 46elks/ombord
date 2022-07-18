function renderUser(data, template, parentElement, callback = null){
  app.log("Render user");
  app.log(data);
  
  let userElement = template.content.cloneNode(true);
  userElement = setUserData(data, userElement);

  // Append user to DOM
  parentElement.prepend(userElement);
  userElement = document.getElementById("user-"+data.id);
  
  if(callback !== null) callback(userElement);

}

function setUserData(data, element){

  app.log("Set user data in DOM");
  app.log(data);
  app.log(element);

  if(!data) return false;

  if (!data.id) data.id = data.user_id;

  if(!element) element = document.getElementById('user-'+data.id);
  
  if(!element) return element;

  let image = element.querySelector(".js-user-image");
  let name = element.querySelector(".js-user-name");
  let title = element.querySelector(".js-user-title");
  let desc = element.querySelector(".js-user-description");
  let phone = element.querySelector(".js-user-phone");
  let email = element.querySelector(".js-user-email");

  element.id = "user-"+data.id;

  if(image && data.img) image.src = data.img;
  if(name && data.firstname && data.lastname) name.innerHTML = data.firstname+" "+data.lastname;
  if(title && data.title) title.innerHTML = data.title;
  if(desc && data.description) desc.innerHTML = data.description;
  if(phone && data.phone_work) phone.innerHTML = data.phone_work;
  if(email && data.email) email.innerHTML = data.email;

  return element;

}