<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## O projeto

Este projeto é sobre um Sistema de Cobranças, que tem como objetivo importar arquivos .csv a partir de um formulário de uma aplicação frontend. Este documento fornece informações essenciais sobre o projeto, incluindo como configurar e executar o sistema, bem como detalhes sobre sua estrutura e funcionalidades.

## Visão geral

O Sistema de Cobranças é uma aplicação que permite aos usuários importar arquivos CSV contendo informações de cobranças. A aplicação é composta por uma interface frontend, onde os usuários podem enviar arquivos CSV, e um backend que processa e armazena os dados das cobranças.

## Funcionalidades

- Importação de arquivos CSV: Os usuários podem fazer upload de arquivos CSV contendo informações de cobranças.
- Processamento de arquivos: O backend processa os arquivos CSV, valida os dados e armazena as informações das cobranças em um banco de dados.
- Gera os boletos para cobrança: Para cada usuário o sistema gerar boletos de acordo com o perfil do mesmo.
- Disparar mensagens para os e-mails: Os usuários recebem notificações sobre sua fatural do mês atual.

### Requisitos do Sistema

Certifique-se de que você tenha as seguintes tecnologias e ferramentas instaladas antes de iniciar o projeto:

- Docker.
- Composer: Gerenciador de dependências.
- Um navegador da web moderno (por exemplo, Google Chrome, Firefox).
- Git: Para controle de versão e clonagem do projeto.
- (opcional) Um editor de código de sua escolha (por exemplo, Visual Studio Code).

## Configuração

1. Clone o projeto com o seguinte comando.

```bash
git clone git@github.com:ismael-borges/backend-challenge-boilerplate.git
```

2. Após clonar o projeto execute o seguinte comando para instalar as dependênciais.

```bash
# executar na raiz do projeto
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

3. Copie o arquivo .env.example para o arquivo .env

```bash
# executar na raiz do projeto
cp .ev.example .env
```

## Rodando o projeto

1. Execute o comando a seguir para subir os containers docker

```bash
sail up -d
```

2. Após subir os containers execute o comando a seguir para criar as tabelas no banco de dados

```bash
sail artisan migrate
```

3. **(opcional)** Após criar as tabelas execute este comando para habilitar os agendamentos configurados

```bash
sail artisan schedule:work
```
### **Observações importante do projeto:**

Os agendamentos foram criados para simular um ambiente real de produção onde os usuários iram importar um arquivo .csv e rotinas pré-definidas iram fazer todo o processo de importação.

Para fim de averiguar a performance da importação foi criado o comando

```bash
sail artisan import:csv
```
Após finalizar a importação você pode ir na tabela schedule_imports e verificar a coluna execute_time, nela vai está em segundos quanto tempo o script levou para importar o arquivo.

**Funcionalidade envio de E-mails**

- Sobre o envio de e-mails que é uma das funcionalidades utilizamos o Mailtrap, a fim de demonstrar a funcionalidade limitamos o envio em três e-mails para que o Mailtrap não acabe gerando erro ao receber muitas chamadas.
- Para torar segura a geração do boleto, criamos a criptografia por chave secreta do identificador do cliente que é passado na rota e validado no backend para descifrar e buscar o cliente, em caso de não existir retorna um erro.

**Funcionalidade geração de boletos**

Para gerar os boletos, decidir fazer por demanda. Assim não preciso criar uma novo agendamento consumindo recursos da máquina.

Dentro do e-mail existe um link para o cliente acessar seu boleto e é nesse momento que o boleto é gerado com todas as informações necessárias para gerá-lo

## Pontos de melhorias do projeto

- Permitir que ao gerar boletos as configurações possam ser definidas pelo administrador do sistema
- Criar tokens de autenticação da aplicação frontend para o backend
- Caso inserir novas informações no template do e-mail, criptografar as informações importantes para garantir a segurança delas 

## Bibliotecas utilizadas

- Laravel boleto: https://github.com/eduardokum/laravel-boleto

Usada para gerar todos os boletos dentro da plataforma de forma simples e eficiente.

- League CSV: https://csv.thephpleague.com/

A melhor biblioteca para leitura de arquivos .csv de forma simples e eficiente
