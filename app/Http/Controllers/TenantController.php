<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Funcionarios;
use App\Models\Empresas;
use App\Models\Empresa_information;
use App\Models\Produtos_categoria;
use App\Models\Clientes; // Add this line to import the 'Clientes' class
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
            'senha' => $funcionario->senha, // Certifique-se de hash a senha corretamente
        ]);

        Empresa_information::create([
            'cnpj' => $cnpj,
            'nome' => $nome,
            'tamanho_empresa' => $request->tamanho_empresa,
            'tipo_empresa' => $request->tipo_empresa,
            'telefone' => $request->telefone,
            'estado' => 'ativa',
            'padrao_cores' => 'azul',
            'dominio' => $nomeSanitizado,
        ]);

        $this->criarClienteNaoCadastrado();
        $this->criarCategorias($request->tipo_empresa);

        // Limpa o contexto do tenant
        tenancy()->end();

        // Retorna uma resposta de sucesso
        return response()->json(['message' => "Tenant {$nomeSanitizado} foi criado com sucesso com o domínio {$nomeSanitizado}.localhost"]);
    }

    public function criarClienteNaoCadastrado()
    {
        Clientes::create([
            'id' => 1,
            'nome' => 'Cliente Não cadastrado',
            'cpfOuCnpj' => '00000000000',
            'telefone' => '00000000000',
            'email' => '',
            'endereco_completo' => '',
            'debitos' => 0,
            'observacoes' => '',
        ]);
    }

    public function criarCategorias($tipo_empresa)
    {
        if ($tipo_empresa == "alimentosEbebidas") {
            Produtos_categoria::create([
                'nome' => 'Cereais e Grãos',
            ]);
            Produtos_categoria::create([
                'nome' => 'Carnes e frios',
            ]);
            Produtos_categoria::create([
                'nome' => 'Hortifruti',
            ]);
            Produtos_categoria::create([
                'nome' => 'Bebidas alcoólicas',
            ]);
            Produtos_categoria::create([
                'nome' => 'Bebidas não alcoólicas',
            ]);
            Produtos_categoria::create([
                'nome' => 'Doces e Sobremesas',
            ]);
        } else if ($tipo_empresa == "agropecuarios") {
            Produtos_categoria::create([
                'nome' => 'Alimentação Animal',
            ]);
            Produtos_categoria::create([
                'nome' => 'Fertilizantes e adubo',
            ]);
            Produtos_categoria::create([
                'nome' => 'Sementes e Mudas',
            ]);
            Produtos_categoria::create([
                'nome' => 'Medicamentos Veterinários',
            ]);
            Produtos_categoria::create([
                'nome' => 'Defensivos Agrícolas',
            ]);
            Produtos_categoria::create([
                'nome' => 'Produtos para Jardinagem',
            ]);
        } else if ($tipo_empresa == "atacado") {
            Produtos_categoria::create([
                'nome' => 'Alimentos e Bebidas',
            ]);
            Produtos_categoria::create([
                'nome' => 'Produtos de Limpeza',
            ]);
            Produtos_categoria::create([
                'nome' => 'Produtos de Higiene e cuidados pessoais',
            ]);
            Produtos_categoria::create([
                'nome' => 'Eletrônicos',
            ]);
            Produtos_categoria::create([
                'nome' => 'Móveis e Decoração',
            ]);
            Produtos_categoria::create([
                'nome' => 'Embalagens e Descartáveis',
            ]);


        } else if ($tipo_empresa == "autopecas") {
            Produtos_categoria::create([
                'nome' => 'Peças de Motor',
            ]);
            Produtos_categoria::create([
                'nome' => 'Baterias e Acessórios Elétricos',
            ]);

            Produtos_categoria::create([
                'nome' => 'Pneus e Rodas',
            ]);

            Produtos_categoria::create([
                'nome' => 'Peças de Suspensão e Direção',
            ]);

            Produtos_categoria::create([
                'nome' => 'Peças de Freio',
            ]);

            Produtos_categoria::create([
                'nome' => 'Óleos e Lubrificantes',
            ]);
            Produtos_categoria::create([
                'nome' => 'Produtos de Manutenção e Limpeza Automotiva',
            ]);
            Produtos_categoria::create([
                'nome' => 'Acessórios Internos e Externos',
            ]);

        } else if ($tipo_empresa == "construcao") {
            Produtos_categoria::create([
                'nome' => 'Materiais de Construção',
            ]);
            Produtos_categoria::create([
                'nome' => 'Ferramentas',
            ]);
            Produtos_categoria::create([
                'nome' => 'Elétrica',
            ]);
            Produtos_categoria::create([
                'nome' => 'Hidráulica',
            ]);
            Produtos_categoria::create([
                'nome' => 'Tintas e Acessórios',
            ]);
            Produtos_categoria::create([
                'nome' => 'Pisos e Azulejos',
            ]);
            Produtos_categoria::create([
                'nome' => 'Portas e Janelas',
            ]);
            Produtos_categoria::create([
                'nome' => 'Telhas e Materiais de Cobertura',
            ]);
        } else if ($tipo_empresa == "livrosJornaisPapelaria") {
            Produtos_categoria::create([
                'nome' => 'Livros',
            ]);
            Produtos_categoria::create([
                'nome' => 'Revistas',
            ]);
            Produtos_categoria::create([
                'nome' => 'Papelaria',
            ]);
            Produtos_categoria::create([
                'nome' => 'Material de Escritório',
            ]);
            Produtos_categoria::create([
                'nome' => 'Material Escolar',
            ]);
            Produtos_categoria::create([
                'nome' => 'Material para Desenho e Pintura',
            ]);

        } else if ($tipo_empresa == "moveis") {
            Produtos_categoria::create([
                'nome' => 'Sala de Estar',
            ]);
            Produtos_categoria::create([
                'nome' => 'Sala de Jantar',
            ]);
            Produtos_categoria::create([
                'nome' => 'Quarto',
            ]);
            Produtos_categoria::create([
                'nome' => 'Cozinha',
            ]);
            Produtos_categoria::create([
                'nome' => 'Escritório',
            ]);
            Produtos_categoria::create([
                'nome' => 'Banheiro',
            ]);
            Produtos_categoria::create([
                'nome' => 'Área Externa',
            ]);
            Produtos_categoria::create([
                'nome' => 'Decoração',
            ]);

        } else if ($tipo_empresa == "farmaceuticos") {
            Produtos_categoria::create([
                'nome' => 'Medicamentos',
            ]);
            Produtos_categoria::create([
                'nome' => 'Suplementos Alimentares',
            ]);
            Produtos_categoria::create([
                'nome' => 'Higiene Pessoal',
            ]);
            Produtos_categoria::create([
                'nome' => 'Cosméticos e Dermocosméticos',
            ]);
            Produtos_categoria::create([
                'nome' => 'Cuidados com Bebês',
            ]);
            Produtos_categoria::create([
                'nome' => 'Equipamentos Médicos',
            ]);

        } else if ($tipo_empresa == "informatica") {
            Produtos_categoria::create([
                'nome' => 'Computadores e Notebooks',
            ]);
            Produtos_categoria::create([
                'nome' => 'Periféricos e Acessórios',
            ]);
            Produtos_categoria::create([
                'nome' => 'Impressoras e Multifuncionais',
            ]);
            Produtos_categoria::create([
                'nome' => 'Softwares',
            ]);
            Produtos_categoria::create([
                'nome' => 'Redes e Conectividade',
            ]);
            Produtos_categoria::create([
                'nome' => 'Armazenamento',
            ]);
            Produtos_categoria::create([
                'nome' => 'Gamer',
            ]);
            Produtos_categoria::create([
                'nome' => 'Hardware',
            ]);

        } else if ($tipo_empresa == "vestuario") {
            Produtos_categoria::create([
                'nome' => 'Masculino',
            ]);
            Produtos_categoria::create([
                'nome' => 'Feminino',
            ]);
            Produtos_categoria::create([
                'nome' => 'Infantil',
            ]);
            Produtos_categoria::create([
                'nome' => 'Calçados',
            ]);
            Produtos_categoria::create([
                'nome' => 'Acessórios',
            ]);
            Produtos_categoria::create([
                'nome' => 'Moda Praia',
            ]);
            Produtos_categoria::create([
                'nome' => 'Moda Íntima',
            ]);
            Produtos_categoria::create([
                'nome' => 'Moda Fitness',
            ]);
        }
    }

}
