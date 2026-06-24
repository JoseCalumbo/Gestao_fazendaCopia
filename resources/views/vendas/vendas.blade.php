[file name]: vendas.blade.php
[file content begin]
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

    *,
    *::before,
    *::after {
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
       SIDEBAR
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

    body.icons-only #sidebar {
      width: var(--sidebar-w-icons);
    }

    body.sidebar-hidden #sidebar {
      width: 0;
    }

    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 15px;
      border-bottom: 1px solid rgba(255, 255, 255, .1);
      white-space: nowrap;
      min-height: var(--topbar-h);
      overflow: hidden;
    }

    body.icons-only .sidebar-logo {
      justify-content: center;
      padding: 14px 0;
    }

    body.icons-only .sidebar-logo .logo-text-wrap {
      opacity: 0;
      pointer-events: none;
      width: 0;
      overflow: hidden;
    }

    .sidebar-nav {
      flex: 1;
      padding: 12px 0;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .sidebar-nav::-webkit-scrollbar {
      width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, .18);
      border-radius: 10px;
    }

    .sidebar-nav {
      scrollbar-width: thin;
      scrollbar-color: rgba(255, 255, 255, .18) transparent;
    }

    .nav-section-title {
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: rgba(255, 255, 255, .4);
      padding: 18px 20px 6px;
      white-space: nowrap;
      transition: opacity .2s;
    }

    body.icons-only .nav-section-title {
      opacity: 0;
      height: 0;
      padding: 0;
      overflow: hidden;
    }

    .nav-item-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 18px;
      color: rgba(255, 255, 255, .75);
      text-decoration: none;
      border-radius: 10px;
      margin: 2px 8px;
      transition: background .2s, color .15s;
      white-space: nowrap;
      position: relative;
    }

    .nav-item-link i {
      font-size: 18px;
      flex-shrink: 0;
      width: 22px;
      text-align: center;
    }

    .nav-item-link .nav-label {
      font-size: 14px;
      font-weight: 500;
      opacity: 1;
      transition: opacity .2s;
    }

    body.icons-only .nav-item-link .nav-label {
      opacity: 0;
      pointer-events: none;
      width: 0;
      overflow: hidden;
    }

    body.icons-only .nav-item-link {
      justify-content: center;
      padding: 11px 0;
      margin: 2px 6px;
    }

    .nav-item-link:hover {
      background: rgba(255, 255, 255, .1);
      color: #fff;
    }

    .nav-item-link.active {
      background: var(--accent);
      color: #fff;
      box-shadow: 0 4px 14px rgba(102, 187, 106, .35);
    }

    .sidebar-tooltip .tooltip-inner {
      background: #0f3d14;
      color: #fff;
      font-size: 12.5px;
      font-weight: 500;
      padding: 5px 12px;
      border-radius: 8px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, .3);
    }

    .sidebar-tooltip.bs-tooltip-end .tooltip-arrow::before {
      border-right-color: #0f3d14;
    }

    .sidebar-user {
      padding: 14px 10px;
      border-top: 1px solid rgba(255, 255, 255, .1);
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      transition: background .2s;
      border-radius: 10px;
      margin: 4px 6px;
      white-space: nowrap;
    }

    .sidebar-user:hover {
      background: rgba(255, 255, 255, .08);
    }

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

    .sidebar-user .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .sidebar-user .avatar i {
      color: #fff;
      font-size: 16px;
    }

    .sidebar-user .user-info {
      opacity: 1;
      transition: opacity .2s;
    }

    .sidebar-user .user-info .u-name {
      font-size: 13px;
      font-weight: 600;
      color: #fff;
    }

    .sidebar-user .user-info .u-role {
      font-size: 11px;
      color: rgba(255, 255, 255, .5);
    }

    body.icons-only .sidebar-user .user-info {
      opacity: 0;
      pointer-events: none;
    }

    /* ═══════════════════════════════════════════
       TOPBAR
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

    body.icons-only #topbar {
      left: var(--sidebar-w-icons);
    }

    body.sidebar-hidden #topbar {
      left: 0;
    }

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

    .topbar-toggle:hover {
      background: var(--accent-lt);
      color: var(--primary);
    }

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

    .topbar-icon-btn:hover {
      background: var(--primary);
      color: #fff;
    }

    .bi {
      color: var(--primary);
    }

    .nav-item-link .bi,
    .sidebar-logo .bi,
    .sidebar-user .bi,
    .modal-header .bi,
    .modal-header-icon .bi,
    .btn-green .bi,
    .topbar-icon-btn:hover .bi,
    .action-btn.edit:hover .bi,
    .action-btn.print:hover .bi,
    .action-btn.delete:hover .bi,
    .action-btn.view:hover .bi {
      color: inherit;
    }

    .topbar-title .bi,
    .table-card-header .bi,
    .cfg-card-title .bi,
    .modal-section-title .bi {
      color: var(--primary);
    }

    .badge-status .bi,
    .stat-badge .bi {
      color: inherit;
    }

    .search-wrap .bi {
      color: var(--text-light);
    }

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

    .topbar-user:hover {
      background: #C8E6C9;
    }

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

    .topbar-user .t-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .avatar-md {
      width: 30px !important;
      height: 30px;
      object-fit: cover;
      border-radius: 50%;
    }

    .topbar-user .t-avatar i {
      color: #fff;
      font-size: 14px;
    }

    .topbar-user span {
      font-size: 13px;
      font-weight: 500;
      color: var(--primary);
    }

    .dropdown-menu-user {
      min-width: 200px;
      border: 1px solid var(--border);
      border-radius: 14px;
      box-shadow: 0 12px 36px rgba(0, 0, 0, .12);
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

    .dropdown-menu-user .dropdown-item i {
      font-size: 15px;
      color: var(--text-light);
    }

    .dropdown-menu-user .dropdown-item:hover {
      background: var(--accent-lt);
      color: var(--primary);
    }

    .dropdown-menu-user .dropdown-item:hover i {
      color: var(--primary);
    }

    .dropdown-menu-user .dropdown-divider {
      margin: 4px 6px;
      border-color: var(--border);
    }

    .dropdown-menu-user .item-logout {
      color: #C62828;
    }

    .dropdown-menu-user .item-logout i {
      color: #C62828;
    }

    .dropdown-menu-user .item-logout:hover {
      background: #FFEBEE;
      color: #C62828;
    }

    .dropdown-menu-user form {
      margin: 0;
    }

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

    .dropdown-menu-user form button:hover {
      background: #FFEBEE;
    }

    .dropdown-menu-user form button i {
      font-size: 15px;
      color: #C62828;
    }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════ */
    #main {
      margin-left: var(--sidebar-w);
      padding-top: var(--topbar-h);
      transition: margin-left .3s ease;
      min-height: 100vh;
    }

    body.icons-only #main {
      margin-left: var(--sidebar-w-icons);
    }

    body.sidebar-hidden #main {
      margin-left: 0;
    }

    .content-inner {
      padding: 28px;
    }

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

    .page-header p {
      font-size: 13.5px;
      color: var(--text-light);
    }

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

    .btn-green:hover {
      background: var(--accent);
      color: #fff;
    }

    .btn-green:active {
      transform: scale(.97);
    }

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

    .btn-outline-green:hover {
      background: var(--accent-lt);
      color: var(--primary);
    }

    /* ═══════════════════════════════════════════
       STAT CARDS
    ═══════════════════════════════════════════ */
    .stat-card {
      background: var(--card-bg);
      border-radius: 16px;
      padding: 22px 20px;
      border: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 16px;
      transition: box-shadow .2s, transform .2s;
    }

    .stat-card:hover {
      box-shadow: 0 8px 28px rgba(46, 125, 50, .1);
      transform: translateY(-2px);
    }

    .stat-icon {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 22px;
    }

    .stat-icon.green {
      background: var(--accent-lt);
      color: var(--primary);
    }

    .stat-icon.blue {
      background: #E3F2FD;
      color: #1565C0;
    }

    .stat-icon.amber {
      background: #FFF8E1;
      color: #F57F17;
    }

    .stat-icon.purple {
      background: #EDE7F6;
      color: #6A1B9A;
    }

    .stat-info .s-label {
      font-size: 12.5px;
      color: var(--text-light);
      margin-bottom: 4px;
    }

    .stat-info .s-value {
      font-family: 'Sora', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--text-dark);
      line-height: 1;
      margin-bottom: 5px;
    }

    .stat-badge {
      font-size: 11.5px;
      font-weight: 600;
      padding: 3px 8px;
      border-radius: 30px;
      display: inline-flex;
      align-items: center;
      gap: 3px;
    }

    .stat-badge.up {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .stat-badge.info {
      background: #E3F2FD;
      color: #1565C0;
    }

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

    /* Search bar */
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
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
      background: #fff;
    }

    .search-input::placeholder {
      color: #C3B8B4;
    }

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
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
    }

    /* Vendas Table */
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

    .venda-table tr:last-child td {
      border-bottom: none;
    }

    .venda-table tbody tr:hover td {
      background: #F8FBF8;
    }

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

    .badge-status.pago {
      color: #2E7D32;
    }

    .badge-status.pendente {
      color: #F57F17;
    }

    .badge-status.cancelado {
      color: #C62828;
    }

    .badge-status .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      display: inline-block;
    }

    .badge-status.pago .dot {
      background: #2E7D32;
    }

    .badge-status.pendente .dot {
      background: #F57F17;
    }

    .badge-status.cancelado .dot {
      background: #C62828;
    }

    /* Action buttons */
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

    .action-btn.view {
      background: #EDE7F6;
      color: #6A1B9A;
    }

    .action-btn.view:hover {
      background: #6A1B9A;
      color: #fff;
    }

    .action-btn.print {
      background: #E3F2FD;
      color: #1565C0;
    }

    .action-btn.print:hover {
      background: #1565C0;
      color: #fff;
    }

    /* Pagination */
    .table-footer {
      padding: 14px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid var(--border);
      flex-wrap: wrap;
      gap: 10px;
    }

    .table-footer span {
      font-size: 12.5px;
      color: var(--text-light);
    }

    .pagination-btns {
      display: flex;
      gap: 6px;
    }

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

    .page-btn:hover {
      border-color: var(--primary);
      color: var(--primary);
    }

    .page-btn.active {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
    }

    /* ═══════════════════════════════════════════
       CARRINHO DE COMPRAS (Painel lateral)
    ═══════════════════════════════════════════ */
    .cart-panel {
      background: var(--card-bg);
      border-radius: 16px;
      border: 1px solid var(--border);
      padding: 20px;
      position: sticky;
      top: calc(var(--topbar-h) + 28px);
    }

    .cart-panel .cart-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--border);
    }

    .cart-panel .cart-header h6 {
      font-family: 'Sora', sans-serif;
      font-weight: 600;
      color: var(--text-dark);
      margin: 0;
    }

    .cart-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 0;
      border-bottom: 1px solid var(--border);
      font-size: 13px;
    }

    .cart-item:last-child {
      border-bottom: none;
    }

    .cart-item .item-info {
      flex: 1;
    }

    .cart-item .item-info .item-name {
      font-weight: 500;
      color: var(--text-dark);
    }

    .cart-item .item-info .item-detail {
      font-size: 12px;
      color: var(--text-light);
    }

    .cart-item .item-qty {
      margin: 0 12px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .cart-item .item-price {
      font-weight: 600;
      color: var(--primary);
      min-width: 80px;
      text-align: right;
    }

    .cart-item .btn-remove-item {
      background: none;
      border: none;
      color: var(--danger);
      cursor: pointer;
      padding: 0 4px;
      font-size: 16px;
    }

    .cart-item .btn-remove-item:hover {
      color: #b71c1c;
    }

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
    }

    .cart-empty {
      text-align: center;
      padding: 30px 0;
      color: var(--text-light);
    }

    .cart-empty i {
      font-size: 48px;
      display: block;
      margin-bottom: 12px;
      opacity: .4;
    }

    /* ═══════════════════════════════════════════
       MODAL — VER VENDA
    ═══════════════════════════════════════════ */
    .modal-coop {
      max-width: 700px;
    }

    .modal-content {
      border: none;
      border-radius: 18px;
      box-shadow: 0 24px 64px rgba(0, 0, 0, .15);
      overflow: hidden;
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

    .modal-header .btn-close:hover {
      opacity: 1;
    }

    .modal-header-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: rgba(255, 255, 255, .2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 17px;
      color: #fff;
      flex-shrink: 0;
    }

    .modal-body {
      background: #fff;
      padding: 24px;
    }

    .modal-footer {
      padding: 14px 20px;
      border-top: 1px solid var(--border);
      background: #fff;
      flex-shrink: 0;
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
      box-shadow: 0 12px 36px rgba(0, 0, 0, .12);
      display: flex;
      align-items: center;
      gap: 12px;
      transform: translateY(80px);
      opacity: 0;
      transition: all .35s cubic-bezier(.34, 1.56, .64, 1);
      pointer-events: none;
    }

    .save-toast.show {
      transform: translateY(0);
      opacity: 1;
      pointer-events: all;
    }

    .save-toast .toast-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .save-toast .toast-icon.success {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .save-toast .toast-icon.danger {
      background: #FFEBEE;
      color: #C62828;
    }

    .save-toast .toast-text .t-title {
      font-size: 13.5px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .save-toast .toast-text .t-sub {
      font-size: 12px;
      color: var(--text-light);
    }

    /* Animations */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(14px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .anim {
      animation: fadeUp .4s ease both;
    }

    .anim-d1 {
      animation-delay: .05s;
    }

    .anim-d2 {
      animation-delay: .10s;
    }

    .anim-d3 {
      animation-delay: .15s;
    }

    .anim-d4 {
      animation-delay: .20s;
    }

    /* Dark mode */
    body.dark-mode {
      --card-bg: #1e2a20;
      --page-bg: #141d15;
      --text-dark: #e8f0e9;
      --text-mid: #9ab89e;
      --text-light: #6a8a6e;
      --border: rgba(255, 255, 255, .07);
    }

    body.dark-mode #topbar {
      background: #1e2a20;
      border-color: rgba(255, 255, 255, .06);
    }

    body.dark-mode .topbar-title {
      color: #e8f0e9;
    }

    body.dark-mode .topbar-user {
      background: rgba(102, 187, 106, .15);
    }

    body.dark-mode .topbar-user span {
      color: #66BB6A;
    }

    body.dark-mode .topbar-icon-btn {
      background: rgba(102, 187, 106, .12);
    }

    body.dark-mode .venda-table th {
      background: #172518;
    }

    body.dark-mode .venda-table tbody tr:hover td {
      background: #1a2a1c;
    }

    body.dark-mode .search-input,
    body.dark-mode .filter-select {
      background: #172518;
      color: #e8f0e9;
      border-color: rgba(255, 255, 255, .1);
    }

    body.dark-mode .modal-body {
      background: #1a2a1c;
    }

    body.dark-mode .modal-footer {
      background: #1e2a20;
      border-color: rgba(255, 255, 255, .07);
    }

    /* Responsive */
    @media (max-width: 992px) {
      .cart-panel {
        position: static;
        margin-top: 20px;
      }
    }

    @media (max-width: 768px) {
      :root {
        --sidebar-w: 240px;
      }

      body:not(.sidebar-hidden) #sidebar {
        box-shadow: 4px 0 20px rgba(0, 0, 0, .2);
      }

      body.default #sidebar {
        width: 0;
      }

      body.default #main {
        margin-left: 0;
      }

      body.default #topbar {
        left: 0;
      }

      .content-inner {
        padding: 16px;
      }

      .modal-coop {
        max-width: 100%;
        margin: 10px;
      }
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
          <button class="btn-outline-green" id="btnExportar">
            <i class="bi bi-download"></i> Exportar
          </button>
          <button class="btn-green" id="btnNovaVenda">
            <i class="bi bi-cart-plus-fill"></i> Nova Venda
          </button>
        </div>
      </div>

      <!-- Stat Cards -->
      <div class="row g-3 mb-4 anim anim-d1">
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-cart-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Total de Vendas</div>
              <div class="s-value">{{ $totalVendas ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-check-circle-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Vendas Pagas</div>
              <div class="s-value">{{ $vendasPagas ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon amber"><i class="bi bi-clock-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Pendentes</div>
              <div class="s-value">{{ $vendasPendentes ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-info">
              <div class="s-label">Total Faturado (Kz)</div>
              <div class="s-value">{{ number_format($totalFaturado ?? 0, 0, ',', '.') }}</div>
            </div>
          </div>
        </div>
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
                <span style="font-size:12.5px;color:var(--text-light);">{{ $produtos->total() ?? 0 }} produtos</span>
              </div>
            </div>

            <div class="search-filter-bar">
              <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" class="search-input" id="searchProduto" placeholder="Pesquisar por produto...">
              </div>
              <select class="filter-select" id="filterCategoria">
                <option value="">Todas as categorias</option>
                <option value="Graos">Grãos</option>
                <option value="Legumes">Legumes</option>
                <option value="Frutas">Frutas</option>
                <option value="Outros">Outros</option>
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
                  @forelse($produtos as $produto)
                    <tr id="produto-row-{{ $produto->id }}" data-nome="{{ $produto->nome }}"
                      data-preco="{{ $produto->preco_unitario }}" data-stock="{{ $produto->quantidade }}">
                      <td>
                        <input type="checkbox" class="row-check produto-check"
                          style="accent-color:var(--primary);width:15px;height:15px;cursor:pointer;">
                      </td>
                      <td>
                        <div style="font-weight:600;font-size:14px;">{{ $produto->nome }}</div>
                      </td>
                      <td>{{ $produto->categoria ?? '—' }}</td>
                      <td>{{ $produto->quantidade }} {{ $produto->unidade ?? '' }}</td>
                      <td><strong>{{ number_format($produto->preco_unitario, 0, ',', '.') }}</strong></td>
                      <td style="text-align:center;">
                        <input type="number" class="form-control form-control-sm qtd-input"
                          style="width:70px;display:inline-block;text-align:center;" value="1" min="1"
                          max="{{ $produto->quantidade }}">
                      </td>
                      <td style="text-align:center;">
                        <button class="btn btn-sm btn-success btn-add-cart" data-id="{{ $produto->id }}"
                          data-nome="{{ $produto->nome }}" data-preco="{{ $produto->preco_unitario }}"
                          data-stock="{{ $produto->quantidade }}">
                          <i class="bi bi-cart-plus"></i>
                        </button>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
                        <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                        Nenhum produto disponível.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="table-footer">
              <span id="tableCount">
                Mostrando {{ $produtos->firstItem() ?? 0 }} até {{ $produtos->lastItem() ?? 0 }} de
                {{ $produtos->total() }} produtos
              </span>
              <div class="pagination-btns">
                @if ($produtos->onFirstPage())
                  <button class="page-btn" disabled><i class="bi bi-chevron-left"></i></button>
                @else
                  <a href="{{ $produtos->previousPageUrl() }}" class="page-btn"><i class="bi bi-chevron-left"></i></a>
                @endif

                @foreach ($produtos->getUrlRange(1, $produtos->lastPage()) as $page => $url)
                  @if ($page == $produtos->currentPage())
                    <button class="page-btn active">{{ $page }}</button>
                  @else
                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                  @endif
                @endforeach

                @if ($produtos->hasMorePages())
                  <a href="{{ $produtos->nextPageUrl() }}" class="page-btn"><i class="bi bi-chevron-right"></i></a>
                @else
                  <button class="page-btn" disabled><i class="bi bi-chevron-right"></i></button>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Coluna Direita: Carrinho de Compras -->
        <div class="col-lg-4">
          <div class="cart-panel">
            <div class="cart-header">
              <h6><i class="bi bi-cart-fill me-2" style="color:var(--primary);"></i>Carrinho</h6>
              <span style="font-size:12px;color:var(--text-light);" id="cartCount">0 itens</span>
            </div>

            <div id="cartItems">
              <div class="cart-empty">
                <i class="bi bi-cart"></i>
                <p>Seu carrinho está vazio</p>
                <p style="font-size:12px;">Selecione produtos e clique em adicionar</p>
              </div>
            </div>

            <div id="cartSummary" style="display:none;">
              <!-- Itens serão renderizados via JS -->
            </div>

            <div class="cart-total">
              <span>Total:</span>
              <span id="cartTotal">0 Kz</span>
            </div>

            <div class="mt-3">
              <button class="btn-green w-100" id="btnFinalizarVenda" disabled>
                <i class="bi bi-check2-circle"></i> Finalizar Venda
              </button>
            </div>
            <div class="mt-2">
              <button class="btn-outline-green w-100" id="btnLimparCarrinho">
                <i class="bi bi-trash"></i> Limpar Carrinho
              </button>
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
            <span style="font-size:12.5px;color:var(--text-light);">{{ $vendas->total() ?? 0 }} registos</span>
          </div>
        </div>

        <div class="search-filter-bar">
          <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" class="search-input" id="searchVenda" placeholder="Pesquisar por cliente ou produto...">
          </div>
          <select class="filter-select" id="filterVendaStatus">
            <option value="">Todos os status</option>
            <option value="pago">Pago</option>
            <option value="pendente">Pendente</option>
            <option value="cancelado">Cancelado</option>
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
                <th>Produtos</th>
                <th>Total (Kz)</th>
                <th>Status</th>
                <th style="text-align:center;">Acções</th>
              </tr>
            </thead>
            <tbody id="vendaTableBody">
              @forelse($vendas as $venda)
                <tr id="venda-row-{{ $venda->id }}" data-status="{{ $venda->status }}">
                  <td><strong>#{{ str_pad($venda->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                  <td>{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                  <td>{{ $venda->cliente_nome ?? '—' }}</td>
                  <td>{{ $venda->itens_count ?? 0 }} itens</td>
                  <td><strong>{{ number_format($venda->total, 0, ',', '.') }}</strong></td>
                  <td>
                    <span class="badge-status {{ $venda->status }}">
                      <span class="dot"></span>
                      {{ ucfirst($venda->status) }}
                    </span>
                  </td>
                  <td style="text-align:center;">
                    <div style="display:flex;gap:6px;justify-content:center;">
                      <button class="action-btn view btn-ver-venda" title="Ver detalhes"
                        data-id="{{ $venda->id }}" data-cliente="{{ $venda->cliente_nome ?? '—' }}"
                        data-total="{{ $venda->total }}" data-status="{{ $venda->status }}"
                        data-itens="{{ json_encode($venda->itens ?? []) }}">
                        <i class="bi bi-eye-fill"></i>
                      </button>
                      <button class="action-btn print btn-imprimir-venda" title="Imprimir Fatura"
                        data-id="{{ $venda->id }}">
                        <i class="bi bi-printer-fill"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
                    <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                    Nenhuma venda registada.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="table-footer">
          <span id="vendaCount">
            Mostrando {{ $vendas->firstItem() ?? 0 }} até {{ $vendas->lastItem() ?? 0 }} de
            {{ $vendas->total() }} vendas
          </span>
          <div class="pagination-btns">
            @if ($vendas->onFirstPage())
              <button class="page-btn" disabled><i class="bi bi-chevron-left"></i></button>
            @else
              <a href="{{ $vendas->previousPageUrl() }}" class="page-btn"><i class="bi bi-chevron-left"></i></a>
            @endif

            @foreach ($vendas->getUrlRange(1, $vendas->lastPage()) as $page => $url)
              @if ($page == $vendas->currentPage())
                <button class="page-btn active">{{ $page }}</button>
              @else
                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
              @endif
            @endforeach

            @if ($vendas->hasMorePages())
              <a href="{{ $vendas->nextPageUrl() }}" class="page-btn"><i class="bi bi-chevron-right"></i></a>
            @else
              <button class="page-btn" disabled><i class="bi bi-chevron-right"></i></button>
            @endif
          </div>
        </div>
      </div>

    </div><!-- /content-inner -->
  </main>

  <!-- ══════════════════════════════════════
     MODAL — VER VENDA
══════════════════════════════════════ -->
  <div class="modal fade modal-coop" id="modalVerVenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-receipt"></i></div>
            <div>
              <div class="modal-title">Detalhes da Venda</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;" id="verVendaNumero">#000000</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-6"><strong>Data:</strong> <span id="verVendaData">—</span></div>
            <div class="col-6"><strong>Cliente:</strong> <span id="verVendaCliente">—</span></div>
            <div class="col-12"><strong>Status:</strong> <span id="verVendaStatus">—</span></div>
          </div>
          <hr>
          <h6 style="font-family:'Sora',sans-serif;font-weight:600;margin-bottom:12px;">Itens da Venda</h6>
          <div id="verVendaItens">
            <p style="color:var(--text-light);">Carregando...</p>
          </div>
          <hr>
          <div style="text-align:right;font-size:18px;font-weight:700;color:var(--text-dark);">
            Total: <span id="verVendaTotal">0 Kz</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn-green btn-imprimir-fatura" id="btnImprimirFatura">
            <i class="bi bi-printer-fill"></i> Imprimir Fatura
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════
     MODAL — FINALIZAR VENDA
══════════════════════════════════════ -->
  <div class="modal fade modal-coop" id="modalFinalizarVenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-cart-check-fill"></i></div>
            <div>
              <div class="modal-title">Finalizar Venda</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Confirme os dados da venda</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formFinalizarVenda">
            @csrf
            <div class="modal-form-card" style="background:var(--card-bg);border-radius:14px;border:1px solid var(--border);padding:20px 22px;margin-bottom:16px;">
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label" style="display:block;font-size:12px;font-weight:600;color:var(--text-mid);margin-bottom:5px;">Nome do Cliente *</label>
                  <input type="text" class="cfg-input" id="clienteNome" required
                    style="width:100%;border:1.5px solid var(--border);border-radius:10px;padding:10px 13px;font-size:13.5px;color:var(--text-dark);background:#FAFAF9;outline:none;"
                    placeholder="Ex: Mercado de Viana">
                </div>
                <div class="col-12">
                  <label class="cfg-label" style="display:block;font-size:12px;font-weight:600;color:var(--text-mid);margin-bottom:5px;">Forma de Pagamento</label>
                  <select class="cfg-select" id="formaPagamento"
                    style="width:100%;border:1.5px solid var(--border);border-radius:10px;padding:10px 32px 10px 13px;font-size:13.5px;color:var(--text-dark);background:#FAFAF9;appearance:none;cursor:pointer;outline:none;">
                    <option value="dinheiro">Dinheiro</option>
                    <option value="transferencia">Transferência Bancária</option>
                    <option value="credito">Crédito</option>
                    <option value="cheque">Cheque</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="cfg-label" style="display:block;font-size:12px;font-weight:600;color:var(--text-mid);margin-bottom:5px;">Status da Venda</label>
                  <select class="cfg-select" id="vendaStatus"
                    style="width:100%;border:1.5px solid var(--border);border-radius:10px;padding:10px 32px 10px 13px;font-size:13.5px;color:var(--text-dark);background:#FAFAF9;appearance:none;cursor:pointer;outline:none;">
                    <option value="pago">Pago</option>
                    <option value="pendente">Pendente</option>
                  </select>
                </div>
              </div>
            </div>

            <div style="background:var(--accent-lt);border-radius:12px;padding:16px 20px;margin-bottom:16px;">
              <div style="display:flex;justify-content:space-between;font-size:14px;">
                <span style="color:var(--text-mid);">Total de Itens:</span>
                <span style="font-weight:600;" id="finalizarTotalItens">0</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:18px;font-weight:700;color:var(--text-dark);margin-top:8px;padding-top:8px;border-top:1px solid rgba(0,0,0,.1);">
                <span>Total a Pagar:</span>
                <span id="finalizarTotalValor">0 Kz</span>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn-green" id="btnConfirmarVenda">
            <i class="bi bi-check2-circle"></i> Confirmar Venda
          </button>
        </div>
      </div>
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
       CARRINHO DE COMPRAS
    ══════════════════════════════════════ */
    let cart = [];

    function renderCart() {
      const container = document.getElementById('cartItems');
      const summary = document.getElementById('cartSummary');
      const totalSpan = document.getElementById('cartTotal');
      const countSpan = document.getElementById('cartCount');
      const btnFinalizar = document.getElementById('btnFinalizarVenda');

      if (cart.length === 0) {
        container.innerHTML = `
          <div class="cart-empty">
            <i class="bi bi-cart"></i>
            <p>Seu carrinho está vazio</p>
            <p style="font-size:12px;">Selecione produtos e clique em adicionar</p>
          </div>
        `;
        summary.style.display = 'none';
        totalSpan.textContent = '0 Kz';
        countSpan.textContent = '0 itens';
        btnFinalizar.disabled = true;
        return;
      }

      summary.style.display = 'block';
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
              <div class="item-detail">${item.quantidade} x ${Number(item.preco).toLocaleString('pt-AO')} Kz</div>
            </div>
            <div class="item-price">${subtotal.toLocaleString('pt-AO')} Kz</div>
            <button class="btn-remove-item" onclick="removeFromCart(${index})">
              <i class="bi bi-x-circle-fill"></i>
            </button>
          </div>
        `;
      });

      summary.innerHTML = html;
      totalSpan.textContent = total.toLocaleString('pt-AO') + ' Kz';
      countSpan.textContent = totalItens + ' itens';
      btnFinalizar.disabled = false;
    }

    function addToCart(id, nome, preco, stock) {
      const qtdInput = document.querySelector(`#produto-row-${id} .qtd-input`);
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
       FINALIZAR VENDA
    ══════════════════════════════════════ */
    const modalFinalizar = new bootstrap.Modal(document.getElementById('modalFinalizarVenda'));

    document.getElementById('btnFinalizarVenda').addEventListener('click', () => {
      if (cart.length === 0) {
        showToast('Carrinho vazio', 'Adicione produtos antes de finalizar.', 'warning');
        return;
      }

      const total = cart.reduce((sum, item) => sum + (item.preco * item.quantidade), 0);
      const totalItens = cart.reduce((sum, item) => sum + item.quantidade, 0);

      document.getElementById('finalizarTotalItens').textContent = totalItens;
      document.getElementById('finalizarTotalValor').textContent = total.toLocaleString('pt-AO') + ' Kz';
      document.getElementById('formFinalizarVenda').reset();

      modalFinalizar.show();
    });

    document.getElementById('btnConfirmarVenda').addEventListener('click', function() {
      const cliente = document.getElementById('clienteNome').value.trim();
      if (!cliente) {
        showToast('Campo obrigatório', 'Informe o nome do cliente.', 'danger');
        return;
      }

      // Simular envio da venda
      const btn = this;
      btn.disabled = true;
      btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processando...';

      const dadosVenda = {
        cliente: cliente,
        pagamento: document.getElementById('formaPagamento').value,
        status: document.getElementById('vendaStatus').value,
        itens: cart
      };

      // Simular requisição AJAX
      setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check2-circle"></i> Confirmar Venda';

        // Gerar número de venda
        const numVenda = String(Math.floor(Math.random() * 900000) + 100000);

        // Adicionar ao histórico
        const tbody = document.getElementById('vendaTableBody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
          <td><strong>#${numVenda}</strong></td>
          <td>${new Date().toLocaleDateString('pt-PT')}</td>
          <td>${cliente}</td>
          <td>${cart.length} itens</td>
          <td><strong>${cart.reduce((sum, i) => sum + (i.preco * i.quantidade), 0).toLocaleString('pt-AO')}</strong></td>
          <td><span class="badge-status ${document.getElementById('vendaStatus').value}"><span class="dot"></span>${document.getElementById('vendaStatus').value === 'pago' ? 'Pago' : 'Pendente'}</span></td>
          <td style="text-align:center;">
            <div style="display:flex;gap:6px;justify-content:center;">
              <button class="action-btn view btn-ver-venda" title="Ver detalhes"><i class="bi bi-eye-fill"></i></button>
              <button class="action-btn print btn-imprimir-venda" title="Imprimir Fatura"><i class="bi bi-printer-fill"></i></button>
            </div>
          </td>
        `;
        tbody.prepend(newRow);

        // Limpar carrinho
        cart = [];
        renderCart();

        modalFinalizar.hide();
        showToast('Venda realizada', `Venda #${numVenda} registada com sucesso!`);

        // Atualizar estatísticas
        const totalVendasSpan = document.querySelector('.stat-card:first-child .s-value');
        if (totalVendasSpan) {
          totalVendasSpan.textContent = parseInt(totalVendasSpan.textContent || 0) + 1;
        }
      }, 1500);
    });

    /* ══════════════════════════════════════
       VER VENDA
    ══════════════════════════════════════ */
    const modalVerVenda = new bootstrap.Modal(document.getElementById('modalVerVenda'));

    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.btn-ver-venda');
      if (!btn) return;

      const id = btn.dataset.id || '000001';
      const cliente = btn.dataset.cliente || '—';
      const total = parseFloat(btn.dataset.total) || 0;
      const status = btn.dataset.status || 'pago';

      document.getElementById('verVendaNumero').textContent = '#' + String(id).padStart(6, '0');
      document.getElementById('verVendaData').textContent = new Date().toLocaleDateString('pt-PT');
      document.getElementById('verVendaCliente').textContent = cliente;
      document.getElementById('verVendaStatus').innerHTML = `<span class="badge-status ${status}"><span class="dot"></span>${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
      document.getElementById('verVendaTotal').textContent = total.toLocaleString('pt-AO') + ' Kz';

      // Itens simulados
      const itensDiv = document.getElementById('verVendaItens');
      itensDiv.innerHTML = `
        <table class="table table-sm" style="font-size:13px;">
          <thead>
            <tr style="border-bottom:1px solid var(--border);">
              <th>Produto</th>
              <th style="text-align:center;">Qtd</th>
              <th style="text-align:right;">Preço</th>
              <th style="text-align:right;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Milho (saco 50kg)</td>
              <td style="text-align:center;">2</td>
              <td style="text-align:right;">12.000 Kz</td>
              <td style="text-align:right;">24.000 Kz</td>
            </tr>
            <tr>
              <td>Feijão (saco 25kg)</td>
              <td style="text-align:center;">1</td>
              <td style="text-align:right;">18.500 Kz</td>
              <td style="text-align:right;">18.500 Kz</td>
            </tr>
          </tbody>
        </table>
      `;

      modalVerVenda.show();
    });

    /* ══════════════════════════════════════
       NOVA VENDA (botão)
    ══════════════════════════════════════ */
    document.getElementById('btnNovaVenda').addEventListener('click', () => {
      // Rolagem para o topo da página
      window.scrollTo({ top: 0, behavior: 'smooth' });
      showToast('Nova Venda', 'Selecione os produtos e adicione ao carrinho.');
    });

    /* ══════════════════════════════════════
       FILTROS PRODUTOS (front-end)
    ══════════════════════════════════════ */
    document.getElementById('btnFiltrar').addEventListener('click', function() {
      const search = document.getElementById('searchProduto').value.toLowerCase().trim();
      const categoria = document.getElementById('filterCategoria').value;

      const rows = document.querySelectorAll('#produtoTableBody tr');
      let visibleCount = 0;

      rows.forEach(row => {
        const nome = row.querySelector('td:nth-child(2) div')?.textContent?.toLowerCase() || '';
        const rowCategoria = row.querySelector('td:nth-child(3)')?.textContent || '';

        let show = true;
        if (search && !nome.includes(search)) show = false;
        if (categoria && rowCategoria !== categoria) show = false;

        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
      });

      const info = document.getElementById('tableCount');
      if (info) {
        const total = rows.length;
        info.textContent = `Mostrando ${visibleCount} de ${total} produtos`;
      }
    });

    document.getElementById('btnLimparFiltros').addEventListener('click', function() {
      document.getElementById('searchProduto').value = '';
      document.getElementById('filterCategoria').value = '';
      document.querySelectorAll('#produtoTableBody tr').forEach(row => row.style.display = '');
      const info = document.getElementById('tableCount');
      if (info) {
        const total = document.querySelectorAll('#produtoTableBody tr').length;
        info.textContent = `Mostrando ${total} de ${total} produtos`;
      }
    });

    /* ══════════════════════════════════════
       FILTROS VENDAS (front-end)
    ══════════════════════════════════════ */
    document.getElementById('btnFiltrarVendas').addEventListener('click', function() {
      const search = document.getElementById('searchVenda').value.toLowerCase().trim();
      const status = document.getElementById('filterVendaStatus').value;

      const rows = document.querySelectorAll('#vendaTableBody tr');
      let visibleCount = 0;

      rows.forEach(row => {
        const cliente = row.querySelector('td:nth-child(3)')?.textContent?.toLowerCase() || '';
        const rowStatus = row.dataset.status || '';

        let show = true;
        if (search && !cliente.includes(search)) show = false;
        if (status && rowStatus !== status) show = false;

        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
      });

      const info = document.getElementById('vendaCount');
      if (info) {
        const total = rows.length;
        info.textContent = `Mostrando ${visibleCount} de ${total} vendas`;
      }
    });

    document.getElementById('btnLimparFiltrosVendas').addEventListener('click', function() {
      document.getElementById('searchVenda').value = '';
      document.getElementById('filterVendaStatus').value = '';
      document.querySelectorAll('#vendaTableBody tr').forEach(row => row.style.display = '');
      const info = document.getElementById('vendaCount');
      if (info) {
        const total = document.querySelectorAll('#vendaTableBody tr').length;
        info.textContent = `Mostrando ${total} de ${total} vendas`;
      }
    });

    /* ══════════════════════════════════════
       SELECT ALL
    ══════════════════════════════════════ */
    document.getElementById('selectAll').addEventListener('change', function() {
      document.querySelectorAll('.produto-check').forEach(cb => cb.checked = this.checked);
    });

    /* ══════════════════════════════════════
       EXPORTAR
    ══════════════════════════════════════ */
    document.getElementById('btnExportar').addEventListener('click', () => {
      showToast('A exportar…', 'O ficheiro será gerado e descarregado em breve.');
    });

    /* ══════════════════════════════════════
       IMPRIMIR FATURA
    ══════════════════════════════════════ */
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.btn-imprimir-venda');
      if (!btn) return;
      showToast('Imprimir Fatura', 'A fatura será gerada para impressão.');
    });

    document.getElementById('btnImprimirFatura').addEventListener('click', function() {
      showToast('Imprimir Fatura', 'A fatura será gerada para impressão.');
    });
  </script>

</body>

</html>
[file content end]