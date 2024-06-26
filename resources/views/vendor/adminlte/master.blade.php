<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @if (session('exito'))
    <div class="alert alert-success">
        {{ session('exito') }}
    </div>
    @endif
    @if($errors->has('general'))
        <div class="alert alert-danger">
            {{ $errors->first('general') }}
            @if(isset($errors->changes))
                <pre>{{ print_r($errors->changes, true) }}</pre>
            @endif
        </div>
    @endif
    @include('partials.notifications')
<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

        @if(config('adminlte.google_fonts.allowed', true))
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @endif
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    <style>
        h1 {
                font-weight: bold;
                font-style: italic;
            }
    </style>
    

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @endif

</head>

<body class="@yield('classes_body')" @yield('body_data')>
    <style>
        table {
            font-size: 12px; /* Cambia el valor según tus preferencias */
        }
        .btn-flat.btn-primary {
        background-color: #117d65;
        /* Puedes agregar otros estilos si es necesario */
    }
    </style>
    {{-- Body Content --}}
    
    @yield('body')

    {{-- Base Scripts --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    <div class="modal fade" id="editarPerfilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <form method="POST" action="{{ route('perfil.actualizar') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
    
                        <div class="form-group">
                            <label for="image">Foto:</label>
                            <input type="file" name="image" id="image" class="form-control-file">
                        </div>
    
                        <div class="form-group">
                            <label for="cambiar-contrasena">Cambiar contraseña</label>
                            <input type="checkbox" name="cambiar-contrasena" id="cambiar-contrasena">
                        </div>
    
                        <div class="form-group d-none" id="contrasena-form">
                            <label for="password">Contraseña Actual</label>
                            <input type="password" name="password_actual" class="form-control">
                            @error('password_actual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <div class="form-group d-none" id="nueva-contrasena-form">
                            <label for="password">Nueva contraseña</label>
                            <input type="password" name="password_nueva" class="form-control">
                        </div>
    
                        <div class="form-group d-none" id="confirmar-contrasena-form">
                            <label for="password_confirmation">Confirmar nueva contraseña</label>
                            <input type="password" name="password_nueva_confirmation" class="form-control">
                        </div>
    
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
    
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Mostrar u ocultar el campo de contraseña y confirmación según el estado del checkbox
        const checkbox = document.getElementById('cambiar-contrasena');
        const contrasenaForm = document.getElementById('contrasena-form');
        const nuevaContrasenaForm = document.getElementById('nueva-contrasena-form');
        const confirmarContrasenaForm = document.getElementById('confirmar-contrasena-form');
    
        checkbox.addEventListener('change', function() {
            contrasenaForm.classList.toggle('d-none', !checkbox.checked);
            nuevaContrasenaForm.classList.toggle('d-none', !checkbox.checked);
            confirmarContrasenaForm.classList.toggle('d-none', !checkbox.checked);
        });
    
        // Abrir el modal cuando se hace clic en el enlace
        const editarPerfilLink = document.getElementById('editarPerfilLink');
        editarPerfilLink.addEventListener('click', function(event) {
            event.preventDefault(); // Evitar la navegación normal
            $('#editarPerfilModal').modal('show'); // Mostrar el modal
        });
    </script>
    
    {{-- Custom Scripts --}}
    @yield('adminlte_js')
    

</body>

</html>
