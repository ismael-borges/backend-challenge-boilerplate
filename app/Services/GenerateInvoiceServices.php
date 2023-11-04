<?php

namespace App\Services;

use App\Models\PaymentProjection;
use Carbon\Carbon;

class GenerateInvoiceServices
{
    private PaymentProjection $payer;
    private string $path = '';

    public function __construct()
    {
        $this->path = public_path('assets/images/invoices/logo-bb.png');

        $identifier = request()->route('id');
        $this->payer = PaymentProjection::find($identifier);
    }

    /**
     * @throws \Exception
     */
    public function generateInvoice(): void
    {
        $recipient = $this->generateRecipient();
        $paymaster = $this->generatePaymaster();

        $bb = new \Eduardokum\LaravelBoleto\Boleto\Banco\Bb([
            'logo' => $this->path,
            'dataVencimento' => Carbon::make($this->payer->debtDueDate),
            'valor' => $this->payer->debtAmount,
            'numero' => 1,
            'numeroDocumento' => 1,
            'pagador' => $paymaster,
            'beneficiario' => $recipient,
            'carteira' => 11,
            'agencia' => 1111,
            'convenio' => 1231237,
            'conta' => 22222,
            'multa' => 2,
            'juros' => 1,
            'jurosApos' => 0,
            'descricaoDemonstrativo' => [],
            'instrucoes' => [
                'Instruções (texto de responsabilidade do Cedente)',
                'AO REALIZAR O PAGAMENTO SEMPRE CONFIRME (CNPJ E NOME DO BENEFICIÁRIO)',
                'E JUROS AO MÊS DE 1% APÓS 10 DIAS DO VENCIMENTO ATUALIZAR O BOLETO',
                'ACRESCIMO DA MULTA, JUROS, CORREÇÃO, E ENCARGOS CONTRATUAIS',
                'Após o vecimento cobrar multa de 2%, O banco receberá até o dia 20 de cada mês.',
                'Este documento não quita e/ou declara o imóvel isento de débito(s) anteriore(s).',
            ]
        ]);

        $pdf = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();
        $pdf->addBoleto($bb);
        $pdf->gerarBoleto();
    }

    private function generateRecipient(): \Eduardokum\LaravelBoleto\Pessoa
    {
        return new \Eduardokum\LaravelBoleto\Pessoa([
            'documento' => '41.702.844/0001-61',
            'nome'      => 'Boilerplate companie',
            'cep'       => '45604-122',
            'endereco'  => 'Rua Benígno Alves',
            'bairro' => 'Nossa Senhora de Fátima',
            'uf'        => 'BA',
            'cidade'    => 'Itabuna',
        ]);
    }

    private function generatePaymaster(): \Eduardokum\LaravelBoleto\Pessoa
    {
        return new \Eduardokum\LaravelBoleto\Pessoa([
            'documento' => '495.488.680-59',
            'nome'      => $this->payer->name,
            'cep'       => '13456-409',
            'endereco'  => 'Rua do Mercúrio',
            'bairro' => 'Jardim Pântano',
            'uf'        => 'SP',
            'cidade'    => 'Santa Bárbara Do Oeste',
        ]);
    }
}
