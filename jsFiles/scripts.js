$(".openbtn").click(function openNav(){
    $("#mySidebar").css("width", "250px");
    $("#main").css("marginRight", "250px");
  
  });
  
  $("#addbtn").click(function openNav2(){
    $("#mySidebar2").css("width", "100%");
    $("#mainc").css("marginRight", "300px");
  
  });
  
  $(".closebtn").click(function closeNav(){
    $("#mySidebar").css("width", "0");
    $("#main").css("marginRight", "0");
  
  });
  $(".closebtn2").click(function closeNav2(){
    $("#mySidebar2").css("width", "0");
    $("#mainc").css("marginRight", "0");
  
  });
  