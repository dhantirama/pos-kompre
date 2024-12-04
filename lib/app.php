<?php
function ubahStatus($status)
{
  switch ($status) {
    case 0:
      return '<span class="badge bg-label-warning">Baru</span>';
    case 1:
      return '<span class="badge bg-label-success">Diambil</span>';
    default:
      return '<span class="badge bg-label-secondary">Unknown Status</span>';
  }
}
