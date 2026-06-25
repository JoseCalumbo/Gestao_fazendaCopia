<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG – Vendas</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap"
    rel="stylesheet" />

  <style>
    :root {
      --sidebar-bg: #1B5E20;
      --sidebar-hover: #2E7D32;
      --sidebar-active: #2E7D32;
      --accent: #66BB6A;
      --accent-lt: #E8F5E9;
      --primary: #2E7D32;
      --text-dark: #1C2B1E;
      --text-mid: #4A6350;
      --text-light: #8FA894;
      --border: rgba(0, 0, 0, .07);
      --card-bg: #ffffff;
      --page-bg: #F4F6F4;
      --sidebar-w: 240px;
      --sidebar-w-icons: 68px;
      --topbar-h: 64px;
      --danger: #C62828;
      --warning: #F57F17;
      --info: #1565C0;
    }

    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--page-bg);
      color: var(--text-dark);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ═══════════════════════════════════════════
       SIDEBAR (mesmo estilo do projeto)
    ═══════════════════════════════════════════ */
    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--sidebar-w);
      height: 100vh;
      background: var(--sidebar-bg);
      display: flex;
      flex-direction: column;
      transition: width .3s ease;
      z-index: 1000;
      overflow: hidden;
    }
    body.icons-only #sidebar { width: var(--sidebar-w-icons); }
    body.sidebar-hidden #sidebar { width: 0; }

    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 15px;
      border-bottom: 1px solid rgba(255,255,255,.1);
      white-space: nowrap;
      min-height: var(--topbar-h);
      overflow: hidden;
    }
    body.icons-only .sidebar-logo { justify-content: center; padding: 14px 0; }
    body.icons-only .sidebar-logo .logo-text-wrap { opacity: 0; pointer-events: none; width: 0; overflow: hidden; }

    .sidebar-nav { flex: 1; padding: 12px 0; overflow-y: auto; overflow-x: hidden; }
    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.18); border-radius: 10px; }
    .sidebar-nav { scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.18) transparent; }

    .nav-section-title {
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: rgba(255,255,255,.4);
      padding: 18px 20px 6px;
      white-space: nowrap;
      transition: opacity .2s;
    }
    body.icons-only .nav-section-title { opacity: 0; height: 0; padding: 0; overflow: hidden; }

    .nav-item-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 18px;
      color: rgba(255,255,255,.75);
      text-decoration: none;
      border-radius: 10px;
      margin: 2px 8px;
      transition: background .2s, color .15s;
      white-space: nowrap;
      position: relative;
    }
    .nav-item-link i { font-size: 18px; flex-shrink: 0; width: 22px; text-align: center; }
    .nav-item-link .nav-label { font-size: 14px; font-weight: 500; opacity: 1; transition: opacity .2s; }
    body.icons-only .nav-item-link .nav-label { opacity: 0; pointer-events: none; width: 0; overflow: hidden; }
    body.icons-only .nav-item-link { justify-content: center; padding: 11px 0; margin: 2px 6px; }
    .nav-item-link:hover { background: rgba(255,255,255,.1); color: #fff; }
    .nav-item-link.active {
      background: var(--accent);
      color: #fff;
      box-shadow: 0 4px 14px rgba(102,187,106,.35);
    }

    .sidebar-tooltip .tooltip-inner {
      background: #0f3d14;
      color: #fff;
      font-size: 12.5px;
      font-weight: 500;
      padding: 5px 12px;
      border-radius: 8px;
      box-shadow: 0 4px 14px rgba(0,0,0,.3);
    }

    .sidebar-user {
      padding: 14px 10px;
      border-top: 1px solid rgba(255,255,255,.1);
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      transition: background .2s;
      border-radius: 10px;
      margin: 4px 6px;
      white-space: nowrap;
    }
    .sidebar-user:hover { background: rgba(255,255,255,.08); }
    .sidebar-user .avatar {
      width: 34px;
      height: 34px;
      background: var(--accent);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      overflow: hidden;
    }
    .sidebar-user .avatar img { width: 100%; height: 100%; object-fit: cover; }
    .sidebar-user .avatar i { color: #fff; font-size: 16px; }
    .sidebar-user .user-info { opacity: 1; transition: opacity .2s; }
    .sidebar-user .user-info .u-name { font-size: 13px; font-weight: 600; color: #fff; }
    .sidebar-user .user-info .u-role { font-size: 11px; color: rgba(255,255,255,.5); }
    body.icons-only .sidebar-user .user-info { opacity: 0; pointer-events: none; }

    /* ═══════════════════════════════════════════
       TOPBAR (mesmo estilo)
    ═══════════════════════════════════════════ */
    #topbar {
      position: fixed;
      top: 0;
      left: var(--sidebar-w);
      right: 0;
      height: var(--topbar-h);
      background: #fff;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 28px;
      gap: 16px;
      z-index: 900;
      transition: left .3s ease;
    }
    body.icons-only #topbar { left: var(--sidebar-w-icons); }
    body.sidebar-hidden #topbar { left: 0; }

    .topbar-toggle {
      background: none;
      border: none;
      font-size: 20px;
      color: var(--text-mid);
      cursor: pointer;
      padding: 6px;
      border-radius: 8px;
      transition: background .2s, color .2s;
    }
    .topbar-toggle:hover { background: var(--accent-lt); color: var(--primary); }

    .topbar-title {
      font-family: 'Sora', sans-serif;
      font-size: 16px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .topbar-right {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .topbar-icon-btn {
      width: 38px;
      height: 38px;
      border: none;
      background: var(--accent-lt);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary);
      font-size: 17px;
      cursor: pointer;
      transition: background .2s, color .2s;
      position: relative;
    }
    .topbar-icon-btn:hover { background: var(--primary); color: #fff; }

    .bi { color: var(--primary); }
    .nav-item-link .bi, .sidebar-logo .bi, .sidebar-user .bi,
    .modal-header .bi, .modal-header-icon .bi, .btn-green .bi,
    .topbar-icon-btn:hover .bi, .action-btn.edit:hover .bi,
    .action-btn.print:hover .bi, .action-btn.delete:hover .bi,
    .action-btn.view:hover .bi { color: inherit; }

    .topbar-title .bi, .table-card-header .bi,
    .cfg-card-title .bi, .modal-section-title .bi { color: var(--primary); }
    .badge-status .bi, .stat-badge .bi { color: inherit; }
    .search-wrap .bi { color: var(--text-light); }

    .notif-badge {
      position: absolute;
      top: 6px;
      right: 6px;
      width: 8px;
      height: 8px;
      background: #E53935;
      border-radius: 50%;
      border: 2px solid #fff;
    }

    .topbar-user {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 6px 12px;
      background: var(--accent-lt);
      border-radius: 30px;
      cursor: pointer;
      transition: background .2s;
    }
    .topbar-user:hover { background: #C8E6C9; }
    .topbar-user .t-avatar {
      width: 30px;
      height: 30px;
      background: var(--primary);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .topbar-user .t-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-md { width: 30px !important; height: 30px; object-fit: cover; border-radius: 50%; }
    .topbar-user .t-avatar i { color: #fff; font-size: 14px; }
    .topbar-user span { font-size: 13px; font-weight: 500; color: var(--primary); }

    .dropdown-menu-user {
      min-width: 200px;
      border: 1px solid var(--border);
      border-radius: 14px;
      box-shadow: 0 12px 36px rgba(0,0,0,.12);
      padding: 6px;
      margin-top: 8px !important;
    }
    .dropdown-menu-user .dropdown-header {
      font-size: 11px;
      font-weight: 600;
      letter-spacing: .8px;
      text-transform: uppercase;
      color: var(--text-light);
      padding: 6px 12px 4px;
    }
    .dropdown-menu-user .dropdown-item {
      font-size: 13.5px;
      color: var(--text-mid);
      border-radius: 8px;
      padding: 9px 12px;
      display: flex;
      align-items: center;
      gap: 9px;
      transition: background .15s, color .15s;
    }
    .dropdown-menu-user .dropdown-item i { font-size: 15px; color: var(--text-light); }
    .dropdown-menu-user .dropdown-item:hover { background: var(--accent-lt); color: var(--primary); }
    .dropdown-menu-user .dropdown-item:hover i { color: var(--primary); }
    .dropdown-menu-user .dropdown-divider { margin: 4px 6px; border-color: var(--border); }
    .dropdown-menu-user .item-logout { color: #C62828; }
    .dropdown-menu-user .item-logout i { color: #C62828; }
    .dropdown-menu-user .item-logout:hover { background: #FFEBEE; color: #C62828; }
    .dropdown-menu-user form { margin: 0; }
    .dropdown-menu-user form button {
      background: none;
      border: none;
      font-size: 13.5px;
      color: #C62828;
      border-radius: 8px;
      padding: 9px 12px;
      width: 100%;
      text-align: left;
      display: flex;
      align-items: center;
      gap: 9px;
      cursor: pointer;
      transition: background .15s;
    }
    .dropdown-menu-user form button:hover { background: #FFEBEE; }
    .dropdown-menu-user form button i { font-size: 15px; color: #C62828; }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════ */
    #main {
      margin-left: var(--sidebar-w);
      padding-top: var(--topbar-h);
      transition: margin-left .3s ease;
      min-height: 100vh;
    }
    body.icons-only #main { margin-left: var(--sidebar-w-icons); }
    body.sidebar-hidden #main { margin-left: 0; }
    .content-inner { padding: 28px; }

    /* ═══════════════════════════════════════════
       PAGE HEADER
    ═══════════════════════════════════════════ */
    .page-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 28px;
      flex-wrap: wrap;
      gap: 12px;
    }
    .page-header h1 {
      font-family: 'Sora', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 3px;
    }
    .page-header p { font-size: 13.5px; color: var(--text-light); }

    .btn-green {
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 9px 18px;
      font-size: 13.5px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      transition: background .2s, transform .1s;
      text-decoration: none;
    }
    .btn-green:hover { background: var(--accent); color: #fff; }
    .btn-green:active { transform: scale(.97); }
    .btn-green:disabled { opacity: .6; cursor: not-allowed; }

    .btn-outline-green {
      background: transparent;
      color: var(--primary);
      border: 1.5px solid var(--primary);
      border-radius: 10px;
      padding: 8px 16px;
      font-size: 13.5px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      transition: background .2s, color .2s;
      text-decoration: none;
    }
    .btn-outline-green:hover { background: var(--accent-lt); color: var(--primary); }

    /* ═══════════════════════════════════════════
       FILTER BUTTONS
    ═══════════════════════════════════════════ */
    .filter-btn-group {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      margin-bottom: 16px;
    }
    .filter-btn {
      background: var(--card-bg);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 8px 16px;
      font-size: 13px;
      font-weight: 500;
      color: var(--text-mid);
      cursor: pointer;
      transition: all .2s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    .filter-btn:hover { border-color: var(--primary); color: var(--primary); transform: translateY(-1px); }
    .filter-btn.active { border-color: var(--primary); background: var(--accent-lt); color: var(--primary); }
    .filter-btn .badge-count {
      background: var(--accent-lt);
      color: var(--primary);
      border-radius: 20px;
      padding: 0px 8px;
      font-size: 11px;
      font-weight: 700;
    }
    .filter-btn.active .badge-count { background: var(--primary); color: #fff; }

    /* ═══════════════════════════════════════════
       TABLE CARD
    ═══════════════════════════════════════════ */
    .table-card {
      background: var(--card-bg);
      border-radius: 16px;
      border: 1px solid var(--border);
      overflow: hidden;
    }
    .table-card-header {
      padding: 18px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border);
      flex-wrap: wrap;
      gap: 12px;
    }
    .table-card-header h5 {
      font-family: 'Sora', sans-serif;
      font-size: 15px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .search-filter-bar {
      padding: 14px 24px;
      border-bottom: 1px solid var(--border);
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
    }
    .search-wrap {
      flex: 1;
      min-width: 220px;
      position: relative;
    }
    .search-wrap i {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
      font-size: 14px;
      pointer-events: none;
    }
    .search-input {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 10px 14px 10px 36px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      outline: none;
      font-family: 'DM Sans', sans-serif;
      transition: border-color .2s, box-shadow .2s;
    }
    .search-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,50,.1);
      background: #fff;
    }
    .search-input::placeholder { color: #C3B8B4; }

    .filter-select {
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 10px 32px 10px 14px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      appearance: none;
      cursor: pointer;
      outline: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA894' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      transition: border-color .2s;
      min-width: 150px;
    }
    .filter-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,50,.1);
    }

    .venda-table {
      width: 100%;
      border-collapse: collapse;
    }
    .venda-table th {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .8px;
      color: var(--text-light);
      padding: 12px 20px;
      background: #FAFBFA;
      border-bottom: 1px solid var(--border);
      text-align: left;
      white-space: nowrap;
    }
    .venda-table td {
      font-size: 13.5px;
      color: var(--text-dark);
      padding: 14px 20px;
      border-bottom: 1px solid var(--border);
      vertical-align: middle;
    }
    .venda-table tr:last-child td { border-bottom: none; }
    .venda-table tbody tr:hover td { background: #F8FBF8; }

    .action-btn {
      width: 32px;
      height: 32px;
      border: none;
      border-radius: 9px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
      transition: background .15s, color .15s;
      text-decoration: none;
    }
    .action-btn.add { background: var(--accent-lt); color: var(--primary); }
    .action-btn.add:hover { background: var(--primary); color: #fff; }
    .action-btn.view { background: #EDE7F6; color: #6A1B9A; }
    .action-btn.view:hover { background: #6A1B9A; color: #fff; }
    .action-btn.print { background: #E3F2FD; color: #1565C0; }
    .action-btn.print:hover { background: #1565C0; color: #fff; }

    .badge-status {
      font-size: 12px;
      font-weight: 500;
      padding: 0;
      background: none;
      border-radius: 0;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }
    .badge-status.pago { color: #2E7D32; }
    .badge-status.pendente { color: #F57F17; }
    .badge-status.cancelado { color: #C62828; }
    .badge-status .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      display: inline-block;
    }
    .badge-status.pago .dot { background: #2E7D32; }
    .badge-status.pendente .dot { background: #F57F17; }
    .badge-status.cancelado .dot { background: #C62828; }

    .table-footer {
      padding: 14px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid var(--border);
      flex-wrap: wrap;
      gap: 10px;
    }
    .table-footer span { font-size: 12.5px; color: var(--text-light); }
    .pagination-btns { display: flex; gap: 6px; }
    .page-btn {
      min-width: 34px;
      height: 34px;
      padding: 0 10px;
      border: 1.5px solid var(--border);
      border-radius: 9px;
      background: #fff;
      font-size: 13px;
      color: var(--text-mid);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .15s;
      font-family: 'DM Sans', sans-serif;
    }
    .page-btn:hover { border-color: var(--primary); color: var(--primary); }
    .page-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); }
    .page-btn:disabled { opacity: .4; cursor: not-allowed; }

    /* ═══════════════════════════════════════════
       CARRINHO DE COMPRAS
    ═══════════════════════════════════════════ */
    .cart-panel-wrapper {
      position: sticky;
      top: calc(var(--topbar-h) + 28px);
    }
    .cart-panel {
      background: var(--card-bg);
      border-radius: 16px;
      border: 1px solid var(--border);
      padding: 20px;
      height: calc(100vh - var(--topbar-h) - 80px);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    .cart-panel .cart-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--border);
      flex-shrink: 0;
    }
    .cart-panel .cart-header h6 {
      font-family: 'Sora', sans-serif;
      font-weight: 600;
      color: var(--text-dark);
      margin: 0;
    }
    .cart-items-container {
      flex: 1;
      overflow-y: auto;
      margin: 0 -20px;
      padding: 0 20px;
    }
    .cart-items-container::-webkit-scrollbar { width: 4px; }
    .cart-items-container::-webkit-scrollbar-thumb { background: rgba(0,0,0,.12); border-radius: 4px; }

    .cart-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 0;
      border-bottom: 1px solid var(--border);
      font-size: 13px;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item .item-info { flex: 1; min-width: 0; }
    .cart-item .item-info .item-name { font-weight: 500; color: var(--text-dark); }
    .cart-item .item-info .item-detail { font-size: 12px; color: var(--text-light); }
    .cart-item .item-price { font-weight: 600; color: var(--primary); min-width: 70px; text-align: right; font-size: 13px; }
    .cart-item .btn-remove-item {
      background: none;
      border: none;
      color: var(--danger);
      cursor: pointer;
      padding: 0 4px;
      font-size: 16px;
      opacity: .6;
      transition: opacity .2s;
    }
    .cart-item .btn-remove-item:hover { opacity: 1; }

    .cart-total {
      display: flex;
      justify-content: space-between;
      padding-top: 12px;
      margin-top: 12px;
      border-top: 2px solid var(--border);
      font-family: 'Sora', sans-serif;
      font-size: 18px;
      font-weight: 700;
      color: var(--text-dark);
      flex-shrink: 0;
    }
    .cart-empty {
      text-align: center;
      padding: 30px 0;
      color: var(--text-light);
    }
    .cart-empty i { font-size: 48px; display: block; margin-bottom: 12px; opacity: .4; }
    .cart-empty p { margin-bottom: 4px; }
    .cart-empty .sub { font-size: 12px; opacity: .7; }
    .cart-actions {
      flex-shrink: 0;
      padding-top: 12px;
      border-top: 1px solid var(--border);
    }

    /* ═══════════════════════════════════════════
       MODAL — FINALIZAR VENDA (duas colunas)
    ═══════════════════════════════════════════ */
    .modal-coop .modal-dialog {
      max-width: 900px;
      width: 100%;
    }

    .modal-coop .modal-content {
      border: none;
      border-radius: 18px;
      box-shadow: 0 24px 64px rgba(0,0,0,.15);
      overflow: hidden;
      max-height: 90vh;
      display: flex;
      flex-direction: column;
    }
    .modal-coop .modal-body {
      flex: 1;
      overflow: hidden;
      padding: 0;
      background: var(--page-bg);
      display: flex;
    }

    .modal-header {
      padding: 11px 20px;
      border-bottom: 1px solid var(--border);
      background: linear-gradient(135deg, var(--sidebar-bg) 0%, var(--primary) 100%);
      flex-shrink: 0;
    }
    .modal-header .modal-title {
      font-family: 'Sora', sans-serif;
      font-size: 16px;
      font-weight: 700;
      color: #fff;
    }
    .modal-header .btn-close {
      filter: brightness(0) invert(1);
      opacity: .8;
    }
    .modal-header .btn-close:hover { opacity: 1; }
    .modal-header-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: rgba(255,255,255,.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 17px;
      color: #fff;
      flex-shrink: 0;
    }

    .modal-footer {
      padding: 14px 20px;
      border-top: 1px solid var(--border);
      background: #fff;
      flex-shrink: 0;
    }

    /* Coluna Esquerda - Resumo (50%) */
    .modal-col-resumo {
      width: 50%;
      padding: 20px 20px 16px 24px;
      background: var(--page-bg);
      display: flex;
      flex-direction: column;
      border-right: 1px solid var(--border);
    }

    /* Coluna Direita - Dados Cliente (50%) */
    .modal-col-dados {
      width: 50%;
      padding: 20px 24px 16px 20px;
      background: var(--card-bg);
      display: flex;
      flex-direction: column;
    }

    .modal-col-dados .dados-scroll {
      flex: 1;
      overflow-y: auto;
    }
    .modal-col-dados .dados-scroll::-webkit-scrollbar { width: 4px; }
    .modal-col-dados .dados-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,.12); border-radius: 4px; }

    .modal-section-title {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--text-light);
      margin-bottom: 12px;
      padding-bottom: 6px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .modal-section-title i { font-size: 13px; color: var(--primary); }

    .cfg-label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-mid);
      margin-bottom: 5px;
      letter-spacing: .2px;
    }
    .cfg-input {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 9px 13px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      font-family: 'DM Sans', sans-serif;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .cfg-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,50,.1);
      background: #fff;
    }
    .cfg-input::placeholder { color: #C3B8B4; }

    .cfg-select {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 9px 32px 9px 13px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      appearance: none;
      cursor: pointer;
      outline: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA894' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      transition: border-color .2s;
      font-family: 'DM Sans', sans-serif;
    }
    .cfg-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,50,.1);
    }

    .troco-info {
      background: var(--accent-lt);
      border-radius: 10px;
      padding: 10px 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      font-size: 14px;
      margin-top: 8px;
    }
    .troco-info .troco-valor {
      color: var(--primary);
      font-size: 17px;
    }
    .troco-info .troco-valor.negativo { color: var(--danger); }

    /* Resumo itens dentro do modal */
    .resumo-itens {
      flex: 1;
      background: var(--card-bg);
      border-radius: 14px;
      border: 1px solid var(--border);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }
    .resumo-itens .resumo-header {
      padding: 10px 16px;
      background: #FAFBFA;
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-light);
      text-transform: uppercase;
      letter-spacing: .5px;
      flex-shrink: 0;
    }
    .resumo-itens .resumo-body {
      flex: 1;
      overflow-y: auto;
      padding: 0 16px;
    }
    .resumo-itens .resumo-body::-webkit-scrollbar { width: 4px; }
    .resumo-itens .resumo-body::-webkit-scrollbar-thumb { background: rgba(0,0,0,.12); border-radius: 4px; }

    .resumo-itens .resumo-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid var(--border);
      font-size: 13px;
    }
    .resumo-itens .resumo-item:last-child { border-bottom: none; }
    .resumo-itens .resumo-item .item-nome { font-weight: 500; color: var(--text-dark); flex: 1; }
    .resumo-itens .resumo-item .item-qtd { margin: 0 12px; color: var(--text-mid); font-weight: 500; }
    .resumo-itens .resumo-item .item-subtotal { font-weight: 600; color: var(--primary); min-width: 80px; text-align: right; }

    .resumo-total-modal {
      display: flex;
      justify-content: space-between;
      padding: 10px 16px;
      margin-top: 10px;
      background: var(--accent-lt);
      border-radius: 10px;
      font-family: 'Sora', sans-serif;
      font-size: 17px;
      font-weight: 700;
      color: var(--text-dark);
      flex-shrink: 0;
    }
    .resumo-total-modal .total-valor { color: var(--primary); }

    /* ═══════════════════════════════════════════
       MODAL — RESUMO DA VENDA (com scroll e centralizado)
    ═══════════════════════════════════════════ */
    .modal-resumo .modal-content {
      max-width: 620px;
      max-height: 90vh;
    }
    .modal-resumo .modal-header .btn-close { display: none !important; }
    .modal-resumo .modal-body {
      background: #fff;
      padding: 24px;
      overflow-y: auto;
      max-height: calc(90vh - 140px);
    }
    .modal-resumo .modal-body::-webkit-scrollbar { width: 6px; }
    .modal-resumo .modal-body::-webkit-scrollbar-thumb {
      background: rgba(0,0,0,.15);
      border-radius: 4px;
    }
    .modal-resumo .modal-body::-webkit-scrollbar-track {
      background: rgba(0,0,0,.03);
      border-radius: 4px;
    }

    .fatura-preview {
      background: #fff;
      padding: 24px;
      border: 1px solid var(--border);
      border-radius: 12px;
      max-width: 560px;
      margin: 0 auto;
    }
    .fatura-preview .fatura-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 2px solid var(--primary);
      padding-bottom: 12px;
      margin-bottom: 16px;
    }
    .fatura-preview .fatura-header .fatura-titulo {
      font-family: 'Sora', sans-serif;
      font-size: 18px;
      font-weight: 700;
      color: var(--primary);
    }
    .fatura-preview .fatura-header .fatura-numero {
      font-size: 13px;
      color: var(--text-light);
      text-align: right;
    }
    .fatura-preview .fatura-cliente {
      margin-bottom: 16px;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--border);
    }
    .fatura-preview .fatura-cliente .cliente-nome { font-weight: 600; font-size: 15px; }
    .fatura-preview .fatura-cliente .cliente-detalhe { font-size: 12px; color: var(--text-light); }
    .fatura-preview .fatura-itens table {
      width: 100%;
      font-size: 13px;
      border-collapse: collapse;
    }
    .fatura-preview .fatura-itens table th {
      font-size: 11px;
      text-transform: uppercase;
      color: var(--text-light);
      border-bottom: 1px solid var(--border);
      padding: 8px 0;
      text-align: left;
    }
    .fatura-preview .fatura-itens table td {
      padding: 6px 0;
      border-bottom: 1px solid var(--border);
    }
    .fatura-preview .fatura-itens table td:last-child { text-align: right; }
    .fatura-preview .fatura-total {
      margin-top: 16px;
      padding-top: 12px;
      border-top: 2px solid var(--primary);
      display: flex;
      justify-content: space-between;
      font-size: 16px;
      font-weight: 700;
    }
    .fatura-preview .fatura-total .total-valor { color: var(--primary); font-size: 20px; }
    .fatura-preview .fatura-troco {
      display: flex;
      justify-content: space-between;
      font-size: 14px;
      padding-top: 4px;
      color: var(--text-mid);
    }
    .fatura-preview .fatura-rodape {
      margin-top: 16px;
      padding-top: 12px;
      border-top: 1px solid var(--border);
      font-size: 11px;
      color: var(--text-light);
      text-align: center;
    }

    /* Toast */
    .save-toast {
      position: fixed;
      bottom: 28px;
      right: 28px;
      z-index: 9999;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 14px 20px;
      box-shadow: 0 12px 36px rgba(0,0,0,.12);
      display: flex;
      align-items: center;
      gap: 12px;
      transform: translateY(80px);
      opacity: 0;
      transition: all .35s cubic-bezier(.34,1.56,.64,1);
      pointer-events: none;
    }
    .save-toast.show { transform: translateY(0); opacity: 1; pointer-events: all; }
    .save-toast .toast-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }
    .save-toast .toast-icon.success { background: #E8F5E9; color: #2E7D32; }
    .save-toast .toast-icon.danger { background: #FFEBEE; color: #C62828; }
    .save-toast .toast-text .t-title { font-size: 13.5px; font-weight: 600; color: var(--text-dark); }
    .save-toast .toast-text .t-sub { font-size: 12px; color: var(--text-light); }

    /* Loading spinner */
    .spinner-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,.5);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 99999;
    }
    .spinner-overlay.show { display: flex; }

    /* Animations */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(14px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .anim { animation: fadeUp .4s ease both; }
    .anim-d1 { animation-delay: .05s; }
    .anim-d2 { animation-delay: .10s; }

    /* Dark mode */
    body.dark-mode {
      --card-bg: #1e2a20;
      --page-bg: #141d15;
      --text-dark: #e8f0e9;
      --text-mid: #9ab89e;
      --text-light: #6a8a6e;
      --border: rgba(255,255,255,.07);
    }
    body.dark-mode #topbar { background: #1e2a20; border-color: rgba(255,255,255,.06); }
    body.dark-mode .topbar-title { color: #e8f0e9; }
    body.dark-mode .topbar-user { background: rgba(102,187,106,.15); }
    body.dark-mode .topbar-user span { color: #66BB6A; }
    body.dark-mode .topbar-icon-btn { background: rgba(102,187,106,.12); }
    body.dark-mode .venda-table th { background: #172518; }
    body.dark-mode .venda-table tbody tr:hover td { background: #1a2a1c; }
    body.dark-mode .search-input, body.dark-mode .filter-select,
    body.dark-mode .cfg-input, body.dark-mode .cfg-select {
      background: #172518;
      color: #e8f0e9;
      border-color: rgba(255,255,255,.1);
    }
    body.dark-mode .modal-body { background: #1a2a1c; }
    body.dark-mode .modal-col-dados { background: #1e2a20; }
    body.dark-mode .modal-col-resumo { background: #141d15; }
    body.dark-mode .modal-footer { background: #1e2a20; border-color: rgba(255,255,255,.07); }
    body.dark-mode .cart-panel { background: #1e2a20; border-color: rgba(255,255,255,.07); }
    body.dark-mode .filter-btn { background: #1e2a20; border-color: rgba(255,255,255,.07); color: var(--text-mid); }
    body.dark-mode .filter-btn.active { background: #1a2a1c; border-color: var(--primary); color: var(--text-dark); }
    body.dark-mode .fatura-preview { background: #1e2a20; border-color: rgba(255,255,255,.07); }
    body.dark-mode .modal-resumo .modal-body { background: #1a2a1c; }
    body.dark-mode .resumo-itens .resumo-header { background: #172518; }
    body.dark-mode .troco-info { background: rgba(102,187,106,.15); }
    body.dark-mode .modal-resumo .modal-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); }

    /* Responsive */
    @media (max-width: 992px) {
      .cart-panel-wrapper { position: static; margin-top: 20px; }
      .cart-panel { height: auto; max-height: 400px; }
      .modal-coop .modal-dialog { max-width: 95%; }
      .modal-coop .modal-body { flex-direction: column; }
      .modal-col-resumo { width: 100%; border-right: none; border-bottom: 1px solid var(--border); max-height: 300px; }
      .modal-col-dados { width: 100%; }
    }
    @media (max-width: 768px) {
      :root { --sidebar-w: 240px; }
      body:not(.sidebar-hidden) #sidebar { box-shadow: 4px 0 20px rgba(0,0,0,.2); }
      body.default #sidebar { width: 0; }
      body.default #main { margin-left: 0; }
      body.default #topbar { left: 0; }
      .content-inner { padding: 16px; }
      .modal-coop .modal-dialog { max-width: 100%; margin: 10px; }
      .modal-col-resumo { max-height: 200px; }
      .modal-resumo .modal-content { max-height: 95vh; }
      .modal-resumo .modal-body { max-height: calc(95vh - 120px); }
    }
  </style>
</head>

<body>

  <!-- ══════════════════════════════════════
     SIDEBAR
══════════════════════════════════════ -->
  <nav id="sidebar">
    <div class="sidebar-logo">
      <div class="logo-svg-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340" width="38" height="38" style="flex-shrink:0;">
          <circle cx="170" cy="170" r="145" fill="#66BB6A" />
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
            <ellipse cx="239" cy="171" rx="6" ry="4" fill="#66BB6A" stroke="none" />
            <line x1="212" y1="170" x2="212" y2="188" stroke="#66BB6A" stroke-width="4" />
            <line x1="220" y1="170" x2="220" y2="188" stroke="#66BB6A" stroke-width="4" />
            <line x1="228" y1="170" x2="228" y2="188" stroke="#66BB6A" stroke-width="4" />
          </g>
        </svg>
      </div>
      <div class="logo-text-wrap" style="opacity:1;transition:opacity .2s;white-space:nowrap;">
        <div
          style="font-family:'Sora',sans-serif;font-size:17px;font-weight:700;color:#fff;letter-spacing:1px;line-height:1.1;">
          SIAG</div>
        <div style="font-size:10px;color:rgba(255,255,255,.5);letter-spacing:.5px;">Agrícola Cooperativas</div>
      </div>
    </div>

    <div class="sidebar-nav">
      <div class="nav-section-title">Principal</div>
      <a href="{{ route('dashboard') }}" class="nav-item-link" data-label="Dashboard"><i
          class="bi bi-grid-1x2-fill"></i><span class="nav-label">Dashboard</span></a>
      <a href="{{ route('cooperativas') }}" class="nav-item-link" data-label="Cooperativa"><i
          class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
      <a href="{{ route('agricultores.index') }}" class="nav-item-link" data-label="Agricultores"><i
          class="bi bi-people-fill"></i><span class="nav-label">Agricultores</span></a>

      <div class="nav-section-title">Agrícola</div>
      <a href="#" class="nav-item-link" data-label="Safras"><i class="bi bi-flower2"></i><span
          class="nav-label">Safras</span></a>
      <a href="#" class="nav-item-link" data-label="Talhões"><i class="bi bi-map-fill"></i><span
          class="nav-label">Talhões</span></a>
      <a href="#" class="nav-item-link" data-label="Insumos"><i class="bi bi-box-seam-fill"></i><span
          class="nav-label">Insumos</span></a>

      <div class="nav-section-title">Comercial</div>
      <a href="#" class="nav-item-link active" data-label="Vendas"><i class="bi bi-cart-fill"></i><span
          class="nav-label">Vendas</span></a>
      <a href="#" class="nav-item-link" data-label="Contratos"><i class="bi bi-file-earmark-text-fill"></i><span
          class="nav-label">Contratos</span></a>

      <div class="nav-section-title">Financeiro</div>
      <a href="#" class="nav-item-link" data-label="Fluxo de Caixa"><i class="bi bi-cash-stack"></i><span
          class="nav-label">Fluxo de Caixa</span></a>

      <div class="nav-section-title">Sistema</div>
      <a href="#" class="nav-item-link" data-label="Relatórios"><i class="bi bi-bar-chart-fill"></i><span
          class="nav-label">Relatórios</span></a>
      <a href="{{ route('configuracoes') }}" class="nav-item-link" data-label="Configurações"><i
          class="bi bi-gear-fill"></i><span class="nav-label">Configurações</span></a>
    </div>

    <div class="sidebar-user">
      <div class="avatar">
        @if(!empty(Auth::user()->foto))
          <img id="dropdownAvatarLarge"
            src="{{ Auth::check() ? Auth::user()->foto_url : asset('uploads/users/default-user.png') }}" alt="Foto-perfil"
            width="20" class="avatar-md">
        @else
          <span style="color:#fff;font-weight:700;font-size:15px;">{{ substr(Auth::user()->name, 0, 1) }}</span>
        @endif
      </div>
      <div class="user-info">
        <div class="u-name">{{ Auth::user()->name }}</div>
        <div class="u-role">Minha Conta</div>
      </div>
    </div>
  </nav>

  <!-- ══════════════════════════════════════
     TOPBAR
══════════════════════════════════════ -->
  <header id="topbar">
    <button class="topbar-toggle" id="sidebarToggle" title="Toggle Sidebar">
      <i class="bi bi-list"></i>
    </button>
    <span class="topbar-title">Vendas</span>
    <nav aria-label="breadcrumb" class="d-none d-md-flex ms-3">
      <ol class="breadcrumb mb-0" style="font-size:12.5px;">
        <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">SIAG</a></li>
        <li class="breadcrumb-item active" style="color:var(--text-light);">Vendas</li>
      </ol>
    </nav>
    <div class="topbar-right">
      <span class="badge rounded-pill d-none d-md-inline-flex align-items-center gap-1"
        style="background:var(--accent-lt);color:var(--primary);font-size:12px;padding:7px 13px;font-weight:600;">
        <i class="bi bi-calendar3"></i> Safra {{ date('Y') }}
      </span>
      <button class="topbar-icon-btn" title="Notificações">
        <i class="bi bi-bell-fill"></i><span class="notif-badge"></span>
      </button>
      <button class="topbar-icon-btn" title="Mensagens">
        <i class="bi bi-chat-dots-fill"></i>
      </button>
      <div class="dropdown d-none d-sm-flex">
        <div class="topbar-user" data-bs-toggle="dropdown" data-bs-offset="0,4" role="button">
          <div class="t-avatar">
            <img id="dropdownAvatarLarge"
              src="{{ Auth::check() ? Auth::user()->foto_url : asset('uploads/users/default-user.png') }}"
              alt="Foto-perfil" width="20" class="avatar-md">
          </div>
          <span> {{ Auth::check() ? Auth::user()->name : 'Utilizador' }}</span>
          <i class="bi bi-chevron-down" style="font-size:11px;color:var(--primary);"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user">
          <li><span class="dropdown-header"> Nível: {{ Auth::user()->nivel }}</li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-person-gear"></i> Minha Conta</a></li>
          <li>
            <a class="dropdown-item" href="#" id="themeToggle">
              <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
              <span id="themeLabel">Modo Escuro</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <div class="dropdown-item item-logout p-0">
              <form method="POST" action="/logout">
                @csrf
                <button type="submit"><i class="bi bi-box-arrow-right"></i> Sair</button>
              </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </header>

  <!-- ══════════════════════════════════════
     MAIN
══════════════════════════════════════ -->
  <main id="main">
    <div class="content-inner">

      <!-- Page Header -->
      <div class="page-header anim">
        <div>
          <h1>Gestão de Vendas</h1>
          <p>Registo e administração das vendas de produtos agrícolas</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <a href="{{ route('fluxo-caixa') }}" class="btn-outline-green">
            <i class="bi bi-cash-stack"></i> Fluxo de Caixa
          </a>
          <button class="btn-outline-green" id="btnExportar">
            <i class="bi bi-download"></i> Exportar
          </button>
          <button class="btn-green" id="btnNovaVenda">
            <i class="bi bi-cart-plus-fill"></i> Nova Venda
          </button>
        </div>
      </div>

      <!-- Filter Buttons (categorias dinâmicas) -->
      <div class="filter-btn-group anim anim-d1" id="filterButtons">
        <button class="filter-btn active" data-filter="todos">
          Todos <span class="badge-count" id="countTodos">0</span>
        </button>
        <button class="filter-btn" data-filter="mais-vendidos">
          Mais Vendidos <span class="badge-count" id="countMaisVendidos">0</span>
        </button>
        <button class="filter-btn" data-filter="frutas">
          Frutas <span class="badge-count" id="countFrutas">0</span>
        </button>
        <button class="filter-btn" data-filter="graos">
          Grãos <span class="badge-count" id="countGraos">0</span>
        </button>
        <button class="filter-btn" data-filter="legumes">
          Legumes <span class="badge-count" id="countLegumes">0</span>
        </button>
        <button class="filter-btn" data-filter="tuberculos">
          Tubérculos <span class="badge-count" id="countTuberculos">0</span>
        </button>
      </div>

      <!-- Layout: Lista de Produtos + Carrinho -->
      <div class="row g-4 anim anim-d2">

        <!-- Coluna Esquerda: Produtos Disponíveis -->
        <div class="col-lg-8">
          <div class="table-card">

            <!-- Header -->
            <div class="table-card-header">
              <div style="display:flex;align-items:center;gap:12px;">
                <h5><i class="bi bi-box-seam-fill me-2" style="color:var(--primary);"></i>Produtos Disponíveis</h5>
              </div>
              <div style="display:flex;gap:8px;align-items:center;">
                <span style="font-size:12.5px;color:var(--text-light);" id="produtoCount">0 produtos</span>
              </div>
            </div>

            <div class="search-filter-bar">
              <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" class="search-input" id="searchProduto" placeholder="Pesquisar por produto...">
              </div>
              <select class="filter-select" id="filterCategoria">
                <option value="">Todas as categorias</option>
                <option value="Fruta">Frutas</option>
                <option value="Grao">Grãos</option>
                <option value="Legume">Legumes</option>
                <option value="Tuberculo">Tubérculos</option>
                <option value="Outro">Outros</option>
              </select>
              <button class="btn-green" id="btnFiltrar" style="padding:8px 18px;"><i class="bi bi-search"></i> Filtrar</button>
              <button class="btn-outline-green" id="btnLimparFiltros" style="padding:8px 18px;"><i class="bi bi-eraser"></i> Limpar</button>
            </div>

            <!-- Tabela de Produtos -->
            <div style="overflow-x:auto;">
              <table class="venda-table" id="produtoTable">
                <thead>
                  <tr>
                    <th style="width:40px;">
                      <input type="checkbox" id="selectAll"
                        style="accent-color:var(--primary);width:15px;height:15px;cursor:pointer;">
                    </th>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Stock</th>
                    <th>Preço Unit. (Kz)</th>
                    <th style="text-align:center;">Qtd</th>
                    <th style="text-align:center;">Acção</th>
                  </tr>
                </thead>
                <tbody id="produtoTableBody">
                  <!-- Produtos serão renderizados via JS -->
                </tbody>
              </table>
            </div>

            <div class="table-footer">
              <span id="tableCount">Mostrando 0 de 0 produtos</span>
              <div class="pagination-btns" id="produtoPagination">
                <button class="page-btn" id="prodPrevPage"><i class="bi bi-chevron-left"></i></button>
                <span class="page-btn active" id="prodCurrentPage">1</span>
                <button class="page-btn" id="prodNextPage"><i class="bi bi-chevron-right"></i></button>
              </div>
            </div>
          </div>
        </div>

        <!-- Coluna Direita: Carrinho de Compras (fixo) -->
        <div class="col-lg-4">
          <div class="cart-panel-wrapper">
            <div class="cart-panel">
              <div class="cart-header">
                <h6><i class="bi bi-cart-fill me-2" style="color:var(--primary);"></i>Carrinho</h6>
                <span style="font-size:12px;color:var(--text-light);" id="cartCount">0 itens</span>
              </div>

              <div class="cart-items-container" id="cartItemsContainer">
                <div id="cartItems">
                  <div class="cart-empty">
                    <i class="bi bi-cart"></i>
                    <p>Seu carrinho está vazio</p>
                    <p class="sub">Selecione produtos e clique em adicionar</p>
                  </div>
                </div>
              </div>

              <div class="cart-total">
                <span>Total:</span>
                <span id="cartTotal">0 Kz</span>
              </div>

              <div class="cart-actions">
                <button class="btn-green w-100" id="btnFinalizarVenda" disabled>
                  <i class="bi bi-check2-circle"></i> Finalizar Venda
                </button>
                <button class="btn-outline-green w-100 mt-2" id="btnLimparCarrinho">
                  <i class="bi bi-trash"></i> Limpar Carrinho
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Histórico de Vendas -->
      <div class="table-card anim anim-d3 mt-4">
        <div class="table-card-header">
          <div style="display:flex;align-items:center;gap:12px;">
            <h5><i class="bi bi-clock-history me-2" style="color:var(--primary);"></i>Histórico de Vendas</h5>
          </div>
          <div style="display:flex;gap:8px;align-items:center;">
            <span style="font-size:12.5px;color:var(--text-light);" id="vendaTotalCount">0 registos</span>
          </div>
        </div>

        <div class="search-filter-bar">
          <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" class="search-input" id="searchVenda" placeholder="Pesquisar por cliente...">
          </div>
          <select class="filter-select" id="filterVendaStatus">
            <option value="">Todos os status</option>
            <option value="pago">Pago</option>
            <option value="pendente">Pendente</option>
          </select>
          <button class="btn-green" id="btnFiltrarVendas" style="padding:8px 18px;"><i class="bi bi-search"></i> Filtrar</button>
          <button class="btn-outline-green" id="btnLimparFiltrosVendas" style="padding:8px 18px;"><i class="bi bi-eraser"></i> Limpar</button>
        </div>

        <div style="overflow-x:auto;">
          <table class="venda-table" id="vendaTable">
            <thead>
              <tr>
                <th>Nº Venda</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Itens</th>
                <th>Total (Kz)</th>
                <th>Pagamento</th>
                <th>Status</th>
                <th style="text-align:center;">Ações</th>
              </tr>
            </thead>
            <tbody id="vendaTableBody">
              <!-- Vendas serão renderizadas via JS -->
            </tbody>
          </table>
        </div>

        <div class="table-footer">
          <span id="vendaCount">Mostrando 0 de 0 vendas</span>
          <div class="pagination-btns" id="vendaPagination">
            <button class="page-btn" id="vendaPrevPage"><i class="bi bi-chevron-left"></i></button>
            <span class="page-btn active" id="vendaCurrentPage">1</span>
            <button class="page-btn" id="vendaNextPage"><i class="bi bi-chevron-right"></i></button>
          </div>
        </div>
      </div>

    </div><!-- /content-inner -->
  </main>

  <!-- ══════════════════════════════════════
     MODAL — FINALIZAR VENDA (duas colunas)
══════════════════════════════════════ -->
  <div class="modal fade modal-coop" id="modalFinalizarVenda" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-cart-check-fill"></i></div>
            <div>
              <div class="modal-title">Finalizar Venda</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Preencha os dados e confirme</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <!-- COLUNA ESQUERDA - Resumo -->
          <div class="modal-col-resumo">
            <div class="modal-section-title">
              <i class="bi bi-cart-fill"></i> Resumo do Pedido
            </div>

            <div class="resumo-itens">
              <div class="resumo-header">
                <span>Produto</span>
                <span style="text-align:center;">Qtd</span>
                <span style="text-align:right;">Subtotal</span>
              </div>
              <div class="resumo-body" id="resumoItensLista">
                <!-- Itens serão renderizados via JS -->
              </div>
            </div>

            <div class="resumo-total-modal">
              <span>Total</span>
              <span class="total-valor" id="resumoTotalValor">0 Kz</span>
            </div>
          </div>

          <!-- COLUNA DIREITA - Dados Cliente e Pagamento -->
          <div class="modal-col-dados">
            <div class="dados-scroll">
              <div class="modal-section-title">
                <i class="bi bi-person-fill"></i> Dados do Cliente
              </div>

              <form id="formFinalizarVenda">
                @csrf
                <input type="hidden" id="cooperativaId" value="{{ session('cooperativa_id') ?? 1 }}">
                <div class="row g-3">
                  <div class="col-12">
                    <label class="cfg-label" for="clienteNome">Nome do Cliente *</label>
                    <input class="cfg-input" type="text" id="clienteNome" required placeholder="Ex: Mercado de Viana">
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label" for="formaPagamento">Forma de Pagamento</label>
                    <select class="cfg-select" id="formaPagamento">
                      <option value="dinheiro">Dinheiro</option>
                      <option value="transferencia">Transferência Bancária</option>
                      <option value="credito">Crédito</option>
                      <option value="cheque">Cheque</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label" for="vendaStatus">Status da Venda</label>
                    <select class="cfg-select" id="vendaStatus">
                      <option value="pago">Pago</option>
                      <option value="pendente">Pendente</option>
                    </select>
                  </div>
                  <div class="col-12">
                    <label class="cfg-label" for="valorEntregue">Valor Entregue (Kz)</label>
                    <input class="cfg-input" type="number" id="valorEntregue" placeholder="0" min="0" step="1">
                  </div>
                  <div class="col-12">
                    <div class="troco-info">
                      <span>Troco:</span>
                      <span class="troco-valor" id="trocoValor">0 Kz</span>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">
            <i class="bi bi-x-lg"></i> Cancelar
          </button>
          <button type="button" class="btn-green" id="btnConfirmarVenda">
            <i class="bi bi-check2-circle"></i> Finalizar Venda
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════
     MODAL — RESUMO DA VENDA (com scroll e centralizado)
══════════════════════════════════════ -->
  <div class="modal fade modal-resumo" id="modalResumoVenda" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-receipt"></i></div>
            <div>
              <div class="modal-title">Resumo da Venda</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;" id="resumoNumero">#000000</div>
            </div>
          </div>
        </div>

        <div class="modal-body">
          <div class="fatura-preview" id="faturaPreview">
            <div class="fatura-header">
              <div>
                <div class="fatura-titulo">SIAG</div>
                <div style="font-size:12px;color:var(--text-light);">Sistema Integrado de Apoio à Gestão Agrícola</div>
              </div>
              <div>
                <div class="fatura-numero" id="resumoNumeroTop">#000000</div>
                <div style="font-size:11px;color:var(--text-light);" id="resumoData">07/06/2026</div>
              </div>
            </div>

            <div class="fatura-cliente">
              <div class="cliente-nome" id="resumoCliente">—</div>
              <div class="cliente-detalhe">Forma de Pagamento: <span id="resumoPagamento">—</span></div>
              <div class="cliente-detalhe">Status: <span id="resumoStatus">—</span></div>
            </div>

            <div class="fatura-itens">
              <table>
                <thead>
                  <tr>
                    <th>Produto</th>
                    <th style="text-align:center;">Qtd</th>
                    <th style="text-align:right;">Preço</th>
                    <th style="text-align:right;">Subtotal</th>
                  </tr>
                </thead>
                <tbody id="resumoItensBody">
                </tbody>
              </table>
            </div>

            <div class="fatura-total">
              <span>Total</span>
              <span class="total-valor" id="resumoTotal">0 Kz</span>
            </div>

            <div class="fatura-troco">
              <span>Valor Entregue: <span id="resumoEntregue">0 Kz</span></span>
              <span>Troco: <span id="resumoTroco">0 Kz</span></span>
            </div>

            <div class="fatura-rodape">
              Documento gerado automaticamente · Válido sem assinatura
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn-green" id="btnImprimirResumo">
            <i class="bi bi-printer-fill"></i> Imprimir Fatura
          </button>
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">
            <i class="bi bi-check2-circle"></i> Concluir
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Loading Spinner -->
  <div class="spinner-overlay" id="loadingSpinner">
    <div class="spinner-border text-light" style="width: 4rem; height: 4rem;" role="status">
      <span class="visually-hidden">Carregando...</span>
    </div>
  </div>

  <!-- Toast -->
  <div class="save-toast" id="saveToast">
    <div class="toast-icon success" id="toastIcon"><i class="bi bi-check-lg" id="toastIconI"></i></div>
    <div class="toast-text">
      <div class="t-title" id="toastTitle">Operação concluída</div>
      <div class="t-sub" id="toastSub">Acção realizada com sucesso.</div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    /* ══════════════════════════════════════
       CONFIGURAÇÕES
    ══════════════════════════════════════ */
    const COOPERATIVA_ID = {{ session('cooperativa_id') ?? 1 }};
    const PRODUTOS_URL = `/cooperativas/${COOPERATIVA_ID}/produtos/json`;
    const STORE_VENDA_URL = '{{ route("vendas.store") }}';
    const GET_VENDA_URL = '{{ route("vendas.show", "") }}';

    /* ══════════════════════════════════════
       SIDEBAR TOGGLE (3 estados)
    ══════════════════════════════════════ */
    const body = document.body;
    let sideState = 0;

    function applyTooltips() {
      document.querySelectorAll('.nav-item-link').forEach(el => {
        const tip = bootstrap.Tooltip.getInstance(el);
        if (tip) tip.dispose();
      });
      if (body.classList.contains('icons-only')) {
        document.querySelectorAll('.nav-item-link').forEach(el => {
          new bootstrap.Tooltip(el, {
            title: el.dataset.label || '',
            placement: 'right',
            trigger: 'hover',
            customClass: 'sidebar-tooltip'
          });
        });
      }
    }

    document.getElementById('sidebarToggle').addEventListener('click', () => {
      sideState = (sideState + 1) % 3;
      body.classList.remove('icons-only', 'sidebar-hidden');
      if (sideState === 1) body.classList.add('icons-only');
      if (sideState === 2) body.classList.add('sidebar-hidden');
      applyTooltips();
    });

    /* ══════════════════════════════════════
       DARK MODE
    ══════════════════════════════════════ */
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const themeLabel = document.getElementById('themeLabel');
    let darkMode = false;

    themeToggle.addEventListener('click', function(e) {
      e.preventDefault();
      darkMode = !darkMode;
      body.classList.toggle('dark-mode', darkMode);
      themeIcon.className = darkMode ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
      themeLabel.textContent = darkMode ? 'Modo Claro' : 'Modo Escuro';
    });

    /* ══════════════════════════════════════
       NAV ACTIVE SIDEBAR
    ══════════════════════════════════════ */
    document.querySelectorAll('.nav-item-link').forEach(link => {
      link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (!href || href === '#') {
          e.preventDefault();
        }
        document.querySelectorAll('.nav-item-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        const label = this.dataset.label || this.querySelector('.nav-label')?.textContent || '';
        document.querySelector('.topbar-title').textContent = label;
      });
    });

    /* ══════════════════════════════════════
       TOAST
    ══════════════════════════════════════ */
    function showToast(title, sub, type = 'success') {
      const toast = document.getElementById('saveToast');
      const icon = document.getElementById('toastIcon');
      const iconI = document.getElementById('toastIconI');
      document.getElementById('toastTitle').textContent = title;
      document.getElementById('toastSub').textContent = sub;
      icon.className = 'toast-icon ' + (type === 'danger' ? 'danger' : 'success');
      iconI.className = type === 'danger' ? 'bi bi-x-lg' : 'bi bi-check-lg';
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3500);
    }

    /* ══════════════════════════════════════
       LOADING SPINNER
    ══════════════════════════════════════ */
    function showLoading(show = true) {
      document.getElementById('loadingSpinner').classList.toggle('show', show);
    }

    /* ══════════════════════════════════════
       CARREGAR PRODUTOS DA API
    ══════════════════════════════════════ */
    let produtos = [];
    let vendas = [];
    let cart = [];
    let currentFilter = 'todos';
    let currentPage = 1;
    const itemsPerPage = 5;
    let vendaCurrentPage = 1;
    const vendaItemsPerPage = 5;

    async function loadProdutos() {
      showLoading(true);
      try {
        const response = await fetch(PRODUTOS_URL);
        const data = await response.json();

        if (Array.isArray(data)) {
          produtos = data.map(p => ({
            id: p.id,
            nome: p.nome,
            categoria: p.categoria || 'Outro',
            stock: parseFloat(p.quantidade) || 0,
            preco: parseFloat(p.preco_venda) || 0,
            unidade: p.unidade || 'un'
          }));
        } else if (data.data && Array.isArray(data.data)) {
          produtos = data.data.map(p => ({
            id: p.id,
            nome: p.nome,
            categoria: p.categoria || 'Outro',
            stock: parseFloat(p.quantidade) || 0,
            preco: parseFloat(p.preco_venda) || 0,
            unidade: p.unidade || 'un'
          }));
        }

        updateFilterCounts();
        renderProducts();
        showLoading(false);
      } catch (error) {
        console.error('Erro ao carregar produtos:', error);
        showToast('Erro', 'Não foi possível carregar os produtos.', 'danger');
        showLoading(false);
      }
    }

    /* ══════════════════════════════════════
       CARREGAR VENDAS (mock para demonstração)
    ══════════════════════════════════════ */
    function loadVendas() {
      // Aqui você pode carregar as vendas da API
      // Por enquanto, usamos dados mock
      vendas = [
        { id: 1, cliente: 'Mercado de Viana', total: 42500, forma_pagamento: 'dinheiro', status: 'pago', itens: [{produto: 'Milho', quantidade: 2, preco: 12000}, {produto: 'Feijão', quantidade: 1, preco: 18500}] },
        { id: 2, cliente: 'Cooperativa Central', total: 28500, forma_pagamento: 'transferencia', status: 'pendente', itens: [{produto: 'Mandioca', quantidade: 3, preco: 8500}] },
        { id: 3, cliente: 'Mercado do Kilamba', total: 15000, forma_pagamento: 'dinheiro', status: 'pago', itens: [{produto: 'Arroz', quantidade: 1, preco: 15000}] },
      ];
      renderVendas();
      updateVendaCounts();
    }

    /* ══════════════════════════════════════
       FUNÇÕES DE FILTRO E RENDERIZAÇÃO DE PRODUTOS
    ══════════════════════════════════════ */
    function getFilteredProducts() {
      let filtered = [...produtos];
      const search = document.getElementById('searchProduto').value.toLowerCase().trim();
      const categoria = document.getElementById('filterCategoria').value;

      if (search) {
        filtered = filtered.filter(p => p.nome.toLowerCase().includes(search));
      }

      if (categoria) {
        filtered = filtered.filter(p => p.categoria === categoria);
      }

      if (currentFilter === 'mais-vendidos') {
        filtered = filtered.sort((a, b) => b.stock - a.stock);
      } else if (currentFilter !== 'todos') {
        const categoriaMap = {
          'frutas': 'Fruta',
          'graos': 'Grao',
          'legumes': 'Legume',
          'tuberculos': 'Tuberculo'
        };
        const cat = categoriaMap[currentFilter];
        if (cat) {
          filtered = filtered.filter(p => p.categoria === cat);
        }
      }

      return filtered;
    }

    function updateFilterCounts() {
      const total = produtos.length;
      const maisVendidos = [...produtos].sort((a, b) => b.stock - a.stock).slice(0, 5).length;
      const frutas = produtos.filter(p => p.categoria === 'Fruta').length;
      const graos = produtos.filter(p => p.categoria === 'Grao').length;
      const legumes = produtos.filter(p => p.categoria === 'Legume').length;
      const tuberculos = produtos.filter(p => p.categoria === 'Tuberculo').length;

      document.getElementById('countTodos').textContent = total;
      document.getElementById('countMaisVendidos').textContent = maisVendidos;
      document.getElementById('countFrutas').textContent = frutas;
      document.getElementById('countGraos').textContent = graos;
      document.getElementById('countLegumes').textContent = legumes;
      document.getElementById('countTuberculos').textContent = tuberculos;
    }

    function renderProducts() {
      const filtered = getFilteredProducts();
      const totalPages = Math.ceil(filtered.length / itemsPerPage) || 1;

      if (currentPage > totalPages) currentPage = totalPages;

      const start = (currentPage - 1) * itemsPerPage;
      const paginated = filtered.slice(start, start + itemsPerPage);

      const tbody = document.getElementById('produtoTableBody');
      if (paginated.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
              <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
              Nenhum produto encontrado.
            </td>
          </tr>
        `;
      } else {
        tbody.innerHTML = paginated.map(p => `
          <tr id="produto-row-${p.id}" data-nome="${p.nome}" data-preco="${p.preco}" data-stock="${p.stock}" data-categoria="${p.categoria}">
            <td>
              <input type="checkbox" class="row-check produto-check" style="accent-color:var(--primary);width:15px;height:15px;cursor:pointer;">
            </td>
            <td>
              <div style="font-weight:600;font-size:14px;">${p.nome}</div>
            </td>
            <td>${p.categoria}</td>
            <td>${p.stock} ${p.unidade || 'un'}</td>
            <td><strong>${p.preco.toLocaleString('pt-AO')}</strong></td>
            <td style="text-align:center;">
              <input type="number" class="form-control form-control-sm qtd-input" style="width:70px;display:inline-block;text-align:center;" value="1" min="1" max="${p.stock}">
            </td>
            <td style="text-align:center;">
              <button class="action-btn add btn-add-cart" data-id="${p.id}" data-nome="${p.nome}" data-preco="${p.preco}" data-stock="${p.stock}">
                <i class="bi bi-cart-plus"></i>
              </button>
            </td>
          </tr>
        `).join('');
      }

      document.getElementById('produtoCount').textContent = filtered.length + ' produtos';
      document.getElementById('tableCount').textContent = `Mostrando ${paginated.length} de ${filtered.length} produtos`;
      document.getElementById('prodCurrentPage').textContent = currentPage;
      document.getElementById('prodPrevPage').disabled = currentPage <= 1;
      document.getElementById('prodNextPage').disabled = currentPage >= totalPages;

      updateFilterCounts();
    }

    /* ══════════════════════════════════════
       RENDERIZAR VENDAS
    ══════════════════════════════════════ */
    function updateVendaCounts() {
      document.getElementById('vendaTotalCount').textContent = vendas.length + ' registos';
    }

    function renderVendas() {
      const filtered = getFilteredVendas();
      const totalPages = Math.ceil(filtered.length / vendaItemsPerPage) || 1;

      if (vendaCurrentPage > totalPages) vendaCurrentPage = totalPages;

      const start = (vendaCurrentPage - 1) * vendaItemsPerPage;
      const paginated = filtered.slice(start, start + vendaItemsPerPage);

      const tbody = document.getElementById('vendaTableBody');
      if (paginated.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="8" style="text-align:center;padding:40px;color:var(--text-light);">
              <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
              Nenhuma venda registada.
            </td>
          </tr>
        `;
      } else {
        tbody.innerHTML = paginated.map(v => `
          <tr data-status="${v.status}">
            <td><strong>#${String(v.id).padStart(6, '0')}</strong></td>
            <td>${new Date().toLocaleDateString('pt-PT')}</td>
            <td>${v.cliente}</td>
            <td>${v.itens.length} itens</td>
            <td><strong>${v.total.toLocaleString('pt-AO')}</strong></td>
            <td>${v.forma_pagamento}</td>
            <td>
              <span class="badge-status ${v.status}">
                <span class="dot"></span>
                ${v.status === 'pago' ? 'Pago' : 'Pendente'}
              </span>
            </td>
            <td style="text-align:center;">
              <div style="display:flex;gap:6px;justify-content:center;">
                <button class="action-btn view btn-ver-venda" title="Ver detalhes" data-id="${v.id}">
                  <i class="bi bi-eye-fill"></i>
                </button>
                <button class="action-btn print btn-imprimir-venda" title="Imprimir Fatura" data-id="${v.id}">
                  <i class="bi bi-printer-fill"></i>
                </button>
              </div>
            </td>
          </tr>
        `).join('');
      }

      document.getElementById('vendaCount').textContent = `Mostrando ${paginated.length} de ${filtered.length} vendas`;
      document.getElementById('vendaCurrentPage').textContent = vendaCurrentPage;
      document.getElementById('vendaPrevPage').disabled = vendaCurrentPage <= 1;
      document.getElementById('vendaNextPage').disabled = vendaCurrentPage >= totalPages;
    }

    function getFilteredVendas() {
      let filtered = [...vendas];
      const search = document.getElementById('searchVenda').value.toLowerCase().trim();
      const status = document.getElementById('filterVendaStatus').value;

      if (search) {
        filtered = filtered.filter(v => v.cliente.toLowerCase().includes(search));
      }

      if (status) {
        filtered = filtered.filter(v => v.status === status);
      }

      return filtered;
    }

    /* ══════════════════════════════════════
       FILTER BUTTONS
    ══════════════════════════════════════ */
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        currentFilter = this.dataset.filter;
        currentPage = 1;
        renderProducts();
      });
    });

    /* ══════════════════════════════════════
       PAGINAÇÃO PRODUTOS
    ══════════════════════════════════════ */
    document.getElementById('prodPrevPage').addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        renderProducts();
      }
    });

    document.getElementById('prodNextPage').addEventListener('click', () => {
      const filtered = getFilteredProducts();
      const totalPages = Math.ceil(filtered.length / itemsPerPage);
      if (currentPage < totalPages) {
        currentPage++;
        renderProducts();
      }
    });

    /* ══════════════════════════════════════
       PAGINAÇÃO VENDAS
    ══════════════════════════════════════ */
    document.getElementById('vendaPrevPage').addEventListener('click', () => {
      if (vendaCurrentPage > 1) {
        vendaCurrentPage--;
        renderVendas();
      }
    });

    document.getElementById('vendaNextPage').addEventListener('click', () => {
      const filtered = getFilteredVendas();
      const totalPages = Math.ceil(filtered.length / vendaItemsPerPage);
      if (vendaCurrentPage < totalPages) {
        vendaCurrentPage++;
        renderVendas();
      }
    });

    /* ══════════════════════════════════════
       FILTROS (search e categoria)
    ══════════════════════════════════════ */
    document.getElementById('btnFiltrar').addEventListener('click', () => {
      currentPage = 1;
      renderProducts();
    });

    document.getElementById('btnLimparFiltros').addEventListener('click', () => {
      document.getElementById('searchProduto').value = '';
      document.getElementById('filterCategoria').value = '';
      currentPage = 1;
      renderProducts();
    });

    document.getElementById('searchProduto').addEventListener('keyup', (e) => {
      if (e.key === 'Enter') {
        currentPage = 1;
        renderProducts();
      }
    });

    /* ══════════════════════════════════════
       FILTROS VENDAS
    ══════════════════════════════════════ */
    document.getElementById('btnFiltrarVendas').addEventListener('click', () => {
      vendaCurrentPage = 1;
      renderVendas();
    });

    document.getElementById('btnLimparFiltrosVendas').addEventListener('click', () => {
      document.getElementById('searchVenda').value = '';
      document.getElementById('filterVendaStatus').value = '';
      vendaCurrentPage = 1;
      renderVendas();
    });

    document.getElementById('searchVenda').addEventListener('keyup', (e) => {
      if (e.key === 'Enter') {
        vendaCurrentPage = 1;
        renderVendas();
      }
    });

    /* ══════════════════════════════════════
       CARRINHO DE COMPRAS
    ══════════════════════════════════════ */
    function renderCart() {
      const container = document.getElementById('cartItems');
      const totalSpan = document.getElementById('cartTotal');
      const countSpan = document.getElementById('cartCount');
      const btnFinalizar = document.getElementById('btnFinalizarVenda');

      if (cart.length === 0) {
        container.innerHTML = `
          <div class="cart-empty">
            <i class="bi bi-cart"></i>
            <p>Seu carrinho está vazio</p>
            <p class="sub">Selecione produtos e clique em adicionar</p>
          </div>
        `;
        totalSpan.textContent = '0 Kz';
        countSpan.textContent = '0 itens';
        btnFinalizar.disabled = true;
        return;
      }

      let html = '';
      let total = 0;
      let totalItens = 0;

      cart.forEach((item, index) => {
        const subtotal = item.preco * item.quantidade;
        total += subtotal;
        totalItens += item.quantidade;
        html += `
          <div class="cart-item">
            <div class="item-info">
              <div class="item-name">${item.nome}</div>
              <div class="item-detail">${item.quantidade} x ${item.preco.toLocaleString('pt-AO')} Kz</div>
            </div>
            <div class="item-price">${subtotal.toLocaleString('pt-AO')} Kz</div>
            <button class="btn-remove-item" onclick="removeFromCart(${index})">
              <i class="bi bi-x-circle-fill"></i>
            </button>
          </div>
        `;
      });

      container.innerHTML = html;
      totalSpan.textContent = total.toLocaleString('pt-AO') + ' Kz';
      countSpan.textContent = totalItens + ' itens';
      btnFinalizar.disabled = false;
    }

    function addToCart(id, nome, preco, stock) {
      const row = document.querySelector(`#produto-row-${id}`);
      const qtdInput = row ? row.querySelector('.qtd-input') : null;
      const qtd = parseInt(qtdInput ? qtdInput.value : 1);

      if (qtd < 1 || qtd > stock) {
        showToast('Quantidade inválida', 'Verifique a quantidade disponível.', 'danger');
        return;
      }

      const existing = cart.find(item => item.id === id);
      if (existing) {
        const newQtd = existing.quantidade + qtd;
        if (newQtd > stock) {
          showToast('Quantidade excedida', 'Não há stock suficiente.', 'danger');
          return;
        }
        existing.quantidade = newQtd;
      } else {
        cart.push({ id, nome, preco: parseFloat(preco), quantidade: qtd });
      }

      renderCart();
      showToast('Produto adicionado', `${nome} adicionado ao carrinho.`);
    }

    function removeFromCart(index) {
      const item = cart[index];
      cart.splice(index, 1);
      renderCart();
      showToast('Produto removido', `${item.nome} removido do carrinho.`);
    }

    document.getElementById('btnLimparCarrinho').addEventListener('click', () => {
      if (cart.length === 0) return;
      if (confirm('Tem certeza que deseja limpar o carrinho?')) {
        cart = [];
        renderCart();
        showToast('Carrinho limpo', 'Todos os itens foram removidos.');
      }
    });

    /* ══════════════════════════════════════
       ADICIONAR PRODUTOS AO CARRINHO
    ══════════════════════════════════════ */
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.btn-add-cart');
      if (!btn) return;

      const id = parseInt(btn.dataset.id);
      const nome = btn.dataset.nome;
      const preco = parseFloat(btn.dataset.preco);
      const stock = parseInt(btn.dataset.stock);

      addToCart(id, nome, preco, stock);
    });

    /* ══════════════════════════════════════
       SELECT ALL
    ══════════════════════════════════════ */
    document.getElementById('selectAll').addEventListener('change', function() {
      document.querySelectorAll('.produto-check').forEach(cb => cb.checked = this.checked);
    });

    /* ══════════════════════════════════════
       NOVA VENDA (botão)
    ══════════════════════════════════════ */
    document.getElementById('btnNovaVenda').addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
      showToast('Nova Venda', 'Selecione os produtos e adicione ao carrinho.');
    });

    /* ══════════════════════════════════════
       EXPORTAR
    ══════════════════════════════════════ */
    document.getElementById('btnExportar').addEventListener('click', () => {
      showToast('A exportar…', 'O ficheiro será gerado e descarregado em breve.');
    });

    /* ══════════════════════════════════════
       CÁLCULO DO TROCO
    ══════════════════════════════════════ */
    document.getElementById('valorEntregue').addEventListener('input', function() {
      const total = cart.reduce((sum, item) => sum + (item.preco * item.quantidade), 0);
      const entregue = parseFloat(this.value) || 0;
      const troco = entregue - total;
      const trocoElement = document.getElementById('trocoValor');

      if (troco >= 0) {
        trocoElement.textContent = troco.toLocaleString('pt-AO') + ' Kz';
        trocoElement.className = 'troco-valor';
      } else {
        trocoElement.textContent = 'Falta ' + Math.abs(troco).toLocaleString('pt-AO') + ' Kz';
        trocoElement.className = 'troco-valor negativo';
      }
    });

    /* ══════════════════════════════════════
       FINALIZAR VENDA (Modal)
    ══════════════════════════════════════ */
    const modalFinalizar = new bootstrap.Modal(document.getElementById('modalFinalizarVenda'));
    const modalResumo = new bootstrap.Modal(document.getElementById('modalResumoVenda'));

    document.getElementById('btnFinalizarVenda').addEventListener('click', () => {
      if (cart.length === 0) {
        showToast('Carrinho vazio', 'Adicione produtos antes de finalizar.', 'warning');
        return;
      }

      renderResumoModal();

      document.getElementById('valorEntregue').value = '';
      document.getElementById('trocoValor').textContent = '0 Kz';
      document.getElementById('trocoValor').className = 'troco-valor';
      document.getElementById('formFinalizarVenda').reset();

      modalFinalizar.show();
    });

    function renderResumoModal() {
      const container = document.getElementById('resumoItensLista');
      const totalElement = document.getElementById('resumoTotalValor');

      if (cart.length === 0) {
        container.innerHTML = '<p style="color:var(--text-light);padding:16px;text-align:center;">Nenhum item no carrinho</p>';
        totalElement.textContent = '0 Kz';
        return;
      }

      let total = 0;
      let html = '';

      cart.forEach(item => {
        const subtotal = item.preco * item.quantidade;
        total += subtotal;
        html += `
          <div class="resumo-item">
            <span class="item-nome">${item.nome}</span>
            <span class="item-qtd">${item.quantidade}x</span>
            <span class="item-subtotal">${subtotal.toLocaleString('pt-AO')} Kz</span>
          </div>
        `;
      });

      container.innerHTML = html;
      totalElement.textContent = total.toLocaleString('pt-AO') + ' Kz';
    }

    document.getElementById('btnConfirmarVenda').addEventListener('click', async function() {
      const cliente = document.getElementById('clienteNome').value.trim();
      if (!cliente) {
        showToast('Campo obrigatório', 'Informe o nome do cliente.', 'danger');
        return;
      }

      const total = cart.reduce((sum, item) => sum + (item.preco * item.quantidade), 0);
      const entregue = parseFloat(document.getElementById('valorEntregue').value) || 0;
      const troco = entregue - total;

      if (entregue > 0 && troco < 0) {
        showToast('Valor insuficiente', 'O valor entregue é menor que o total da venda.', 'danger');
        return;
      }

      const btn = this;
      btn.disabled = true;
      btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processando...';

      const dadosVenda = {
        cooperativa_id: parseInt(document.getElementById('cooperativaId').value),
        cliente: cliente,
        forma_pagamento: document.getElementById('formaPagamento').value,
        status: document.getElementById('vendaStatus').value,
        valor_entregue: entregue,
        itens: cart.map(item => ({
          produto_id: item.id,
          quantidade: item.quantidade,
          preco_unitario: item.preco
        }))
      };

      try {
        const response = await fetch(STORE_VENDA_URL, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify(dadosVenda)
        });

        const result = await response.json();

        if (result.success) {
          // Fechar modal de finalização
          modalFinalizar.hide();

          // Preparar resumo
          document.getElementById('resumoNumero').textContent = '#' + result.numero;
          document.getElementById('resumoNumeroTop').textContent = '#' + result.numero;
          document.getElementById('resumoData').textContent = new Date().toLocaleDateString('pt-PT');
          document.getElementById('resumoCliente').textContent = cliente;
          document.getElementById('resumoPagamento').textContent = document.getElementById('formaPagamento').options[document.getElementById('formaPagamento').selectedIndex].text;
          document.getElementById('resumoStatus').textContent = document.getElementById('vendaStatus').value === 'pago' ? 'Pago' : 'Pendente';
          document.getElementById('resumoTotal').textContent = total.toLocaleString('pt-AO') + ' Kz';
          document.getElementById('resumoEntregue').textContent = entregue.toLocaleString('pt-AO') + ' Kz';
          document.getElementById('resumoTroco').textContent = troco >= 0 ? troco.toLocaleString('pt-AO') + ' Kz' : '—';

          // Itens
          const itensBody = document.getElementById('resumoItensBody');
          itensBody.innerHTML = cart.map(item => `
            <tr>
              <td>${item.nome}</td>
              <td style="text-align:center;">${item.quantidade}</td>
              <td style="text-align:right;">${item.preco.toLocaleString('pt-AO')} Kz</td>
              <td style="text-align:right;">${(item.preco * item.quantidade).toLocaleString('pt-AO')} Kz</td>
            </tr>
          `).join('');

          // Adicionar venda ao histórico
          vendas.unshift({
            id: result.venda_id,
            cliente: cliente,
            total: total,
            forma_pagamento: document.getElementById('formaPagamento').value,
            status: document.getElementById('vendaStatus').value,
            itens: cart.map(item => ({
              produto: item.nome,
              quantidade: item.quantidade,
              preco: item.preco
            }))
          });

          // Limpar carrinho
          cart = [];
          renderCart();

          // Abrir modal de resumo
          modalResumo.show();

          showToast('Venda realizada', `Venda #${result.numero} registada com sucesso!`);

          // Re-renderizar vendas
          renderVendas();
          updateVendaCounts();
        } else {
          showToast('Erro', result.message || 'Erro ao realizar venda.', 'danger');
        }
      } catch (error) {
        console.error('Erro ao salvar venda:', error);
        showToast('Erro', 'Erro ao conectar com o servidor.', 'danger');
      } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check2-circle"></i> Finalizar Venda';
      }
    });

    /* ══════════════════════════════════════
       IMPRIMIR RESUMO / FATURA
    ══════════════════════════════════════ */
    document.getElementById('btnImprimirResumo').addEventListener('click', function() {
      const conteudo = document.getElementById('faturaPreview').innerHTML;
      const janela = window.open('', '_blank', 'width=800,height=600');
      janela.document.write(`
        <html>
          <head>
            <title>Fatura SIAG</title>
            <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
            <style>
              body { font-family: 'DM Sans', sans-serif; padding: 40px; background: #fff; }
              .fatura-preview { max-width: 600px; margin: 0 auto; }
              .fatura-header { display: flex; justify-content: space-between; border-bottom: 2px solid #2E7D32; padding-bottom: 12px; margin-bottom: 16px; }
              .fatura-titulo { font-size: 20px; font-weight: 700; color: #2E7D32; }
              .fatura-numero { font-size: 13px; color: #8FA894; text-align: right; }
              .fatura-cliente { margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #eee; }
              .cliente-nome { font-weight: 600; font-size: 15px; }
              .cliente-detalhe { font-size: 12px; color: #8FA894; }
              table { width: 100%; font-size: 13px; border-collapse: collapse; }
              th { font-size: 11px; text-transform: uppercase; color: #8FA894; border-bottom: 1px solid #eee; padding: 8px 0; text-align: left; }
              td { padding: 6px 0; border-bottom: 1px solid #eee; }
              td:last-child { text-align: right; }
              .fatura-total { margin-top: 16px; padding-top: 12px; border-top: 2px solid #2E7D32; display: flex; justify-content: space-between; font-size: 16px; font-weight: 700; }
              .total-valor { color: #2E7D32; font-size: 20px; }
              .fatura-troco { display: flex; justify-content: space-between; font-size: 14px; padding-top: 4px; color: #4A6350; }
              .fatura-rodape { margin-top: 16px; padding-top: 12px; border-top: 1px solid #eee; font-size: 11px; color: #8FA894; text-align: center; }
              @media print { body { padding: 20px; } }
            </style>
          </head>
          <body>
            <div class="fatura-preview">${conteudo}</div>
            <script>
              window.onload = function() { window.print(); window.close(); }
            <\/script>
          </body>
        </html>
      `);
      janela.document.close();
    });

    /* ══════════════════════════════════════
       VER VENDA (detalhes)
    ══════════════════════════════════════ */
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.btn-ver-venda');
      if (!btn) return;

      const vendaId = btn.dataset.id;
      // Aqui você pode buscar os detalhes da venda da API
      showToast('Detalhes da Venda', `Venda #${String(vendaId).padStart(6, '0')} - Funcionalidade em desenvolvimento.`);
    });

    /* ══════════════════════════════════════
       IMPRIMIR VENDA
    ══════════════════════════════════════ */
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.btn-imprimir-venda');
      if (!btn) return;
      showToast('Imprimir Fatura', 'A fatura será gerada para impressão.');
    });

    /* ══════════════════════════════════════
       INICIALIZAÇÃO
    ══════════════════════════════════════ */
    loadProdutos();
    loadVendas();
  </script>

</body>

</html>
