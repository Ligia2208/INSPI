<?php

require __DIR__ . '/Modules/GestionDocumental.php';
require __DIR__ . '/Modules/CorePrincipal.php';
require __DIR__ . '/Modules/RecursosHumanos.php';
require __DIR__ . '/Modules/Inventario.php';
require __DIR__ . '/Modules/Intranet.php';
require __DIR__ . '/Modules/CambioCultura.php';
require __DIR__ . '/Modules/Plataformas.php';
require __DIR__ . '/Modules/Soporte.php';

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\Google\GoogleAnalyticsController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Log\LogController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Prospect\ProspectController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Quotation\QuotationController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Service\ProjectController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\ServiceType\ServiceTypeController;
use App\Http\Controllers\Setting\AccountController;
use App\Http\Controllers\Setting\BackupController;
use App\Http\Controllers\Setting\CategoryClientController;
use App\Http\Controllers\Setting\CategoryExpenseController;
use App\Http\Controllers\Setting\PaymentTypeController;
use App\Http\Controllers\Setting\PermissionController;
use App\Http\Controllers\Setting\RoleController;
use App\Http\Controllers\Setting\WelcomeController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Login
Auth::routes(['register' => false]);


Route::middleware(['auth'])->group(function () {

    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard.index');


    //Setting
    Route::prefix('ajustes')->group(function () {
        //Welcome
        Route::get('/', [WelcomeController::class, 'index'])->name('setting.welcome.index');
        //Permission
        Route::resource('permisos', PermissionController::class)->parameters(['permisos' => 'permission'])->names('setting.permission');
        //Role
        Route::resource('roles', RoleController::class)->parameters(['roles' => 'role'])->names('setting.role');
        //Category client
        Route::resource('categoria-clientes', CategoryClientController::class)->parameters(['categoria-clientes' => 'categoryClient'])->names('setting.category-client');
        //Category expense
        Route::resource('categoria-gastos', CategoryExpenseController::class)->parameters(['categoria-gastos' => 'categoryExpense'])->names('setting.category-expense');
        //Payment Type
        Route::resource('tipos-de-pagos', PaymentTypeController::class)->parameters(['tipos-de-pagos' => 'paymentType'])->names('setting.payment-type');
        //Accounts
        Route::resource('cuentas', AccountController::class)->parameters(['cuentas' => 'account'])->names('setting.account');
        //Backup
        Route::resource('copias-de-seguridad', BackupController::class)->parameters(['copia-de-seguridad' => 'backup'])->names('setting.backup');
    });

    //log
    Route::get('logs', [LogController::class, 'index'])->name('log.index');

    //User
    Route::resource('usuarios', UserController::class)->parameters(['usuarios' => 'user'])->names('user');
    Route::prefix('usuarios/{user}')->group(function () {
        //Password
        Route::get('password', [UserController::class, 'password'])->name('user.password');
        //Permission
        Route::get('permisos', [UserController::class, 'permission'])->name('user.permission');
        //Prospect
        Route::get('prospectos', [UserController::class, 'prospect'])->name('user.prospect');
        //Transfer Prospect
        Route::get('transferir', [UserController::class, 'transfer'])->name('user.transfer');
        //Client
        Route::get('clientes', [UserController::class, 'client'])->name('user.client');
        //Payment
        Route::get('pagos', [UserController::class, 'payment'])->name('user.payment');
        //Expense
        Route::get('gastos', [UserController::class, 'expense'])->name('user.expense');
        //Expense
        Route::get('logs', [UserController::class, 'log'])->name('user.log');
    });

    //Prospect
    Route::get('prospectos/{prospect}/become-to-client', [ProspectController::class, 'becomeToClient'])->name('prospect.become-to-client');
    Route::resource('prospectos', ProspectController::class)->parameters(['prospectos' => 'prospect'])->names('prospect');

    //Client
    Route::resource('clientes', ClientController::class)->parameters(['clientes' => 'client'])->names('client');

    //Provider
    Route::resource('proveedores', ProviderController::class)->parameters(['proveedores' => 'provider'])->names('provider');

    //Services Type
    Route::resource('tipos-de-servicios', ServiceTypeController::class)->parameters(['tipos-de-servicios' => 'serviceType'])->names('service-type');

    //Service
    Route::resource('servicios', ServiceController::class)->parameters(['servicios' => 'service'])->names('service');

    //Project
    Route::resource('proyectos', ProjectController::class)->parameters(['proyectos' => 'service'])->names('project');

    //Quotation
    Route::resource('cotizaciones', QuotationController::class)->parameters(['cotizaciones' => 'quotation'])->names('quotation');

    //Invoice
    Route::resource('facturas', InvoiceController::class)->parameters(['facturas' => 'invoice'])->names('invoice');

    //Payment
    Route::resource('pagos', PaymentController::class)->parameters(['pagos' => 'payment'])->names('payment');

    //Expense
    Route::resource('gastos', ExpenseController::class)->parameters(['gastos' => 'expense'])->names('expense');


    /* =========================== INVENTARIO =========================== */
    Route::group(['namespace' => 'App\Http\Controllers\InventarioReactivo'], function(){

        Route::get('/inventario', 'InventarioController@index')->name('inventario'); //vista principal

        Route::get('inventario/marca', 'InventarioController@listMarca')->name('inventario.marca');
        Route::post('/inventario/saveMarca', 'InventarioController@saveMarca')->name('inventario.saveMarca');
        Route::post('/inventario/deleteMarca', 'InventarioController@deleteMarca')->name('inventario.deleteMarca');
        Route::get('/inventario/obtenerMarca/{id}', 'InventarioController@obtenerMarca')->name('inventario.obtenerMarca');
        Route::put('/inventario/actualizarMarca/{id}', 'InventarioController@actualizarMarca')->name('inventario.actualizarMarca');

        Route::get('/inventario/obtenerKit/{id}', 'InventarioController@obtenerKit')->name('inventario.obtenerKit');
        Route::get('inventario/get_proveedor', 'InventarioController@get_proveedor')->name('inventario.get_proveedor');

        Route::get('inventario/categoria', 'InventarioController@listCategoria')->name('inventario.categoria');
        Route::post('/inventario/saveCategoria', 'InventarioController@saveCategoria')->name('inventario.saveCategoria');
        Route::post('/inventario/deleteCategoria', 'InventarioController@deleteCategoria')->name('inventario.deleteCategoria');
        Route::get('/inventario/obtenerCategoria/{id}', 'InventarioController@obtenerCategoria')->name('inventario.obtenerCategoria');
        Route::put('/inventario/actualizarCategoria/{id}', 'InventarioController@actualizarCategoria')->name('inventario.actualizarCategoria');


        Route::get('inventario/articulo', 'InventarioController@listArticulo')->name('inventario.articulo');
        Route::post('/inventario/saveArticulo', 'InventarioController@saveArticulo')->name('inventario.saveArticulo');
        Route::post('/inventario/deleteArticulo', 'InventarioController@deleteArticulo')->name('inventario.deleteArticulo');
        Route::get('/inventario/obtenerArticulo/{id}', 'InventarioController@obtenerArticulo')->name('inventario.obtenerArticulo');
        Route::put('/inventario/actualizarArticulo/{id}', 'InventarioController@actualizarArticulo')->name('inventario.actualizarArticulo');
        Route::get('inventario/obtenerMarcas', 'InventarioController@obtenerMarcas')->name('inventario.obtenerMarcas');

        Route::get('inventario/movimiento', 'InventarioController@listMovimiento')->name('inventario.listMovimiento');
        Route::get('inventario/crearMovimiento', 'InventarioController@crearMovimiento')->name('inventario.crearMovimiento');

        Route::get('inventario/crearAjuste', 'InventarioController@crearAjuste')->name('inventario.crearAjuste');
        Route::post('inventario/saveAjuste', 'InventarioController@saveAjuste')->name('inventario.saveAjuste');

        Route::get('inventario/editarMovimiento/{id}', 'InventarioController@editarMovimiento')->name('inventario.editarMovimiento');
        Route::get('inventario/getMoviemientos/{id}', 'InventarioController@getMoviemientos')->name('inventario.getMoviemientos');
        Route::post('inventario/editMovimiento', 'InventarioController@editMovimiento')->name('inventario.editMovimiento');
        Route::post('inventario/editTransferencia', 'InventarioController@editTransferencia')->name('inventario.editTransferencia');

        Route::get('inventario/obtenerArticulos', 'InventarioController@obtenerArticulos')->name('inventario.obtenerArticulos');
        Route::post('inventario/saveMovimiento', 'InventarioController@saveMovimiento')->name('inventario.saveMovimiento');
        Route::post('inventario/import', 'InventarioController@import')->name('inventario.import');
        Route::post('inventario/report1', 'InventarioController@report1')->name('inventario.report1');
        Route::post('inventario/report2', 'InventarioController@report2')->name('inventario.report2');
        Route::post('inventario/report3', 'InventarioController@report3')->name('inventario.report3');
        Route::get('inventario/articuloLote/{id}', 'InventarioController@articuloLote')->name('inventario.articuloLote');
        Route::get('inventario/articuloLoteExa/{id}', 'InventarioController@articuloLoteExa')->name('inventario.articuloLoteExa');
        Route::get('inventario/articuloLoteIdLab', 'InventarioController@articuloLoteIdLab')->name('inventario.articuloLoteIdLab');
        Route::get('inventario/unidadLote/{id}', 'InventarioController@unidadLote')->name('inventario.unidadLote');
        Route::get('inventario/unidadLoteIdLab', 'InventarioController@unidadLoteIdLab')->name('inventario.unidadLoteIdLab');

        Route::get('inventario/exportarPlantilla', 'InventarioController@exportarPlantilla')->name('exportarPlantilla');

        Route::get('inventario/laboratorio', 'InventarioController@laboratorio')->name('inventario.laboratorio');
        Route::get('inventario/bodega', 'InventarioController@bodega')->name('inventario.bodega');
        Route::get('/inventario/filtrar', 'InventarioController@filtrar')->name('inventario.filtrar');
        Route::get('/inventario/filtrarReporte', 'InventarioController@filtrarReporte')->name('inventario.filtrarReporte');

        Route::get('inventario/crearEgreso', 'InventarioController@crearEgreso')->name('inventario.crearEgreso');
        Route::post('inventario/saveMovimientoEgre', 'InventarioController@saveMovimientoEgre')->name('inventario.saveMovimientoEgre');
        Route::get('inventario/transferencia', 'InventarioController@createTransferencia')->name('inventario.createTransferencia');
        Route::get('inventario/obtenerArticulosLab', 'InventarioController@obtenerArticulosLab')->name('inventario.obtenerArticulosLab');
        Route::get('inventario/obtenerArticulosIdLab', 'InventarioController@obtenerArticulosIdLab')->name('inventario.obtenerArticulosIdLab');
        Route::get('inventario/obtenerArticulosExa', 'InventarioController@obtenerArticulosExa')->name('inventario.obtenerArticulosExa  ');
        Route::get('inventario/agregarUnidades', 'InventarioController@agregarUnidades')->name('inventario.agregarUnidades');
        Route::post('inventario/saveTransferencia', 'InventarioController@saveTransferencia')->name('inventario.saveTransferencia');

        Route::get('inventario/crearEgresoInm', 'InventarioController@crearEgresoInm')->name('inventario.crearEgresoInm');
        Route::post('inventario/saveCorrida', 'InventarioController@saveCorrida')->name('inventario.saveCorrida');
        Route::post('inventario/saveCorridaManInm', 'InventarioController@saveCorridaManInm')->name('inventario.saveCorridaManInm');

        Route::get('inventario/muestrasLaborat/{id}', 'InventarioController@muestrasLaborat')->name('inventario.muestrasLaborat');
        Route::post('inventario/saveCorridaInm', 'InventarioController@saveCorridaInm')->name('inventario.saveCorridaInm');
        Route::post('inventario/saveCorridaMan', 'InventarioController@saveCorridaMan')->name('inventario.saveCorridaMan');
        Route::get('inventario/obtenerExamenLab', 'InventarioController@obtenerExamenLab')->name('inventario.obtenerExamenLab');
        Route::get('inventario/obtenerControlLab', 'InventarioController@obtenerControlLab')->name('inventario.obtenerControlLab');
        Route::get('inventario/list_corrida', 'InventarioController@listCorrida')->name('inventario.listCorrida');
        Route::get('/inventario/obtenerUsuariosLab/{id_usuario}', 'InventarioController@obtenerUsuariosLab')->name('inventario.obtenerUsuariosLab');
        Route::get('inventario/reportHexa', 'InventarioController@reportHexa')->name('inventario.reportHexa');
        Route::get('inventario/reportMono', 'InventarioController@reportMono')->name('inventario.reportMono');

        Route::get('inventario/obtenerArticulosCate/{id}', 'InventarioController@obtenerArticulosCate')->name('inventario.obtenerArticulosCate');
        Route::get('inventario/list_ajuste', 'InventarioController@list_ajuste')->name('inventario.list_ajuste');
        Route::get('inventario/validaAjuste', 'InventarioController@validaAjuste')->name('inventario.validaAjuste');

        Route::post('inventario/updateValor', 'InventarioController@updateValor')->name('inventario.updateValor');

        Route::post('inventario/updateKit', 'InventarioController@updateKit')->name('inventario.updateKit');
        Route::post('inventario/updateNameReactivo', 'InventarioController@updateNameReactivo')->name('inventario.updateNameReactivo');
        Route::post('inventario/updateSubcategoria', 'InventarioController@updateSubcategoria')->name('inventario.updateSubcategoria');
        Route::post('inventario/deleteSubcategoria', 'InventarioController@deleteSubcategoria')->name('inventario.deleteSubcategoria');

        Route::get('inventario/unidad', 'InventarioController@listUnidad')->name('inventario.unidad');
        Route::post('/inventario/saveUnidad', 'InventarioController@saveUnidad')->name('inventario.saveUnidad');
        Route::post('/inventario/deleteUnidad', 'InventarioController@deleteUnidad')->name('inventario.deleteUnidad');
        Route::get('/inventario/obtenerUnidad/{id}', 'InventarioController@obtenerUnidad')->name('inventario.obtenerUnidad');
        Route::put('/inventario/actualizarUnidad/{id}', 'InventarioController@actualizarUnidad')->name('inventario.actualizarUnidad');

        Route::get('/inventario/generate-pdf_in', 'InventarioController@generatePDF_IN')->name('inventario.generatePDF_IN');
        Route::get('/inventario/generate-pdf_out', 'InventarioController@generatePDF_OUT')->name('inventario.generatePDF_OUT');
        Route::get('/inventario/generate-pdf_ajuste', 'InventarioController@generatePDF_AJ')->name('inventario.generatePDF_AJ');


        Route::get('inventario/crearEgresoInf', 'InventarioController@crearEgresoInf')->name('inventario.crearEgresoInf');
        Route::post('inventario/saveCorridaManInf', 'InventarioController@saveCorridaManInf')->name('inventario.saveCorridaManInf');
        Route::get('inventario/reportReactivo', 'InventarioController@reportReactivo')->name('inventario.reportReactivo');
        Route::get('inventario/reportBodegaInvetario', 'InventarioController@reportBodegaInvetario')->name('inventario.reportBodegaInvetario');
        Route::get('inventario/reportReactivoKardex', 'InventarioController@reportReactivoKardex')->name('inventario.reportReactivoKardex');

        Route::get('inventario/kardexInventario', 'InventarioController@kardexInventario')->name('inventario.kardexInventario');
        Route::get('/inventario/pdf_corrida', 'InventarioController@pdf_corrida')->name('inventario.pdf_corrida');

        Route::get('inventario/reportInventario', 'InventarioController@reportInventario')->name('inventario.reportInventario');
        Route::get('inventario/reportInventarioStock', 'InventarioController@reportInventarioStock')->name('inventario.reportInventarioStock');
        Route::get('inventario/reportMovimientoGeneral', 'InventarioController@reportMovimientoGeneral')->name('inventario.reportMovimientoGeneral');
        Route::get('inventario/reportInventarioGeneral', 'InventarioController@reportInventarioGeneral')->name('inventario.reportInventarioGeneral');

        Route::get('inventario/reportInventarioStockGeneral', 'InventarioController@reportInventarioStockGeneral')->name('inventario.reportInventarioStockGeneral');

        Route::get('inventario/get_tranferir', 'InventarioController@get_tranferir')->name('inventario.get_tranferir');
        Route::post('/inventario/sendTransferencia', 'InventarioController@sendTransferencia')->name('inventario.sendTransferencia');

        Route::get('/inventario/pdf', 'InventarioController@pdf')->name('inventario.pdf');

        Route::get('/download/{fileName}', 'InventarioController@downloadExcel')->name('download.excel'); 

    });
    /* =========================== INVENTARIO =========================== */




    /* =========================== ENCUESTAS =========================== */
    Route::group(['namespace' => 'App\Http\Controllers\EvaluacionEncuesta'], function(){

        Route::get('/encuestas', 'EncuestaController@index')->name('encuesta'); //vista principal

        Route::get('/encuestas/create', 'EncuestaController@createView')->name('encuesta.createView'); // vista de crear encuesta
        Route::post('/encuestas/save', 'EncuestaController@saveEncuesta')->name('encuesta.saveEncuesta');
        Route::get('/encuestas/listarEncuesta', 'EncuestaController@listEncuesta')->name('encuesta.listEncuesta'); // vista de listar Encuestas
        Route::get('/encuestas/eliminarEncuesta/{id}', 'EncuestaController@eliminarEncuesta')->name('encuesta.eliminarEncuesta');//eliminar encuesta
        Route::get('/encuestas/visualizarEncuesta', 'EncuestaController@visualizarEncuesta')->name('encuesta.visualizarEncuesta');


        Route::get('/encuestas/listarLaboratorio', 'EncuestaController@listLaboratorio')->name('encuesta.listLaboratorio'); // vista de listar laboratorio
        Route::get('/encuestas/crearLaboratorio', 'EncuestaController@createLaboratorio')->name('encuesta.createLaboratorio'); // vista de crear laboratorio
        Route::get('/encuestas/editLaboratorio/{id}', 'EncuestaController@editLaboratorio')->name('encuesta.editLaboratorio');
        Route::get('/encuestas/eliminarLaboratorio/{id}', 'EncuestaController@eliminarLaboratorio')->name('encuesta.eliminarLaboratorio');//eliminar seguimiento


        Route::post('/encuestas/saveLaboratorio', 'EncuestaController@saveLaboratorio')->name('encuesta.saveLaboratorio');
        Route::get('/encuestas/enlazarEncuesta', 'EncuestaController@link_encuesta')->name('encuesta.link_encuesta'); // vista de crear laboratorio
        Route::post('/encuestas/saveTipoEncuesta', 'EncuestaController@saveTipoEncuesta')->name('encuesta.saveTipoEncuesta');//para guardar el enlace, tipo y encuesta
        Route::get('/encuestas/crearUsuario', 'EncuestaController@createUsuario_lab')->name('encuesta.createUsuario_lab'); // vista de crear usuarios
        Route::get('/encuestas/createUsuario_int', 'EncuestaController@createUsuario_int')->name('encuesta.createUsuario_int'); // vista de crear usuarios interno
        Route::post('/encuestas/saveUsuarioInt', 'EncuestaController@saveUsuarioInt')->name('encuesta.saveUsuarioInt');//para guardar el usuario de tipo interno
        Route::post('/encuestas/deleteUsuarioInt', 'EncuestaController@deleteUsuarioInt')->name('encuesta.deleteUsuarioInt');//para eliminar el usuario de tipo interno
        Route::get('/encuestas/createUsuario_nopre', 'EncuestaController@createUsuario_nopre')->name('encuesta.createUsuario_nopre'); // vista de crear usuarios no presencial
        Route::post('/encuestas/saveUsuarioNopre', 'EncuestaController@saveUsuarioNopre')->name('encuesta.saveUsuarioNopre');//para guardar el usuario de tipo externo no presencial
        Route::post('/encuestas/deleteUsuarioNopre', 'EncuestaController@deleteUsuarioNopre')->name('encuesta.deleteUsuarioNopre');//para eliminar el usuario de tipo externo no presencial
        Route::get('/encuestas/createUsuario_pre', 'EncuestaController@createUsuario_pre')->name('encuesta.createUsuario_pre'); // vista de crear usuarios externo presencial
        Route::post('/encuestas/saveUsuarioPre', 'EncuestaController@saveUsuarioPre')->name('encuesta.saveUsuarioPre');//para guardar el usuario de tipo externo presencial
        Route::post('/encuestas/deleteUsuarioPre', 'EncuestaController@deleteUsuarioPre')->name('encuesta.deleteUsuarioPre');//para eliminar el usuario de tipo externo presencial
        Route::get('/encuestas/crearEvento', 'EncuestaController@createEvento')->name('encuesta.createEvento'); // vista de crear laboratorio
        Route::post('/encuestas/saveEvento', 'EncuestaController@saveEvento')->name('encuesta.saveEvento');
        Route::post('/encuestas/moveUsuarioNopre', 'EncuestaController@moveUsuarioNopre')->name('encuesta.moveUsuarioNopre');
        Route::get('/encuestas/editUsuario_nopre', 'EncuestaController@editUsuario_nopre')->name('encuesta.editUsuario_nopre'); // vista de crear usuarios externo presencial
        Route::post('/encuestas/saveEditUsuarioNopre', 'EncuestaController@saveEditUsuarioNopre')->name('encuesta.saveEditUsuarioNopre');//para guardar el usuario de tipo externo no presencial


        Route::get('/laboratoriosTipo/{id}', 'EncuestaController@laboratoriosTipo')->name('encuesta.laboratoriosTipo');
        Route::get('/encuestas/usuEncuesta', 'EncuestaController@usuEncuesta')->name('encuesta.usuEncuesta'); // vista para visualizar todas las encuestas del lab
        Route::get('/encuestas/getEncuestas', 'EncuestaController@getEncuestas')->name('encuesta.getEncuestas');
        Route::get('/encuestas/getEncuestasTotales', 'EncuestaController@getEncuestasTotales')->name('encuesta.getEncuestasTotales');
        Route::get('/eventoCorreo/{id}', 'EncuestaController@eventoCorreo')->name('encuesta.eventoCorreo');


        Route::get('/obtenerDepartamentosEncuesta/{id}', 'EncuestaController@departamentos')->name('encuesta.departamentos');//devuelve departamento
        Route::get('/obtenerLaboratoriosEncuesta/{id}', 'EncuestaController@laboratorios')->name('encuesta.laboratorios');//devuelve departamento

        Route::get('/homeUsuario', 'EncuestaController@homeUsuario')->name('encuesta.homeUsuario'); //vista principal
        Route::get('/encuestas/doEncuesta', 'EncuestaController@doEncuesta')->name('encuesta.doEncuesta');
        Route::get('/encuestas/finishEncuesta', 'EncuestaController@finishEncuesta')->name('encuesta.finishEncuesta');
        Route::post('/encuestas/saveUser', 'EncuestaController@saveUser')->name('encuesta.saveUser');

        Route::get('encuestas/reportNoPresencial', 'EncuestaController@reportNoPresencial')->name('encuesta.reportNoPresencial');

        Route::get('/obtenerLink/{id}', 'EncuestaController@obtenerLink')->name('encuesta.obtenerLink');//devuelve departamento

        Route::post('/encuestas/deleteEncuestaUser', 'EncuestaController@deleteEncuestaUser')->name('encuesta.deleteCategoria');

        //Route::middleware('guest')->get('/EncuestaSatisfaccion/{id_url}', 'EncuestaController@doEncuestaSatisfaccion')->name('encuesta.doEncuestaSatisfaccion');

    });
    /* =========================== ENCUESTAS =========================== */



});
