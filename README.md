# 🎬 My Little Cine

Sistema web de gerenciamento de cinema e reserva de ingressos desenvolvido em **PHP** e **MySQL**, com uma identidade visual temática retrô-pixelada. Este projeto faz parte do desenvolvimento acadêmico em Téc. em Sistemas Development.

---

## 🛠️ Tecnologias Utilizadas

* **Linguagens:** PHP (Backend), HTML5, CSS3 (Frontend)
* **Banco de Dados:** MySQL / MariaDB (com uso de `mysqli` e Prepared Statements)
* **Controle de Versão:** Git & GitHub
* **Estilização:** Variáveis CSS globais (`variaveis.css`, `estilo.css`) e folhas de estilo modulares por página.

---

## 📁 Estrutura do Projeto

```text
my_little_cine/
│
├── conexao/
│   └── conexao.php          # Conexão centralizada com o banco de dados MySQL
├── css/
│   ├── variaveis.css        # Variáveis globais de cores, fontes e espaçamentos
│   ├── estilo.css           # Estilos globais e layout base (Header/Footer)
│   ├── login.css            # Estilo da página de Login
│   ├── cadastro.css         # Estilo da página de Cadastro
│   ├── perfil.css           # Estilo da página de Perfil do Usuário
│   ├── editar_perfil.css    # Estilo do formulário de edição de perfil
│   ├── assentos.css         # Estilo da grade de seleção de poltronas
│   ├── geren_filmes.css     # Estilo do painel admin de filmes
│   ├── geren_sessoes.css    # Estilo do painel admin de sessões
│   └── index_admin.css      # Estilo do menu do painel administrativo
├── imagens/
│   └── home_icone.png       # Ícones e assets visuais
├── admin/
│   ├── index_admin.php      # Menu principal da área administrativa
│   ├── geren_filmes.php     # Cadastro, edição, listagem e exclusão de filmes
│   ├── geren_sessoes.php    # Gestão de horários, datas, preços, salas e idiomas
│   └── geren_usuarios.php   # Gestão e controle de usuários cadastrados
├── index_usuario.php        # Página inicial / Vitrine do cinema
├── login.php                # Tela de autenticação de usuários
├── cadastrar.php            # Tela de criação de novas contas
├── perfil.php               # Exibição dos dados do usuário logado
├── editar.php               # Processamento e formulário de alteração de dados
├── assentos.php             # Seleção interativa de poltronas da sessão
├── processar_reserva.php    # Script intermediário de reserva e atualização de assentos
├── ingressos.php            # Tela de resumo e conclusão do ingresso
└── logout.php               # Encerramento de sessão do usuário