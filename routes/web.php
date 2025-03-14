<?php

use App\Http\Controllers\AdministradoresController;
use App\Http\Middleware\AuthenticateDashboardAdministrator;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CadastroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\InformacaoProdutosController;
use App\Http\Middleware\AuthenticateDashboard;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\CotacoesController;
use App\Http\Controllers\SimplesNacionalController;
use App\Mail\MensagemMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::post('/redirect-post', [LoginController::class, 'redirectPost'])->name('redirect-post');

        Route::get('/', function () {
            return view('index.inicio');
        })->name('inicio');
        Route::get('/teste', function () {
            return view('testeVue.index'); });
        Route::get('/criartenant', [TenantController::class, 'create']);
        Route::post('/criar-Tenant', [TenantController::class, 'createTenant'])->name('criarTenant');
        Route::get('/create-tenant', [TenantController::class, 'createTenant']);



        Route::get('/login', [LoginController::class, 'login3'])->name('login3');
        Route::post('/identificarLocatario', [LoginController::class, 'identificarLocatario'])->name('identify.tenant');

        Auth::routes(['verify' => true]);


        Route::post('login', [LoginController::class, 'login3']);

        Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro');
        Route::post('/cadastro', [CadastroController::class, 'store']);
        Route::get('/cadastroConcluido', [CadastroController::class, 'cadastroConcluido'])->name('cadastroConcluido');
        Route::get('/sanitize-string/{nome}', [LoginController::class, 'sanitizeString'])->name('sanitize.string');

        Route::get('/buscar-empresa', [LoginController::class, 'buscar'])->name('buscar.empresa');

        Route::get('/mensagem', function () {
            return new MensagemMail();
            // Mail::to('patrickcaminhasm@gmail.com')->send(new MensagemMail());
            //return 'E-mail enviado com sucesso!';
        });






        /*Route::match(['get', 'post'], '/cadastroempresaconcluido', function () {
            return view('index/cadastroEmpresaConcluido');
        });*/
        //   });}

        Route::get('loginAdministrativo', [AdministradoresController::class, 'showLoginForm'])->name('loginAdministrativo.form');
        Route::post('loginAdministrativo', [AdministradoresController::class, 'login'])->name('loginAdministrativo.store');
        Route::get('/loginAdministrativoSecond', [AdministradoresController::class, 'formularioLoginAdmin2'])->name('loginAdministrativoSecond.form');
        Route::get('cadastroAdministrador', [AdministradoresController::class, 'showCadastroForm'])->name('cadastroAdministrador.form');
        Route::post('cadastroAdministrador', [AdministradoresController::class, 'store'])->name('cadastroAdministrador.store');
        Route::post('identificarTipoUsuario', [LoginController::class, 'identificarTipoUsuario'])->name('identify.user');
        Route::get('/inicioAdministrador', [AdministradoresController::class, 'showDashboard'])->name('dashboardAdministrador.log');

        Route::post('/inicioAdministrador', [AdministradoresController::class, 'showDashboard'])->name('dashboardAdministrador.log');
        Route::get('/simplesNacional', [SimplesNacionalController::class, 'create'])->name('simples.create');
        Route::post('/simplesNacional/store', [SimplesNacionalController::class, 'store'])->name('simples.store');
        Route::post('/simplesNacional/update', [SimplesNacionalController::class, 'update'])->name('simples.update');



        Route::get('logout', [AdministradoresController::class, 'logout'])->name('logout');


        //Route::middleware([AuthenticateDashboardAdministrator::class])->group(function () {
        //    Route::get('/dashboardAdministrador', [AdministradoresController::class, 'showDashboard'])->name('cadastroAdministrador.log');
        //    Route::post('/dashboardAdministrador', [AdministradoresController::class, 'showDashboard'])->name('dashboardAdministrador.log');
        //});







        Route::middleware([AuthenticateDashboard::class])->group(function () {
            /*Route::match(['get', 'post'], '/dashboard', function () {
        return view('sistema/dashboard');
    });*/


            Route::get('/dashboard/{id}', function () {
                return view('sistema.dashboard');
            });
            Route::get('/cadastroproduto', [ProdutoController::class, 'create'])->name('cadastroproduto');
            Route::post('/cadastroproduto', [ProdutoController::class, 'store'])->name('cadastroproduto.store');

            Route::get('/informacaoproduto', [InformacaoProdutosController::class, 'createRead'])->name('produto.informacao');
            Route::get('/informacaoproduto/{nome}', [InformacaoProdutosController::class, 'listar'])->name('produto.listar.nome');
            Route::get('/informacaoprodutorequisicao', [InformacaoProdutosController::class, 'create'])->name('produto.listar');
            Route::get('alterarinformacoesproduto', [InformacaoProdutosController::class, 'update'])->name('produto.alterar');

            Route::get('/ cadastroFornecedor', [FornecedorController::class, 'create'])->name(' fornecedor.create');
            Route::post('/ cadastroFornecedor', [FornecedorController::class, 'store'])->name(' fornecedor.store');

            Route::get('/configuracoes', [ConfiguracoesController::class, 'createConfiguracoes'])->name('configuracoes');
            Route::get('/alterarSenha', [ConfiguracoesController::class, 'createAlterarSenha'])->name('configuracoes.senha');
            Route::post('/alterarSenhaConfirmar', [ConfiguracoesController::class, 'update'])->name('configuracoes.senha.alterar');

            Route::get('/cadastrarfuncionario', [ConfiguracoesController::class, 'createCadastroFuncionario'])->name('configuracoes.funcionario');
            Route::post('/cadastrarfuncionarioconfirmar', [ConfiguracoesController::class, 'storeFuncionario'])->name('configuracoes.funcionario.cadastrar');
        });

        Route::get('/cotacaoprodutos', [CotacoesController::class, 'create'])->name('cotacaoprodutos')->name('cotacaoprodutos');

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
