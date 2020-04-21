<?php

use HOdonto\Model\User;

function checkSignIn()
{
  return User::checkSignIn();
}

function activeLanguage($lang)
{
  if (!$_COOKIE['lang']) return ($lang === 'en_GB') ? 'active' : '';
  return ($lang === $_COOKIE['lang']) ? 'active' : '';
}

?>