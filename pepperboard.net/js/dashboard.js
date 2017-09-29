$(document).ready(function () {
  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();      
    });

     $('.dropdown-toggle').dropdown();

    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  });  

  $('[data-toggle="tooltip"]').tooltip();   

  $('input[type=checkbox]').change(function() {
    if($(this).prop('checked'))
      $("#"+$(this).attr('id')+"-tick").val('1');
    else $("#"+$(this).attr('id')+"-tick").val('0');
    // console.log($(this).prop('checked'));
    console.log($(this).attr('id'));
  });

  $('#chk').change(function() {
    alert($(this).prop('checked'))
    if($(this).prop('checked'))
      $("#status").val("1");
    else $("#status").val("0");
})

  $("#success-alert").fadeTo(3000, 2500).slideUp(5000, function(){
        $("#success-alert").slideUp(2500);
  });

  // $("#filters").change(function(){
  //   // alert($(this).val());

  //   $.get("./dashboard/filter",
  //   {
  //       filter: $(this).val()
  //   },
  //   function(data, status){
  //       alert("Data: " + data + "\nStatus: " + status);
  //   });

  // })
});