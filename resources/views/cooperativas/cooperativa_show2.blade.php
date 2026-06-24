<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG – Perfil da Cooperativa</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
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

    .topbar-title-wrap {
      display: flex;
      flex-direction: column;
      line-height: 1.15;
    }

    .topbar-title {
      font-family: 'Sora', sans-serif;
      font-size: 16px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .topbar-subtitle {
      font-size: 11.5px;
      color: var(--text-light);
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
    .action-btn.delete:hover .bi,
    .action-btn.view:hover .bi,
    .profile-logo-icon .bi {
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
      margin-bottom: 24px;
      flex-wrap: wrap;
      gap: 12px;
    }

    .page-header-back {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 12.5px;
      color: var(--text-light);
      text-decoration: none;
      margin-bottom: 8px;
      transition: color .15s;
    }

    .page-header-back:hover {
      color: var(--primary);
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

    .stat-badge.down {
      background: #FFEBEE;
      color: #C62828;
    }

    /* ═══════════════════════════════════════════
       SETTINGS-STYLE LAYOUT — tabs laterais
    ═══════════════════════════════════════════ */
    .settings-wrap {
      display: flex;
      gap: 24px;
      align-items: flex-start;
    }

    .settings-nav {
      flex-shrink: 0;
      width: 230px;
      background: var(--card-bg);
      border-radius: 16px;
      border: 1px solid var(--border);
      padding: 10px;
      position: sticky;
      top: calc(var(--topbar-h) + 28px);
    }

    .settings-nav-item {
      display: flex;
      align-items: center;
      gap: 11px;
      padding: 11px 14px;
      border-radius: 10px;
      cursor: pointer;
      color: var(--text-mid);
      font-size: 13.5px;
      font-weight: 500;
      transition: background .15s, color .15s;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
      white-space: nowrap;
    }

    .settings-nav-item i {
      font-size: 16px;
      color: var(--text-light);
      transition: color .15s;
    }

    .settings-nav-item:hover {
      background: var(--accent-lt);
      color: var(--primary);
    }

    .settings-nav-item:hover i {
      color: var(--primary);
    }

    .settings-nav-item.active {
      background: var(--accent-lt);
      color: var(--primary);
      font-weight: 600;
    }

    .settings-nav-item.active i {
      color: var(--primary);
    }

    .settings-nav-item .nav-count {
      margin-left: auto;
      font-size: 10.5px;
      font-weight: 700;
      color: var(--text-light);
      background: var(--page-bg);
      padding: 1px 7px;
      border-radius: 20px;
    }

    .settings-nav-item.active .nav-count {
      background: #fff;
      color: var(--primary);
    }

    .settings-content {
      flex: 1;
      min-width: 0;
    }

    .settings-panel {
      display: none;
    }

    .settings-panel.active {
      display: block;
    }

    /* ── CARDS GERAIS ─── */
    .cfg-card {
      background: var(--card-bg);
      border-radius: 16px;
      border: 1px solid var(--border);
      margin-bottom: 20px;
      overflow: hidden;
    }

    .cfg-card-header {
      padding: 18px 24px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      flex-wrap: wrap;
    }

    .cfg-card-header-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .cfg-card-icon {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }

    .cfg-card-icon.green {
      background: var(--accent-lt);
      color: var(--primary);
    }

    .cfg-card-icon.blue {
      background: #E3F2FD;
      color: #1565C0;
    }

    .cfg-card-icon.amber {
      background: #FFF8E1;
      color: #F57F17;
    }

    .cfg-card-icon.red {
      background: #FFEBEE;
      color: #C62828;
    }

    .cfg-card-icon.purple {
      background: #EDE7F6;
      color: #6A1B9A;
    }

    .cfg-card-icon.teal {
      background: #E0F2F1;
      color: #00695C;
    }

    .cfg-card-title {
      font-family: 'Sora', sans-serif;
      font-size: 14.5px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .cfg-card-sub {
      font-size: 12px;
      color: var(--text-light);
      margin-top: 2px;
    }

    .cfg-card-body {
      padding: 22px 24px;
    }

    /* ── TABELAS ─── */
    .table-wrap {
      overflow-x: auto;
    }

    .mini-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }

    .mini-table th {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .8px;
      color: var(--text-light);
      padding: 12px 16px;
      background: #FAFBFA;
      border-bottom: 1px solid var(--border);
      text-align: left;
      white-space: nowrap;
    }

    .mini-table td {
      font-size: 13.5px;
      color: var(--text-dark);
      padding: 13px 16px;
      border-bottom: 1px solid var(--border);
      vertical-align: middle;
    }

    .mini-table tr:last-child td {
      border-bottom: none;
    }

    .mini-table tbody tr:hover td {
      background: #F8FBF8;
    }

    /* Badges texto neutro (padrão SIAG) */
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

    .badge-status.activo,
    .badge-status.pago,
    .badge-status.disponivel,
    .badge-status.concluida,
    .badge-status.em_cultivo,
    .badge-status.pago,
    .badge-status.liquidado,
    .badge-status.oferecido {
      color: #2E7D32;
    }

    .badge-status.inactivo,
    .badge-status.esgotado,
    .badge-status.em_atraso {
      color: #C62828;
    }

    .badge-status.pendente,
    .badge-status.baixo,
    .badge-status.pousio {
      color: #F57F17;
    }

    .badge-status .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      display: inline-block;
    }

    .badge-status.activo .dot,
    .badge-status.pago .dot,
    .badge-status.disponivel .dot,
    .badge-status.concluida .dot,
    .badge-status.em_cultivo .dot,
    .badge-status.liquidado .dot,
    .badge-status.oferecido .dot {
      background: #2E7D32;
    }

    .badge-status.inactivo .dot,
    .badge-status.esgotado .dot,
    .badge-status.em_atraso .dot {
      background: #C62828;
    }

    .badge-status.pendente .dot,
    .badge-status.baixo .dot,
    .badge-status.pousio .dot {
      background: #F57F17;
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

    .action-btn.edit {
      background: var(--accent-lt);
      color: var(--primary);
    }

    .action-btn.edit:hover {
      background: var(--primary);
      color: #fff;
    }

    .action-btn.delete {
      background: #FFEBEE;
      color: #C62828;
    }

    .action-btn.delete:hover {
      background: #C62828;
      color: #fff;
    }

    .action-btn.view {
      background: #EDE7F6;
      color: #6A1B9A;
    }

    .action-btn.view:hover {
      background: #6A1B9A;
      color: #fff;
    }

    .action-btn.revert {
      background: #FFF8E1;
      color: #F57F17;
    }

    .action-btn.revert:hover {
      background: #F57F17;
      color: #fff;
    }

    /* Avatar agricultor na tabela */
    .ag-avatar-sm {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }

    /* Empty state pequeno */
    .mini-empty {
      text-align: center;
      padding: 36px 20px;
    }

    .mini-empty i {
      font-size: 38px;
      color: var(--accent);
      opacity: .5;
      display: block;
      margin-bottom: 10px;
    }

    .mini-empty p {
      font-size: 12.5px;
      color: var(--text-light);
    }

    /* ── PAGINAÇÃO ─── */
    .pagination-wrapper {
      padding: 14px 24px;
      border-top: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    .pagination-wrapper .pagination-info {
      font-size: 12.5px;
      color: var(--text-light);
    }

    .pagination-wrapper .pagination {
      margin: 0;
      gap: 4px;
    }

    .pagination-wrapper .page-link {
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 6px 12px;
      font-size: 12.5px;
      color: var(--text-mid);
      background: transparent;
    }

    .pagination-wrapper .page-link:hover {
      background: var(--accent-lt);
      color: var(--primary);
      border-color: var(--primary);
    }

    .pagination-wrapper .page-item.active .page-link {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
    }

    .pagination-wrapper .page-item.disabled .page-link {
      opacity: .4;
      cursor: not-allowed;
    }

    /* ── FILTROS (estilo da página agricultores) ─── */
    .filter-bar {
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

    /* ── MODAL (estilo da página agricultores) ─── */
    .modal-coop {
      max-width: 2000px;
    }

    .modal-coop .modal-content {
      max-height: 90vh;
      display: flex;
      flex-direction: column;
    }

    .modal-coop .modal-body {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
      padding: 0;
      background: var(--page-bg);
      scrollbar-width: thin;
      scrollbar-color: rgba(0, 0, 0, .15) transparent;
    }

    .modal-coop .modal-body::-webkit-scrollbar {
      width: 5px;
    }

    .modal-coop .modal-body::-webkit-scrollbar-track {
      background: transparent;
    }

    .modal-coop .modal-body::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, .12);
      border-radius: 10px;
    }

    .modal-coop .modal-body::-webkit-scrollbar-thumb:hover {
      background: rgba(0, 0, 0, .22);
    }

    body.dark-mode .modal-coop .modal-body {
      scrollbar-color: rgba(255, 255, 255, .15) transparent;
    }

    body.dark-mode .modal-coop .modal-body::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, .15);
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
      background: var(--page-bg);
    }

    .modal-footer {
      padding: 14px 20px;
      border-top: 1px solid var(--border);
      background: #fff;
      flex-shrink: 0;
    }

    .modal-section-title {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--text-light);
      margin-bottom: 14px;
      padding-bottom: 8px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .modal-section-title i {
      font-size: 13px;
      color: var(--primary);
    }

    .modal-form-card {
      background: var(--card-bg);
      border-radius: 14px;
      border: 1px solid var(--border);
      padding: 20px 22px;
      margin-bottom: 16px;
    }

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
      padding: 10px 13px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      font-family: 'DM Sans', sans-serif;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    .cfg-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
      background: #fff;
    }

    .cfg-input::placeholder {
      color: #C3B8B4;
    }

    .cfg-select {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 10px 32px 10px 13px;
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
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
    }

    .cfg-textarea {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 10px 13px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      resize: vertical;
      min-height: 80px;
      outline: none;
      font-family: 'DM Sans', sans-serif;
      transition: border-color .2s;
    }

    .cfg-textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
    }

    .cfg-helper {
      font-size: 11.5px;
      color: var(--text-light);
      margin-top: 4px;
    }

    /* Foto upload */
    .foto-upload-zone {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 2px dashed var(--border);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: border-color .2s, background .2s;
      font-size: 11px;
      color: var(--text-light);
      text-align: center;
      gap: 4px;
      flex-shrink: 0;
      overflow: hidden;
    }

    .foto-upload-zone:hover {
      border-color: var(--primary);
      background: var(--accent-lt);
    }

    .foto-upload-zone i {
      font-size: 24px;
      color: var(--text-light);
    }

    /* Info alert */
    .info-alert {
      background: #FFF8E1;
      border: 1px solid #FFE082;
      border-radius: 12px;
      padding: 14px 18px;
      margin-bottom: 16px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
    }

    .info-alert i {
      color: #F57F17;
      font-size: 18px;
      flex-shrink: 0;
      margin-top: 1px;
    }

    .info-alert .ia-title {
      font-size: 13.5px;
      font-weight: 600;
      color: #7f5000;
    }

    .info-alert .ia-sub {
      font-size: 12.5px;
      color: #9a6000;
      margin-top: 2px;
    }

    /* ── Animations ─── */
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

    body.dark-mode .mini-table th {
      background: #172518;
    }

    body.dark-mode .mini-table tbody tr:hover td {
      background: #1a2a1c;
    }

    body.dark-mode .filter-bar {
      background: #1a2a1c;
    }

    body.dark-mode .search-input,
    body.dark-mode .filter-select,
    body.dark-mode .cfg-input,
    body.dark-mode .cfg-select,
    body.dark-mode .cfg-textarea {
      background: #172518;
      color: #e8f0e9;
      border-color: rgba(255, 255, 255, .1);
    }

    body.dark-mode .modal-body {
      background: #1a2a1c;
    }

    body.dark-mode .modal-form-card {
      background: #1e2a20;
      border-color: rgba(255, 255, 255, .07);
    }

    body.dark-mode .modal-footer {
      background: #1e2a20;
      border-color: rgba(255, 255, 255, .07);
    }

    /* Responsive */
    @media (max-width: 900px) {
      .settings-wrap {
        flex-direction: column;
      }

      .settings-nav {
        width: 100%;
        position: static;
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        padding: 8px;
      }

      .settings-nav-item {
        width: auto;
        padding: 8px 12px;
        font-size: 12.5px;
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
      max-width: 400px;
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
      flex-shrink: 0;
    }

    .save-toast .toast-icon.success {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .save-toast .toast-icon.danger {
      background: #FFEBEE;
      color: #C62828;
    }

    .save-toast .toast-icon.warning {
      background: #FFF8E1;
      color: #F57F17;
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
      <a href="{{ route('cooperativas') }}" class="nav-item-link active" data-label="Cooperativa"><i
          class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
      <a href="{{ route('agricultores.index') }}" class="nav-item-link" data-label="Agricultores"><i
          class="bi bi-person-badge-fill"></i><span class="nav-label">Agricultores</span></a>

      <div class="nav-section-title">Agrícola</div>
      <a href="{{route('safras.painel')}}" class="nav-item-link" data-label="Safras"><i class="bi bi-flower2"></i><span
          class="nav-label">Safras</span></a>
      <a href="{{route('talhoes.index')}}" class="nav-item-link" data-label="Talhões"><i class="bi bi-map-fill"></i><span
          class="nav-label">Talhões</span></a>
      <a href="{{ route('insumos.index') }}" class="nav-item-link" data-label="Insumos"><i
          class="bi bi-box-seam-fill"></i><span class="nav-label">Insumos</span></a>

      <div class="nav-section-title">Financeiro</div>
      <a href="#" class="nav-item-link" data-label="Contas a Pagar"><i class="bi bi-arrow-down-circle-fill"></i><span
          class="nav-label">Contas a Pagar</span></a>
      <a href="#" class="nav-item-link" data-label="Contas a Receber"><i class="bi bi-arrow-up-circle-fill"></i><span
          class="nav-label">Contas a Receber</span></a>
      <a href="#" class="nav-item-link" data-label="Fluxo de Caixa"><i class="bi bi-cash-stack"></i><span
          class="nav-label">Fluxo de Caixa</span></a>

      <div class="nav-section-title">Comercial</div>
      <a href="#" class="nav-item-link" data-label="Vendas"><i class="bi bi-cart-fill"></i><span
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
          <img src="{{ asset('storage/users/' . Auth::user()->foto) }}" alt="Foto"
            onerror="this.onerror=null;this.parentElement.innerHTML='{{ substr(Auth::user()->name, 0, 1) }}';this.parentElement.style.color='#fff';this.parentElement.style.fontWeight='700';this.parentElement.style.fontSize='15px';">
        @else
          <span style="color:#fff;font-weight:700;font-size:15px;">{{ substr(Auth::user()->name, 0, 1) }}</span>
        @endif
      </div>
      <div class="user-info">
        <div class="u-name">{{ Auth::user()->name }}</div>
        <div class="u-role">{{ Auth::user()->nivel }} · Viana</div>
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
    <div class="topbar-title-wrap">
      <span class="topbar-title">{{ $cooperativa->nome ?? 'Cooperativa Agrícola de Viana' }}</span>
      <span class="topbar-subtitle">
        <i class="bi bi-geo-alt-fill" style="font-size:10px;"></i>
        {{ $cooperativa->municipio ?? 'Viana' }}, {{ $cooperativa->provincia ?? 'Luanda' }}
      </span>
    </div>
    <nav aria-label="breadcrumb" class="d-none d-md-flex ms-3">
      <ol class="breadcrumb mb-0" style="font-size:12.5px;">
        <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">SIAG</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cooperativas') }}"
            style="color:var(--primary);text-decoration:none;">Cooperativas</a></li>
        <li class="breadcrumb-item active" style="color:var(--text-light);">Perfil</li>
      </ol>
    </nav>
    <div class="topbar-right">
      <span class="badge rounded-pill d-none d-md-inline-flex align-items-center gap-1"
        style="background:var(--accent-lt);color:var(--primary);font-size:12px;padding:7px 13px;font-weight:600;">
        <i class="bi bi-calendar3"></i> Safra {{ $cooperativa->safra ?? '2024/25' }}
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
            <img src="{{ Auth::check() ? Auth::user()->foto_url : asset('uploads/users/default-user.png') }}"
              alt="Foto-perfil" class="avatar-md">
          </div>
          <span>{{ Auth::check() ? Auth::user()->name : 'Utilizador' }}</span>
          <i class="bi bi-chevron-down" style="font-size:11px;color:var(--primary);"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user">
          <li><span class="dropdown-header">Nível: {{ Auth::user()->nivel }}</span></li>
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
          <a href="{{ route('cooperativas') }}" class="page-header-back">
            <i class="bi bi-arrow-left"></i> Voltar à lista de Cooperativas
          </a>
          <h1>Gestão da Cooperativa</h1>
          <p>Dados completos, agricultores, produção e histórico financeiro da cooperativa</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <button class="btn-outline-green" id="btnImprimirFicha">
            <i class="bi bi-printer-fill"></i> Imprimir Ficha
          </button>
          <button class="btn-green" id="btnEditarCooperativa">
            <i class="bi bi-pencil-fill"></i> Editar Cooperativa
          </button>
        </div>
      </div>

      <!-- Stat Cards -->
      <div class="row g-3 mb-4 anim anim-d2">
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Total de Agricultores</div>
              <div class="s-value" id="totalAgricultores">{{ $cooperativa->numero_socios ?? '348' }}</div>
              <span class="stat-badge up"><i class="bi bi-arrow-up"></i> +12 este mês</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon amber"><i class="bi bi-box-seam-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Produção Total (ton)</div>
              <div class="s-value">{{ $cooperativa->producao_estimada ?? '1.153' }}</div>
              <span class="stat-badge up"><i class="bi bi-arrow-up"></i> Safra 24/25</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-cart-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Vendas Totais (Kz)</div>
              <div class="s-value">4.2M</div>
              <span class="stat-badge info"><i class="bi bi-info-circle"></i> Acumulado 24/25</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-droplet-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Insumos Distribuídos</div>
              <div class="s-value">142</div>
              <span class="stat-badge info"><i class="bi bi-box-arrow-in-down"></i> Última: 12 Mai</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Settings-style layout -->
      <div class="settings-wrap anim anim-d3">

        <!-- ── VERTICAL NAV ── -->
        <nav class="settings-nav">
          <button class="settings-nav-item active" data-tab="dados">
            <i class="bi bi-building"></i> Dados da Cooperativa
          </button>
          <button class="settings-nav-item" data-tab="agricultores">
            <i class="bi bi-person-badge-fill"></i> Agricultores <span class="nav-count">348</span>
          </button>
          <button class="settings-nav-item" data-tab="talhoes">
            <i class="bi bi-map-fill"></i> Talhões <span class="nav-count">86</span>
          </button>
          <button class="settings-nav-item" data-tab="colheitas">
            <i class="bi bi-flower2"></i> Colheitas <span class="nav-count">24</span>
          </button>
          <button class="settings-nav-item" data-tab="insumos">
            <i class="bi bi-box-seam-fill"></i> Insumos <span class="nav-count">142</span>
          </button>
          <button class="settings-nav-item" data-tab="receitas">
            <i class="bi bi-cash-coin"></i> Receitas <span class="nav-count">38</span>
          </button>
          <button class="settings-nav-item" data-tab="vendas">
            <i class="bi bi-cart-fill"></i> Vendas <span class="nav-count">52</span>
          </button>
          <button class="settings-nav-item" data-tab="saidas">
            <i class="bi bi-arrow-down-circle-fill"></i> Saídas / Despesas <span class="nav-count">19</span>
          </button>
        </nav>

        <!-- ── CONTENT PANELS ── -->
        <div class="settings-content">

          <!-- ════════════════════════
             TAB 1 — DADOS DA COOPERATIVA
        ════════════════════════ -->
          <div class="settings-panel active" id="tab-dados">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-building"></i></div>
                  <div>
                    <div class="cfg-card-title">Informações da Cooperativa</div>
                    <div class="cfg-card-sub">Dados cadastrais e informações gerais da cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" id="btnEditarDadosCooperativa" style="padding:8px 14px;font-size:12.5px;">
                  <i class="bi bi-pencil-fill"></i> Editar Dados
                </button>
              </div>
              <div class="cfg-card-body">
                <div style="display:flex;align-items:center;gap:24px;margin-bottom:24px;flex-wrap:wrap;">
                  <!-- Logomarca -->
                  <div class="profile-logo-i" id="coopLogo"
                    style="width:86px;height:86px;border-radius:18px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;flex-shrink:0;overflow:hidden;border:3px solid var(--accent-lt);letter-spacing:-1px;font-family:'Sora',sans-serif;">
                    @if($cooperativa->foto)
                      <img src="{{ asset('storage/' . $cooperativa->foto) }}" alt="Logo da Cooperativa">
                    @else
                      <i class="bi bi-building"></i>
                    @endif

                  </div>
                  <div>
                    <div style="font-size:18px;font-weight:700;color:var(--text-dark);font-family:'Sora',sans-serif;">
                      {{ $cooperativa->nome ?? 'Cooperativa Agrícola de Viana' }}
                    </div>
                    <div style="font-size:12.5px;color:var(--text-light);">
                      <span class="badge-estado activa" id="coopEstadoBadge"
                        style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:5px;background:#E8F5E9;color:#2E7D32;">
                        <span class="estado-dot"
                          style="width:6px;height:6px;border-radius:50%;display:inline-block;background:#2E7D32;"></span>Activa
                      </span>
                    </div>
                  </div>
                </div>

                <div class="row g-4">
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Nome da Cooperativa</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->nome ?? 'Cooperativa Agrícola de Viana' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      NIF</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->nif ?? '5401234567' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Data de Fundação</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ isset($cooperativa->data_fundacao) ? \Carbon\Carbon::parse($cooperativa->data_fundacao)->format('d/m/Y') : '15/03/2018' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Safra Actual</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->safra ?? '2024/2025' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Município</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->municipio ?? 'Viana' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Província</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->provincia ?? 'Luanda' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Endereço</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->endereco ?? 'Km 12, Estrada de Viana, Luanda Sul' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Principal Cultura</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->principal_cultura ?? 'Milho' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Área Cultivável (ha)</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->area_total_cultivada ?? '1.240' }} ha
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">Nº
                      de Talhões</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->numero_talhoes ?? '86' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Telefone</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->telefone ?? '+244 923 456 789' }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      E-mail</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">{{ $cooperativa->email ??
                      'geral@coop-viana.ao' }}</div>
                  </div>
                  <div class="col-md-6">
                    <div style="font-size:12px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Website</div>
                    <div style="font-size:15px;font-weight:600;color:var(--text-dark);">
                      {{ $cooperativa->website ?? 'coop-viana.ao' }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ════════════════════════
             TAB 2 — AGRICULTORES
        ════════════════════════ -->
          <div class="settings-panel" id="tab-agricultores">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-person-badge-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Agricultores Associados</div>
                    <div class="cfg-card-sub">Todos os agricultores vinculados a esta cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoAgricultor">
                  <i class="bi bi-person-plus-fill"></i> Associar Agricultor
                </button>
              </div>

              <!-- Filtros  zz -->
              <div class="filter-bar" id="agricultoresFiltros">
                <div class="search-wrap">
                  <i class="bi bi-search"></i>
                  <input type="text" class="search-input" id="filtroAgricultorNome" placeholder="Filtrar por nome...">
                </div>
                <select class="filter-select" id="filtroAgricultorEstado">
                  <option value="">Todos os estados</option>
                  <option value="Activo">Activo</option>
                  <option value="Inactivo">Inactivo</option>
                  <option value="Pendente">Pendente</option>
                </select>
                <button class="btn-green btn-filter" id="btnFiltrarAgricultores" style="padding:8px 18px;"><i
                    class="bi bi-search"></i> Filtrar</button>
                <button class="btn-outline-green btn-filter" id="btnLimparFiltrosAgricultores"
                  style="padding:8px 18px;"><i class="bi bi-eraser"></i> Limpar</button>
              </div>

              <div class="table-wrap">
                <table class="mini-table" id="tabelaAgricultores">
                  <thead>
                    <tr>
                      <th>Agricultor</th>
                      <th>BI / Contacto</th>
                      <th>Cargo</th>
                      <th>Talhões</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody id="corpoTabelaAgricultores">
                    <!-- Carregado via AJAX -->
                  </tbody>
                </table>
              </div>
              <div class="pagination-wrapper" id="paginacaoAgricultores">
                <div class="pagination-info" id="infoAgricultores">Carregando...</div>
                <nav>
                  <ul class="pagination" id="paginacaoLinksAgricultores"></ul>
                </nav>
              </div>

            </div>
          </div>

          <!-- ════════════════════════
             TAB 3 — TALHÕES
        ════════════════════════ -->
          <div class="settings-panel" id="tab-talhoes">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-map-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Talhões da Cooperativa</div>
                    <div class="cfg-card-sub">Todas as parcelas de terra registadas sob gestão desta cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoTalhao">
                  <i class="bi bi-plus-lg"></i> Novo Talhão
                </button>
              </div>
              <div class="table-wrap">
                <table class="mini-table" id="tabelaTalhoes">
                  <thead>
                    <tr>
                      <th>Designação</th>
                      <th>Agricultor</th>
                      <th>Área (ha)</th>
                      <th>Cultura Actual</th>
                      <th>Localização</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody id="corpoTabelaTalhoes">
                    <!-- Carregado via AJAX -->
                  </tbody>
                </table>
              </div>
              <div class="pagination-wrapper" id="paginacaoTalhoes">
                <div class="pagination-info" id="infoTalhoes">Carregando...</div>
                <nav>
                  <ul class="pagination" id="paginacaoLinksTalhoes"></ul>
                </nav>
              </div>
            </div>
          </div>

          <!-- ════════════════════════
             TAB 4 — COLHEITAS
        ════════════════════════ -->
          <div class="settings-panel" id="tab-colheitas">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-flower2"></i></div>
                  <div>
                    <div class="cfg-card-title">Colheitas da Cooperativa</div>
                    <div class="cfg-card-sub">Total agregado de todas as colheitas dos agricultores associados</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaColheita">
                  <i class="bi bi-plus-lg"></i> Nova Colheita
                </button>
              </div>
              <div class="table-wrap">
                <table class="mini-table" id="tabelaColheitas">
                  <thead>
                    <tr>
                      <th>Cultura</th>
                      <th>Agricultor</th>
                      <th>Talhão</th>
                      <th>Data</th>
                      <th>Quantidade</th>
                      <th>Qualidade</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody id="corpoTabelaColheitas">
                    <!-- Carregado via AJAX -->
                  </tbody>
                </table>
              </div>
              <div class="pagination-wrapper" id="paginacaoColheitas">
                <div class="pagination-info" id="infoColheitas">Carregando...</div>
                <nav>
                  <ul class="pagination" id="paginacaoLinksColheitas"></ul>
                </nav>
              </div>
            </div>
          </div>

          <!-- ════════════════════════
             TAB 5 — INSUMOS (Saída de Insumos)
        ════════════════════════ -->
          <div class="settings-panel" id="tab-insumos">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon amber"><i class="bi bi-box-seam-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Movimentação de Insumos</div>
                    <div class="cfg-card-sub">Histórico completo de entradas, saídas e distribuição de insumos da
                      cooperativa </div>
                  </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                  <a href="{{ route('cooperativas.insumos.index', $cooperativa->id) }}" class="btn-outline-green"
                    style="padding:8px 14px;font-size:12.5px;text-decoration:none;">
                    <i class="bi bi-box-seam-fill"></i> Gerenciar Estoque
                  </a>
                </div>
              </div>

              <!-- Filtros -->
              <div class="filter-bar" id="insumosFiltros">
                <div class="search-wrap">
                  <i class="bi bi-search"></i>
                  <input type="text" class="search-input" id="filtroInsumoCategoria"
                    placeholder="Filtrar por categoria...">
                </div>
                <select class="filter-select" id="filtroInsumoEstado">
                  <option value="">Todos os estados</option>
                  <option value="pago">Pago</option>
                  <option value="pendente">Pendente</option>
                  <option value="oferecido">Oferecido</option>
                  <option value="liquidado">Liquidado</option>
                </select>
                <button class="btn-green btn-filter" id="btnFiltrarInsumos" style="padding:8px 18px;"><i
                    class="bi bi-search"></i> Filtrar</button>
                <button class="btn-outline-green btn-filter" id="btnLimparFiltrosInsumos" style="padding:8px 18px;"><i
                    class="bi bi-eraser"></i> Limpar</button>
              </div>

              <div class="table-wrap">
                <table class="mini-table" id="tabelaInsumos">
                  <thead>
                    <tr>
                      <th>Categoria</th>
                      <th>Agricultor</th>
                      <th>Data de Saída</th>
                      <th>Quantidade</th>
                      <th>Modalidade</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody id="corpoTabelaInsumos">
                    <!-- Carregado via AJAX -->
                  </tbody>
                </table>
              </div>
              <div class="pagination-wrapper" id="paginacaoInsumos">
                <div class="pagination-info" id="infoInsumos">Carregando...</div>
                <nav>
                  <ul class="pagination" id="paginacaoLinksInsumos"></ul>
                </nav>
              </div>

            </div>
          </div>

          <!-- ════════════════════════
             TAB 6 — RECEITAS
        ════════════════════════ -->
          <div class="settings-panel" id="tab-receitas">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon blue"><i class="bi bi-cash-coin"></i></div>
                  <div>
                    <div class="cfg-card-title">Receitas da Cooperativa</div>
                    <div class="cfg-card-sub">Total de entradas financeiras — vendas, subsídios e apoios recebidos</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaReceita">
                  <i class="bi bi-plus-lg"></i> Nova Receita
                </button>
              </div>

              <!-- Filtros -->
              <div class="filter-bar" id="receitasFiltros">
                <div class="search-wrap">
                  <i class="bi bi-search"></i>
                  <input type="text" class="search-input" id="filtroReceitaNome" placeholder="Filtrar por nome...">
                </div>
                <select class="filter-select" id="filtroReceitaEstado">
                  <option value="">Todos os estados</option>
                  <option value="Pago">Pago</option>
                  <option value="Pendente">Pendente</option>
                </select>
                <button class="btn-green btn-filter" id="btnFiltrarReceitas" style="padding:8px 18px;"><i
                    class="bi bi-search"></i> Filtrar</button>
                <button class="btn-outline-green btn-filter" id="btnLimparFiltrosReceitas" style="padding:8px 18px;"><i
                    class="bi bi-eraser"></i> Limpar</button>
              </div>

              <div class="table-wrap">
                <table class="mini-table" id="tabelaReceitas">
                  <thead>
                    <tr>
                      <th>Descrição</th>
                      <th>Origem</th>
                      <th>Agricultor</th>
                      <th>Data</th>
                      <th>Valor (Kz)</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody id="corpoTabelaReceitas">
                    <!-- Carregado via AJAX -->
                  </tbody>
                </table>
              </div>
              <div class="pagination-wrapper" id="paginacaoReceitas">
                <div class="pagination-info" id="infoReceitas">Carregando...</div>
                <nav>
                  <ul class="pagination" id="paginacaoLinksReceitas"></ul>
                </nav>
              </div>
            </div>
          </div>

          <!-- ════════════════════════
             TAB 7 — VENDAS
        ════════════════════════ -->
          <div class="settings-panel" id="tab-vendas">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon amber"><i class="bi bi-cart-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Histórico de Vendas</div>
                    <div class="cfg-card-sub">Todas as vendas de produtos realizadas pela cooperativa e seus
                      agricultores</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaVenda">
                  <i class="bi bi-plus-lg"></i> Nova Venda
                </button>
              </div>

              <!-- Filtros -->
              <div class="filter-bar" id="vendasFiltros">
                <div class="search-wrap">
                  <i class="bi bi-search"></i>
                  <input type="text" class="search-input" id="filtroVendaNome" placeholder="Filtrar por nome...">
                </div>
                <select class="filter-select" id="filtroVendaEstado">
                  <option value="">Todos os estados</option>
                  <option value="Concluída">Concluída</option>
                  <option value="Pendente">Pendente</option>
                </select>
                <button class="btn-green btn-filter" id="btnFiltrarVendas" style="padding:8px 18px;"><i
                    class="bi bi-search"></i> Filtrar</button>
                <button class="btn-outline-green btn-filter" id="btnLimparFiltrosVendas" style="padding:8px 18px;"><i
                    class="bi bi-eraser"></i> Limpar</button>
              </div>

              <div class="table-wrap">
                <table class="mini-table" id="tabelaVendas">
                  <thead>
                    <tr>
                      <th>Produto</th>
                      <th>Agricultor</th>
                      <th>Comprador</th>
                      <th>Data</th>
                      <th>Quantidade</th>
                      <th>Valor Total (Kz)</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody id="corpoTabelaVendas">
                    <!-- Carregado via AJAX -->
                  </tbody>
                </table>
              </div>
              <div class="pagination-wrapper" id="paginacaoVendas">
                <div class="pagination-info" id="infoVendas">Carregando...</div>
                <nav>
                  <ul class="pagination" id="paginacaoLinksVendas"></ul>
                </nav>
              </div>
            </div>
          </div>

          <!-- ════════════════════════
             TAB 8 — SAÍDAS / DESPESAS
        ════════════════════════ -->
          <div class="settings-panel" id="tab-saidas">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon red"><i class="bi bi-arrow-down-circle-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Saídas e Despesas</div>
                    <div class="cfg-card-sub">Registo de todas as despesas operacionais e financeiras da cooperativa
                    </div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaSaida">
                  <i class="bi bi-plus-lg"></i> Registar Despesa
                </button>
              </div>

              <!-- Filtros -->
              <div class="filter-bar" id="saidasFiltros">
                <div class="search-wrap">
                  <i class="bi bi-search"></i>
                  <input type="text" class="search-input" id="filtroSaidaNome" placeholder="Filtrar por nome...">
                </div>
                <select class="filter-select" id="filtroSaidaEstado">
                  <option value="">Todos os estados</option>
                  <option value="Pago">Pago</option>
                  <option value="Pendente">Pendente</option>
                  <option value="Em Atraso">Em Atraso</option>
                </select>
                <button class="btn-green btn-filter" id="btnFiltrarSaidas" style="padding:8px 18px;"><i
                    class="bi bi-search"></i> Filtrar</button>
                <button class="btn-outline-green btn-filter" id="btnLimparFiltrosSaidas" style="padding:8px 18px;"><i
                    class="bi bi-eraser"></i> Limpar</button>
              </div>

              <div class="table-wrap">
                <table class="mini-table" id="tabelaSaidas">
                  <thead>
                    <tr>
                      <th>Descrição</th>
                      <th>Categoria</th>
                      <th>Fornecedor</th>
                      <th>Data</th>
                      <th>Valor (Kz)</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody id="corpoTabelaSaidas">
                    <!-- Carregado via AJAX -->
                  </tbody>
                </table>
              </div>
              <div class="pagination-wrapper" id="paginacaoSaidas">
                <div class="pagination-info" id="infoSaidas">Carregando...</div>
                <nav>
                  <ul class="pagination" id="paginacaoLinksSaidas"></ul>
                </nav>
              </div>

              <!-- Resumo rodapé -->
              <div
                style="padding:16px 24px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <div style="font-size:12px;color:var(--text-light);">
                  <i class="bi bi-info-circle me-1"></i>Resumo financeiro de despesas
                </div>
                <div style="display:flex;gap:24px;" id="resumoDespesas">
                  <div style="text-align:right;">
                    <div style="font-size:11px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Total Pago</div>
                    <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:700;color:#2E7D32;"
                      id="totalPago">Kz 0</div>
                  </div>
                  <div style="text-align:right;">
                    <div style="font-size:11px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Total Pendente</div>
                    <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:700;color:#F57F17;"
                      id="totalPendente">Kz 0</div>
                  </div>
                  <div style="text-align:right;">
                    <div style="font-size:11px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">
                      Total em Atraso</div>
                    <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:700;color:#C62828;"
                      id="totalEmAtraso">Kz 0</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /settings-content -->

      </div>
      <!-- /settings-wrap -->

    </div><!-- /content-inner -->
  </main>

  <!-- ══════════════════════════════════════
     MODALS — Centralizados com modal-dialog-centered
══════════════════════════════════════ -->

  <!-- ─── MODAL AGRICULTORES: Associar Agricultor ─── -->
  <div class="modal fade modal-coop" id="modalAssociarAgricultor" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-person-plus-fill"></i></div>
            <div>
              <div class="modal-title">Associar Agricultor</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Vincular agricultor à cooperativa
              </div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">

          <form id="formAssociarAgricultor">
            @csrf
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-person-vcard-fill"></i> Dados do Agricultor</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Nome do Agricultor *</label>
                  <input type="text" class="cfg-input" id="agricultorNome" required
                    placeholder="Ex: João Manuel Ferreira">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">BI *</label>
                  <input type="text" class="cfg-input" id="agricultorBI" required placeholder="004512378LA041">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Contacto *</label>
                  <input type="text" class="cfg-input" id="agricultorContacto" required placeholder="+244 923 111 222">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Cargo</label>
                  <select class="cfg-select" id="agricultorCargo">
                    <option value="Agricultor">Agricultor</option>
                    <option value="Sócio">Sócio</option>
                    <option value="Dirigente">Dirigente</option>
                    <option value="Técnico">Técnico</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Estado</label>
                  <select class="cfg-select" id="agricultorEstado">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                    <option value="Pendente">Pendente</option>
                  </select>
                </div>
              </div>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarAgricultor"><i class="bi bi-check2-circle"></i>
                Associar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL AGRICULTORES: Remover Agricultor ─── -->
  <div class="modal fade" id="modalRemoverAgricultor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
      <div class="modal-content">
        <div class="modal-header" style="background:linear-gradient(135deg, #7f0000, #C62828);">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div>
              <div class="modal-title">Confirmar Remoção</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Esta acção é irreversível</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body" style="background:#fff;padding:28px;">
          <p style="font-size:13.5px;color:var(--text-mid);margin-bottom:10px;">
            Tem a certeza que deseja remover o agricultor:
          </p>
          <div
            style="background:#FFF8F8;border:1px solid #FFCDD2;border-radius:10px;padding:14px 18px;margin-bottom:16px;">
            <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:#C62828;"
              id="removerAgricultorNome">—</div>
            <div style="font-size:12px;color:var(--text-light);margin-top:3px;">Todos os dados associados serão
              removidos permanentemente.</div>
          </div>
          <input type="hidden" id="removerAgricultorId">
        </div>
        <div class="modal-footer" style="border-top:1px solid #FFCDD2;">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn-green" id="btnConfirmarRemover" style="background:#C62828;box-shadow:none;">
            <i class="bi bi-trash-fill"></i> Remover Definitivamente
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL TALHÕES: Registrar Talhão ─── -->
  <div class="modal fade modal-coop" id="modalNovoTalhao" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-map-fill"></i></div>
            <div>
              <div class="modal-title">Registrar Talhão</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Nova parcela de terra para cultivo
              </div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formNovoTalhao">
            @csrf
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-map-fill"></i> Dados do Talhão</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Designação *</label>
                  <input type="text" class="cfg-input" id="talhaoDesignacao" required placeholder="Ex: Talhão A1">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Agricultor *</label>
                  <select class="cfg-select" id="talhaoAgricultor">
                    <option value="">Selecione um agricultor</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Área (ha) *</label>
                  <input type="number" step="0.1" class="cfg-input" id="talhaoArea" required placeholder="0.0">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Cultura Actual</label>
                  <input type="text" class="cfg-input" id="talhaoCultura" placeholder="Ex: Milho">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Localização *</label>
                  <input type="text" class="cfg-input" id="talhaoLocalizacao" required placeholder="Ex: Km 12, Viana">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="talhaoEstado">
                    <option value="Em Cultivo">Em Cultivo</option>
                    <option value="Pousio">Pousio</option>
                    <option value="Preparação">Preparação</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarTalhao"><i class="bi bi-check2-circle"></i>
                Registrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL COLHEITAS: Registrar Colheita ─── -->
  <div class="modal fade modal-coop" id="modalNovaColheita" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-flower2"></i></div>
            <div>
              <div class="modal-title">Registrar Colheita</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Registo de produção agrícola</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formNovaColheita">
            @csrf
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-flower2"></i> Dados da Colheita</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Cultura *</label>
                  <input type="text" class="cfg-input" id="colheitaCultura" required
                    placeholder="Ex: Milho, Feijão, Mandioca...">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Agricultor *</label>
                  <select class="cfg-select" id="colheitaAgricultor">
                    <option value="">Selecione um agricultor</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="cfg-label">Talhão *</label>
                  <input type="text" class="cfg-input" id="colheitaTalhao" required placeholder="Ex: Talhão A1">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Data *</label>
                  <input type="date" class="cfg-input" id="colheitaData" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Quantidade (kg) *</label>
                  <input type="number" class="cfg-input" id="colheitaQuantidade" required placeholder="0">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Qualidade *</label>
                  <select class="cfg-select" id="colheitaQualidade">
                    <option value="Boa">Boa</option>
                    <option value="Razoável">Razoável</option>
                    <option value="Ruim">Ruim</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarColheita"><i class="bi bi-check2-circle"></i>
                Registrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL INSUMOS: Registrar Saída ─── -->
  <div class="modal fade modal-coop" id="modalRegistrarSaidaInsumo" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-box-seam-fill"></i></div>
            <div>
              <div class="modal-title">Movimentação de Insumos</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Registar saída ou distribuição de
                insumos</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formRegistrarSaidaInsumo">
            @csrf
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-box-seam-fill"></i> Dados da Saída</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Categoria *</label>
                  <input type="text" class="cfg-input" id="insumoSaidaCategoria" required
                    placeholder="Ex: Sementes, Fertilizantes...">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Agricultor *</label>
                  <select class="cfg-select" id="insumoSaidaAgricultor">
                    <option value="">Selecione um agricultor</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Data de Saída *</label>
                  <input type="date" class="cfg-input" id="insumoSaidaData" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Quantidade *</label>
                  <input type="number" class="cfg-input" id="insumoSaidaQuantidade" required placeholder="0">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Modalidade *</label>
                  <select class="cfg-select" id="insumoSaidaModalidade">
                    <option value="Vendido">Vendido</option>
                    <option value="Oferta">Oferta</option>
                    <option value="Troca">Troca</option>
                    <option value="Crédito">Crédito</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="insumoSaidaEstado">
                    <option value="Pago">Pago</option>
                    <option value="Pendente">Pendente</option>
                    <option value="Oferecido">Oferecido</option>
                    <option value="Liquidado">Liquidado</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarSaidaInsumo"><i class="bi bi-check2-circle"></i>
                Registrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL INSUMOS: Editar Saída ─── -->
  <div class="modal fade modal-coop" id="modalEditarInsumoSaida" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-pencil-fill"></i></div>
            <div>
              <div class="modal-title">Editar Saída de Insumo</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Atualizar dados da movimentação
              </div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formEditarInsumoSaida">
            @csrf
            @method('PUT')
            <input type="hidden" id="editarInsumoSaidaId">
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-pencil-fill"></i> Editar Saída</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Categoria *</label>
                  <input type="text" class="cfg-input" id="editarInsumoSaidaCategoria" required>
                </div>
                <div class="col-12">
                  <label class="cfg-label">Agricultor *</label>
                  <select class="cfg-select" id="editarInsumoSaidaAgricultor"></select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Data de Saída *</label>
                  <input type="date" class="cfg-input" id="editarInsumoSaidaData" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Quantidade *</label>
                  <input type="number" class="cfg-input" id="editarInsumoSaidaQuantidade" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Modalidade *</label>
                  <select class="cfg-select" id="editarInsumoSaidaModalidade">
                    <option value="Vendido">Vendido</option>
                    <option value="Oferta">Oferta</option>
                    <option value="Troca">Troca</option>
                    <option value="Crédito">Crédito</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="editarInsumoSaidaEstado">
                    <option value="Pago">Pago</option>
                    <option value="Pendente">Pendente</option>
                    <option value="Oferecido">Oferecido</option>
                    <option value="Liquidado">Liquidado</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarEditarInsumoSaida"><i
                  class="bi bi-check2-circle"></i> Salvar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL RECEITAS: Nova Receita ─── -->
  <div class="modal fade modal-coop" id="modalNovaReceita" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-cash-coin"></i></div>
            <div>
              <div class="modal-title">Registrar Receita</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Entrada financeira da cooperativa
              </div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formNovaReceita">
            @csrf
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-cash-coin"></i> Dados da Receita</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Descrição *</label>
                  <input type="text" class="cfg-input" id="receitaDescricao" required placeholder="Ex: Venda de Milho">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Origem *</label>
                  <select class="cfg-select" id="receitaOrigem">
                    <option value="Comercial">Comercial</option>
                    <option value="Apoio Público">Apoio Público</option>
                    <option value="Financiamento">Financiamento</option>
                    <option value="Doação">Doação</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Agricultor</label>
                  <select class="cfg-select" id="receitaAgricultor">
                    <option value="Cooperativa (Geral)">Cooperativa (Geral)</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Data *</label>
                  <input type="date" class="cfg-input" id="receitaData" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Valor (Kz) *</label>
                  <input type="number" class="cfg-input" id="receitaValor" required placeholder="0">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="receitaEstado">
                    <option value="Pago">Pago</option>
                    <option value="Pendente">Pendente</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarReceita"><i class="bi bi-check2-circle"></i>
                Registrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL RECEITAS: Editar Receita ─── -->
  <div class="modal fade modal-coop" id="modalEditarReceita" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-pencil-fill"></i></div>
            <div>
              <div class="modal-title">Editar Receita</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Atualizar dados da receita</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formEditarReceita">
            @csrf
            @method('PUT')
            <input type="hidden" id="editarReceitaId">
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-pencil-fill"></i> Editar Receita</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Descrição *</label>
                  <input type="text" class="cfg-input" id="editarReceitaDescricao" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Origem *</label>
                  <select class="cfg-select" id="editarReceitaOrigem">
                    <option value="Comercial">Comercial</option>
                    <option value="Apoio Público">Apoio Público</option>
                    <option value="Financiamento">Financiamento</option>
                    <option value="Doação">Doação</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Agricultor</label>
                  <select class="cfg-select" id="editarReceitaAgricultor">
                    <option value="Cooperativa (Geral)">Cooperativa (Geral)</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Data *</label>
                  <input type="date" class="cfg-input" id="editarReceitaData" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Valor (Kz) *</label>
                  <input type="number" class="cfg-input" id="editarReceitaValor" required>
                </div>
                <div class="col-12">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="editarReceitaEstado">
                    <option value="Pago">Pago</option>
                    <option value="Pendente">Pendente</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarEditarReceita"><i class="bi bi-check2-circle"></i>
                Salvar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL VENDAS: Nova Venda ─── -->
  <div class="modal fade modal-coop" id="modalNovaVenda" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-cart-fill"></i></div>
            <div>
              <div class="modal-title">Registrar Venda</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Registo de venda de produtos</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formNovaVenda">
            @csrf
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-cart-fill"></i> Dados da Venda</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Produto *</label>
                  <input type="text" class="cfg-input" id="vendaProduto" required placeholder="Ex: Milho (saco 50kg)">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Agricultor *</label>
                  <select class="cfg-select" id="vendaAgricultor">
                    <option value="">Selecione um agricultor</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Comprador *</label>
                  <input type="text" class="cfg-input" id="vendaComprador" required placeholder="Ex: Mercado de Viana">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Data *</label>
                  <input type="date" class="cfg-input" id="vendaData" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Valor Total (Kz) *</label>
                  <input type="number" class="cfg-input" id="vendaValor" required placeholder="0">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Quantidade *</label>
                  <input type="text" class="cfg-input" id="vendaQuantidade" required placeholder="Ex: 8 sacos">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="vendaEstado">
                    <option value="Concluída">Concluída</option>
                    <option value="Pendente">Pendente</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarVenda"><i class="bi bi-check2-circle"></i>
                Registrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL VENDAS: Editar Venda ─── -->
  <div class="modal fade modal-coop" id="modalEditarVenda" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-pencil-fill"></i></div>
            <div>
              <div class="modal-title">Editar Venda</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Atualizar dados da venda</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formEditarVenda">
            @csrf
            @method('PUT')
            <input type="hidden" id="editarVendaId">
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-pencil-fill"></i> Editar Venda</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Produto *</label>
                  <input type="text" class="cfg-input" id="editarVendaProduto" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Agricultor *</label>
                  <select class="cfg-select" id="editarVendaAgricultor"></select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Comprador *</label>
                  <input type="text" class="cfg-input" id="editarVendaComprador" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Data *</label>
                  <input type="date" class="cfg-input" id="editarVendaData" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Valor Total (Kz) *</label>
                  <input type="number" class="cfg-input" id="editarVendaValor" required>
                </div>
                <div class="col-12">
                  <label class="cfg-label">Quantidade *</label>
                  <input type="text" class="cfg-input" id="editarVendaQuantidade" required>
                </div>
                <div class="col-12">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="editarVendaEstado">
                    <option value="Concluída">Concluída</option>
                    <option value="Pendente">Pendente</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarEditarVenda"><i class="bi bi-check2-circle"></i>
                Salvar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL SAÍDAS: Nova Despesa ─── -->
  <div class="modal fade modal-coop" id="modalNovaSaida" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-arrow-down-circle-fill"></i></div>
            <div>
              <div class="modal-title">Registrar Despesa</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Saída financeira da cooperativa
              </div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formNovaSaida">
            @csrf
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-arrow-down-circle-fill"></i> Dados da Despesa</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Descrição *</label>
                  <input type="text" class="cfg-input" id="saidaDescricao" required
                    placeholder="Ex: Compra de Fertilizantes">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Categoria *</label>
                  <select class="cfg-select" id="saidaCategoria">
                    <option value="Insumos">Insumos</option>
                    <option value="Logística">Logística</option>
                    <option value="Equipamentos">Equipamentos</option>
                    <option value="Instalações">Instalações</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                    <option value="Serviços">Serviços</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Fornecedor</label>
                  <input type="text" class="cfg-input" id="saidaFornecedor" placeholder="Ex: AgroViana Lda.">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Data *</label>
                  <input type="date" class="cfg-input" id="saidaData" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Valor (Kz) *</label>
                  <input type="number" class="cfg-input" id="saidaValor" required placeholder="0">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="saidaEstado">
                    <option value="Pago">Pago</option>
                    <option value="Pendente">Pendente</option>
                    <option value="Em Atraso">Em Atraso</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarSaida"><i class="bi bi-check2-circle"></i>
                Registrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL SAÍDAS: Editar Despesa ─── -->
  <div class="modal fade modal-coop" id="modalEditarSaida" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-pencil-fill"></i></div>
            <div>
              <div class="modal-title">Editar Despesa</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Atualizar dados da despesa</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formEditarSaida">
            @csrf
            @method('PUT')
            <input type="hidden" id="editarSaidaId">
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-pencil-fill"></i> Editar Despesa</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Descrição *</label>
                  <input type="text" class="cfg-input" id="editarSaidaDescricao" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Categoria *</label>
                  <select class="cfg-select" id="editarSaidaCategoria">
                    <option value="Insumos">Insumos</option>
                    <option value="Logística">Logística</option>
                    <option value="Equipamentos">Equipamentos</option>
                    <option value="Instalações">Instalações</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                    <option value="Serviços">Serviços</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Fornecedor</label>
                  <input type="text" class="cfg-input" id="editarSaidaFornecedor">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Data *</label>
                  <input type="date" class="cfg-input" id="editarSaidaData" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Valor (Kz) *</label>
                  <input type="number" class="cfg-input" id="editarSaidaValor" required>
                </div>
                <div class="col-12">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="editarSaidaEstado">
                    <option value="Pago">Pago</option>
                    <option value="Pendente">Pendente</option>
                    <option value="Em Atraso">Em Atraso</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                Cancelar</button>
              <button type="button" class="btn-green" id="btnSalvarEditarSaida"><i class="bi bi-check2-circle"></i>
                Salvar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div class="save-toast" id="saveToast">
    <div class="toast-icon success" id="toastIcon">
      <i class="bi bi-check-lg" id="toastIconI"></i>
    </div>
    <div class="toast-text">
      <div class="t-title" id="toastTitle">Operação concluída</div>
      <div class="t-sub" id="toastSub">Acção realizada com sucesso.</div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- ══════════════════════════════════════
     SCRIPT PRINCIPAL — SPA + CRUD
══════════════════════════════════════ -->
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

    themeToggle.addEventListener('click', function (e) {
      e.preventDefault();
      darkMode = !darkMode;
      body.classList.toggle('dark-mode', darkMode);
      themeIcon.className = darkMode ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
      themeLabel.textContent = darkMode ? 'Modo Claro' : 'Modo Escuro';
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
      icon.className = 'toast-icon ' + type;
      iconI.className = type === 'danger' ? 'bi bi-x-lg' : type === 'warning' ? 'bi bi-exclamation-triangle-fill' : 'bi bi-check-lg';
      toast.classList.add('show');
      clearTimeout(toast._timeout);
      toast._timeout = setTimeout(() => toast.classList.remove('show'), 3500);
    }

    /* ══════════════════════════════════════
       TABS LATERAIS
    ══════════════════════════════════════ */
    document.querySelectorAll('.settings-nav-item').forEach(btn => {
      btn.addEventListener('click', () => {
        const tab = btn.dataset.tab;

        document.querySelectorAll('.settings-nav-item').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.settings-panel').forEach(p => {
          p.classList.remove('active');
        });
        const panel = document.getElementById('tab-' + tab);
        if (panel) {
          panel.classList.add('active');
          panel.querySelectorAll('.anim').forEach(el => {
            el.style.animation = 'none';
            el.offsetHeight;
            el.style.animation = '';
          });
        }

        if (tab === 'agricultores') carregarAgricultores();
        else if (tab === 'talhoes') carregarTalhoes();
        else if (tab === 'colheitas') carregarColheitas();
        else if (tab === 'insumos') carregarInsumos();
        else if (tab === 'receitas') carregarReceitas();
        else if (tab === 'vendas') carregarVendas();
        else if (tab === 'saidas') carregarSaidas();
      });
    });

    /* ══════════════════════════════════════
       BOTÕES DE TOPO
    ══════════════════════════════════════ */
    document.getElementById('btnEditarCooperativa').addEventListener('click', () => {
      showToast('Editar Cooperativa', 'Abra a lista de Cooperativas para editar os dados completos.');
    });
    document.getElementById('btnImprimirFicha').addEventListener('click', () => {
      showToast('Ficha da Cooperativa', 'Geração de PDF será implementada na próxima sprint.');
    });
    document.getElementById('btnEditarDadosCooperativa').addEventListener('click', () => {
      showToast('Editar Dados', 'Funcionalidade em desenvolvimento.');
    });











    /* ══════════════════════════════════=============================================================════
       ─── CRUD AGRICULTORES  zz ───
    ══════════════════════════════════=================================================================════ */
    let agricultoresPage = 1;
    let agricultoresFiltros = { nome: '', estado: '' };

    function carregarAgricultores(page = 1) {
      agricultoresPage = page;

      // Captura o ID da cooperativa dinamicamente a partir da URL atual da página
      const urlParts = window.location.pathname.split('/');
      const idCooperativaAtual = urlParts.find(p => !isNaN(p) && p !== "");

      // Gera os parâmetros corretos para filtrar via backend
      const params = new URLSearchParams({
        page: page,
        nome: agricultoresFiltros.nome,
        estado: agricultoresFiltros.estado
      });

      // Fetch usando rigorosamente o padrão de rota estipulado
      fetch(`/cooperativas/${idCooperativaAtual}/membros/json?${params.toString()}`)
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            renderTabelaAgricultores(data.data);
            renderPaginacaoAgricultores(data);

            // Atualiza contadores na Blade
            if (document.getElementById('totalAgricultores')) {
              document.getElementById('totalAgricultores').textContent = data.total || 0;
            }
            const navCount = document.querySelector('[data-tab="agricultores"] .nav-count');
            if (navCount) navCount.textContent = data.total || 0;
          }
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar agricultores.', 'danger');
          console.error(err);
        });
    }

    function renderTabelaAgricultores(agricultores) {
      const tbody = document.getElementById('corpoTabelaAgricultores');
      if (!tbody) return;

      if (!agricultores || agricultores.length === 0) {
        tbody.innerHTML = `
      <tr>
        <td colspan="6" style="text-align:center;padding:40px;color:var(--text-light);">
          <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
          Nenhum agricultor associado.
        </td>
      </tr>
    `;
        return;
      }

      // Renderização limpa, sem cores excessivas, apenas preto/cinza
      tbody.innerHTML = agricultores.map(a => `
    <tr>
      <td>
        <div style="display:flex;align-items:center;gap:10px;">
          <div class="ag-avatar-sm" style="background:#e0e0e0; color:#000; font-weight:600; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
            ${a.nome ? a.nome.substring(0, 2).toUpperCase() : '??'}
          </div>
          <div>
            <div style="font-weight:600; color:#000;">${a.nome || 'N/A'}</div>
            <div style="font-size:11px;color:var(--text-light);">Assoc. desde ${a.created_at ? new Date(a.created_at).toLocaleDateString('pt-PT') : '--'}</div>
          </div>
        </div>
      </td>
      <td>
        <div style="font-size:13px; color:#000;">${a.bi || '--'}</div>
        <div style="font-size:11.5px;color:var(--text-light);">${a.contacto || '--'}</div>
      </td>
      <td><span style="font-size:12px;font-weight:500;color:#000;">${a.cargo || 'Agricultor'}</span></td>
      <td><strong style="color:#000;">${a.talhoes_count || 0}</strong> talões</td>
      <td>
        <span style="color:#000; font-weight:600; cursor:pointer;" onclick="alternarEstadoMembro(${a.id})">
          <i class="bi ${a.estado === 'Activo' ? 'bi-circle-fill' : 'bi-circle'}" style="font-size:9px; margin-right:5px; color:#000;"></i>${a.estado}
        </span>
      </td>
      <td style="text-align:center;">
        <div style="display:flex;gap:6px;justify-content:center;">
          <a class="action-btn view" title="Ver perfil" href="/agricultores/${a.agricultor_id}" style="color:#000; padding:4px 8px;"><i class="bi bi-eye-fill"></i></a>
          <button class="action-btn delete" title="Remover" onclick="abrirModalRemoverAgricultor(${a.id}, '${a.nome}')" style="background:none; border:none; color:#000; cursor:pointer;"><i class="bi bi-person-dash-fill"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
    }

    function renderPaginacaoAgricultores(data) {
      const info = document.getElementById('infoAgricultores');
      const links = document.getElementById('paginacaoLinksAgricultores');
      if (!links) return;

      if (info) {
        info.textContent = `Mostrando ${data.from || 0} - ${data.to || 0} de ${data.total || 0} registos`;
      }

      if (data.last_page <= 1) { links.innerHTML = ''; return; }

      let html = '';
      html += `<li class="page-item ${data.prev_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarAgricultores(${data.current_page - 1});return false;" style="color:#000;">«</a></li>`;

      for (let i = 1; i <= data.last_page; i++) {
        html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
      <a class="page-link" href="#" onclick="carregarAgricultores(${i});return false;" style="${i === data.current_page ? 'background:#000; border-color:#000; color:#fff;' : 'color:#000;'}">${i}</a></li>`;
      }

      html += `<li class="page-item ${data.next_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarAgricultores(${data.current_page + 1});return false;" style="color:#000;">»</a></li>`;

      links.innerHTML = html;
    }

    /* Eventos para Filtros */
    document.getElementById('btnFiltrarAgricultores')?.addEventListener('click', () => {
      agricultoresFiltros.nome = document.getElementById('filtroAgricultorNome').value;
      agricultoresFiltros.estado = document.getElementById('filtroAgricultorEstado').value;
      carregarAgricultores(1);
    });

    document.getElementById('btnLimparFiltrosAgricultores')?.addEventListener('click', () => {
      document.getElementById('filtroAgricultorNome').value = '';
      document.getElementById('filtroAgricultorEstado').value = '';
      agricultoresFiltros = { nome: '', estado: '' };
      carregarAgricultores(1);
    });

    /* Envio do Formulário de Associação (Salvar) */
    document.getElementById('btnSalvarAgricultor')?.addEventListener('click', () => {
      const urlParts = window.location.pathname.split('/');
      const idCooperativaAtual = urlParts.find(p => !isNaN(p) && p !== "");

      const data = {
        agricultor_id: document.getElementById('selectAgricultor').value,
        cargo: document.getElementById('agricultorCargo').value
      };

      fetch(`/cooperativas/${idCooperativaAtual}/membros/associar`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Membro associado com sucesso!');
            bootstrap.Modal.getInstance(document.getElementById('modalAssociarAgricultor')).hide();
            carregarAgricultores(1);
          } else {
            showToast('Erro', result.message || 'Falha ao associar.', 'danger');
          }
        })
        .catch(err => console.error(err));
    });

    /* Alternar Estado via AJAX */
    function alternarEstadoMembro(id) {
      const urlParts = window.location.pathname.split('/');
      const idCooperativaAtual = urlParts.find(p => !isNaN(p) && p !== "");

      fetch(`/cooperativas/${idCooperativaAtual}/membros/${id}/alternar-estado`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
        .then(res => res.json())
        .then(() => carregarAgricultores(agricultoresPage));
    }

    /* Remover Membro da Cooperativa */
    document.getElementById('btnConfirmarRemover')?.addEventListener('click', () => {
      const urlParts = window.location.pathname.split('/');
      const idCooperativaAtual = urlParts.find(p => !isNaN(p) && p !== "");
      const id = document.getElementById('removerAgricultorId').value;

      fetch(`/cooperativas/${idCooperativaAtual}/membros/${id}/remover`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Agricultor removido com sucesso!');
            bootstrap.Modal.getInstance(document.getElementById('modalRemoverAgricultor')).hide();
            carregarAgricultores(1);
          }
        })
        .catch(err => console.error(err));
    });

    // Inicialização Automática
    document.addEventListener('DOMContentLoaded', () => {
      carregarAgricultores(1);
    });




    /* ════════════════════════════==============================================================══════════
       ─── CRUD TALHÕES ─── tt
    ═══════════════════════════════=================================================================═══════ */
  
    let talhoesPage = 1;

    function carregarTalhoes(page = 1) {
      talhoesPage = page;
      const params = new URLSearchParams({ page });
      

      fetch(`/api/cooperativas/${cooperativaId}/talhoes?${params}`)
        .then(res => res.json())
        .then(data => {
          renderTabelaTalhoes(data.data);
          renderPaginacaoTalhoes(data);
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar talhões.', 'danger');
          console.error(err);
        });
    }

    function renderTabelaTalhoes(talhoes) {
      const tbody = document.getElementById('corpoTabelaTalhoes');
      if (!talhoes || talhoes.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
      <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Nenhum talhão registado.</td></tr>`;
        return;
      }

      tbody.innerHTML = talhoes.map(t => `
    <tr>
      <td><i class="bi bi-map-fill me-1" style="color:var(--primary);"></i>${t.designacao || 'N/A'}</td>
      <td>${t.agricultor?.nome_completo || '--'}</td>
      <td><strong>${t.area || 0} ha</strong></td>
      <td>${t.cultura_actual || '--'}</td>
      <td>${t.localizacao || '--'}</td>
      <td><span class="badge-status ${(t.estado || 'Em Cultivo').toLowerCase().replace(/\s/g, '_')}"><span class="dot"></span>${t.estado || 'Em Cultivo'}</span></td>
      <td style="text-align:center;">
        <div style="display:flex;gap:6px;justify-content:center;">
          <button class="action-btn edit" title="Editar" onclick="showToast('Editar Talhão','Funcionalidade em desenvolvimento.')"><i class="bi bi-pencil-fill"></i></button>
          <button class="action-btn delete" title="Apagar" onclick="showToast('Apagar Talhão','Funcionalidade em desenvolvimento.','danger')"><i class="bi bi-trash-fill"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
    }

    function renderPaginacaoTalhoes(data) {
      const info = document.getElementById('infoTalhoes');
      const links = document.getElementById('paginacaoLinksTalhoes');
      info.textContent = `Mostrando ${data.from || 0} - ${data.to || 0} de ${data.total || 0} registos`;

      if (data.last_page <= 1) { links.innerHTML = ''; return; }

      let html = '';
      html += `<li class="page-item ${data.prev_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarTalhoes(${data.current_page - 1});return false;">«</a></li>`;
      for (let i = 1; i <= data.last_page; i++) {
        html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
      <a class="page-link" href="#" onclick="carregarTalhoes(${i});return false;">${i}</a></li>`;
      }
      html += `<li class="page-item ${data.next_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarTalhoes(${data.current_page + 1});return false;">»</a></li>`;
      links.innerHTML = html;
    }

    /* Modal Talhão */
    const modalTalhao = new bootstrap.Modal(document.getElementById('modalNovoTalhao'));

    document.getElementById('btnNovoTalhao').addEventListener('click', () => {
      fetch('/api/cooperativa/agricultores?per_page=1000')
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById('talhaoAgricultor');
          select.innerHTML = '<option value="">Selecione um agricultor</option>' +
            data.data.map(a => `<option value="${a.id}">${a.nome}</option>`).join('');
        });
      document.getElementById('formNovoTalhao').reset();
      modalTalhao.show();
    });

    document.getElementById('btnSalvarTalhao').addEventListener('click', () => {
      const data = {
        designacao: document.getElementById('talhaoDesignacao').value,
        agricultor_id: document.getElementById('talhaoAgricultor').value,
        area: document.getElementById('talhaoArea').value,
        cultura_actual: document.getElementById('talhaoCultura').value,
        localizacao: document.getElementById('talhaoLocalizacao').value,
        estado: document.getElementById('talhaoEstado').value
      };

      fetch('/api/cooperativa/talhoes', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Talhão registado com sucesso!');
            modalTalhao.hide();
            carregarTalhoes(talhoesPage);
          } else {
            showToast('Erro', result.message || 'Falha ao registrar talhão.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });














    /* ═════════════════════════════==================================================================═════════
       ─── CRUD COLHEITAS ─── cc
    ══════════════════════════=====================================================================════════════ */
    let colheitasPage = 1;

    function carregarColheitas(page = 1) {
      colheitasPage = page;
      const params = new URLSearchParams({ page });

      fetch(`/api/cooperativa/colheitas?${params}`)
        .then(res => res.json())
        .then(data => {
          renderTabelaColheitas(data.data);
          renderPaginacaoColheitas(data);
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar colheitas.', 'danger');
          console.error(err);
        });
    }

    function renderTabelaColheitas(colheitas) {
      const tbody = document.getElementById('corpoTabelaColheitas');
      if (!colheitas || colheitas.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
      <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Nenhuma colheita registada.</td></tr>`;
        return;
      }

      tbody.innerHTML = colheitas.map(c => `
    <tr>
      <td><i class="bi bi-flower2 me-1" style="color:var(--primary);"></i>${c.cultura || 'N/A'}</td>
      <td>${c.agricultor_nome || '--'}</td>
      <td>${c.talhao || '--'}</td>
      <td>${c.data ? new Date(c.data).toLocaleDateString('pt-PT') : '--'}</td>
      <td><strong>${c.quantidade || 0} kg</strong></td>
      <td><span class="badge-status ${(c.qualidade || 'Boa').toLowerCase()}"><span class="dot"></span>${c.qualidade || 'Boa'}</span></td>
      <td style="text-align:center;">
        <div style="display:flex;gap:6px;justify-content:center;">
          <button class="action-btn edit" title="Editar" onclick="showToast('Editar Colheita','Funcionalidade em desenvolvimento.')"><i class="bi bi-pencil-fill"></i></button>
          <button class="action-btn delete" title="Apagar" onclick="showToast('Apagar Colheita','Funcionalidade em desenvolvimento.','danger')"><i class="bi bi-trash-fill"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
    }

    function renderPaginacaoColheitas(data) {
      const info = document.getElementById('infoColheitas');
      const links = document.getElementById('paginacaoLinksColheitas');
      info.textContent = `Mostrando ${data.from || 0} - ${data.to || 0} de ${data.total || 0} registos`;

      if (data.last_page <= 1) { links.innerHTML = ''; return; }

      let html = '';
      html += `<li class="page-item ${data.prev_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarColheitas(${data.current_page - 1});return false;">«</a></li>`;
      for (let i = 1; i <= data.last_page; i++) {
        html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
      <a class="page-link" href="#" onclick="carregarColheitas(${i});return false;">${i}</a></li>`;
      }
      html += `<li class="page-item ${data.next_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarColheitas(${data.current_page + 1});return false;">»</a></li>`;
      links.innerHTML = html;
    }

    /* Modal Colheita */
    const modalColheita = new bootstrap.Modal(document.getElementById('modalNovaColheita'));

    document.getElementById('btnNovaColheita').addEventListener('click', () => {
      fetch('/api/cooperativa/agricultores?per_page=1000')
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById('colheitaAgricultor');
          select.innerHTML = '<option value="">Selecione um agricultor</option>' +
            data.data.map(a => `<option value="${a.id}">${a.nome}</option>`).join('');
        });
      document.getElementById('formNovaColheita').reset();
      document.getElementById('colheitaData').valueAsDate = new Date();
      modalColheita.show();
    });

    document.getElementById('btnSalvarColheita').addEventListener('click', () => {
      const data = {
        cultura: document.getElementById('colheitaCultura').value,
        agricultor_id: document.getElementById('colheitaAgricultor').value,
        talhao: document.getElementById('colheitaTalhao').value,
        data: document.getElementById('colheitaData').value,
        quantidade: document.getElementById('colheitaQuantidade').value,
        qualidade: document.getElementById('colheitaQualidade').value
      };

      fetch('/api/cooperativa/colheitas', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Colheita registada com sucesso!');
            modalColheita.hide();
            carregarColheitas(colheitasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao registrar colheita.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });














    /* ════════════════════════════════===========================================================══════
       ─── CRUD INSUMOS (Saída) ─── ii
    ════════════════════════════════============================================================══════ */
    // Variáveis Globais de Controlo
    let historicoData = [];      // Guarda todos os registos originais vindos do servidor
    let historicoFiltrado = [];  // Guarda os registos após aplicar os filtros
    let insumosPage = 1;
    const insumosPorPagina = 10;

    // Captura o ID da cooperativa dinamicamente da URL do Laravel
    const urlParts = window.location.pathname.split('/');
    let idx = urlParts.indexOf('cooperativa');
    if (idx === -1) idx = urlParts.indexOf('cooperativas');
    const cooperativaId = idx !== -1 ? urlParts[idx + 1] : "{{ $cooperativa->id ?? '' }}";

    // Inicializa os Eventos quando a página carrega
    document.addEventListener('DOMContentLoaded', function () {
      carregarHistorico();

      // Eventos de Clique nos botões de Filtrar e Limpar
      document.getElementById('btnFiltrarInsumos')?.addEventListener('click', aplicarFiltrosHistorico);
      document.getElementById('btnLimparFiltrosInsumos')?.addEventListener('click', limparFiltrosHistorico);
    });

    // 1. Função para procurar os dados na Rota que definiste
    function carregarHistorico() {
      if (!cooperativaId) return;

      fetch(`/cooperativa/${cooperativaId}/estoque/historico`)
        .then(res => res.json())
        .then(res => {
          if (res.success) {
            historicoData = res.data;
            historicoFiltrado = [...historicoData]; // Cópia inicial
            renderTabelaHistorico();
          } else {
            showToast('Erro', res.message || 'Falha ao carregar histórico.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Não foi possível conectar ao servidor.', 'danger');
          console.error(err);
        });
    }

    // 2. Função de Processamento dos Filtros do teu HTML
    function aplicarFiltrosHistorico() {
      const buscaCategoria = document.getElementById('filtroInsumoCategoria')?.value.toLowerCase().trim() || '';
      const buscaEstado = document.getElementById('filtroInsumoEstado')?.value.toLowerCase() || '';

      historicoFiltrado = historicoData.filter(item => {
        // Filtra por Categoria / Nome do Insumo
        const matchCategoria = item.insumo_nome.toLowerCase().includes(buscaCategoria);
        // Filtra pelo Estado (Pago, Pendente, etc.)
        const matchEstado = buscaEstado ? item.estado.toLowerCase() === buscaEstado : true;

        return matchCategoria && matchEstado;
      });

      insumosPage = 1; // Volta para a primeira página após filtrar
      renderTabelaHistorico();
    }

    // 3. Função para Limpar os Inputs e restaurar os dados
    function limparFiltrosHistorico() {
      const inputCat = document.getElementById('filtroInsumoCategoria');
      const selectEst = document.getElementById('filtroInsumoEstado');

      if (inputCat) inputCat.value = '';
      if (selectEst) selectEst.value = '';

      historicoFiltrado = [...historicoData];
      insumosPage = 1;
      renderTabelaHistorico();
    }

    // 4. Desenha as linhas da tabela no HTML (Corpo da Tabela)
    function renderTabelaHistorico() {
      const tbody = document.getElementById('corpoTabelaInsumos');
      if (!tbody) return;

      // Lógica interna de paginação frontend
      const total = historicoFiltrado.length;
      const totalPages = Math.ceil(total / insumosPorPagina) || 1;

      if (insumosPage > totalPages) insumosPage = totalPages;
      const start = (insumosPage - 1) * insumosPorPagina;
      const end = Math.min(start + insumosPorPagina, total);
      const itensPagina = historicoFiltrado.slice(start, end);

      if (itensPagina.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:30px;color:gray;">
            <i class="bi bi-inbox" style="font-size:24px;display:block;"></i> Nenhum movimento encontrado.</td></tr>`;
        renderPaginacaoLinks(totalPages);
        return;
      }

      tbody.innerHTML = itensPagina.map(item => {
        const estadoClass = item.estado ? item.estado.toLowerCase() : 'pendente';
        const tipoMovClass = item.tipo_movimento === 'Saída' ? 'danger' : 'success';
        const formatarTexto = (txt) => txt ? txt.charAt(0).toUpperCase() + txt.slice(1).toLowerCase() : '';

        return `
            <tr>
                <td><strong>${item.insumo_nome}</strong><br><small style="color:var(--text-light);">${item.data}</small></td>
                <td>${item.agricultor_nome}</td>
                <td><span class="badge bg-${tipoMovClass}">${item.tipo_movimento}</span></td>
                <td><strong>${item.quantidade}</strong></td>
                <td>${formatarTexto(item.modalidade)}</td>
                <td><span class="badge-status ${estadoClass}"><span class="dot"></span> ${formatarTexto(item.estado)}</span></td>
            </tr>
        `;
      }).join('');

      // Atualiza o texto informativo da paginação (Ex: Mostrando 1 - 10 de 25)
      const infoContainer = document.getElementById('infoInsumos');
      if (infoContainer) {
        infoContainer.textContent = `Mostrando ${total === 0 ? 0 : start + 1} - ${end} de ${total} movimentos`;
      }

      renderPaginacaoLinks(totalPages);
    }

    // 5. Gera os botões numéricos da paginação
    function renderPaginacaoLinks(totalPages) {
      const pagUl = document.getElementById('paginacaoLinksInsumos');
      if (!pagUl) return;

      let html = '';
      // Botão Anterior
      html += `<li class="page-item ${insumosPage <= 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="event.preventDefault(); mudarPaginaInsumos(${insumosPage - 1})"><i class="bi bi-chevron-left"></i></a>
    </li>`;

      // Páginas numéricas
      for (let i = 1; i <= totalPages; i++) {
        html += `<li class="page-item ${i === insumosPage ? 'active' : ''}">
            <a class="page-link" href="#" onclick="event.preventDefault(); mudarPaginaInsumos(${i})">${i}</a>
        </li>`;
      }

      // Botão Próximo
      html += `<li class="page-item ${insumosPage >= totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="event.preventDefault(); mudarPaginaInsumos(${insumosPage + 1})"><i class="bi bi-chevron-right"></i></a>
    </li>`;

      pagUl.innerHTML = html;
    }

    // Controla a mudança de página
    function mudarPaginaInsumos(novaPagina) {
      insumosPage = novaPagina;
      renderTabelaHistorico();
    }


    function carregarInsumos() {
      aplicarFiltrosHistorico();
    }
















    /* ═════════════════════════════════===============================================================═════
       ─── CRUD RECEITAS ───
    ═══════════════════════════════════============================================================═══ */
    let receitasPage = 1;
    let receitasFiltros = { nome: '', estado: '' };

    function carregarReceitas(page = 1) {
      receitasPage = page;
      const params = new URLSearchParams({
        page,
        nome: receitasFiltros.nome,
        estado: receitasFiltros.estado
      });

      fetch(`/api/cooperativa/receitas?${params}`)
        .then(res => res.json())
        .then(data => {
          renderTabelaReceitas(data.data);
          renderPaginacaoReceitas(data);
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar receitas.', 'danger');
          console.error(err);
        });
    }

    function renderTabelaReceitas(receitas) {
      const tbody = document.getElementById('corpoTabelaReceitas');
      if (!receitas || receitas.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
      <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Nenhuma receita registada.</td></tr>`;
        return;
      }

      tbody.innerHTML = receitas.map(r => `
    <tr>
      <td><i class="bi bi-cash-coin me-1" style="color:var(--primary);"></i>${r.descricao || 'N/A'}</td>
      <td>${r.origem || '--'}</td>
      <td>${r.agricultor_nome || 'Cooperativa (Geral)'}</td>
      <td>${r.data ? new Date(r.data).toLocaleDateString('pt-PT') : '--'}</td>
      <td><strong>${(r.valor || 0).toLocaleString('pt-AO')}</strong></td>
      <td><span class="badge-status ${(r.estado || 'Pendente').toLowerCase()}"><span class="dot"></span>${r.estado || 'Pendente'}</span></td>
      <td style="text-align:center;">
        <div style="display:flex;gap:6px;justify-content:center;">
          <button class="action-btn edit" title="Editar" onclick="abrirModalEditarReceita(${r.id})"><i class="bi bi-pencil-fill"></i></button>
          <button class="action-btn delete" title="Apagar" onclick="showToast('Apagar Receita','Funcionalidade em desenvolvimento.','danger')"><i class="bi bi-trash-fill"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
    }

    function renderPaginacaoReceitas(data) {
      const info = document.getElementById('infoReceitas');
      const links = document.getElementById('paginacaoLinksReceitas');
      info.textContent = `Mostrando ${data.from || 0} - ${data.to || 0} de ${data.total || 0} registos`;

      if (data.last_page <= 1) { links.innerHTML = ''; return; }

      let html = '';
      html += `<li class="page-item ${data.prev_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarReceitas(${data.current_page - 1});return false;">«</a></li>`;
      for (let i = 1; i <= data.last_page; i++) {
        html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
      <a class="page-link" href="#" onclick="carregarReceitas(${i});return false;">${i}</a></li>`;
      }
      html += `<li class="page-item ${data.next_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarReceitas(${data.current_page + 1});return false;">»</a></li>`;
      links.innerHTML = html;
    }

    /* Filtros Receitas */
    document.getElementById('btnFiltrarReceitas').addEventListener('click', () => {
      receitasFiltros.nome = document.getElementById('filtroReceitaNome').value;
      receitasFiltros.estado = document.getElementById('filtroReceitaEstado').value;
      carregarReceitas(1);
    });

    document.getElementById('btnLimparFiltrosReceitas').addEventListener('click', () => {
      document.getElementById('filtroReceitaNome').value = '';
      document.getElementById('filtroReceitaEstado').value = '';
      receitasFiltros = { nome: '', estado: '' };
      carregarReceitas(1);
    });

    /* Modal Nova Receita */
    const modalReceita = new bootstrap.Modal(document.getElementById('modalNovaReceita'));

    document.getElementById('btnNovaReceita').addEventListener('click', () => {
      fetch('/api/cooperativa/agricultores?per_page=1000')
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById('receitaAgricultor');
          select.innerHTML = '<option value="Cooperativa (Geral)">Cooperativa (Geral)</option>' +
            data.data.map(a => `<option value="${a.id}">${a.nome}</option>`).join('');
        });
      document.getElementById('formNovaReceita').reset();
      document.getElementById('receitaData').valueAsDate = new Date();
      modalReceita.show();
    });

    document.getElementById('btnSalvarReceita').addEventListener('click', () => {
      const data = {
        descricao: document.getElementById('receitaDescricao').value,
        origem: document.getElementById('receitaOrigem').value,
        agricultor_id: document.getElementById('receitaAgricultor').value,
        data: document.getElementById('receitaData').value,
        valor: document.getElementById('receitaValor').value,
        estado: document.getElementById('receitaEstado').value
      };

      fetch('/api/cooperativa/receitas', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Receita registada com sucesso!');
            modalReceita.hide();
            carregarReceitas(receitasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao registrar receita.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });

    /* Modal Editar Receita */
    const modalEditarReceita = new bootstrap.Modal(document.getElementById('modalEditarReceita'));

    function abrirModalEditarReceita(id) {
      fetch(`/api/cooperativa/receitas/${id}`)
        .then(res => res.json())
        .then(data => {
          const r = data.data;
          document.getElementById('editarReceitaId').value = r.id;
          document.getElementById('editarReceitaDescricao').value = r.descricao || '';
          document.getElementById('editarReceitaOrigem').value = r.origem || 'Comercial';
          document.getElementById('editarReceitaData').value = r.data || '';
          document.getElementById('editarReceitaValor').value = r.valor || '';
          document.getElementById('editarReceitaEstado').value = r.estado || 'Pendente';

          fetch('/api/cooperativa/agricultores?per_page=1000')
            .then(res => res.json())
            .then(agData => {
              const select = document.getElementById('editarReceitaAgricultor');
              select.innerHTML = '<option value="Cooperativa (Geral)">Cooperativa (Geral)</option>' +
                agData.data.map(a =>
                  `<option value="${a.id}" ${a.id == r.agricultor_id ? 'selected' : ''}>${a.nome}</option>`
                ).join('');
              modalEditarReceita.show();
            });
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar dados da receita.', 'danger');
          console.error(err);
        });
    }

    document.getElementById('btnSalvarEditarReceita').addEventListener('click', () => {
      const id = document.getElementById('editarReceitaId').value;
      const data = {
        descricao: document.getElementById('editarReceitaDescricao').value,
        origem: document.getElementById('editarReceitaOrigem').value,
        agricultor_id: document.getElementById('editarReceitaAgricultor').value,
        data: document.getElementById('editarReceitaData').value,
        valor: document.getElementById('editarReceitaValor').value,
        estado: document.getElementById('editarReceitaEstado').value
      };

      fetch(`/api/cooperativa/receitas/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Receita atualizada com sucesso!');
            modalEditarReceita.hide();
            carregarReceitas(receitasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao atualizar.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });









    /* ════════════════════════════=========================================================══════════
       ─── CRUD VENDAS ───
    ═════════════════════════===============================================================═════════════ */
    let vendasPage = 1;
    let vendasFiltros = { nome: '', estado: '' };

    function carregarVendas(page = 1) {
      vendasPage = page;
      const params = new URLSearchParams({
        page,
        nome: vendasFiltros.nome,
        estado: vendasFiltros.estado
      });

      fetch(`/api/cooperativa/vendas?${params}`)
        .then(res => res.json())
        .then(data => {
          renderTabelaVendas(data.data);
          renderPaginacaoVendas(data);
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar vendas.', 'danger');
          console.error(err);
        });
    }

    function renderTabelaVendas(vendas) {
      const tbody = document.getElementById('corpoTabelaVendas');
      if (!vendas || vendas.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:40px;color:var(--text-light);">
      <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Nenhuma venda registada.</td></tr>`;
        return;
      }

      tbody.innerHTML = vendas.map(v => `
    <tr>
      <td><i class="bi bi-basket-fill me-1" style="color:var(--primary);"></i>${v.produto || 'N/A'}</td>
      <td>${v.agricultor_nome || '--'}</td>
      <td>${v.comprador || '--'}</td>
      <td>${v.data ? new Date(v.data).toLocaleDateString('pt-PT') : '--'}</td>
      <td>${v.quantidade || '--'}</td>
      <td><strong>${(v.valor || 0).toLocaleString('pt-AO')}</strong></td>
      <td><span class="badge-status ${(v.estado || 'Pendente').toLowerCase()}"><span class="dot"></span>${v.estado || 'Pendente'}</span></td>
      <td style="text-align:center;">
        <div style="display:flex;gap:6px;justify-content:center;">
          <button class="action-btn edit" title="Editar" onclick="abrirModalEditarVenda(${v.id})"><i class="bi bi-pencil-fill"></i></button>
          <button class="action-btn delete" title="Apagar" onclick="showToast('Apagar Venda','Funcionalidade em desenvolvimento.','danger')"><i class="bi bi-trash-fill"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
    }

    function renderPaginacaoVendas(data) {
      const info = document.getElementById('infoVendas');
      const links = document.getElementById('paginacaoLinksVendas');
      info.textContent = `Mostrando ${data.from || 0} - ${data.to || 0} de ${data.total || 0} registos`;

      if (data.last_page <= 1) { links.innerHTML = ''; return; }

      let html = '';
      html += `<li class="page-item ${data.prev_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarVendas(${data.current_page - 1});return false;">«</a></li>`;
      for (let i = 1; i <= data.last_page; i++) {
        html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
      <a class="page-link" href="#" onclick="carregarVendas(${i});return false;">${i}</a></li>`;
      }
      html += `<li class="page-item ${data.next_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarVendas(${data.current_page + 1});return false;">»</a></li>`;
      links.innerHTML = html;
    }

    /* Filtros Vendas */
    document.getElementById('btnFiltrarVendas').addEventListener('click', () => {
      vendasFiltros.nome = document.getElementById('filtroVendaNome').value;
      vendasFiltros.estado = document.getElementById('filtroVendaEstado').value;
      carregarVendas(1);
    });

    document.getElementById('btnLimparFiltrosVendas').addEventListener('click', () => {
      document.getElementById('filtroVendaNome').value = '';
      document.getElementById('filtroVendaEstado').value = '';
      vendasFiltros = { nome: '', estado: '' };
      carregarVendas(1);
    });

    /* Modal Nova Venda */
    const modalVenda = new bootstrap.Modal(document.getElementById('modalNovaVenda'));

    document.getElementById('btnNovaVenda').addEventListener('click', () => {
      fetch('/api/cooperativa/agricultores?per_page=1000')
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById('vendaAgricultor');
          select.innerHTML = '<option value="">Selecione um agricultor</option>' +
            data.data.map(a => `<option value="${a.id}">${a.nome}</option>`).join('');
        });
      document.getElementById('formNovaVenda').reset();
      document.getElementById('vendaData').valueAsDate = new Date();
      modalVenda.show();
    });

    document.getElementById('btnSalvarVenda').addEventListener('click', () => {
      const data = {
        produto: document.getElementById('vendaProduto').value,
        agricultor_id: document.getElementById('vendaAgricultor').value,
        comprador: document.getElementById('vendaComprador').value,
        data: document.getElementById('vendaData').value,
        quantidade: document.getElementById('vendaQuantidade').value,
        valor: document.getElementById('vendaValor').value,
        estado: document.getElementById('vendaEstado').value
      };

      fetch('/api/cooperativa/vendas', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Venda registada com sucesso!');
            modalVenda.hide();
            carregarVendas(vendasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao registrar venda.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });

    /* Modal Editar Venda */
    const modalEditarVenda = new bootstrap.Modal(document.getElementById('modalEditarVenda'));

    function abrirModalEditarVenda(id) {
      fetch(`/api/cooperativa/vendas/${id}`)
        .then(res => res.json())
        .then(data => {
          const v = data.data;
          document.getElementById('editarVendaId').value = v.id;
          document.getElementById('editarVendaProduto').value = v.produto || '';
          document.getElementById('editarVendaComprador').value = v.comprador || '';
          document.getElementById('editarVendaData').value = v.data || '';
          document.getElementById('editarVendaQuantidade').value = v.quantidade || '';
          document.getElementById('editarVendaValor').value = v.valor || '';
          document.getElementById('editarVendaEstado').value = v.estado || 'Pendente';

          fetch('/api/cooperativa/agricultores?per_page=1000')
            .then(res => res.json())
            .then(agData => {
              const select = document.getElementById('editarVendaAgricultor');
              select.innerHTML = '<option value="">Selecione um agricultor</option>' +
                agData.data.map(a =>
                  `<option value="${a.id}" ${a.id == v.agricultor_id ? 'selected' : ''}>${a.nome}</option>`
                ).join('');
              modalEditarVenda.show();
            });
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar dados da venda.', 'danger');
          console.error(err);
        });
    }

    document.getElementById('btnSalvarEditarVenda').addEventListener('click', () => {
      const id = document.getElementById('editarVendaId').value;
      const data = {
        produto: document.getElementById('editarVendaProduto').value,
        agricultor_id: document.getElementById('editarVendaAgricultor').value,
        comprador: document.getElementById('editarVendaComprador').value,
        data: document.getElementById('editarVendaData').value,
        quantidade: document.getElementById('editarVendaQuantidade').value,
        valor: document.getElementById('editarVendaValor').value,
        estado: document.getElementById('editarVendaEstado').value
      };

      fetch(`/api/cooperativa/vendas/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Venda atualizada com sucesso!');
            modalEditarVenda.hide();
            carregarVendas(vendasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao atualizar.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });







    /* ══════════════════════════════════===========================================================════
       ─── CRUD SAÍDAS / DESPESAS ───
    ══════════════════════════════════=============================================================════ */
    let saidasPage = 1;
    let saidasFiltros = { nome: '', estado: '' };

    function carregarSaidas(page = 1) {
      saidasPage = page;
      const params = new URLSearchParams({
        page,
        nome: saidasFiltros.nome,
        estado: saidasFiltros.estado
      });

      fetch(`/api/cooperativa/saidas?${params}`)
        .then(res => res.json())
        .then(data => {
          renderTabelaSaidas(data.data);
          renderPaginacaoSaidas(data);
          atualizarResumoDespesas(data.data || []);
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar despesas.', 'danger');
          console.error(err);
        });
    }

    function renderTabelaSaidas(saidas) {
      const tbody = document.getElementById('corpoTabelaSaidas');
      if (!saidas || saidas.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
      <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Nenhuma despesa registada.</td></tr>`;
        return;
      }

      tbody.innerHTML = saidas.map(s => `
    <tr>
      <td><i class="bi bi-arrow-down-circle-fill me-1" style="color:#C62828;"></i>${s.descricao || 'N/A'}</td>
      <td>${s.categoria || '--'}</td>
      <td>${s.fornecedor || '--'}</td>
      <td>${s.data ? new Date(s.data).toLocaleDateString('pt-PT') : '--'}</td>
      <td><strong>${(s.valor || 0).toLocaleString('pt-AO')}</strong></td>
      <td><span class="badge-status ${(s.estado || 'Pendente').toLowerCase().replace(/\s/g, '_')}"><span class="dot"></span>${s.estado || 'Pendente'}</span></td>
      <td style="text-align:center;">
        <div style="display:flex;gap:6px;justify-content:center;">
          <button class="action-btn edit" title="Editar" onclick="abrirModalEditarSaida(${s.id})"><i class="bi bi-pencil-fill"></i></button>
          <button class="action-btn delete" title="Apagar" onclick="showToast('Apagar Despesa','Funcionalidade em desenvolvimento.','danger')"><i class="bi bi-trash-fill"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
    }

    function renderPaginacaoSaidas(data) {
      const info = document.getElementById('infoSaidas');
      const links = document.getElementById('paginacaoLinksSaidas');
      info.textContent = `Mostrando ${data.from || 0} - ${data.to || 0} de ${data.total || 0} registos`;

      if (data.last_page <= 1) { links.innerHTML = ''; return; }

      let html = '';
      html += `<li class="page-item ${data.prev_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarSaidas(${data.current_page - 1});return false;">«</a></li>`;
      for (let i = 1; i <= data.last_page; i++) {
        html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
      <a class="page-link" href="#" onclick="carregarSaidas(${i});return false;">${i}</a></li>`;
      }
      html += `<li class="page-item ${data.next_page_url ? '' : 'disabled'}">
    <a class="page-link" href="#" onclick="carregarSaidas(${data.current_page + 1});return false;">»</a></li>`;
      links.innerHTML = html;
    }

    function atualizarResumoDespesas(saidas) {
      let totalPago = 0, totalPendente = 0, totalEmAtraso = 0;
      saidas.forEach(s => {
        const valor = parseFloat(s.valor) || 0;
        if (s.estado === 'Pago') totalPago += valor;
        else if (s.estado === 'Pendente') totalPendente += valor;
        else if (s.estado === 'Em Atraso') totalEmAtraso += valor;
      });
      document.getElementById('totalPago').textContent = 'Kz ' + totalPago.toLocaleString('pt-AO');
      document.getElementById('totalPendente').textContent = 'Kz ' + totalPendente.toLocaleString('pt-AO');
      document.getElementById('totalEmAtraso').textContent = 'Kz ' + totalEmAtraso.toLocaleString('pt-AO');
    }

    /* Filtros Saídas */
    document.getElementById('btnFiltrarSaidas').addEventListener('click', () => {
      saidasFiltros.nome = document.getElementById('filtroSaidaNome').value;
      saidasFiltros.estado = document.getElementById('filtroSaidaEstado').value;
      carregarSaidas(1);
    });

    document.getElementById('btnLimparFiltrosSaidas').addEventListener('click', () => {
      document.getElementById('filtroSaidaNome').value = '';
      document.getElementById('filtroSaidaEstado').value = '';
      saidasFiltros = { nome: '', estado: '' };
      carregarSaidas(1);
    });

    /* Modal Nova Saída */
    const modalSaida = new bootstrap.Modal(document.getElementById('modalNovaSaida'));

    document.getElementById('btnNovaSaida').addEventListener('click', () => {
      document.getElementById('formNovaSaida').reset();
      document.getElementById('saidaData').valueAsDate = new Date();
      modalSaida.show();
    });

    document.getElementById('btnSalvarSaida').addEventListener('click', () => {
      const data = {
        descricao: document.getElementById('saidaDescricao').value,
        categoria: document.getElementById('saidaCategoria').value,
        fornecedor: document.getElementById('saidaFornecedor').value,
        data: document.getElementById('saidaData').value,
        valor: document.getElementById('saidaValor').value,
        estado: document.getElementById('saidaEstado').value
      };

      fetch('/api/cooperativa/saidas', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Despesa registada com sucesso!');
            modalSaida.hide();
            carregarSaidas(saidasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao registrar despesa.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });

    /* Modal Editar Saída */
    const modalEditarSaida = new bootstrap.Modal(document.getElementById('modalEditarSaida'));

    function abrirModalEditarSaida(id) {
      fetch(`/api/cooperativa/saidas/${id}`)
        .then(res => res.json())
        .then(data => {
          const s = data.data;
          document.getElementById('editarSaidaId').value = s.id;
          document.getElementById('editarSaidaDescricao').value = s.descricao || '';
          document.getElementById('editarSaidaCategoria').value = s.categoria || 'Insumos';
          document.getElementById('editarSaidaFornecedor').value = s.fornecedor || '';
          document.getElementById('editarSaidaData').value = s.data || '';
          document.getElementById('editarSaidaValor').value = s.valor || '';
          document.getElementById('editarSaidaEstado').value = s.estado || 'Pendente';
          modalEditarSaida.show();
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar dados da despesa.', 'danger');
          console.error(err);
        });
    }

    document.getElementById('btnSalvarEditarSaida').addEventListener('click', () => {
      const id = document.getElementById('editarSaidaId').value;
      const data = {
        descricao: document.getElementById('editarSaidaDescricao').value,
        categoria: document.getElementById('editarSaidaCategoria').value,
        fornecedor: document.getElementById('editarSaidaFornecedor').value,
        data: document.getElementById('editarSaidaData').value,
        valor: document.getElementById('editarSaidaValor').value,
        estado: document.getElementById('editarSaidaEstado').value
      };

      fetch(`/api/cooperativa/saidas/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Despesa atualizada com sucesso!');
            modalEditarSaida.hide();
            carregarSaidas(saidasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao atualizar.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });

    /* ══════════════════════════════════════
       NAV ACTIVE SIDEBAR
    ══════════════════════════════════════ */
    document.querySelectorAll('.nav-item-link').forEach(link => {
      link.addEventListener('click', function (e) {
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
       INICIALIZAÇÃO
    ══════════════════════════════════════ */
    document.addEventListener('DOMContentLoaded', () => {
      //  carregarAgricultores(1);
    });
  </script>

</body>

</html>