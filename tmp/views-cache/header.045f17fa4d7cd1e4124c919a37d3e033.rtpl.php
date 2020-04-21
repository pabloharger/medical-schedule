<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Clinic Ortodontic System</title>
  <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
</head>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/"><?php echo L('header_clinicName'); ?></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <?php if( checkSignIn() ){ ?>

      <div class="collapse navbar-collapse text-center justify-content-begin" id="navbar2SupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" name="dentist" href="/dentist"><?php echo L('header_menu_dentist'); ?> <span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/patient"><?php echo L('header_menu_patient'); ?><span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/schedule"><?php echo L('header_menu_schedule'); ?><span class="sr-only"></span></a>
          </li>
        </ul>
      </div>
      <?php } ?>

      <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span id="selected-dropdown-menu" class="flag-icon flag-icon-us"></span>
            </a>
            <div class="dropdown-menu" id="dropdown-menu-lang">
                <a class="dropdown-item <?php echo activeLanguage('en_GB'); ?>" en_GB href="/lang/en_GB"><span class="flag-icon flag-icon-fr"> </span>English</a>
                <a class="dropdown-item <?php echo activeLanguage('pt_BR'); ?>" pt_BR href="/lang/pt_BR"><span class="flag-icon flag-icon-it"> </span>Português</a>
                <a class="dropdown-item <?php echo activeLanguage('es_ES'); ?>" es_ES href="/lang/es_ES"><span class="flag-icon flag-icon-ru"> </span>Español</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/account/logout"><?php echo L('header_menu_signOut'); ?><span class="sr-only"></span></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>