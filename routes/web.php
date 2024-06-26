<?php

use App\Http\Controllers\AdministradoresController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CadastroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\CadastroProdutos;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\InformacaoProdutosController;
use App\Http\Middleware\AuthenticateDashboard;
use App\Http\Controllers\ConfiguracoesController;


foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::get('/', function () {
            return view('index.inicio');
        })->name('inicio');
        Route::get('empresas', [LoginController::class, 'showEmpresas'])->name('empresas');
        Route::get('/criartenant', [TenantController::class, 'create']);
        Route::post('/criar-Tenant', [TenantController::class, 'createTenant'])->name('criarTenant');
        Route::get('/create-tenant', [TenantController::class, 'createTenant']);


        Route::get('paginalogin', [LoginController::class, 'showLoginForm'])->name('paginalogin');
        Route::post('paginalogin', [LoginController::class, 'showLoginForm'])->name('paginalogin');
        Route::post('login', [LoginController::class, 'login']);

        Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro');
        Route::post('/cadastro', [CadastroController::class, 'store']);
        /*Route::match(['get', 'post'], '/cadastroempresaconcluido', function () {
            return view('index/cadastroEmpresaConcluido');
        });*/
        //   });}

        Route::get('loginAdministrativo', [AdministradoresController::class, 'showLoginForm'])->name('loginAdministrativo.form');
        Route::post('loginAdministrativo', [AdministradoresController::class, 'login'])->name('loginAdministrativo.store');
        Route::get('cadastroAdministrador', [AdministradoresController::class, 'showCadastroForm'])->name('cadastroAdministrador.form');
        Route::post('cadastroAdministrador', [AdministradoresController::class, 'store'])->name('cadastroAdministrador.store');
   
        Route::get('/dashboardAdministrador', [AdministradoresController::class, 'showDashboard'])->name('cadastroAdministrador.store');

        Route::post('dashboardAdministrador', [AdministradoresController::class, 'showDashboardForm'])->name('dashboardAdministrador.log');


        Route::get('logout', [LoginController::class, 'logout'])->name('logout');










        Route::middleware([AuthenticateDashboard::class])->group(function () {
            /*Route::match(['get', 'post'], '/dashboard', function () {
        return view('sistema/dashboard');
    });*/
            Route::get('/dashboard/{id}', function () {
                return view('sistema.dashboard');
            });
            Route::get('/cadastroproduto', [CadastroProdutos::class, 'create'])->name('cadastroproduto');
            Route::post('/cadastroproduto', [CadastroProdutos::class, 'store'])->name('cadastroproduto.store');

            Route::get('/informacaoproduto', [InformacaoProdutosController::class, 'createRead'])->name('produto.informacao');
            Route::get('/informacaoproduto/{nome}', [InformacaoProdutosController::class, 'listar'])->name('produto.listar.nome');
            Route::get('/informacaoprodutorequisicao', [InformacaoProdutosController::class, 'create'])->name('produto.listar');
            Route::get('alterarinformacoesproduto', [InformacaoProdutosController::class, 'update'])->name('produto.alterar');

            Route::get('/cadastrofornecedor', [FornecedorController::class, 'create'])->name('cadastrofornecedor');
            Route::post('/cadastrofornecedor', [FornecedorController::class, 'store'])->name('cadastrofornecedor.store');

            Route::get('/configuracoes', [ConfiguracoesController::class, 'createConfiguracoes'])->name('configuracoes');
            Route::get('/alterarSenha', [ConfiguracoesController::class, 'createAlterarSenha'])->name('configuracoes.senha');
            Route::post('/alterarSenhaConfirmar', [ConfiguracoesController::class, 'update'])->name('configuracoes.senha.alterar');

            Route::get('/cadastrarfuncionario', [ConfiguracoesController::class, 'createCadastroFuncionario'])->name('configuracoes.funcionario');
            Route::post('/cadastrarfuncionarioconfirmar', [ConfiguracoesController::class, 'storeFuncionario'])->name('configuracoes.funcionario.cadastrar');
        });

        Route::middleware(AuthenticateDashboard::class)->match(['post'], '/cotacaoprodutos', function () {
            return view('cotacao/cotacaoDeProdutos');
        });
        Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/cotacaoprodutosrevisao', function () {
            return view('cotacao/cotacaoDeProdutosRevisao');
        });
        Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/cotacaoprodutosfinal', function () {
            return view('cotacao/cotacaoDeProdutosFinal');
        });
        Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/cotacaoprodutoseditar', function () {
            return view('cotacao/cotacaoDeProdutosEditar');
        });


        Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/ultimasatividades', function () {
            return view('sistema/ultimasAtividades');
        });
        Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/notificacoes', function () {
            return view('sistema/notificacoes');
        });

        Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/enviarmensagem', function () {
            return view('sistema/caixaDeMensagensEnviar');
        });

        Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/dashboard2', function () {
            return view('alternative/dashboard');
        });
        Route::match(['get', 'post'], '/login2', function () {
            return view('alternative/login');
        });
    });
}
