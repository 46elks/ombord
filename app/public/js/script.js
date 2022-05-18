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


// Handle all form requests
var formHandler = {

  form: null,
  formData: {},
  callback: null,

  init: function(form, callback = null){
    var me = this;
    me.callback = callback;
    me.bindEvents(form);
  },

  bindEvents: function(form) {
    var me = this;
    app.log("Bind form events");

    // Add event listeners on form submit
    form.addEventListener("submit", function(e){
      app.log("Form submitted");
      e.preventDefault();
      me.prepareForm(e);
    });
  },

  prepareForm: function(e){
    app.log("Form being prepared");
    var me            = this;
    var searchParams  = new URLSearchParams(new FormData(e.target));
    me.form = e;

    searchParams.forEach(function(value, key) {
      me.formData[key] = value;
    });

    apiRequest.send(e.target.method, me.formData, function(data){
      if(typeof me.callback == 'function') me.callback(data);
    });
  }
}

// Helper for making API requests
var apiRequest = {

  send:function(method,data,callback=null){
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
}


// Enable dragging of tasks to change order in a list
$( function() {
  $( ".js-tasks-list" ).sortable({
    stop: storeTasksOrder,
    axis: "y",
    handle: ".js-task-handle",
    cursor: "grabbing"
  });
} );

function storeTasksOrder(e){
  app.log("Sorting tasks..");
  let listId = e.target.dataset.id;
  let orderOfAllTasksArray = $(e.target).sortable('toArray', {attribute: "data-id"});
  var orderOfAllTasks = orderOfAllTasksArray.join(',');
  let data = {
    _action: "update_tasks_order",
    tasks_order: orderOfAllTasks,
    list_id: listId
  }
  apiRequest.send("PATCH",data,function(data){
    app.log("Tasks order updated");
    app.log(data);
  });
}