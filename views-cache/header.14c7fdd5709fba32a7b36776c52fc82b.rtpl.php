<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Clinic Ortodontic System</title>
  <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<!--?php 
    include 'pages/syst.html';
    include 'pages/menu.php';
?-->
</head>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="">Your Clinic</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      
<!--?php
      if ($_SESSION['login']){
?-->
      <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
              <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menu
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="/dentist">Dentist</a>
                    <a class="dropdown-item" href="/patient">Patient</a>
                    <a class="dropdown-item" href="/schedule">Schedule</a>
                    <a class="dropdown-item" href="/logout">Logout</a>
                  </div>
                </div>
          </li>
        </ul>
      </div>
<!--?php
      }
?-->
    </div>
  </nav>