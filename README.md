
<body>

  <div class="section">
    <div class="emoji-title">👨‍💼 <strong>Projeto RH</strong></div>
    <p>Sistema completo de Recursos Humanos, desenvolvido com <span class="highlight">Laravel (backend)</span> e <span class="highlight">Vue.js (frontend)</span>, focado na gestão de colaboradores.</p>
  </div>

  <div class="section">
    <div class="emoji-title">🧰 Tecnologias Utilizadas</div>
    <ul>
      <li>⚙️ <strong>Backend:</strong> Laravel (PHP)</li>
      <li>🖥️ <strong>Frontend:</strong> Vue.js</li>
      <li>🗄️ <strong>Banco de Dados:</strong> MySQL</li>
      <li>🔐 <strong>APIs REST</strong> para comunicação entre frontend e backend</li>
    </ul>
  </div>

  <div class="section">
    <div class="emoji-title">📋 Descrição Geral</div>
    <p>Este projeto tem como objetivo construir um <strong>sistema de RH eficiente, intuitivo e seguro</strong>. A plataforma possibilita o gerenciamento completo de informações de colaboradores.</p>
  </div>

  <div class="section">
    <div class="emoji-title">✅ Funcionalidades Implementadas</div>
    <ul>
      <li>🧑‍💼 <strong>CRUD completo de:</strong></li>
      <ul>
        <li>Colaboradores</li>
      </ul>
      <li>🔄 Integração entre frontend e backend via APIs REST</li>
      <li>🔐 Rotas protegidas para garantir a segurança do sistema</li>
      <li>🎨 Interfaces desenvolvidas com base em protótipos visuais</li>
      <li>💬 Comunicação eficiente entre camadas front e back</li>
    </ul>
  </div>

  <div class="section">
    <div class="emoji-title">📦 Como Rodar Localmente</div>
    <p>Siga os passos abaixo para executar o projeto:</p>
    <div class="code-block">
      git clone https://github.com/WagnerK4uan/projeto-rh.git<br>
      cd projeto-rh<br>
      composer install<br>
      cp .env.example .env<br>
      php artisan key:generate<br>
      php artisan migrate<br>
      php artisan serve<br>
 npm install<br>
    npm run dev
    </div>
  <br>  <p><strong>💡 Dica:</strong> Certifique-se de ter o MySQL rodando e o arquivo <code>.env</code> configurado corretamente com suas credenciais de banco de dados.</p>
  </div>

  <div class="section">
    <div class="emoji-title">🧪 Executando Testes</div>
    <div class="code-block">
      php artisan test
    </div>
  </div>

</body>
</html>
