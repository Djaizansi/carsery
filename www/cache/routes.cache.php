<?php return array(
  '/' =>
  array(
    'controller' => 'default',
    'action' => 'default',
  ),
  '/ajout-utilisateur' =>
  array(
    'controller' => 'user',
    'action' => 'add',
  ),
  '/supprimer-utilisateur' =>
  array(
    'controller' => 'user',
    'action' => 'remove',
  ),
  '/utilisateur' =>
  array(
    'controller' => 'user',
    'action' => 'default',
  ),
  '/test/user' =>
  array(
    'controller' => 'default',
    'action' => 'default',
  ),
  '/connexion' =>
  array(
    'controller' => 'user',
    'action' => 'login',
  ),
  '/inscription' =>
  array(
    'controller' => 'user',
    'action' => 'register',
  ),
  '/mdpoublie' =>
  array(
    'controller' => 'user',
    'action' => 'forget',
  ),
  '/contact' =>
    array(
      'controller' => 'contact',
      'action' => 'contact',
    ),
);
