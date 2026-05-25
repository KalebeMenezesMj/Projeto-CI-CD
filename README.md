# 🌸 Flores & Sonhos — E-commerce Laravel

E-commerce completo para floricultura desenvolvido com Laravel 10.

## ✨ Funcionalidades

### Loja (Frontend)
- **Home** com banner hero, produtos em destaque, categorias e novidades
- **Catálogo de Produtos** com filtros por categoria, faixa de preço e busca
- **Página de Produto** com galeria, preço promocional, contador de estoque
- **Carrinho** para visitantes (sessão) e usuários logados (banco de dados)
- **Merge de carrinho** ao fazer login
- **Checkout** com busca automática de CEP (ViaCEP)
- **Página de sucesso** com resumo do pedido
- **Meus Pedidos** com timeline de status
- **Perfil** com dados pessoais, senha e gerenciamento de endereços

### Painel Admin
- **Dashboard** com métricas e gráficos
- **CRUD de Produtos** com upload de imagem, preço promocional, estoque
- **CRUD de Categorias** com ordem de exibição
- **Gerenciamento de Pedidos** com atualização de status e pagamento

### Autenticação
- Login, cadastro, logout
- Recuperação de senha por e-mail
- Middleware para área admin

### Pagamentos (simulado)
- Cartão de Crédito (até 3x sem juros)
- PIX (aprovação imediata)
- Boleto (vence em 3 dias)

---

## 🚀 Instalação

### Requisitos
- PHP 8.1 ou superior
- Composer
- MySQL 8.0+ (ou SQLite para desenvolvimento)

### Passo a passo

**1. Clone ou extraia o projeto**

**2. Instale as dependências**
```bash
composer install
```

**3. Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure o banco de dados no `.env`**

**Para MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=floricultura
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

**Para SQLite (mais simples):**
```env
DB_CONNECTION=sqlite
```
```bash
# Crie o arquivo SQLite
touch database/database.sqlite
# No Windows:
type nul > database\database.sqlite
```

**5. Execute as migrations e seeders**
```bash
php artisan migrate --seed
```

**6. Crie o link de storage**
```bash
php artisan storage:link
```

**7. Inicie o servidor**
```bash
php artisan serve
```

**8. Acesse: [http://localhost:8000](http://localhost:8000)**

---

## 🔑 Credenciais de Acesso

| Tipo | E-mail | Senha |
|------|--------|-------|
| Admin | admin@floresesonhos.com.br | admin123 |
| Cliente | cliente@teste.com | cliente123 |

Painel Admin: [http://localhost:8000/admin](http://localhost:8000/admin)

---

## 📁 Estrutura do Projeto

```
projetoLaravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # CRUD admin
│   │   │   ├── Auth/           # Autenticação
│   │   │   ├── CartController  # Carrinho
│   │   │   ├── CheckoutController
│   │   │   ├── HomeController
│   │   │   ├── OrderController
│   │   │   └── ProductController
│   │   └── Middleware/
│   │       └── AdminMiddleware  # Proteção área admin
│   └── Models/
│       ├── User, Category, Product
│       ├── Cart, CartItem
│       └── Order, OrderItem, Address
├── database/
│   ├── migrations/             # 11 migrations
│   └── seeders/                # Dados de exemplo
└── resources/views/
    ├── layouts/                # app.blade.php, admin.blade.php
    ├── home.blade.php
    ├── products/
    ├── cart/
    ├── checkout/
    ├── orders/
    ├── profile/
    ├── auth/
    └── admin/
```

---

## 🗄️ Banco de Dados

| Tabela | Descrição |
|--------|-----------|
| users | Usuários e admins |
| categories | Categorias de flores |
| products | Produtos com preços e estoque |
| carts | Carrinhos (usuário ou sessão) |
| cart_items | Itens do carrinho |
| orders | Pedidos finalizados |
| order_items | Itens de cada pedido |
| addresses | Endereços dos usuários |

---

## 🎨 Design

- Bootstrap 5 via CDN
- Font Awesome para ícones
- Tema rosa/rosa/verde (floral)
- Google Fonts: Playfair Display + Lato
- Design responsivo mobile-first

---

## 💡 Próximos Passos Sugeridos

- Integração com gateway de pagamento (Mercado Pago, PagSeguro)
- Notificações por e-mail (pedido confirmado, status atualizado)
- Avaliações de produtos
- Cupons de desconto
- Sistema de frete por CEP (Melhor Envio, Correios)
- Dashboard com gráficos de vendas
- Exportação de pedidos em PDF

---

Desenvolvido com ❤️ e 🌸
