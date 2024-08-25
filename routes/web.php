<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardDocenteController;
use App\Http\Controllers\DashboardSecretarioController;
use App\Http\Controllers\DashboardSecretarioEpsuController;
use App\Http\Controllers\DashboardAlumnoController;
use App\Http\Controllers\DashboardPostulanteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\ParaleloController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\SecretarioController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MaestriaController;
use App\Http\Controllers\AsignaturaDocenteController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\CohorteController;
use App\Http\Controllers\CohorteDocenteController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\NotasAsignaturaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostulanteController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\PerfilAlumnoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {  return redirect()->route('login');});

Auth::routes();

Route::post('/guardar-cambios', [DocenteController::class, 'guardarCambios'])->name('guardarCambios');

Route::get('/actualizar_perfil', [PerfilAlumnoController::class, 'edit'])->name('edit_datosAlumnos');
Route::post('/actualizar_perfil/procesar', [PerfilAlumnoController::class, 'update'])->name('update_datosAlumnos');

Route::get('/dashboard/admin', [DashboardAdminController::class, 'index'])->middleware('can:dashboard_admin')->name('dashboard_admin');

Route::get('/dashboard/docente', [DashboardDocenteController::class, 'index'])->middleware('can:dashboard_docente')->name('dashboard_docente');

Route::get('/dashboard/secretario', [DashboardSecretarioController::class, 'index'])->middleware('can:dashboard_secretario')->name('dashboard_secretario');
Route::get('/dashboard/secretario/epsu', [DashboardSecretarioEpsuController::class, 'index'])->middleware('can:epsu_dashboard')->name('dashboard_secretario_epsu');
Route::post('/postulantes/{dni}/convertir', [PostulanteController::class, 'convertirEnEstudiante'])->middleware('can:dashboard_secretario')->name('postulantes.convertir');

Route::get('/dashboard/alumno', [DashboardAlumnoController::class, 'index'])->middleware('can:dashboard_alumno')->name('dashboard_alumno');

Route::get('/dashboard/postulante', [DashboardPostulanteController::class, 'index'])->middleware('can:dashboard_postulante')->name('dashboard_postulante');
Route::post('postulante/store', [DashboardPostulanteController::class, 'store'])->middleware('can:dashboard_postulante')->name('dashboard_postulante.store');
Route::get('postulantes/{dni}/carta-aceptacion', [DashboardPostulanteController::class, 'carta_aceptacionPdf'])->middleware('can:dashboard_postulante')->name('postulantes.carta_aceptacion');
// Crud usuarios
Route::resource('usuarios', UsuarioController::class)->middleware('can:dashboard_admin')->names([
    'index' => 'usuarios.index',
    'create' => 'usuarios.create',
    'store' => 'usuarios.store',
    'show' => 'usuarios.show',
    'edit' => 'usuarios.edit',
    'update' => 'usuarios.update',
    'destroy' => 'usuarios.destroy'
]);
Route::put('/usuarios/{usuario}/disable', [UsuarioController::class, 'disable'])->name('usuarios.disable')->middleware('can:dashboard_admin');
Route::put('/usuarios/{usuario}/enable', [UsuarioController::class, 'enable'])->name('usuarios.enable')->middleware('can:dashboard_admin');

