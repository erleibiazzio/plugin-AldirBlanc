<?php

return [
    'header' =>[       
        'CPF',
        'NOME_SOCIAL', 
        'CNPJ',
        'RAZAO_SOCIAL',             
        'LOGRADOURO',
        'NUMERO',
        'COMPLEMENTO',
        'BAIRRO',
        'MUNICIPIO',
        'CEP',
        'ESTADO',
        'NUM_BANCO',
        'TIPO_CONTA_BANCO',        
        'AGENCIA_BANCO',
        'CONTA_BANCO',
        'OPERACAO_BANCO',
        'VALOR',
        'INSCRICAO_ID',
        'INCISO',
    ],
    'fields' => [        
        'CPF' => 'CPF DO RESPONSÁVEL PELO ESPAÇO CULTURAL, EMPRESA, ENTIDADE OU COOPERATIVA CULTURAL:',
        'NOME_SOCIAL' => 'NOME COMPLETO DO RESPONSÁVEL PELO ESPAÇO CULTURAL, EMPRESA, ENTIDADE OU COOPERATIVA CULTURAL:', 
        'CNPJ' => ['NÚMERO DE INSCRIÇÃO EM CADASTRO NACIONAL DE PESSOA JURÍDICA – CNPJ:'],
        'RAZAO_SOCIAL' => ['RAZÃO SOCIAL DA ENTIDADE, EMPRESA OU DA COOPERATIVA CULTURAL:'],                
        'LOGRADOURO' => 'ENDEREÇO COMPLETO DO RESPONSÁVEL PELO ESPAÇO CULTURAL, EMPRESA, ENTIDADE OU COOPERATIVA CULTURAL:',
        'NUMERO' => 'ENDEREÇO COMPLETO DO RESPONSÁVEL PELO ESPAÇO CULTURAL, EMPRESA, ENTIDADE OU COOPERATIVA CULTURAL:',
        'COMPLEMENTO' => 'ENDEREÇO COMPLETO DO RESPONSÁVEL PELO ESPAÇO CULTURAL, EMPRESA, ENTIDADE OU COOPERATIVA CULTURAL:',
        'BAIRRO' => 'ENDEREÇO COMPLETO DO RESPONSÁVEL PELO ESPAÇO CULTURAL, EMPRESA, ENTIDADE OU COOPERATIVA CULTURAL:',
        'MUNICIPIO' => 'ENDEREÇO COMPLETO DO RESPONSÁVEL PELO ESPAÇO CULTURAL, EMPRESA, ENTIDADE OU COOPERATIVA CULTURAL:',
        'CEP' => 'ENDEREÇO COMPLETO DO RESPONSÁVEL PELO ESPAÇO CULTURAL, EMPRESA, ENTIDADE OU COOPERATIVA CULTURAL:',
        'ESTADO' => 'ENDEREÇO COMPLETO DO RESPONSÁVEL PELO ESPAÇO CULTURAL, EMPRESA, ENTIDADE OU COOPERATIVA CULTURAL:',
        'NUM_BANCO' => 'BANCO:' ,
        'TIPO_CONTA_BANCO' => 'TIPO DE CONTA BANCÁRIA:',        
        'AGENCIA_BANCO' => 'AGÊNCIA',
        'CONTA_BANCO'  => 'NÚMERO DA CONTA:',
        'OPERACAO_BANCO'  => 'NÚMERO DA OPERAÇÃO SE HOUVER',
        'VALOR' => '600',        
        'INCISO' => 1288,
    ],
    'parameters_default' => [
        'status' => '10'
    ],
    'categories' => [
        'CPF' => [
            'BENEFICIÁRIO COM CPF E ESPAÇO FÍSICO',
            'BENEFICIÁRIO COM CPF E ESPAÇO FÍSICO'
        ],
        'CNPJ' => [
            'BENEFICIÁRIO COM CNPJ E ESPAÇO FÍSICO',
            'BENEFICIÁRIO COM CNPJ E SEM ESPAÇO FÍSICO'
        ]
    ]
        

];