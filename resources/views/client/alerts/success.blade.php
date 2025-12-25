 @if (session()->has('success'))
 <script>
     window.onload = () => {
         Swal.fire({
             position: "top",
             toast: true,
             showConfirmButton: false,
             timer: 2000,
             timerProgressBar: true,
             icon: "success",
             title: "{{session()->get('success')}}"
         });
     }
 </script>
 @endif