// Crud docentes
Route::middleware(['can:dashboard_secretario'])->name('docentes.')->group(function () {
    Route::get('docentes', [DocenteController::class, 'index'])->name('index');
    Route::get('docentes/create', [DocenteController::class, 'create'])->name('create');
    Route::post('docentes', [DocenteController::class, 'store'])->name('store');
    Route::get('docentes/{docente}', [DocenteController::class, 'show'])->name('show');
    Route::get('docentes/{docente}/edit', [DocenteController::class, 'edit'])->name('edit');
    Route::put('docentes/{docente}', [DocenteController::class, 'update'])->name('update');
    Route::delete('docentes/{docente}', [DocenteController::class, 'destroy'])->name('destroy');
});
Route::post('/dashboard/docente/update-silabo', [DashboardDocenteController::class, 'updateSilabo'])->name('updateSilabo');
// Crud paralelo
Route::middleware(['can:dashboard_admin'])->group(function () {
    Route::resource('paralelos', ParaleloController::class)->names([
        'index' => 'paralelos.index',
        'create' => 'paralelos.create',
        'store' => 'paralelos.store',
        'show' => 'paralelos.show',
        'edit' => 'paralelos.edit',
        'update' => 'paralelos.update',
        'destroy' => 'paralelos.destroy'
    ]);

    Route::resource('secretarios', SecretarioController::class)->names([
        'index' => 'secretarios.index',
        'create' => 'secretarios.create',
        'store' => 'secretarios.store',
        'show' => 'secretarios.show',
        'edit' => 'secretarios.edit',
        'update' => 'secretarios.update',
        'destroy' => 'secretarios.destroy'
    ]);
});

Route::middleware(['can:dashboard_secretario'])->name('alumnos.')->group(function () {
    Route::get('alumnos', [AlumnoController::class, 'index'])->name('index');
    Route::get('alumnos/create', [AlumnoController::class, 'create'])->name('create');
    Route::post('alumnos', [AlumnoController::class, 'store'])->name('store');
    Route::get('alumnos/{alumno}/edit', [AlumnoController::class, 'edit'])->where('alumno', '.*')->name('edit');
    Route::put('alumnos/{alumno}', [AlumnoController::class, 'update'])->where('alumno', '.*')->name('update');
    Route::delete('alumnos/{alumno}', [AlumnoController::class, 'destroy'])->where('alumno', '.*')->name('destroy');
});

Route::middleware(['can:dashboard_admin'])->name('maestrias.')->group(function () {
    Route::get('maestrias', [MaestriaController::class, 'index'])->name('index');
    Route::get('maestrias/create', [MaestriaController::class, 'create'])->name('create');
    Route::post('maestrias', [MaestriaController::class, 'store'])->name('store');
    Route::get('maestrias/{maestria}', [MaestriaController::class, 'show'])->name('show');
    Route::get('maestrias/{maestria}/edit', [MaestriaController::class, 'edit'])->name('edit');
    Route::put('maestrias/{maestria}', [MaestriaController::class, 'update'])->name('update');
    Route::delete('maestrias/{maestria}', [MaestriaController::class, 'destroy'])->name('destroy');
    Route::put('maestrias/{maestria}/disable', [MaestriaController::class, 'disable'])->name('disable');
    Route::put('maestrias/{maestria}/enable', [MaestriaController::class, 'enable'])->name('enable');
});
Route::delete('/docentes/{docente_dni}/asignaturas/{asignatura_id}', [AsignaturaDocenteController::class, 'destroy'])->name('eliminar_asignatura');
Route::get('/asignaturas_docentes/create/{docente_id}', [AsignaturaDocenteController::class, 'create'])
    ->where('docente_id', '.*')
    ->name('asignaturas_docentes.create1');

Route::middleware(['can:dashboard_admin'])->name('asignaturas.')->group(function () {
    Route::get('/asignaturas', [AsignaturaController::class, 'index'])->name('index');
    Route::get('/asignaturas/create', [AsignaturaController::class, 'create'])->name('create');
    Route::post('/asignaturas', [AsignaturaController::class, 'store'])->name('store');
    Route::get('/asignaturas/{asignatura}', [AsignaturaController::class, 'show'])->name('show');
    Route::get('/asignaturas/{asignatura}/edit', [AsignaturaController::class, 'edit'])->name('edit');
    Route::put('/asignaturas/{asignatura}', [AsignaturaController::class, 'update'])->name('update');
    Route::delete('/asignaturas/{asignatura}', [AsignaturaController::class, 'destroy'])->name('destroy');
});

