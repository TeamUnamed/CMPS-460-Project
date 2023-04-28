
$.get("base/navbar.html", function(data){
    $("div.navbar").replaceWith(data);
});