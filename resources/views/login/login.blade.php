<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG</title>

  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:wght@400;500&display=swap"
    rel="stylesheet" />

  <style>
    :root {
      --primary: #2E7D32;
      --primary-dk: #66BB6A;
      --primary-lt: #f5fae8;
      --text-dark: #1C1210;
      --text-mid: #5A4A43;
      --text-light: #9E8880;
      --border: rgba(0, 0, 0, 0.10);
      /* Overlay */
      --overlay-start: rgba(41, 206, 68, 0.50);
      --overlay-end: rgba(18, 104, 33, 0.72);
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #F5F0EE;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }

    /* ── Card wrapper ─────────────────────────────── */
    .login-card {
      display: flex;
      width: 100%;
      max-width: 980px;
      min-height: 580px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 24px 64px rgba(90, 30, 10, 0.18);
    }

    /* ── LEFT PANEL ───────────────────────────────── */
    .panel-left {
      flex: 0 0 48%;
      background: #fff;
      display: flex;
      flex-direction: column;
      padding: 2.8rem 3rem;
    }

    .logo-wrap {
      display: flex;
      align-items: center;
      gap: 11px;
      margin-bottom: 2.8rem;
    }

    .logo-icon {
      width: 46px;
      height: 46px;
      background: var(--primary);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .logo-label {
      line-height: 1;
    }

    .logo-label .brand {
      font-family: 'Sora', sans-serif;
      font-size: 18px;
      font-weight: 700;
      color: var(--text-dark);
      letter-spacing: 0.5px;
    }

    .logo-label .sub {
      font-size: 11px;
      color: var(--text-light);
    }

    .form-section {
      flex: 1;
    }

    .form-section h2 {
      font-family: 'Sora', sans-serif;
      font-size: 22px;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 6px;
    }

    .form-section p.lead-text {
      font-size: 13.5px;
      color: var(--text-light);
      margin-bottom: 2rem;
    }

    .form-label {
      font-size: 12.5px;
      font-weight: 500;
      color: var(--text-mid);
      margin-bottom: 5px;
    }

    .form-control {
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px 14px;
      font-size: 14px;
      color: var(--text-dark);
      background: #FAFAF9;
      transition: border-color .2s, box-shadow .2s;
    }

    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3.5px rgba(232, 98, 42, 0.13);
      background: #fff;
    }

    .form-control::placeholder {
      color: #C3B8B4;
    }

    .input-icon-wrap {
      position: relative;
    }

    .input-icon-wrap .field-icon {
      position: absolute;
      right: 13px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
      cursor: pointer;
      transition: color .2s;
    }

    .input-icon-wrap .field-icon:hover {
      color: var(--primary);
    }

    .forgot {
      font-size: 12.5px;
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
    }

    .forgot:hover {
      text-decoration: underline;
    }

    .btn-primary-custom {
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 13px;
      font-size: 14.5px;
      font-weight: 600;
      width: 100%;
      letter-spacing: 0.3px;
      transition: background 2s, transform .1s;
    }

    .btn-primary-custom:hover {
      background: var(--primary-dk);
    }

    .btn-primary-custom:active {
      transform: scale(0.98);
    }

    /* ── Footer / Suporte ─────────────────────────── */
    .footer-section {
      margin-top: auto;
      padding-top: 1.8rem;
    }

    .divider-label {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 1rem;
    }

    .divider-label::before,
    .divider-label::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    .divider-label span {
      font-size: 12px;
      color: var(--text-light);
      white-space: nowrap;
    }

    .btn-suporte {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: 1px solid var(--border);
      border-radius: 999px;
      padding: 8px 20px;
      font-size: 13px;
      color: var(--text-mid);
      background: transparent;
      text-decoration: none;
      transition: border-color .2s, color .2s, background .2s;
    }

    .btn-suporte:hover {
      border-color: #25D366;
      color: #1a9e50;
      background: #f0faf4;
    }

    /* ── RIGHT PANEL ──────────────────────────────── */
    .panel-right {
      flex: 1;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: flex-end;
    }

    .right-bg {
      position: absolute;
      inset: 0;
      background: url('/image/login-milho.png') center/cover no-repeat;
    }

    .right-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(160deg,

          var(--overlay-start) 0%,
          var(--overlay-end) 100%);
    }

    .right-content {
      position: relative;
      z-index: 2;
      padding: 2.4rem 2.4rem 2.8rem;
    }

    .tag-pill {
      display: inline-block;
      background: var(--primary);
      color: #fff;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
      padding: 4px 12px;
      border-radius: 999px;
      margin-bottom: 14px;
      text-transform: uppercase;
    }

    .right-headline {
      font-family: 'Sora', sans-serif;
      font-size: 28px;
      font-weight: 700;
      color: #fff;
      line-height: 1.25;
      margin-bottom: 16px;
      text-shadow: 0 1px 4px rgba(0, 0, 0, 0.25);
    }

    .right-headline .hl {
      background: var(--primary);
      border-radius: 6px;
      padding: 1px 9px;
    }

    .right-desc {
      display: flex;
      gap: 10px;
      align-items: flex-start;
    }

    .right-desc .arrow {
      color: var(--primary);
      font-size: 15px;
      flex-shrink: 0;
      margin-top: 2px;
    }

    .right-desc p {
      font-size: 13.5px;
      color: rgba(255, 255, 255, 0.90);
      line-height: 1.65;
      margin: 0;
    }

    /* ── Animations ───────────────────────────────── */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(18px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .anim-1 {
      animation: fadeUp .5s ease both;
    }

    .anim-2 {
      animation: fadeUp .5s .10s ease both;
    }

    .anim-3 {
      animation: fadeUp .5s .20s ease both;
    }

    .anim-4 {
      animation: fadeUp .5s .30s ease both;
    }

    .anim-5 {
      animation: fadeUp .5s .40s ease both;
    }

    .anim-6 {
      animation: fadeUp .5s .50s ease both;
    }

    /* ── Responsive ───────────────────────────────── */
    @media (max-width: 720px) {
      .login-card {
        flex-direction: column;
        min-height: unset;
        max-width: 440px;
      }

      .panel-right {
        min-height: 220px;
      }

      .panel-left {
        padding: 2rem 1.8rem;
      }
    }
  </style>
</head>

<body>

  <div class="login-card">

    <!-- ── LEFT ──────────────────────────────────── -->
    <div class="panel-left">

      <!-- Logo -->
      <div class="logo-wrap anim-1">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1020 340" width="70%" height="70%">
          <defs>
            <style>
              :root {
                --cor-principal: var(--primary);
              }

              .fundo-mutavel {
                fill: var(--cor-principal);
              }

              .detalhe-mutavel-fill {
                fill: var(--cor-principal);
              }

              .detalhe-mutavel-stroke {
                stroke: var(--cor-principal);
              }

              .texto-principal {
                font-family: 'Arial Black', Arial, sans-serif;
                font-weight: 900;
                fill: #000000;
              }

              .texto-secundario {
                font-family: Arial, sans-serif;
                font-weight: 300;
                fill: #6d6e71;
              }
            </style>
          </defs>

          <circle cx="170" cy="170" r="145" class="fundo-mutavel" />

          <g fill="#ffffff" stroke="#ffffff" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round">
            <circle cx="118" cy="188" r="48" fill="none" stroke-width="6" />
            <circle cx="118" cy="188" r="35" fill="none" stroke-width="4.5" />
            <circle cx="118" cy="188" r="16" fill="#ffffff" />
            <path
              d="M 118 135 L 118 144 M 118 232 L 118 241 M 65 188 L 74 188 M 162 188 L 171 188 M 81 151 L 88 157 M 155 219 L 162 225 M 81 225 L 88 219 M 155 151 L 162 157"
              stroke-width="6" />

            <path d="M 68 185 C 68 140, 108 120, 160 128 C 171 132, 174 144, 174 151" fill="none" stroke-width="6" />

            <circle cx="231" cy="204" r="26" fill="none" stroke-width="5" />
            <circle cx="231" cy="204" r="10" fill="#ffffff" />
            <path
              d="M 231 174 L 231 180 M 231 228 L 231 234 M 201 204 L 207 204 M 255 204 L 261 204 M 210 183 L 214 187 M 248 221 L 252 225 M 210 225 L 214 221 M 248 183 L 252 187"
              stroke-width="4" />

            <path
              d="M 117 125 L 117 105 C 117 102, 120 99, 125 99 L 176 99 C 181 99, 184 102, 185 107 L 202 157 L 176 157"
              fill="none" stroke-width="6" />
            <path d="M 144 99 L 144 128 L 187 128" fill="none" stroke-width="4" />
            <path d="M 176 99 L 188 128" fill="none" stroke-width="4" />

            <path d="M 174 151 L 246 156 C 252 156, 254 159, 254 165 L 254 197 L 202 197 Z" fill="#ffffff" />

            <rect x="168" y="173" width="18" height="9" fill="none" stroke-width="4.5" />
            <rect x="168" y="185" width="18" height="7" fill="none" stroke-width="4.5" />

            <path d="M 223 156 L 223 125 C 223 119, 219 117, 219 113 L 220 107" fill="none" stroke-width="4.5" />

            <ellipse cx="239" cy="171" rx="6" ry="4" class="detalhe-mutavel-fill" stroke="none" />
            <line x1="212" y1="170" x2="212" y2="188" class="detalhe-mutavel-stroke" stroke-width="4" />
            <line x1="220" y1="170" x2="220" y2="188" class="detalhe-mutavel-stroke" stroke-width="4" />
            <line x1="228" y1="170" x2="228" y2="188" class="detalhe-mutavel-stroke" stroke-width="4" />
          </g>

          <text x="345" y="178" font-size="115" class="texto-principal" letter-spacing="-2">SIAG</text>
          <text x="340" y="255" font-size="51" class="texto-secundario" letter-spacing="1">Agricola Cooperativas</text>
        </svg>

      </div>

      <!-- Form -->
      <div class="form-section">
        <h2 class="anim-2">Seja Bem-vindo </h2>
        <p class="lead-text anim-2">Acesse sua conta para continuar</p>

        <div class="mb-3 anim-3">
          <label class="form-label" for="email">E-mail</label>
          <div class="input-icon-wrap">
            <input type="email" id="email" name="email" class="form-control pe-5" placeholder="seu@email.com.br" />
            <span class="field-icon">
              <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="2" y="4" width="20" height="16" rx="3" />
                <path d="M2 7l10 7 10-7" />
              </svg>
            </span>
          </div>
        </div>

        <div class="mb-1 anim-4">
          <label class="form-label" for="senha">Senha de Acesso</label>
          <div class="input-icon-wrap">
            <input type="password" id="senha" name="password" class="form-control pe-5" placeholder="••••••••" />
            <span class="field-icon" id="togglePwd">
              <svg id="eyeOpen" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8"
                viewBox="0 0 24 24">
                <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
              <svg id="eyeClosed" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8"
                viewBox="0 0 24 24" style="display:none">
                <path
                  d="M17.94 17.94A10.94 10.94 0 0 1 12 19C5 19 1 12 1 12a18.5 18.5 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19M1 1l22 22" />
              </svg>
            </span>
          </div>
        </div>

        <div class="text-end mb-4 anim-4">
          <a href="#" class="forgot">Esqueceu a senha?</a>
        </div>

        <button class="btn-primary-custom anim-5" id="btnAcessar">
          Acessar Sistema
        </button>
      </div>

      <!-- Footer -->
      <div class="footer-section anim-6">
        <div class="divider-label"><span>Contato</span></div>
        <div class="text-center">
          <a href="https://wa.me/" class="btn-suporte" target="_blank" rel="noopener">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="#25D366">
              <path
                d="M20.52 3.48A11.93 11.93 0 0 0 12 0C5.37 0 0 5.37 0 12a11.93 11.93 0 0 0 1.67 6.09L0 24l6.12-1.61A11.93 11.93 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.2-1.25-6.22-3.48-8.52zm-8.52 18.43a9.87 9.87 0 0 1-5.06-1.39l-.36-.22-3.73.98 1-3.63-.24-.38A9.87 9.87 0 0 1 2.13 12 9.87 9.87 0 0 1 12 2.13 9.87 9.87 0 0 1 21.87 12a9.87 9.87 0 0 1-9.87 9.91zm5.4-7.4c-.3-.15-1.76-.87-2.03-.97s-.47-.15-.67.15-.77.97-.94 1.16-.35.22-.65.07a8.18 8.18 0 0 1-2.4-1.48 9.06 9.06 0 0 1-1.66-2.07c-.17-.3 0-.46.13-.6.13-.13.3-.35.44-.52s.2-.3.3-.5.05-.37-.02-.52c-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37s-1.04 1.02-1.04 2.49 1.06 2.89 1.21 3.09 2.09 3.19 5.07 4.48c.71.31 1.26.49 1.69.63.71.22 1.36.19 1.87.12.57-.09 1.76-.72 2.01-1.41s.25-1.29.17-1.41c-.07-.1-.27-.17-.57-.32z" />
            </svg>
            Suporte
          </a>
        </div>
      </div>

    </div>

    <!-- ── RIGHT ──────────────────────────────────── -->
    <div class="panel-right">
      <div class="right-bg"></div>
      <div class="right-overlay"></div>
      <div class="right-content">
        <div class="tag-pill">Gestão Agrícola para Cooperativas Locais</div>
        <h1 class="right-headline">
          <span class="hl">Conecte-se</span> ao que importa<br>
          no campo SIAG
        </h1>
        <div class="right-desc">
          <span class="arrow">▶</span>
          <p>Faça a gestão completa da sua operação financeira, comercial e agrícola, a qualquer hora e em qualquer
            lugar.</p>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>


  <script>
    $('#btnAcessar').click(function () {

      const email = $('#email').val();
      const password = $('#senha').val();

      const btn = $('#btnAcessar');

      btn.text('Entrando...');
      btn.prop('disabled', true);

      $.ajax({
        url: "/login",
        type: "POST",
        data: {
          email: email,
          password: password,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {

          if (res.status) {
            window.location.href = res.redirect;
          } else {
            alert(res.message);
          }

          btn.text('Acessar Sistema');
          btn.prop('disabled', false);
        },

        error: function () {
          alert("Erro no servidor");
          btn.text('Acessar Sistema');
          btn.prop('disabled', false);
        }
      });
    });
  </script>

</body>

</html>