Route::middleware(['can:dashboard_secretario'])->name('asignaturas_docentes.')->group(function () {
    Route::get('/asignaturas_docentes', [AsignaturaDocenteController::class, 'index'])->name('index');
    Route::get('/asignaturas_docentes/create/{docente_id}', [AsignaturaDocenteController::class, 'create'])
        ->where('docente_id', '.*')
        ->name('create1');
    Route::post('/asignaturas_docentes', [AsignaturaDocenteController::class, 'store'])->name('store');
    Route::get('/asignaturas_docentes/{asignatura_docente}', [AsignaturaDocenteController::class, 'show'])->name('show');
    Route::get('/asignaturas_docentes/{asignatura_docente}/edit', [AsignaturaDocenteController::class, 'edit'])->name('edit');
    Route::put('/asignaturas_docentes/{asignatura_docente}', [AsignaturaDocenteController::class, 'update'])->name('update');
    Route::delete('/asignaturas_docentes/{asignatura_docente}', [AsignaturaDocenteController::class, 'destroy'])->name('destroy');
});

Route::middleware(['can:dashboard_admin'])->name('aulas.')->group(function () {
    Route::get('aulas', [AulaController::class, 'index'])->name('index');
    Route::get('aulas/create', [AulaController::class, 'create'])->name('create');
    Route::post('aulas', [AulaController::class, 'store'])->name('store');
    Route::get('aulas/{aula}', [AulaController::class, 'show'])->name('show');
    Route::get('aulas/{aula}/edit', [AulaController::class, 'edit'])->name('edit');
    Route::put('aulas/{aula}', [AulaController::class, 'update'])->name('update');
    Route::delete('aulas/{aula}', [AulaController::class, 'destroy'])->name('destroy');
});

Route::middleware(['can:dashboard_admin'])->name('periodos_academicos.')->group(function () {
    Route::get('periodos_academicos', [PeriodoAcademicoController::class, 'index'])->name('index');
    Route::get('periodos_academicos/create', [PeriodoAcademicoController::class, 'create'])->name('create');
    Route::post('periodos_academicos', [PeriodoAcademicoController::class, 'store'])->name('store');
    Route::get('periodos_academicos/{periodo_academico}', [PeriodoAcademicoController::class, 'show'])->name('show');
    Route::get('periodos_academicos/{periodo_academico}/edit', [PeriodoAcademicoController::class, 'edit'])->name('edit');
    Route::put('periodos_academicos/{periodo_academico}', [PeriodoAcademicoController::class, 'update'])->name('update');
    Route::delete('periodos_academicos/{periodo_academico}', [PeriodoAcademicoController::class, 'destroy'])->name('destroy');
});

Route::middleware(['can:dashboard_secretario'])->name('cohortes.')->group(function () {
    Route::get('cohortes', [CohorteController::class, 'index'])->name('index');
    Route::get('cohortes/create', [CohorteController::class, 'create'])->name('create');
    Route::post('cohortes', [CohorteController::class, 'store'])->name('store');
    Route::get('cohortes/{cohort}/edit', [CohorteController::class, 'edit'])->name('edit');
    Route::put('cohortes/{cohort}', [CohorteController::class, 'update'])->name('update');
    Route::delete('cohortes/{cohort}', [CohorteController::class, 'destroy'])->name('destroy');
});

Route::get('/cohortes_docentes/create/{docente_id}', [CohorteDocenteController::class, 'create'])->where('docente_id', '.*')->middleware('can:dashboard_secretario');
Route::get('/cohortes_docentes/create/{docente_id}/{asignatura_id}', [CohorteDocenteController::class, 'create'])->where('docente_id', '.*')->middleware('can:dashboard_secretario');
Route::resource('cohortes_docentes', CohorteDocenteController::class)->middleware('can:dashboard_secretario')->names([
    'create' => 'cohortes_docentes.create',
    'store' => 'cohortes_docentes.store',
    'index' => 'cohortes_docentes.index',
    'edit' => 'cohortes_docentes.edit',
    'update' => 'cohortes_docentes.update',
    'show' => 'cohortes_docentes.show',
    'destroy' => 'cohortes_docentes.destroy'
]);

