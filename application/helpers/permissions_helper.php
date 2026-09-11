<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('user_permissions')) {
    /**
     * Retourne les permissions de l'utilisateur sous forme de clefs "module|page".
     * Mémoire cache statique : 1 seule requête par page chargée.
     */
    function user_permissions($userId = null)
    {
        static $cache = [];

        $ci = &get_instance();

        if ($userId === null) {
            $userId = (int) $ci->session->userdata('user_id');
        }
        if ($userId <= 0) {
            return [];
        }

        if (!isset($cache[$userId])) {
            $keys = [];
            $rows = $ci->db->select('module_code, permission_code')
                ->where('user_id', $userId)
                ->get('user_permissions')
                ->result();
            foreach ($rows as $r) {
                $keys[] = $r->module_code . '|' . $r->permission_code;
            }
            $cache[$userId] = $keys;
        }

        return $cache[$userId];
    }
}

if (!function_exists('has_access')) {
    /** L'utilisateur a-t-il accès à cette page précise ? */
    function has_access($module, $page, $userId = null)
    {
        $ci = &get_instance();

        // Bypass : les super-admins voient tout, même sans lignes en base
        $roleCode = strtoupper((string) $ci->session->userdata('role_code'));
        if (in_array($roleCode, ['SUPER_ADMIN', 'ADMIN_ENTREPRISE'], true)) {
            return true;
        }

        return in_array($module . '|' . $page, user_permissions($userId), true);
    }
}

if (!function_exists('has_any_access')) {
    /** L'utilisateur a-t-il au moins une page dans ce module ? (pour afficher/masquer le groupe parent) */
    function has_any_access($module, $userId = null)
    {
        $ci = &get_instance();
        $roleCode = strtoupper((string) $ci->session->userdata('role_code'));
        if (in_array($roleCode, ['SUPER_ADMIN', 'ADMIN_ENTREPRISE'], true)) {
            return true;
        }

        foreach (user_permissions($userId) as $key) {
            if (strpos($key, $module . '|') === 0) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('require_access')) {
    /** Garde-fou serveur : à placer en 1ʳᵉ ligne de chaque méthode de controller */
    function require_access($module, $page)
    {
        $ci = &get_instance();

        if (!$ci->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        if (!has_access($module, $page)) {
            show_error('Vous n’avez pas les droits d’accès à cette page.', 403);
        }
    }
}
