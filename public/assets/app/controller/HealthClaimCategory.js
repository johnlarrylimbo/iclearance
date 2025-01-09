functionalfoodsApp.controller('HealthClaimCategory', function ($scope, $http, $timeout) {

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //hide html5 default messages every time.
  $('input, select, textarea').on("invalid", function(e) {
    e.preventDefault();
  });

  $('input, select, textarea').on("valid", function(e) {
      e.preventDefault();
  });
  //end hide html5 default message

  
  $('.add-health-claim-category').on('click', function () {
    $('#categoryModal').modal('show');
    console.log('success');
  });



  

});
