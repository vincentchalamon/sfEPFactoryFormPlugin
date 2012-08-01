function gup(name, defaut)
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.href);
  if(results == null) return typeof(defaut) == "undefined" ? "" : defaut;
  else return results[1];
}

/*---------------------------------------------------------
  Configuration
---------------------------------------------------------*/

// Set this to the server side language you wish to use.
var lang = 'php'; // options: lasso, php, py

// Set this to the directory you wish to manage.
//var fileRoot = '/uploads/';
var fileRoot = gup("path", "/uploads/");

// Show image previews in grid views?
var showThumbs = true;

// Add http to return url
var addHttp = true;
