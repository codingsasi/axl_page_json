<?php

namespace Drupal\axl_page_json\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Alter site information route.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('system.site_information_settings')) {
      $route->setDefault('_form', 'Drupal\axl_page_json\Form\CustomSiteInformationForm');
    }
  }

}
