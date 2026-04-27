$(document).ready(function() {

   // load the json file using ajax
   $.ajax({
      type: "GET",
      url: "projects.json",
      dataType: "json",
      success: function(data) {

         // build the accordion html by looping through each menu item
         var output = "";
         $.each(data.menuItem, function(i, item) {
            var lockIcon = item.secure ? ' &#x1F512;' : '';
            output += "<h3>" + item.lab + " - " + item.title + lockIcon + "</h3>";
            output += "<div>";
            output += "<p>" + item.desc + "</p>";
            output += "<a href='" + item.href + "'";
            if (item.secure) {
               output += " title='Password required'";
            }
            output += ">Go to " + item.lab + "</a>";
            output += "</div>";
         });

         $("#projectsOutput").html(output);

         // turn it into a jquery ui accordion
         $("#projectsOutput").accordion({
            collapsible: true,
            active: false,
            heightStyle: "content"
         });

         // build the rss preview from the same json
         buildRSS(data);
         
         // build the atom preview from the same json
         buildAtom(data);
      },
      error: function(msg) {
         alert("error loading json: " + msg.status + " " + msg.statusText);
      }
   });

});



// takes the json data and renders RSS preview
function buildRSS(data) {

   var output = "<h2>RSS Feed</h2>";
   output += "<p class='rss-subtext'>RSS Feed preview from JSON</p>";

   $.each(data.menuItem, function(i, item) {
      var lockIcon = item.secure ? ' &#x1F512;' : '';
      output += "<div class='rss-card'>";
      output += "<strong>" + item.lab + ": " + item.title + lockIcon + "</strong>";
      output += "<p>" + item.desc + "</p>";
      output += "<a href='" + item.liveLink + "' target='_blank'>" + item.liveLink + "</a>";
      output += "</div>";
   });

   $("#rssPreview").html(output);
}

// takes the json data and renders Atom preview
function buildAtom(data) {

   var output = "<h2>Atom Feed</h2>";
   output += "<p class='rss-subtext'>Atom Feed preview from JSON</p>";

   $.each(data.menuItem, function(i, item) {
      var lockIcon = item.secure ? ' &#x1F512;' : '';
      output += "<div class='rss-card atom-card'>";
      output += "<strong>" + item.lab + ": " + item.title + lockIcon + "</strong>";
      output += "<p>" + item.desc + "</p>";
      output += "<a href='" + item.liveLink + "' target='_blank'>" + item.liveLink + "</a>";
      output += "</div>";
   });

   $("#atomPreview").html(output);
}