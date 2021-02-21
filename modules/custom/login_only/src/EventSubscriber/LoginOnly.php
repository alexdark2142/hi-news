<?php
namespace Drupal\login_only\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Event subscriber subscribing to KernelEvents::REQUEST.
 */
class LoginOnly implements EventSubscriberInterface {

  /**
   * Denies access to the site for anonymous and authenticated users
   * @param GetResponseEvent $event
   */
  public function checkAuthStatus(GetResponseEvent $event) {

    $current_route = \Drupal::routeMatch()->getRouteName();
    $anonymous = \Drupal::currentUser()->isAnonymous();
    $currentRole = \Drupal::currentUser()->getRoles();
    $available_route_anon = [
      'user.login',
      'user.register',
      'user.reset',
      'user.reset.form',
      'user.reset.login',
      'user.pass'
    ];
    $available_route = [
      'user.logout',
      'entity.user.canonical',
      'smile_contact.admin',
      'smile_contact.contact_page',
    ];
    if ($anonymous && !in_array($current_route, $available_route_anon)){
      $response = new RedirectResponse('/user/login', 301);
      $response->send();
    }
    elseif (!$anonymous && !in_array('administrator', $currentRole) && !in_array($current_route, $available_route)) {
        $response = new RedirectResponse('/user/{id}', 301);
        $response->send();
    }
  }



  /**
   *
   */
  public static function getSubscribedEvents() {
    $settings = \Drupal::config('login_only.settings');
    $value = $settings->get('disabled');
    if ($value) {
      $events[KernelEvents::REQUEST][] = ['checkAuthStatus'];
      return $events;
    }
  }
}
