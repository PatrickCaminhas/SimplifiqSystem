<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class CpfCripto
{
    /**
     * Criptografa um CPF
     */
    public static function encriptarCPF(string $cpf): string
    {
        return Crypt::encryptString($cpf);
    }

    /**
     * Descriptografa um CPF
     */
    public static function desencriptarCPF(string $encryptedCpf): string
    {
        try {
            $cpf = Crypt::decryptString($encryptedCpf);
            return $cpf; // Retorna o CPF descriptografado (apenas números)
        } catch (DecryptException $e) {
            // Trate a exceção conforme sua necessidade (ex: log, erro, etc.)
            throw new \Exception("Falha ao descriptografar CPF: " . $e->getMessage());
        }
    }
}
