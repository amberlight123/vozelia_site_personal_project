<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Vozelia</title>
<meta name="theme-color" content="#80B04F">
<link rel="icon" type="image/jpeg" href="public/img/vozelia_logo.jpg">
<link rel="stylesheet" href="public/css/style.css">
</head>
<?php
  $controller = $_GET['controller'] ?? 'pages';
  $action = $_GET['action'] ?? 'home';

  $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
  $path = rtrim($path, '/');

  $isLanding = (
    $controller === 'pages'
    && in_array($action, ['home', 'index', ''], true)
  ) || $path === '' || $path === '/' || $path === '/index.php' || $path === 'index.php';

  $classes = [];
  if ($controller === 'admin') {
    $classes[] = 'is-admin';
  } elseif ($controller === 'ops') {
    $classes[] = 'is-ops';
  }
  if ($isLanding) {
    $classes[] = 'is-landing';
  }
  $bodyClass = implode(' ', $classes);
?>
<body class="<?= htmlspecialchars($bodyClass) ?>">
<!-- Top strip -->
<div class="top-strip">
  <div class="top-strip-inner">
    <div class="top-strip-links">
      <a class="top-strip-item" href="tel:310-0869" aria-label="Llamar a Vozelia">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.86.3 1.7.54 2.5a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.58-1.06a2 2 0 0 1 2.11-.45c.8.24 1.64.42 2.5.54A2 2 0 0 1 22 16.92z"/></svg>
        <span>310-0VOZ (310-0869)</span>
      </a>
      <a class="top-strip-item" href="https://mail.google.com/mail/?view=cm&fs=1&to=info@vozelia.com.pa" aria-label="Enviar correo a Vozelia">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="M4 4l8 8 8-8"/></svg>
        <span>info@vozelia.com.pa</span>
      </a>
    </div>
  </div>
</div>

<!-- Main header -->
<header class="site-header" data-site-header>
  <div class="site-header-inner">
    <div class="brand">
      <a class="brand-link" href="index.php?controller=pages&action=home" aria-label="Ir al inicio">
        <img class="brand-logo" src="public/img/vozelia_logo.jpg" alt="Logo Vozelia">
        <div class="brand-text">
          <div class="wordmark" aria-label="Vozelia">
            <span>v</span><span class="o">o</span><span>zelia</span>
          </div>
          <div class="brand-sub">Telefonía IP · Trunk SIP · Central Virtual</div>
        </div>
      </a>
    </div>

    <nav class="main-nav" aria-label="Navegación principal">
      <a href="index.php?controller=pages&action=home#about">Quiénes somos</a>
      <a href="index.php?controller=pages&action=home#services">Servicios</a>
      <a href="index.php?controller=pages&action=home#pricing">Tarifas</a>
      <a href="index.php?controller=pages&action=home#contact">Contacto</a>
    </nav>

    <div class="header-actions">
      <a class="btn btn-compact" href="index.php?controller=pages&action=contacto#cotizar">Comenzar</a>

      <?php if (function_exists('is_logged_in') && is_logged_in()): ?>
        <a class="btn-secondary btn-compact" href="index.php?controller=user&action=profile">Panel</a>
        <?php if (function_exists('is_admin') && is_admin()): ?>
          <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=dashboard">Admin</a>
          <a class="btn-secondary btn-compact" href="index.php?controller=ops&action=status">Estado</a>
        <?php endif; ?>
        <a class="btn-secondary btn-compact" href="index.php?controller=auth&action=logout">Salir</a>
      <?php else: ?>
        <a class="btn-secondary btn-compact" href="index.php?controller=auth&action=showLogin">Acceso clientes</a>
      <?php endif; ?>

      <button class="theme-toggle" type="button" data-theme-toggle aria-label="Cambiar tema">
        <span class="theme-toggle-icon" aria-hidden="true"></span>
      </button>

      <button class="nav-toggle" type="button" data-nav-toggle aria-label="Abrir menú">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 6h18"/><path d="M3 12h18"/><path d="M3 18h18"/></svg>
      </button>
    </div>
  </div>

  <div class="mobile-nav" data-mobile-nav>
    <div class="mobile-nav-inner">
      <a href="index.php?controller=pages&action=home#about">Quiénes somos</a>
      <a href="index.php?controller=pages&action=home#services">Servicios</a>
      <a href="index.php?controller=pages&action=home#pricing">Tarifas</a>
      <a href="index.php?controller=pages&action=home#contact">Contacto</a>
      <a href="index.php?controller=ops&action=status">Estado</a>
      <div class="actions-row">
        <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Comenzar</a>
        <a class="btn-outline" href="index.php?controller=pages&action=tarifas">Ver tarifas</a>
      </div>
    </div>
  </div>
</header>

<main class="main container">
