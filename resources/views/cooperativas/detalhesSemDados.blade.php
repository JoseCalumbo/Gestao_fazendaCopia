<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG – Perfil da Cooperativa</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap"
    rel="stylesheet" />
  <!-- ApexCharts -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
    .action-btn.print:hover .bi,
    .action-btn.delete:hover .bi,
    .action-btn.view:hover .bi,
    .profile-avatar-icon .bi {
      color: inherit;
    }

    .topbar-title .bi,
    .table-card-header .bi,
    .cfg-card-title .bi,
    .modal-section-title .bi {
      color: var(--primary);
    }

    .badge-status .bi,
    .badge-cargo .bi,
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
       PROFILE CARD (cabeçalho do perfil)
    ═══════════════════════════════════════════ */
    .profile-card {
      background: var(--card-bg);
      border-radius: 18px;
      border: 1px solid var(--border);
      padding: 26px 28px;
      margin-bottom: 22px;
      display: flex;
      align-items: center;
      gap: 24px;
      flex-wrap: wrap;
    }

    .profile-avatar-icon {
      width: 86px;
      height: 86px;
      border-radius: 50%;

      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      font-weight: 800;
      flex-shrink: 0;
      overflow: hidden;
      border: 3px solid var(--accent-lt);
    }

    .profile-avatar-icon img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-main {
      flex: 1;
      min-width: 220px;
    }

    .profile-main .p-name {
      font-family: 'Sora', sans-serif;
      font-size: 19px;
      font-weight: 700;
      color: var(--text-dark);
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .profile-main .p-coop {
      font-size: 13px;
      color: var(--text-light);
      margin-top: 3px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .profile-main .p-coop a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
    }

    .profile-meta {
      display: flex;
      gap: 26px;
      flex-wrap: wrap;
      margin-top: 14px;
    }

    .profile-meta-item {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .profile-meta-item i {
      font-size: 15px;
      color: var(--primary);
    }

    .profile-meta-item .pm-label {
      font-size: 10.5px;
      color: var(--text-light);
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    .profile-meta-item .pm-value {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .profile-actions {
      display: flex;
      gap: 10px;
      flex-shrink: 0;
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
       SETTINGS-STYLE LAYOUT — lateral tabs + content
    ═══════════════════════════════════════════ */
    .settings-wrap {
      display: flex;
      gap: 24px;
      align-items: flex-start;
    }

    .settings-nav {
      flex-shrink: 0;
      width: 220px;
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

    /* ── TABELAS DE LISTAGEM ─── */
    .mini-table-wrap {
      overflow-x: auto;
    }

    .mini-table {
      width: 100%;
      border-collapse: collapse;
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

    /* Badges — texto neutro sem fundo/borda (padrão SIAG) */
    .badge-status,
    .badge-cargo {
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
    .badge-status.concluida {
      color: #2E7D32;
    }

    .badge-status.inactivo,
    .badge-status.esgotado {
      color: #C62828;
    }

    .badge-status.pendente,
    .badge-status.baixo {
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
    .badge-status.concluida .dot {
      background: #2E7D32;
    }

    .badge-status.inactivo .dot,
    .badge-status.esgotado .dot {
      background: #C62828;
    }

    .badge-status.pendente .dot,
    .badge-status.baixo .dot {
      background: #F57F17;
    }

    /* Action buttons in table */
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

    /* ═══════════════════════════════════════════
       Animations
    ═══════════════════════════════════════════ */
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

      .profile-card {
        padding: 20px;
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
      <a href="{{ route('dashboard')}}" class="nav-item-link" data-label="Dashboard"><i
          class="bi bi-grid-1x2-fill"></i><span class="nav-label">Dashboard</span></a>
      <a href="{{ route('cooperativas')}}" class="nav-item-link active" data-label="Cooperativa"><i
          class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
      <a href="{{ route('agricultores.index')}}" class="nav-item-link" data-label="Agricultores"><i
          class="bi bi-person-badge-fill"></i><span class="nav-label">Agricultores</span></a>

      <div class="nav-section-title">Agrícola</div>
      <a href="#" class="nav-item-link" data-label="Safras"><i class="bi bi-flower2"></i><span
          class="nav-label">Safras</span></a>
      <a href="#" class="nav-item-link" data-label="Talhões"><i class="bi bi-map-fill"></i><span
          class="nav-label">Talhões</span></a>
      <a href="{{ route('insumos.index')}}" class="nav-item-link" data-label="Insumos"><i
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
      <span class="topbar-title" id="topbarCoopNome">{{ $cooperativa->nome ?? 'Cooperativa Exemplo' }}</span>
      <span class="topbar-subtitle" id="topbarCoopLocal">{{ $cooperativa->municipio ?? 'Viana' }},
        {{ $cooperativa->provincia ?? 'Luanda' }}</span>
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
            <img id="dropdownAvatarLarge"
              src="{{ Auth::check() ? Auth::user()->foto_url : asset('uploads/users/default-user.png') }}"
              alt="Foto-perfil" width="20" class="avatar-md">
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
          <p>Informação completa, agricultores associados e desempenho da cooperativa</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <button class="btn-outline-green" id="btnImprimirPerfil">
            <i class="bi bi-printer-fill"></i> Imprimir Ficha
          </button>
          <button class="btn-green" id="btnEditarCooperativa">
            <i class="bi bi-pencil-fill"></i> Editar Cooperativa
          </button>
        </div>
      </div>

      <!-- ══ PROFILE CARD ══ -->
      <div class="profile-card anim anim-d1">
        <div class="profile-avatar-icon" id="profileAvatar">
          @if($cooperativa->foto)
            <img src="{{ asset('storage/' . $cooperativa->foto) }}" alt="Logo da Cooperativa">
          @else
            <i class="bi bi-building"></i>
          @endif
        </div>
        <div class="profile-main">
          <div class="p-name">
            <span id="profileNome">{{ $cooperativa->nome ?? 'Cooperativa Exemplo' }}</span>
            <span
              class="badge-status {{ $cooperativa->estado == 'activo' ? 'activo' : ($cooperativa->estado == 'pendente' ? 'pendente' : 'inactivo') }}"
              id="profileEstado">
              <span class="dot"></span>{{ ucfirst($cooperativa->estado) }}
            </span>
          </div>
          <div class="p-coop">
            <i class="bi bi-geo-alt" style="font-size:13px;"></i>
            {{ $cooperativa->municipio ?? 'Viana' }}, {{ $cooperativa->provincia ?? 'Luanda' }} -
            {{ $cooperativa->endereco ?? '' }}
          </div>

          <div class="profile-meta">
            <div class="profile-meta-item">
              <i class="bi bi-person-fill"></i>
              <div>
                <div class="pm-label">Total Agricultores</div>
                <div class="pm-value" id="profileTotalSocios">{{ $cooperativa->numero_socios ?? 0 }}</div>
              </div>
            </div>
            <div class="profile-meta-item">
              <i class="bi bi-card-text"></i>
              <div>
                <div class="pm-label">NIF</div>
                <div class="pm-value" id="profileNIF">{{ $cooperativa->nif ?? 'N/A' }}</div>
              </div>
            </div>
            <div class="profile-meta-item">
              <i class="bi bi-telephone-fill"></i>
              <div>
                <div class="pm-label">Telefone</div>
                <div class="pm-value" id="profileTelefone">{{ $cooperativa->telefone ?? 'N/A' }}</div>
              </div>
            </div>
            <div class="profile-meta-item">
              <i class="bi bi-envelope-fill"></i>
              <div>
                <div class="pm-label">Email</div>
                <div class="pm-value" id="profileEmail">{{ $cooperativa->email ?? 'N/A' }}</div>
              </div>
            </div>
            <div class="profile-meta-item">
              <i class="bi bi-globe"></i>
              <div>
                <div class="pm-label">Website</div>
                <div class="pm-value" id="profileWebsite">{{ $cooperativa->website ?? 'N/A' }}</div>
              </div>
            </div>
            <div class="profile-meta-item">
              <i class="bi bi-calendar-check-fill"></i>
              <div>
                <div class="pm-label">Data de Fundação</div>
                <div class="pm-value" id="profileFundacao">{{ $cooperativa->data_fundacao ?? 'N/A' }}</div>
              </div>
            </div>
            <div class="profile-meta-item">
              <i class="bi bi-map-fill"></i>
              <div>
                <div class="pm-label">Extensão Cultivável</div>
                <div class="pm-value" id="profileAreaTotal">{{ $cooperativa->area_total_cultivada ?? 0 }} ha</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Stat Cards - Dados da Cooperativa -->
      <div class="row g-3 mb-4 anim anim-d2">
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-person-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Total Agricultores</div>
              <div class="s-value" id="statSocios">{{ $cooperativa->numero_socios ?? 0 }}</div>
              <span class="stat-badge up"><i class="bi bi-arrow-up"></i> Associados activos</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon amber"><i class="bi bi-box-seam-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Produção Total (kg)</div>
              <div class="s-value" id="statProducao">
                {{ number_format($cooperativa->producao_estimada ?? 0, 0, ',', '.') }}</div>
              <span class="stat-badge up"><i class="bi bi-arrow-up"></i> Safra
                {{ $cooperativa->safra ?? '2024/25' }}</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-cart-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Vendas (Kz)</div>
              <div class="s-value" id="statVendas">{{ number_format($cooperativa->vendas_totais ?? 0, 0, ',', '.') }}
              </div>
              <span class="stat-badge info"><i class="bi bi-info-circle"></i> Total de vendas</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-droplet-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Insumos Distribuídos</div>
              <div class="s-value" id="statInsumos">{{ $cooperativa->insumos_distribuidos ?? 0 }}</div>
              <span class="stat-badge info"><i class="bi bi-box-arrow-in-down"></i> Última distribuição</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Settings-style layout: tabs laterais -->
      <div class="settings-wrap anim anim-d3">

        <!-- ── VERTICAL NAV ── -->
        <nav class="settings-nav">
          <button class="settings-nav-item active" data-tab="agricultores">
            <i class="bi bi-person-fill"></i> Agricultores <span
              class="nav-count">{{ $cooperativa->numero_socios ?? 0 }}</span>
          </button>
          <button class="settings-nav-item" data-tab="colheitas">
            <i class="bi bi-flower2"></i> Colheitas <span class="nav-count">{{ $totalColheitas ?? 0 }}</span>
          </button>
          <button class="settings-nav-item" data-tab="insumos">
            <i class="bi bi-box-seam-fill"></i> Insumos <span class="nav-count">{{ $totalInsumos ?? 0 }}</span>
          </button>
          <button class="settings-nav-item" data-tab="produtos">
            <i class="bi bi-basket-fill"></i> Produtos <span class="nav-count">{{ $totalProdutos ?? 0 }}</span>
          </button>
          <button class="settings-nav-item" data-tab="talhoes">
            <i class="bi bi-map-fill"></i> Talhões <span class="nav-count">{{ $totalTalhoes ?? 0 }}</span>
          </button>
          <button class="settings-nav-item" data-tab="receitas">
            <i class="bi bi-cash-coin"></i> Receitas <span class="nav-count">{{ $totalReceitas ?? 0 }}</span>
          </button>
          <button class="settings-nav-item" data-tab="contas-receber">
            <i class="bi bi-arrow-up-circle-fill"></i> Contas a Receber <span
              class="nav-count">{{ $totalContasReceber ?? 0 }}</span>
          </button>
          <button class="settings-nav-item" data-tab="contas-pagar">
            <i class="bi bi-arrow-down-circle-fill"></i> Contas a Pagar <span
              class="nav-count">{{ $totalContasPagar ?? 0 }}</span>
          </button>
        </nav>

        <!-- ── CONTENT PANELS ── -->
        <div class="settings-content">

          <!-- ════════════════════════════
             TAB 1 — AGRICULTORES ASSOCIADOS
        ════════════════════════════ -->
          <div class="settings-panel active" id="tab-agricultores">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-person-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Agricultores Associados</div>
                    <div class="cfg-card-sub">Lista de todos os agricultores membros da cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoAgricultor">
                  <i class="bi bi-plus-lg"></i> Adicionar Agricultor
                </button>
              </div>
              <div class="mini-table-wrap">
                <table class="mini-table">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>BI</th>
                      <th>Contacto</th>
                      <th>Talhões</th>
                      <th>Produção (kg)</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($agricultores ?? [] as $agricultor)
                      <tr>
                        <td><i class="bi bi-person-fill me-1" style="color:var(--primary);"></i>
                          {{ $agricultor->nome_completo }}</td>
                        <td>{{ $agricultor->bilhete }}</td>
                        <td>{{ $agricultor->telefone_principal }}</td>
                        <td>{{ $agricultor->numero_talhoes ?? 0 }}</td>
                        <td><strong>{{ number_format($agricultor->producao_total ?? 0, 0, ',', '.') }}</strong></td>
                        <td>
                          <span class="badge-status {{ $agricultor->estado == 'activo' ? 'activo' : 'inactivo' }}">
                            <span class="dot"></span>{{ ucfirst($agricultor->estado) }}
                          </span>
                        </td>
                        <td style="text-align:center;">
                          <div style="display:flex;gap:6px;justify-content:center;">
                            <a href="{{ route('agricultores.show', $agricultor->id) }}" class="action-btn view"
                              title="Ver Perfil"><i class="bi bi-eye-fill"></i></a>
                            <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                            <button class="action-btn delete" title="Remover"><i class="bi bi-trash-fill"></i></button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center py-4">
                          <div class="mini-empty">
                            <i class="bi bi-person-x-fill"></i>
                            <p>Nenhum agricultor associado a esta cooperativa.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /TAB AGRICULTORES -->

          <!-- ════════════════════════════
             TAB 2 — COLHEITAS
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-colheitas">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-flower2"></i></div>
                  <div>
                    <div class="cfg-card-title">Colheitas da Cooperativa</div>
                    <div class="cfg-card-sub">Registo de colheitas de todos os agricultores associados</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaColheita">
                  <i class="bi bi-plus-lg"></i> Nova Colheita
                </button>
              </div>
              <div class="mini-table-wrap">
                <table class="mini-table">
                  <thead>
                    <tr>
                      <th>Agricultor</th>
                      <th>Cultura</th>
                      <th>Talhão</th>
                      <th>Data</th>
                      <th>Quantidade</th>
                      <th>Qualidade</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($colheitas ?? [] as $colheita)
                      <tr>
                        <td><i class="bi bi-person-fill me-1" style="color:var(--primary);"></i>
                          {{ $colheita->agricultor->nome_completo ?? 'N/A' }}</td>
                        <td>{{ $colheita->cultura }}</td>
                        <td>{{ $colheita->talhao }}</td>
                        <td>{{ $colheita->data_colheita }}</td>
                        <td><strong>{{ number_format($colheita->quantidade, 0, ',', '.') }} kg</strong></td>
                        <td><span class="badge-status {{ $colheita->qualidade == 'Boa' ? 'activo' : 'pendente' }}"><span
                              class="dot"></span>{{ $colheita->qualidade }}</span></td>
                        <td style="text-align:center;">
                          <div style="display:flex;gap:6px;justify-content:center;">
                            <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                            <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center py-4">
                          <div class="mini-empty">
                            <i class="bi bi-flower2"></i>
                            <p>Nenhuma colheita registada.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /TAB COLHEITAS -->

          <!-- ════════════════════════════
             TAB 3 — INSUMOS
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-insumos">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon amber"><i class="bi bi-box-seam-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Insumos Atribuídos</div>
                    <div class="cfg-card-sub"> Histórico completo de entradas, saídas e distribuição de insumos da cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoInsumo">
                  <i class="bi bi-plus-lg"></i> Atribuir Insumo
                </button>
              </div>
              <div class="mini-table-wrap">

                <table class="mini-table">
                  <thead>
                    <tr>
                      <th>Insumo</th>
                      <th>Agricultor</th>
                      <th>Categoria</th>
                      <th>Data</th>
                      <th>Quantidade</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($insumos ?? [] as $insumo)
                      <tr>
                        <td><i class="bi bi-seedling me-1" style="color:var(--primary);"></i> {{ $insumo->nome }}</td>
                        <td>{{ $insumo->agricultor->nome_completo ?? 'N/A' }}</td>
                        <td>{{ $insumo->categoria }}</td>
                        <td>{{ $insumo->data_entrada }}</td>
                        <td><strong>{{ $insumo->quantidade }}</strong></td>
                        <td>
                          <span
                            class="badge-status {{ $insumo->estado == 'disponivel' ? 'disponivel' : ($insumo->estado == 'baixo' ? 'baixo' : 'esgotado') }}">
                            <span class="dot"></span>{{ ucfirst($insumo->estado) }}
                          </span>
                        </td>
                        <td style="text-align:center;">
                          <div style="display:flex;gap:6px;justify-content:center;">
                            <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                            <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center py-4">
                          <div class="mini-empty">
                            <i class="bi bi-box-seam-fill"></i>
                            <p>Nenhum insumo registado.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>

              </div>
            </div>
          </div>
          <!-- /TAB INSUMOS -->

          <!-- ════════════════════════════
             TAB 4 — PRODUTOS (ESTOQUE)
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-produtos">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon purple"><i class="bi bi-basket-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Produtos em Estoque</div>
                    <div class="cfg-card-sub">Produção armazenada de todos os agricultores da cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoProduto">
                  <i class="bi bi-plus-lg"></i> Novo Registo
                </button>
              </div>
              <div class="mini-table-wrap">
                <table class="mini-table">
                  <thead>
                    <tr>
                      <th>Produto</th>
                      <th>Agricultor</th>
                      <th>Quantidade</th>
                      <th>Preço Unitário (Kz)</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($produtos ?? [] as $produto)
                      <tr>
                        <td><i class="bi bi-basket-fill me-1" style="color:var(--primary);"></i> {{ $produto->nome }}</td>
                        <td>{{ $produto->agricultor->nome_completo ?? 'N/A' }}</td>
                        <td><strong>{{ $produto->quantidade }} {{ $produto->unidade ?? '' }}</strong></td>
                        <td>{{ number_format($produto->preco_unitario, 0, ',', '.') }}</td>
                        <td>
                          <span
                            class="badge-status {{ $produto->estado == 'disponivel' ? 'disponivel' : ($produto->estado == 'baixo' ? 'baixo' : 'esgotado') }}">
                            <span class="dot"></span>{{ ucfirst($produto->estado) }}
                          </span>
                        </td>
                        <td style="text-align:center;">
                          <div style="display:flex;gap:6px;justify-content:center;">
                            <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                            <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center py-4">
                          <div class="mini-empty">
                            <i class="bi bi-basket-fill"></i>
                            <p>Nenhum produto em stock.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /TAB PRODUTOS -->

          <!-- ════════════════════════════
             TAB 5 — TALHÕES
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-talhoes">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-map-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Talhões dos Agricultores</div>
                    <div class="cfg-card-sub">Parcelas de terra cultivadas pelos agricultores da cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoTalhao">
                  <i class="bi bi-plus-lg"></i> Novo Talhão
                </button>
              </div>
              <div class="mini-table-wrap">
                <table class="mini-table">
                  <thead>
                    <tr>
                      <th>Designação</th>
                      <th>Agricultor</th>
                      <th>Área (ha)</th>
                      <th>Cultura</th>
                      <th>Localização</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($talhoes ?? [] as $talhao)
                      <tr>
                        <td><i class="bi bi-map-fill me-1" style="color:var(--primary);"></i> {{ $talhao->designacao }}
                        </td>
                        <td>{{ $talhao->agricultor->nome_completo ?? 'N/A' }}</td>
                        <td><strong>{{ $talhao->area }} ha</strong></td>
                        <td>{{ $talhao->cultura_actual ?? 'N/A' }}</td>
                        <td>{{ $talhao->localizacao }}</td>
                        <td>
                          <span class="badge-status {{ $talhao->estado == 'em_cultivo' ? 'activo' : 'pendente' }}">
                            <span class="dot"></span>{{ ucfirst($talhao->estado) }}
                          </span>
                        </td>
                        <td style="text-align:center;">
                          <div style="display:flex;gap:6px;justify-content:center;">
                            <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                            <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center py-4">
                          <div class="mini-empty">
                            <i class="bi bi-map-fill"></i>
                            <p>Nenhum talhão registado.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /TAB TALHÕES -->

          <!-- ════════════════════════════
             TAB 6 — RECEITAS
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-receitas">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon blue"><i class="bi bi-cash-coin"></i></div>
                  <div>
                    <div class="cfg-card-title">Receitas Financeiras</div>
                    <div class="cfg-card-sub">Valores recebidos pelos agricultores da cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaReceita">
                  <i class="bi bi-plus-lg"></i> Nova Receita
                </button>
              </div>
              <div class="mini-table-wrap">
                <table class="mini-table">
                  <thead>
                    <tr>
                      <th>Agricultor</th>
                      <th>Descrição</th>
                      <th>Origem</th>
                      <th>Data</th>
                      <th>Valor (Kz)</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($receitas ?? [] as $receita)
                      <tr>
                        <td><i class="bi bi-person-fill me-1" style="color:var(--primary);"></i>
                          {{ $receita->agricultor->nome_completo ?? 'N/A' }}</td>
                        <td>{{ $receita->descricao }}</td>
                        <td>{{ $receita->origem }}</td>
                        <td>{{ $receita->data }}</td>
                        <td><strong>{{ number_format($receita->valor, 0, ',', '.') }}</strong></td>
                        <td>
                          <span class="badge-status {{ $receita->estado == 'pago' ? 'pago' : 'pendente' }}">
                            <span class="dot"></span>{{ ucfirst($receita->estado) }}
                          </span>
                        </td>
                        <td style="text-align:center;">
                          <div style="display:flex;gap:6px;justify-content:center;">
                            <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                            <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center py-4">
                          <div class="mini-empty">
                            <i class="bi bi-cash-coin"></i>
                            <p>Nenhuma receita registada.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /TAB RECEITAS -->

          <!-- ════════════════════════════
             TAB 7 — CONTAS A RECEBER
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-contas-receber">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon blue"><i class="bi bi-arrow-up-circle-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Contas a Receber</div>
                    <div class="cfg-card-sub">Valores a receber pelos agricultores da cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaContaReceber">
                  <i class="bi bi-plus-lg"></i> Nova Conta a Receber
                </button>
              </div>
              <div class="mini-table-wrap">
                <table class="mini-table">
                  <thead>
                    <tr>
                      <th>Agricultor</th>
                      <th>Descrição</th>
                      <th>Data Vencimento</th>
                      <th>Valor (Kz)</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contasReceber ?? [] as $conta)
                      <tr>
                        <td><i class="bi bi-person-fill me-1" style="color:var(--primary);"></i>
                          {{ $conta->agricultor->nome_completo ?? 'N/A' }}</td>
                        <td>{{ $conta->descricao }}</td>
                        <td>{{ $conta->data_vencimento }}</td>
                        <td><strong>{{ number_format($conta->valor, 0, ',', '.') }}</strong></td>
                        <td>
                          <span
                            class="badge-status {{ $conta->estado == 'pago' ? 'pago' : ($conta->estado == 'vencido' ? 'esgotado' : 'pendente') }}">
                            <span class="dot"></span>{{ ucfirst($conta->estado) }}
                          </span>
                        </td>
                        <td style="text-align:center;">
                          <div style="display:flex;gap:6px;justify-content:center;">
                            <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                            <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center py-4">
                          <div class="mini-empty">
                            <i class="bi bi-arrow-up-circle-fill"></i>
                            <p>Nenhuma conta a receber registada.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /TAB CONTAS A RECEBER -->

          <!-- ════════════════════════════
             TAB 8 — CONTAS A PAGAR
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-contas-pagar">
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon red"><i class="bi bi-arrow-down-circle-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Contas a Pagar</div>
                    <div class="cfg-card-sub">Obrigações financeiras da cooperativa</div>
                  </div>
                </div>
                <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaContaPagar">
                  <i class="bi bi-plus-lg"></i> Nova Conta a Pagar
                </button>
              </div>
              <div class="mini-table-wrap">
                <table class="mini-table">
                  <thead>
                    <tr>
                      <th>Fornecedor</th>
                      <th>Descrição</th>
                      <th>Data Vencimento</th>
                      <th>Valor (Kz)</th>
                      <th>Estado</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contasPagar ?? [] as $conta)
                      <tr>
                        <td><i class="bi bi-building me-1" style="color:var(--primary);"></i> {{ $conta->fornecedor }}
                        </td>
                        <td>{{ $conta->descricao }}</td>
                        <td>{{ $conta->data_vencimento }}</td>
                        <td><strong>{{ number_format($conta->valor, 0, ',', '.') }}</strong></td>
                        <td>
                          <span
                            class="badge-status {{ $conta->estado == 'pago' ? 'pago' : ($conta->estado == 'vencido' ? 'esgotado' : 'pendente') }}">
                            <span class="dot"></span>{{ ucfirst($conta->estado) }}
                          </span>
                        </td>
                        <td style="text-align:center;">
                          <div style="display:flex;gap:6px;justify-content:center;">
                            <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                            <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center py-4">
                          <div class="mini-empty">
                            <i class="bi bi-arrow-down-circle-fill"></i>
                            <p>Nenhuma conta a pagar registada.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /TAB CONTAS A PAGAR -->

        </div>
        <!-- /settings-content -->

      </div>
      <!-- /settings-wrap -->

    </div><!-- /content-inner -->
  </main>

  <!-- Toast -->
  <div class="save-toast" id="saveToast"
    style="position:fixed;bottom:28px;right:28px;z-index:9999;background:#fff;border:1px solid var(--border);border-radius:14px;padding:14px 20px;box-shadow:0 12px 36px rgba(0,0,0,.12);display:flex;align-items:center;gap:12px;transform:translateY(80px);opacity:0;transition:all .35s cubic-bezier(.34,1.56,.64,1);pointer-events:none;">
    <div class="toast-icon success" id="toastIcon"
      style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;background:#E8F5E9;color:#2E7D32;">
      <i class="bi bi-check-lg" id="toastIconI"></i>
    </div>
    <div class="toast-text">
      <div class="t-title" id="toastTitle" style="font-size:13.5px;font-weight:600;color:var(--text-dark);">Operação
        concluída</div>
      <div class="t-sub" id="toastSub" style="font-size:12px;color:var(--text-light);">Acção realizada com sucesso.
      </div>
    </div>
  </div>

  <style>
    .save-toast.show {
      transform: translateY(0);
      opacity: 1;
      pointer-events: all;
    }

    .save-toast .toast-icon.danger {
      background: #FFEBEE;
      color: #C62828;
    }
  </style>

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

    themeToggle.addEventListener('click', function (e) {
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
       TABS LATERAIS
    ══════════════════════════════════════ */
    document.querySelectorAll('.settings-nav-item').forEach(btn => {
      btn.addEventListener('click', () => {
        const tab = btn.dataset.tab;

        document.querySelectorAll('.settings-nav-item').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.settings-panel').forEach(p => {
          p.classList.remove('active');
          p.querySelectorAll('.anim').forEach(el => {
            el.style.animation = 'none';
            el.offsetHeight; // reflow
            el.style.animation = '';
          });
        });
        const panel = document.getElementById('tab-' + tab);
        if (panel) panel.classList.add('active');
      });
    });

    /* ══════════════════════════════════════
       BOTÕES DE TOPO (placeholders)
    ══════════════════════════════════════ */
    document.getElementById('btnEditarCooperativa').addEventListener('click', () => {
      showToast('Editar Cooperativa', 'Abra a lista de Cooperativas para editar os dados completos.');
    });
    document.getElementById('btnImprimirPerfil').addEventListener('click', () => {
      showToast('Ficha da Cooperativa', 'Geração de PDF será implementada na próxima sprint.');
    });

    ['btnNovoAgricultor', 'btnNovaColheita', 'btnNovoInsumo', 'btnNovoProduto', 'btnNovoTalhao', 'btnNovaReceita', 'btnNovaContaReceber', 'btnNovaContaPagar'].forEach(id => {
      const el = document.getElementById(id);
      if (el) {
        el.addEventListener('click', () => {
          showToast('Funcionalidade em desenvolvimento', 'Este módulo será implementado na próxima sprint.');
        });
      }
    });
  </script>

</body>

</html>