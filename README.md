# 🏍️ Moto Black - Painel Administrativo & API

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

</div>

---

## 📋 Sobre o Projeto

Este repositório contém o **painel administrativo** e **endpoints de API** para os aplicativos do Moto Black, permitindo o gerenciamento completo da plataforma de mototáxis.

### 🔗 Aplicativos Relacionados

- 🚶‍♂️ **[App Passageiro](https://github.com/AlbertoJr789/app-motoblack-cliente)** - Aplicativo para passageiros
- 🏍️ **[App Mototaxista](https://github.com/AlbertoJr789/app-motoblack-mototaxista)** - Aplicativo para mototaxistas

---

## 🛠️ Pré-requisitos

| Software | Versão |
|----------|--------|
| **PHP** | 8.1 - 8.3 |
| **Composer** | 2.8.6+ |
| **Node.js** | 23.10+ |

> 💡 **Dica:** Recomendamos usar o [Laravel Herd](https://herd.laravel.com) para uma instalação mais conveniente de todos os softwares necessários.

---

## ⚙️ Configuração e Instalação

### 1. 📦 Instalar Dependências

```bash
# Instalar dependências PHP
composer install

# Instalar dependências frontend
npm install

# Compilar assets
npm run build
```

### 2. 🔧 Configurar Ambiente

```bash
# Copiar arquivo de ambiente
cp .env.example .env

# Limpar cache de configuração
php artisan config:clear

# Gerar chave da aplicação
php artisan key:generate

# Criar link simbólico para storage
php artisan storage:link
```

### 3. 🗄️ Configurar Banco de Dados

Edite o arquivo `.env` com as seguintes variáveis importantes:

```env
# URL da aplicação (importante para links simbólicos)
APP_URL=http://${IPV4}:8000

# Configurações do Firebase
FIREBASE_URL=https://exemplo-default-rtdb.firebaseio.com

# Chave da API HERE
HERE_API_KEY=djjawdoajw92941924090asdj
```

### 4. 🚀 Executar Migrações

```bash
# Executar migrações
php artisan migrate

# (Opcional) Popular banco com dados de teste
php artisan db:seed
```

> 🔑 **Credenciais de Acesso:** Após executar o seed, você pode acessar com:
> - **Usuário:** `admin`
> - **Senha:** `123123123`

---

## 🚀 Executando a Aplicação

Para expor a aplicação aos aplicativos móveis:

```bash
php artisan serve --host=0.0.0.0
```

> 📱 **Importante:** Use a flag `--host=0.0.0.0` para permitir acesso via rede LAN. Os aplicativos móveis devem estar conectados na mesma rede Wi-Fi do servidor.

---

## 📚 Tecnologias Utilizadas

- **Backend:** Laravel 10, PHP 8.1+
- **Frontend:** Vue.js, Tailwind CSS, Livewire
- **Banco de Dados:** MySQL
- **APIs:** Firebase Realtime Database, HERE Maps API
- **Autenticação:** Laravel Jetstream

---

<div align="center">


</div> 