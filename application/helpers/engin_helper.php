<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Helpers d'affichage — Module Engins & Matériels
 * Chargé par le contrôleur Engin : $this->load->helper('engin');
 */

if (!function_exists('eq_e')) {
    /** Échappement HTML (null -> '') */
    function eq_e($value)
    {
        return html_escape((string) ($value === null ? '' : $value));
    }
}

if (!function_exists('eq_num')) {
    function eq_num($value, $decimals = 0)
    {
        return number_format((float) $value, (int) $decimals, ',', ' ');
    }
}

if (!function_exists('eq_money')) {
    function eq_money($value, $suffix = ' BIF')
    {
        return number_format((float) $value, 0, ',', ' ') . $suffix;
    }
}

if (!function_exists('eq_date')) {
    function eq_date($date, $withTime = false)
    {
        if (empty($date) || strpos((string) $date, '0000-00-00') === 0) {
            return '-';
        }
        $ts = strtotime($date);
        return $ts ? date($withTime ? 'd/m/Y H:i' : 'd/m/Y', $ts) : '-';
    }
}

if (!function_exists('eq_unit')) {
    /** Unité du compteur : km / h */
    function eq_unit($typeCompteur)
    {
        return $typeCompteur === 'heure' ? 'h' : ($typeCompteur === 'km' ? 'km' : '');
    }
}

if (!function_exists('eq_conso_unit')) {
    function eq_conso_unit($typeCompteur)
    {
        return $typeCompteur === 'heure' ? 'L/h' : 'L/100 km';
    }
}

if (!function_exists('eq_badge')) {
    /** Classe CSS du badge selon un état / statut */
    function eq_badge($status)
    {
        $map = [
            'Disponible'    => 'eq-badge-success',
            'Terminé'       => 'eq-badge-success',
            'Validé'        => 'eq-badge-success',
            'Résolue'       => 'eq-badge-success',
            'Sur chantier'  => 'eq-badge-info',
            'Programmé'     => 'eq-badge-info',
            'Signalée'      => 'eq-badge-info',
            'Maintenance'   => 'eq-badge-warning',
            'En cours'      => 'eq-badge-warning',
            'En diagnostic' => 'eq-badge-warning',
            'En réparation' => 'eq-badge-warning',
            'Majeure'       => 'eq-badge-warning',
            'En panne'      => 'eq-badge-danger',
            'Annulé'        => 'eq-badge-danger',
            'Annulée'       => 'eq-badge-danger',
            'Critique'      => 'eq-badge-danger',
            'Réformé'       => 'eq-badge-muted',
            'Mineure'       => 'eq-badge-muted',
        ];
        return isset($map[$status]) ? $map[$status] : 'eq-badge-muted';
    }
}

if (!function_exists('eq_file_icon')) {
    function eq_file_icon($fileName)
    {
        $ext = strtolower(pathinfo((string) $fileName, PATHINFO_EXTENSION));
        if ($ext === 'pdf') {
            return 'fas fa-file-pdf text-danger';
        }
        if (in_array($ext, ['doc', 'docx'], true)) {
            return 'fas fa-file-word text-primary';
        }
        if (in_array($ext, ['xls', 'xlsx'], true)) {
            return 'fas fa-file-excel text-success';
        }
        if (in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
            return 'fas fa-file-image text-info';
        }
        return 'fas fa-file text-secondary';
    }
}

if (!function_exists('eq_json')) {
    /** JSON sûr pour une insertion dans une balise <script> */
    function eq_json($data)
    {
        return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
    }
}
