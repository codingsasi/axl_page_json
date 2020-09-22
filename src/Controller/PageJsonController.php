<?php

namespace Drupal\axl_page_json\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PageJsonController.
 */
class PageJsonController extends ControllerBase {

  /**
   * @var \Symfony\Component\Serializer\Serializer
   */
  private $serializer;

  /**
   * Serializes a given entity into a supported format.
   *
   * @param \Symfony\Component\Serializer\Serializer $serializer
   */
  public function __construct(Serializer $serializer) {
    $this->serializer = $serializer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('serializer')
    );
  }

  /**
   * Checks API key, node bundle and returns JSON.
   *
   * @param string $siteapikey
   *   The Site API key.
   * @param \Drupal\node\Entity\Node $node
   *   Drupal Node.
   *
   * @return array|bool|\Drupal\Core\Access\AccessResultForbidden|float|int|string
   *   Return either serialized Page Node or Access Denied.
   */
  public function page($siteapikey, Node $node) {
    if ($node->bundle() !== 'page' || empty($siteapikey)
      || $this->config('system.site')->get('siteapikey') != $siteapikey) {
      return new Response('Access Denied', Response::HTTP_FORBIDDEN);
    }
    return JsonResponse::fromJsonString(
      $this->serializer->serialize(
        $node, 'json',
        ['plugin_id' => 'entity']
      )
    );
  }

}
