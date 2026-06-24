<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIAG – Dashboard</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"> --}}

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}"> --}}

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap"
    rel="stylesheet" />
    
  <link rel="stylesheet" href="{{ asset('assets/fonts/font-primary.css') }}">

  <!-- ApexCharts -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="{{ asset('assets/js/apexcharts.js') }}" defer></script>

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

    /* ── SIDEBAR ─────────────────────────────── */
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
      overflow: hidden;
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

    /* nav items */
    .sidebar-nav {
      flex: 1;
      padding: 12px 0;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .sidebar-nav::-webkit-scrollbar {
      width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
      background: transparent;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, .18);
      border-radius: 10px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, .35);
    }

    /* Firefox */
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

    /* centrar ícone quando sidebar está em modo só-ícones */
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

    /* sidebar bottom / user */
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

    /* ── TOPBAR ──────────────────────────────── */
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

    /* ── MAIN CONTENT ────────────────────────── */
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

    /* ── PAGE HEADER ─────────────────────────── */
    .page-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 24px;
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

    /* ── STAT CARDS ──────────────────────────── */
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

    .stat-icon.red {
      background: #FFEBEE;
      color: #C62828;
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

    .stat-badge.down {
      background: #FFEBEE;
      color: #C62828;
    }

    /* ── CHART CARDS ─────────────────────────── */
    .chart-card {
      background: var(--card-bg);
      border-radius: 16px;
      padding: 22px 20px;
      border: 1px solid var(--border);
    }

    .chart-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
    }

    .chart-card-header h5 {
      font-family: 'Sora', sans-serif;
      font-size: 15px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .chart-card-header span {
      font-size: 12px;
      color: var(--text-light);
    }

    /* ── TABS ────────────────────────────────── */
    .area-tabs .nav-link {
      font-size: 13.5px;
      font-weight: 500;
      color: var(--text-mid);
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      transition: background .15s, color .15s;
    }

    .area-tabs .nav-link.active,
    .area-tabs .nav-link:hover {
      background: var(--accent-lt);
      color: var(--primary);
    }

    /* ── TABLE CARD ──────────────────────────── */
    .table-card {
      background: var(--card-bg);
      border-radius: 16px;
      border: 1px solid var(--border);
      overflow: hidden;
    }

    .table-card-header {
      padding: 18px 22px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border);
    }

    .table-card-header h5 {
      font-family: 'Sora', sans-serif;
      font-size: 15px;
      font-weight: 600;
    }

    .table> :not(caption)>*>* {
      padding: 14px 22px;
    }

    .table thead th {
      font-size: 11.5px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .8px;
      color: var(--text-light);
      background: #FAFBFA;
      border-bottom: 1px solid var(--border);
    }

    .table tbody td {
      font-size: 13.5px;
      color: var(--text-dark);
      border-bottom: 1px solid var(--border);
    }

    .table tbody tr:last-child td {
      border-bottom: none;
    }

    .table tbody tr:hover td {
      background: #F8FBF8;
    }

    .badge-status {
      font-size: 11.5px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 30px;
    }

    .badge-status.pago {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .badge-status.pendente {
      background: #FFF8E1;
      color: #F57F17;
    }

    .badge-status.atraso {
      background: #FFEBEE;
      color: #C62828;
    }

    /* ── QUICK ACTIONS ───────────────────────── */
    .quick-card {
      background: var(--card-bg);
      border-radius: 16px;
      padding: 18px;
      border: 1px solid var(--border);
      text-align: center;
      cursor: pointer;
      transition: box-shadow .2s, transform .2s, background .2s;
      text-decoration: none;
    }

    .quick-card:hover {
      box-shadow: 0 8px 24px rgba(46, 125, 50, .12);
      transform: translateY(-3px);
      background: var(--accent-lt);
    }

    .quick-card i {
      font-size: 26px;
      color: var(--primary);
      display: block;
      margin-bottom: 8px;
    }

    .quick-card span {
      font-size: 12.5px;
      font-weight: 500;
      color: var(--text-mid);
    }

    /* ── WEATHER MINI CARD ───────────────────── */
    .weather-card {
      background: linear-gradient(135deg, #2E7D32, #66BB6A);
      border-radius: 16px;
      padding: 20px;
      color: #fff;
    }

    .weather-card .w-city {
      font-size: 12px;
      opacity: .8;
      margin-bottom: 6px;
    }

    .weather-card .w-temp {
      font-family: 'Sora', sans-serif;
      font-size: 36px;
      font-weight: 700;
    }

    .weather-card .w-desc {
      font-size: 13px;
      opacity: .85;
      margin-top: 4px;
    }

    .weather-card .w-extras {
      display: flex;
      gap: 14px;
      margin-top: 14px;
    }

    .weather-card .w-extras div {
      font-size: 12px;
      opacity: .85;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    /* ── CALENDAR MINI ───────────────────────── */
    .calendar-card {
      background: var(--card-bg);
      border-radius: 16px;
      padding: 18px;
      border: 1px solid var(--border);
    }

    .calendar-card h6 {
      font-family: 'Sora', sans-serif;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 12px;
      color: var(--text-dark);
    }

    .event-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 0;
      border-bottom: 1px solid var(--border);
    }

    .event-item:last-child {
      border-bottom: none;
    }

    .event-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    .event-item .e-title {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-dark);
    }

    .event-item .e-date {
      font-size: 11.5px;
      color: var(--text-light);
    }

    /* ── Animations ──────────────────────────── */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(16px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .anim {
      animation: fadeUp .45s ease both;
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

    .anim-d5 {
      animation-delay: .25s;
    }

    .anim-d6 {
      animation-delay: .30s;
    }

    /* ── BOOTSTRAP TOOLTIP CUSTOMIZADO ──────── */
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

    /* ── DARK MODE ───────────────────────────── */
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

    body.dark-mode .table thead th {
      background: #1a2a1c;
    }

    body.dark-mode .table tbody tr:hover td {
      background: #1a2a1c;
    }

    body.dark-mode .breadcrumb-item.active {
      color: #6a8a6e !important;
    }

    /* ── TOPBAR USER DROPDOWN ────────────────── */
    .topbar-user {
      position: relative;
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

    @media (max-width: 768px) {
      :root {
        --sidebar-w: 240px;
      }

      body:not(.sidebar-hidden) #sidebar {
        box-shadow: 4px 0 20px rgba(0, 0, 0, .2);
      }

      body {}

      body.default #sidebar {
        width: 0;
      }

      body.default #main {
        margin-left: 0;
      }

      body.default #topbar {
        left: 0;
      }
    }
  </style>
