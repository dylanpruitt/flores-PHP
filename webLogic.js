function openTab( event, id ) {
    // Get all elements with class="tabContent" and hide them
    tabContent = document.getElementsByClassName( "tabContent" );
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }

    // Get all elements with class="tabLinks" and remove the class "active"
    tabLinks = document.getElementsByClassName( "tabLinks" );
    for (i = 0; i < tabLinks.length; i++) {
        tabLinks[i].className = tabLinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById( id ).style.display = "block";
    event.currentTarget.className += " active";
}

function post( file, map ) {
   var form = document.createElement("form");
   form.setAttribute( "method", "post");
   form.setAttribute( "action",  file );

   for (var key in map) {
       var hiddenField = document.createElement( "input" );
       hiddenField.setAttribute( "type", "hidden");
       hiddenField.setAttribute( "name",  key );
       hiddenField.setAttribute( "value", map[ key ]);

      form.appendChild( hiddenField );
    }
    document.body.appendChild( form );
    form.submit();
}