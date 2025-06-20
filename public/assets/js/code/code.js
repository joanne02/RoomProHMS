$(function(){
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");

  
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete this?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      // Perform delete via AJAX or redirect manually after second alert
                      Swal.fire({
                          title: 'Deleted!',
                          text: 'Your file has been deleted.',
                          icon: 'success',
                      }).then(() => {
                          // Now redirect after user clicks "OK" on the success alert
                          window.location.href = link;
                      });
                  }
                  }) 
    });

  });

