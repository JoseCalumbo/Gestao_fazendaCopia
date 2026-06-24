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
      max-width: 2010px;
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

    /* ═══════════════════════════════════════════
       IMPRESSÃO - Estilos para a ficha da cooperativa
    ═══════════════════════════════════════════ */
    @media print {

      #sidebar,
      #topbar,
      .page-header .btn-outline-green,
      .page-header .btn-green,
      .settings-nav,
      .action-btn,
      .btn-green,
      .btn-outline-green,
      .filter-bar,
      .pagination-wrapper {
        display: none !important;
      }

      #main {
        margin-left: 0 !important;
        padding-top: 0 !important;
      }

      .content-inner {
        padding: 20px !important;
      }

      .settings-panel {
        display: block !important;
        page-break-after: always;
      }

      .settings-panel:not(.active) {
        display: block !important;
      }

      .settings-wrap {
        display: block !important;
      }

      .settings-content {
        display: block !important;
      }

      .cfg-card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        break-inside: avoid;
      }

      .stat-card {
        break-inside: avoid;
      }

      .page-header h1 {
        font-size: 24px !important;
      }

      .profile-logo-icon {
        border: 2px solid #000 !important;
      }

      .badge-status {
        color: #000 !important;
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
      <a href="{{ route('cooperativas') }}" class="nav-item-link active" data-label="Cooperativa"><i
          class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
      <a href="{{ route('agricultores.index') }}" class="nav-item-link" data-label="Agricultores"><i
          class="bi bi-person-badge-fill"></i><span class="nav-label">Agricultores</span></a>

      <div class="nav-section-title">Agrícola</div>
      <a href="{{ route('safras.painel') }}" class="nav-item-link" data-label="Safras"><i
          class="bi bi-flower2"></i><span class="nav-label">Safras</span></a>
      <a href="{{ route('talhoes.index') }}" class="nav-item-link" data-label="Talhões"><i
          class="bi bi-map-fill"></i><span class="nav-label">Talhões</span></a>
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

        </div>
      </div>

      <!-- Stat Cards -->
      <div class="row g-3 mb-4 anim anim-d2">
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Total de Agricultores</div>
              <div class="s-value" id="totalAgricultores">0</div>
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
              <div class="s-value">22</div>
              <span class="stat-badge info"><i class="bi bi-box-arrow-in-down"></i> Última: 12 Mai</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Settings-style layout -->
      <div class="settings-wrap anim anim-d3">

        <!-- ── VERTICAL NAV ── ttab -->
        <nav class="settings-nav">
          <button class="settings-nav-item active" data-tab="dados">
            <i class="bi bi-building"></i> Dados da Cooperativa
          </button>
          <button class="settings-nav-item" data-tab="agricultores">
            <i class="bi bi-person-badge-fill"></i> Agricultores <span class="nav-count">348</span>
          </button>
          <button class="settings-nav-item" data-tab="talhoes">
            <i class="bi bi-map-fill"></i> Talhões <span
              class="nav-count">{{ $totalTalhoes = $cooperativa->talhoes()->count() ?? 0}}</span>
          </button>
          <button class="settings-nav-item" data-tab="insumos">
            <i class="bi bi-box-seam-fill"></i> Insumos <span
              class="nav-count">{{ $totalTalhoes = $cooperativa->talhoes()->count() ?? 0}}</span>
          </button>
          <button class="settings-nav-item" data-tab="produtos">
            <i class="bi bi-basket-fill"></i> Produtos <span class="nav-count">0</span>
          </button>
          <button class="settings-nav-item" data-tab="receitas">
            <i class="bi bi-cash-coin"></i> Receitas <span class="nav-count">38</span>
          </button>
          <button class="settings-nav-item" data-tab="vendas">
            <i class="bi bi-cart-fill"></i> Vendas <span class="nav-count">52</span>
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

              </div>
              <div class="cfg-card-body">
                <div style="display:flex;align-items:center;gap:24px;margin-bottom:24px;flex-wrap:wrap;">
                  <!-- Logomarca -->
                  <div class="profile-logo-icon" id="coopLogo"
                    style="width:86px;height:86px;border-radius:18px;color:#fff;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;flex-shrink:0;overflow:hidden;border:3px solid var(--accent-lt);letter-spacing:-1px;font-family:'Sora',sans-serif;">
                    @if($cooperativa->foto)
                      <img src="{{ asset('storage/' . $cooperativa->foto) }}" alt="Logo da Cooperativa"
                        style="width:100%;height:100%;object-fit:cover;">
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
             TAB 2 — AGRICULTORES ogg
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

              <!-- Filtros -->
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

              <!-- Filtros tttt -->
              <div class="filter-bar" id="talhoesFiltros">
                <div class="search-wrap">
                  <i class="bi bi-search"></i>
                  <input type="text" class="search-input" id="filtroTalhaoDesignacao"
                    placeholder="Filtrar por designação...">
                </div>
                <select class="filter-select" id="filtroTalhaoEstado">
                  <option value="">Todos os estados</option>
                  <option value="Em Cultivo">Em Cultivo</option>
                  <option value="Pousio">Pousio</option>
                  <option value="activo">Activo</option>
                  <option value="inactivo">Inactivo</option>
                </select>
                <button class="btn-green btn-filter" id="btnFiltrarTalhoes" style="padding:8px 18px;"><i
                    class="bi bi-search"></i> Filtrar</button>
                <button class="btn-outline-green btn-filter" id="btnLimparFiltrosTalhoes" style="padding:8px 18px;"><i
                    class="bi bi-eraser"></i> Limpar</button>
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
             TAB 4 — INSUMOS
        ════════════════════════ -->
          <div class="settings-panel" id="tab-insumos">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon amber"><i class="bi bi-box-seam-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Movimentação de Insumos</div>
                    <div class="cfg-card-sub">Histórico completo de entradas, saídas e distribuição de insumos da
                      cooperativa</div>
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
             TAB 5 — PRODUTOS
        ════════════════════════ -->
          <div class="settings-panel" id="tab-produtos">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon teal"><i class="bi bi-basket-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Produtos da Cooperativa</div>
                    <div class="cfg-card-sub">Registo de produtos agrícolas disponíveis para venda</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoProduto">
                  <i class="bi bi-plus-lg"></i> Novo Produto
                </button>
              </div>

              <!-- Filtros -->
              <div class="filter-bar" id="produtosFiltros">
                <div class="search-wrap">
                  <i class="bi bi-search"></i>
                  <input type="text" class="search-input" id="filtroProdutoNome" placeholder="Filtrar por nome...">
                </div>
                <select class="filter-select" id="filtroProdutoEstado">
                  <option value="">Todos os estados</option>
                  <option value="disponivel">Disponível</option>
                  <option value="esgotado">Esgotado</option>
                </select>
                <button class="btn-green btn-filter" id="btnFiltrarProdutos" style="padding:8px 18px;"><i
                    class="bi bi-search"></i> Filtrar</button>
                <button class="btn-outline-green btn-filter" id="btnLimparFiltrosProdutos" style="padding:8px 18px;"><i
                    class="bi bi-eraser"></i> Limpar</button>
              </div>

              <div class="table-wrap">
                <table class="mini-table" id="tabelaProdutos">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Categoria</th>
                      <th>Quantidade</th>
                      <th>Unidade</th>
                      <th>Preço Unitário</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody id="corpoTabelaProdutos">
                    <!-- Carregado via AJAX -->
                  </tbody>
                </table>
              </div>
              <div class="pagination-wrapper" id="paginacaoProdutos">
                <div class="pagination-info" id="infoProdutos">Carregando...</div>
                <nav>
                  <ul class="pagination" id="paginacaoLinksProdutos"></ul>
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
              <div class="modal-title" id="ModalAgricultorTitulo">Associar Agricultor</div>
              <div id="ModalAgricultorSubTitulo" style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Vincular agricultor à cooperativa
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
                  <label class="cfg-label">Agricultor *</label>
                  <select class="cfg-select" id="selectAgricultor" required>
                    <option value="">Selecione um agricultor</option>
                    <!-- Preenchido via JS -->
                  </select>
                </div>
                <div class="col-12 col-md-12">
                  <label class="cfg-label">Cargo</label>
                  <select class="cfg-select" id="agricultorCargo">
                    <option value="Sem Cargo">Sem Cargo</option>
                    <option value="Presidente">Presidente</option>
                    <option value="Secretario">Secretario</option>
                    <option value="Sócio">Tesoureiro</option>
                    <option value="Dirigente">Dirigente</option>
                    <option value="Técnico">Técnico</option>
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

  <!-- ─── MODAL TALHÕES: Registrar/Editar Talhão ─── -->
  <div class="modal fade modal-coop" id="modalNovoTalhao" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-map-fill"></i></div>
            <div>
              <div class="modal-title" id="modalTalhaoTitle">Registrar Talhão</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;" id="modalTalhaoSub">Nova parcela
                de
                terra para cultivo</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formNovoTalhao">
            @csrf
            <input type="hidden" id="talhaoId">
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
                    <option value="Colhido">Colhido</option>
                    <option value="inactivo">Inactivo</option>
                    <option value="activo">Activo</option>
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
              <button type="button" class="btn-green" id="btnSalvarTalhao"><i class="bi bi-check2-circle"></i> <span
                  id="btnTalhaoLabel">Registrar</span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL TALHÕES: Confirmar Exclusão ─── -->
  <div class="modal fade" id="modalDeleteTalhao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
      <div class="modal-content">
        <div class="modal-header" style="background:linear-gradient(135deg, #7f0000, #C62828);">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div>
              <div class="modal-title">Confirmar Eliminação</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Esta acção é irreversível</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body" style="background:#fff;padding:28px;">
          <p style="font-size:13.5px;color:var(--text-mid);margin-bottom:10px;">
            Tem a certeza que deseja eliminar o talhão:
          </p>
          <div
            style="background:#FFF8F8;border:1px solid #FFCDD2;border-radius:10px;padding:14px 18px;margin-bottom:16px;">
            <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:#C62828;"
              id="deleteTalhaoNome">—</div>
            <div style="font-size:12px;color:var(--text-light);margin-top:3px;">Todos os dados associados serão
              removidos permanentemente.</div>
          </div>
          <input type="hidden" id="deleteTalhaoId">
        </div>
        <div class="modal-footer" style="border-top:1px solid #FFCDD2;">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn-green" id="btnConfirmDeleteTalhao"
            style="background:#C62828;box-shadow:none;">
            <i class="bi bi-trash-fill"></i> Eliminar Definitivamente
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL PRODUTOS: Registrar/Editar Produto ─── -->
  <div class="modal fade modal-coop" id="modalNovoProduto" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-basket-fill"></i></div>
            <div>
              <div class="modal-title" id="modalProdutoTitle">Registrar Produto</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;" id="modalProdutoSub">Adicionar
                novo produto ao estoque</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formNovoProduto">
            @csrf
            <input type="hidden" id="produtoId">
            <div class="modal-form-card">
              <div class="modal-section-title"><i class="bi bi-basket-fill"></i> Dados do Produto</div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label">Nome do Produto *</label>
                  <input type="text" class="cfg-input" id="produtoNome" required
                    placeholder="Ex: Milho Grão, Feijão Manteiga">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Categoria *</label>
                  <select class="cfg-select" id="produtoCategoria" required>
                    <option value="">Selecione</option>
                    <option value="Grãos">Grãos</option>
                    <option value="Legumes">Legumes</option>
                    <option value="Frutas">Frutas</option>
                    <option value="Outros">Outros</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Unidade de Medida *</label>
                  <input type="text" class="cfg-input" id="produtoUnidade" required placeholder="Ex: kg, saco, L">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Quantidade *</label>
                  <input type="number" class="cfg-input" id="produtoQuantidade" required placeholder="0" step="1">
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label">Preço Unitário (Kz) *</label>
                  <input type="number" class="cfg-input" id="produtoPreco" required placeholder="0" step="0.01">
                </div>
                <div class="col-12">
                  <label class="cfg-label">Estado *</label>
                  <select class="cfg-select" id="produtoEstado" required>
                    <option value="disponivel">Disponível</option>
                    <option value="esgotado">Esgotado</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="cfg-label">Descrição</label>
                  <textarea class="cfg-textarea" id="produtoDescricao" rows="2"
                    placeholder="Descrição opcional do produto"></textarea>
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
              <button type="button" class="btn-green" id="btnSalvarProduto"><i class="bi bi-check2-circle"></i> <span
                  id="btnProdutoLabel">Salvar</span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL PRODUTOS: Confirmar Exclusão ─── -->
  <div class="modal fade" id="modalDeleteProduto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
      <div class="modal-content">
        <div class="modal-header" style="background:linear-gradient(135deg, #7f0000, #C62828);">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div>
              <div class="modal-title">Confirmar Exclusão</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Esta acção é irreversível</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body" style="background:#fff;padding:28px;">
          <p style="font-size:13.5px;color:var(--text-mid);margin-bottom:10px;">
            Tem a certeza que deseja excluir o produto:
          </p>
          <div
            style="background:#FFF8F8;border:1px solid #FFCDD2;border-radius:10px;padding:14px 18px;margin-bottom:16px;">
            <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:#C62828;"
              id="deleteProdutoNome">—</div>
            <div style="font-size:12px;color:var(--text-light);margin-top:3px;">Todos os dados associados serão
              removidos permanentemente.</div>
          </div>
          <input type="hidden" id="deleteProdutoId">
        </div>
        <div class="modal-footer" style="border-top:1px solid #FFCDD2;">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn-green" id="btnConfirmDeleteProduto"
            style="background:#C62828;box-shadow:none;">
            <i class="bi bi-trash-fill"></i> Excluir Definitivamente
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL RECEITAS: Registrar/Editar Receita ─── -->
  <div class="modal fade modal-coop" id="modalNovaReceita" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-cash-coin"></i></div>
            <div>
              <div class="modal-title" id="modalReceitaTitle">Registrar Receita</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;" id="modalReceitaSub">Entrada
                financeira da cooperativa</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formNovaReceita">
            @csrf
            <input type="hidden" id="receitaId">
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
              <button type="button" class="btn-green" id="btnSalvarReceita"><i class="bi bi-check2-circle"></i> <span
                  id="btnReceitaLabel">Registrar</span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL RECEITAS: Confirmar Exclusão ─── -->
  <div class="modal fade" id="modalDeleteReceita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
      <div class="modal-content">
        <div class="modal-header" style="background:linear-gradient(135deg, #7f0000, #C62828);">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div>
              <div class="modal-title">Confirmar Eliminação</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Esta acção é irreversível</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body" style="background:#fff;padding:28px;">
          <p style="font-size:13.5px;color:var(--text-mid);margin-bottom:10px;">
            Tem a certeza que deseja eliminar a receita:
          </p>
          <div
            style="background:#FFF8F8;border:1px solid #FFCDD2;border-radius:10px;padding:14px 18px;margin-bottom:16px;">
            <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:#C62828;"
              id="deleteReceitaNome">—</div>
            <div style="font-size:12px;color:var(--text-light);margin-top:3px;">Todos os dados associados serão
              removidos permanentemente.</div>
          </div>
          <input type="hidden" id="deleteReceitaId">
        </div>
        <div class="modal-footer" style="border-top:1px solid #FFCDD2;">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn-green" id="btnConfirmDeleteReceita"
            style="background:#C62828;box-shadow:none;">
            <i class="bi bi-trash-fill"></i> Eliminar Definitivamente
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL VENDAS: Registrar/Editar Venda ─── -->
  <div class="modal fade modal-coop" id="modalNovaVenda" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-cart-fill"></i></div>
            <div>
              <div class="modal-title" id="modalVendaTitle">Registrar Venda</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;" id="modalVendaSub">Registo de
                venda
                de produtos</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formNovaVenda">
            @csrf
            <input type="hidden" id="vendaId">
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
              <button type="button" class="btn-green" id="btnSalvarVenda"><i class="bi bi-check2-circle"></i> <span
                  id="btnVendaLabel">Registrar</span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── MODAL VENDAS: Confirmar Exclusão ─── -->
  <div class="modal fade" id="modalDeleteVenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
      <div class="modal-content">
        <div class="modal-header" style="background:linear-gradient(135deg, #7f0000, #C62828);">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div>
              <div class="modal-title">Confirmar Eliminação</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Esta acção é irreversível</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body" style="background:#fff;padding:28px;">
          <p style="font-size:13.5px;color:var(--text-mid);margin-bottom:10px;">
            Tem a certeza que deseja eliminar a venda:
          </p>
          <div
            style="background:#FFF8F8;border:1px solid #FFCDD2;border-radius:10px;padding:14px 18px;margin-bottom:16px;">
            <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:#C62828;"
              id="deleteVendaNome">—</div>
            <div style="font-size:12px;color:var(--text-light);margin-top:3px;">Todos os dados associados serão
              removidos permanentemente.</div>
          </div>
          <input type="hidden" id="deleteVendaId">
        </div>
        <div class="modal-footer" style="border-top:1px solid #FFCDD2;">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn-green" id="btnConfirmDeleteVenda"
            style="background:#C62828;box-shadow:none;">
            <i class="bi bi-trash-fill"></i> Eliminar Definitivamente
          </button>
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
      iconI.className = type === 'danger' ? 'bi bi-x-lg' : type === 'warning' ?
        'bi bi-exclamation-triangle-fill' : 'bi bi-check-lg';
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
        else if (tab === 'insumos') carregarInsumos();
        else if (tab === 'produtos') carregarProdutos();
        else if (tab === 'receitas') carregarReceitas();
        else if (tab === 'vendas') carregarVendas();
      });
    });

    /* ══════════════════════════════════════
       VARIÁVEL GLOBAL: ID da Cooperativa
    ══════════════════════════════════════ */
    const cooperativaId = '{{ $cooperativa->id }}';

    /* ══════════════════════════════════════
       ─── IMPRIMIR FICHA ───
    ══════════════════════════════════════ */
    document.getElementById('btnImprimirFicha').addEventListener('click', function () {
      window.print();
    });

    /* ══════════════════════════════════════
       BOTÕES DE TOPO
    ══════════════════════════════════════ */



    /* ══════════════════════════════════════
       ─── CRUD AGRICULTORES ─── agrr agg
    ══════════════════════════════════════ */
    let agricultoresPage = 1;
    let agricultoresFiltros = { nome: '', estado: '' };

    function carregarAgricultores(page = 1) {
      agricultoresPage = page;
      const params = new URLSearchParams({
        page: page,
        nome: agricultoresFiltros.nome,
        estado: agricultoresFiltros.estado
      });

      fetch(`/cooperativas/${cooperativaId}/membros/json?${params}`)
        .then(res => res.json())
        .then(data => {
          renderTabelaAgricultores(data.data);
          renderPaginacaoAgricultores(data);
          document.getElementById('totalAgricultores').textContent = data.total || 0;
          const navCount = document.querySelector('[data-tab="agricultores"] .nav-count');
          if (navCount) navCount.textContent = data.total || 0;
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar agricultores.', 'danger');
          console.error(err);
        });
    }

    function renderTabelaAgricultores(agricultores) {
      const tbody = document.getElementById('corpoTabelaAgricultores');
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

      const cores = ['#1B5E20', '#1565C0', '#F57F17', '#6A1B9A', '#C62828', '#00695C'];
      tbody.innerHTML = agricultores.map((a, i) => `
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px;">
                 <img
            src="${a.foto_url}"
            alt="${a.nome}"
            style="
                width:40px;
                height:40px;
                border-radius:50%;
                object-fit:cover;
            "
               >
               
              <div>
                <div style="font-weight:600;">${a.nome || 'N/A'}</div>
                <div style="font-size:11px;color:var(--text-light);">Assoc. desde ${a.created_at ? new Date(a.created_at).toLocaleDateString('pt-PT') : '--'}</div>
              </div>
            </div>
          </td>
          <td>
            <div style="font-size:13px;">${a.bi || '--'}</div>
            <div style="font-size:11.5px;color:var(--text-light);">${a.contacto || '--'}</div>
          </td>
          <td><span style="font-size:12px;font-weight:500;color:var(--text-mid);">${a.cargo || 'Agricultor'}</span></td>
          <td><strong>${a.talhoes_count || 0}</strong> talhões</td>
          <td><span class="badge-status ${(a.estado || 'Activo').toLowerCase()}"><span class="dot"></span>${a.estado || 'Activo'}</span></td>
          <td style="text-align:center;">
            <div style="display:flex;gap:6px;justify-content:center;">
              <a href="/agricultores/${a.agricultor_id}" class="action-btn view"
                title="Ver detalhes"> <i class="bi bi-eye-fill"></i> </a>
              <button class="action-btn delete" title="Remover" onclick="abrirModalRemoverAgricultor(${a.id}, '${a.nome}')"><i class="bi bi-person-dash-fill"></i></button>
            </div>
          </td>
        </tr>
      `).join('');
    }

    function renderPaginacaoAgricultores(data) {
      const info = document.getElementById('infoAgricultores');
      const links = document.getElementById('paginacaoLinksAgricultores');

      info.textContent = `Mostrando ${data.from || 0} - ${data.to || 0} de ${data.total || 0} registos`;

      if (data.last_page <= 1) {
        links.innerHTML = '';
        return;
      }

      let html = '';
      html += `<li class="page-item ${data.prev_page_url ? '' : 'disabled'}">
        <a class="page-link" href="#" onclick="carregarAgricultores(${data.current_page - 1});return false;">«</a>
      </li>`;

      for (let i = 1; i <= data.last_page; i++) {
        html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
          <a class="page-link" href="#" onclick="carregarAgricultores(${i});return false;">${i}</a>
        </li>`;
      }

      html += `<li class="page-item ${data.next_page_url ? '' : 'disabled'}">
        <a class="page-link" href="#" onclick="carregarAgricultores(${data.current_page + 1});return false;">»</a>
      </li>`;

      links.innerHTML = html;
    }

    /* Filtros Agricultores */
    document.getElementById('btnFiltrarAgricultores').addEventListener('click', () => {
      agricultoresFiltros.nome = document.getElementById('filtroAgricultorNome').value;
      agricultoresFiltros.estado = document.getElementById('filtroAgricultorEstado').value;
      carregarAgricultores(1);
    });

    document.getElementById('btnLimparFiltrosAgricultores').addEventListener('click', () => {
      document.getElementById('filtroAgricultorNome').value = '';
      document.getElementById('filtroAgricultorEstado').value = '';
      agricultoresFiltros = { nome: '', estado: '' };
      carregarAgricultores(1);
    });


    /* Associar Agricultor */
    const modalAssociar = new bootstrap.Modal(document.getElementById('modalAssociarAgricultor'));

    document.getElementById('btnNovoAgricultor').addEventListener('click', () => {
      fetch(`/cooperativas/${cooperativaId}/agricultores/sem-cooperativa`)
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById('selectAgricultor');
          select.innerHTML = '<option value="">Selecione um agricultor</option>' +
            data.data.map(a => `<option value="${a.id}">${a.nome_completo} - <p>Bilhete:${a.bi}</p></option>`).join('');
        });
      document.getElementById('formAssociarAgricultor').reset();
      modalAssociar.show();
    });

    
    document.getElementById('btnSalvarAgricultor').addEventListener('click', () => {
      const data = {
        agricultor_id: document.getElementById('selectAgricultor').value,
        cargo: document.getElementById('agricultorCargo').value,
      };

      fetch(`/cooperativas/${cooperativaId}/membros/associar`, {
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
            showToast('Sucesso', 'Agricultor associado com sucesso!');
            modalAssociar.hide();
            carregarAgricultores(agricultoresPage);
          } else {
            showToast('Erro', result.message || 'Falha ao associar agricultor.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });

    /* Remover Agricultor */
    let removerAgricultorId = null;

    function abrirModalRemoverAgricultor(id, nome) {
      removerAgricultorId = id;
      document.getElementById('removerAgricultorNome').textContent = nome;
      document.getElementById('removerAgricultorId').value = id;
      new bootstrap.Modal(document.getElementById('modalRemoverAgricultor')).show();
    }

    document.getElementById('btnConfirmarRemover').addEventListener('click', () => {
      const id = document.getElementById('removerAgricultorId').value;

      fetch(`/cooperativas/${cooperativaId}/membros/${id}/remover`, {
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
            carregarAgricultores(agricultoresPage);
          } else {
            showToast('Erro', result.message || 'Falha ao remover agricultor.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });





    /* ══════════════════════════════════════
       ─── CRUD TALHÕES ─── tall
    ══════════════════════════════════════ */

    let talhoesPage = 1;
    let talhoesFiltros = { designacao: '', estado: '', agricultor_id: '' };

    function carregarTalhoes(page = 1) {
      talhoesPage = page;
      const params = new URLSearchParams({
        page,
        designacao: talhoesFiltros.designacao,
        estado: talhoesFiltros.estado,
        agricultor_id: talhoesFiltros.agricultor_id
      });

      fetch(`/api/cooperativas/${cooperativaId}/list/talhoes?${params}`)
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
        tbody.innerHTML =
          `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
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
              <button class="action-btn edit" title="Editar" onclick="abrirModalEditarTalhao(${t.id})"><i class="bi bi-pencil-fill"></i></button>
              <button class="action-btn delete" title="Apagar" onclick="abrirModalDeleteTalhao(${t.id}, '${t.designacao}')"><i class="bi bi-trash-fill"></i></button>
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

    /* Filtros Talhões */
    document.getElementById('btnFiltrarTalhoes').addEventListener('click', () => {
      talhoesFiltros.designacao = document.getElementById('filtroTalhaoDesignacao').value;
      talhoesFiltros.estado = document.getElementById('filtroTalhaoEstado').value;
      carregarTalhoes(1);
    });

    document.getElementById('btnLimparFiltrosTalhoes').addEventListener('click', () => {
      document.getElementById('filtroTalhaoDesignacao').value = '';
      document.getElementById('filtroTalhaoEstado').value = '';
      talhoesFiltros = { designacao: '', estado: '', agricultor_id: '' };
      carregarTalhoes(1);
    });

    // /* Popular filtro de agricultores * abc /
    // function carregarFiltroAgricultoresTalhoes() {
    //   fetch(`/api/cooperativas/${cooperativaId}/agricultores`)
    //     .then(res => res.json())
    //     .then(data => {
    //       const select = document.getElementById('filtroTalhaoAgricultor');
    //       select.innerHTML = '<option value="">Todos os agricultores</option>' +
    //         data.data.map(a => `<option value="${a.id}">${a.nome_completo}</option>`).join('');
    //     }); <<
    // }

    /* Modal Talhão - Registrar/Editar */
    const modalTalhao = new bootstrap.Modal(document.getElementById('modalNovoTalhao'));
    document.getElementById('btnNovoTalhao').addEventListener('click', () => {
      document.getElementById('talhaoId').value = '';
      document.getElementById('modalTalhaoTitle').textContent = 'Registrar Talhão';
      document.getElementById('modalTalhaoSub').textContent = 'Nova parcela de terra para cultivo';
      document.getElementById('btnTalhaoLabel').textContent = 'Registrar';

      fetch(`/api/cooperativas/${cooperativaId}/agricultores/associados/activo`)
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById('talhaoAgricultor');
          select.innerHTML = '<option value="">Selecione um agricultor</option>' +
            data.data.map(a => `<option value="${a.id}">${a.nome_completo}</option>`).join('');
        });

      document.getElementById('formNovoTalhao').reset();
      modalTalhao.show();
    });

    function abrirModalEditarTalhao(id) {
      fetch(`/cooperativas/${cooperativaId}/talhoes/show/${id}`)
        .then(res => res.json())
        .then(data => {

          const t = data;
          document.getElementById('talhaoId').value = t.id;
          document.getElementById('modalTalhaoTitle').textContent = 'Editar Talhão';
          document.getElementById('modalTalhaoSub').textContent = 'Atualizar dados do talhão';
          document.getElementById('btnTalhaoLabel').textContent = 'Salvar';
          document.getElementById('talhaoDesignacao').value = t.designacao || '';
          document.getElementById('talhaoArea').value = t.area || '';
          document.getElementById('talhaoCultura').value = t.cultura_actual || '';
          document.getElementById('talhaoLocalizacao').value = t.localizacao || '';
          document.getElementById('talhaoEstado').value = t.estado || 'Em cultivo';

          fetch(`/api/cooperativas/${cooperativaId}/agricultores/associados/activo`)
            .then(res => res.json())
            .then(agData => {
              const select = document.getElementById('talhaoAgricultor');
              select.innerHTML = '<option value="">Selecione um agricultor</option>' +
                agData.data.map(a =>
                  `<option value="${a.id}" ${a.id == t.agricultor_id ? 'selected' : ''}>${a.nome_completo}</option>`
                ).join('');
              modalTalhao.show();
            });
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar dados do talhão.', 'danger');
          console.error(err);
        });
    }

    document.getElementById('btnSalvarTalhao').addEventListener('click', () => {
      const id = document.getElementById('talhaoId').value;
      const data = {
        designacao: document.getElementById('talhaoDesignacao').value,
        agricultor_id: document.getElementById('talhaoAgricultor').value,
        area: document.getElementById('talhaoArea').value,
        cultura_actual: document.getElementById('talhaoCultura').value,
        localizacao: document.getElementById('talhaoLocalizacao').value,
        estado: document.getElementById('talhaoEstado').value
      };

      const url = id ? `/cooperativas/${cooperativaId}/talhoes/${id}/update` : `/cooperativas/${cooperativaId}/talhoes/store`;
      const method = id ? 'PUT' : 'POST';

      fetch(url, {
        method: method,
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
            showToast('Sucesso', id ? 'Talhão atualizado com sucesso!' : 'Talhão registado com sucesso!');
            modalTalhao.hide();
            carregarTalhoes(talhoesPage);
          } else {
            showToast('Erro', result.message || 'Falha ao salvar talhão.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });


    /* Modal Delete Talhão */
    const modalDeleteTalhao = new bootstrap.Modal(document.getElementById('modalDeleteTalhao'));
    let deleteTalhaoId = null;
    let deleteTalhaoNome = '';

    function abrirModalDeleteTalhao(id, nome) {
      deleteTalhaoId = id;
      deleteTalhaoNome = nome;
      document.getElementById('deleteTalhaoNome').textContent = nome;
      document.getElementById('deleteTalhaoId').value = id;
      modalDeleteTalhao.show();
    }

    //delete talhão
    document.getElementById('btnConfirmDeleteTalhao').addEventListener('click', () => {
      const id = document.getElementById('deleteTalhaoId').value;
      fetch(`/cooperativas/${cooperativaId}/talhoes/${id}/delete`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Talhão excluído com sucesso!');
            modalDeleteTalhao.hide();
            carregarTalhoes(talhoesPage);
          } else {
            showToast('Erro', result.message || 'Falha ao excluir talhão.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });




    /* ══════════════════════════════════════
       ─── CRUD INSUMOS ───inss
    ══════════════════════════════════════ */
    let insumosPage = 1;
    let insumosFiltros = { categoria: '', estado: '' };

    function carregarInsumos(page = 1) {
      insumosPage = page;
      const params = new URLSearchParams({
        page,
        categoria: insumosFiltros.categoria,
        estado: insumosFiltros.estado
      });

      fetch(`/cooperativa/${cooperativaId}/estoque/historico?${params}`)
        .then(res => res.json())
        .then(data => {
          renderTabelaInsumos(data.data);
          renderPaginacaoInsumos(data);
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar insumos.', 'danger');
          console.error(err);
        });
    }

    function renderTabelaInsumos(insumos) {
      const tbody = document.getElementById('corpoTabelaInsumos');
      if (!insumos || insumos.length === 0) {
        tbody.innerHTML =
          `<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-light);">
      <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Nenhuma movimentação registada.</td></tr>`;
        return;
      }

      tbody.innerHTML = insumos.map(i => `
        <tr>
          <td>${i.insumo_nome || 'N/A'}</td>
          <td>${i.agricultor_nome || '--'}</td>
          <td>${i.data}</td>
          <td><strong>${i.quantidade || 0}</strong></td>
          <td>${i.modalidade || '--'}</td>
          <td><span class="badge-status ${(i.estado || 'Pendente').toLowerCase()}"><span class="dot"></span>${i.estado || 'Pendente'}</span></td>
        </tr>
      `).join('');
    }

    function renderPaginacaoInsumos(data) {
      const info = document.getElementById('infoInsumos');
      const links = document.getElementById('paginacaoLinksInsumos');
      info.textContent = `Mostrando ${data.from || 0} - ${data.to || 0} de ${data.total || 0} registos`;

      if (data.last_page <= 1) { links.innerHTML = ''; return; }

      let html = '';
      html += `<li class="page-item ${data.prev_page_url ? '' : 'disabled'}">
        <a class="page-link" href="#" onclick="carregarInsumos(${data.current_page - 1});return false;">«</a></li>`;
      for (let i = 1; i <= data.last_page; i++) {
        html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
          <a class="page-link" href="#" onclick="carregarInsumos(${i});return false;">${i}</a></li>`;
      }
      html += `<li class="page-item ${data.next_page_url ? '' : 'disabled'}">
        <a class="page-link" href="#" onclick="carregarInsumos(${data.current_page + 1});return false;">»</a></li>`;
      links.innerHTML = html;
    }

    /* Filtros Insumos */
    document.getElementById('btnFiltrarInsumos').addEventListener('click', () => {
      insumosFiltros.categoria = document.getElementById('filtroInsumoCategoria').value;
      insumosFiltros.estado = document.getElementById('filtroInsumoEstado').value;
      carregarInsumos(1);
    });

    document.getElementById('btnLimparFiltrosInsumos').addEventListener('click', () => {
      document.getElementById('filtroInsumoCategoria').value = '';
      document.getElementById('filtroInsumoEstado').value = '';
      insumosFiltros = { categoria: '', estado: '' };
      carregarInsumos(1);
    });





    /* ══════════════════════════════════════
       ─── CRUD PRODUTOS ─── proo
    ══════════════════════════════════════ */
    let produtosPage = 1;
    let produtosFiltros = { nome: '', estado: '' };

    function carregarProdutos(page = 1) {
      produtosPage = page;
      const params = new URLSearchParams({
        page,
        nome: produtosFiltros.nome,
        estado: produtosFiltros.estado
      });

      fetch(`/api/cooperativa/${cooperativaId}/produtos?${params}`)
        .then(res => res.json())
        .then(data => {
          renderTabelaProdutos(data.data);
          renderPaginacaoProdutos(data);
          const navCount = document.querySelector('[data-tab="produtos"] .nav-count');
          if (navCount) navCount.textContent = data.total || 0;
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar produtos.', 'danger');
          console.error(err);
        });
    }

    function renderTabelaProdutos(produtos) {
      const tbody = document.getElementById('corpoTabelaProdutos');
      if (!produtos || produtos.length === 0) {
        tbody.innerHTML =
          `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
      <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Nenhum produto registado.</td></tr>`;
        return;
      }

      tbody.innerHTML = produtos.map(p => `
        <tr>
          <td><i class="bi bi-basket-fill me-1" style="color:var(--primary);"></i>${p.nome || 'N/A'}</td>
          <td>${p.categoria || '--'}</td>
          <td><strong>${p.quantidade || 0}</strong></td>
          <td>${p.unidade || '--'}</td>
          <td>${(p.preco_unitario || 0).toLocaleString('pt-AO')} Kz</td>
          <td><span class="badge-status ${(p.estado || 'disponivel').toLowerCase()}"><span class="dot"></span>${p.estado || 'Disponível'}</span></td>
          <td style="text-align:center;">
            <div style="display:flex;gap:6px;justify-content:center;">
              <button class="action-btn edit" title="Editar" onclick="abrirModalEditarProduto(${p.id})"><i class="bi bi-pencil-fill"></i></button>
              <button class="action-btn delete" title="Excluir" onclick="abrirModalDeleteProduto(${p.id}, '${p.nome}')"><i class="bi bi-trash-fill"></i></button>
            </div>
          </td>
        </tr>
      `).join('');
    }

    function renderPaginacaoProdutos(data) {
      const info = document.getElementById('infoProdutos');
      const links = document.getElementById('paginacaoLinksProdutos');
      info.textContent = `Mostrando ${data.from || 0} - ${data.to || 0} de ${data.total || 0} registos`;

      if (data.last_page <= 1) { links.innerHTML = ''; return; }

      let html = '';
      html += `<li class="page-item ${data.prev_page_url ? '' : 'disabled'}">
        <a class="page-link" href="#" onclick="carregarProdutos(${data.current_page - 1});return false;">«</a></li>`;
      for (let i = 1; i <= data.last_page; i++) {
        html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
          <a class="page-link" href="#" onclick="carregarProdutos(${i});return false;">${i}</a></li>`;
      }
      html += `<li class="page-item ${data.next_page_url ? '' : 'disabled'}">
        <a class="page-link" href="#" onclick="carregarProdutos(${data.current_page + 1});return false;">»</a></li>`;
      links.innerHTML = html;
    }

    /* Filtros Produtos */
    document.getElementById('btnFiltrarProdutos').addEventListener('click', () => {
      produtosFiltros.nome = document.getElementById('filtroProdutoNome').value;
      produtosFiltros.estado = document.getElementById('filtroProdutoEstado').value;
      carregarProdutos(1);
    });

    document.getElementById('btnLimparFiltrosProdutos').addEventListener('click', () => {
      document.getElementById('filtroProdutoNome').value = '';
      document.getElementById('filtroProdutoEstado').value = '';
      produtosFiltros = { nome: '', estado: '' };
      carregarProdutos(1);
    });

    /* Modal Produto - Registrar/Editar */
    const modalProduto = new bootstrap.Modal(document.getElementById('modalNovoProduto'));

    document.getElementById('btnNovoProduto').addEventListener('click', () => {
      document.getElementById('produtoId').value = '';
      document.getElementById('modalProdutoTitle').textContent = 'Registrar Produto';
      document.getElementById('modalProdutoSub').textContent = 'Adicionar novo produto ao estoque';
      document.getElementById('btnProdutoLabel').textContent = 'Salvar';
      document.getElementById('formNovoProduto').reset();
      modalProduto.show();
    });

    function abrirModalEditarProduto(id) {
      fetch(`/api/cooperativa/${cooperativaId}/produtos/${id}`)
        .then(res => res.json())
        .then(data => {
          const p = data.data;
          document.getElementById('produtoId').value = p.id;
          document.getElementById('modalProdutoTitle').textContent = 'Editar Produto';
          document.getElementById('modalProdutoSub').textContent = 'Atualizar dados do produto';
          document.getElementById('btnProdutoLabel').textContent = 'Salvar';
          document.getElementById('produtoNome').value = p.nome || '';
          document.getElementById('produtoCategoria').value = p.categoria || 'Grãos';
          document.getElementById('produtoUnidade').value = p.unidade || '';
          document.getElementById('produtoQuantidade').value = p.quantidade || 0;
          document.getElementById('produtoPreco').value = p.preco_unitario || 0;
          document.getElementById('produtoEstado').value = p.estado || 'disponivel';
          document.getElementById('produtoDescricao').value = p.descricao || '';
          modalProduto.show();
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar dados do produto.', 'danger');
          console.error(err);
        });
    }

    document.getElementById('btnSalvarProduto').addEventListener('click', () => {
      const id = document.getElementById('produtoId').value;
      const data = {
        nome: document.getElementById('produtoNome').value,
        categoria: document.getElementById('produtoCategoria').value,
        unidade: document.getElementById('produtoUnidade').value,
        quantidade: document.getElementById('produtoQuantidade').value,
        preco_unitario: document.getElementById('produtoPreco').value,
        estado: document.getElementById('produtoEstado').value,
        descricao: document.getElementById('produtoDescricao').value
      };

      const url = id ? `/api/cooperativa/${cooperativaId}/produtos/${id}` :
        `/api/cooperativa/${cooperativaId}/produtos`;
      const method = id ? 'PUT' : 'POST';

      fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', id ? 'Produto atualizado com sucesso!' : 'Produto registado com sucesso!');
            modalProduto.hide();
            carregarProdutos(produtosPage);
          } else {
            showToast('Erro', result.message || 'Falha ao salvar produto.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });

    /* Modal Delete Produto */
    const modalDeleteProduto = new bootstrap.Modal(document.getElementById('modalDeleteProduto'));
    let deleteProdutoId = null;
    let deleteProdutoNome = '';

    function abrirModalDeleteProduto(id, nome) {
      deleteProdutoId = id;
      deleteProdutoNome = nome;
      document.getElementById('deleteProdutoNome').textContent = nome;
      document.getElementById('deleteProdutoId').value = id;
      modalDeleteProduto.show();
    }

    document.getElementById('btnConfirmDeleteProduto').addEventListener('click', () => {
      const id = document.getElementById('deleteProdutoId').value;

      fetch(`/api/cooperativa/${cooperativaId}/produtos/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Produto excluído com sucesso!');
            modalDeleteProduto.hide();
            carregarProdutos(produtosPage);
          } else {
            showToast('Erro', result.message || 'Falha ao excluir produto.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });







    /* ══════════════════════════════════════
       ─── CRUD RECEITAS ─── recc
    ══════════════════════════════════════ */
    let receitasPage = 1;
    let receitasFiltros = { nome: '', estado: '' };

    function carregarReceitas(page = 1) {
      receitasPage = page;
      const params = new URLSearchParams({
        page,
        nome: receitasFiltros.nome,
        estado: receitasFiltros.estado
      });

      fetch(`/api/cooperativa/${cooperativaId}/receitas?${params}`)
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
        tbody.innerHTML =
          `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
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
              <button class="action-btn delete" title="Apagar" onclick="abrirModalDeleteReceita(${r.id}, '${r.descricao}')"><i class="bi bi-trash-fill"></i></button>
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

    /* Modal Receita - Registrar/Editar */
    const modalReceita = new bootstrap.Modal(document.getElementById('modalNovaReceita'));

    document.getElementById('btnNovaReceita').addEventListener('click', () => {
      document.getElementById('receitaId').value = '';
      document.getElementById('modalReceitaTitle').textContent = 'Registrar Receita';
      document.getElementById('modalReceitaSub').textContent = 'Entrada financeira da cooperativa';
      document.getElementById('btnReceitaLabel').textContent = 'Registrar';
      fetch(`/api/cooperativa/${cooperativaId}/agricultores/associados`)
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

    function abrirModalEditarReceita(id) {
      fetch(`/api/cooperativa/${cooperativaId}/receitas/${id}`)
        .then(res => res.json())
        .then(data => {
          const r = data.data;
          document.getElementById('receitaId').value = r.id;
          document.getElementById('modalReceitaTitle').textContent = 'Editar Receita';
          document.getElementById('modalReceitaSub').textContent = 'Atualizar dados da receita';
          document.getElementById('btnReceitaLabel').textContent = 'Salvar';
          document.getElementById('receitaDescricao').value = r.descricao || '';
          document.getElementById('receitaOrigem').value = r.origem || 'Comercial';
          document.getElementById('receitaData').value = r.data || '';
          document.getElementById('receitaValor').value = r.valor || '';
          document.getElementById('receitaEstado').value = r.estado || 'Pendente';

          fetch(`/api/cooperativa/${cooperativaId}/agricultores/associados`)
            .then(res => res.json())
            .then(agData => {
              const select = document.getElementById('receitaAgricultor');
              select.innerHTML = '<option value="Cooperativa (Geral)">Cooperativa (Geral)</option>' +
                agData.data.map(a =>
                  `<option value="${a.id}" ${a.id == r.agricultor_id ? 'selected' : ''}>${a.nome}</option>`
                ).join('');
              modalReceita.show();
            });
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar dados da receita.', 'danger');
          console.error(err);
        });
    }

    document.getElementById('btnSalvarReceita').addEventListener('click', () => {
      const id = document.getElementById('receitaId').value;
      const data = {
        descricao: document.getElementById('receitaDescricao').value,
        origem: document.getElementById('receitaOrigem').value,
        agricultor_id: document.getElementById('receitaAgricultor').value,
        data: document.getElementById('receitaData').value,
        valor: document.getElementById('receitaValor').value,
        estado: document.getElementById('receitaEstado').value
      };

      const url = id ? `/api/cooperativa/${cooperativaId}/receitas/${id}` :
        `/api/cooperativa/${cooperativaId}/receitas`;
      const method = id ? 'PUT' : 'POST';

      fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', id ? 'Receita atualizada com sucesso!' : 'Receita registada com sucesso!');
            modalReceita.hide();
            carregarReceitas(receitasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao salvar receita.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });

    /* Modal Delete Receita */
    const modalDeleteReceita = new bootstrap.Modal(document.getElementById('modalDeleteReceita'));
    let deleteReceitaId = null;
    let deleteReceitaNome = '';

    function abrirModalDeleteReceita(id, nome) {
      deleteReceitaId = id;
      deleteReceitaNome = nome;
      document.getElementById('deleteReceitaNome').textContent = nome;
      document.getElementById('deleteReceitaId').value = id;
      modalDeleteReceita.show();
    }

    document.getElementById('btnConfirmDeleteReceita').addEventListener('click', () => {
      const id = document.getElementById('deleteReceitaId').value;

      fetch(`/api/cooperativa/${cooperativaId}/receitas/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Receita excluída com sucesso!');
            modalDeleteReceita.hide();
            carregarReceitas(receitasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao excluir receita.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });








    /* ══════════════════════════════════════
       ─── CRUD VENDAS ─── ven
    ══════════════════════════════════════ */
    let vendasPage = 1;
    let vendasFiltros = { nome: '', estado: '' };

    function carregarVendas(page = 1) {
      vendasPage = page;
      const params = new URLSearchParams({
        page,
        nome: vendasFiltros.nome,
        estado: vendasFiltros.estado
      });

      fetch(`/api/cooperativa/${cooperativaId}/vendas?${params}`)
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
        tbody.innerHTML =
          `<tr><td colspan="8" style="text-align:center;padding:40px;color:var(--text-light);">
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
              <button class="action-btn delete" title="Apagar" onclick="abrirModalDeleteVenda(${v.id}, '${v.produto}')"><i class="bi bi-trash-fill"></i></button>
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

    /* Modal Venda - Registrar/Editar */
    const modalVenda = new bootstrap.Modal(document.getElementById('modalNovaVenda'));

    document.getElementById('btnNovaVenda').addEventListener('click', () => {
      document.getElementById('vendaId').value = '';
      document.getElementById('modalVendaTitle').textContent = 'Registrar Venda';
      document.getElementById('modalVendaSub').textContent = 'Registo de venda de produtos';
      document.getElementById('btnVendaLabel').textContent = 'Registrar';
      fetch(`/api/cooperativa/${cooperativaId}/agricultores/associados`)
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

    function abrirModalEditarVenda(id) {
      fetch(`/api/cooperativa/${cooperativaId}/vendas/${id}`)
        .then(res => res.json())
        .then(data => {
          const v = data.data;
          document.getElementById('vendaId').value = v.id;
          document.getElementById('modalVendaTitle').textContent = 'Editar Venda';
          document.getElementById('modalVendaSub').textContent = 'Atualizar dados da venda';
          document.getElementById('btnVendaLabel').textContent = 'Salvar';
          document.getElementById('vendaProduto').value = v.produto || '';
          document.getElementById('vendaComprador').value = v.comprador || '';
          document.getElementById('vendaData').value = v.data || '';
          document.getElementById('vendaQuantidade').value = v.quantidade || '';
          document.getElementById('vendaValor').value = v.valor || '';
          document.getElementById('vendaEstado').value = v.estado || 'Pendente';

          fetch(`/api/cooperativa/${cooperativaId}/agricultores/associados`)
            .then(res => res.json())
            .then(agData => {
              const select = document.getElementById('vendaAgricultor');
              select.innerHTML = '<option value="">Selecione um agricultor</option>' +
                agData.data.map(a =>
                  `<option value="${a.id}" ${a.id == v.agricultor_id ? 'selected' : ''}>${a.nome}</option>`
                ).join('');
              modalVenda.show();
            });
        })
        .catch(err => {
          showToast('Erro', 'Falha ao carregar dados da venda.', 'danger');
          console.error(err);
        });
    }

    document.getElementById('btnSalvarVenda').addEventListener('click', () => {
      const id = document.getElementById('vendaId').value;
      const data = {
        produto: document.getElementById('vendaProduto').value,
        agricultor_id: document.getElementById('vendaAgricultor').value,
        comprador: document.getElementById('vendaComprador').value,
        data: document.getElementById('vendaData').value,
        quantidade: document.getElementById('vendaQuantidade').value,
        valor: document.getElementById('vendaValor').value,
        estado: document.getElementById('vendaEstado').value
      };

      const url = id ? `/api/cooperativa/${cooperativaId}/vendas/${id}` :
        `/api/cooperativa/${cooperativaId}/vendas`;
      const method = id ? 'PUT' : 'POST';

      fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', id ? 'Venda atualizada com sucesso!' : 'Venda registada com sucesso!');
            modalVenda.hide();
            carregarVendas(vendasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao salvar venda.', 'danger');
          }
        })
        .catch(err => {
          showToast('Erro', 'Erro ao processar requisição.', 'danger');
          console.error(err);
        });
    });

    /* Modal Delete Venda */
    const modalDeleteVenda = new bootstrap.Modal(document.getElementById('modalDeleteVenda'));
    let deleteVendaId = null;
    let deleteVendaNome = '';

    function abrirModalDeleteVenda(id, nome) {
      deleteVendaId = id;
      deleteVendaNome = nome;
      document.getElementById('deleteVendaNome').textContent = nome;
      document.getElementById('deleteVendaId').value = id;
      modalDeleteVenda.show();
    }

    document.getElementById('btnConfirmDeleteVenda').addEventListener('click', () => {
      const id = document.getElementById('deleteVendaId').value;

      fetch(`/api/cooperativa/${cooperativaId}/vendas/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            showToast('Sucesso', 'Venda excluída com sucesso!');
            modalDeleteVenda.hide();
            carregarVendas(vendasPage);
          } else {
            showToast('Erro', result.message || 'Falha ao excluir venda.', 'danger');
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
       ESTATISTICAS
    ══════════════════════════════════════ */

    function carregarEstatisticas() {

      fetch(`/api/cooperativas/${cooperativaId}/estatisticas`)
        .then(response => response.json())
        .then(response => {

          const dados = response.data;

          // document.getElementById('totalTalhoes').textContent =
          //   dados.total_talhoes ?? 0;

          document.getElementById('totalAgricultores').textContent =
            dados.total_agricultores ?? 0;

          // document.getElementById('areaTotal').textContent =
          //   `${dados.area_total ?? 0} ha`;

        })
        .catch(error => {
          console.error('Erro ao carregar estatísticas:', error);
        });
    }
    /* ══════════════════════════════════════
       INICIALIZAÇÃO
    ══════════════════════════════════════ */

    document.addEventListener('DOMContentLoaded', () => {
      // carregarFiltroAgricultoresTalhoes();
      carregarAgricultores(1);
      carregarTalhoes(1);
      carregarInsumos(1);
      carregarProdutos(1);
      carregarReceitas(1);
      carregarVendas(1);
      carregarEstatisticas();
    });
  </script>

</body>

</html>