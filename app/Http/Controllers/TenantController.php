<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Funcionarios;
use App\Models\Empresas;
use Illuminate\Support\Facades\Hash;


class TenantController extends Controller
{
    public function create()
    {
        return view('administracao\criarTenant');
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
    public function createTenant(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'cnpj' => 'required|string',
        ]);

        $nome = $request->input('nome');
        $cnpj = $request->input('cnpj');

               // Função para remover espaços e substituir caracteres especiais
        $nomeSanitizado = $this->sanitizeString($nome);
        // Verifica se um nome foi fornecido
        if (!$nomeSanitizado) {
            return response()->json(['message' => 'Nenhum nome de tenant fornecido.'], 400);
        }

        $funcionario = Funcionarios::where('cnpj', $cnpj)->first();
        
        $empresa = Empresas::where('cnpj', $cnpj)->update([
            'estado' => 'ativa',
        ]);

        // Cria o tenant com o nome fornecido
        $tenant = Tenant::create(['id' => $nomeSanitizado]);
        $tenant->domains()->create(['domain' => "{$nomeSanitizado}.localhost"]);

        // Usa o contexto do tenant para adicionar o funcionário admin
        tenancy()->initialize($tenant);

        do {
            $id_funcionario = mt_rand(100, 999);
        } while (Funcionarios::where('id', $id_funcionario)->exists());

        // Adiciona o funcionário admin na tabela funcionarios do tenant
        Funcionarios::create([
            'id' => $id_funcionario,
            'nome' => $funcionario->nome,
            'sobrenome' => $funcionario->sobrenome,
            'cargo' => 'Administrador',
            'email' => $funcionario->email,
            'senha' => Hash::make('password'), // Certifique-se de hash a senha corretamente
        ]);

        // Limpa o contexto do tenant
        tenancy()->end();

        // Retorna uma resposta de sucesso
        return response()->json(['message' => "Tenant {$nomeSanitizado} foi criado com sucesso com o domínio {$nomeSanitizado}.localhost"]);
    }
}
