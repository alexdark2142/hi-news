<?php

namespace Drupal\smile_entity\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityMalformedException;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\smile_entity\Entity\SmileTest;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a list controller for smile_entity entity.
 *
 * @ingroup smile_entity
 */
class SmileListBuilder extends EntityListBuilder {

  /**
   * The url generator.
   *
   * @var UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('url_generator')
    );
  }

  /**
   * Constructs a new SmileListBuilder object.
   *
   * @param EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param EntityStorageInterface $storage
   *   The entity storage class.
   * @param UrlGeneratorInterface $url_generator
   *   The url generator.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, UrlGeneratorInterface $url_generator) {
    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;
  }

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  public function render() {
    $build['description'] = [
      '#markup' => $this->t('Implements the "smile_test" custom object type. You can manage the fields on the <a href="@adminlink">Admin page</a>.', [
        '@adminlink' => $this->urlGenerator->generateFromRoute('smile_entity.smile_settings'),
      ]),
    ];
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the smile list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['title'] = $this->t('Title');
    $header['role'] = $this->t('Role');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   * @throws EntityMalformedException
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity SmileTest */
    $row['title'] = $entity->get('title')->value;
    $row['role'] = $entity->get('role')->target_id;

    return $row + parent::buildRow($entity);
  }

}
