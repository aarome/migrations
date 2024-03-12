<?php

namespace Drupal\migrations\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\migrate\MigrateSkipRowException;

/**
 * Skips processing the current row if a node with the same title exists.
 *
 * @MigrateProcessPlugin(
 *   id = "skip_existing_node"
 * )
 */
class SkipExistingNode extends ProcessPluginBase {

  /**
   *
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Use the entityTypeManager to check for existing nodes with the same title.
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['title' => $value]);
    if (!empty($nodes)) {
      // Log the skipping of this row.
      \Drupal::logger('migrations')->info('Skipping migration row due to existing node with title: @title', ['@title' => $value]);

      // Skip this row.
      throw new MigrateSkipRowException();
    }
    return $value;
  }

}
