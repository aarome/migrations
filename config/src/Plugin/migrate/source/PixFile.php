<?php
  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Update filepath to remove public:// directory portion.
    $original_path = $row->getSourceProperty('filepath');
    $new_path = str_replace('sites/default/files/', 'public://', $original_path);
    $row->setSourceProperty('filepath', $new_path);

    return parent::prepareRow($row);
  }
?>