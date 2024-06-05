@if (session('message'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif
