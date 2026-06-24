<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG – Configurações</title>

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

    /* Tooltips no modo icons-only */
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

    /* Dropdown topbar */
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
    }

    .btn-green:hover {
      background: var(--accent);
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
    }

    .btn-outline-green:hover {
      background: var(--accent-lt);
    }

    .btn-danger-outline {
      background: transparent;
      color: var(--danger);
      border: 1.5px solid #FFCDD2;
      border-radius: 10px;
      padding: 8px 16px;
      font-size: 13.5px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      transition: background .2s;
    }

    .btn-danger-outline:hover {
      background: #FFEBEE;
    }

    /* ═══════════════════════════════════════════
       SETTINGS LAYOUT — lateral tabs + content
    ═══════════════════════════════════════════ */
    .settings-wrap {
      display: flex;
      gap: 24px;
      align-items: flex-start;
    }

    /* ── VERTICAL TABS NAV ─── */
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

    .settings-nav-divider {
      height: 1px;
      background: var(--border);
      margin: 8px 0;
    }

    /* ── CONTENT PANELS ─── */
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

    /* ── FORM ELEMENTS ─── */
    .cfg-label {
      display: block;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--text-mid);
      margin-bottom: 6px;
      letter-spacing: .2px;
    }

    .cfg-input {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 11px 14px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      transition: border-color .2s, box-shadow .2s;
      font-family: 'DM Sans', sans-serif;
      outline: none;
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
      padding: 11px 14px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      appearance: none;
      cursor: pointer;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA894' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 14px center;
      padding-right: 36px;
      transition: border-color .2s;
      outline: none;
    }

    .cfg-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
    }

    .cfg-textarea {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 11px 14px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      resize: vertical;
      min-height: 90px;
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
      margin-top: 5px;
    }

    /* ── TOGGLE SWITCH ─── */
    .cfg-toggle-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 0;
      border-bottom: 1px solid var(--border);
    }

    .cfg-toggle-row:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }

    .cfg-toggle-row:first-child {
      padding-top: 0;
    }

    .cfg-toggle-info .t-title {
      font-size: 13.5px;
      font-weight: 500;
      color: var(--text-dark);
      margin-bottom: 2px;
    }

    .cfg-toggle-info .t-desc {
      font-size: 12px;
      color: var(--text-light);
    }

    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 42px;
      height: 24px;
      flex-shrink: 0;
    }

    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle-slider {
      position: absolute;
      cursor: pointer;
      inset: 0;
      background: #D5D9D6;
      border-radius: 24px;
      transition: background .25s;
    }

    .toggle-slider::before {
      content: '';
      position: absolute;
      width: 18px;
      height: 18px;
      background: #fff;
      border-radius: 50%;
      left: 3px;
      bottom: 3px;
      transition: transform .25s;
      box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
    }

    .toggle-switch input:checked+.toggle-slider {
      background: var(--primary);
    }

    .toggle-switch input:checked+.toggle-slider::before {
      transform: translateX(18px);
    }

    /* ── COLOR PICKER ─── */
    .color-options {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .color-swatch {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      cursor: pointer;
      border: 3px solid transparent;
      transition: transform .15s, border-color .15s;
      position: relative;
    }

    .color-swatch:hover {
      transform: scale(1.12);
    }

    .color-swatch.selected {
      border-color: var(--text-dark);
    }

    .color-swatch.selected::after {
      content: '✓';
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 13px;
      font-weight: 700;
    }

    /* ── BADGE ─── */
    .badge-role {
      font-size: 12px;
      font-weight: 500;
      padding: 0;
    }

    .badge-role.admin {
      background: none;
      color: var(--text-mid);
    }

    .badge-role.tecnico {
      background: none;
      color: var(--text-mid);
    }

    .badge-role.gestor {
      background: none;
      color: var(--text-mid);
    }

    .badge-role.inactivo {
      background: none;
      color: var(--text-mid);
    }

    .badge-status {
      font-size: 12px;
      font-weight: 500;
      padding: 0;
    }

    .badge-status.activo {
      background: none;
      color: var(--text-mid);
    }

    .badge-status.inactivo {
      background: none;
      color: var(--text-mid);
    }

    .badge-status.pendente {
      background: none;
      color: var(--text-mid);
    }

    /* ── USERS TABLE ─── */
    .users-table {
      width: 100%;
      border-collapse: collapse;
    }

    .users-table th {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .8px;
      color: var(--text-light);
      padding: 12px 16px;
      background: #FAFBFA;
      border-bottom: 1px solid var(--border);
      text-align: left;
    }

    .users-table td {
      font-size: 13.5px;
      color: var(--text-dark);
      padding: 13px 16px;
      border-bottom: 1px solid var(--border);
      vertical-align: middle;
    }

    .users-table tr:last-child td {
      border-bottom: none;
    }

    .users-table tr:hover td {
      background: #F8FBF8;
    }

    .user-avatar-sm {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #aaaaaa27;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
      margin-right: 8px;
    }

    .user-cell {
      display: flex;
      align-items: center;
    }

    /* ── PERMISSIONS GRID ─── */
    .perm-table {
      width: 100%;
      border-collapse: collapse;
    }

    .perm-table th {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .8px;
      color: var(--text-light);
      padding: 12px 16px;
      background: #FAFBFA;
      border-bottom: 1px solid var(--border);
      text-align: center;
    }

    .perm-table th:first-child {
      text-align: left;
    }

    .perm-table td {
      font-size: 13px;
      color: var(--text-dark);
      padding: 12px 16px;
      border-bottom: 1px solid var(--border);
      text-align: center;
      vertical-align: middle;
    }

    .perm-table td:first-child {
      text-align: left;
      font-weight: 500;
    }

    .perm-table tr:last-child td {
      border-bottom: none;
    }

    .perm-table tr:hover td {
      background: #F8FBF8;
    }

    .perm-check {
      width: 18px;
      height: 18px;
      accent-color: var(--primary);
      cursor: pointer;
    }

    .perm-role-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 4px;
    }

    .perm-role-badge {
      font-size: 10px;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 30px;
    }

    /* ── SECURITY ─── */
    .security-log-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 12px 0;
      border-bottom: 1px solid var(--border);
    }

    .security-log-item:last-child {
      border-bottom: none;
    }

    .security-log-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }

    .security-log-icon.success {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .security-log-icon.warning {
      background: #FFF8E1;
      color: #F57F17;
    }

    .security-log-icon.danger {
      background: #FFEBEE;
      color: #C62828;
    }

    .security-log-info .sl-title {
      font-size: 13.5px;
      font-weight: 500;
      color: var(--text-dark);
    }

    .security-log-info .sl-meta {
      font-size: 12px;
      color: var(--text-light);
      margin-top: 2px;
    }

    .security-log-time {
      margin-left: auto;
      font-size: 11.5px;
      color: var(--text-light);
      white-space: nowrap;
    }

    /* ── APARÊNCIA ─── */
    .theme-option {
      border: 2px solid var(--border);
      border-radius: 14px;
      padding: 14px;
      cursor: pointer;
      transition: border-color .2s, box-shadow .2s;
      text-align: center;
      position: relative;
    }

    .theme-option:hover {
      border-color: var(--primary);
    }

    .theme-option.selected {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .15);
    }

    .theme-option.selected::after {
      content: '✓';
      position: absolute;
      top: 8px;
      right: 10px;
      background: var(--primary);
      color: #fff;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 700;
    }

    .theme-preview {
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 10px;
      aspect-ratio: 16/9;
      position: relative;
    }

    .theme-label {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-mid);
    }

    .font-option {
      border: 2px solid var(--border);
      border-radius: 12px;
      padding: 12px 16px;
      cursor: pointer;
      transition: border-color .2s;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .font-option:hover {
      border-color: var(--primary);
    }

    .font-option.selected {
      border-color: var(--primary);
      background: var(--accent-lt);
    }

    .font-option-sample {
      font-size: 18px;
      color: var(--text-mid);
    }

    .font-option-name {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-dark);
    }

    .font-option-desc {
      font-size: 11px;
      color: var(--text-light);
    }

    /* ── RANGE SLIDER ─── */
    .cfg-range {
      width: 100%;
      accent-color: var(--primary);
      cursor: pointer;
      height: 6px;
    }

    .range-labels {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      color: var(--text-light);
      margin-top: 4px;
    }

    /* ── EMPRESA LOGO UPLOAD ─── */
    .logo-upload-zone {
      border: 2px dashed var(--border);
      border-radius: 14px;
      padding: 28px;
      text-align: center;
      cursor: pointer;
      transition: border-color .2s, background .2s;
    }

    .logo-upload-zone:hover {
      border-color: var(--primary);
      background: var(--accent-lt);
    }

    .logo-upload-icon {
      font-size: 32px;
      color: var(--text-light);
      margin-bottom: 8px;
    }

    .logo-upload-text {
      font-size: 13.5px;
      color: var(--text-mid);
      font-weight: 500;
    }

    .logo-upload-hint {
      font-size: 11.5px;
      color: var(--text-light);
      margin-top: 4px;
    }

    /* ── TOAST / SAVE FEEDBACK ─── */
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
      background: #E8F5E9;
      color: #2E7D32;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
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

    /* ── MODAL UTILIZADOR ─── */
    .modal-user {
      max-width: 780px;
    }

    .modal-user .modal-content {
      height: 620px;
      display: flex;
      flex-direction: column;
      border: none;
      border-radius: 18px;
      box-shadow: 0 24px 64px rgba(0, 0, 0, .15);
      overflow: hidden;
    }

    .modal-user .modal-body {
      flex: 1;
      overflow: hidden;
      padding: 0;
      background: var(--page-bg);
    }

    /* O modal-body faz o scroll — o panel apenas ocupa o espaço */
    .modal-user .modal-body {
      flex: 1;
      overflow-y: auto;
      padding: 0;
      background: var(--page-bg);
    }

    .modal-user .modal-body::-webkit-scrollbar {
      width: 4px;
    }

    .modal-user .modal-body::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, .12);
      border-radius: 4px;
    }

    .modal-user-tab-panel {
      display: none;
      padding: 22px;
    }

    .modal-user-tab-panel.active {
      display: block;
    }

    .modal-user .modal-header {
      padding: 11px 20px;
      border-bottom: 1px solid var(--border);
      background: linear-gradient(135deg, var(--sidebar-bg) 0%, var(--primary) 100%);
      flex-shrink: 0;
    }

    .modal-user .modal-title {
      font-family: 'Sora', sans-serif;
      font-size: 16px;
      font-weight: 700;
      color: #fff;
    }

    .modal-user .modal-header .btn-close {
      filter: brightness(0) invert(1);
      opacity: .8;
    }

    .modal-user .modal-header .btn-close:hover {
      opacity: 1;
    }

    .modal-user-header-icon {
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

    .modal-user .modal-footer {
      padding: 14px 20px;
      border-top: 1px solid var(--border);
      background: #fff;
      flex-shrink: 0;
    }

    /* Tabs dentro do modal */
    .modal-user-tabs {
      display: flex;
      gap: 0;
      border-bottom: 2px solid var(--border);
      background: var(--page-bg);
      padding: 0 24px;
      overflow-x: auto;
      flex-shrink: 0;
    }

    .modal-user-tabs::-webkit-scrollbar {
      height: 0;
    }

    .modal-user-tab-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 14px 18px;
      font-size: 13px;
      font-weight: 500;
      color: var(--text-mid);
      background: none;
      border: none;
      border-bottom: 2px solid transparent;
      margin-bottom: -2px;
      cursor: pointer;
      transition: color .15s, border-color .15s;
      white-space: nowrap;
    }

    .modal-user-tab-btn i {
      color: var(--text-light);
      transition: color .15s;
      font-size: 15px;
    }

    .modal-user-tab-btn:hover {
      color: var(--primary);
    }

    .modal-user-tab-btn:hover i {
      color: var(--primary);
    }

    .modal-user-tab-btn.active {
      color: var(--primary);
      font-weight: 600;
      border-bottom-color: var(--primary);
    }

    .modal-user-tab-btn.active i {
      color: var(--primary);
    }

    /* Cards dentro do modal */
    .mf-card {
      background: var(--card-bg);
      border-radius: 14px;
      border: 1px solid var(--border);
      padding: 20px 22px;
      margin-bottom: 16px;
    }

    .mf-section-title {
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

    .mf-section-title i {
      font-size: 13px;
      color: var(--primary);
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
    }

    .foto-upload-zone:hover {
      border-color: var(--primary);
      background: var(--accent-lt);
    }

    .foto-upload-zone i {
      font-size: 24px;
      color: var(--text-light);
    }

    /* Password strength */
    .pwd-strength-bar {
      height: 4px;
      border-radius: 4px;
      background: var(--border);
      margin-top: 6px;
      overflow: hidden;
    }

    .pwd-strength-fill {
      height: 100%;
      border-radius: 4px;
      width: 0%;
      transition: width .3s, background .3s;
    }

    .pwd-strength-label {
      font-size: 11px;
      color: var(--text-light);
      margin-top: 4px;
    }

    /* ── ANIMATIONS ─── */
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

    /* ── DARK MODE (herança do sistema) ─── */
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

    body.dark-mode .cfg-input,
    body.dark-mode .cfg-select,
    body.dark-mode .cfg-textarea {
      background: #172518;
      color: #e8f0e9;
      border-color: rgba(255, 255, 255, .1);
    }

    body.dark-mode .users-table th,
    body.dark-mode .perm-table th {
      background: #172518;
    }

    body.dark-mode .users-table tr:hover td,
    body.dark-mode .perm-table tr:hover td {
      background: #172518;
    }

    /* ── RESPONSIVE ─── */
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

      .settings-nav-divider {
        display: none;
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
          <g fill="#fff" stroke="#fff" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round">
            <circle cx="118" cy="188" r="48" fill="none" stroke-width="6" />
            <circle cx="118" cy="188" r="35" fill="none" stroke-width="4.5" />
            <circle cx="118" cy="188" r="16" fill="#fff" />
            <path
              d="M118 135L118 144M118 232L118 241M65 188L74 188M162 188L171 188M81 151L88 157M155 219L162 225M81 225L88 219M155 151L162 157"
              stroke-width="6" />
            <path d="M68 185C68 140,108 120,160 128C171 132,174 144,174 151" fill="none" stroke-width="6" />
            <circle cx="231" cy="204" r="26" fill="none" stroke-width="5" />
            <circle cx="231" cy="204" r="10" fill="#fff" />
            <path d="M117 125L117 105C117 102,120 99,125 99L176 99C181 99,184 102,185 107L202 157L176 157" fill="none"
              stroke-width="6" />
            <path d="M144 99L144 128L187 128" fill="none" stroke-width="4" />
            <path d="M174 151L246 156C252 156,254 159,254 165L254 197L202 197Z" fill="#fff" />
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
      <a href="/dashboard" class="nav-item-link" data-label="Dashboard"><i class="bi bi-grid-1x2-fill"></i><span
          class="nav-label">Dashboard</span></a>
      <a href="{{route('cooperativas')}}" class="nav-item-link" data-label="Cooperativa"><i
          class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
      <a href="{{route('agricultores.index')}}" class="nav-item-link" data-label="Agricultores"><i
          class="bi bi-people-fill"></i><span class="nav-label">Agricultores</span></a>

      <div class="nav-section-title">Agrícola</div>
      <a href="{{route('safras.painel')}}" class="nav-item-link" data-label="Safras"><i class="bi bi-flower2"></i><span
          class="nav-label">Safras</span></a>
      <a href="{{route('talhoes.index')}}" class="nav-item-link" data-label="Talhões"><i class="bi bi-map-fill"></i><span
          class="nav-label">Talhões</span></a>
      <a href="#" class="nav-item-link" data-label="Insumos"><i class="bi bi-box-seam-fill"></i><span
          class="nav-label">Insumos</span></a>

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
      <a href="#" class="nav-item-link active" data-label="Configurações"><i class="bi bi-gear-fill"></i><span
          class="nav-label">Configurações</span></a>
    </div>

    <div class="sidebar-user">
      <div class="avatar"><i class="bi bi-person-fill"></i></div>
      <div class="user-info">
        <div class="u-name">Admin SIAG</div>
        <div class="u-role">Gestor · Viana</div>
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
    <span class="topbar-title">Configurações</span>
    <nav aria-label="breadcrumb" class="d-none d-md-flex ms-3">
      <ol class="breadcrumb mb-0" style="font-size:12.5px;">
        <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">SIAG</a></li>
        <li class="breadcrumb-item active" style="color:var(--text-light);">Configurações</li>
      </ol>
    </nav>
    <div class="topbar-right">
      <span class="badge rounded-pill d-none d-md-inline-flex align-items-center gap-1"
        style="background:var(--accent-lt);color:var(--primary);font-size:12px;padding:7px 13px;font-weight:600;">
        <i class="bi bi-calendar3"></i> Safra 2024/25
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
          <h1>Configurações do Sistema</h1>
          <p>Gerencie as preferências, utilizadores e parâmetros do SIAG</p>
        </div>
        <button class="btn-green" id="btnSalvarGlobal">
          <i class="bi bi-check2-circle"></i> Guardar Alterações
        </button>
      </div>

      <!-- Settings Layout -->
      <div class="settings-wrap anim anim-d1">

        <!-- ── VERTICAL NAV ── -->
        <nav class="settings-nav">
          <button class="settings-nav-item active" data-tab="aparencia">
            <i class="bi bi-palette-fill"></i> Aparência
          </button>
          <button class="settings-nav-item" data-tab="notificacoes">
            <i class="bi bi-bell-fill"></i> Notificações
          </button>
          <button class="settings-nav-item" data-tab="seguranca">
            <i class="bi bi-shield-lock-fill"></i> Segurança
          </button>
          <div class="settings-nav-divider"></div>
          <button class="settings-nav-item" data-tab="utilizadores">
            <i class="bi bi-people-fill"></i> Utilizadores
          </button>
          <button class="settings-nav-item" data-tab="permissoes">
            <i class="bi bi-key-fill"></i> Permissões
          </button>
          <div class="settings-nav-divider"></div>
          <button class="settings-nav-item" data-tab="empresa">
            <i class="bi bi-pc-display-horizontal"></i> Sistema
          </button>
        </nav>

        <!-- ── CONTENT PANELS ── -->
        <div class="settings-content">

          <!-- ════════════════════════════
             TAB 1 — APARÊNCIA
        ════════════════════════════ -->
          <div class="settings-panel active" id="tab-aparencia">

            <!-- Tema -->
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-palette-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Tema do Sistema</div>
                    <div class="cfg-card-sub">Escolha o modo visual preferido</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="row g-3">
                  <div class="col-4">
                    <div class="theme-option selected" data-theme="claro">
                      <div class="theme-preview" style="background:#F4F6F4;">
                        <div
                          style="background:#fff;height:40%;border-radius:6px 6px 0 0;display:flex;align-items:center;padding:0 8px;gap:4px;">
                          <div style="width:8px;height:8px;background:#2E7D32;border-radius:50%;"></div>
                          <div style="flex:1;height:4px;background:#E8F5E9;border-radius:4px;"></div>
                        </div>
                        <div style="display:flex;height:60%;gap:4px;padding:4px 0 0 0;">
                          <div style="width:30%;background:#1B5E20;border-radius:0 0 0 6px;"></div>
                          <div style="flex:1;padding:4px;display:flex;flex-direction:column;gap:3px;">
                            <div style="height:4px;background:#E8F5E9;border-radius:4px;"></div>
                            <div style="height:4px;background:#E8F5E9;border-radius:4px;width:70%;"></div>
                          </div>
                        </div>
                      </div>
                      <div class="theme-label">Claro</div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="theme-option" data-theme="escuro">
                      <div class="theme-preview" style="background:#141d15;">
                        <div
                          style="background:#1e2a20;height:40%;border-radius:6px 6px 0 0;display:flex;align-items:center;padding:0 8px;gap:4px;">
                          <div style="width:8px;height:8px;background:#66BB6A;border-radius:50%;"></div>
                          <div style="flex:1;height:4px;background:#2E7D32;border-radius:4px;"></div>
                        </div>
                        <div style="display:flex;height:60%;gap:4px;padding:4px 0 0 0;">
                          <div style="width:30%;background:#0f3d14;border-radius:0 0 0 6px;"></div>
                          <div style="flex:1;padding:4px;display:flex;flex-direction:column;gap:3px;">
                            <div style="height:4px;background:#2E7D32;border-radius:4px;"></div>
                            <div style="height:4px;background:#2E7D32;border-radius:4px;width:70%;"></div>
                          </div>
                        </div>
                      </div>
                      <div class="theme-label">Escuro</div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="theme-option" data-theme="sistema">
                      <div class="theme-preview" style="background:linear-gradient(135deg,#F4F6F4 50%,#141d15 50%);">
                        <div
                          style="height:40%;border-radius:6px 6px 0 0;background:linear-gradient(135deg,#fff 50%,#1e2a20 50%);display:flex;align-items:center;padding:0 8px;gap:4px;">
                          <div style="width:8px;height:8px;background:#2E7D32;border-radius:50%;"></div>
                        </div>
                        <div style="display:flex;height:60%;gap:4px;padding:4px 0 0 0;">
                          <div
                            style="width:30%;background:linear-gradient(180deg,#1B5E20 50%,#0f3d14 50%);border-radius:0 0 0 6px;">
                          </div>
                          <div style="flex:1;"></div>
                        </div>
                      </div>
                      <div class="theme-label">Sistema</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Cor Principal -->
            <div class="cfg-card anim anim-d1">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon teal"><i class="bi bi-brush-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Cor Principal</div>
                    <div class="cfg-card-sub">Tom dominante da interface</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="color-options">
                  <div class="color-swatch selected" style="background:#2E7D32;" title="Verde Principal"
                    data-color="#2E7D32"></div>
                  <div class="color-swatch" style="background:#1565C0;" title="Azul" data-color="#1565C0"></div>
                  <div class="color-swatch" style="background:#6A1B9A;" title="Roxo" data-color="#6A1B9A"></div>
                  <div class="color-swatch" style="background:#E65100;" title="Laranja" data-color="#E65100"></div>
                  <div class="color-swatch" style="background:#00695C;" title="Verde Azulado" data-color="#00695C">
                  </div>
                  <div class="color-swatch" style="background:#C62828;" title="Vermelho" data-color="#C62828"></div>
                  <div class="color-swatch" style="background:#F57F17;" title="Âmbar" data-color="#F57F17"></div>
                  <div class="color-swatch" style="background:#37474F;" title="Cinzento" data-color="#37474F"></div>
                </div>
              </div>
            </div>

            <!-- Tipografia & Densidade -->
            <div class="cfg-card anim anim-d2">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon blue"><i class="bi bi-fonts"></i></div>
                  <div>
                    <div class="cfg-card-title">Tipografia</div>
                    <div class="cfg-card-sub">Fonte de texto do sistema</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="row g-2 mb-4">
                  <div class="col-12 col-md-4">
                    <div class="font-option selected" data-font="DM Sans">
                      <div class="font-option-sample" style="font-family:'DM Sans',sans-serif;">Aa</div>
                      <div>
                        <div class="font-option-name">DM Sans</div>
                        <div class="font-option-desc">Padrão actual</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="font-option" data-font="Sora">
                      <div class="font-option-sample" style="font-family:'Sora',sans-serif;">Aa</div>
                      <div>
                        <div class="font-option-name">Sora</div>
                        <div class="font-option-desc">Mais técnica</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="font-option" data-font="system">
                      <div class="font-option-sample" style="font-family:system-ui,sans-serif;">Aa</div>
                      <div>
                        <div class="font-option-name">Sistema</div>
                        <div class="font-option-desc">Fonte nativa</div>
                      </div>
                    </div>
                  </div>
                </div>

                <label class="cfg-label">Tamanho Base da Fonte</label>
                <input type="range" class="cfg-range" min="12" max="18" value="14" id="fontSizeRange">
                <div class="range-labels"><span>Pequeno (12px)</span><span id="fontSizeVal">14px</span><span>Grande
                    (18px)</span></div>

                <div style="margin-top:20px;">
                  <label class="cfg-label">Densidade da Interface</label>
                  <input type="range" class="cfg-range" min="1" max="3" value="2" id="densityRange">
                  <div class="range-labels"><span>Compacta</span><span
                      id="densityLabel">Normal</span><span>Espaçosa</span></div>
                </div>
              </div>
            </div>

            <!-- Sidebar -->
            <div class="cfg-card anim anim-d3">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-layout-sidebar-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Comportamento da Barra Lateral</div>
                    <div class="cfg-card-sub">Modo inicial e animações</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Sidebar expandida por defeito</div>
                    <div class="t-desc">Mostrar menu completo ao iniciar sessão</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Animações de transição</div>
                    <div class="t-desc">Deslizamento suave ao colapsar/expandir</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Tooltips no modo ícones</div>
                    <div class="t-desc">Mostrar etiqueta ao passar o rato sobre ícones</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
              </div>
            </div>
          </div>
          <!-- /TAB APARÊNCIA -->


          <!-- ════════════════════════════
             TAB 2 — NOTIFICAÇÕES
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-notificacoes">

            <!-- Canais -->
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon amber"><i class="bi bi-bell-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Canais de Notificação</div>
                    <div class="cfg-card-sub">Configure como e onde recebe alertas</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title"><i class="bi bi-bell-fill me-2" style="color:var(--primary)"></i>Notificações
                      no Sistema</div>
                    <div class="t-desc">Alertas visíveis dentro do SIAG (sino no topo)</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title"><i class="bi bi-envelope-fill me-2"
                        style="color:var(--primary)"></i>Notificações por E-mail</div>
                    <div class="t-desc">Enviar alertas para o e-mail do utilizador</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title"><i class="bi bi-phone-fill me-2" style="color:var(--primary)"></i>SMS /
                      WhatsApp</div>
                    <div class="t-desc">Alertas críticos via mensagem de texto</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title"><i class="bi bi-browser-chrome me-2"
                        style="color:var(--primary)"></i>Notificações Push (Navegador)</div>
                    <div class="t-desc">Alertas do sistema mesmo com o browser em segundo plano</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                </div>
              </div>
            </div>

            <!-- Tipos de Eventos -->
            <div class="cfg-card anim anim-d1">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-funnel-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Eventos a Notificar</div>
                    <div class="cfg-card-sub">Seleccione os acontecimentos que geram alertas</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="row g-3">
                  <div class="col-12 col-md-6">
                    <p
                      style="font-size:12px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--text-light);margin-bottom:10px;">
                      Financeiro</p>
                    <div class="cfg-toggle-row">
                      <div class="cfg-toggle-info">
                        <div class="t-title">Pagamentos em atraso</div>
                      </div>
                      <label class="toggle-switch"><input type="checkbox" checked><span
                          class="toggle-slider"></span></label>
                    </div>
                    <div class="cfg-toggle-row">
                      <div class="cfg-toggle-info">
                        <div class="t-title">Contas a vencer (3 dias)</div>
                      </div>
                      <label class="toggle-switch"><input type="checkbox" checked><span
                          class="toggle-slider"></span></label>
                    </div>
                    <div class="cfg-toggle-row">
                      <div class="cfg-toggle-info">
                        <div class="t-title">Novo pagamento recebido</div>
                      </div>
                      <label class="toggle-switch"><input type="checkbox" checked><span
                          class="toggle-slider"></span></label>
                    </div>
                    <div class="cfg-toggle-row">
                      <div class="cfg-toggle-info">
                        <div class="t-title">Limite de fluxo de caixa</div>
                      </div>
                      <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <p
                      style="font-size:12px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--text-light);margin-bottom:10px;">
                      Agrícola & Stock</p>
                    <div class="cfg-toggle-row">
                      <div class="cfg-toggle-info">
                        <div class="t-title">Stock crítico de insumos</div>
                      </div>
                      <label class="toggle-switch"><input type="checkbox" checked><span
                          class="toggle-slider"></span></label>
                    </div>
                    <div class="cfg-toggle-row">
                      <div class="cfg-toggle-info">
                        <div class="t-title">Início/fim de safra</div>
                      </div>
                      <label class="toggle-switch"><input type="checkbox" checked><span
                          class="toggle-slider"></span></label>
                    </div>
                    <div class="cfg-toggle-row">
                      <div class="cfg-toggle-info">
                        <div class="t-title">Novo cooperado registado</div>
                      </div>
                      <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                    </div>
                    <div class="cfg-toggle-row">
                      <div class="cfg-toggle-info">
                        <div class="t-title">Relatório gerado</div>
                      </div>
                      <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Configuração de E-mail -->
            <div class="cfg-card anim anim-d2">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon blue"><i class="bi bi-envelope-at-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Configuração de E-mail (SMTP)</div>
                    <div class="cfg-card-sub">Servidor de envio de notificações</div>
                  </div>
                </div>
                <button class="btn-outline-green" id="btnTestEmail"><i class="bi bi-send-fill"></i> Testar</button>
              </div>
              <div class="cfg-card-body">
                <div class="row g-3">
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Servidor SMTP</label>
                    <input class="cfg-input" type="text" placeholder="smtp.gmail.com" value="smtp.mailtrap.io">
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="cfg-label">Porta</label>
                    <input class="cfg-input" type="number" placeholder="587" value="587">
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="cfg-label">Encriptação</label>
                    <select class="cfg-select">
                      <option>TLS</option>
                      <option>SSL</option>
                      <option>Nenhuma</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Utilizador SMTP</label>
                    <input class="cfg-input" type="email" placeholder="no-reply@siag.ao" value="siag@coop-viana.ao">
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Senha SMTP</label>
                    <input class="cfg-input" type="password" value="••••••••••••">
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Nome do Remetente</label>
                    <input class="cfg-input" type="text" placeholder="SIAG Sistema" value="SIAG – Cooperativa Viana">
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">E-mail de Resposta (Reply-To)</label>
                    <input class="cfg-input" type="email" placeholder="suporte@siag.ao" value="suporte@coop-viana.ao">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /TAB NOTIFICAÇÕES -->


          <!-- ════════════════════════════
             TAB 3 — SEGURANÇA
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-seguranca">

            <!-- Política de Senha -->
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon red"><i class="bi bi-shield-lock-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Política de Senha</div>
                    <div class="cfg-card-sub">Regras de complexidade e validade</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="row g-3 mb-3">
                  <div class="col-12 col-md-4">
                    <label class="cfg-label">Comprimento Mínimo</label>
                    <input class="cfg-input" type="number" min="6" max="32" value="8">
                    <div class="cfg-helper">Recomendado: 8 ou mais caracteres</div>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label">Validade (dias)</label>
                    <input class="cfg-input" type="number" min="0" value="90">
                    <div class="cfg-helper">0 = sem expiração</div>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label">Tentativas até bloquear</label>
                    <input class="cfg-input" type="number" min="3" max="10" value="5">
                    <div class="cfg-helper">Após N tentativas falhadas</div>
                  </div>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Exigir letras maiúsculas e minúsculas</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Exigir pelo menos um número</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Exigir caractere especial (!@#$...)</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Impedir reutilização das últimas 5 senhas</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
              </div>
            </div>

            <!-- Sessão & Autenticação -->
            <div class="cfg-card anim anim-d1">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon amber"><i class="bi bi-clock-history"></i></div>
                  <div>
                    <div class="cfg-card-title">Sessão & Autenticação</div>
                    <div class="cfg-card-sub">Tempo de inactividade e autenticação de dois factores</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="row g-3 mb-3">
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Tempo de inactividade (minutos)</label>
                    <select class="cfg-select">
                      <option>15 minutos</option>
                      <option selected>30 minutos</option>
                      <option>1 hora</option>
                      <option>2 horas</option>
                      <option>Nunca</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Duração máxima da sessão</label>
                    <select class="cfg-select">
                      <option>4 horas</option>
                      <option selected>8 horas</option>
                      <option>24 horas</option>
                      <option>7 dias</option>
                    </select>
                  </div>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Autenticação de Dois Factores (2FA)</div>
                    <div class="t-desc">Obrigar 2FA para todos os administradores</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Notificar login em novo dispositivo</div>
                    <div class="t-desc">Enviar e-mail ao detectar acesso de IP desconhecido</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
                <div class="cfg-toggle-row">
                  <div class="cfg-toggle-info">
                    <div class="t-title">Forçar HTTPS em todas as ligações</div>
                    <div class="t-desc">Redirecionar HTTP → HTTPS automaticamente</div>
                  </div>
                  <label class="toggle-switch"><input type="checkbox" checked><span
                      class="toggle-slider"></span></label>
                </div>
              </div>
            </div>

            <!-- Log de Acessos -->
            <div class="cfg-card anim anim-d2">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon purple"><i class="bi bi-journal-text"></i></div>
                  <div>
                    <div class="cfg-card-title">Registo de Acessos Recentes</div>
                    <div class="cfg-card-sub">Últimas actividades de autenticação</div>
                  </div>
                </div>
                <button class="btn-outline-green"><i class="bi bi-download"></i> Exportar</button>
              </div>
              <div class="cfg-card-body" style="padding-bottom:8px;">
                <div class="security-log-item">
                  <div class="security-log-icon success"><i class="bi bi-check-circle-fill"></i></div>
                  <div class="security-log-info">
                    <div class="sl-title">Login bem-sucedido — Admin SIAG</div>
                    <div class="sl-meta"><i class="bi bi-geo-alt me-1"></i>Luanda, AO · IP 192.168.1.10 · Chrome 124
                    </div>
                  </div>
                  <div class="security-log-time">Hoje, 08:42</div>
                </div>
                <div class="security-log-item">
                  <div class="security-log-icon warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
                  <div class="security-log-info">
                    <div class="sl-title">Tentativa de login falhada — joao.ferreira</div>
                    <div class="sl-meta"><i class="bi bi-geo-alt me-1"></i>Viana, AO · IP 197.149.80.11 · Firefox 125
                    </div>
                  </div>
                  <div class="security-log-time">Hoje, 07:15</div>
                </div>
                <div class="security-log-item">
                  <div class="security-log-icon success"><i class="bi bi-check-circle-fill"></i></div>
                  <div class="security-log-info">
                    <div class="sl-title">Login bem-sucedido — Técnica Maria</div>
                    <div class="sl-meta"><i class="bi bi-geo-alt me-1"></i>Luanda, AO · IP 192.168.1.22 · Safari 17
                    </div>
                  </div>
                  <div class="security-log-time">Ontem, 16:30</div>
                </div>
                <div class="security-log-item">
                  <div class="security-log-icon danger"><i class="bi bi-shield-x-fill"></i></div>
                  <div class="security-log-info">
                    <div class="sl-title">Conta bloqueada — 5 tentativas — paulo.dias</div>
                    <div class="sl-meta"><i class="bi bi-geo-alt me-1"></i>Malanje, AO · IP 197.214.12.33 · Chrome
                      Mobile</div>
                  </div>
                  <div class="security-log-time">Ontem, 11:04</div>
                </div>
                <div class="security-log-item">
                  <div class="security-log-icon success"><i class="bi bi-check-circle-fill"></i></div>
                  <div class="security-log-info">
                    <div class="sl-title">Sessão terminada — Admin SIAG</div>
                    <div class="sl-meta"><i class="bi bi-geo-alt me-1"></i>Luanda, AO · IP 192.168.1.10 · Chrome 124
                    </div>
                  </div>
                  <div class="security-log-time">04 Jun, 18:00</div>
                </div>
              </div>
            </div>
          </div>
          <!-- /TAB SEGURANÇA -->









          <!-- ═══════════════════════=====================================================================═════
             TAB 4 — UTILIZADORES
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-utilizadores">

            <!-- Barra de acções -->
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon blue"><i class="bi bi-people-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Gestão de Utilizadores</div>
                    <div class="cfg-card-sub">Administradores, técnicos e gestores do sistema</div>
                  </div>
                </div>
                <button class="btn-green" id="btnNovoUser" data-bs-toggle="modal" data-bs-target="#modalNovoUser">
                  <i class="bi bi-person-plus-fill"></i> Novo Utilizador
                </button>
              </div>
              <!-- Search & Filter -->
              <div
                style="padding:14px 24px;border-bottom:1px solid var(--border);display:flex;gap:10px;flex-wrap:wrap;">
                <div style="flex:1;min-width:200px;position:relative;">
                  <i
                    class="bi bi-seabsolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-light);font-size:14px;"></i>
                  <input id="pesquisaUtilizador" class="cfg-input" type="text" placeholder="Pesquisar utilizador..."
                    style="padding-left:36px;">

                </div>
                <select id="filtroNivel" class="cfg-select" style="width:160px;">
                  <option value="">Todos os níveis</option>
                  <option value="gestor">Gestor</option>
                  <option value="tecnico">Técnico</option>
                </select>

                <select id="filtroEstado" class="cfg-select" style="width:140px;">
                  <option value="">Todos os estados</option>
                  <option value="activo">Activo</option>
                  <option value="inactivo">Inactivo</option>
                </select>
              </div>
              <!-- Table -->
              <div style="overflow-x:auto;">

                <table class="users-table">
                  <thead>
                    <tr>
                      <th>Utilizador</th>
                      <th>E-mail</th>
                      <th>Nível</th>
                      <th>Estado</th>
                      <th>Último Acesso</th>
                      <th style="text-align:center;">Ações</th>
                    </tr>
                  </thead>

                  <tbody id="tabela-utilizadores">

                    @foreach($users as $user)

                      <tr id="user-row-{{ $user->id }}" data-nivel="{{ strtolower($user->nivel) }}"
                        data-estado="{{ strtolower($user->estado) }}">
                        <td>
                          <div class="user-cell">

                            <img class="user-avatar-sm"
                              src="{{ !empty($user->foto) ? asset('uploads/users/' . $user->foto) : asset('uploads/users/default-user.png') }}"
                              alt="Foto" style="width:40px;height:40px;border-radius:50%;object-fit:cover;"
                              onerror="this.style.display='none';this.nextElementSibling.style.display='inline-flex';">

                            <div class="user-avatar-sm" style="display:none;">{{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                              <div style="font-weight:600;">{{ $user->name }}</div>
                              <div style="font-size:11px;color:var(--text-light);">Criado em
                                {{ $user->created_at->format('M Y') }}
                              </div>
                            </div>
                          </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nivel }}</td>
                        <td>{{ $user->estado }}</td>
                        <td>{{ $user->ultimo_acesso ? $user->ultimo_acesso->format('d/M/Y, H:i') : 'Nunca' }}</td>
                        <td style="text-align:center;">
                          <div style="display:flex;gap:6px;justify-content:center;">

                            <button class="topbar-icon-btn btn-editar-user" title="Editar" data-id="{{$user->id}}">
                              <i class="bi bi-pencil-fill"></i>
                            </button>

                            <button class="topbar-icon-btn btn-delete-user" title="Apagar utilizador"
                              data-id="{{$user->id}}"
                              style="width:30px;height:30px;font-size:14px;background:#FFEBEE;color:#C62828;"><i
                                class="bi bi-person-x-fill"></i>
                            </button>

                          </div>
                        </td>
                      </tr>

                    @endforeach

                  </tbody>

                </table>
              </div>
              <!-- Pagination -->
              <div
                style="padding:14px 24px;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--border);flex-wrap:wrap;gap:8px;">

                <span id="pagination-info" style="font-size:12.5px;color:var(--text-light);"> Mostrando 0 de 0
                  utilizadores </span>

                <!-- Pagination -->
                <div
                  style="padding:14px 24px;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--border);flex-wrap:wrap;gap:8px;">

                  <!-- Botões de Navegação -->
                  <div style="display:flex;gap:6px;" id="pagination-buttons">
                    <!-- Será preenchido dinamicamente -->
                  </div>

                </div>

              </div>
            </div>
          </div>

          <!-- /TAB UTILIZADORES -->






          <!-- ════════════════════════════
             TAB 5 — PERMISSÕES
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-permissoes">

            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon purple"><i class="bi bi-key-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Matriz de Permissões</div>
                    <div class="cfg-card-sub">Controlo de acesso por papel e módulo</div>
                  </div>
                </div>
                <button class="btn-green"><i class="bi bi-check2-all"></i> Guardar</button>
              </div>
              <div style="overflow-x:auto;">
                <table class="perm-table">
                  <thead>
                    <tr>
                      <th style="min-width:200px;">Módulo / Acção</th>
                      <th>
                        <div class="perm-role-header">
                          <span class="perm-role-badge" style="background:#EDE7F6;color:#6A1B9A;">Admin</span>
                          <span style="font-size:10px;font-weight:400;color:var(--text-light);">Total</span>
                        </div>
                      </th>
                      <th>
                        <div class="perm-role-header">
                          <span class="perm-role-badge"
                            style="background:var(--accent-lt);color:var(--primary);">Gestor</span>
                          <span style="font-size:10px;font-weight:400;color:var(--text-light);">Operacional</span>
                        </div>
                      </th>
                      <th>
                        <div class="perm-role-header">
                          <span class="perm-role-badge" style="background:#E3F2FD;color:#1565C0;">Técnico</span>
                          <span style="font-size:10px;font-weight:400;color:var(--text-light);">Agrícola</span>
                        </div>
                      </th>
                      <th>
                        <div class="perm-role-header">
                          <span class="perm-role-badge" style="background:#E8F5E9;color:#2E7D32;">Agricultor</span>
                          <span style="font-size:10px;font-weight:400;color:var(--text-light);">Próprio</span>
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Dashboard -->
                    <tr style="background:var(--page-bg);">
                      <td colspan="5"
                        style="font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--text-light);padding:8px 16px;">
                        Dashboard</td>
                    </tr>
                    <tr>
                      <td>Visualizar Dashboard</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check"></td>
                    </tr>
                    <!-- Cooperados -->
                    <tr style="background:var(--page-bg);">
                      <td colspan="5"
                        style="font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--text-light);padding:8px 16px;">
                        Cooperados</td>
                    </tr>
                    <tr>
                      <td>Listar cooperados</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check"></td>
                    </tr>
                    <tr>
                      <td>Criar / Editar cooperado</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check"></td>
                    </tr>
                    <tr>
                      <td>Eliminar cooperado</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check"></td>
                    </tr>
                    <!-- Financeiro -->
                    <tr style="background:var(--page-bg);">
                      <td colspan="5"
                        style="font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--text-light);padding:8px 16px;">
                        Financeiro</td>
                    </tr>
                    <tr>
                      <td>Visualizar contas</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                    </tr>
                    <tr>
                      <td>Registar pagamentos</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                    </tr>
                    <tr>
                      <td>Exportar relatórios financeiros</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check"></td>
                    </tr>
                    <!-- Agrícola -->
                    <tr style="background:var(--page-bg);">
                      <td colspan="5"
                        style="font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--text-light);padding:8px 16px;">
                        Agrícola</td>
                    </tr>
                    <tr>
                      <td>Gerir safras e talhões</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                    </tr>
                    <tr>
                      <td>Controlo de insumos</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                    </tr>
                    <tr>
                      <td>Registar produção</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                    </tr>
                    <!-- Sistema -->
                    <tr style="background:var(--page-bg);">
                      <td colspan="5"
                        style="font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--text-light);padding:8px 16px;">
                        Sistema</td>
                    </tr>
                    <tr>
                      <td>Aceder às Configurações</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check"></td>
                    </tr>
                    <tr>
                      <td>Gerir utilizadores</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check"></td>
                    </tr>
                    <tr>
                      <td>Ver logs de auditoria</td>
                      <td><input type="checkbox" class="perm-check" checked disabled></td>
                      <td><input type="checkbox" class="perm-check" checked></td>
                      <td><input type="checkbox" class="perm-check"></td>
                      <td><input type="checkbox" class="perm-check"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div style="padding:14px 24px;border-top:1px solid var(--border);">
                <p style="font-size:12px;color:var(--text-light);"><i class="bi bi-info-circle me-1"></i>As permissões
                  marcadas como <strong>Admin</strong> estão bloqueadas por segurança e não podem ser removidas.</p>
              </div>
            </div>

          </div>
          <!-- /TAB PERMISSÕES -->


          <!-- ════════════════════════════
             TAB 6 — SISTEMA
        ════════════════════════════ -->
          <div class="settings-panel" id="tab-empresa">

            <!-- Identidade do Sistema SIAG -->
            <div class="cfg-card anim">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-pc-display-horizontal"></i></div>
                  <div>
                    <div class="cfg-card-title">Identidade do Sistema</div>
                    <div class="cfg-card-sub">Nome, logotipo e favicon exibidos na interface do SIAG</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="row g-3">
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Nome do Sistema</label>
                    <input class="cfg-input" type="text" value="SIAG">
                    <div class="cfg-helper">Aparece no título do navegador e no cabeçalho</div>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Subtítulo / Tagline</label>
                    <input class="cfg-input" type="text" value="Agrícola Cooperativas">
                    <div class="cfg-helper">Texto secundário abaixo do nome na sidebar</div>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Logotipo Principal</label>
                    <div class="logo-upload-zone" onclick="document.getElementById('logoInput').click()">
                      <div class="logo-upload-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                      <div class="logo-upload-text">Clique para carregar logotipo</div>
                      <div class="logo-upload-hint">PNG, SVG ou JPG · Máx. 2 MB · 300×100 px recomendado</div>
                    </div>
                    <input type="file" id="logoInput" accept="image/*" style="display:none;">
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Ícone / Favicon</label>
                    <div class="logo-upload-zone" onclick="document.getElementById('faviconInput').click()">
                      <div class="logo-upload-icon"><i class="bi bi-file-image-fill"></i></div>
                      <div class="logo-upload-text">Clique para carregar favicon</div>
                      <div class="logo-upload-hint">PNG ou ICO · 32×32 px ou 64×64 px</div>
                    </div>
                    <input type="file" id="faviconInput" accept="image/*,.ico" style="display:none;">
                  </div>
                </div>
              </div>
            </div>

            <!-- Parâmetros Globais -->
            <div class="cfg-card anim anim-d1">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon teal"><i class="bi bi-sliders"></i></div>
                  <div>
                    <div class="cfg-card-title">Parâmetros Globais do Sistema</div>
                    <div class="cfg-card-sub">Configurações que se aplicam a todas as cooperativas geridas pelo SIAG
                    </div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div class="row g-3">
                  <div class="col-12 col-md-4">
                    <label class="cfg-label">Moeda Padrão</label>
                    <select class="cfg-select">
                      <option selected>Kwanza (Kz)</option>
                      <option>Dólar (USD)</option>
                      <option>Euro (€)</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label">Fuso Horário</label>
                    <select class="cfg-select">
                      <option selected>Africa/Luanda (UTC+1)</option>
                      <option>UTC</option>
                      <option>Africa/Maputo (UTC+2)</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label">Formato de Data</label>
                    <select class="cfg-select">
                      <option selected>DD/MM/AAAA</option>
                      <option>MM/DD/AAAA</option>
                      <option>AAAA-MM-DD</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label">Idioma do Sistema</label>
                    <select class="cfg-select">
                      <option selected>Português (Angola)</option>
                      <option>Português (Brasil)</option>
                      <option>English</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label">Safra Global Activa</label>
                    <input class="cfg-input" type="text" value="2024/2025">
                    <div class="cfg-helper">Referência padrão para relatórios e filtros</div>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label">Versão do Sistema</label>
                    <input class="cfg-input" type="text" value="SIAG v1.0.0" readonly
                      style="background:#f5f5f5;color:var(--text-light);cursor:not-allowed;">
                  </div>
                </div>
              </div>
            </div>

            <!-- Ano Agrícola -->
            <div class="cfg-card anim anim-d2">
              <div class="cfg-card-header">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon green"><i class="bi bi-calendar2-range-fill"></i></div>
                  <div>
                    <div class="cfg-card-title">Ano Agrícola</div>
                    <div class="cfg-card-sub">Registo e controlo dos anos de actividade agrícola do sistema</div>
                  </div>
                </div>
                <button class="btn-green" id="btnIniciarAno" data-bs-toggle="modal" data-bs-target="#modalAnoAgricola">
                  <i class="bi bi-plus-circle-fill"></i> Registar Ano Agrícola
                </button>
              </div>

              <!-- Tabela de anos anteriores -->
              <div style="overflow-x:auto;">
                <table class="users-table" id="tabelaAnosAgricolas">
                  <thead>
                    <tr>
                      <th>Nome / Período</th>
                      <th>Data Início</th>
                      <th>Data Fim</th>
                      <th>Estado</th>
                      <th>Registado em</th>
                      <th style="text-align:center;">Acções</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($anos as $ano)

                      <tr id="ano-row-{{ $ano->id }}">

                        <td>
                          <div style="font-weight:600;">
                            {{ $ano->nome }}
                          </div>

                          <div style="font-size:11px;color:var(--text-light);">
                            ID #{{ $ano->id }}
                          </div>
                        </td>

                        <td>
                          {{ \Carbon\Carbon::parse($ano->data_inicio)->format('d/m/Y') }}
                        </td>

                        <td>
                          {{ \Carbon\Carbon::parse($ano->data_fim)->format('d/m/Y') }}
                        </td>

                        <td>

                          @if($ano->estado == 'em_producao')

                            <span
                              style="font-size:11px;font-weight:600;background:#E8F5E9;color:#2E7D32;padding:3px 10px;border-radius:20px;">
                              Em Produção
                            </span>

                          @elseif($ano->estado == 'iniciado')

                            <span
                              style="font-size:11px;font-weight:600;background:#FFF8E1;color:#F57F17;padding:3px 10px;border-radius:20px;">
                              Iniciado
                            </span>

                          @else

                            <span
                              style="font-size:11px;font-weight:600;background:#F5F5F5;color:#757575;padding:3px 10px;border-radius:20px;">
                              Finalizado
                            </span>

                          @endif

                        </td>

                        <td>
                          {{ $ano->created_at->format('d M Y') }}
                        </td>

                        <td style="text-align:center;">

                          <div style="display:flex;gap:6px;justify-content:center;">

                            <button class="topbar-icon-btn btn-editar-ano" data-id="{{ $ano->id }}"
                              data-nome="{{ $ano->nome }}" data-inicio="{{ $ano->data_inicio }}"
                              data-fim="{{ $ano->data_fim }}" data-estado="{{ $ano->estado }}">
                              <i class="bi bi-pencil-fill"></i>
                            </button>

                            <button class="topbar-icon-btn btn-eliminar-ano" data-id="{{ $ano->id }}">
                              <i class="bi bi-trash-fill"></i>
                            </button>

                          </div>

                        </td>

                      </tr>

                    @endforeach

                  </tbody>
                </table>
              </div>
              <div style="padding:12px 22px;border-top:1px solid var(--border);">
                {{-- paginação --}}
              </div>
            </div>

            <!-- Zona de Perigo -->
            <div class="cfg-card anim anim-d3" style="border-color:#FFCDD2;">
              <div class="cfg-card-header"
                style="border-bottom-color:#FFCDD2;background:#FFF8F8;border-radius:16px 16px 0 0;">
                <div class="cfg-card-header-left">
                  <div class="cfg-card-icon red"><i class="bi bi-exclamation-triangle-fill"></i></div>
                  <div>
                    <div class="cfg-card-title" style="color:#C62828;">Zona de Perigo</div>
                    <div class="cfg-card-sub">Acções irreversíveis. Proceda com cautela.</div>
                  </div>
                </div>
              </div>
              <div class="cfg-card-body">
                <div
                  style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid #FFCDD2;flex-wrap:wrap;gap:10px;">
                  <div>
                    <div style="font-size:13.5px;font-weight:600;color:var(--text-dark);">Exportar todos os dados</div>
                    <div style="font-size:12px;color:var(--text-light);">Gerar arquivo ZIP com backup completo de todas
                      as cooperativas</div>
                  </div>
                  <button class="btn-outline-green"><i class="bi bi-download"></i> Exportar ZIP</button>
                </div>
                <div
                  style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid #FFCDD2;flex-wrap:wrap;gap:10px;">
                  <div>
                    <div style="font-size:13.5px;font-weight:600;color:var(--text-dark);">Limpar dados de demonstração
                    </div>
                    <div style="font-size:12px;color:var(--text-light);">Remove todos os registos de teste inseridos
                      durante a configuração</div>
                  </div>
                  <button class="btn-danger-outline"><i class="bi bi-eraser-fill"></i> Limpar Demo</button>
                </div>
                <div
                  style="display:flex;align-items:center;justify-content:space-between;padding:12px 0 0 0;flex-wrap:wrap;gap:10px;">
                  <div>
                    <div style="font-size:13.5px;font-weight:600;color:#C62828;">Repor configurações de fábrica</div>
                    <div style="font-size:12px;color:var(--text-light);">Apaga TODOS os dados do sistema e reinicia.
                      Acção irreversível.</div>
                  </div>
                  <button class="btn-danger-outline" style="border-color:#C62828;color:#C62828;" id="btnResetSystem">
                    <i class="bi bi-trash3-fill"></i> Repor Sistema
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- /TAB SISTEMA -->

        </div>
        <!-- /settings-content -->

      </div>
      <!-- /settings-wrap -->

    </div>
  </main>

  <!-- ══ TOAST FEEDBACK ══ -->
  <div class="save-toast" id="saveToast">
    <div class="toast-icon"><i class="bi bi-check-lg"></i></div>
    <div class="toast-text">
      <div class="t-title">Configurações guardadas</div>
      <div class="t-sub">As alterações foram aplicadas com sucesso1.</div>
    </div>
  </div>








  <!-- ══════════════════════════════════════
       MODAL — NOVO / EDITAR UTILIZADOR
  ══════════════════════════════════════ -->
  <div class="modal fade" id="modalNovoUser" tabindex="-1" aria-labelledby="modalNovoUserLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-user modal-dialog-centered">
      <div class="modal-content">

        <!-- Header -->
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-user-header-icon">
              <i class="bi bi-person-plus-fill"></i>
            </div>
            <div>
              <div class="modal-title" id="modalNovoUserLabel">Novo Utilizador</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <!-- Tabs nav -->
        <div class="modal-user-tabs">
          <button class="modal-user-tab-btn active" data-user-tab="dados">
            <i class="bi bi-person-fill"></i> Dados Pessoais
          </button>
          <button class="modal-user-tab-btn" data-user-tab="acesso">
            <i class="bi bi-shield-lock-fill"></i> Acesso & Segurança
          </button>
          <button class="modal-user-tab-btn" data-user-tab="perfil">
            <i class="bi bi-sliders"></i> Perfil & Estado
          </button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <form id="formNovoUser" novalidate>
            @csrf

            <input type="hidden" id="userId" name="id" value="">

            <!-- ══ TAB 1 — DADOS PESSOAIS ══ -->
            <div class="modal-user-tab-panel active" id="utab-dados">

              <div class="mf-card">
                <div class="mf-section-title">
                  <i class="bi bi-camera-fill"></i> Fotografia do Utilizador
                </div>
                <div style="display:flex;align-items:center;gap:22px;">
                  <div class="foto-upload-zone" onclick="document.getElementById('fotoInput').click()" id="fotoZone">
                    <i class="bi bi-person-circle"></i>
                    <span>Carregar foto</span>
                  </div>
                  <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none;">
                  <div>
                    <div style="font-size:13px;font-weight:600;color:var(--text-dark);margin-bottom:4px;">Foto de perfil
                    </div>
                    <div style="font-size:12px;color:var(--text-light);margin-bottom:10px;">JPG ou PNG · Máx. 2 MB ·
                      200×200 px recomendado</div>
                    <button type="button" class="btn-outline-green" style="padding:6px 14px;font-size:12.5px;"
                      onclick="document.getElementById('fotoInput').click()">
                      <i class="bi bi-upload"></i> Seleccionar ficheiro
                    </button>
                  </div>
                </div>
              </div>

              <div class="mf-card">
                <div class="mf-section-title">
                  <i class="bi bi-person-vcard-fill"></i> Informação Pessoal
                </div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="cfg-label" for="userName">Nome Completo *</label>
                    <input class="cfg-input" type="text" id="userName" name="name" placeholder="" required>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label" for="userEmail">E-mail *</label>
                    <input class="cfg-input" type="email" id="userEmail" name="email" placeholder="utilizador@siag.ao"
                      required>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label" for="userTelefone">Telefone</label>
                    <input class="cfg-input" type="tel" id="userTelefone" name="telefone" placeholder="">
                  </div>
                </div>
              </div>
            </div>
            <!-- /TAB DADOS PESSOAIS -->

            <!-- ══ TAB 2 — ACESSO & SEGURANÇA ══ -->
            <div class="modal-user-tab-panel" id="utab-acesso">

              <div class="mf-card">
                <div class="mf-section-title">
                  <i class="bi bi-key-fill"></i> Credenciais de Acesso
                </div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="cfg-label" for="userPassword">Senha *</label>
                    <div style="position:relative;">
                      <input class="cfg-input" type="password" id="userPassword" name="password"
                        placeholder="Mínimo 8 caracteres" autocomplete="new-password" oninput="avaliarSenha(this.value)"
                        style="padding-right:44px;">
                      <button type="button" onclick="togglePwd('userPassword','eyePwd1')"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-light);cursor:pointer;font-size:16px;">
                        <i class="bi bi-eye-fill" id="eyePwd1"></i>
                      </button>
                    </div>
                    <div class="pwd-strength-bar">
                      <div class="pwd-strength-fill" id="pwdFill"></div>
                    </div>
                    <div class="pwd-strength-label" id="pwdLabel">Introduza a senha</div>
                  </div>
                  <div class="col-12">
                    <label class="cfg-label" for="userPasswordConfirm">Confirmar Senha *</label>
                    <div style="position:relative;">
                      <input class="cfg-input" type="password" id="userPasswordConfirm" name="password_confirmation"
                        placeholder="Repita a senha" autocomplete="new-password" style="padding-right:44px;">
                      <button type="button" onclick="togglePwd('userPasswordConfirm','eyePwd2')"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-light);cursor:pointer;font-size:16px;">
                        <i class="bi bi-eye-fill" id="eyePwd2"></i>
                      </button>
                    </div>
                    <div class="cfg-helper" id="pwdMatchMsg"></div>
                  </div>
                </div>
              </div>

            </div>
            <!-- /TAB ACESSO & SEGURANÇA -->

            <!-- ══ TAB 3 — PERFIL & ESTADO ══ -->
            <div class="modal-user-tab-panel" id="utab-perfil">

              <div class="mf-card">
                <div class="mf-section-title">
                  <i class="bi bi-person-gear"></i> Nível de Acesso
                </div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="cfg-label" for="userNivel">Nível / Papel *</label>
                    <select class="cfg-select" id="userNivel" name="nivel" required>
                      <option value="">Seleccione o nível…</option>
                      <option value="admin">Administrador</option>
                      <option value="gestor">Gestor</option>
                      <option value="tecnico">Técnico</option>
                    </select>
                    <div class="cfg-helper">Define quais os módulos e acções disponíveis para este utilizador</div>
                  </div>
                </div>
              </div>

              <div class="mf-card">
                <div class="mf-section-title">
                  <i class="bi bi-toggle-on"></i> Estado da Conta
                </div>
                <div class="row g-3">
                  <div class="col-12 col-md-6">
                    <label class="cfg-label" for="userEstado">Estado *</label>
                    <select class="cfg-select" id="userEstado" name="estado" required>
                      <option value="activo" selected>Activo</option>
                      <option value="inactivo">Inactivo</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label">Último Acesso</label>
                    <input class="cfg-input" type="text" value="—" readonly
                      style="background:#f5f5f5;color:var(--text-light);cursor:not-allowed;"
                      title="Preenchido automaticamente pelo sistema">
                    <div class="cfg-helper">Campo <code>ultimo_acesso</code> — gerido pelo sistema</div>
                  </div>
                </div>
              </div>

              <div class="mf-card">
                <div class="mf-section-title">
                  <i class="bi bi-info-circle-fill"></i> Informação do Registo
                </div>
                <div class="row g-2">
                  <div class="col-6">
                    <div style="padding:10px 12px;background:#FAFAF9;border:1px solid var(--border);border-radius:8px;">
                      <div
                        style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-light);">
                        Criado em</div>
                      <div style="font-size:13px;font-weight:500;color:var(--text-dark);margin-top:2px;"
                        id="userCreatedAt">— (novo registo)</div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div style="padding:10px 12px;background:#FAFAF9;border:1px solid var(--border);border-radius:8px;">
                      <div
                        style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-light);">
                        Actualizado em</div>
                      <div style="font-size:13px;font-weight:500;color:var(--text-dark);margin-top:2px;"
                        id="userUpdatedAt">— (novo registo)</div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <!-- /TAB PERFIL & ESTADO -->

          </form>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i> Cancelar
              </button>

              <button type="button" class="btn-green" id="btnGuardarUser">
                <i class="bi bi-check2-circle"></i>
                <span id="btnGuardarUserLabel">Registar Utilizador</span>
              </button>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- /MODAL NOVO UTILIZADOR -->

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {

      const pesquisa = document.getElementById('pesquisaUtilizador');
      const filtroNivel = document.getElementById('filtroNivel');
      const filtroEstado = document.getElementById('filtroEstado');

      function filtrarUtilizadores() {

        const texto = pesquisa.value.toLowerCase();
        const nivel = filtroNivel.value.toLowerCase();
        const estado = filtroEstado.value.toLowerCase();

        const linhas = document.querySelectorAll('#tabela-utilizadores tr');

        linhas.forEach(linha => {

          const conteudo = linha.innerText.toLowerCase();
          const nivelLinha = linha.dataset.nivel || '';
          const estadoLinha = linha.dataset.estado || '';

          const correspondePesquisa =
            texto === '' || conteudo.includes(texto);

          const correspondeNivel =
            nivel === '' || nivelLinha === nivel;

          const correspondeEstado =
            estado === '' || estadoLinha === estado;

          linha.style.display =
            (correspondePesquisa &&
              correspondeNivel &&
              correspondeEstado)
              ? ''
              : 'none';
        });
      }

      pesquisa.addEventListener('keyup', filtrarUtilizadores);
      filtroNivel.addEventListener('change', filtrarUtilizadores);
      filtroEstado.addEventListener('change', filtrarUtilizadores);

    });
  </script>

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
       SETTINGS TABS
    ══════════════════════════════════════ */
    document.querySelectorAll('.settings-nav-item').forEach(btn => {
      btn.addEventListener('click', () => {
        const tab = btn.dataset.tab;

        // Nav active state
        document.querySelectorAll('.settings-nav-item').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Panel active state
        document.querySelectorAll('.settings-panel').forEach(p => {
          p.classList.remove('active');
          // Re-trigger animations
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
       TEMA (CLARO / ESCURO / SISTEMA)
    ══════════════════════════════════════ */
    document.querySelectorAll('.theme-option').forEach(opt => {
      opt.addEventListener('click', () => {
        document.querySelectorAll('.theme-option').forEach(o => o.classList.remove('selected'));
        opt.classList.add('selected');
        const t = opt.dataset.theme;
        if (t === 'escuro') { body.classList.add('dark-mode'); darkMode = true; themeIcon.className = 'bi bi-sun-fill'; themeLabel.textContent = 'Modo Claro'; }
        else { body.classList.remove('dark-mode'); darkMode = false; themeIcon.className = 'bi bi-moon-stars-fill'; themeLabel.textContent = 'Modo Escuro'; }
      });
    });

    /* ══════════════════════════════════════
       COR PRINCIPAL
    ══════════════════════════════════════ */
    document.querySelectorAll('.color-swatch').forEach(swatch => {
      swatch.addEventListener('click', () => {
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
        swatch.classList.add('selected');
        // Aplica cor ao CSS (demo — em produção persistiria via AJAX)
        document.documentElement.style.setProperty('--primary', swatch.dataset.color);
      });
    });

    /* ══════════════════════════════════════
       TIPOGRAFIA
    ══════════════════════════════════════ */
    document.querySelectorAll('.font-option').forEach(opt => {
      opt.addEventListener('click', () => {
        document.querySelectorAll('.font-option').forEach(o => o.classList.remove('selected'));
        opt.classList.add('selected');
      });
    });

    /* Sliders */
    const fontRange = document.getElementById('fontSizeRange');
    const fontVal = document.getElementById('fontSizeVal');
    const densRange = document.getElementById('densityRange');
    const densLabel = document.getElementById('densityLabel');
    const densLabels = ['Compacta', 'Normal', 'Espaçosa'];

    if (fontRange) {
      fontRange.addEventListener('input', () => { fontVal.textContent = fontRange.value + 'px'; });
    }
    if (densRange) {
      densRange.addEventListener('input', () => { densLabel.textContent = densLabels[densRange.value - 1]; });
    }

    /* ══════════════════════════════════════
       TOAST DE GRAVAÇÃO
    ══════════════════════════════════════ */
    function showToast(msg, sub) {
      const toast = document.getElementById('saveToast');
      if (msg) toast.querySelector('.t-title').textContent = msg;
      if (sub) toast.querySelector('.t-sub').textContent = sub;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3000);
    }

    document.getElementById('btnSalvarGlobal').addEventListener('click', () => {
      showToast('Configurações guardadas', 'As alterações foram aplicadas com sucesso.');
    });

    /* ══════════════════════════════════════
       TESTAR E-MAIL
    ══════════════════════════════════════ */
    const btnTestEmail = document.getElementById('btnTestEmail');
    if (btnTestEmail) {
      btnTestEmail.addEventListener('click', () => {
        btnTestEmail.innerHTML = '<i class="bi bi-hourglass-split"></i> A enviar...';
        btnTestEmail.disabled = true;
        setTimeout(() => {
          btnTestEmail.innerHTML = '<i class="bi bi-send-fill"></i> Testar';
          btnTestEmail.disabled = false;
          showToast('E-mail de teste enviado!', 'Verifique a caixa de entrada do remetente.');
        }, 1800);
      });
    }

    /* ══════════════════════════════════════
       RESET CONFIRMAÇÃO
    ══════════════════════════════════════ */
    const btnReset = document.getElementById('btnResetSystem');
    if (btnReset) {
      btnReset.addEventListener('click', () => {
        if (confirm('⚠️ Atenção! Esta acção é irreversível.\n\nTodos os dados serão apagados. Tem a certeza que deseja repor o sistema?')) {
          alert('Acção cancelada por segurança neste ambiente de demonstração.');
        }
      });
    }

    /* ══════════════════════════════════════
       NAV ACTIVO SIDEBAR
    ══════════════════════════════════════ */
    document.querySelectorAll('.nav-item-link').forEach(link => {
      link.addEventListener('click', function (e) {
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
       UPLOAD PREVIEW (logo)
    ══════════════════════════════════════ */
    ['logoInput', 'faviconInput'].forEach(id => {
      const input = document.getElementById(id);
      if (!input) return;
      input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) showToast('Ficheiro carregado', file.name + ' aguarda ser guardado.');
      });
    });



    /* ══════════════════════════════════════
       MODAL — NOVO UTILIZADOR
    ══════════════════════════════════════ */

    document.getElementById('btnNovoUser').addEventListener('click', () => {

      modoUser = 'create';
      document.getElementById('formNovoUser').reset();
      document.getElementById('modalNovoUserLabel').textContent = 'Novo Utilizador';
      document.getElementById('btnGuardarUserLabel').textContent = 'Registar Utilizador';
    });

    // Tabs do modal
    document.querySelectorAll('.modal-user-tab-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const tab = btn.dataset.userTab;
        document.querySelectorAll('.modal-user-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.modal-user-tab-panel').forEach(p => p.classList.remove('active'));
        const panel = document.getElementById('utab-' + tab);
        if (panel) panel.classList.add('active');
      });
    });

    let modoUser = 'create';

    // Reset modal ao abrir
    document.getElementById('modalNovoUser').addEventListener('show.bs.modal', () => {


      if (modoUser === 'create') {

        document.getElementById('formNovoUser').reset();

        document.getElementById('userId').value = '';
        document.getElementById('modalNovoUserLabel').textContent = 'Novo Utilizador';

        document.getElementById('btnGuardarUserLabel').textContent = 'Registar Utilizador';

        document.getElementById('pwdFill').style.width = '0%';
        document.getElementById('pwdLabel').textContent = 'Introduza a senha';
        document.getElementById('pwdLabel').style.color = 'var(--text-light)';
        document.getElementById('pwdMatchMsg').textContent = '';
        document.getElementById('userCreatedAt').textContent = '— (novo registo)';
        document.getElementById('userUpdatedAt').textContent = '— (novo registo)';
        // Reset foto zone
        const fotoZone = document.getElementById('fotoZone');
        fotoZone.innerHTML = '<i class="bi bi-person-circle"></i><span>Carregar foto</span>';

        fotoZone.style.background = '';
      }
      // Volta sempre ao primeiro tab
      document.querySelectorAll('.modal-user-tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.modal-user-tab-panel').forEach(p => p.classList.remove('active'));
      document.querySelector('.modal-user-tab-btn[data-user-tab="dados"]').classList.add('active');
      document.getElementById('utab-dados').classList.add('active');
    });

    // Mostrar/ocultar senha
    function togglePwd(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash-fill';
      } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-fill';
      }
    }

    // Avaliador de força da senha
    function avaliarSenha(val) {
      const fill = document.getElementById('pwdFill');
      const label = document.getElementById('pwdLabel');
      const confirm = document.getElementById('userPasswordConfirm');

      let score = 0;
      if (val.length >= 8) score++;
      if (/[A-Z]/.test(val)) score++;
      if (/[0-9]/.test(val)) score++;
      if (/[^A-Za-z0-9]/.test(val)) score++;

      const configs = [
        { w: '0%', color: 'var(--border)', text: 'Introduza a senha' },
        { w: '25%', color: '#C62828', text: 'Fraca' },
        { w: '50%', color: '#F57F17', text: 'Razoável' },
        { w: '75%', color: '#1565C0', text: 'Boa' },
        { w: '100%', color: '#2E7D32', text: 'Forte' },
      ];
      const c = configs[score] || configs[0];
      fill.style.width = c.w;
      fill.style.background = c.color;
      label.textContent = c.text;
      label.style.color = c.color;

      // verificar confirmação em tempo real
      verificarConfirmacao(val, confirm.value);
    }

    function verificarConfirmacao(pwd, confirm) {
      const msg = document.getElementById('pwdMatchMsg');
      if (!confirm) { msg.textContent = ''; return; }
      if (pwd === confirm) {
        msg.textContent = '✓ As senhas coincidem';
        msg.style.color = '#2E7D32';
      } else {
        msg.textContent = '✗ As senhas não coincidem';
        msg.style.color = '#C62828';
      }
    }

    document.getElementById('userPasswordConfirm').addEventListener('input', function () {
      verificarConfirmacao(document.getElementById('userPassword').value, this.value);
    });

    // Preview foto
    document.getElementById('fotoInput').addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = function (ev) {
        const zone = document.getElementById('fotoZone');
        zone.innerHTML = `<img src="${ev.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        zone.style.border = '2px solid var(--primary)';
      };
      reader.readAsDataURL(file);
    });



    // Guardar utilizador e Actualizar
    document.getElementById('btnGuardarUser').addEventListener('click', () => {

      const nome = document.getElementById('userName').value.trim();
      const email = document.getElementById('userEmail').value.trim();
      const pwd = document.getElementById('userPassword').value;
      const pwdC = document.getElementById('userPasswordConfirm').value;
      const nivel = document.getElementById('userNivel').value;
      const estado = document.getElementById('userEstado').value;
      const userId = document.getElementById('userId').value;

      // Validação
      if (!nome || !email) {
        document.querySelector('.modal-user-tab-btn[data-user-tab="dados"]').click();
        showToast('Campos obrigatórios em falta', 'Preencha o Nome e E-mail.', 'danger');
        return;
      }

      // Só obriga senha quando for novo utilizador
      if (modoUser === 'create' && !pwd) {
        document.querySelector('.modal-user-tab-btn[data-user-tab="acesso"]').click();
        showToast('Senha obrigatória', 'Defina uma senha para o utilizador.', 'danger');
        return;
      }

      // Só valida se alguma senha foi introduzida
      if (pwd && pwd !== pwdC) {
        document.querySelector('.modal-user-tab-btn[data-user-tab="acesso"]').click();
        showToast('Senhas não coincidem', 'As senhas introduzidas são diferentes.', 'danger');
        return;
      }

      if (!nivel) {
        document.querySelector('.modal-user-tab-btn[data-user-tab="perfil"]').click();
        showToast('Nível obrigatório', 'Seleccione o nível de acesso do utilizador.', 'danger');
        return;
      }

      const btn = document.getElementById('btnGuardarUser');
      const orig = btn.innerHTML;

      btn.innerHTML = '<i class="bi bi-hourglass-split"></i> A guardar…';
      btn.disabled = true;

      const formData = new FormData(document.getElementById('formNovoUser'));

      formData.append('name', nome);
      formData.append('email', email);
      formData.append('telefone', document.getElementById('userTelefone').value.trim());
      formData.append('nivel', nivel);
      formData.append('estado', estado);

      // Só envia senha se existir
      if (pwd) {
        formData.append('password', pwd);
      }

      let url = '/users';
      let method = 'POST';

      // EDITAR--------------------------------------------------------------------------------------------------------------------------------------------------------
      if (modoUser === 'edit') {

        url = `/users/${userId}`;

        // Laravel aceita PUT via _method
        formData.append('_method', 'PUT');

      }

      fetch(url, {
        method: method,
        headers: {
          'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content'),
          'Accept': 'application/json',
        },
        body: formData
      })
        .then(res => res.json())
        .then(data => {

          btn.innerHTML = orig;
          btn.disabled = false;

          if (data.success) {

            // Novo utilizador
            if (modoUser === 'create') {

              adicionarLinhaTabela(data.user);

              showToast(
                'Utilizador criado',
                'Registado com sucesso.'
              );

            } else {

              showToast(
                'Utilizador actualizado',
                'Dados actualizados com sucesso.'
              );

              // alterar a linha sem carregar
              const linha = document.getElementById(
                `user-row-${data.user.id}`
              );

              if (linha) {

                linha.children[1].textContent = data.user.email;
                linha.children[2].textContent = data.user.nivel;
                linha.children[3].textContent = data.user.estado;

                const nomeDiv =
                  linha.querySelector('.user-cell div div');

                if (nomeDiv) {
                  nomeDiv.textContent = data.user.name;
                }
              }

            }

            bootstrap.Modal.getInstance(
              document.getElementById('modalNovoUser')
            ).hide();

            document.getElementById('formNovoUser').reset();

          } else {

            showToast(
              'Erro',
              data.message || 'Não foi possível guardar o utilizador.',
              'danger'
            );

          }

        })
        .catch(() => {

          btn.innerHTML = orig;
          btn.disabled = false;

          showToast(
            'Erro de ligação',
            'Não foi possível comunicar com o servidor.',
            'danger'
          );

        });



    });


    // Adiciona a linha depois do insert do novo usuario
    function adicionarLinhaTabela(user) {

      const tbody = document.getElementById('tabela-utilizadores');

      const tr = document.createElement('tr');

      tr.setAttribute('data-nome', user.name.toLowerCase());

      tr.setAttribute('data-nivel', user.nivel.toLowerCase());
      tr.setAttribute('data-estado', user.estado.toLowerCase());

      tr.innerHTML = `
        <td>
            <div class="user-cell">
                <img class="user-avatar-sm"
                  src="{{ !empty($user->foto) ? asset('uploads/users/' . $user->foto) : asset('uploads/users/default-user.png') }}"
                  alt="Foto" style="width:40px;height:40px;border-radius:50%;object-fit:cover;"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='inline-flex';">

                <div>
                    <div style="font-weight:600;">${user.name}</div>
                    <div style="font-size:11px;color:var(--text-light);">
                        Criado agora
                    </div>
                </div>

            </div>
        </td>

        <td>${user.email}</td>
        <td>${user.nivel}</td>
        <td>${user.estado}</td>
        <td>Nunca</td>

        <td style="text-align:center;">
            <div style="display:flex;gap:6px;justify-content:center;">

              <button class="topbar-icon-btn btn-editar-user" title="Editar" data-id="{{$user->id}}">
                 <i class="bi bi-pencil-fill"></i>
              </button>
                           
              <button class="topbar-icon-btn btn-delete-user" title="Apagar utilizador"
                 data-id="{{$user->id}}"
                 style="width:30px;height:30px;font-size:14px;background:#FFEBEE;color:#C62828;"><i
                 class="bi bi-person-x-fill"></i>
             </button>

            </div>
        </td>
    `;

      // adiciona primeiro
      tbody.appendChild(tr);

      //  ordena depois do insert
      ordenarTabelaUsuarios();
    }

    // Ordena a linha adicionada no inisert
    function ordenarTabelaUsuarios() {

      const tbody = document.getElementById('tabela-utilizadores');

      const rows = Array.from(tbody.querySelectorAll('tr'));

      rows.sort((a, b) => {

        const nomeA = a.querySelector('.user-cell div div').textContent.toLowerCase();
        const nomeB = b.querySelector('.user-cell div div').textContent.toLowerCase();

        return nomeA.localeCompare(nomeB);
      });

      // reanexa na ordem correta
      rows.forEach(row => tbody.appendChild(row));
    }

    // Força de senha — modal reset
    function avaliarSenhaReset(val) {
      const fill = document.getElementById('resetPwdFill');
      const label = document.getElementById('resetPwdLabel');
      let score = 0;
      if (val.length >= 8) score++;
      if (/[A-Z]/.test(val)) score++;
      if (/[0-9]/.test(val)) score++;
      if (/[^A-Za-z0-9]/.test(val)) score++;
      const configs = [
        { w: '0%', color: 'var(--border)', text: 'Introduza a nova senha' },
        { w: '25%', color: '#C62828', text: 'Fraca' },
        { w: '50%', color: '#F57F17', text: 'Razoável' },
        { w: '75%', color: '#1565C0', text: 'Boa' },
        { w: '100%', color: '#2E7D32', text: 'Forte' },
      ];
      const c = configs[score] || configs[0];
      fill.style.width = c.w; fill.style.background = c.color;
      label.textContent = c.text; label.style.color = c.color;
      verificarSenhaReset();
    }

    function verificarSenhaReset() {
      const pwd = document.getElementById('novaSenha').value;
      const conf = document.getElementById('novaSenhaConfirm').value;
      const msg = document.getElementById('resetMatchMsg');
      if (!conf) { msg.textContent = ''; return; }
      if (pwd === conf) { msg.textContent = '✓ As senhas coincidem'; msg.style.color = '#2E7D32'; }
      else { msg.textContent = '✗ As senhas não coincidem'; msg.style.color = '#C62828'; }
    }

    function togglePwdReset(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      input.type = input.type === 'password' ? 'text' : 'password';
      icon.className = input.type === 'password' ? 'bi bi-eye-fill' : 'bi bi-eye-slash-fill';
    }

    console.log("Caregado com sucesso")

  </script>



  <script>

    class PaginationManager {
      constructor(containerId = 'pagination-buttons', infoId = 'pagination-info', tbodyId = 'tabela-utilizadores') {
        this.container = document.getElementById(containerId);
        this.infoElement = document.getElementById(infoId);
        this.tbody = document.getElementById(tbodyId);
        this.currentPage = 1;
        this.lastPage = 1;
        this.total = 0;
        this.from = 0;
        this.to = 0;
      }

      // Buscar dados e atualizar paginação
      async loadPage(page = 1) {
        try {
          const response = await fetch(`/users?page=${page}`, {
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          const data = await response.json();

          // Armazenar informações de paginação
          this.currentPage = data.current_page;
          this.lastPage = data.last_page;
          this.total = data.total;
          this.from = data.from;
          this.to = data.to;

          // Renderizar usuários na tabela
          this.renderUsers(data.data);

          // Atualizar UI de paginação
          this.renderPagination();
          this.updateInfo();

          // Scroll suave para a tabela
          document.querySelector('.users-table').scrollIntoView({ behavior: 'smooth' });

        } catch (error) {
          console.error('Erro ao carregar página:', error);
        }
      }

      // Renderizar usuários na tabela (mantendo sua estrutura HTML)
      renderUsers(users) {
        if (!this.tbody) return;

        this.tbody.innerHTML = users.map(user => `
      <tr id="user-row-${user.id}" data-nivel="${user.nivel.toLowerCase()}" data-estado="${user.estado.toLowerCase()}">
        <td>
          <div class="user-cell">
            <img class="user-avatar-sm"
              src="${user.foto ? '/uploads/users/' + user.foto : '/uploads/users/default-user.png'}"
              alt="Foto" 
              style="width:40px;height:40px;border-radius:50%;object-fit:cover;"
              onerror="this.style.display='none';this.nextElementSibling.style.display='inline-flex';">
            
            <div class="user-avatar-sm" style="display:none;">
              ${user.name.charAt(0).toUpperCase()}
            </div>
            
            <div>
              <div style="font-weight:600;">${user.name}</div>
              <div style="font-size:11px;color:var(--text-light);">
                Criado em ${this.formatDatePT(user.created_at, 'abr Y')}
              </div>
            </div>
          </div>
        </td>
        <td>${user.email}</td>
        <td>${user.nivel}</td>
        <td>${user.estado}</td>
        <td>${user.ultimo_acesso ? this.formatDatePT(user.ultimo_acesso) : 'Nunca'}</td>
        <td style="text-align:center;">
          <div style="display:flex;gap:6px;justify-content:center;">
            <button class="topbar-icon-btn btn-editar-user" title="Editar" data-id="${user.id}">
              <i class="bi bi-pencil-fill"></i>
            </button>
            <button class="topbar-icon-btn btn-delete-user" title="Apagar utilizador"
              data-id="${user.id}"
              style="width:30px;height:30px;font-size:14px;background:#FFEBEE;color:#C62828;">
              <i class="bi bi-person-x-fill"></i>
            </button>
          </div>
        </td>
      </tr>
    `).join('');

        // Re-anexar event listeners aos botões de ação
        this.attachEventListeners();
      }

      // Anexar event listeners aos botões (editar e deletar)
      attachEventListeners() {
        this.attachDeleteListeners();
        this.attachEditListeners();
      }

      // ============= DELETE USER =============
      attachDeleteListeners() {
        document.querySelectorAll('.btn-delete-user').forEach(btn => {
          btn.addEventListener('click', function () {

            const id = this.dataset.id;

            if (!confirm('Tens a certeza que queres eliminar este utilizador?')) return;

            fetch(`/users/${id}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
              }
            })
              .then(res => res.json())
              .then(data => {
                if (data.success) {
                  // Remove a linha da tabela
                  document.getElementById(`user-row-${id}`).remove();

                  // Recarrega a página se ficou vazia
                  setTimeout(() => {
                    window.paginationManager.loadPage(window.paginationManager.currentPage);
                  }, 300);

                } else {
                  alert(data.message);
                }
              })
              .catch(err => console.error(err));
          });
        });
      }

      // ============= EDIT USER =============
      attachEditListeners() {
        document.querySelectorAll('.btn-editar-user').forEach(btn => {

          btn.addEventListener('click', function () {

            const id = this.dataset.id;

            fetch(`/users/${id}`)
              .then(r => r.json())
              .then(user => {

                modoUser = 'edit';

                if (modoUser === 'edit') {

                  document.getElementById('modalNovoUserLabel').textContent =
                    'Editar Utilizador';

                  document.getElementById('btnGuardarUserLabel').textContent =
                    'Actualizar Utilizador';
                }

                // Preenche os campos do formulário
                document.getElementById('userId').value = user.id;
                document.getElementById('userName').value = user.name;
                document.getElementById('userEmail').value = user.email;
                document.getElementById('userTelefone').value = user.telefone ?? '';
                document.getElementById('userNivel').value = user.nivel;
                document.getElementById('userEstado').value = user.estado;

                // Limpa os campos de password
                document.getElementById('userPassword').value = '';
                document.getElementById('userPasswordConfirm').value = '';

                // Abre o modal
                const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNovoUser'));
                modal.show();

              })
              .catch(err => console.error('Erro ao carregar utilizador:', err));

          });

        });
      }

      // Atualizar texto de informações
      updateInfo() {
        const text = this.total > 0
          ? `Mostrando ${this.from} a ${this.to} de ${this.total} utilizadores`
          : 'Nenhum utilizador encontrado';

        this.infoElement.textContent = text;
      }

      // Renderizar botões de paginação
      renderPagination() {
        this.container.innerHTML = '';

        // Botão Anterior
        const prevBtn = this.createButton(
          '<i class="bi bi-chevron-left"></i>',
          'btn-outline-green',
          () => this.loadPage(this.currentPage - 1),
          this.currentPage === 1
        );
        this.container.appendChild(prevBtn);

        // Números de página
        const pagesRange = this.getPagesToShow();
        pagesRange.forEach(pageNum => {
          const isActive = pageNum === this.currentPage;
          const btn = this.createButton(
            pageNum.toString(),
            isActive ? 'btn-green' : 'btn-outline-green',
            () => this.loadPage(pageNum),
            false
          );
          this.container.appendChild(btn);
        });

        // Botão Próximo
        const nextBtn = this.createButton(
          '<i class="bi bi-chevron-right"></i>',
          'btn-outline-green',
          () => this.loadPage(this.currentPage + 1),
          this.currentPage === this.lastPage
        );
        this.container.appendChild(nextBtn);
      }

      // Criar botão com evento
      createButton(text, className, onClick, disabled = false) {
        const btn = document.createElement('button');
        btn.innerHTML = text;
        btn.className = className;
        btn.style.cssText = 'padding:6px 12px;font-size:12px;';
        btn.disabled = disabled;
        btn.onclick = (e) => {
          e.preventDefault();
          if (!disabled) onClick();
        };
        return btn;
      }

      // Determinar quais páginas mostrar (máx 5)
      getPagesToShow() {
        const pages = [];
        const maxPagesToShow = 5;
        let startPage = Math.max(1, this.currentPage - 2);
        let endPage = Math.min(this.lastPage, startPage + maxPagesToShow - 1);

        if (endPage - startPage < maxPagesToShow - 1) {
          startPage = Math.max(1, endPage - maxPagesToShow + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
          pages.push(i);
        }

        return pages;
      }

      // Função para formatar datas em Português
      formatDatePT(dateString, format = 'completo') {
        const date = new Date(dateString);

        const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

        const dia = String(date.getDate()).padStart(2, '0');
        const mes = meses[date.getMonth()];
        const ano = date.getFullYear();
        const hora = String(date.getHours()).padStart(2, '0');
        const minuto = String(date.getMinutes()).padStart(2, '0');

        if (format === 'abr Y') {
          return `${mes} ${ano}`;
        }

        // Formato completo: dd/MMM/Y, HH:mm
        return `${dia}/${mes}/${ano}, ${hora}:${minuto}`;
      }
    }

    // Inicializar quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', () => {
      window.paginationManager = new PaginationManager();
      window.paginationManager.loadPage(1); // Carregar primeira página
    });
  </script>

  <!-- ══════════════════════════════════════
       MODAL — REGISTAR / EDITAR ANO AGRÍCOLA
  ══════════════════════════════════════ -->
  <div class="modal fade" id="modalAnoAgricola" tabindex="-1" aria-labelledby="modalAnoLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
      <div class="modal-content"
        style="border:none;border-radius:18px;box-shadow:0 24px 64px rgba(0,0,0,.15);overflow:hidden;display:flex;flex-direction:column;">

        <!-- Header -->
        <div class="modal-header"
          style="padding:11px 20px;border-bottom:1px solid var(--border);background:linear-gradient(135deg,var(--sidebar-bg) 0%,var(--primary) 100%);flex-shrink:0;">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div
              style="width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:17px;color:#fff;">
              <i class="bi bi-calendar2-range-fill" id="modalAnoIcon"></i>
            </div>
            <div>
              <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:700;color:#fff;" id="modalAnoLabel">
                Registar Ano Agrícola</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"
            style="filter:brightness(0) invert(1);opacity:.8;"></button>
        </div>

        <!-- Body -->
        <div class="modal-body" style="padding:24px;background:var(--page-bg);overflow-y:auto;">
          <form id="formAnoAgricola" novalidate>
            @csrf
            <input type="hidden" id="anoId" name="id" value="">

            <div class="mf-card"
              style="background:var(--card-bg);border-radius:14px;border:1px solid var(--border);padding:20px 22px;margin-bottom:16px;">
              <div
                style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--text-light);margin-bottom:14px;padding-bottom:8px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;">
                <i class="bi bi-calendar-event-fill" style="font-size:13px;color:var(--primary);"></i> Dados do Ano
                Agrícola
              </div>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cfg-label" for="anoNome">Nome do Ano Agrícola *</label>
                  <input class="cfg-input" type="text" id="anoNome" name="nome" placeholder="Ex: Ano Agrícola 2025/2026"
                    required>
                  <div class="cfg-helper">Designação que identifica este período no sistema</div>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label" for="anoInicio">Data de Início *</label>
                  <input class="cfg-input" type="date" id="anoInicio" name="data_inicio" required>
                </div>
                <div class="col-12 col-md-6">
                  <label class="cfg-label" for="anoFim">Data de Fim *</label>
                  <input class="cfg-input" type="date" id="anoFim" name="data_fim" required>
                </div>
                <div class="col-12">
                  <label class="cfg-label" for="anoEstado">Estado *</label>
                  <select class="cfg-select" id="anoEstado" name="estado" required>
                    <option value="">Seleccione o estado…</option>
                    <option value="iniciado">Iniciado</option>
                    <option value="em_producao">Em Produção</option>
                    <option value="finalizado">Finalizado</option>
                  </select>
                  <div class="cfg-helper">Só pode existir um ano <strong>Em Produção</strong> de cada vez</div>
                </div>
              </div>
            </div>
          </form>
        </div>

        <!-- Footer -->
        <div class="modal-footer"
          style="padding:14px 20px;border-top:1px solid var(--border);background:#fff;flex-shrink:0;">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i> Cancelar
              </button>
              <button type="button" class="btn-green" id="btnGuardarAno">
                <i class="bi bi-check2-circle"></i>
                <span id="btnGuardarAnoLabel">Registar Ano</span>
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- /MODAL ANO AGRÍCOLA -->

  <script>
    /* ══════════════════════════════════════
       FUNÇÃO UTILITÁRIA — Formatar datas
    ══════════════════════════════════════ */
    function formatDateDisplay(dateStr) {
      if (!dateStr) return '';
      dateStr = String(dateStr).trim();
      const iso = dateStr.match(/^(\d{4})-(\d{2})-(\d{2})/);
      if (iso) return `${iso[3]}/${iso[2]}/${iso[1]}`;
      const dmy = dateStr.match(/^(\d{2})[\/\-](\d{2})[\/\-](\d{4})$/);
      if (dmy) return `${dmy[1]}/${dmy[2]}/${dmy[3]}`;
      const d = new Date(dateStr);
      if (!isNaN(d)) {
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();
        return `${day}/${month}/${year}`;
      }
      return dateStr;
    }

    function normalizeToISO(dateStr) {
      if (!dateStr) return '';
      dateStr = String(dateStr).trim();
      // Se já está em YYYY-MM-DD
      if (/^\d{4}-\d{2}-\d{2}/.test(dateStr)) {
        return dateStr.substring(0, 10);
      }
      // Se é ISO com hora (YYYY-MM-DDTHH:mm:ss)
      const isoMatch = dateStr.match(/^(\d{4}-\d{2}-\d{2})/);
      if (isoMatch) return isoMatch[1];
      // Se é DD/MM/YYYY
      const dmy = dateStr.match(/^(\d{2})[\/\-](\d{2})[\/\-](\d{4})$/);
      if (dmy) return `${dmy[3]}-${dmy[2]}-${dmy[1]}`;
      return '';
    }

    function parseDateForInput(dateStr) {
      return normalizeToISO(dateStr);
    }

    /* ══════════════════════════════════════
       ANO AGRÍCOLA — reset modal ao abrir (novo)
    ══════════════════════════════════════ */
    document.getElementById('modalAnoAgricola').addEventListener('show.bs.modal', function (e) {
      if (e.relatedTarget && e.relatedTarget.id === 'btnIniciarAno') {
        document.getElementById('formAnoAgricola').reset();
        document.getElementById('anoId').value = '';
        document.getElementById('modalAnoLabel').textContent = 'Registar Ano Agrícola';
        document.getElementById('btnGuardarAnoLabel').textContent = 'Registar Ano';
      }
    });

    /* ══════════════════════════════════════
       ANO AGRÍCOLA — botão editar
    ══════════════════════════════════════ */
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-editar-ano');
      if (!btn) return;

      const anoInicio = parseDateForInput(btn.dataset.inicio || '');
      const anoFim = parseDateForInput(btn.dataset.fim || '');

      document.getElementById('anoId').value = btn.dataset.id || '';
      document.getElementById('anoNome').value = btn.dataset.nome || '';
      document.getElementById('anoInicio').value = anoInicio;
      document.getElementById('anoFim').value = anoFim;
      document.getElementById('anoEstado').value = btn.dataset.estado || '';
      document.getElementById('modalAnoLabel').textContent = 'Editar Ano Agrícola';
      document.getElementById('btnGuardarAnoLabel').textContent = 'Guardar Alterações';

      new bootstrap.Modal(document.getElementById('modalAnoAgricola')).show();
    });

    /* ══════════════════════════════════════
       ANO AGRÍCOLA — guardar (criar / editar)
    ══════════════════════════════════════ */
    document.getElementById('btnGuardarAno').addEventListener('click', () => {
      const id = document.getElementById('anoId').value;
      const nome = document.getElementById('anoNome').value.trim();
      const inicio = document.getElementById('anoInicio').value;
      const fim = document.getElementById('anoFim').value;
      const estado = document.getElementById('anoEstado').value;

      if (!nome || !inicio || !fim || !estado) {
        showToast('Campos obrigatórios em falta', 'Preencha todos os campos marcados com *.');
        return;
      }
      if (fim < inicio) {
        showToast('Datas inválidas', 'A data de fim não pode ser anterior à data de início.');
        return;
      }

      const btn = document.getElementById('btnGuardarAno');
      const orig = btn.innerHTML;
      btn.innerHTML = '<i class="bi bi-hourglass-split"></i> A guardar…';
      btn.disabled = true;

      const url = id ? `/ano_agricola/${id}` : '/ano_agricola';
      const method = id ? 'PUT' : 'POST';

      fetch(url, {
        method,
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
        },
        body: JSON.stringify({ nome, data_inicio: inicio, data_fim: fim, estado })
      })
        .then(r => r.json())
        .then(data => {
          btn.innerHTML = orig;
          btn.disabled = false;

          if (data.success) {

            bootstrap.Modal.getInstance(
              document.getElementById('modalAnoAgricola')
            ).hide();

            const ano = data.data;

            // Normaliza as datas do servidor para ISO (YYYY-MM-DD)
            const dataInicioISO = normalizeToISO(ano.data_inicio);
            const dataFimISO = normalizeToISO(ano.data_fim);

            let estadoHtml = '';

            if (ano.estado === 'em_producao') {
              estadoHtml = `
            <span style="font-size:11px;font-weight:600;background:#E8F5E9;color:#2E7D32;padding:3px 10px;border-radius:20px;">
                Em Produção
            </span>
            `;
            } else if (ano.estado === 'iniciado') {
              estadoHtml = `
            <span style="font-size:11px;font-weight:600;background:#FFF8E1;color:#F57F17;padding:3px 10px;border-radius:20px;">
                Iniciado
            </span>
            `;
            } else {
              estadoHtml = `
            <span style="font-size:11px;font-weight:600;background:#F5F5F5;color:#757575;padding:3px 10px;border-radius:20px;">
                Finalizado
            </span>
            `;
            }

            const linha = `
          <tr id="ano-row-${ano.id}">
              <td>
                <div style="font-weight:600;">
                    ${ano.nome}
                </div>
                <div style="font-size:11px;color:var(--text-light);">
                    ID #${ano.id}
                </div>
              </td>
              <td>${formatDateDisplay(ano.data_inicio)}</td>
              <td>${formatDateDisplay(ano.data_fim)}</td>
              <td>${estadoHtml}</td>
              <td>${new Date().toLocaleDateString('pt-PT')}</td>
              <td style="text-align:center;">
                <div style="display:flex;gap:6px;justify-content:center;">
                  <button
                      class="topbar-icon-btn btn-editar-ano"
                      data-id="${ano.id}"
                      data-nome="${ano.nome}"
                      data-inicio="${dataInicioISO}"
                      data-fim="${dataFimISO}"
                      data-estado="${ano.estado}">
                      <i class="bi bi-pencil-fill"></i>
                  </button>
                  <button
                      class="topbar-icon-btn btn-eliminar-ano"
                      data-id="${ano.id}">
                      <i class="bi bi-trash-fill"></i>
                  </button>
                </div>
              </td>
          </tr>
          `;

            const tbody = document.querySelector('#tabelaAnosAgricolas tbody');
            const existingRow = document.getElementById(`ano-row-${ano.id}`);

            if (existingRow) {
              // Edição: substitui a linha existente
              existingRow.outerHTML = linha;
            } else {
              // Novo: insere no início da tabela
              tbody.insertAdjacentHTML('afterbegin', linha);
            }

            showToast(
              id
                ? 'Ano Agrícola actualizado'
                : 'Ano Agrícola registado',
              nome + (
                id
                  ? ' foi actualizado com sucesso.'
                  : ' foi adicionado ao sistema.'
              )
            );
          } else {
            showToast('Erro ao guardar', data.message || 'Verifique os dados e tente novamente.');
          }
        })
        .catch(() => {
          btn.innerHTML = orig;
          btn.disabled = false;
          showToast('Erro de ligação', 'Verifique a sua conexão.');
        });
    });

    /* ══════════════════════════════════════
       ANO AGRÍCOLA — eliminar
    ══════════════════════════════════════ */
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-eliminar-ano');
      if (!btn) return;

      const id = btn.dataset.id;
      if (!confirm('Tem a certeza que deseja eliminar este Ano Agrícola? Esta acção é irreversível.')) return;

      fetch(`/ano_agricola/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
        }
      })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            btn.closest('tr').remove();
            showToast('Ano Agrícola eliminado', 'O registo foi removido do sistema.');
          } else {
            showToast('Erro', data.message || 'Não foi possível eliminar.');
          }
        })
        .catch(() => showToast('Erro de ligação', 'Verifique a sua conexão.'));
    });
  </script>



</body>

</html>