</head>

<body>

  <!-- ══ SIDEBAR ══════════════════════════════════════ -->
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

      <a href="#" class="nav-item-link active" data-label="Dashboard">
        <i class="bi bi-grid-1x2-fill"></i>
        <span class="nav-label">Dashboard</span>
      </a>
      <a href="{{route('cooperativas')}}" class="nav-item-link" data-label="Cooperativa">
        <i class="bi bi-building"></i>
        <span class="nav-label">Cooperativa</span>
      </a>
      <a href="{{route('agricultores.index')}}" class="nav-item-link" data-label="Agricultores">
        <i class="bi bi-people-fill"></i>
        <span class="nav-label">Agricultores</span>
      </a>

      <div class="nav-section-title">Agrícola</div>

      <a href="{{route('safras.painel')}}" class="nav-item-link" data-label="Safras">
        <i class="bi bi-flower2"></i>
        <span class="nav-label">Safras</span>
      </a>
      <a  href="{{route('talhoes.index')}}" class="nav-item-link" data-label="Talhões">
        <i class="bi bi-map-fill"></i>
        <span class="nav-label">Talhões</span>
      </a>
      <a href="{{route('insumos.index')}}" class="nav-item-link" data-label="Insumos">
        <i class="bi bi-box-seam-fill"></i>
        <span class="nav-label">Insumos</span>
      </a>

      <div class="nav-section-title">Financeiro</div>

      <a href="#" class="nav-item-link" data-label="Contas a Pagar">
        <i class="bi bi-arrow-down-circle-fill"></i>
        <span class="nav-label">Contas a Pagar</span>
      </a>
      <a href="#" class="nav-item-link" data-label="Contas a Receber">
        <i class="bi bi-arrow-up-circle-fill"></i>
        <span class="nav-label">Contas a Receber</span>
      </a>
      <a href="#" class="nav-item-link" data-label="Fluxo de Caixa">
        <i class="bi bi-cash-stack"></i>
        <span class="nav-label">Fluxo de Caixa</span>
      </a>

      <div class="nav-section-title">Comercial</div>

      <a href="#" class="nav-item-link" data-label="Vendas">
        <i class="bi bi-cart-fill"></i>
        <span class="nav-label">Vendas</span>
      </a>
      <a href="#" class="nav-item-link" data-label="Contratos">
        <i class="bi bi-file-earmark-text-fill"></i>
        <span class="nav-label">Contratos</span>
      </a>

      <div class="nav-section-title">Sistema</div>

      <a href="#" class="nav-item-link" data-label="Relatórios">
        <i class="bi bi-bar-chart-fill"></i>
        <span class="nav-label">Relatórios</span>
      </a>
      <a href="{{route('configuracoes')}}" class="nav-item-link" data-label="Configurações">
        <i class="bi bi-gear-fill"></i>
        <span class="nav-label">Configurações</span>
      </a>
    </div>

    <div class="sidebar-user">
      <div class="avatar"><i class="bi bi-person-fill"></i></div>
      <div class="user-info">
        <div class="u-name">Admin SIAG</div>
        <div class="u-role">Gestor · Viana</div>
      </div>
    </div>
  </nav>

  <!-- ══ TOPBAR ════════════════════════════════════════ -->
  <header id="topbar">
    <button class="topbar-toggle" id="sidebarToggle" title="Toggle Sidebar">
      <i class="bi bi-list"></i>
    </button>

    <span class="topbar-title">Dashboard</span>

    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="d-none d-md-flex ms-3">
      <ol class="breadcrumb mb-0" style="font-size:12.5px;">
        <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">SIAG</a></li>
        <li class="breadcrumb-item active" style="color:var(--text-light);">Dashboard</li>
      </ol>
    </nav>

    <div class="topbar-right">
      <!-- safra badge -->
      <span class="badge rounded-pill d-none d-md-inline-flex align-items-center gap-1"
        style="background:var(--accent-lt);color:var(--primary);font-size:12px;padding:7px 13px;font-weight:600;">
        <i class="bi bi-calendar3"></i> Safra 2024/25
      </span>

      <button class="topbar-icon-btn" title="Notificações">
        <i class="bi bi-bell-fill"></i>
        <span class="notif-badge"></span>
      </button>

      <button class="topbar-icon-btn" title="Mensagens">
        <i class="bi bi-chat-dots-fill"></i>
      </button>

      <div class="dropdown d-none d-sm-flex">
        <div class="topbar-user" data-bs-toggle="dropdown" data-bs-offset="0,4" role="button">
          <div class="t-avatar">
              <img id="dropdownAvatarLarge" 
               src="{{ Auth::check() ? Auth::user()->foto_url : asset('uploads/users/default-user.png') }}" 
               alt="Foto-perfil"  width="20" class="avatar-md">
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

  <!-- ══ MAIN ══════════════════════════════════════════ -->
  <main id="main">
    <div class="content-inner">

      <!-- page header -->
      <div class="page-header anim">
        <div>
          <h1>Áreas de Trabalho</h1>
          <p>Visão geral da Cooperativa Viana — Safra 2024/25</p>
        </div>
        <button class="btn-green">
          <i class="bi bi-plus-lg"></i> Nova Atividade
        </button>
      </div>

      <!-- area tabs -->
      <ul class="nav area-tabs mb-4 anim anim-d1">
        <li class="nav-item">
          <a class="nav-link active" href="#">
            <i class="bi bi-currency-dollar me-1"></i> Financeiro
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="bi bi-shop me-1"></i> Comercial
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="bi bi-tree me-1"></i> Agrícola
          </a>
        </li>
      </ul>

      <!-- stat cards row -->
      <div class="row g-3 mb-4 anim anim-d2">
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-info">
              <div class="s-label">Receita Total</div>
              <div class="s-value">Kz 4.2M</div>
              <span class="stat-badge up"><i class="bi bi-arrow-up"></i> 12.4%</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Cooperados Activos</div>
              <div class="s-value">348</div>
              <span class="stat-badge up"><i class="bi bi-arrow-up"></i> 5 novos</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon amber"><i class="bi bi-box-seam-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Produção (ton)</div>
              <div class="s-value">1.153</div>
              <span class="stat-badge up"><i class="bi bi-arrow-up"></i> 8.7%</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-exclamation-circle-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Pagtos em Atraso</div>
              <div class="s-value">23</div>
              <span class="stat-badge down"><i class="bi bi-arrow-up"></i> +3</span>
            </div>
          </div>
        </div>
      </div>

      <!-- charts row -->
      <div class="row g-3 mb-4 anim anim-d3">

        <!-- line chart -->
        <div class="col-12 col-lg-8">
          <div class="chart-card">
            <div class="chart-card-header">
              <h5><i class="bi bi-graph-up me-2" style="color:var(--primary)"></i>Fluxo de Caixa — 2025</h5>
              <span>Últimos 12 meses</span>
            </div>
            <div id="chart-cashflow"></div>
          </div>
        </div>

        <!-- donut chart -->
        <div class="col-12 col-lg-4">
          <div class="chart-card">
            <div class="chart-card-header">
              <h5><i class="bi bi-pie-chart-fill me-2" style="color:var(--primary)"></i>Desembolsos</h5>
              <span>Safra 24/25</span>
            </div>
            <div id="chart-donut"></div>
          </div>
        </div>

      </div>

      <!-- bottom row -->
      <div class="row g-3 anim anim-d4">

        <!-- recent transactions table -->
        <div class="col-12 col-xl-7">
          <div class="table-card">
            <div class="table-card-header">
              <h5><i class="bi bi-receipt me-2" style="color:var(--primary)"></i>Últimas Transacções</h5>
              <button class="btn-green" style="padding:6px 14px;font-size:12.5px;">
                Ver Todos
              </button>
            </div>
            <div class="table-responsive">
              <table class="table mb-0">
                <thead>
                  <tr>
                    <th>Descrição</th>
                    <th>Cooperado</th>
                    <th>Valor</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><i class="bi bi-flower2 text-success me-1"></i> Sementes Milho</td>
                    <td>João Ferreira</td>
                    <td class="fw-600">Kz 120.000</td>
                    <td><span class="badge-status pago">Pago</span></td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-droplet-fill text-primary me-1"></i> Fertilizantes</td>
                    <td>Maria Silva</td>
                    <td class="fw-600">Kz 85.400</td>
                    <td><span class="badge-status pendente">Pendente</span></td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-truck-fill text-warning me-1"></i> Transporte</td>
                    <td>António Costa</td>
                    <td class="fw-600">Kz 45.000</td>
                    <td><span class="badge-status pago">Pago</span></td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-bug-fill text-danger me-1"></i> Defensivos</td>
                    <td>Rosa Neto</td>
                    <td class="fw-600">Kz 62.800</td>
                    <td><span class="badge-status atraso">Atraso</span></td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-gear-fill text-secondary me-1"></i> Maquinaria</td>
                    <td>Paulo Dias</td>
                    <td class="fw-600">Kz 195.000</td>
                    <td><span class="badge-status pago">Pago</span></td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-archive-fill me-1" style="color:var(--primary)"></i> Armazenagem</td>
                    <td>Inês Lemos</td>
                    <td class="fw-600">Kz 33.200</td>
                    <td><span class="badge-status pendente">Pendente</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- right column: weather + events + quick actions -->
        <div class="col-12 col-xl-5">
          <div class="row g-3">

            <!-- weather -->
            <div class="col-12">
              <div class="weather-card">
                <div class="w-city"><i class="bi bi-geo-alt-fill me-1"></i>Viana, Luanda</div>
                <div class="w-temp">28°C</div>
                <div class="w-desc">☀️ Ensolarado · Humidade 74%</div>
                <div class="w-extras">
                  <div><i class="bi bi-wind"></i> 12 km/h</div>
                  <div><i class="bi bi-droplet-half"></i> 74%</div>
                  <div><i class="bi bi-eye-fill"></i> 10 km</div>
                  <div><i class="bi bi-thermometer-half"></i> Máx 31°</div>
                </div>
              </div>
            </div>

            <!-- upcoming events -->
            <div class="col-12">
              <div class="calendar-card">
                <h6><i class="bi bi-calendar-event-fill me-2" style="color:var(--primary)"></i>Próximos Eventos</h6>
                <div class="event-item">
                  <div class="event-dot" style="background:#2E7D32;"></div>
                  <div>
                    <div class="e-title">Reunião Cooperados</div>
                    <div class="e-date">03 Jun · 09:00</div>
                  </div>
                </div>
                <div class="event-item">
                  <div class="event-dot" style="background:#1565C0;"></div>
                  <div>
                    <div class="e-title">Distribuição Insumos</div>
                    <div class="e-date">05 Jun · 07:30</div>
                  </div>
                </div>
                <div class="event-item">
                  <div class="event-dot" style="background:#F57F17;"></div>
                  <div>
                    <div class="e-title">Vencimento Contratos</div>
                    <div class="e-date">10 Jun · Prazo Final</div>
                  </div>
                </div>
                <div class="event-item">
                  <div class="event-dot" style="background:#C62828;"></div>
                  <div>
                    <div class="e-title">Colheita Prevista</div>
                    <div class="e-date">18 Jun · Início</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- quick actions -->
            <div class="col-12">
              <div class="chart-card">
                <div class="chart-card-header mb-2">
                  <h5><i class="bi bi-lightning-fill me-2" style="color:var(--primary)"></i>Acções Rápidas</h5>
                </div>
                <div class="row g-2">
                  <div class="col-3">
                    <a href="#" class="quick-card">
                      <i class="bi bi-person-plus-fill"></i>
                      <span>Cooperado</span>
                    </a>
                  </div>
                  <div class="col-3">
                    <a href="#" class="quick-card">
                      <i class="bi bi-file-earmark-plus-fill"></i>
                      <span>Contrato</span>
                    </a>
                  </div>
                  <div class="col-3">
                    <a href="#" class="quick-card">
                      <i class="bi bi-cash-coin"></i>
                      <span>Pagamento</span>
                    </a>
                  </div>
                  <div class="col-3">
                    <a href="#" class="quick-card">
                      <i class="bi bi-bar-chart-fill"></i>
                      <span>Relatório</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div><!-- /bottom row -->

    </div><!-- /content-inner -->
  </main>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  {{-- <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script> --}}

  <script>
    /* ── Sidebar toggle (3 states: full → icons-only → hidden → full) ── */
    const body = document.body;
    let state = 0; // 0=full, 1=icons-only, 2=hidden

    function applyTooltips() {
      // Destroy existing tooltips first
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
      state = (state + 1) % 3;
      body.classList.remove('icons-only', 'sidebar-hidden');
      if (state === 1) body.classList.add('icons-only');
      if (state === 2) body.classList.add('sidebar-hidden');
      applyTooltips();
    });

    /* active nav */
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

    /* ── Dark / Light Mode Toggle ─────────────────────────────── */
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const themeLabel = document.getElementById('themeLabel');
    let darkMode = false;

    themeToggle.addEventListener('click', function (e) {
      e.preventDefault();
      darkMode = !darkMode;
      body.classList.toggle('dark-mode', darkMode);
      if (darkMode) {
        themeIcon.className = 'bi bi-sun-fill';
        themeLabel.textContent = 'Modo Claro';
      } else {
        themeIcon.className = 'bi bi-moon-stars-fill';
        themeLabel.textContent = 'Modo Escuro';
      }
    });

    /* ── ApexCharts ───────────────────────────────────────────── */

    /* cashflow line chart */
    const cashflowOptions = {
      chart: {
        type: 'area', height: 250, toolbar: { show: false }, sparkline: { enabled: false },
        fontFamily: 'DM Sans, sans-serif'
      },
      series: [
        { name: 'Contas a Receber', data: [420, 510, 380, 620, 540, 710, 680, 750, 620, 810, 740, 890] },
        { name: 'Contas a Pagar', data: [310, 420, 290, 510, 460, 580, 530, 620, 490, 670, 590, 720] },
        { name: 'Saldo', data: [110, 90, 90, 110, 80, 130, 150, 130, 130, 140, 150, 170] },
      ],
      colors: ['#2E7D32', '#C62828', '#1565C0'],
      fill: {
        type: 'gradient',
        gradient: { shadeIntensity: 1, opacityFrom: 0.25, opacityTo: 0.02, stops: [0, 100] }
      },
      stroke: { curve: 'smooth', width: 2.5 },
      xaxis: {
        categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        labels: { style: { fontSize: '11px', colors: '#8FA894' } },
        axisBorder: { show: false }, axisTicks: { show: false }
      },
      yaxis: {
        labels: {
          style: { fontSize: '11px', colors: '#8FA894' },
          formatter: v => 'Kz ' + (v / 100).toFixed(0) + 'k'
        }
      },
      tooltip: { x: { format: 'MMM' }, y: { formatter: v => 'Kz ' + v.toLocaleString('pt-AO') + ',00' } },
      grid: { borderColor: '#F0F4F0', strokeDashArray: 4 },
      legend: {
        position: 'top', horizontalAlign: 'right',
        labels: { colors: '#4A6350' }, markers: { size: 6, shape: 'circle' }
      },
      dataLabels: { enabled: false }
    };

    new ApexCharts(document.querySelector('#chart-cashflow'), cashflowOptions).render();

    /* donut chart */
    const donutOptions = {
      chart: { type: 'donut', height: 250, fontFamily: 'DM Sans, sans-serif' },
      series: [28.6, 22.3, 13.3, 8.9, 4.3, 3.8, 3.5, 3.4, 3.0, 2.2, 1.3, 1.1, 1.0],
      labels: ['Fertilizantes', 'Defensivos', 'Sementes', 'Comissões', 'Biológicos',
        'Arrendamentos', 'Combustíveis', 'Corretivos', 'Máquinas', 'Serviços',
        'Impostos', 'Adm.', 'Diversas'],
      colors: ['#1B5E20', '#2E7D32', '#388E3C', '#43A047', '#4CAF50',
        '#66BB6A', '#81C784', '#A5D6A7', '#C8E6C9', '#E8F5E9',
        '#F57F17', '#1565C0', '#C62828'],
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
            labels: {
              show: true,
              total: {
                show: true, label: 'Total', color: '#4A6350',
                formatter: () => '100%'
              }
            }
          }
        }
      },
      dataLabels: { enabled: false },
      legend: { position: 'bottom', fontSize: '11px', labels: { colors: '#4A6350' } },
      tooltip: { y: { formatter: v => v.toFixed(1) + '%' } }
    };

    new ApexCharts(document.querySelector('#chart-donut'), donutOptions).render();
  </script>

</body>

</html>