
$.get("http://localhost/SQLProject/navbar.html", function(data){
    $("div.navbar").replaceWith(data);
});