Route::get('/matriculas/create/{alumno_id}', [MatriculaController::class, 'create'])->where('alumno_id', '.*')->middleware('can:dashboard_secretario');
Route::get('/matriculas/create/{alumno_id}/{cohorte_id}', [MatriculaController::class, 'create'])->where('alumno_id', '.*')->middleware('can:dashboard_secretario');
Route::resource('matriculas', MatriculaController::class)->parameters(['matriculas' => 'id'])->names([
    'index' => 'matriculas.index',
    'create' => 'matriculas.create',
    'store' => 'matriculas.store',
    'show' => 'matriculas.show',
    'edit' => 'matriculas.edit',
    'update' => 'matriculas.update',
    'destroy' => 'matriculas.destroy'
])->middleware('can:dashboard_secretario');

Route::get('/calificaciones/create/{docente_id}/{asignatura_id}/{cohorte_id}', [CalificacionController::class, 'create'])->where('docente_id', '.*')->middleware('can:dashboard_docente')->name('calificaciones.create1');
Route::get('/calificaciones/show/{alumno_id}/{docente_id}/{asignatura_id}/{cohorte_id}', [CalificacionController::class, 'show'])->where('alumno_id', '.*')->where('docente_id', '.*')->middleware('can:dashboard_docente')->name('calificaciones.show1');
Route::get('/calificaciones/edit/{alumno_id}/{docente_id}/{asignatura_id}/{cohorte_id}', [CalificacionController::class, 'edit'])->where('docente_id', '.*')->middleware('can:dashboard_docente')->name('calificaciones.edit1');

Route::resource('calificaciones', CalificacionController::class)->names([
    'index' => 'calificaciones.index',
    'create' => 'calificaciones.create',
    'store' => 'calificaciones.store',
    'show' => 'calificaciones.show',
    'edit' => 'calificaciones.edit',
    'update' => 'calificaciones.update',
    'destroy' => 'calificaciones.destroy'
])->middleware('can:dashboard_docente');

Route::post('/perfiles/actualizar', [PerfilController::class, 'actualizar_p'])->name('perfil.actualizar');



Route::resource('secciones', SeccionController::class)->names([
    'index' => 'secciones.index',
    'create' => 'secciones.create',
    'store' => 'secciones.store',
    'edit' => 'secciones.edit',
    'update' => 'secciones.update',
    'destroy' => 'secciones.destroy'
])->middleware('can:dashboard_admin');

Route::resource('record', RecordController::class)->names([
    'index' => 'record.index',
    'create' => 'record.create',
    'store' => 'record.store',
    'edit' => 'record.edit',
    'update' => 'record.update',
    'destroy' => 'record.destroy'
])->middleware('can:dashboard_secretario');

Route::middleware(['can:dashboard_admin'])->name('notas.')->group(function () {
    Route::get('notas/create/{id_alumno}', [NotaController::class, 'create'])->where('id_alumno', '.*')->name('create');
    Route::post('notas', [NotaController::class, 'store'])->name('store');
    Route::get('notas/{id_alumno}', [NotaController::class, 'index'])->where('id_alumno', '.*')->name('index');
    Route::get('notas/{id_alumno}/edit', [NotaController::class, 'edit'])->where('id_alumno', '.*')->name('edit');
    Route::put('notas/{id_alumno}', [NotaController::class, 'update'])->where('id_alumno', '.*')->name('update');
    Route::delete('notas/{id_alumno}', [NotaController::class, 'destroy'])->where('id_alumno', '.*')->name('destroy');
});

