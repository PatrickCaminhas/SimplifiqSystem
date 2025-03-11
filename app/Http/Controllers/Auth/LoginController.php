<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administradores;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Funcionarios;
use App\Models\Empresas;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Models\Empresa_information;
use Illuminate\Support\Str;
use App\Services\AdministradorService;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('index.login3');
    }

    public function buscar(Request $request)
    {
        $termo = $request->input('query');
        $empresas = Empresas::where('nome', 'LIKE', "%{$termo}%")->limit(10)->get();

        return response()->json($empresas);
    }
    private function sanitizeString($string)
    {
        $string = trim($string); // Remove espaços em branco do início e do fim
        $string = str_replace(
            ['ç', 'ã', 'õ', 'á', 'é', 'í', 'ó', 'ú', 'â', 'ê', 'î', 'ô', 'û', 'à', 'è', 'ì', 'ò', 'ù', 'ä', 'ë', 'ï', 'ö', 'ü', 'ñ'],
            ['c', 'a', 'o', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n'],
            $string
        ); // Substitui caracteres especiais
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Remove caracteres especiais
        $string = preg_replace('/\s+/', '', $string); // Remove espaços em branco no meio

        return strtolower($string);
    }
    public function showLoginFormTenant()
    {
        $empresa = Empresa_information::first();
        $empresa= $empresa->nome;
        return view('index.login',['empresa' => $empresa]);
    }
    public function showEmpresas()
    {

        $empresas = Empresas::all()->where('estado', 'ativa');

        // Sanitiza o nome de cada empresa
        $empresasSanitizadas = [];
        foreach ($empresas as $empresa) {
            $empresa->nome = $this->sanitizeString($empresa->nome);
            $empresasSanitizadas[] = $empresa;
        }

        if ($empresasSanitizadas) {
            return view('index.empresas', ['empresas' => $empresasSanitizadas]);
        } else {
            return redirect('index.empresas')->with('error', 'Empresa não encontrada.');
        }
    }

    public function showEmpresas2()
    {

        $empresas = Empresas::all()->where('estado', 'ativa');

        // Sanitiza o nome de cada empresa
        $empresasSanitizadas = [];
        foreach ($empresas as $empresa) {
            $empresa->nome = $this->sanitizeString($empresa->nome);
            $empresasSanitizadas[] = $empresa;
        }

        if ($empresasSanitizadas) {
            return view('index.empresas2');
        } else {
            return redirect('index.empresas')->with('error', 'Empresa não encontrada.');
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $credentials = $request->only('email', 'senha');

        // Tentar autenticar o usuário
        $funcionario = Funcionarios::where('email', $credentials['email'])->first();

        if ($funcionario && Hash::check($credentials['senha'], $funcionario->senha)) {

            Auth::login($funcionario);
            $this->informacoesDaEmpresa($funcionario);
            return redirect()->intended('dashboard');
        }
        if ($funcionario) {
            return redirect()->back()->with([
                'error' => 'Senha incorreta.',
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'E-mail não cadastrado.',
            ]);
        }
    }

    public function informacoesDaEmpresa($funcionario){

        $empresa = Empresa_information::first();
            session([  'funcionario' => $funcionario,
                            'tema' => $empresa->padrao_cores,
                            'empresa' => $empresa->nome,
                            'tamanho_empresa' => $empresa->tamanho_empresa,
                            'menu' => $empresa->tipo_empresa,
                            'Administrador' => $this->verificaPrivilegiosAdministrativos(),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function identificarLocatario(Request $request)
    {
        // Valida os dados de entrada
        $request->validate([
            'email' => 'required|email',

        ]);

        $email = $request['email'];
        // Tenta autenticar o usuário
        $funcionario = Funcionarios::where('email', $email)->first();

        if ($funcionario) {
            $data = ['email' => $email, 'timestamp' => now()->timestamp];

            $encryptedEmail = Crypt::encryptString(json_encode($data));

            $subdominio = $funcionario->empresa->getDomain();

            return redirect()->away('http://' . $subdominio . ':8000/login_second?token=' . $encryptedEmail)
                ->with('email', $request['email'])->with('senha', $request['senha']);
        }

        return redirect()->away('localhost/login')->with([
            'error' => 'E-mail incorreto. ',
        ]);
    }

    public function loginfirstAdmin(Request $request)
    {

         // Valida os dados de entrada
         $request->validate([
            'email' => 'required|email',

        ]);
        $email = $request['email'];
        // Tentar autenticar o usuário
        $admin = Administradores::where('email', $email)->first();
        if ($admin) {

            $data = ['email' => $email, 'timestamp' => now()->timestamp];
            $encryptedEmail = Crypt::encryptString(json_encode($data));
            return redirect()->away('localhost/loginAdministrativoSecond?token=' . $encryptedEmail)
            ->with('email', $request['email'])->with('senha', $request['senha']);
        }
        else{
            return redirect()->away('localhost/login')->with([
                'error' => 'E-mail incorreto Admin.',
            ]);
        }
    }

    public function identificarTipoUsuario(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request['email'];
        $provedor = Str::after($email, '@');

        if($provedor == 'simplifiqsystem.com'){
            return $this->loginfirstAdmin($request);
        }else{
           return $this->identificarLocatario($request);
        }
    }

    public function formularioLoginTenant(Request $request)
    {
        if (!$request->has('token')) {
            return redirect()->route(route: 'login')->with(['error' => 'Token inválido.']);
        }
        $encryptedToken = $request->query('token');

        try {
            // Desencriptar o email
            $empresa = Empresa_information::first();
            $empresa= $empresa->nome;
            $decryptedData = Crypt::decryptString($encryptedToken);
            $data = json_decode($decryptedData, true);

            $email = $data['email'];
            $timestamp = $data['timestamp'];

            // Verificar se o token expirou (expira em 15 minutos, por exemplo)
            if (now()->timestamp - $timestamp > 300) { // 300 segundos = 5 minutos
                return redirect()->route('login')->json(['error' => 'Token expirado.'], 403);
            }
        } catch (\Exception $e) {
            return redirect()->route(route: 'login')->with(['error' => 'Token inválido ou expirado.']);
        }

        return view('index.login3-2', ['email' => $email, 'empresa' => $empresa]);
    }


    public function loginTenant(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $credentials = $request->only('email', 'senha');

        // Tentar autenticar o usuário
        $funcionario = Funcionarios::where('email', $credentials['email'])->first();

        if ($funcionario && Hash::check($credentials['senha'], $funcionario->senha)) {

            Auth::login($funcionario);
            session(['funcionario' => $funcionario]);
            return redirect()->intended('dashboard');
        }
        if ($funcionario) {
            return redirect()->back()->with([
                'error' => 'Senha incorreta.',
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'O e-mail incorreto.',
            ]);
        }
    }




    /*
        public function handleSubdomainLogin(Request $request)
        {



            // Autentica o funcionário no subdomínio
            $funcionario = Funcionarios::where('email', $request['email'])->first();

            if ($funcionario && Hash::check($request['senha'], $funcionario->senha)) {
                Auth::login($funcionario);
                return redirect()->intended('dashboard'); // Redireciona para o dashboard do subdomínio
            } elseif ($funcionario) {
                return redirect()->away('localhost/login3')->with([
                    'email' => 'Senha incorreta.'
                ]);
            }
            return redirect()->away('localhost/login3')->with([
                'email' => 'E-mail incorreto.',
            ]);
        }

    */

    public function loginSubdominio(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

    }

    public function verificaPrivilegiosAdministrativos()
    {
        $usuarioAtual = auth()->user();
        if ($usuarioAtual->cargo == 'Administrador' || $usuarioAtual->cargo == 'Gerente' || $usuarioAtual->cargo == 'Proprietario') {
            return true;
        } else {
            return false;
        }
    }



}
