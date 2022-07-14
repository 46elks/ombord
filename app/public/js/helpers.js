var app = {
  debug: false,
  apiBaseURL: null,

  init: function(){
    var me = this;
    me.log("app init");

    // Set base url
    let url = window.location;
    me.apiBaseURL = url.protocol+"//"+url.host+"/form-submit";
    app.log(me.apiBaseURL);
  },

  log: function(msg){
    if(this.debug) console.log(msg);
  }
}

app.init();

// Handler for submitting forms
function submitForm(form, callback = null){
  app.log("Submit form");

  // Parse data in form
  let searchParams  = new URLSearchParams(new FormData(form));
  let formData = {};
  
  searchParams.forEach(function(value, key) {
    formData[key] = value;
  });

  // Send API request
  apiPost(formData, function(data){
    if(typeof callback == 'function') callback(data);
  });

}

// Handler making API requests
function apiPost(data, callback = null){
  app.log("Send post request to API");
  app.log(data);
  method = "POST";

  let xhr = new XMLHttpRequest();
  xhr.open(method, app.apiBaseURL, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(JSON.stringify(data));
  app.log("API request sent");

  // This will be called after the response is received
  xhr.onload = function() {
    if (xhr.status != 200) {
      let errorMsg = `Error ${xhr.status} : ${xhr.statusText} \n${xhr.responseText}`;
      app.log(errorMsg);
      alert(errorMsg);
    } else { // show the result
      app.log("API reponse recieved");
      
      if(typeof callback == 'function') {
        app.log(xhr.responseText);
        let responseText = JSON.parse(xhr.responseText);

        if(typeof responseText === "object" && responseText !== null){
          callback(Object.assign(responseText, data));
        } else if(responseText !== null || responseText !== 'undefined'){
          callback(Object.assign({responseText:responseText}, data));
        } else {
          callback(data);
        }
      }
    }
  };

  xhr.onerror = function(e) {
    console.log("Request failed");
    console.log(e);
  };
}

// ===========
// Close modal 
// ===========
function closeModal(modal_id){
  let modal = document.getElementById(modal_id);
  if(modal) modal.classList.add('hidden');
}

// ==========
// Open modal 
// ==========
function openModal(modal_id){
  let modal = document.getElementById(modal_id);
  if(modal) modal.classList.remove('hidden');
}

// ======================================
// Refresh content inside the trix editor
// ======================================
function trixRefresh(trix, content){

  if(!trix) return false;

  // Clear any previous contents in the editor
  let textDoc = trix.editor.getDocument().toString();
  if(textDoc){
    trix.editor.setSelectedRange([0, textDoc.length])
    trix.editor.deleteInDirection("forward")
  }

  // Add content to the editor
  trix.editor.insertHTML(content);

}