Route::get('/generar-pdf/{docenteId}/{asignaturaId}/{cohorteId}/{aulaId?}/{paraleloId?}', [NotasAsignaturaController::class, 'show'])
    ->where('docenteId', '.*')
    ->middleware(['can:dashboard_docente'])
    ->name('pdf.notas.asignatura');


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/enviar-correo', [CorreoController::class, 'formulario'])->name('formulario-correo');
Route::post('/enviar-correo', [CorreoController::class, 'enviarCorreo'])->name('enviar-correo');
Route::get('/cancelar-envio', [CorreoController::class, 'cancelarEnvio'])->name('cancelar-envio');

Route::get('/exportar-excel/{docenteId}/{asignaturaId}/{cohorteId}/{aulaId?}/{paraleloId?}', [DashboardDocenteController::class, 'exportarExcel'])
    ->name('exportar.excel');

Route::get('/inicio', [InicioController::class, 'redireccionarDashboard'])->name('inicio');

Route::post('mensajes', [MessageController::class, 'store'])->name('messages.store');
Route::get('mensajes/buzon', [MessageController::class, 'index'])->name('messages.index');
Route::delete('/mensajes/{id_message}', [MessageController::class, 'destroy'])->name('messages.destroy');

Route::get('postulacion/create', [PostulanteController::class, 'create'])->name('postulantes.create');
Route::post('postulacion', [PostulanteController::class, 'store'])->name('postulantes.store');
Route::get('postulacion', [PostulanteController::class, 'index'])->name('postulantes.index');
Route::delete('postulacion/{dni}', [PostulanteController::class, 'destroy'])->where('dni', '.*')->name('postulantes.destroy');
Route::get('postulacion/{dni}', [PostulanteController::class, 'show'])->where('dni', '.*')->name('postulantes.show');
Route::post('postulacion/{dni}/aceptar', [PostulanteController::class, 'acep_neg'])->where('dni', '.*')->name('postulantes.aceptar');

Route::resource('notificaciones', NotificacionesController::class)->only(['index', 'destroy']);
Route::get('/cantidad-notificaciones', [NotificacionesController::class, 'contador']);

// Rutas protegidas por middleware para roles específicos
Route::middleware(['can:dashboard_alumno'])->group(function () {
    Route::get('/pagos/pago/estudiante', [PagoController::class, 'pago'])->name('pagos.pago');
    Route::post('/pagos/elegir-modalidad', [PagoController::class, 'elegirModalidad'])->name('pagos.elegir-modalidad');
});

Route::middleware(['can:dashboard_secretario'])->group(function () {
    // Listar todos los pagos (equivalente a index)
    Route::get('/pagos/dashboard', [PagoController::class, 'index'])->name('pagos.index');

    Route::patch('/pagos/{pago}/verificar', [PagoController::class, 'verificar_pago'])->name('pagos.verificar');


    // Mostrar el formulario para editar un pago (equivalente a edit)
    Route::get('/pagos/{pago}/edit', [PagoController::class, 'edit'])->name('pagos.edit');

    // Actualizar un pago existente (equivalente a update)
    Route::put('/pagos/{pago}', [PagoController::class, 'update'])->name('pagos.update');
    Route::patch('/pagos/{pago}', [PagoController::class, 'update']);

    // Eliminar un pago (equivalente a destroy)
    Route::delete('/pagos/{pago}', [PagoController::class, 'destroy'])->name('pagos.destroy');
});

// Listar todos los pagos (equivalente a index)

// Mostrar el formulario para descuento
Route::get('/descuento', [PagoController::class, 'showDescuentoForm'])->name('pago.descuento.form');

// Procesar el descuento
Route::post('/descuento', [PagoController::class, 'processDescuento'])->name('pago.descuento.process');

// Guardar un nuevo pago (equivalente a store)
Route::post('/pagos', [PagoController::class, 'store'])->name('pagos.store');



