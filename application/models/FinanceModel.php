<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinanceModel extends CI_Model
{
    public function get_exercises()
    {
        return $this->db
            ->order_by('year', 'DESC')
            ->get('tbl_finance_exercice')
            ->result();
    }

    public function get_active_exercise()
    {
        return $this->db
            ->where('is_active', 1)
            ->where('status', 'open')
            ->get('tbl_finance_exercice')
            ->row();
    }

    public function count_exercises()
    {
        return $this->db->count_all('tbl_finance_exercice');
    }

    public function count_by_status($status)
    {
        return $this->db
            ->where('status', $status)
            ->count_all_results('tbl_finance_exercice');
    }

    public function insert_exercise($data)
    {
        if ((int)$data['is_active'] === 1) {
            $this->db->update('tbl_finance_exercice', ['is_active' => 0]);
        }

        return $this->db->insert('tbl_finance_exercice', $data);
    }

    public function close_exercise($id)
    {
        return $this->db
            ->where('id', $id)
            ->update('tbl_finance_exercice', [
                'status' => 'closed',
                'is_active' => 0,
                'closed_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function update_exercise($id, $data)
    {
        if ((int)$data['is_active'] === 1) {
            $this->db->update('tbl_finance_exercice', ['is_active' => 0]);
        }

        return $this->db
            ->where('id', $id)
            ->update('tbl_finance_exercice', $data);
    }

    public function get_account_classes()
    {
        return $this->db
            ->order_by('code_prefix', 'ASC')
            ->get('tbl_finance_account_class')
            ->result();
    }

    public function update_account_class($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('tbl_finance_account_class', $data);
    }

    public function delete_account_class($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('tbl_finance_account_class');
    }

    public function get_chart_accounts()
    {
        return $this->db

            ->select('
            tbl_finance_chart_account.*,
            tbl_finance_account_class.class_name,
            tbl_finance_account_class.class_number,
            chantiers.name AS chantier_name
        ')

            ->from('tbl_finance_chart_account')

            ->join(
                'tbl_finance_account_class',
                'tbl_finance_account_class.id = tbl_finance_chart_account.class_id',
                'left'
            )

            ->join(
                'chantiers',
                'chantiers.id = tbl_finance_chart_account.chantier_id',
                'left'
            )

            ->order_by('tbl_finance_chart_account.account_code', 'ASC')

            ->get()

            ->result();
    }

    public function chart_account_exist($code)
    {
        return $this->db
            ->where('account_code', $code)
            ->count_all_results('tbl_finance_chart_account') > 0;
    }

    public function insert_chart_account($data)
    {
        return $this->db
            ->insert('tbl_finance_chart_account', $data);
    }

    public function update_chart_account($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('tbl_finance_chart_account', $data);
    }

    public function delete_chart_account($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('tbl_finance_chart_account');
    }

    public function get_journal_codes()
    {
        return $this->db
            ->select('
            tbl_finance_journal_code.*,
            tbl_finance_chart_account.account_code,
            tbl_finance_chart_account.account_name
        ')
            ->from('tbl_finance_journal_code')
            ->join(
                'tbl_finance_chart_account',
                'tbl_finance_chart_account.id = tbl_finance_journal_code.default_account_id',
                'left'
            )
            ->order_by('tbl_finance_journal_code.journal_code', 'ASC')
            ->get()
            ->result();
    }

    public function insert_journal_code($data)
    {
        return $this->db->insert(
            'tbl_finance_journal_code',
            $data
        );
    }

    public function update_journal_code($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('tbl_finance_journal_code', $data);
    }

    public function delete_journal_code($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('tbl_finance_journal_code');
    }

    public function get_accounting_entries()
    {
        $this->db->select("
            e.*,
            ex.name,
            j.journal_code,
            j.journal_name,
            c.name AS chantier_name
        ");

        $this->db->from('tbl_finance_accounting_entry e');

        $this->db->join(
            'tbl_finance_exercice ex',
            'ex.id = e.exercise_id',
            'left'
        );

        $this->db->join(
            'tbl_finance_journal_code j',
            'j.id = e.journal_id',
            'left'
        );

        $this->db->join(
            'chantiers c',
            'c.id = e.chantier_id',
            'left'
        );

        $this->db->order_by('e.operation_date', 'DESC');
        $this->db->order_by('e.id', 'DESC');

        return $this->db->get()->result();
    }

    public function insert_accounting_entry($data)
    {
        $this->db->insert('tbl_finance_accounting_entry', $data);
        return $this->db->insert_id();
    }

    public function insert_accounting_entry_line($data)
    {
        return $this->db->insert('tbl_finance_accounting_entry_line', $data);
    }


    public function get_accounting_entry_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('tbl_finance_accounting_entry')
            ->row();
    }

    public function get_accounting_entry_lines($entry_id)
    {
        return $this->db
            ->where('entry_id', $entry_id)
            ->get('tbl_finance_accounting_entry_line')
            ->result();
    }

    public function update_accounting_entry($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update(
                'tbl_finance_accounting_entry',
                $data
            );
    }

    public function delete_accounting_entry_lines($entryId)
    {
        return $this->db
            ->where('entry_id', $entryId)
            ->delete('tbl_finance_accounting_entry_line');
    }

    public function delete_accounting_entry($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('tbl_finance_accounting_entry');
    }

    public function get_accounting_entry_lines_details($entry_id)
    {
        return $this->db
            ->select('
            l.*,
            d.account_code AS debit_code,
            d.account_name AS debit_name,
            c.account_code AS credit_code,
            c.account_name AS credit_name
        ')
            ->from('tbl_finance_accounting_entry_line l')
            ->join('tbl_finance_chart_account d', 'd.id = l.debit_account_id', 'left')
            ->join('tbl_finance_chart_account c', 'c.id = l.credit_account_id', 'left')
            ->where('l.entry_id', $entry_id)
            ->get()
            ->result();
    }

    public function get_journal_entries()
    {
        return $this->db
            ->select('
            e.*,
            j.journal_code,
            j.journal_name,
            ch.name AS chantier_name
        ')
            ->from('tbl_finance_accounting_entry e')
            ->join('tbl_finance_journal_code j', 'j.id = e.journal_id', 'left')
            ->join('chantiers ch', 'ch.id = e.chantier_id', 'left')
            ->order_by('e.operation_date', 'DESC')
            ->order_by('e.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_journal_entry_lines($entry_id)
    {
        return $this->db
            ->select('
            l.*,
            d.account_code AS debit_code,
            d.account_name AS debit_name,
            c.account_code AS credit_code,
            c.account_name AS credit_name
        ')
            ->from('tbl_finance_accounting_entry_line l')
            ->join('tbl_finance_chart_account d', 'd.id = l.debit_account_id', 'left')
            ->join('tbl_finance_chart_account c', 'c.id = l.credit_account_id', 'left')
            ->where('l.entry_id', $entry_id)
            ->get()
            ->result();
    }

    public function get_grand_livre_entries()
    {
        $sql = "
            SELECT 
                ca.id AS account_id,
                ca.account_code,
                ca.account_name,

                e.id AS entry_id,
                e.piece_number,
                e.operation_date,
                e.reference,
                e.general_label,
                e.currency,

                j.journal_code,
                j.journal_name,

                l.line_label,
                l.debit_account_id,
                l.credit_account_id,
                l.debit,
                l.credit,
                l.has_tva,
                l.tva_type,
                l.tva_rate,
                l.tva_amount,

                CASE 
                    WHEN l.debit_account_id = ca.id THEN l.debit
                    ELSE 0
                END AS debit_amount,

                CASE 
                    WHEN l.credit_account_id = ca.id THEN l.credit
                    ELSE 0
                END AS credit_amount

            FROM tbl_finance_chart_account ca

            INNER JOIN tbl_finance_accounting_entry_line l 
                ON l.debit_account_id = ca.id 
                OR l.credit_account_id = ca.id

            INNER JOIN tbl_finance_accounting_entry e 
                ON e.id = l.entry_id

            LEFT JOIN tbl_finance_journal_code j 
                ON j.id = e.journal_id

            ORDER BY 
                ca.account_code ASC,
                e.operation_date ASC,
                e.id ASC
        ";

        return $this->db->query($sql)->result();
    }

    public function get_balance_generale()
    {
        $sql = "
        SELECT
            ca.id AS account_id,
            ca.account_code,
            ca.account_name,
            ca.currency,
            cc.class_number,
            cc.code_prefix,
            cc.class_name,

            SUM(CASE WHEN l.debit_account_id = ca.id THEN IFNULL(l.debit, 0) ELSE 0 END) AS total_debit,
            SUM(CASE WHEN l.credit_account_id = ca.id THEN IFNULL(l.credit, 0) ELSE 0 END) AS total_credit

        FROM tbl_finance_chart_account ca

        LEFT JOIN tbl_finance_account_class cc
            ON cc.id = ca.class_id

        LEFT JOIN tbl_finance_accounting_entry_line l
            ON l.debit_account_id = ca.id
            OR l.credit_account_id = ca.id

        GROUP BY ca.id

        ORDER BY ca.account_code ASC
    ";

        $accounts = $this->db->query($sql)->result();

        foreach ($accounts as &$acc) {

            $balance = (float)$acc->total_debit - (float)$acc->total_credit;

            if ($balance >= 0) {
                $acc->debit_balance = $balance;
                $acc->credit_balance = 0;
            } else {
                $acc->debit_balance = 0;
                $acc->credit_balance = abs($balance);
            }
        }

        return $accounts;
    }

    // public function get_active_exercise()
    // {
    //     return $this->db
    //         ->where('status', 'open')
    //         ->order_by('id', 'DESC')
    //         ->get('tbl_finance_exercise')
    //         ->row();
    // }

    public function get_closing_stats()
    {
        return $this->db
            ->select("
            COUNT(id) AS total_entries,
            SUM(total_debit) AS total_debit,
            SUM(total_credit) AS total_credit,
            SUM(total_tva) AS total_tva
        ")
            ->from('tbl_finance_accounting_entry')
            ->get()
            ->row();
    }

    public function get_closing_checks()
    {
        $stats = $this->get_closing_stats();

        $drafts = $this->db
            ->where('status', 'draft')
            ->count_all_results('tbl_finance_accounting_entry');

        $withoutJournal = $this->db
            ->where('journal_id IS NULL', null, false)
            ->or_where('journal_id', 0)
            ->count_all_results('tbl_finance_accounting_entry');

        $withoutChantier = $this->db
            ->where('chantier_id IS NULL', null, false)
            ->count_all_results('tbl_finance_accounting_entry');

        return [
            'balance_ok' => round((float)$stats->total_debit, 2) == round((float)$stats->total_credit, 2),
            'drafts' => $drafts,
            'without_journal' => $withoutJournal,
            'without_chantier' => $withoutChantier,
            'tva_total' => (float)$stats->total_tva
        ];
    }



    public function get_closing_history()
    {
        $this->db->select("
        ex.*,
        SUM(IFNULL(e.total_debit,0))  AS total_debit,
        SUM(IFNULL(e.total_credit,0)) AS total_credit,
        u.first_name AS closed_by_name
    ");

        $this->db->from('tbl_finance_exercice ex');

        $this->db->join(
            'tbl_finance_accounting_entry e',
            'e.exercise_id = ex.id',
            'left'
        );

        $this->db->join(
            'users u',
            'u.id = ex.created_by',
            'left'
        );

        $this->db->group_by('ex.id');

        $this->db->order_by('ex.year', 'DESC');

        return $this->db->get()->result();
    }

    /**
     * Génère le prochain code caisse pour une année.
     *
     * Exemple :
     * CAI-2026-001
     * CAI-2026-002
     */
    public function getNextCashboxCode(?int $year = null): string
    {
        $year = $year ?? (int) date('Y');

        $prefix = 'CAI-' . $year . '-';

        $sql = "
        SELECT code
        FROM tbl_finance_cashbox
        WHERE code LIKE ?
        ORDER BY CAST(SUBSTRING_INDEX(code, '-', -1) AS UNSIGNED) DESC
        LIMIT 1
    ";

        $query = $this->db->query($sql, [$prefix . '%']);
        $lastCashbox = $query->row();

        $nextNumber = 1;

        if ($lastCashbox && !empty($lastCashbox->code)) {
            $parts = explode('-', $lastCashbox->code);
            $lastNumber = (int) end($parts);

            $nextNumber = $lastNumber + 1;
        }

        return sprintf(
            'CAI-%d-%03d',
            $year,
            $nextNumber
        );
    }

    public function chantierHasCashbox(int $chantierId): bool
    {
        return $this->db
            ->where('chantier_id', $chantierId)
            ->where('type', 'chantier')
            ->where('status !=', 'closed')
            ->count_all_results('tbl_finance_cashbox') > 0;
    }

    /**
     * Crée une caisse avec un code séquentiel.
     *
     * La transaction et GET_LOCK évitent que deux utilisateurs
     * obtiennent simultanément le même code.
     */
    public function createCashbox(array $data)
    {
        $year = (int) date('Y');
        $lockName = 'cashbox_code_' . $year;

        $this->db->trans_begin();

        try {
            /*
         * Verrou MySQL pour éviter les doublons lorsque deux
         * utilisateurs enregistrent au même moment.
         */
            $lockQuery = $this->db->query(
                'SELECT GET_LOCK(?, 10) AS lock_status',
                [$lockName]
            );

            $lockResult = $lockQuery->row();

            if (!$lockResult || (int) $lockResult->lock_status !== 1) {
                throw new RuntimeException(
                    'Impossible de réserver le numéro de caisse.'
                );
            }

            /*
         * Le code est généré côté serveur.
         * La valeur envoyée par le formulaire n'est pas utilisée.
         */
            $data['code'] = $this->getNextCashboxCode($year);

            $this->db->insert(
                'tbl_finance_cashbox',
                $data
            );

            if ($this->db->affected_rows() !== 1) {
                throw new RuntimeException(
                    'La caisse n’a pas pu être enregistrée.'
                );
            }

            $cashboxId = $this->db->insert_id();

            $this->db->query(
                'SELECT RELEASE_LOCK(?)',
                [$lockName]
            );

            $this->db->trans_commit();

            return [
                'status' => true,
                'id'     => $cashboxId,
                'code'   => $data['code'],
            ];
        } catch (Throwable $exception) {
            $this->db->trans_rollback();

            /*
         * On tente de libérer le verrou même après une erreur.
         */
            $this->db->query(
                'SELECT RELEASE_LOCK(?)',
                [$lockName]
            );

            log_message(
                'error',
                'Erreur création caisse : ' . $exception->getMessage()
            );

            return [
                'status'  => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function getAllCashboxes(): array
    {
        return $this->db
            ->select([
                'c.id',
                'c.code',
                'c.name',
                'c.type',
                'c.chantier_id',
                'c.responsable',
                'c.devise',
                'c.opening_balance',
                'c.current_balance',
                'c.alert_threshold',
                'c.observation',
                'c.status',
                'c.created_at',
                'ch.name AS chantier_name',
            ])
            ->from('tbl_finance_cashbox c')
            ->join(
                'chantiers ch',
                'ch.id = c.chantier_id',
                'left'
            )
            ->order_by('c.id', 'DESC')
            ->get()
            ->result();
    }

    public function getNextCashboxOperationReference(?int $year = null): string
    {
        $year = $year ?? (int) date('Y');

        $prefix = 'MVT-' . $year . '-';

        $sql = "
        SELECT reference
        FROM tbl_finance_cashbox_operation
        WHERE reference LIKE ?
        ORDER BY
            CAST(
                SUBSTRING_INDEX(reference, '-', -1)
                AS UNSIGNED
            ) DESC
        LIMIT 1
    ";

        $query = $this->db->query(
            $sql,
            [$prefix . '%']
        );

        $lastOperation = $query->row();

        $nextNumber = 1;

        if ($lastOperation && !empty($lastOperation->reference)) {
            $parts = explode(
                '-',
                $lastOperation->reference
            );

            $lastNumber = (int) end($parts);

            $nextNumber = $lastNumber + 1;
        }

        return sprintf(
            'MVT-%d-%05d',
            $year,
            $nextNumber
        );
    }

    private function getCashboxForUpdate(int $cashboxId)
    {
        $sql = "
        SELECT
            id,
            code,
            name,
            devise,
            current_balance,
            status
        FROM tbl_finance_cashbox
        WHERE id = ?
        LIMIT 1
        FOR UPDATE
    ";

        return $this->db
            ->query($sql, [$cashboxId])
            ->row();
    }

    /**
     * Enregistre une opération de caisse et met à jour les soldes.
     *
     * @param array $operationData
     * @return array
     */
    public function createCashboxOperation(array $operationData): array
    {
        $operationType = isset($operationData['operation_type'])
            ? trim((string) $operationData['operation_type'])
            : '';

        $sourceCashboxId = !empty($operationData['source_cashbox_id'])
            ? (int) $operationData['source_cashbox_id']
            : null;

        $destinationCashboxId = !empty($operationData['destination_cashbox_id'])
            ? (int) $operationData['destination_cashbox_id']
            : null;

        $amount = isset($operationData['amount'])
            ? (float) $operationData['amount']
            : 0;

        if (
            !in_array(
                $operationType,
                [
                    'encaissement',
                    'decaissement',
                    'approvisionnement',
                ],
                true
            )
        ) {
            return [
                'status' => false,
                'message' => 'Le type d’opération est invalide.',
            ];
        }

        if ($amount <= 0) {
            return [
                'status' => false,
                'message' => 'Le montant doit être supérieur à zéro.',
            ];
        }

        $this->db->trans_begin();

        try {
            $sourceCashbox = null;
            $destinationCashbox = null;

            /*
            * Verrouiller la caisse source.
            */
            if ($sourceCashboxId !== null) {
                $sourceCashbox =
                    $this->getCashboxByIdForUpdate(
                        $sourceCashboxId
                    );

                if (!$sourceCashbox) {
                    throw new RuntimeException(
                        'La caisse source est introuvable.'
                    );
                }

                if ($sourceCashbox->status !== 'active') {
                    throw new RuntimeException(
                        'La caisse source n’est pas active.'
                    );
                }

                if (
                    (float) $sourceCashbox->current_balance
                    < $amount
                ) {
                    throw new RuntimeException(
                        'Le solde disponible dans la caisse source est insuffisant.'
                    );
                }
            }

            /*
            * Verrouiller la caisse destination.
            */
            if ($destinationCashboxId !== null) {
                $destinationCashbox =
                    $this->getCashboxByIdForUpdate(
                        $destinationCashboxId
                    );

                if (!$destinationCashbox) {
                    throw new RuntimeException(
                        'La caisse destination est introuvable.'
                    );
                }

                if ($destinationCashbox->status !== 'active') {
                    throw new RuntimeException(
                        'La caisse destination n’est pas active.'
                    );
                }
            }

            /*
            * Vérifier les devises lors d’un transfert.
            */
            if (
                $operationType === 'approvisionnement'
                && $sourceCashbox
                && $destinationCashbox
                && $sourceCashbox->devise
                !== $destinationCashbox->devise
            ) {
                throw new RuntimeException(
                    'Les deux caisses doivent utiliser la même devise.'
                );
            }

            /*
            * Générer la référence.
            */
            $reference =
                $this->getNextCashboxOperationReference();

            $operationData['reference'] =
                $reference;

            /*
            * Insérer l’opération.
            */
            $inserted =
                $this->db->insert(
                    'tbl_finance_cashbox_operation',
                    $operationData
                );

            if (!$inserted) {
                throw new RuntimeException(
                    'Impossible d’enregistrer l’opération.'
                );
            }

            $operationId =
                (int) $this->db->insert_id();

            /*
            * Débiter la caisse source.
            */
            if ($sourceCashbox) {
                $newSourceBalance =
                    (float) $sourceCashbox->current_balance
                    - $amount;

                $updatedSource =
                    $this->db
                    ->where(
                        'id',
                        $sourceCashboxId
                    )
                    ->update(
                        'tbl_finance_cashbox',
                        [
                            'current_balance' =>
                            $newSourceBalance,
                        ]
                    );

                if (!$updatedSource) {
                    throw new RuntimeException(
                        'Impossible de débiter la caisse source.'
                    );
                }
            }

            /*
            * Créditer la caisse destination.
            */
            if ($destinationCashbox) {
                $newDestinationBalance =
                    (float) $destinationCashbox->current_balance
                    + $amount;

                $updatedDestination =
                    $this->db
                    ->where(
                        'id',
                        $destinationCashboxId
                    )
                    ->update(
                        'tbl_finance_cashbox',
                        [
                            'current_balance' =>
                            $newDestinationBalance,
                        ]
                    );

                if (!$updatedDestination) {
                    throw new RuntimeException(
                        'Impossible de créditer la caisse destination.'
                    );
                }
            }

            if ($this->db->trans_status() === false) {
                throw new RuntimeException(
                    'Une erreur est survenue pendant la transaction.'
                );
            }

            $this->db->trans_commit();

            return [
                'status' => true,
                'operation_id' => $operationId,
                'reference' => $reference,
                'message' => 'Opération enregistrée avec succès.',
            ];
        } catch (Throwable $exception) {
            $this->db->trans_rollback();

            log_message(
                'error',
                'Erreur opération de caisse : '
                    . $exception->getMessage()
            );

            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    /**
     * Retourne la situation des caisses avec filtres.
     *
     * Filtres disponibles :
     * - search       : code, nom, responsable ou chantier ;
     * - type         : siege ou chantier ;
     * - chantier_id  : chantier associé ;
     * - situation    : normal, faible ou critique.
     */
    public function getCashboxSituations(array $filters = []): array
    {
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        /*
        * =========================================================
        * NORMALISATION DES FILTRES
        * =========================================================
        */

        $search = isset($filters['search'])
            ? trim((string) $filters['search'])
            : '';

        $type = isset($filters['type'])
            ? trim((string) $filters['type'])
            : '';

        $chantierId = isset($filters['chantier_id'])
            ? (int) $filters['chantier_id']
            : 0;

        $situation = isset($filters['situation'])
            ? trim((string) $filters['situation'])
            : '';

        /*
            * =========================================================
            * REQUÊTE PRINCIPALE
            * =========================================================
            */

        $sql = "
            SELECT
                c.id,
                c.code,
                c.name,
                c.type,
                c.chantier_id,
                c.responsable,
                c.devise,
                c.opening_balance,
                c.current_balance,
                c.alert_threshold,
                c.observation,
                c.status,
                c.created_at,
                c.updated_at,

                ch.name AS chantier_name,
                ch.ref_chantier,
                ch.location,

                COALESCE(
                    movements.monthly_entries,
                    0
                ) AS monthly_entries,

                COALESCE(
                    movements.monthly_outputs,
                    0
                ) AS monthly_outputs,

                COALESCE(
                    movements.monthly_operations,
                    0
                ) AS monthly_operations,

                CASE

                    /*
                    * Critique :
                    * solde inférieur ou égal au seuil.
                    */
                    WHEN
                        c.alert_threshold > 0
                        AND c.current_balance
                            <= c.alert_threshold

                    THEN 'critique'

                    /*
                    * Faible :
                    * solde supérieur au seuil,
                    * mais inférieur ou égal au double du seuil.
                    */
                    WHEN
                        c.alert_threshold > 0
                        AND c.current_balance
                            > c.alert_threshold
                        AND c.current_balance
                            <= (c.alert_threshold * 2)

                    THEN 'faible'

                    /*
                    * Sinon la situation est normale.
                    */
                    ELSE 'normal'

                END AS balance_situation

            FROM tbl_finance_cashbox c

            LEFT JOIN chantiers ch
                ON ch.id = c.chantier_id

            LEFT JOIN
            (
                SELECT
                    all_movements.cashbox_id,

                    SUM(
                        all_movements.entry_amount
                    ) AS monthly_entries,

                    SUM(
                        all_movements.output_amount
                    ) AS monthly_outputs,

                    COUNT(
                        DISTINCT all_movements.operation_id
                    ) AS monthly_operations

                FROM
                (
                    /*
                    * Entrées dans les caisses.
                    */
                    SELECT
                        op.id AS operation_id,
                        op.destination_cashbox_id AS cashbox_id,
                        op.amount AS entry_amount,
                        0 AS output_amount

                    FROM tbl_finance_cashbox_operation op

                    WHERE op.destination_cashbox_id IS NOT NULL
                    AND op.status = 'validated'
                    AND op.operation_date BETWEEN ? AND ?

                    UNION ALL

                    /*
                    * Sorties depuis les caisses.
                    */
                    SELECT
                        op.id AS operation_id,
                        op.source_cashbox_id AS cashbox_id,
                        0 AS entry_amount,
                        op.amount AS output_amount

                    FROM tbl_finance_cashbox_operation op

                    WHERE op.source_cashbox_id IS NOT NULL
                    AND op.status = 'validated'
                    AND op.operation_date BETWEEN ? AND ?

                ) all_movements

                GROUP BY all_movements.cashbox_id

            ) movements
                ON movements.cashbox_id = c.id

            WHERE c.status = 'active'
        ";

        $queryParameters = [
            $monthStart,
            $monthEnd,
            $monthStart,
            $monthEnd,
        ];

        /*
        * =========================================================
        * FILTRE DE RECHERCHE
        * =========================================================
        */

        if ($search !== '') {
            $sql .= "
            AND
            (
                c.code LIKE ?
                OR c.name LIKE ?
                OR c.responsable LIKE ?
                OR ch.name LIKE ?
                OR ch.ref_chantier LIKE ?
                OR ch.location LIKE ?
            )
        ";

            $searchValue = '%' . $search . '%';

            $queryParameters[] = $searchValue;
            $queryParameters[] = $searchValue;
            $queryParameters[] = $searchValue;
            $queryParameters[] = $searchValue;
            $queryParameters[] = $searchValue;
            $queryParameters[] = $searchValue;
        }

        /*
        * =========================================================
        * FILTRE PAR TYPE
        * =========================================================
        */

        if (
            in_array(
                $type,
                ['siege', 'chantier'],
                true
            )
        ) {
            $sql .= "
            AND c.type = ?
        ";

            $queryParameters[] = $type;
        }

        /*
        * =========================================================
        * FILTRE PAR CHANTIER
        * =========================================================
        */

        if ($chantierId > 0) {
            $sql .= "
            AND c.chantier_id = ?
        ";

            $queryParameters[] = $chantierId;
        }

        /*
        * =========================================================
        * FILTRE PAR SITUATION
        * =========================================================
        */

        if ($situation === 'critique') {
            $sql .= "
            AND c.alert_threshold > 0
            AND c.current_balance
                <= c.alert_threshold
        ";
        } elseif ($situation === 'faible') {
            $sql .= "
            AND c.alert_threshold > 0
            AND c.current_balance
                > c.alert_threshold
            AND c.current_balance
                <= (c.alert_threshold * 2)
        ";
        } elseif ($situation === 'normal') {
            $sql .= "
            AND
            (
                c.alert_threshold <= 0
                OR c.current_balance
                    > (c.alert_threshold * 2)
            )
        ";
        }

        /*
        * =========================================================
        * TRI
        * =========================================================
        *
        * Ordre :
        * 1. caisse siège ;
        * 2. caisses critiques ;
        * 3. caisses faibles ;
        * 4. caisses normales ;
        * 5. nom de la caisse.
        */

        $sql .= "
            ORDER BY

                CASE
                    WHEN c.type = 'siege'
                        THEN 0
                    ELSE 1
                END ASC,

                CASE

                    WHEN
                        c.alert_threshold > 0
                        AND c.current_balance
                            <= c.alert_threshold
                        THEN 0

                    WHEN
                        c.alert_threshold > 0
                        AND c.current_balance
                            <= (c.alert_threshold * 2)
                        THEN 1

                    ELSE 2

                END ASC,

                c.name ASC
        ";

        return $this->db
            ->query(
                $sql,
                $queryParameters
            )
            ->result();
    }

    public function countActiveCashboxes(): int
    {
        return (int) $this->db
            ->where('status', 'active')
            ->count_all_results('tbl_finance_cashbox');
    }

    /**
     * Récupère les mouvements récents de caisse.
     *
     * Pour chaque opération :
     * - encaissement : on affiche la caisse destination ;
     * - décaissement : on affiche la caisse source ;
     * - approvisionnement : on affiche la caisse source.
     *
     * Le solde après opération est recalculé à partir :
     * - du solde initial ;
     * - des entrées validées ;
     * - des sorties validées.
     */
    public function getRecentCashboxMovements(int $limit = 10): array
    {
        $limit = max(1, min($limit, 100));

        $sql = "
            SELECT
                movement.id,
                movement.reference,
                movement.operation_type,
                movement.operation_date,
                movement.source_cashbox_id,
                movement.destination_cashbox_id,
                movement.amount,
                movement.currency,
                movement.category,
                movement.third_party,
                movement.payment_method,
                movement.document_number,
                movement.attachment,
                movement.label,
                movement.observation,
                movement.status,
                movement.created_by,
                movement.validated_by,
                movement.created_at,
                movement.updated_at,
                movement.cashbox_id,

                cashbox.code AS cashbox_code,
                cashbox.name AS cashbox_name,
                cashbox.type AS cashbox_type,
                cashbox.devise AS cashbox_currency,
                cashbox.opening_balance,

                source_cashbox.code AS source_cashbox_code,
                source_cashbox.name AS source_cashbox_name,

                destination_cashbox.code AS destination_cashbox_code,
                destination_cashbox.name AS destination_cashbox_name,

                (
                    cashbox.opening_balance

                    +

                    COALESCE(
                        (
                            SELECT SUM(incoming.amount)

                            FROM tbl_finance_cashbox_operation incoming

                            WHERE incoming.destination_cashbox_id
                                = movement.cashbox_id

                            AND incoming.status = 'validated'

                            AND
                            (
                                incoming.operation_date
                                    < movement.operation_date

                                OR
                                (
                                    incoming.operation_date
                                        = movement.operation_date

                                    AND incoming.created_at
                                        < movement.created_at
                                )

                                OR
                                (
                                    incoming.operation_date
                                        = movement.operation_date

                                    AND incoming.created_at
                                        = movement.created_at

                                    AND incoming.id
                                        <= movement.id
                                )
                            )
                        ),
                        0
                    )

                    -

                    COALESCE(
                        (
                            SELECT SUM(outgoing.amount)

                            FROM tbl_finance_cashbox_operation outgoing

                            WHERE outgoing.source_cashbox_id
                                = movement.cashbox_id

                            AND outgoing.status = 'validated'

                            AND
                            (
                                outgoing.operation_date
                                    < movement.operation_date

                                OR
                                (
                                    outgoing.operation_date
                                        = movement.operation_date

                                    AND outgoing.created_at
                                        < movement.created_at
                                )

                                OR
                                (
                                    outgoing.operation_date
                                        = movement.operation_date

                                    AND outgoing.created_at
                                        = movement.created_at

                                    AND outgoing.id
                                        <= movement.id
                                )
                            )
                        ),
                        0
                    )
                ) AS balance_after

            FROM
            (
                SELECT
                    operation.*,

                    CASE
                        WHEN operation.operation_type = 'encaissement'
                            THEN operation.destination_cashbox_id

                        WHEN operation.operation_type = 'decaissement'
                            THEN operation.source_cashbox_id

                        WHEN operation.operation_type = 'approvisionnement'
                            THEN operation.source_cashbox_id

                        ELSE operation.source_cashbox_id
                    END AS cashbox_id

                FROM tbl_finance_cashbox_operation operation

            ) movement

            INNER JOIN tbl_finance_cashbox cashbox
                ON cashbox.id = movement.cashbox_id

            LEFT JOIN tbl_finance_cashbox source_cashbox
                ON source_cashbox.id = movement.source_cashbox_id

            LEFT JOIN tbl_finance_cashbox destination_cashbox
                ON destination_cashbox.id
                    = movement.destination_cashbox_id

            ORDER BY
                movement.operation_date DESC,
                movement.created_at DESC,
                movement.id DESC

            LIMIT {$limit}
        ";

        return $this->db
            ->query($sql)
            ->result();
    }

    public function countCashboxMovements(): int
    {
        return (int) $this->db
            ->where('status !=', 'cancelled')
            ->count_all_results(
                'tbl_finance_cashbox_operation'
            );
    }

    /**
     * Retourne les principales dépenses du mois en cours,
     * regroupées par catégorie.
     *
     * Seuls les décaissements validés sont considérés comme dépenses.
     */
    public function getMonthlyMainExpenses(int $limit = 5): array
    {
        $limit = max(1, min($limit, 20));

        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        $sql = "
        SELECT
            CASE
                WHEN category IS NULL OR TRIM(category) = ''
                    THEN 'Autre'
                ELSE category
            END AS category,

            SUM(amount) AS total_amount,

            COUNT(id) AS total_operations

        FROM tbl_finance_cashbox_operation

        WHERE operation_type = 'decaissement'
        AND status = 'validated'
        AND operation_date BETWEEN ? AND ?

        GROUP BY
            CASE
                WHEN category IS NULL OR TRIM(category) = ''
                    THEN 'Autre'
                ELSE category
            END

        ORDER BY total_amount DESC

        LIMIT {$limit}
    ";

        $expenses = $this->db
            ->query(
                $sql,
                [
                    $monthStart,
                    $monthEnd,
                ]
            )
            ->result();

        /*
     * Le montant le plus élevé servira de référence
     * pour calculer la largeur des barres.
     */
        $maximumAmount = 0;

        if (!empty($expenses)) {
            $maximumAmount = (float) $expenses[0]->total_amount;
        }

        foreach ($expenses as $expense) {
            $expense->total_amount = (float) $expense->total_amount;

            if ($maximumAmount > 0) {
                $expense->percentage = (
                    $expense->total_amount / $maximumAmount
                ) * 100;
            } else {
                $expense->percentage = 0;
            }

            /*
         * Empêcher une barre trop petite d’être invisible.
         */
            if (
                $expense->total_amount > 0
                && $expense->percentage < 5
            ) {
                $expense->percentage = 5;
            }

            $expense->percentage = min(
                100,
                $expense->percentage
            );
        }

        return $expenses;
    }

    /**
     * Retourne la synthèse financière de chaque caisse chantier.
     *
     * Approvisionné :
     * solde initial + toutes les entrées validées.
     *
     * Consommé :
     * uniquement les décaissements validés.
     *
     * Disponible :
     * solde actuel enregistré dans la caisse.
     */
    public function getCashboxSummaryByChantier(): array
    {
        $sql = "
            SELECT
                c.id AS cashbox_id,
                c.code AS cashbox_code,
                c.name AS cashbox_name,
                c.chantier_id,
                c.devise,
                c.opening_balance,
                c.current_balance,
                c.alert_threshold,
                c.status AS cashbox_status,

                ch.name AS chantier_name,
                ch.ref_chantier,
                ch.location,
                ch.status AS chantier_status,

                /*
                * Total de toutes les entrées reçues par la caisse.
                *
                * Cela inclut :
                * - les encaissements directs ;
                * - les approvisionnements internes reçus.
                */
                COALESCE(
                    SUM(
                        CASE
                            WHEN op.destination_cashbox_id = c.id
                            AND op.status = 'validated'
                            THEN op.amount
                            ELSE 0
                        END
                    ),
                    0
                ) AS total_entries,

                /*
                * Consommation réelle :
                * uniquement les décaissements.
                */
                COALESCE(
                    SUM(
                        CASE
                            WHEN op.source_cashbox_id = c.id
                            AND op.operation_type = 'decaissement'
                            AND op.status = 'validated'
                            THEN op.amount
                            ELSE 0
                        END
                    ),
                    0
                ) AS total_consumed,

                /*
                * Transferts envoyés vers une autre caisse.
                *
                * Ce montant ne représente pas une dépense,
                * mais il réduit quand même le solde disponible.
                */
                COALESCE(
                    SUM(
                        CASE
                            WHEN op.source_cashbox_id = c.id
                            AND op.operation_type = 'approvisionnement'
                            AND op.status = 'validated'
                            THEN op.amount
                            ELSE 0
                        END
                    ),
                    0
                ) AS total_transferred_out,

                /*
                * Nombre total des mouvements liés à la caisse.
                */
                COUNT(
                    DISTINCT CASE
                        WHEN
                            (
                                op.source_cashbox_id = c.id
                                OR op.destination_cashbox_id = c.id
                            )
                            AND op.status = 'validated'
                        THEN op.id
                        ELSE NULL
                    END
                ) AS total_operations

            FROM tbl_finance_cashbox c

            LEFT JOIN chantiers ch
                ON ch.id = c.chantier_id

            LEFT JOIN tbl_finance_cashbox_operation op
                ON
                (
                    op.source_cashbox_id = c.id
                    OR op.destination_cashbox_id = c.id
                )

            WHERE c.type = 'chantier'
            AND c.status = 'active'

            GROUP BY
                c.id,
                c.code,
                c.name,
                c.chantier_id,
                c.devise,
                c.opening_balance,
                c.current_balance,
                c.alert_threshold,
                c.status,
                ch.name,
                ch.ref_chantier,
                ch.location,
                ch.status

            ORDER BY
                CASE
                    WHEN c.current_balance <= c.alert_threshold
                        THEN 0
                    ELSE 1
                END ASC,

                c.current_balance ASC,

                ch.name ASC
        ";

        $results = $this->db
            ->query($sql)
            ->result();

        foreach ($results as $result) {
            $openingBalance = (float) $result->opening_balance;
            $entries        = (float) $result->total_entries;
            $consumed       = (float) $result->total_consumed;

            /*
         * Total des fonds mis à disposition de la caisse.
         */
            $result->total_funded =
                $openingBalance + $entries;

            /*
         * Pourcentage de consommation réelle.
         */
            if ($result->total_funded > 0) {
                $result->consumption_percentage = (
                    $consumed / $result->total_funded
                ) * 100;
            } else {
                $result->consumption_percentage = 0;
            }

            $result->consumption_percentage = max(
                0,
                min(
                    100,
                    $result->consumption_percentage
                )
            );

            /*
         * Conversion des valeurs en nombres.
         */
            $result->opening_balance =
                $openingBalance;

            $result->current_balance =
                (float) $result->current_balance;

            $result->total_entries =
                $entries;

            $result->total_consumed =
                $consumed;

            $result->total_transferred_out =
                (float) $result->total_transferred_out;

            $result->total_operations =
                (int) $result->total_operations;
        }

        return $results;
    }

    /**
     * Évolution globale des encaissements et décaissements.
     *
     * Les approvisionnements internes sont volontairement exclus :
     * ils représentent un transfert entre deux caisses de SATRACO
     * et non une entrée ou une sortie réelle de l'entreprise.
     *
     * Périodes acceptées :
     * - 7days
     * - 30days
     * - month
     * - year
     */
    // public function getCashFlowEvolution(string $period = '7days'): array
    // {
    //     $today = date('Y-m-d');

    //     switch ($period) {
    //         case '30days':
    //             $startDate = date(
    //                 'Y-m-d',
    //                 strtotime('-29 days')
    //             );

    //             $endDate = $today;
    //             $groupFormat = '%Y-%m-%d';
    //             break;

    //         case 'month':
    //             $startDate = date('Y-m-01');
    //             $endDate = date('Y-m-t');
    //             $groupFormat = '%Y-%m-%d';
    //             break;

    //         case 'year':
    //             $startDate = date('Y-01-01');
    //             $endDate = date('Y-12-31');
    //             $groupFormat = '%Y-%m';
    //             break;

    //         case '7days':
    //         default:
    //             $period = '7days';

    //             $startDate = date(
    //                 'Y-m-d',
    //                 strtotime('-6 days')
    //             );

    //             $endDate = $today;
    //             $groupFormat = '%Y-%m-%d';
    //             break;
    //     }

    //     /*
    //     * =========================================================
    //     * RÉCUPÉRATION DES MOUVEMENTS AGRÉGÉS
    //     * =========================================================
    //     */

    //     $sql = "
    //         SELECT
    //             DATE_FORMAT(
    //                 operation_date,
    //                 ?
    //             ) AS period_key,

    //             COALESCE(
    //                 SUM(
    //                     CASE
    //                         WHEN operation_type = 'encaissement'
    //                         THEN amount
    //                         ELSE 0
    //                     END
    //                 ),
    //                 0
    //             ) AS total_income,

    //             COALESCE(
    //                 SUM(
    //                     CASE
    //                         WHEN operation_type = 'decaissement'
    //                         THEN amount
    //                         ELSE 0
    //                     END
    //                 ),
    //                 0
    //             ) AS total_expense

    //         FROM tbl_finance_cashbox_operation

    //         WHERE status = 'validated'

    //         AND operation_type IN (
    //             'encaissement',
    //             'decaissement'
    //         )

    //         AND operation_date BETWEEN ? AND ?

    //         GROUP BY
    //             DATE_FORMAT(
    //                 operation_date,
    //                 ?
    //             )

    //         ORDER BY period_key ASC
    //     ";          

    //     $queryResults = $this->db
    //         ->query(
    //             $sql,
    //             [
    //                 $groupFormat,
    //                 $startDate,
    //                 $endDate,
    //                 $groupFormat,
    //             ]
    //         )
    //         ->result();

    //     /*
    //  * Indexer les résultats par date ou par mois.
    //  */
    //     $indexedResults = [];

    //     foreach ($queryResults as $row) {
    //         $indexedResults[$row->period_key] = [
    //             'income'  => (float) $row->total_income,
    //             'expense' => (float) $row->total_expense,
    //         ];
    //     }

    //     $labels = [];
    //     $incomes = [];
    //     $expenses = [];

    //     /*
    //     * =========================================================
    //     * PÉRIODE ANNUELLE : UN POINT PAR MOIS
    //     * =========================================================
    //     */
    //     if ($period === 'year') {
    //         $monthNames = [
    //             1  => 'Janv.',
    //             2  => 'Févr.',
    //             3  => 'Mars',
    //             4  => 'Avr.',
    //             5  => 'Mai',
    //             6  => 'Juin',
    //             7  => 'Juil.',
    //             8  => 'Août',
    //             9  => 'Sept.',
    //             10 => 'Oct.',
    //             11 => 'Nov.',
    //             12 => 'Déc.',
    //         ];

    //         for ($month = 1; $month <= 12; $month++) {
    //             $key = date('Y')
    //                 . '-'
    //                 . str_pad(
    //                     (string) $month,
    //                     2,
    //                     '0',
    //                     STR_PAD_LEFT
    //                 );

    //             $labels[] = $monthNames[$month];

    //             $incomes[] = isset($indexedResults[$key])
    //                 ? $indexedResults[$key]['income']
    //                 : 0;

    //             $expenses[] = isset($indexedResults[$key])
    //                 ? $indexedResults[$key]['expense']
    //                 : 0;
    //         }
    //     }

    //     /*
    //  * =========================================================
    //  * AUTRES PÉRIODES : UN POINT PAR JOUR
    //  * =========================================================
    //  */ else {
    //         $startTimestamp = strtotime($startDate);
    //         $endTimestamp = strtotime($endDate);

    //         $monthNames = [
    //             1  => 'Janv.',
    //             2  => 'Févr.',
    //             3  => 'Mars',
    //             4  => 'Avr.',
    //             5  => 'Mai',
    //             6  => 'Juin',
    //             7  => 'Juil.',
    //             8  => 'Août',
    //             9  => 'Sept.',
    //             10 => 'Oct.',
    //             11 => 'Nov.',
    //             12 => 'Déc.',
    //         ];

    //         for (
    //             $timestamp = $startTimestamp;
    //             $timestamp <= $endTimestamp;
    //             $timestamp = strtotime(
    //                 '+1 day',
    //                 $timestamp
    //             )
    //         ) {
    //             $key = date(
    //                 'Y-m-d',
    //                 $timestamp
    //             );

    //             $day = date(
    //                 'd',
    //                 $timestamp
    //             );

    //             $monthNumber = (int) date(
    //                 'n',
    //                 $timestamp
    //             );

    //             $labels[] = $day
    //                 . ' '
    //                 . $monthNames[$monthNumber];

    //             $incomes[] = isset($indexedResults[$key])
    //                 ? $indexedResults[$key]['income']
    //                 : 0;

    //             $expenses[] = isset($indexedResults[$key])
    //                 ? $indexedResults[$key]['expense']
    //                 : 0;
    //         }
    //     }

    //     return [
    //         'period'     => $period,
    //         'start_date' => $startDate,
    //         'end_date'   => $endDate,
    //         'labels'     => $labels,
    //         'incomes'    => $incomes,
    //         'expenses'   => $expenses,
    //     ];
    // }

    /**
     * Retourne les alertes dynamiques de trésorerie.
     *
     * Types d’alertes :
     * - solde critique ;
     * - opération en attente ;
     * - justificatif manquant.
     */
    // public function getTreasuryAlerts(int $limit = 8): array
    // {
    //     $limit = max(
    //         1,
    //         min(
    //             $limit,
    //             30
    //         )
    //     );

    //     $alerts = [];

    //     /*
    //  * =========================================================
    //  * 1. CAISSES AVEC SOLDE CRITIQUE
    //  * =========================================================
    //  */

    //     $criticalCashboxes = $this->db
    //         ->select([
    //             'c.id',
    //             'c.code',
    //             'c.name',
    //             'c.type',
    //             'c.devise',
    //             'c.current_balance',
    //             'c.alert_threshold',
    //             'ch.name AS chantier_name',
    //         ])
    //         ->from('tbl_finance_cashbox c')
    //         ->join(
    //             'chantiers ch',
    //             'ch.id = c.chantier_id',
    //             'left'
    //         )
    //         ->where('c.status', 'active')
    //         ->where('c.alert_threshold >', 0)
    //         ->where(
    //             'c.current_balance <= c.alert_threshold',
    //             null,
    //             false
    //         )
    //         ->order_by('c.current_balance', 'ASC')
    //         ->get()
    //         ->result();

    //     foreach ($criticalCashboxes as $cashbox) {
    //         $displayName = !empty($cashbox->chantier_name)
    //             ? $cashbox->chantier_name
    //             : $cashbox->name;

    //         $alerts[] = [
    //             'type'       => 'danger',
    //             'icon'       => 'fas fa-wallet',
    //             'title'      => 'Solde critique — ' . $displayName,
    //             'message'    =>
    //             'Le solde disponible de '
    //                 . number_format(
    //                     (float) $cashbox->current_balance,
    //                     0,
    //                     ',',
    //                     ' '
    //                 )
    //                 . ' '
    //                 . $cashbox->devise
    //                 . ' est inférieur ou égal au seuil de '
    //                 . number_format(
    //                     (float) $cashbox->alert_threshold,
    //                     0,
    //                     ',',
    //                     ' '
    //                 )
    //                 . ' '
    //                 . $cashbox->devise
    //                 . '.',

    //             'priority'   => 1,
    //             'created_at' => null,
    //         ];
    //     }

    //     /*
    //  * =========================================================
    //  * 2. OPÉRATIONS EN ATTENTE
    //  * =========================================================
    //  */

    //     $pendingOperations = $this->db
    //         ->select([
    //             'op.id',
    //             'op.reference',
    //             'op.operation_type',
    //             'op.amount',
    //             'op.currency',
    //             'op.label',
    //             'op.created_at',
    //             'source.name AS source_name',
    //             'destination.name AS destination_name',
    //         ])
    //         ->from('tbl_finance_cashbox_operation op')
    //         ->join(
    //             'tbl_finance_cashbox source',
    //             'source.id = op.source_cashbox_id',
    //             'left'
    //         )
    //         ->join(
    //             'tbl_finance_cashbox destination',
    //             'destination.id = op.destination_cashbox_id',
    //             'left'
    //         )
    //         ->where('op.status', 'pending')
    //         ->order_by('op.created_at', 'ASC')
    //         ->limit(5)
    //         ->get()
    //         ->result();

    //     foreach ($pendingOperations as $operation) {
    //         $operationLabel = 'Opération en attente';

    //         if (
    //             $operation->operation_type
    //             === 'approvisionnement'
    //         ) {
    //             $operationLabel =
    //                 'Approvisionnement en attente';
    //         } elseif (
    //             $operation->operation_type
    //             === 'encaissement'
    //         ) {
    //             $operationLabel =
    //                 'Encaissement en attente';
    //         } elseif (
    //             $operation->operation_type
    //             === 'decaissement'
    //         ) {
    //             $operationLabel =
    //                 'Décaissement en attente';
    //         }

    //         $message = $operation->reference
    //             . ' — '
    //             . number_format(
    //                 (float) $operation->amount,
    //                 0,
    //                 ',',
    //                 ' '
    //             )
    //             . ' '
    //             . $operation->currency;

    //         if (
    //             $operation->operation_type
    //             === 'approvisionnement'
    //             && !empty($operation->destination_name)
    //         ) {
    //             $message .=
    //                 ' vers '
    //                 . $operation->destination_name;
    //         }

    //         $alerts[] = [
    //             'type'       => 'warning',
    //             'icon'       => 'fas fa-clock',
    //             'title'      => $operationLabel,
    //             'message'    => $message
    //                 . ' attend une validation.',

    //             'priority'   => 2,
    //             'created_at' => $operation->created_at,
    //         ];
    //     }

    //     /*
    //  * =========================================================
    //  * 3. DÉCAISSEMENTS SANS JUSTIFICATIF
    //  * =========================================================
    //  */

    //     $missingAttachments = $this->db
    //         ->select([
    //             'op.id',
    //             'op.reference',
    //             'op.amount',
    //             'op.currency',
    //             'op.category',
    //             'op.third_party',
    //             'op.created_at',
    //             'c.name AS cashbox_name',
    //         ])
    //         ->from('tbl_finance_cashbox_operation op')
    //         ->join(
    //             'tbl_finance_cashbox c',
    //             'c.id = op.source_cashbox_id',
    //             'left'
    //         )
    //         ->where(
    //             'op.operation_type',
    //             'decaissement'
    //         )
    //         ->where(
    //             'op.status',
    //             'validated'
    //         )
    //         ->group_start()
    //         ->where(
    //             'op.attachment IS NULL',
    //             null,
    //             false
    //         )
    //         ->or_where(
    //             'op.attachment',
    //             ''
    //         )
    //         ->group_end()
    //         ->order_by('op.amount', 'DESC')
    //         ->limit(5)
    //         ->get()
    //         ->result();

    //     foreach ($missingAttachments as $operation) {
    //         $alerts[] = [
    //             'type'  => 'info',
    //             'icon'  => 'fas fa-file-alt',
    //             'title' => 'Justificatif manquant',

    //             'message' =>
    //             'Le décaissement '
    //                 . $operation->reference
    //                 . ' de '
    //                 . number_format(
    //                     (float) $operation->amount,
    //                     0,
    //                     ',',
    //                     ' '
    //                 )
    //                 . ' '
    //                 . $operation->currency
    //                 . ' dans '
    //                 . (
    //                     $operation->cashbox_name
    //                     ?: 'une caisse'
    //                 )
    //                 . ' ne possède pas de pièce justificative.',

    //             'priority'   => 3,
    //             'created_at' => $operation->created_at,
    //         ];
    //     }

    //     /*
    //  * Trier les alertes :
    //  * danger, warning, puis information.
    //  */
    //     usort(
    //         $alerts,
    //         function (
    //             array $firstAlert,
    //             array $secondAlert
    //         ): int {
    //             return $firstAlert['priority']
    //                 <=> $secondAlert['priority'];
    //         }
    //     );

    //     return array_slice(
    //         $alerts,
    //         0,
    //         $limit
    //     );
    // }

    public function countTreasuryAlerts(): int
    {
        $criticalCashboxes = (int) $this->db
            ->where('status', 'active')
            ->where('alert_threshold >', 0)
            ->where(
                'current_balance <= alert_threshold',
                null,
                false
            )
            ->count_all_results(
                'tbl_finance_cashbox'
            );

        $pendingOperations = (int) $this->db
            ->where('status', 'pending')
            ->count_all_results(
                'tbl_finance_cashbox_operation'
            );

        $this->db
            ->where(
                'operation_type',
                'decaissement'
            )
            ->where(
                'status',
                'validated'
            )
            ->group_start()
            ->where(
                'attachment IS NULL',
                null,
                false
            )
            ->or_where(
                'attachment',
                ''
            )
            ->group_end();

        $missingAttachments = (int) $this->db
            ->count_all_results(
                'tbl_finance_cashbox_operation'
            );

        return
            $criticalCashboxes
            + $pendingOperations
            + $missingAttachments;
    }

    /**
     * Retourne les statistiques principales des caisses.
     *
     * Les montants affichés dans les cartes sont calculés en BIF.
     *
     * Résultats :
     * - solde global disponible ;
     * - solde des caisses siège ;
     * - solde des caisses chantier ;
     * - nombre de caisses chantier ;
     * - décaissements du jour ;
     * - nombre de décaissements du jour ;
     * - variation du solde global depuis le début du mois.
     */
    public function getCashboxMainStatistics(): array
    {
        $currency = 'BIF';

        $today = date('Y-m-d');
        $monthStart = date('Y-m-01');

        /*
        * =========================================================
        * 1. SOLDE GLOBAL DES CAISSES ACTIVES
        * =========================================================
        */

        $globalRow = $this->db
            ->select("
            COALESCE(
                SUM(current_balance),
                0
            ) AS global_balance,

            COUNT(id) AS total_cashboxes
        ", false)
            ->from('tbl_finance_cashbox')
            ->where('status', 'active')
            ->where('devise', $currency)
            ->get()
            ->row();

        $globalBalance = $globalRow
            ? (float) $globalRow->global_balance
            : 0;

        $totalCashboxes = $globalRow
            ? (int) $globalRow->total_cashboxes
            : 0;

        /*
        * =========================================================
        * 2. CAISSES SIÈGE
        * =========================================================
        */

        $headOfficeRow = $this->db
            ->select("
            COALESCE(
                SUM(current_balance),
                0
            ) AS head_office_balance,

            COUNT(id) AS head_office_count
        ", false)
            ->from('tbl_finance_cashbox')
            ->where('status', 'active')
            ->where('type', 'siege')
            ->where('devise', $currency)
            ->get()
            ->row();

        $headOfficeBalance = $headOfficeRow
            ? (float) $headOfficeRow->head_office_balance
            : 0;

        $headOfficeCount = $headOfficeRow
            ? (int) $headOfficeRow->head_office_count
            : 0;

        /*
     * =========================================================
     * 3. CAISSES CHANTIERS
     * =========================================================
     */

        $constructionRow = $this->db
            ->select("
            COALESCE(
                SUM(current_balance),
                0
            ) AS construction_balance,

            COUNT(id) AS construction_count
        ", false)
            ->from('tbl_finance_cashbox')
            ->where('status', 'active')
            ->where('type', 'chantier')
            ->where('devise', $currency)
            ->get()
            ->row();

        $constructionBalance = $constructionRow
            ? (float) $constructionRow->construction_balance
            : 0;

        $constructionCount = $constructionRow
            ? (int) $constructionRow->construction_count
            : 0;

        /*
     * =========================================================
     * 4. DÉCAISSEMENTS DU JOUR
     * =========================================================
     *
     * On compte uniquement les véritables décaissements.
     * Les approvisionnements entre caisses sont exclus,
     * car ce sont des transferts internes.
     */

        $todayDisbursementRow = $this->db
            ->select("
            COALESCE(
                SUM(amount),
                0
            ) AS total_amount,

            COUNT(id) AS total_operations
        ", false)
            ->from('tbl_finance_cashbox_operation')
            ->where('operation_type', 'decaissement')
            ->where('status', 'validated')
            ->where('operation_date', $today)
            ->where('currency', $currency)
            ->get()
            ->row();

        $todayDisbursementAmount = $todayDisbursementRow
            ? (float) $todayDisbursementRow->total_amount
            : 0;

        $todayDisbursementCount = $todayDisbursementRow
            ? (int) $todayDisbursementRow->total_operations
            : 0;

        /*
     * =========================================================
     * 5. MOUVEMENT NET DU MOIS
     * =========================================================
     *
     * Encaissement :
     * augmente la trésorerie globale.
     *
     * Décaissement :
     * réduit la trésorerie globale.
     *
     * Approvisionnement :
     * exclu, car le montant quitte une caisse mais entre
     * dans une autre caisse de la même entreprise.
     */

        $monthlyFlowRow = $this->db
            ->select("
            COALESCE(
                SUM(
                    CASE
                        WHEN operation_type = 'encaissement'
                        THEN amount
                        ELSE 0
                    END
                ),
                0
            ) AS monthly_income,

            COALESCE(
                SUM(
                    CASE
                        WHEN operation_type = 'decaissement'
                        THEN amount
                        ELSE 0
                    END
                ),
                0
            ) AS monthly_expense
        ", false)
            ->from('tbl_finance_cashbox_operation')
            ->where('status', 'validated')
            ->where('currency', $currency)
            ->where('operation_date >=', $monthStart)
            ->where('operation_date <=', $today)
            ->where_in(
                'operation_type',
                [
                    'encaissement',
                    'decaissement',
                ]
            )
            ->get()
            ->row();

        $monthlyIncome = $monthlyFlowRow
            ? (float) $monthlyFlowRow->monthly_income
            : 0;

        $monthlyExpense = $monthlyFlowRow
            ? (float) $monthlyFlowRow->monthly_expense
            : 0;

        $monthlyNetFlow = $monthlyIncome - $monthlyExpense;

        /*
     * Solde global estimé au début du mois.
     *
     * Solde actuel =
     * solde début du mois + flux net du mois
     *
     * Donc :
     * solde début du mois =
     * solde actuel - flux net du mois
     */
        $monthOpeningBalance = $globalBalance - $monthlyNetFlow;

        /*
     * Pourcentage d’évolution depuis le début du mois.
     */
        $globalVariationPercentage = 0;

        if ($monthOpeningBalance != 0) {
            $globalVariationPercentage = (
                (
                    $globalBalance
                    - $monthOpeningBalance
                )
                / abs($monthOpeningBalance)
            ) * 100;
        }

        /*
     * Part de la caisse siège dans le solde global.
     */
        $headOfficePercentage = 0;

        if ($globalBalance > 0) {
            $headOfficePercentage = (
                $headOfficeBalance
                / $globalBalance
            ) * 100;
        }

        /*
     * Part des caisses chantier dans le solde global.
     */
        $constructionPercentage = 0;

        if ($globalBalance > 0) {
            $constructionPercentage = (
                $constructionBalance
                / $globalBalance
            ) * 100;
        }

        return [
            'currency' => $currency,

            'global_balance' => $globalBalance,
            'total_cashboxes' => $totalCashboxes,

            'head_office_balance' => $headOfficeBalance,
            'head_office_count' => $headOfficeCount,
            'head_office_percentage' => $headOfficePercentage,

            'construction_balance' => $constructionBalance,
            'construction_count' => $constructionCount,
            'construction_percentage' => $constructionPercentage,

            'today_disbursement_amount' =>
            $todayDisbursementAmount,

            'today_disbursement_count' =>
            $todayDisbursementCount,

            'monthly_income' => $monthlyIncome,
            'monthly_expense' => $monthlyExpense,
            'monthly_net_flow' => $monthlyNetFlow,
            'month_opening_balance' => $monthOpeningBalance,

            'global_variation_percentage' =>
            $globalVariationPercentage,
        ];
    }

    /**
     * Insère un nouveau compte bancaire.
     */
    public function createBankAccount(array $data): bool
    {
        return $this->db->insert(
            'tbl_finance_bank_account',
            $data
        );
    }

    /**
     * Recherche un compte bancaire par identifiant.
     */
    public function getBankAccountById(int $id)
    {
        return $this->db
            ->where('id', $id)
            ->get('tbl_finance_bank_account')
            ->row();
    }

    /**
     * Retourne le prochain code bancaire prévisionnel.
     *
     * La véritable génération reste effectuée
     * pendant l’enregistrement.
     */
    public function getNextBankAccountCode(): string
    {
        $year = date('Y');

        $prefix = 'BAN-' . $year . '-';

        $lastAccount = $this->db
            ->select('code')
            ->from('tbl_finance_bank_account')
            ->like(
                'code',
                $prefix,
                'after'
            )
            ->order_by('code', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        $nextNumber = 1;

        if (
            $lastAccount
            && !empty($lastAccount->code)
        ) {
            $parts = explode(
                '-',
                $lastAccount->code
            );

            $lastNumber = (int) end($parts);

            $nextNumber = $lastNumber + 1;
        }

        return $prefix
            . str_pad(
                (string) $nextNumber,
                3,
                '0',
                STR_PAD_LEFT
            );
    }

    /**
     * Retourne les comptes bancaires actifs.
     */
    public function getAllActiveBankAccounts(): array
    {
        return $this->db
            ->select([
                'id',
                'code',
                'name',
                'bank_name',
                'account_number',
                'account_type',
                'currency',
                'current_balance',
                'status',
            ])
            ->from('tbl_finance_bank_account')
            ->where('status', 'active')
            ->order_by('bank_name', 'ASC')
            ->order_by('name', 'ASC')
            ->get()
            ->result();
    }


    /**
     * Génère une référence bancaire :
     *
     * BMV-2026-00001
     * BMV-2026-00002
     */
    private function generateBankOperationReference(): string
    {
        $year = date('Y');

        $prefix = 'BMV-' . $year . '-';

        $lastOperation = $this->db
            ->select('reference')
            ->from('tbl_finance_bank_operation')
            ->like(
                'reference',
                $prefix,
                'after'
            )
            ->order_by('reference', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        $nextNumber = 1;

        if (
            $lastOperation
            && !empty($lastOperation->reference)
        ) {
            $parts = explode(
                '-',
                $lastOperation->reference
            );

            $lastNumber = (int) end($parts);

            $nextNumber =
                $lastNumber + 1;
        }

        $reference = $prefix
            . str_pad(
                (string) $nextNumber,
                5,
                '0',
                STR_PAD_LEFT
            );

        while (
            $this->db
            ->where(
                'reference',
                $reference
            )
            ->count_all_results(
                'tbl_finance_bank_operation'
            ) > 0
        ) {
            $nextNumber++;

            $reference = $prefix
                . str_pad(
                    (string) $nextNumber,
                    5,
                    '0',
                    STR_PAD_LEFT
                );
        }

        return $reference;
    }

    /**
     * Enregistre une opération bancaire et met à jour
     * les soldes des comptes concernés.
     */
    public function createBankOperation(
        array $operationData
    ): array {
        $this->db->trans_begin();

        try {
            $operationType =
                $operationData['operation_type'];

            $amount =
                (float) $operationData['amount'];

            $sourceAccountId =
                !empty($operationData['source_bank_account_id'])
                ? (int) $operationData['source_bank_account_id']
                : NULL;

            $destinationAccountId =
                !empty($operationData['destination_bank_account_id'])
                ? (int) $operationData['destination_bank_account_id']
                : NULL;

            /*
         * =====================================================
         * 1. VERROUILLER ET VÉRIFIER LA SOURCE
         * =====================================================
         */

            $sourceAccount = NULL;

            if ($sourceAccountId) {
                $sourceAccount = $this->db
                    ->query(
                        "
                    SELECT *
                    FROM tbl_finance_bank_account
                    WHERE id = ?
                    FOR UPDATE
                    ",
                        [$sourceAccountId]
                    )
                    ->row();

                if (!$sourceAccount) {
                    throw new Exception(
                        'Le compte bancaire source est introuvable.'
                    );
                }

                if ($sourceAccount->status !== 'active') {
                    throw new Exception(
                        'Le compte bancaire source n’est pas actif.'
                    );
                }

                if (
                    (float) $sourceAccount
                        ->current_balance
                    < $amount
                ) {
                    throw new Exception(
                        'Le solde du compte bancaire source est insuffisant.'
                    );
                }
            }

            /*
         * =====================================================
         * 2. VERROUILLER ET VÉRIFIER LA DESTINATION
         * =====================================================
         */

            $destinationAccount = NULL;

            if ($destinationAccountId) {
                $destinationAccount = $this->db
                    ->query(
                        "
                    SELECT *
                    FROM tbl_finance_bank_account
                    WHERE id = ?
                    FOR UPDATE
                    ",
                        [$destinationAccountId]
                    )
                    ->row();

                if (!$destinationAccount) {
                    throw new Exception(
                        'Le compte bancaire destination est introuvable.'
                    );
                }

                if (
                    $destinationAccount->status
                    !== 'active'
                ) {
                    throw new Exception(
                        'Le compte bancaire destination n’est pas actif.'
                    );
                }
            }

            /*
         * =====================================================
         * 3. CONTRÔLES DU TRANSFERT
         * =====================================================
         */

            if ($operationType === 'transfert') {
                if (
                    !$sourceAccount
                    || !$destinationAccount
                ) {
                    throw new Exception(
                        'Le compte source et le compte destination sont obligatoires pour un transfert.'
                    );
                }

                if (
                    $sourceAccountId
                    === $destinationAccountId
                ) {
                    throw new Exception(
                        'Le compte source et le compte destination doivent être différents.'
                    );
                }

                if (
                    $sourceAccount->currency
                    !== $destinationAccount->currency
                ) {
                    throw new Exception(
                        'Les comptes source et destination doivent utiliser la même devise.'
                    );
                }
            }

            /*
         * =====================================================
         * 4. GÉNÉRER LA RÉFÉRENCE
         * =====================================================
         */

            $reference =
                $this->generateBankOperationReference();

            $operationData['reference'] =
                $reference;

            /*
         * =====================================================
         * 5. INSÉRER L’OPÉRATION
         * =====================================================
         */

            $inserted = $this->db->insert(
                'tbl_finance_bank_operation',
                $operationData
            );

            if (!$inserted) {
                throw new Exception(
                    'Impossible d’enregistrer l’opération bancaire.'
                );
            }

            $operationId =
                (int) $this->db->insert_id();

            /*
         * =====================================================
         * 6. METTRE À JOUR LE COMPTE SOURCE
         * =====================================================
         */

            if (
                in_array(
                    $operationType,
                    ['decaissement', 'transfert'],
                    TRUE
                )
            ) {
                $newSourceBalance =
                    (float) $sourceAccount
                        ->current_balance
                    - $amount;

                $updatedSource = $this->db
                    ->where(
                        'id',
                        $sourceAccountId
                    )
                    ->update(
                        'tbl_finance_bank_account',
                        [
                            'current_balance' =>
                            $newSourceBalance,

                            'updated_at' =>
                            date(
                                'Y-m-d H:i:s'
                            ),
                        ]
                    );

                if (!$updatedSource) {
                    throw new Exception(
                        'Impossible de mettre à jour le solde du compte source.'
                    );
                }
            }

            /*
         * =====================================================
         * 7. METTRE À JOUR LA DESTINATION
         * =====================================================
         */

            if (
                in_array(
                    $operationType,
                    ['encaissement', 'transfert'],
                    TRUE
                )
            ) {
                $newDestinationBalance =
                    (float) $destinationAccount
                        ->current_balance
                    + $amount;

                $updatedDestination = $this->db
                    ->where(
                        'id',
                        $destinationAccountId
                    )
                    ->update(
                        'tbl_finance_bank_account',
                        [
                            'current_balance' =>
                            $newDestinationBalance,

                            'updated_at' =>
                            date(
                                'Y-m-d H:i:s'
                            ),
                        ]
                    );

                if (!$updatedDestination) {
                    throw new Exception(
                        'Impossible de mettre à jour le solde du compte destination.'
                    );
                }
            }

            /*
         * =====================================================
         * 8. VALIDER LA TRANSACTION
         * =====================================================
         */

            if (
                $this->db->trans_status()
                === FALSE
            ) {
                throw new Exception(
                    'Une erreur est survenue pendant la transaction bancaire.'
                );
            }

            $this->db->trans_commit();

            return [
                'status' =>
                TRUE,

                'operation_id' =>
                $operationId,

                'reference' =>
                $reference,

                'message' =>
                'Opération bancaire enregistrée avec succès.',
            ];
        } catch (Throwable $exception) {
            $this->db->trans_rollback();

            log_message(
                'error',
                'Erreur opération bancaire : '
                    . $exception->getMessage()
            );

            return [
                'status' =>
                FALSE,

                'message' =>
                $exception->getMessage(),
            ];
        }
    }

    public function getNextBankOperationReference(): string
    {
        $year = date('Y');

        $prefix = 'BMV-' . $year . '-';

        $lastOperation = $this->db
            ->select('reference')
            ->from('tbl_finance_bank_operation')
            ->like(
                'reference',
                $prefix,
                'after'
            )
            ->order_by('reference', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        $nextNumber = 1;

        if (
            $lastOperation
            && !empty($lastOperation->reference)
        ) {
            $parts = explode(
                '-',
                $lastOperation->reference
            );

            $nextNumber =
                ((int) end($parts)) + 1;
        }

        return $prefix
            . str_pad(
                (string) $nextNumber,
                5,
                '0',
                STR_PAD_LEFT
            );
    }

    /**
     * Retourne les statistiques principales des comptes bancaires.
     *
     * Montants affichés :
     * - solde bancaire global en BIF ;
     * - comptes actifs ;
     * - établissements bancaires ;
     * - encaissements bancaires du jour ;
     * - décaissements bancaires du jour ;
     * - variation du solde depuis le début du mois.
     */
    public function getBankMainStatistics(): array
    {
        $currency = 'BIF';
        $today = date('Y-m-d');
        $monthStart = date('Y-m-01');

        /*
     * =========================================================
     * 1. SOLDE BANCAIRE GLOBAL
     * =========================================================
     */

        $globalRow = $this->db
            ->select("
            COALESCE(
                SUM(current_balance),
                0
            ) AS global_balance,

            COUNT(id) AS active_accounts,

            COUNT(
                DISTINCT bank_name
            ) AS bank_count
        ", false)
            ->from('tbl_finance_bank_account')
            ->where('status', 'active')
            ->where('currency', $currency)
            ->get()
            ->row();

        $globalBalance = $globalRow
            ? (float) $globalRow->global_balance
            : 0;

        /*
     * Ici, active_accounts compte uniquement
     * les comptes actifs en BIF.
     *
     * Le nombre total des comptes actifs,
     * toutes devises confondues, sera calculé
     * séparément plus bas.
     */

        $activeBifAccounts = $globalRow
            ? (int) $globalRow->active_accounts
            : 0;

        $bifBankCount = $globalRow
            ? (int) $globalRow->bank_count
            : 0;

        /*
     * =========================================================
     * 2. NOMBRE TOTAL DE COMPTES ACTIFS
     * =========================================================
     */

        $activeAccountsRow = $this->db
            ->select("
            COUNT(id) AS active_accounts,

            COUNT(
                DISTINCT bank_name
            ) AS bank_count
        ", false)
            ->from('tbl_finance_bank_account')
            ->where('status', 'active')
            ->get()
            ->row();

        $activeAccounts = $activeAccountsRow
            ? (int) $activeAccountsRow->active_accounts
            : 0;

        $bankCount = $activeAccountsRow
            ? (int) $activeAccountsRow->bank_count
            : 0;

        /*
     * =========================================================
     * 3. ENCAISSEMENTS BANCAIRES DU JOUR
     * =========================================================
     *
     * Un encaissement bancaire augmente la trésorerie globale.
     *
     * Le compte concerné est stocké dans :
     * destination_bank_account_id.
     */

        $todayIncomeRow = $this->db
            ->select("
            COALESCE(
                SUM(amount),
                0
            ) AS total_amount,

            COUNT(id) AS total_operations
        ", false)
            ->from('tbl_finance_bank_operation')
            ->where(
                'operation_type',
                'encaissement'
            )
            ->where(
                'operation_date',
                $today
            )
            ->where(
                'status',
                'validated'
            )
            ->where(
                'currency',
                $currency
            )
            ->get()
            ->row();

        $todayIncomeAmount = $todayIncomeRow
            ? (float) $todayIncomeRow->total_amount
            : 0;

        $todayIncomeCount = $todayIncomeRow
            ? (int) $todayIncomeRow->total_operations
            : 0;

        /*
     * =========================================================
     * 4. DÉCAISSEMENTS BANCAIRES DU JOUR
     * =========================================================
     *
     * Un décaissement bancaire diminue la trésorerie globale.
     *
     * Les transferts internes sont exclus.
     */

        $todayExpenseRow = $this->db
            ->select("
            COALESCE(
                SUM(amount),
                0
            ) AS total_amount,

            COUNT(id) AS total_operations
        ", false)
            ->from('tbl_finance_bank_operation')
            ->where(
                'operation_type',
                'decaissement'
            )
            ->where(
                'operation_date',
                $today
            )
            ->where(
                'status',
                'validated'
            )
            ->where(
                'currency',
                $currency
            )
            ->get()
            ->row();

        $todayExpenseAmount = $todayExpenseRow
            ? (float) $todayExpenseRow->total_amount
            : 0;

        $todayExpenseCount = $todayExpenseRow
            ? (int) $todayExpenseRow->total_operations
            : 0;

        /*
     * =========================================================
     * 5. FLUX DU MOIS
     * =========================================================
     *
     * Cette partie sert à calculer la variation affichée
     * sur la première carte.
     */

        $monthlyFlowRow = $this->db
            ->select("
            COALESCE(
                SUM(
                    CASE
                        WHEN operation_type = 'encaissement'
                        THEN amount
                        ELSE 0
                    END
                ),
                0
            ) AS monthly_income,

            COALESCE(
                SUM(
                    CASE
                        WHEN operation_type = 'decaissement'
                        THEN amount
                        ELSE 0
                    END
                ),
                0
            ) AS monthly_expense
        ", false)
            ->from('tbl_finance_bank_operation')
            ->where('status', 'validated')
            ->where('currency', $currency)
            ->where('operation_date >=', $monthStart)
            ->where('operation_date <=', $today)
            ->where_in(
                'operation_type',
                [
                    'encaissement',
                    'decaissement',
                ]
            )
            ->get()
            ->row();

        $monthlyIncome = $monthlyFlowRow
            ? (float) $monthlyFlowRow->monthly_income
            : 0;

        $monthlyExpense = $monthlyFlowRow
            ? (float) $monthlyFlowRow->monthly_expense
            : 0;

        $monthlyNetFlow =
            $monthlyIncome
            - $monthlyExpense;

        /*
     * Solde actuel =
     * solde au début du mois + mouvement net du mois.
     *
     * Donc :
     * solde début mois =
     * solde actuel - mouvement net du mois.
     */

        $monthOpeningBalance =
            $globalBalance
            - $monthlyNetFlow;

        $globalVariationPercentage = 0;

        if ($monthOpeningBalance != 0) {
            $globalVariationPercentage = (
                (
                    $globalBalance
                    - $monthOpeningBalance
                )
                / abs($monthOpeningBalance)
            ) * 100;
        }

        return [
            'currency' => $currency,

            'global_balance' =>
            $globalBalance,

            'active_accounts' =>
            $activeAccounts,

            'active_bif_accounts' =>
            $activeBifAccounts,

            'bank_count' =>
            $bankCount,

            'bif_bank_count' =>
            $bifBankCount,

            'today_income_amount' =>
            $todayIncomeAmount,

            'today_income_count' =>
            $todayIncomeCount,

            'today_expense_amount' =>
            $todayExpenseAmount,

            'today_expense_count' =>
            $todayExpenseCount,

            'monthly_income' =>
            $monthlyIncome,

            'monthly_expense' =>
            $monthlyExpense,

            'monthly_net_flow' =>
            $monthlyNetFlow,

            'month_opening_balance' =>
            $monthOpeningBalance,

            'global_variation_percentage' =>
            $globalVariationPercentage,
        ];
    }

    /**
     * Retourne l'évolution des flux bancaires.
     *
     * Périodes acceptées :
     * - 7days
     * - 30days
     * - month
     * - year
     *
     * Les transferts internes sont exclus.
     */
    public function getBankFlowEvolution(string $period = '7days'): array
    {
        $today = date('Y-m-d');

        switch ($period) {
            case '30days':
                $startDate = date(
                    'Y-m-d',
                    strtotime('-29 days')
                );

                $endDate = $today;
                $groupFormat = '%Y-%m-%d';
                break;

            case 'month':
                $startDate = date('Y-m-01');
                $endDate = date('Y-m-t');
                $groupFormat = '%Y-%m-%d';
                break;

            case 'year':
                $startDate = date('Y-01-01');
                $endDate = date('Y-12-31');
                $groupFormat = '%Y-%m';
                break;

            case '7days':
            default:
                $period = '7days';

                $startDate = date(
                    'Y-m-d',
                    strtotime('-6 days')
                );

                $endDate = $today;
                $groupFormat = '%Y-%m-%d';
                break;
        }

        /*
     * =========================================================
     * RÉCUPÉRER LES OPÉRATIONS AGRÉGÉES
     * =========================================================
     */

        $sql = "
        SELECT
            DATE_FORMAT(
                operation_date,
                ?
            ) AS period_key,

            COALESCE(
                SUM(
                    CASE
                        WHEN operation_type = 'encaissement'
                        THEN amount
                        ELSE 0
                    END
                ),
                0
            ) AS total_income,

            COALESCE(
                SUM(
                    CASE
                        WHEN operation_type = 'decaissement'
                        THEN amount
                        ELSE 0
                    END
                ),
                0
            ) AS total_expense

        FROM tbl_finance_bank_operation

        WHERE status = 'validated'

        AND operation_type IN (
            'encaissement',
            'decaissement'
        )

        AND currency = 'BIF'

        AND operation_date BETWEEN ? AND ?

        GROUP BY
            DATE_FORMAT(
                operation_date,
                ?
            )

        ORDER BY period_key ASC
    ";

        $rows = $this->db
            ->query(
                $sql,
                [
                    $groupFormat,
                    $startDate,
                    $endDate,
                    $groupFormat,
                ]
            )
            ->result();

        /*
     * Indexer les résultats.
     */
        $indexedResults = [];

        foreach ($rows as $row) {
            $indexedResults[$row->period_key] = [
                'income' =>
                (float) $row->total_income,

                'expense' =>
                (float) $row->total_expense,
            ];
        }

        $labels = [];
        $incomes = [];
        $expenses = [];

        $monthNames = [
            1  => 'Janv.',
            2  => 'Févr.',
            3  => 'Mars',
            4  => 'Avr.',
            5  => 'Mai',
            6  => 'Juin',
            7  => 'Juil.',
            8  => 'Août',
            9  => 'Sept.',
            10 => 'Oct.',
            11 => 'Nov.',
            12 => 'Déc.',
        ];

        /*
     * =========================================================
     * ANNÉE : UN POINT PAR MOIS
     * =========================================================
     */

        if ($period === 'year') {
            for ($month = 1; $month <= 12; $month++) {
                $key = date('Y')
                    . '-'
                    . str_pad(
                        (string) $month,
                        2,
                        '0',
                        STR_PAD_LEFT
                    );

                $labels[] = $monthNames[$month];

                $incomes[] = isset(
                    $indexedResults[$key]
                )
                    ? $indexedResults[$key]['income']
                    : 0;

                $expenses[] = isset(
                    $indexedResults[$key]
                )
                    ? $indexedResults[$key]['expense']
                    : 0;
            }
        }

        /*
     * =========================================================
     * AUTRES PÉRIODES : UN POINT PAR JOUR
     * =========================================================
     */ else {
            $startTimestamp = strtotime($startDate);
            $endTimestamp = strtotime($endDate);

            for (
                $timestamp = $startTimestamp;
                $timestamp <= $endTimestamp;
                $timestamp = strtotime(
                    '+1 day',
                    $timestamp
                )
            ) {
                $key = date(
                    'Y-m-d',
                    $timestamp
                );

                $day = date(
                    'd',
                    $timestamp
                );

                $monthNumber = (int) date(
                    'n',
                    $timestamp
                );

                $labels[] = $day
                    . ' '
                    . $monthNames[$monthNumber];

                $incomes[] = isset(
                    $indexedResults[$key]
                )
                    ? $indexedResults[$key]['income']
                    : 0;

                $expenses[] = isset(
                    $indexedResults[$key]
                )
                    ? $indexedResults[$key]['expense']
                    : 0;
            }
        }

        return [
            'period' =>
            $period,

            'start_date' =>
            $startDate,

            'end_date' =>
            $endDate,

            'labels' =>
            $labels,

            'incomes' =>
            $incomes,

            'expenses' =>
            $expenses,
        ];
    }

    /**
     * Retourne le solde disponible par banque.
     *
     * Seuls les comptes actifs en BIF sont additionnés.
     */
    public function getBankBalanceDistribution(): array
    {
        $rows = $this->db
            ->select("
            bank_name,

            COUNT(id) AS account_count,

            COALESCE(
                SUM(current_balance),
                0
            ) AS total_balance
        ", false)
            ->from('tbl_finance_bank_account')
            ->where('status', 'active')
            ->where('currency', 'BIF')
            ->group_by('bank_name')
            ->order_by('total_balance', 'DESC')
            ->get()
            ->result();

        $maxBalance = 0;

        foreach ($rows as $row) {
            $balance = (float) $row->total_balance;

            if ($balance > $maxBalance) {
                $maxBalance = $balance;
            }
        }

        $bankLabels = [
            'CRDB' =>
            'CRDB Bank',

            'BANCOBU' =>
            'BANCOBU',

            'ECOBANK' =>
            'ECOBANK',

            'KCB' =>
            'KCB Bank',

            'BCB' =>
            'BCB',

            'BHB' =>
            'BHB',

            'INTERBANK' =>
            'Interbank Burundi',
        ];

        $distribution = [];

        foreach ($rows as $row) {
            $balance = (float) $row->total_balance;

            $percentage = $maxBalance > 0
                ? ($balance / $maxBalance) * 100
                : 0;

            $distribution[] = [
                'bank_code' =>
                $row->bank_name,

                'bank_name' =>
                $bankLabels[$row->bank_name]
                    ?? $row->bank_name,

                'account_count' =>
                (int) $row->account_count,

                'total_balance' =>
                $balance,

                'percentage' =>
                min(
                    100,
                    max(
                        0,
                        $percentage
                    )
                ),
            ];
        }

        return $distribution;
    }

    /**
     * Retourne la situation détaillée des comptes bancaires.
     *
     * Pour chaque compte :
     * - solde actuel ;
     * - entrées du mois ;
     * - sorties du mois ;
     * - nombre d'opérations ;
     * - informations générales du compte.
     */
    public function getBankAccountSituations(): array
    {
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        $sql = "
        SELECT
            ba.id,
            ba.code,
            ba.name,
            ba.bank_name,
            ba.account_number,
            ba.account_type,
            ba.currency,
            ba.opening_balance,
            ba.current_balance,
            ba.alert_threshold,
            ba.branch_name,
            ba.swift_code,
            ba.observation,
            ba.status,
            ba.created_at,
            ba.updated_at,

            COALESCE(
                movements.monthly_entries,
                0
            ) AS monthly_entries,

            COALESCE(
                movements.monthly_outputs,
                0
            ) AS monthly_outputs,

            COALESCE(
                movements.monthly_operations,
                0
            ) AS monthly_operations

        FROM tbl_finance_bank_account ba

        LEFT JOIN
        (
            SELECT
                bank_movements.bank_account_id,

                SUM(
                    bank_movements.entry_amount
                ) AS monthly_entries,

                SUM(
                    bank_movements.output_amount
                ) AS monthly_outputs,

                COUNT(
                    DISTINCT bank_movements.operation_id
                ) AS monthly_operations

            FROM
            (
                /*
                 * Entrées :
                 * encaissements et destinations des transferts.
                 */
                SELECT
                    op.id AS operation_id,
                    op.destination_bank_account_id
                        AS bank_account_id,
                    op.amount AS entry_amount,
                    0 AS output_amount

                FROM tbl_finance_bank_operation op

                WHERE op.destination_bank_account_id IS NOT NULL
                AND op.status = 'validated'
                AND op.operation_date BETWEEN ? AND ?

                UNION ALL

                /*
                 * Sorties :
                 * décaissements et sources des transferts.
                 */
                SELECT
                    op.id AS operation_id,
                    op.source_bank_account_id
                        AS bank_account_id,
                    0 AS entry_amount,
                    op.amount AS output_amount

                FROM tbl_finance_bank_operation op

                WHERE op.source_bank_account_id IS NOT NULL
                AND op.status = 'validated'
                AND op.operation_date BETWEEN ? AND ?

            ) bank_movements

            GROUP BY bank_movements.bank_account_id

        ) movements
            ON movements.bank_account_id = ba.id

        ORDER BY
            CASE
                WHEN ba.status = 'active'
                    THEN 0
                WHEN ba.status = 'blocked'
                    THEN 1
                ELSE 2
            END ASC,

            ba.bank_name ASC,
            ba.currency ASC,
            ba.name ASC
    ";

        return $this->db
            ->query(
                $sql,
                [
                    $monthStart,
                    $monthEnd,
                    $monthStart,
                    $monthEnd,
                ]
            )
            ->result();
    }

    /**
     * Compte tous les comptes bancaires actifs.
     */
    public function countActiveBankAccounts(): int
    {
        return (int) $this->db
            ->where('status', 'active')
            ->count_all_results(
                'tbl_finance_bank_account'
            );
    }

    /**
     * Retourne les mouvements bancaires les plus récents.
     *
     * @param int $limit Nombre maximum d'opérations à retourner.
     *
     * @return array
     */
    public function getRecentBankOperations(int $limit = 10): array
    {
        $limit = max(
            1,
            min(
                100,
                $limit
            )
        );

        return $this->db
            ->select([
                /*
             * Informations de l'opération.
             */
                'operation.id',
                'operation.reference',
                'operation.operation_type',
                'operation.operation_date',
                'operation.source_bank_account_id',
                'operation.destination_bank_account_id',
                'operation.amount',
                'operation.currency',
                'operation.category',
                'operation.third_party',
                'operation.payment_method',
                'operation.document_number',
                'operation.attachment',
                'operation.label',
                'operation.status',
                'operation.created_by',
                'operation.validated_by',
                'operation.created_at',
                'operation.updated_at',

                /*
             * Compte source.
             */
                'source_account.code AS source_account_code',
                'source_account.name AS source_account_name',
                'source_account.bank_name AS source_bank_name',
                'source_account.account_number AS source_account_number',
                'source_account.currency AS source_currency',

                /*
             * Compte destination.
             */
                'destination_account.code AS destination_account_code',
                'destination_account.name AS destination_account_name',
                'destination_account.bank_name AS destination_bank_name',
                'destination_account.account_number AS destination_account_number',
                'destination_account.currency AS destination_currency',
            ])
            ->from(
                'tbl_finance_bank_operation AS operation'
            )
            ->join(
                'tbl_finance_bank_account AS source_account',
                'source_account.id = operation.source_bank_account_id',
                'left'
            )
            ->join(
                'tbl_finance_bank_account AS destination_account',
                'destination_account.id = operation.destination_bank_account_id',
                'left'
            )
            ->order_by(
                'operation.operation_date',
                'DESC'
            )
            ->order_by(
                'operation.created_at',
                'DESC'
            )
            ->order_by(
                'operation.id',
                'DESC'
            )
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Compte toutes les opérations bancaires enregistrées.
     */
    public function countBankOperations(): int
    {
        return (int) $this->db
            ->count_all_results(
                'tbl_finance_bank_operation'
            );
    }

    /**
     * Retourne les alertes bancaires à afficher.
     *
     * Alertes générées :
     * - opérations en attente ;
     * - opérations validées sans justificatif ;
     * - comptes actifs sous leur seuil d'alerte.
     *
     * @param int $limit Nombre maximum d'alertes.
     *
     * @return array
     */
    public function getBankAlerts(int $limit = 10): array
    {
        $limit = max(
            1,
            min(
                50,
                $limit
            )
        );

        $alerts = [];

        /*
     * =========================================================
     * 1. OPÉRATIONS EN ATTENTE
     * =========================================================
     */

        $pendingOperations = $this->db
            ->select([
                'operation.id',
                'operation.reference',
                'operation.operation_type',
                'operation.amount',
                'operation.currency',
                'operation.label',
                'operation.operation_date',
                'operation.created_at',

                'source_account.name AS source_account_name',
                'destination_account.name AS destination_account_name',
            ])
            ->from(
                'tbl_finance_bank_operation AS operation'
            )
            ->join(
                'tbl_finance_bank_account AS source_account',
                'source_account.id = operation.source_bank_account_id',
                'left'
            )
            ->join(
                'tbl_finance_bank_account AS destination_account',
                'destination_account.id = operation.destination_bank_account_id',
                'left'
            )
            ->where(
                'operation.status',
                'pending'
            )
            ->order_by(
                'operation.operation_date',
                'ASC'
            )
            ->order_by(
                'operation.created_at',
                'ASC'
            )
            ->limit($limit)
            ->get()
            ->result();

        foreach ($pendingOperations as $operation) {
            $title = 'Opération bancaire en attente';

            $description =
                'L’opération '
                . $operation->reference
                . ' d’un montant de '
                . number_format(
                    (float) $operation->amount,
                    0,
                    ',',
                    ' '
                )
                . ' '
                . $operation->currency
                . ' attend une validation.';

            if (
                $operation->operation_type
                === 'transfert'
            ) {
                $title =
                    'Transfert bancaire en attente';

                $description =
                    'Le transfert de '
                    . number_format(
                        (float) $operation->amount,
                        0,
                        ',',
                        ' '
                    )
                    . ' '
                    . $operation->currency
                    . ' de '
                    . (
                        $operation->source_account_name
                        ?: 'un compte source'
                    )
                    . ' vers '
                    . (
                        $operation
                        ->destination_account_name
                        ?: 'un compte destination'
                    )
                    . ' attend une validation.';
            }

            $alerts[] = [
                'type' =>
                'warning',

                'icon' =>
                'fas fa-clock',

                'title' =>
                $title,

                'description' =>
                $description,

                'operation_id' =>
                (int) $operation->id,

                'priority' =>
                2,

                'created_at' =>
                $operation->created_at,
            ];
        }

        /*
     * =========================================================
     * 2. JUSTIFICATIFS MANQUANTS
     * =========================================================
     */

        $missingAttachments = $this->db
            ->select([
                'operation.id',
                'operation.reference',
                'operation.amount',
                'operation.currency',
                'operation.operation_type',
                'operation.label',
                'operation.created_at',
            ])
            ->from(
                'tbl_finance_bank_operation AS operation'
            )
            ->where(
                'operation.status',
                'validated'
            )
            ->group_start()
            ->where(
                'operation.attachment IS NULL',
                null,
                false
            )
            ->or_where(
                'operation.attachment',
                ''
            )
            ->group_end()
            ->order_by(
                'operation.created_at',
                'DESC'
            )
            ->limit($limit)
            ->get()
            ->result();

        foreach ($missingAttachments as $operation) {
            $alerts[] = [
                'type' =>
                'danger',

                'icon' =>
                'fas fa-file-invoice',

                'title' =>
                'Justificatif manquant',

                'description' =>
                'L’opération '
                    . $operation->reference
                    . ' d’un montant de '
                    . number_format(
                        (float) $operation->amount,
                        0,
                        ',',
                        ' '
                    )
                    . ' '
                    . $operation->currency
                    . ' ne possède pas encore de pièce justificative.',

                'operation_id' =>
                (int) $operation->id,

                'priority' =>
                1,

                'created_at' =>
                $operation->created_at,
            ];
        }

        /*
     * =========================================================
     * 3. COMPTES SOUS LE SEUIL D'ALERTE
     * =========================================================
     */

        $lowBalanceAccounts = $this->db
            ->select([
                'id',
                'code',
                'name',
                'current_balance',
                'alert_threshold',
                'currency',
                'created_at',
            ])
            ->from(
                'tbl_finance_bank_account'
            )
            ->where(
                'status',
                'active'
            )
            ->where(
                'alert_threshold >',
                0
            )
            ->where(
                'current_balance <= alert_threshold',
                null,
                false
            )
            ->order_by(
                'current_balance',
                'ASC'
            )
            ->limit($limit)
            ->get()
            ->result();

        foreach ($lowBalanceAccounts as $account) {
            $alerts[] = [
                'type' =>
                'danger',

                'icon' =>
                'fas fa-university',

                'title' =>
                'Solde bancaire critique',

                'description' =>
                'Le compte '
                    . $account->name
                    . ' dispose de '
                    . number_format(
                        (float) $account
                            ->current_balance,
                        0,
                        ',',
                        ' '
                    )
                    . ' '
                    . $account->currency
                    . ', pour un seuil fixé à '
                    . number_format(
                        (float) $account
                            ->alert_threshold,
                        0,
                        ',',
                        ' '
                    )
                    . ' '
                    . $account->currency
                    . '.',

                'account_id' =>
                (int) $account->id,

                'priority' =>
                0,

                'created_at' =>
                $account->created_at,
            ];
        }

        /*
     * Les alertes les plus importantes passent d'abord.
     */
        usort(
            $alerts,
            static function (
                array $first,
                array $second
            ): int {
                if (
                    $first['priority']
                    === $second['priority']
                ) {
                    return strcmp(
                        (string) $second['created_at'],
                        (string) $first['created_at']
                    );
                }

                return $first['priority']
                    <=> $second['priority'];
            }
        );

        return array_slice(
            $alerts,
            0,
            $limit
        );
    }

    /**
     * Retourne les statistiques principales de la page Encaissements.
     *
     * Données calculées depuis tbl_finance_cashbox_operation :
     *
     * - total encaissé pendant le mois courant ;
     * - variation par rapport au mois précédent ;
     * - encaissements validés aujourd'hui ;
     * - encaissements en attente de validation ;
     * - créances restant à encaisser.
     */
    public function getEncaissementMainStatistics(): array
    {
        /*
     * =========================================================
     * 1. DATES DE TRAVAIL
     * =========================================================
     */

        $today = date('Y-m-d');

        $currentMonthStart = date('Y-m-01');
        $currentMonthEnd   = date('Y-m-t');

        $previousMonthStart = date(
            'Y-m-01',
            strtotime('-1 month')
        );

        $previousMonthEnd = date(
            'Y-m-t',
            strtotime('-1 month')
        );

        /*
     * =========================================================
     * 2. TOTAL ENCAISSÉ CE MOIS
     * =========================================================
     */

        $currentMonthRow = $this->db
            ->select("
            COALESCE(
                SUM(amount),
                0
            ) AS total_amount,

            COUNT(id) AS total_operations
        ", false)
            ->from('tbl_finance_cashbox_operation')
            ->where('operation_type', 'encaissement')
            ->where('status', 'validated')
            ->where('currency', 'BIF')
            ->where('operation_date >=', $currentMonthStart)
            ->where('operation_date <=', $currentMonthEnd)
            ->get()
            ->row();

        $currentMonthAmount = $currentMonthRow
            ? (float) $currentMonthRow->total_amount
            : 0;

        $currentMonthCount = $currentMonthRow
            ? (int) $currentMonthRow->total_operations
            : 0;

        /*
     * =========================================================
     * 3. TOTAL ENCAISSÉ LE MOIS PRÉCÉDENT
     * =========================================================
     */

        $previousMonthRow = $this->db
            ->select("
            COALESCE(
                SUM(amount),
                0
            ) AS total_amount
        ", false)
            ->from('tbl_finance_cashbox_operation')
            ->where('operation_type', 'encaissement')
            ->where('status', 'validated')
            ->where('currency', 'BIF')
            ->where('operation_date >=', $previousMonthStart)
            ->where('operation_date <=', $previousMonthEnd)
            ->get()
            ->row();

        $previousMonthAmount = $previousMonthRow
            ? (float) $previousMonthRow->total_amount
            : 0;

        /*
     * =========================================================
     * 4. CALCULER LA VARIATION MENSUELLE
     * =========================================================
     */

        $monthlyVariation = 0;

        if ($previousMonthAmount > 0) {
            $monthlyVariation = (
                (
                    $currentMonthAmount
                    - $previousMonthAmount
                )
                / $previousMonthAmount
            ) * 100;
        } elseif ($currentMonthAmount > 0) {
            /*
         * Le mois précédent était à zéro,
         * mais le mois courant contient des encaissements.
         */
            $monthlyVariation = 100;
        }

        /*
     * =========================================================
     * 5. ENCAISSEMENTS DU JOUR
     * =========================================================
     */

        $todayRow = $this->db
            ->select("
            COALESCE(
                SUM(amount),
                0
            ) AS total_amount,

            COUNT(id) AS total_operations
        ", false)
            ->from('tbl_finance_cashbox_operation')
            ->where('operation_type', 'encaissement')
            ->where('status', 'validated')
            ->where('currency', 'BIF')
            ->where('operation_date', $today)
            ->get()
            ->row();

        $todayAmount = $todayRow
            ? (float) $todayRow->total_amount
            : 0;

        $todayCount = $todayRow
            ? (int) $todayRow->total_operations
            : 0;

        /*
     * =========================================================
     * 6. ENCAISSEMENTS EN ATTENTE
     * =========================================================
     */

        $pendingRow = $this->db
            ->select("
            COALESCE(
                SUM(amount),
                0
            ) AS total_amount,

            COUNT(id) AS total_operations
        ", false)
            ->from('tbl_finance_cashbox_operation')
            ->where('operation_type', 'encaissement')
            ->where('status', 'pending')
            ->where('currency', 'BIF')
            ->get()
            ->row();

        $pendingAmount = $pendingRow
            ? (float) $pendingRow->total_amount
            : 0;

        $pendingCount = $pendingRow
            ? (int) $pendingRow->total_operations
            : 0;

        /*
     * =========================================================
     * 7. CRÉANCES À ENCAISSER
     * =========================================================
     *
     * Cette statistique doit provenir de la facturation :
     *
     * montant total facturé
     * - montant déjà encaissé
     * = créance restante
     *
     * Nous la gardons temporairement à zéro jusqu'à ce que
     * les noms exacts des tables et colonnes de facturation
     * soient reliés à ce module.
     */

        $receivableAmount = 0;
        $receivableClientsCount = 0;

        /*
     * =========================================================
     * 8. RETOURNER LES STATISTIQUES
     * =========================================================
     */

        return [
            'currency' => 'BIF',

            'current_month_amount' =>
            $currentMonthAmount,

            'current_month_count' =>
            $currentMonthCount,

            'previous_month_amount' =>
            $previousMonthAmount,

            'monthly_variation' =>
            $monthlyVariation,

            'today_amount' =>
            $todayAmount,

            'today_count' =>
            $todayCount,

            'pending_amount' =>
            $pendingAmount,

            'pending_count' =>
            $pendingCount,

            'receivable_amount' =>
            $receivableAmount,

            'receivable_clients_count' =>
            $receivableClientsCount,
        ];
    }

    /**
     * Retourne toutes les caisses actives.
     *
     * Cette méthode est utilisée notamment dans :
     * - la page Encaissements ;
     * - la page Décaissements ;
     * - les modales d'opérations de caisse.
     *
     * @return array
     */
    // public function getAllActiveCashboxes(): array
    // {
    //     return $this->db
    //         ->select([
    //             'id',
    //             'code',
    //             'name',
    //             'type',
    //             'chantier_id',
    //             'responsable',
    //             'devise',
    //             'opening_balance',
    //             'current_balance',
    //             'alert_threshold',
    //             'observation',
    //             'status',
    //             'created_by',
    //             'created_at',
    //             'updated_at',
    //         ])
    //         ->from('tbl_finance_cashbox')
    //         ->where('status', 'active')
    //         ->order_by(
    //             "
    //         CASE
    //             WHEN type = 'siege' THEN 0
    //             WHEN type = 'chantier' THEN 1
    //             ELSE 2
    //         END
    //         ",
    //             '',
    //             false
    //         )
    //         ->order_by('name', 'ASC')
    //         ->get()
    //         ->result();
    // }

    /**
     * =====================================================
     * TOUTES LES CAISSES ACTIVES (avec rôle + solde)
     * =====================================================
     */
    public function getAllActiveCashboxes()
    {
        return $this->db->select('id, code, name, role, devise, current_balance')
            ->where('status', 'active')
            ->order_by('role', 'ASC')   /* principale d'abord */
            ->order_by('id', 'ASC')
            ->get('tbl_finance_cashbox')
            ->result();
    }

    /**
     * Retourne l'objectif mensuel d'encaissement.
     *
     * Cette méthode est temporaire.
     * Plus tard, elle pourra lire les objectifs depuis une table
     * de prévisions de trésorerie.
     *
     * @param string $monthKey Exemple : 2026-07
     *
     * @return float
     */
    private function getMonthlyEncaissementObjective(
        string $monthKey
    ): float {
        /*
     * Objectif par défaut.
     */
        $defaultObjective =
            450000000;

        /*
     * Objectifs de test personnalisés.
     */
        $objectives = [
            '2026-01' => 300000000,
            '2026-02' => 320000000,
            '2026-03' => 340000000,
            '2026-04' => 350000000,
            '2026-05' => 400000000,
            '2026-06' => 430000000,
            '2026-07' => 450000000,
            '2026-08' => 460000000,
            '2026-09' => 480000000,
            '2026-10' => 500000000,
            '2026-11' => 520000000,
            '2026-12' => 550000000,
        ];

        return isset($objectives[$monthKey])
            ? (float) $objectives[$monthKey]
            : $defaultObjective;
    }

    /**
     * Retourne l'évolution mensuelle des encaissements.
     *
     * Périodes acceptées :
     * - 6months
     * - 12months
     * - current_year
     * - previous_year
     *
     * @param string $period
     *
     * @return array
     */
    public function getEncaissementEvolution(
        string $period = '6months'
    ): array {
        /*
     * =========================================================
     * 1. DÉTERMINER LA PÉRIODE
     * =========================================================
     */

        $today = date('Y-m-d');

        switch ($period) {
            case '12months':
                $startDate = date(
                    'Y-m-01',
                    strtotime('-11 months')
                );

                $endDate = date('Y-m-t');

                $numberOfMonths = 12;
                break;

            case 'current_year':
                $startDate = date('Y-01-01');
                $endDate = date('Y-12-31');

                $numberOfMonths = 12;
                break;

            case 'previous_year':
                $previousYear = (int) date('Y') - 1;

                $startDate =
                    $previousYear . '-01-01';

                $endDate =
                    $previousYear . '-12-31';

                $numberOfMonths = 12;
                break;

            case '6months':
            default:
                $period = '6months';

                $startDate = date(
                    'Y-m-01',
                    strtotime('-5 months')
                );

                $endDate = date('Y-m-t');

                $numberOfMonths = 6;
                break;
        }

        /*
     * =========================================================
     * 2. RÉCUPÉRER LES ENCAISSEMENTS PAR MOIS
     * =========================================================
     */

        $rows = $this->db
            ->select("
            DATE_FORMAT(
                operation_date,
                '%Y-%m'
            ) AS month_key,

            COALESCE(
                SUM(amount),
                0
            ) AS total_amount,

            COUNT(id) AS total_operations
        ", false)
            ->from('tbl_finance_cashbox_operation')
            ->where(
                'operation_type',
                'encaissement'
            )
            ->where(
                'status',
                'validated'
            )
            ->where(
                'currency',
                'BIF'
            )
            ->where(
                'operation_date >=',
                $startDate
            )
            ->where(
                'operation_date <=',
                $endDate
            )
            ->group_by("
            DATE_FORMAT(
                operation_date,
                '%Y-%m'
            )
        ", false)
            ->order_by(
                'month_key',
                'ASC'
            )
            ->get()
            ->result();

        /*
     * Indexation des résultats.
     */
        $indexedRows = [];

        foreach ($rows as $row) {
            $indexedRows[$row->month_key] = [
                'amount' =>
                (float) $row->total_amount,

                'count' =>
                (int) $row->total_operations,
            ];
        }

        /*
     * =========================================================
     * 3. NOMS DES MOIS
     * =========================================================
     */

        $monthNames = [
            1  => 'Janvier',
            2  => 'Février',
            3  => 'Mars',
            4  => 'Avril',
            5  => 'Mai',
            6  => 'Juin',
            7  => 'Juillet',
            8  => 'Août',
            9  => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre',
        ];

        $labels = [];
        $amounts = [];
        $operationCounts = [];
        $objectives = [];

        /*
     * =========================================================
     * 4. CONSTRUIRE TOUS LES MOIS, MÊME SANS OPÉRATION
     * =========================================================
     */

        if (
            in_array(
                $period,
                [
                    'current_year',
                    'previous_year',
                ],
                true
            )
        ) {
            $year = $period === 'previous_year'
                ? (int) date('Y') - 1
                : (int) date('Y');

            for ($month = 1; $month <= 12; $month++) {
                $monthKey =
                    $year
                    . '-'
                    . str_pad(
                        (string) $month,
                        2,
                        '0',
                        STR_PAD_LEFT
                    );

                $labels[] =
                    $monthNames[$month];

                $amounts[] =
                    isset($indexedRows[$monthKey])
                    ? $indexedRows[$monthKey]['amount']
                    : 0;

                $operationCounts[] =
                    isset($indexedRows[$monthKey])
                    ? $indexedRows[$monthKey]['count']
                    : 0;

                /*
             * Objectif temporaire.
             */
                $objectives[] =
                    $this->getMonthlyEncaissementObjective(
                        $monthKey
                    );
            }
        } else {
            $startTimestamp =
                strtotime($startDate);

            for (
                $index = 0;
                $index < $numberOfMonths;
                $index++
            ) {
                $timestamp = strtotime(
                    '+' . $index . ' month',
                    $startTimestamp
                );

                $monthKey =
                    date(
                        'Y-m',
                        $timestamp
                    );

                $monthNumber =
                    (int) date(
                        'n',
                        $timestamp
                    );

                $year =
                    date(
                        'Y',
                        $timestamp
                    );

                $labels[] =
                    $monthNames[$monthNumber]
                    . ' '
                    . $year;

                $amounts[] =
                    isset($indexedRows[$monthKey])
                    ? $indexedRows[$monthKey]['amount']
                    : 0;

                $operationCounts[] =
                    isset($indexedRows[$monthKey])
                    ? $indexedRows[$monthKey]['count']
                    : 0;

                $objectives[] =
                    $this->getMonthlyEncaissementObjective(
                        $monthKey
                    );
            }
        }

        /*
     * =========================================================
     * 5. TOTAUX DE LA PÉRIODE
     * =========================================================
     */

        $totalAmount = array_sum($amounts);

        $totalOperations =
            array_sum($operationCounts);

        $averageAmount = count($amounts) > 0
            ? $totalAmount / count($amounts)
            : 0;

        return [
            'period' =>
            $period,

            'start_date' =>
            $startDate,

            'end_date' =>
            $endDate,

            'labels' =>
            $labels,

            'amounts' =>
            $amounts,

            'operation_counts' =>
            $operationCounts,

            'objectives' =>
            $objectives,

            'total_amount' =>
            $totalAmount,

            'total_operations' =>
            $totalOperations,

            'average_amount' =>
            $averageAmount,
        ];
    }

    /**
     * Retourne la répartition des encaissements par catégorie.
     *
     * Les résultats sont calculés sur la période sélectionnée.
     *
     * @param string $startDate
     * @param string $endDate
     *
     * @return array
     */
    public function getEncaissementSources(
        string $startDate,
        string $endDate
    ): array {
        $rows = $this->db
            ->select("
            CASE
                WHEN category IS NULL
                    OR TRIM(category) = ''
                THEN 'Autre produit'
                ELSE category
            END AS source_name,

            COALESCE(
                SUM(amount),
                0
            ) AS total_amount,

            COUNT(id) AS total_operations
        ", false)
            ->from('tbl_finance_cashbox_operation')
            ->where(
                'operation_type',
                'encaissement'
            )
            ->where(
                'status',
                'validated'
            )
            ->where(
                'currency',
                'BIF'
            )
            ->where(
                'operation_date >=',
                $startDate
            )
            ->where(
                'operation_date <=',
                $endDate
            )
            ->group_by("
            CASE
                WHEN category IS NULL
                    OR TRIM(category) = ''
                THEN 'Autre produit'
                ELSE category
            END
        ", false)
            ->order_by(
                'total_amount',
                'DESC'
            )
            ->get()
            ->result();

        $totalSourcesAmount = 0;

        foreach ($rows as $row) {
            $totalSourcesAmount +=
                (float) $row->total_amount;
        }

        /*
     * Icônes selon la catégorie.
     */
        $icons = [
            'Paiement client' =>
            'fas fa-users',

            'Paiements clients' =>
            'fas fa-users',

            'Avance sur marché' =>
            'fas fa-file-contract',

            'Avances sur marchés' =>
            'fas fa-file-contract',

            'Emprunt' =>
            'fas fa-university',

            'Emprunts' =>
            'fas fa-university',

            'Remboursement' =>
            'fas fa-undo-alt',

            'Remboursements' =>
            'fas fa-undo-alt',

            'Vente actif' =>
            'fas fa-building',

            'Autre produit' =>
            'fas fa-ellipsis-h',

            'Autres produits' =>
            'fas fa-ellipsis-h',
        ];

        $sources = [];

        foreach ($rows as $row) {
            $amount =
                (float) $row->total_amount;

            $percentage =
                $totalSourcesAmount > 0
                ? (
                    $amount
                    / $totalSourcesAmount
                ) * 100
                : 0;

            $sourceName =
                trim(
                    (string) $row->source_name
                );

            $sources[] = [
                'name' =>
                $sourceName,

                'amount' =>
                $amount,

                'operation_count' =>
                (int) $row->total_operations,

                'percentage' =>
                min(
                    100,
                    max(
                        0,
                        $percentage
                    )
                ),

                'icon' =>
                $icons[$sourceName]
                    ?? 'fas fa-ellipsis-h',
            ];
        }

        return [
            'total_amount' =>
            $totalSourcesAmount,

            'sources' =>
            $sources,
        ];
    }

    /**
     * Retourne l'historique paginé des encaissements.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function getEncaissementHistory(
        int $limit = 10,
        int $offset = 0
    ): array {
        $limit = max(1, min(100, $limit));
        $offset = max(0, $offset);

        return $this->db
            ->select([
                'operation.id',
                'operation.reference',
                'operation.operation_date',
                'operation.destination_cashbox_id',
                'operation.amount',
                'operation.currency',
                'operation.category',
                'operation.third_party',
                'operation.payment_method',
                'operation.document_number',
                'operation.attachment',
                'operation.label',
                'operation.observation',
                'operation.status',
                'operation.created_by',
                'operation.validated_by',
                'operation.created_at',
                'operation.updated_at',

                'cashbox.code AS cashbox_code',
                'cashbox.name AS cashbox_name',
                'cashbox.type AS cashbox_type',
                'cashbox.chantier_id AS cashbox_chantier_id',

                'chantier.name AS chantier_name',
                'chantier.ref_chantier AS chantier_reference',
            ])
            ->from(
                'tbl_finance_cashbox_operation AS operation'
            )
            ->join(
                'tbl_finance_cashbox AS cashbox',
                'cashbox.id = operation.destination_cashbox_id',
                'left'
            )
            ->join(
                'chantiers AS chantier',
                'chantier.id = cashbox.chantier_id',
                'left'
            )
            ->where(
                'operation.operation_type',
                'encaissement'
            )
            ->order_by(
                'operation.operation_date',
                'DESC'
            )
            ->order_by(
                'operation.created_at',
                'DESC'
            )
            ->order_by(
                'operation.id',
                'DESC'
            )
            ->limit(
                $limit,
                $offset
            )
            ->get()
            ->result();
    }

    /**
     * Compte tous les encaissements enregistrés.
     */
    public function countEncaissements(): int
    {
        return (int) $this->db
            ->from('tbl_finance_cashbox_operation')
            ->where(
                'operation_type',
                'encaissement'
            )
            ->count_all_results();
    }

    /**
     * Retourne les prochains encaissements attendus.
     *
     * Pour le moment, un encaissement attendu correspond à une
     * opération de type encaissement ayant le statut pending.
     *
     * @param int $limit
     *
     * @return array
     */
    public function getExpectedEncaissements(
        int $limit = 6
    ): array {
        $limit = max(
            1,
            min(
                50,
                $limit
            )
        );

        return $this->db
            ->select([
                'operation.id',
                'operation.reference',
                'operation.operation_date',
                'operation.amount',
                'operation.currency',
                'operation.category',
                'operation.third_party',
                'operation.payment_method',
                'operation.document_number',
                'operation.label',
                'operation.observation',
                'operation.status',
                'operation.created_at',

                'cashbox.id AS cashbox_id',
                'cashbox.code AS cashbox_code',
                'cashbox.name AS cashbox_name',
                'cashbox.type AS cashbox_type',

                'chantier.id AS chantier_id',
                'chantier.name AS chantier_name',
                'chantier.ref_chantier AS chantier_reference',
            ])
            ->from(
                'tbl_finance_cashbox_operation AS operation'
            )
            ->join(
                'tbl_finance_cashbox AS cashbox',
                'cashbox.id = operation.destination_cashbox_id',
                'left'
            )
            ->join(
                'chantiers AS chantier',
                'chantier.id = cashbox.chantier_id',
                'left'
            )
            ->where(
                'operation.operation_type',
                'encaissement'
            )
            ->where(
                'operation.status',
                'pending'
            )
            ->order_by(
                'operation.operation_date',
                'ASC'
            )
            ->order_by(
                'operation.created_at',
                'ASC'
            )
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Compte les encaissements en attente.
     */
    public function countExpectedEncaissements(): int
    {
        return (int) $this->db
            ->from(
                'tbl_finance_cashbox_operation'
            )
            ->where(
                'operation_type',
                'encaissement'
            )
            ->where(
                'status',
                'pending'
            )
            ->count_all_results();
    }

    /**
     * Retourne une synthèse des encaissements par payeur/client.
     *
     * Logique provisoire :
     *
     * - encaissé = opérations validées ;
     * - reste = opérations en attente ;
     * - total de référence = validé + en attente.
     *
     * La vraie valeur facturée devra ensuite provenir
     * des tables du module Facturation.
     *
     * @param int $limit
     *
     * @return array
     */
    public function getEncaissementClientSummary(
        int $limit = 10
    ): array {
        $limit = max(
            1,
            min(
                100,
                $limit
            )
        );

        $sql = "
        SELECT
            CASE
                WHEN third_party IS NULL
                    OR TRIM(third_party) = ''
                THEN 'Provenance non renseignée'
                ELSE TRIM(third_party)
            END AS client_name,

            COUNT(id) AS operation_count,

            SUM(
                CASE
                    WHEN status = 'validated'
                    THEN 1
                    ELSE 0
                END
            ) AS validated_count,

            SUM(
                CASE
                    WHEN status = 'pending'
                    THEN 1
                    ELSE 0
                END
            ) AS pending_count,

            COALESCE(
                SUM(
                    CASE
                        WHEN status = 'validated'
                        THEN amount
                        ELSE 0
                    END
                ),
                0
            ) AS collected_amount,

            COALESCE(
                SUM(
                    CASE
                        WHEN status = 'pending'
                        THEN amount
                        ELSE 0
                    END
                ),
                0
            ) AS pending_amount,

            COALESCE(
                SUM(
                    CASE
                        WHEN status IN (
                            'validated',
                            'pending'
                        )
                        THEN amount
                        ELSE 0
                    END
                ),
                0
            ) AS expected_total

        FROM tbl_finance_cashbox_operation

        WHERE operation_type = 'encaissement'
        AND currency = 'BIF'
        AND status IN (
            'validated',
            'pending'
        )

        GROUP BY
            CASE
                WHEN third_party IS NULL
                    OR TRIM(third_party) = ''
                THEN 'Provenance non renseignée'
                ELSE TRIM(third_party)
            END

        ORDER BY expected_total DESC

        LIMIT ?
    ";

        $rows = $this->db
            ->query(
                $sql,
                [$limit]
            )
            ->result();

        $results = [];

        foreach ($rows as $row) {
            $expectedTotal =
                (float) $row->expected_total;

            $collectedAmount =
                (float) $row->collected_amount;

            $pendingAmount =
                (float) $row->pending_amount;

            $recoveryPercentage =
                $expectedTotal > 0
                ? (
                    $collectedAmount
                    / $expectedTotal
                ) * 100
                : 0;

            $results[] = [
                'client_name' =>
                $row->client_name,

                'operation_count' =>
                (int) $row->operation_count,

                'validated_count' =>
                (int) $row->validated_count,

                'pending_count' =>
                (int) $row->pending_count,

                'expected_total' =>
                $expectedTotal,

                'collected_amount' =>
                $collectedAmount,

                'pending_amount' =>
                $pendingAmount,

                'recovery_percentage' =>
                min(
                    100,
                    max(
                        0,
                        $recoveryPercentage
                    )
                ),
            ];
        }

        return $results;
    }

    /**
     * Retourne les prochaines échéances d'encaissement.
     *
     * @param int $limit
     *
     * @return array
     */
    public function getUpcomingExpectedReceipts(
        int $limit = 4
    ): array {
        /*
     * Sécuriser la limite.
     */
        $limit = max(
            1,
            min(
                50,
                $limit
            )
        );

        return $this->db
            ->select([
                'expected.id',
                'expected.reference',
                'expected.client_name',
                'expected.client_type',
                'expected.document_type',
                'expected.document_number',
                'expected.label',
                'expected.chantier_id',
                'expected.expected_date',
                'expected.expected_amount',
                'expected.currency',
                'expected.status',
                'expected.observation',
                'expected.created_by',
                'expected.created_at',
                'expected.updated_at',

                'chantier.name AS chantier_name',
                'chantier.ref_chantier AS chantier_reference',
            ])
            ->from(
                'tbl_finance_expected_receipt AS expected'
            )
            ->join(
                'chantiers AS chantier',
                'chantier.id = expected.chantier_id',
                'left'
            )
            ->where_in(
                'expected.status',
                [
                    'pending',
                    'partial',
                    'overdue',
                ]
            )
            ->where(
                'expected.expected_amount >',
                0
            )
            ->order_by(
                "
            CASE
                WHEN expected.expected_date < CURDATE()
                THEN 0
                ELSE 1
            END
            ",
                '',
                false
            )
            ->order_by(
                'expected.expected_date',
                'ASC'
            )
            ->order_by(
                'expected.id',
                'ASC'
            )
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Compte toutes les échéances encore ouvertes.
     *
     * @return int
     */
    public function countOpenExpectedReceipts(): int
    {
        return (int) $this->db
            ->from(
                'tbl_finance_expected_receipt'
            )
            ->where_in(
                'status',
                [
                    'pending',
                    'partial',
                    'overdue',
                ]
            )
            ->count_all_results();
    }

    /**
     * Retourne la liste distincte des établissements bancaires.
     *
     * @return array
     */
    public function getAvailableBankNames(): array
    {
        return $this->db
            ->select('bank_name')
            ->from('tbl_finance_bank_account')
            ->where('bank_name IS NOT NULL', null, false)
            ->where("TRIM(bank_name) <> ''", null, false)
            ->group_by('bank_name')
            ->order_by('bank_name', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Retourne la situation des comptes bancaires
     * avec possibilité de filtrage.
     *
     * Filtres disponibles :
     * - search
     * - bank_name
     * - currency
     * - status
     *
     * @param array $filters
     *
     * @return array
     */
    public function getFilteredBankAccounts(
        array $filters = []
    ): array {
        /*
     * =========================================================
     * 1. VALEURS DES FILTRES
     * =========================================================
     */

        $search = trim(
            (string) (
                $filters['search']
                ?? ''
            )
        );

        $bankName = trim(
            (string) (
                $filters['bank_name']
                ?? ''
            )
        );

        $currency = trim(
            (string) (
                $filters['currency']
                ?? ''
            )
        );

        $status = trim(
            (string) (
                $filters['status']
                ?? ''
            )
        );

        /*
     * =========================================================
     * 2. REQUÊTE DE BASE
     * =========================================================
     */

        $this->db
            ->select([
                'account.id',
                'account.code',
                'account.name',
                'account.bank_name',
                'account.account_number',
                'account.account_type',
                'account.currency',
                'account.opening_balance',
                'account.current_balance',
                'account.alert_threshold',
                'account.branch_name',
                'account.swift_code',
                'account.observation',
                'account.status',
                'account.created_by',
                'account.updated_by',
                'account.created_at',
                'account.updated_at',
            ])
            ->from(
                'tbl_finance_bank_account AS account'
            );

        /*
     * =========================================================
     * 3. FILTRE DE RECHERCHE
     * =========================================================
     *
     * Recherche dans :
     * - code
     * - intitulé
     * - banque
     * - numéro de compte
     * - agence
     * - code SWIFT
     */

        if ($search !== '') {
            $this->db
                ->group_start()
                ->like(
                    'account.code',
                    $search
                )
                ->or_like(
                    'account.name',
                    $search
                )
                ->or_like(
                    'account.bank_name',
                    $search
                )
                ->or_like(
                    'account.account_number',
                    $search
                )
                ->or_like(
                    'account.branch_name',
                    $search
                )
                ->or_like(
                    'account.swift_code',
                    $search
                )
                ->group_end();
        }

        /*
     * =========================================================
     * 4. FILTRE PAR BANQUE
     * =========================================================
     */

        if ($bankName !== '') {
            $this->db->where(
                'account.bank_name',
                $bankName
            );
        }

        /*
     * =========================================================
     * 5. FILTRE PAR DEVISE
     * =========================================================
     */

        if (
            in_array(
                $currency,
                [
                    'BIF',
                    'USD',
                    'EUR',
                ],
                true
            )
        ) {
            $this->db->where(
                'account.currency',
                $currency
            );
        }

        /*
     * =========================================================
     * 6. FILTRE PAR STATUT
     * =========================================================
     */

        if (
            in_array(
                $status,
                [
                    'active',
                    'inactive',
                    'blocked',
                ],
                true
            )
        ) {
            $this->db->where(
                'account.status',
                $status
            );
        }

        /*
     * =========================================================
     * 7. TRI
     * =========================================================
     *
     * On affiche :
     * - les comptes actifs en premier ;
     * - ensuite les comptes inactifs ;
     * - enfin les comptes bloqués.
     */

        $this->db->order_by(
            "
        CASE
            WHEN account.status = 'active' THEN 1
            WHEN account.status = 'inactive' THEN 2
            WHEN account.status = 'blocked' THEN 3
            ELSE 4
        END
        ",
            '',
            false
        );

        $this->db
            ->order_by(
                'account.bank_name',
                'ASC'
            )
            ->order_by(
                'account.name',
                'ASC'
            )
            ->order_by(
                'account.id',
                'DESC'
            );

        return $this->db
            ->get()
            ->result();
    }

    /**
     * Compte les comptes bancaires correspondant aux filtres.
     *
     * @param array $filters
     *
     * @return int
     */
    public function countFilteredBankAccounts(
        array $filters = []
    ): int {
        $search = trim(
            (string) (
                $filters['search']
                ?? ''
            )
        );

        $bankName = trim(
            (string) (
                $filters['bank_name']
                ?? ''
            )
        );

        $currency = trim(
            (string) (
                $filters['currency']
                ?? ''
            )
        );

        $status = trim(
            (string) (
                $filters['status']
                ?? ''
            )
        );

        $this->db
            ->from(
                'tbl_finance_bank_account AS account'
            );

        if ($search !== '') {
            $this->db
                ->group_start()
                ->like(
                    'account.code',
                    $search
                )
                ->or_like(
                    'account.name',
                    $search
                )
                ->or_like(
                    'account.bank_name',
                    $search
                )
                ->or_like(
                    'account.account_number',
                    $search
                )
                ->or_like(
                    'account.branch_name',
                    $search
                )
                ->or_like(
                    'account.swift_code',
                    $search
                )
                ->group_end();
        }

        if ($bankName !== '') {
            $this->db->where(
                'account.bank_name',
                $bankName
            );
        }

        if (
            in_array(
                $currency,
                [
                    'BIF',
                    'USD',
                    'EUR',
                ],
                true
            )
        ) {
            $this->db->where(
                'account.currency',
                $currency
            );
        }

        if (
            in_array(
                $status,
                [
                    'active',
                    'inactive',
                    'blocked',
                ],
                true
            )
        ) {
            $this->db->where(
                'account.status',
                $status
            );
        }

        return (int) $this->db
            ->count_all_results();
    }


    /**
     * Retourne les statistiques principales de la page Décaissements.
     *
     * Les montants affichés sont limités aux opérations en BIF.
     *
     * Statistiques retournées :
     * - total décaissé durant le mois courant ;
     * - variation par rapport au mois précédent ;
     * - décaissements du jour ;
     * - opérations en attente de paiement ;
     * - trésorerie totale disponible.
     *
     * @return array
     */
    public function getDecaissementMainStatistics(): array
    {
        /*
     * =========================================================
     * 1. PÉRIODES
     * =========================================================
     */

        $today = date('Y-m-d');

        $currentMonthStart =
            date('Y-m-01');

        $currentMonthEnd =
            date('Y-m-t');

        $previousMonthStart =
            date(
                'Y-m-01',
                strtotime('first day of previous month')
            );

        $previousMonthEnd =
            date(
                'Y-m-t',
                strtotime('last day of previous month')
            );

        /*
     * =========================================================
     * 2. VALEURS PAR DÉFAUT
     * =========================================================
     */

        $cashboxCurrentMonthAmount = 0;
        $bankCurrentMonthAmount = 0;

        $cashboxPreviousMonthAmount = 0;
        $bankPreviousMonthAmount = 0;

        $cashboxTodayAmount = 0;
        $bankTodayAmount = 0;

        $cashboxTodayCount = 0;
        $bankTodayCount = 0;

        $cashboxPendingAmount = 0;
        $bankPendingAmount = 0;

        $cashboxPendingCount = 0;
        $bankPendingCount = 0;

        $availableCashboxBalance = 0;
        $availableBankBalance = 0;

        /*
     * =========================================================
     * 3. DÉCAISSEMENTS DE CAISSE DU MOIS COURANT
     * =========================================================
     */

        if (
            $this->db->table_exists(
                'tbl_finance_cashbox_operation'
            )
        ) {
            $cashboxCurrentMonth = $this->db
                ->select(
                    'COALESCE(SUM(amount), 0) AS total_amount',
                    false
                )
                ->from(
                    'tbl_finance_cashbox_operation'
                )
                ->where(
                    'operation_type',
                    'decaissement'
                )
                ->where(
                    'status',
                    'validated'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->where(
                    'operation_date >=',
                    $currentMonthStart
                )
                ->where(
                    'operation_date <=',
                    $currentMonthEnd
                )
                ->get()
                ->row();

            $cashboxCurrentMonthAmount =
                $cashboxCurrentMonth
                ? (float) $cashboxCurrentMonth->total_amount
                : 0;

            /*
         * Mois précédent.
         */
            $cashboxPreviousMonth = $this->db
                ->select(
                    'COALESCE(SUM(amount), 0) AS total_amount',
                    false
                )
                ->from(
                    'tbl_finance_cashbox_operation'
                )
                ->where(
                    'operation_type',
                    'decaissement'
                )
                ->where(
                    'status',
                    'validated'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->where(
                    'operation_date >=',
                    $previousMonthStart
                )
                ->where(
                    'operation_date <=',
                    $previousMonthEnd
                )
                ->get()
                ->row();

            $cashboxPreviousMonthAmount =
                $cashboxPreviousMonth
                ? (float) $cashboxPreviousMonth->total_amount
                : 0;

            /*
         * Décaissements du jour.
         */
            $cashboxToday = $this->db
                ->select([
                    'COALESCE(SUM(amount), 0) AS total_amount',
                    'COUNT(id) AS total_operations',
                ], false)
                ->from(
                    'tbl_finance_cashbox_operation'
                )
                ->where(
                    'operation_type',
                    'decaissement'
                )
                ->where(
                    'status',
                    'validated'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->where(
                    'operation_date',
                    $today
                )
                ->get()
                ->row();

            if ($cashboxToday) {
                $cashboxTodayAmount =
                    (float) $cashboxToday->total_amount;

                $cashboxTodayCount =
                    (int) $cashboxToday->total_operations;
            }

            /*
         * Décaissements en attente.
         */
            $cashboxPending = $this->db
                ->select([
                    'COALESCE(SUM(amount), 0) AS total_amount',
                    'COUNT(id) AS total_operations',
                ], false)
                ->from(
                    'tbl_finance_cashbox_operation'
                )
                ->where(
                    'operation_type',
                    'decaissement'
                )
                ->where(
                    'status',
                    'pending'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->get()
                ->row();

            if ($cashboxPending) {
                $cashboxPendingAmount =
                    (float) $cashboxPending->total_amount;

                $cashboxPendingCount =
                    (int) $cashboxPending->total_operations;
            }
        }

        /*
     * =========================================================
     * 4. DÉCAISSEMENTS BANCAIRES
     * =========================================================
     */

        if (
            $this->db->table_exists(
                'tbl_finance_bank_operation'
            )
        ) {
            /*
         * Mois courant.
         */
            $bankCurrentMonth = $this->db
                ->select(
                    'COALESCE(SUM(amount), 0) AS total_amount',
                    false
                )
                ->from(
                    'tbl_finance_bank_operation'
                )
                ->where(
                    'operation_type',
                    'decaissement'
                )
                ->where(
                    'status',
                    'validated'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->where(
                    'operation_date >=',
                    $currentMonthStart
                )
                ->where(
                    'operation_date <=',
                    $currentMonthEnd
                )
                ->get()
                ->row();

            $bankCurrentMonthAmount =
                $bankCurrentMonth
                ? (float) $bankCurrentMonth->total_amount
                : 0;

            /*
         * Mois précédent.
         */
            $bankPreviousMonth = $this->db
                ->select(
                    'COALESCE(SUM(amount), 0) AS total_amount',
                    false
                )
                ->from(
                    'tbl_finance_bank_operation'
                )
                ->where(
                    'operation_type',
                    'decaissement'
                )
                ->where(
                    'status',
                    'validated'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->where(
                    'operation_date >=',
                    $previousMonthStart
                )
                ->where(
                    'operation_date <=',
                    $previousMonthEnd
                )
                ->get()
                ->row();

            $bankPreviousMonthAmount =
                $bankPreviousMonth
                ? (float) $bankPreviousMonth->total_amount
                : 0;

            /*
         * Décaissements bancaires du jour.
         */
            $bankToday = $this->db
                ->select([
                    'COALESCE(SUM(amount), 0) AS total_amount',
                    'COUNT(id) AS total_operations',
                ], false)
                ->from(
                    'tbl_finance_bank_operation'
                )
                ->where(
                    'operation_type',
                    'decaissement'
                )
                ->where(
                    'status',
                    'validated'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->where(
                    'operation_date',
                    $today
                )
                ->get()
                ->row();

            if ($bankToday) {
                $bankTodayAmount =
                    (float) $bankToday->total_amount;

                $bankTodayCount =
                    (int) $bankToday->total_operations;
            }

            /*
         * Décaissements bancaires en attente.
         */
            $bankPending = $this->db
                ->select([
                    'COALESCE(SUM(amount), 0) AS total_amount',
                    'COUNT(id) AS total_operations',
                ], false)
                ->from(
                    'tbl_finance_bank_operation'
                )
                ->where(
                    'operation_type',
                    'decaissement'
                )
                ->where(
                    'status',
                    'pending'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->get()
                ->row();

            if ($bankPending) {
                $bankPendingAmount =
                    (float) $bankPending->total_amount;

                $bankPendingCount =
                    (int) $bankPending->total_operations;
            }
        }

        /*
     * =========================================================
     * 5. SOLDES DISPONIBLES DES CAISSES
     * =========================================================
     */

        if (
            $this->db->table_exists(
                'tbl_finance_cashbox'
            )
        ) {
            $cashboxAvailable = $this->db
                ->select(
                    'COALESCE(SUM(current_balance), 0) AS total_balance',
                    false
                )
                ->from(
                    'tbl_finance_cashbox'
                )
                ->where(
                    'status',
                    'active'
                )
                ->where(
                    'devise',
                    'BIF'
                )
                ->get()
                ->row();

            $availableCashboxBalance =
                $cashboxAvailable
                ? (float) $cashboxAvailable->total_balance
                : 0;
        }

        /*
     * =========================================================
     * 6. SOLDES DISPONIBLES DES COMPTES BANCAIRES
     * =========================================================
     */

        if (
            $this->db->table_exists(
                'tbl_finance_bank_account'
            )
        ) {
            $bankAvailable = $this->db
                ->select(
                    'COALESCE(SUM(current_balance), 0) AS total_balance',
                    false
                )
                ->from(
                    'tbl_finance_bank_account'
                )
                ->where(
                    'status',
                    'active'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->get()
                ->row();

            $availableBankBalance =
                $bankAvailable
                ? (float) $bankAvailable->total_balance
                : 0;
        }

        /*
     * =========================================================
     * 7. TOTAUX CONSOLIDÉS
     * =========================================================
     */

        $currentMonthAmount =
            $cashboxCurrentMonthAmount
            + $bankCurrentMonthAmount;

        $previousMonthAmount =
            $cashboxPreviousMonthAmount
            + $bankPreviousMonthAmount;

        $todayAmount =
            $cashboxTodayAmount
            + $bankTodayAmount;

        $todayCount =
            $cashboxTodayCount
            + $bankTodayCount;

        $pendingAmount =
            $cashboxPendingAmount
            + $bankPendingAmount;

        $pendingCount =
            $cashboxPendingCount
            + $bankPendingCount;

        $availableTreasury =
            $availableCashboxBalance
            + $availableBankBalance;

        /*
     * =========================================================
     * 8. VARIATION MENSUELLE
     * =========================================================
     */

        $monthlyVariation = 0;

        if ($previousMonthAmount > 0) {
            $monthlyVariation =
                (
                    (
                        $currentMonthAmount
                        - $previousMonthAmount
                    )
                    / $previousMonthAmount
                ) * 100;
        } elseif ($currentMonthAmount > 0) {
            $monthlyVariation = 100;
        }

        /*
     * Limiter la valeur à deux décimales.
     */
        $monthlyVariation =
            round(
                $monthlyVariation,
                2
            );

        /*
     * =========================================================
     * 9. RÉSULTAT
     * =========================================================
     */

        return [
            'current_month_amount' =>
            $currentMonthAmount,

            'previous_month_amount' =>
            $previousMonthAmount,

            'monthly_variation' =>
            $monthlyVariation,

            'today_amount' =>
            $todayAmount,

            'today_count' =>
            $todayCount,

            'pending_amount' =>
            $pendingAmount,

            'pending_count' =>
            $pendingCount,

            'available_treasury' =>
            $availableTreasury,

            /*
         * Détails facultatifs.
         */
            'available_cashbox_balance' =>
            $availableCashboxBalance,

            'available_bank_balance' =>
            $availableBankBalance,

            'cashbox_current_month_amount' =>
            $cashboxCurrentMonthAmount,

            'bank_current_month_amount' =>
            $bankCurrentMonthAmount,
        ];
    }

    /**
     * Retourne l'évolution mensuelle des décaissements de caisse.
     *
     * Source unique :
     * tbl_finance_cashbox_operation
     *
     * Conditions :
     * - operation_type = decaissement
     * - status = validated
     * - currency = BIF
     *
     * @param string $period
     *
     * @return array
     */
    public function getDecaissementEvolution(
        string $period = '6months'
    ): array {
        /*
     * =========================================================
     * 1. SÉCURISER LA PÉRIODE
     * =========================================================
     */

        $allowedPeriods = [
            '6months',
            '12months',
            'current_year',
            'previous_year',
        ];

        if (
            !in_array(
                $period,
                $allowedPeriods,
                true
            )
        ) {
            $period = '6months';
        }

        /*
     * =========================================================
     * 2. DÉTERMINER LA PÉRIODE
     * =========================================================
     */

        switch ($period) {
            case '12months':

                $startDate = date(
                    'Y-m-01',
                    strtotime('-11 months')
                );

                $endDate = date('Y-m-t');

                break;

            case 'current_year':

                $startDate = date('Y-01-01');
                $endDate = date('Y-12-31');

                break;

            case 'previous_year':

                $previousYear =
                    (int) date('Y') - 1;

                $startDate =
                    $previousYear . '-01-01';

                $endDate =
                    $previousYear . '-12-31';

                break;

            case '6months':
            default:

                $startDate = date(
                    'Y-m-01',
                    strtotime('-5 months')
                );

                $endDate = date('Y-m-t');

                break;
        }

        /*
     * =========================================================
     * 3. MOIS EN FRANÇAIS
     * =========================================================
     */

        $frenchMonths = [
            1  => 'Janvier',
            2  => 'Février',
            3  => 'Mars',
            4  => 'Avril',
            5  => 'Mai',
            6  => 'Juin',
            7  => 'Juillet',
            8  => 'Août',
            9  => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre',
        ];

        /*
     * =========================================================
     * 4. PRÉPARER TOUS LES MOIS
     * =========================================================
     */

        $startMonth = new DateTime($startDate);
        $startMonth->modify('first day of this month');

        $endMonth = new DateTime($endDate);
        $endMonth->modify('first day of next month');

        $dateInterval =
            new DateInterval('P1M');

        $datePeriod =
            new DatePeriod(
                $startMonth,
                $dateInterval,
                $endMonth
            );

        $months = [];

        foreach ($datePeriod as $monthDate) {
            $year =
                (int) $monthDate->format('Y');

            $month =
                (int) $monthDate->format('n');

            $monthKey =
                $monthDate->format('Y-m');

            $label =
                $frenchMonths[$month];

            /*
         * Ajouter l’année lorsque la période
         * peut traverser plusieurs exercices.
         */
            if (
                $period === '12months'
                || $period === 'previous_year'
            ) {
                $label .= ' ' . $year;
            }

            $months[$monthKey] = [
                'year' =>
                $year,

                'month' =>
                $month,

                'label' =>
                $label,

                'realized_amount' =>
                0,

                'operation_count' =>
                0,

                'planned_amount' =>
                0,
            ];
        }

        /*
     * =========================================================
     * 5. DÉCAISSEMENTS RÉALISÉS
     * =========================================================
     */

        if (
            $this->db->table_exists(
                'tbl_finance_cashbox_operation'
            )
        ) {
            $rows = $this->db
                ->select([
                    'YEAR(operation_date) AS operation_year',
                    'MONTH(operation_date) AS operation_month',
                    'COALESCE(SUM(amount), 0) AS total_amount',
                    'COUNT(id) AS total_operations',
                ], false)
                ->from(
                    'tbl_finance_cashbox_operation'
                )
                ->where(
                    'operation_type',
                    'decaissement'
                )
                ->where(
                    'status',
                    'validated'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->where(
                    'operation_date >=',
                    $startDate
                )
                ->where(
                    'operation_date <=',
                    $endDate
                )
                ->group_by([
                    'YEAR(operation_date)',
                    'MONTH(operation_date)',
                ])
                ->order_by(
                    'YEAR(operation_date)',
                    'ASC'
                )
                ->order_by(
                    'MONTH(operation_date)',
                    'ASC'
                )
                ->get()
                ->result();

            foreach ($rows as $row) {
                $monthKey =
                    sprintf(
                        '%04d-%02d',
                        (int) $row->operation_year,
                        (int) $row->operation_month
                    );

                if (!isset($months[$monthKey])) {
                    continue;
                }

                $months[$monthKey]['realized_amount'] =
                    (float) $row->total_amount;

                $months[$monthKey]['operation_count'] =
                    (int) $row->total_operations;
            }
        }

        /*
     * =========================================================
     * 6. BUDGET PRÉVU
     * =========================================================
     *
     * Facultatif : utilise la table budget si elle existe.
     */

        if (
            $this->db->table_exists(
                'tbl_finance_disbursement_budget'
            )
        ) {
            $budgetRows = $this->db
                ->select([
                    'budget_year',
                    'budget_month',
                    'planned_amount',
                ])
                ->from(
                    'tbl_finance_disbursement_budget'
                )
                ->where(
                    'currency',
                    'BIF'
                )
                ->where(
                    'status',
                    'active'
                )
                ->get()
                ->result();

            foreach ($budgetRows as $budgetRow) {
                $monthKey =
                    sprintf(
                        '%04d-%02d',
                        (int) $budgetRow->budget_year,
                        (int) $budgetRow->budget_month
                    );

                if (!isset($months[$monthKey])) {
                    continue;
                }

                $months[$monthKey]['planned_amount'] =
                    (float) $budgetRow->planned_amount;
            }
        }

        /*
     * =========================================================
     * 7. PRÉPARER LES TABLEAUX CHART.JS
     * =========================================================
     */

        $labels = [];
        $realizedAmounts = [];
        $plannedAmounts = [];
        $operationCounts = [];

        $totalRealized = 0;
        $totalPlanned = 0;
        $totalOperations = 0;

        foreach ($months as $monthData) {
            $labels[] =
                $monthData['label'];

            $realizedAmounts[] =
                round(
                    (float) $monthData['realized_amount'],
                    2
                );

            $plannedAmounts[] =
                round(
                    (float) $monthData['planned_amount'],
                    2
                );

            $operationCounts[] =
                (int) $monthData['operation_count'];

            $totalRealized +=
                (float) $monthData['realized_amount'];

            $totalPlanned +=
                (float) $monthData['planned_amount'];

            $totalOperations +=
                (int) $monthData['operation_count'];
        }

        /*
     * =========================================================
     * 8. TAUX D’EXÉCUTION
     * =========================================================
     */

        $budgetExecutionRate =
            $totalPlanned > 0
            ? (
                $totalRealized
                / $totalPlanned
            ) * 100
            : 0;

        return [
            'period' =>
            $period,

            'start_date' =>
            $startDate,

            'end_date' =>
            $endDate,

            'labels' =>
            $labels,

            'realized_amounts' =>
            $realizedAmounts,

            'planned_amounts' =>
            $plannedAmounts,

            'operation_counts' =>
            $operationCounts,

            'months' =>
            array_values($months),

            'total_realized' =>
            $totalRealized,

            'total_planned' =>
            $totalPlanned,

            'total_operations' =>
            $totalOperations,

            'budget_difference' =>
            $totalPlanned - $totalRealized,

            'budget_execution_rate' =>
            round(
                $budgetExecutionRate,
                2
            ),
        ];
    }

    /**
     * Compte les décaissements enregistrés dans les caisses.
     *
     * @return int
     */
    public function countDecaissementHistory(): int
    {
        return (int) $this->db
            ->from('tbl_finance_cashbox_operation')
            ->where('operation_type', 'decaissement')
            ->count_all_results();
    }

    /**
     * Retourne l'historique paginé des décaissements.
     *
     * Source :
     * tbl_finance_cashbox_operation
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function getDecaissementHistory(
        int $limit = 10,
        int $offset = 0
    ): array {
        $limit = max(1, $limit);
        $offset = max(0, $offset);

        return $this->db
            ->select([
                'operation.id',
                'operation.reference',
                'operation.operation_date',
                'operation.amount',
                'operation.currency',
                'operation.category',
                'operation.third_party',
                'operation.payment_method',
                'operation.document_number',
                'operation.attachment',
                'operation.label',
                'operation.observation',
                'operation.status',
                'operation.created_at',

                'cashbox.id AS cashbox_id',
                'cashbox.code AS cashbox_code',
                'cashbox.name AS cashbox_name',
                'cashbox.type AS cashbox_type',
                'cashbox.chantier_id',

                'chantier.ref_chantier',
                'chantier.name AS chantier_name',
            ])
            ->from(
                'tbl_finance_cashbox_operation AS operation'
            )
            ->join(
                'tbl_finance_cashbox AS cashbox',
                'cashbox.id = operation.source_cashbox_id',
                'left'
            )
            ->join(
                'chantiers AS chantier',
                'chantier.id = cashbox.chantier_id',
                'left'
            )
            ->where(
                'operation.operation_type',
                'decaissement'
            )
            ->order_by(
                'operation.operation_date',
                'DESC'
            )
            ->order_by(
                'operation.created_at',
                'DESC'
            )
            ->order_by(
                'operation.id',
                'DESC'
            )
            ->limit(
                $limit,
                $offset
            )
            ->get()
            ->result();
    }

    /**
     * Retourne la synthèse des décaissements par chantier.
     *
     * Sources :
     * - chantiers : budget du chantier ;
     * - tbl_finance_cashbox : caisse associée au chantier ;
     * - tbl_finance_cashbox_operation : décaissements enregistrés.
     *
     * @param string|null $startDate
     * @param string|null $endDate
     *
     * @return array
     */
    public function getDecaissementChantierSummary(
        ?string $startDate = null,
        ?string $endDate = null
    ): array {
        /*
     * =========================================================
     * 1. NORMALISER LES DATES
     * =========================================================
     */

        $startDate = !empty($startDate)
            ? $startDate
            : date('Y-m-01');

        $endDate = !empty($endDate)
            ? $endDate
            : date('Y-m-t');

        /*
     * =========================================================
     * 2. SOUS-REQUÊTE DES DÉCAISSEMENTS
     * =========================================================
     *
     * On calcule le total décaissé par chantier à partir :
     *
     * opération.source_cashbox_id
     *      -> cashbox.id
     *      -> cashbox.chantier_id
     */

        $escapedStartDate =
            $this->db->escape($startDate);

        $escapedEndDate =
            $this->db->escape($endDate);

        $operationSubquery = "
        SELECT
            cb.chantier_id,

            COALESCE(
                SUM(op.amount),
                0
            ) AS total_disbursed,

            COUNT(op.id) AS operation_count

        FROM tbl_finance_cashbox_operation AS op

        INNER JOIN tbl_finance_cashbox AS cb
            ON cb.id = op.source_cashbox_id

        WHERE op.operation_type = 'decaissement'

          AND op.status = 'validated'

          AND op.currency = 'BIF'

          AND op.operation_date >= {$escapedStartDate}

          AND op.operation_date <= {$escapedEndDate}

          AND cb.chantier_id IS NOT NULL

        GROUP BY cb.chantier_id
    ";

        /*
     * =========================================================
     * 3. RÉCUPÉRER LES CHANTIERS
     * =========================================================
     */

        $rows = $this->db
            ->select([
                'chantier.id',
                'chantier.ref_chantier',
                'chantier.name',
                'chantier.location',
                'chantier.status',

                'COALESCE(chantier.budget, 0) AS budget',

                'COALESCE(disbursement.total_disbursed, 0) AS total_disbursed',

                'COALESCE(disbursement.operation_count, 0) AS operation_count',
            ], false)
            ->from('chantiers AS chantier')
            ->join(
                "({$operationSubquery}) AS disbursement",
                'disbursement.chantier_id = chantier.id',
                'left',
                false
            )
            ->where('chantier.status', 'Actif')
            ->order_by(
                'total_disbursed',
                'DESC'
            )
            ->order_by(
                'chantier.name',
                'ASC'
            )
            ->get()
            ->result();

        /*
     * =========================================================
     * 4. CALCULER LES INDICATEURS
     * =========================================================
     */

        $summary = [];

        foreach ($rows as $row) {
            $budget =
                max(
                    0,
                    (float) $row->budget
                );

            $totalDisbursed =
                max(
                    0,
                    (float) $row->total_disbursed
                );

            /*
         * Le disponible peut devenir négatif
         * en cas de dépassement budgétaire.
         */
            $available =
                $budget - $totalDisbursed;

            $consumptionPercentage =
                $budget > 0
                ? (
                    $totalDisbursed
                    / $budget
                ) * 100
                : 0;

            /*
         * Limite CSS de la barre à 100 %,
         * même lorsque le budget est dépassé.
         */
            $progressPercentage =
                min(
                    100,
                    max(
                        0,
                        $consumptionPercentage
                    )
                );

            /*
         * Couleur selon la consommation.
         */
            if ($consumptionPercentage >= 100) {
                $progressClass =
                    'bg-dark';

                $situation =
                    'depassement';
            } elseif ($consumptionPercentage >= 90) {
                $progressClass =
                    'bg-danger';

                $situation =
                    'critique';
            } elseif ($consumptionPercentage >= 75) {
                $progressClass =
                    'bg-warning';

                $situation =
                    'attention';
            } elseif ($consumptionPercentage >= 50) {
                $progressClass =
                    'bg-info';

                $situation =
                    'normal';
            } else {
                $progressClass =
                    'bg-success';

                $situation =
                    'faible';
            }

            $summary[] = (object) [
                'id' =>
                (int) $row->id,

                'ref_chantier' =>
                $row->ref_chantier,

                'name' =>
                $row->name,

                'location' =>
                $row->location,

                'budget' =>
                $budget,

                'total_disbursed' =>
                $totalDisbursed,

                'available' =>
                $available,

                'operation_count' =>
                (int) $row->operation_count,

                'consumption_percentage' =>
                round(
                    $consumptionPercentage,
                    2
                ),

                'progress_percentage' =>
                round(
                    $progressPercentage,
                    2
                ),

                'progress_class' =>
                $progressClass,

                'situation' =>
                $situation,
            ];
        }

        return $summary;
    }

    /**
     * Récupère tous les comptes bancaires actifs
     * avec leur solde disponible.
     *
     * @return array
     */
    public function getActiveBankAccountsForReconciliation()
    {
        $this->db->select(
            'id,
         code,
         name,
         bank_name,
         account_number,
         account_type,
         currency,
         current_balance,
         branch_name'
        );

        $this->db->from('tbl_finance_bank_account');

        $this->db->where('status', 'active');

        $this->db->order_by('bank_name', 'ASC');

        $this->db->order_by('name', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Récupère un compte bancaire actif par son identifiant.
     *
     * @param int $bankAccountId
     * @return object|null
     */
    public function getActiveBankAccountById($bankAccountId)
    {
        $bankAccountId = (int) $bankAccountId;

        if ($bankAccountId <= 0) {
            return null;
        }

        return $this->db
            ->select([
                'id',
                'code',
                'name',
                'bank_name',
                'account_number',
                'account_type',
                'currency',
                'opening_balance',
                'current_balance',
                'status',
            ])
            ->from('tbl_finance_bank_account')
            ->where('id', $bankAccountId)
            ->where('status', 'active')
            ->limit(1)
            ->get()
            ->row();
    }

    /**
     * Génère la prochaine référence de rapprochement bancaire.
     *
     * Exemple :
     * RAP-2026-00001
     *
     * @return string
     */
    public function generateBankReconciliationReference()
    {
        $year = date('Y');

        $prefix = 'RAP-' . $year . '-';

        $lastReconciliation = $this->db
            ->select('reference')
            ->from('tbl_finance_bank_reconciliation')
            ->like('reference', $prefix, 'after')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        $nextNumber = 1;

        if (
            $lastReconciliation
            && !empty($lastReconciliation->reference)
        ) {
            $parts = explode(
                '-',
                $lastReconciliation->reference
            );

            $lastNumber = (int) end($parts);

            $nextNumber = $lastNumber + 1;
        }

        return $prefix
            . str_pad(
                $nextNumber,
                5,
                '0',
                STR_PAD_LEFT
            );
    }

    /**
     * Vérifie si une session active existe déjà
     * pour le même compte et la même période.
     *
     * @param int $bankAccountId
     * @param string $periodStart
     * @param string $periodEnd
     * @return bool
     */
    public function bankReconciliationAlreadyExists(
        $bankAccountId,
        $periodStart,
        $periodEnd
    ) {
        return $this->db
            ->from('tbl_finance_bank_reconciliation')
            ->where('bank_account_id', (int) $bankAccountId)
            ->where('period_start', $periodStart)
            ->where('period_end', $periodEnd)
            ->where_in(
                'status',
                [
                    'draft',
                    'in_progress',
                    'completed',
                ]
            )
            ->count_all_results() > 0;
    }

    /**
     * Calcule le solde système d'un compte à une date donnée.
     *
     * Solde =
     * solde d'ouverture
     * + encaissements
     * - décaissements
     * - transferts sortants
     * + transferts entrants
     *
     * @param int $bankAccountId
     * @param string $date
     * @return float
     */
    public function getBankAccountSystemBalanceAtDate(
        $bankAccountId,
        $date
    ) {
        $bankAccount = $this->db
            ->select('opening_balance')
            ->from('tbl_finance_bank_account')
            ->where('id', (int) $bankAccountId)
            ->limit(1)
            ->get()
            ->row();

        if (!$bankAccount) {
            return 0;
        }

        $balance = (float) $bankAccount->opening_balance;

        /*
     * Entrées sur le compte.
     */
        $incoming = $this->db
            ->select_sum('amount', 'total')
            ->from('tbl_finance_bank_operation')
            ->where('destination_bank_account_id', (int) $bankAccountId)
            ->where('operation_date <', $date)
            ->where('status', 'validated')
            ->get()
            ->row();

        /*
     * Sorties depuis le compte.
     */
        $outgoing = $this->db
            ->select_sum('amount', 'total')
            ->from('tbl_finance_bank_operation')
            ->where('source_bank_account_id', (int) $bankAccountId)
            ->where('operation_date <', $date)
            ->where('status', 'validated')
            ->get()
            ->row();

        $incomingAmount = $incoming
            ? (float) $incoming->total
            : 0;

        $outgoingAmount = $outgoing
            ? (float) $outgoing->total
            : 0;

        return $balance
            + $incomingAmount
            - $outgoingAmount;
    }

    /**
     * Calcule le solde système jusqu'à la fin d'une date.
     *
     * @param int $bankAccountId
     * @param string $date
     * @return float
     */
    public function getBankAccountSystemClosingBalance(
        $bankAccountId,
        $date
    ) {
        $bankAccount = $this->db
            ->select('opening_balance')
            ->from('tbl_finance_bank_account')
            ->where('id', (int) $bankAccountId)
            ->limit(1)
            ->get()
            ->row();

        if (!$bankAccount) {
            return 0;
        }

        $balance = (float) $bankAccount->opening_balance;

        $incoming = $this->db
            ->select_sum('amount', 'total')
            ->from('tbl_finance_bank_operation')
            ->where('destination_bank_account_id', (int) $bankAccountId)
            ->where('operation_date <=', $date)
            ->where('status', 'validated')
            ->get()
            ->row();

        $outgoing = $this->db
            ->select_sum('amount', 'total')
            ->from('tbl_finance_bank_operation')
            ->where('source_bank_account_id', (int) $bankAccountId)
            ->where('operation_date <=', $date)
            ->where('status', 'validated')
            ->get()
            ->row();

        $incomingAmount = $incoming
            ? (float) $incoming->total
            : 0;

        $outgoingAmount = $outgoing
            ? (float) $outgoing->total
            : 0;

        return $balance
            + $incomingAmount
            - $outgoingAmount;
    }

    /**
     * Enregistre une nouvelle session de rapprochement.
     *
     * @param array $data
     * @return array
     */
    public function createBankReconciliation(array $data)
    {
        $this->db->trans_begin();

        try {
            /*
         * Génération de la référence dans la transaction.
         */
            $data['reference'] =
                $this->generateBankReconciliationReference();

            $inserted = $this->db->insert(
                'tbl_finance_bank_reconciliation',
                $data
            );

            if (!$inserted) {
                throw new Exception(
                    'Impossible d’enregistrer le rapprochement bancaire.'
                );
            }

            $reconciliationId =
                (int) $this->db->insert_id();

            if ($this->db->trans_status() === false) {
                throw new Exception(
                    'Une erreur est survenue pendant la transaction.'
                );
            }

            $this->db->trans_commit();

            return [
                'status' => true,
                'id' => $reconciliationId,
                'reference' => $data['reference'],
                'message' =>
                'Le rapprochement bancaire a été démarré.',
            ];
        } catch (Throwable $exception) {
            $this->db->trans_rollback();

            log_message(
                'error',
                'Erreur création rapprochement bancaire : '
                    . $exception->getMessage()
            );

            return [
                'status' => false,
                'id' => null,
                'reference' => null,
                'message' => $exception->getMessage(),
            ];
        }
    }

    /**
     * Génère la prochaine référence du relevé bancaire.
     *
     * @return string
     */
    public function generateBankStatementReference()
    {
        $year = date('Y');

        $prefix = 'REL-' . $year . '-';

        $lastStatement = $this->db
            ->select('reference')
            ->from('tbl_finance_bank_statement')
            ->like('reference', $prefix, 'after')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        $nextNumber = 1;

        if (
            $lastStatement
            && !empty($lastStatement->reference)
        ) {
            $referenceParts = explode(
                '-',
                $lastStatement->reference
            );

            $lastNumber = (int) end($referenceParts);

            $nextNumber = $lastNumber + 1;
        }

        return $prefix
            . str_pad(
                $nextNumber,
                5,
                '0',
                STR_PAD_LEFT
            );
    }

    /**
     * Vérifie si un relevé existe déjà pour le compte
     * et la période sélectionnés.
     *
     * @param int $bankAccountId
     * @param string $periodStart
     * @param string $periodEnd
     * @return bool
     */
    public function bankStatementAlreadyExists(
        $bankAccountId,
        $periodStart,
        $periodEnd
    ) {
        return $this->db
            ->from('tbl_finance_bank_statement')
            ->where('bank_account_id', (int) $bankAccountId)
            ->where('period_start', $periodStart)
            ->where('period_end', $periodEnd)
            ->where_not_in(
                'status',
                [
                    'cancelled',
                    'failed',
                ]
            )
            ->count_all_results() > 0;
    }

    /**
     * Enregistre les informations d'un relevé bancaire.
     *
     * @param array $data
     * @return array
     */
    public function createBankStatement(array $data)
    {
        $this->db->trans_begin();

        try {
            $data['reference'] =
                $this->generateBankStatementReference();

            $inserted = $this->db->insert(
                'tbl_finance_bank_statement',
                $data
            );

            if (!$inserted) {
                $databaseError = $this->db->error();

                throw new Exception(
                    !empty($databaseError['message'])
                        ? $databaseError['message']
                        : 'Le relevé bancaire n’a pas pu être enregistré.'
                );
            }

            $statementId =
                (int) $this->db->insert_id();

            if ($this->db->trans_status() === false) {
                throw new Exception(
                    'La transaction d’importation a échoué.'
                );
            }

            $this->db->trans_commit();

            return [
                'status' => true,
                'id' => $statementId,
                'reference' => $data['reference'],
                'message' =>
                'Le relevé bancaire a été importé avec succès.',
            ];
        } catch (Throwable $exception) {
            $this->db->trans_rollback();

            log_message(
                'error',
                'Erreur import relevé bancaire : '
                    . $exception->getMessage()
            );

            return [
                'status' => false,
                'id' => null,
                'reference' => null,
                'message' => $exception->getMessage(),
            ];
        }
    }

    /**
     * Statistiques principales du rapprochement bancaire.
     *
     * @return array
     */
    public function getBankReconciliationMainStatistics()
    {
        $startDate = date('Y-m-01');
        $endDate   = date('Y-m-t');

        /*
     * Valeurs par défaut.
     */
        $statistics = [
            'total_bank_operations'       => 0,
            'matched_operations'          => 0,
            'matched_percentage'          => 0,

            'statement_accounts_count'    => 0,
            'statement_closing_balance'   => 0,

            'pending_operations_count'    => 0,
            'pending_operations_amount'   => 0,

            'anomalies_count'             => 0,
            'unjustified_difference'      => 0,
        ];

        /*
     * =====================================================
     * 1. Nombre total d'opérations bancaires du mois
     * =====================================================
     */
        $totalOperations = $this->db
            ->select('COUNT(bo.id) AS total_operations', false)
            ->from('tbl_finance_bank_operation bo')
            ->where('bo.operation_date >=', $startDate)
            ->where('bo.operation_date <=', $endDate)
            ->get()
            ->row();

        $statistics['total_bank_operations'] =
            $totalOperations
            ? (int) $totalOperations->total_operations
            : 0;

        /*
     * =====================================================
     * 2. Soldes des relevés bancaires importés
     * =====================================================
     *
     * On prend le dernier relevé de chaque compte bancaire.
     */
        $latestStatementsSubquery = "
        SELECT
            MAX(bs2.id)
        FROM tbl_finance_bank_statement bs2
        WHERE bs2.bank_account_id = bs.bank_account_id
    ";

        $statementSummary = $this->db
            ->select([
                'COUNT(DISTINCT bs.bank_account_id) AS accounts_count',
                'COALESCE(SUM(bs.closing_balance), 0) AS total_closing_balance',
            ], false)
            ->from('tbl_finance_bank_statement bs')
            ->where(
                "bs.id IN ($latestStatementsSubquery)",
                null,
                false
            )
            ->get()
            ->row();

        if ($statementSummary) {
            $statistics['statement_accounts_count'] =
                (int) $statementSummary->accounts_count;

            $statistics['statement_closing_balance'] =
                (float) $statementSummary->total_closing_balance;
        }

        /*
     * =====================================================
     * 3. Statistiques détaillées de rapprochement
     * =====================================================
     */
        if (
            !$this->db->table_exists(
                'tbl_finance_bank_reconciliation_item'
            )
        ) {
            return $statistics;
        }

        /*
     * Opérations rapprochées.
     */
        $matchedResult = $this->db
            ->select('COUNT(ri.id) AS matched_count', false)
            ->from('tbl_finance_bank_reconciliation_item ri')
            ->join(
                'tbl_finance_bank_reconciliation br',
                'br.id = ri.reconciliation_id',
                'inner'
            )
            ->where('br.period_start <=', $endDate)
            ->where('br.period_end >=', $startDate)
            ->where('ri.matching_status', 'matched')
            ->get()
            ->row();

        $statistics['matched_operations'] =
            $matchedResult
            ? (int) $matchedResult->matched_count
            : 0;

        /*
     * Pourcentage rapproché.
     */
        if ($statistics['total_bank_operations'] > 0) {
            $statistics['matched_percentage'] = round(
                (
                    $statistics['matched_operations']
                    / $statistics['total_bank_operations']
                ) * 100,
                1
            );
        }

        /*
     * Opérations en attente de rapprochement.
     */
        $pendingResult = $this->db
            ->select([
                'COUNT(ri.id) AS pending_count',
                '
                COALESCE(
                    SUM(
                        CASE
                            WHEN ri.statement_amount IS NOT NULL
                            THEN ri.statement_amount
                            ELSE ri.system_amount
                        END
                    ),
                    0
                ) AS pending_amount
            ',
            ], false)
            ->from('tbl_finance_bank_reconciliation_item ri')
            ->join(
                'tbl_finance_bank_reconciliation br',
                'br.id = ri.reconciliation_id',
                'inner'
            )
            ->where('br.period_start <=', $endDate)
            ->where('br.period_end >=', $startDate)
            ->where_in(
                'ri.matching_status',
                [
                    'unmatched',
                    'pending',
                ]
            )
            ->get()
            ->row();

        if ($pendingResult) {
            $statistics['pending_operations_count'] =
                (int) $pendingResult->pending_count;

            $statistics['pending_operations_amount'] =
                (float) $pendingResult->pending_amount;
        }

        /*
     * Anomalies et écart global non justifié.
     */
        $anomalyResult = $this->db
            ->select([
                'COUNT(ri.id) AS anomalies_count',
                '
                COALESCE(
                    SUM(ABS(ri.difference_amount)),
                    0
                ) AS total_difference
            ',
            ], false)
            ->from('tbl_finance_bank_reconciliation_item ri')
            ->join(
                'tbl_finance_bank_reconciliation br',
                'br.id = ri.reconciliation_id',
                'inner'
            )
            ->where('br.period_start <=', $endDate)
            ->where('br.period_end >=', $startDate)
            ->where_in(
                'ri.matching_status',
                [
                    'amount_difference',
                    'date_difference',
                    'missing_system_entry',
                    'missing_statement_entry',
                ]
            )
            ->get()
            ->row();

        if ($anomalyResult) {
            $statistics['anomalies_count'] =
                (int) $anomalyResult->anomalies_count;

            $statistics['unjustified_difference'] =
                (float) $anomalyResult->total_difference;
        }

        return $statistics;
    }

    /**
     * Retourne les sessions de rapprochement pouvant être analysées.
     *
     * @return array
     */
    public function getReconciliationsAvailableForAnalysis()
    {
        return $this->db
            ->select([
                'br.id',
                'br.reference',
                'br.bank_account_id',
                'br.period_start',
                'br.period_end',
                'br.currency',
                'br.status',

                'ba.name AS account_name',
                'ba.bank_name',
                'ba.account_number',
            ])
            ->from('tbl_finance_bank_reconciliation br')
            ->join(
                'tbl_finance_bank_account ba',
                'ba.id = br.bank_account_id',
                'inner'
            )
            ->where_in(
                'br.status',
                [
                    'draft',
                    'in_progress',
                ]
            )
            ->order_by('br.created_at', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Récupère une session de rapprochement par ID.
     *
     * @param int $reconciliationId
     * @return object|null
     */
    public function getBankReconciliationById($reconciliationId)
    {
        return $this->db
            ->select([
                'br.*',

                'ba.name AS account_name',
                'ba.bank_name',
                'ba.account_number',
                'ba.current_balance AS account_current_balance',
                'ba.currency AS account_currency',
            ])
            ->from('tbl_finance_bank_reconciliation br')
            ->join(
                'tbl_finance_bank_account ba',
                'ba.id = br.bank_account_id',
                'inner'
            )
            ->where('br.id', (int) $reconciliationId)
            ->limit(1)
            ->get()
            ->row();
    }

    /**
     * Recherche un relevé bancaire compatible avec une session.
     */
    public function getStatementForReconciliation(
        $bankAccountId,
        $periodStart,
        $periodEnd
    ) {
        $bankAccountId = (int) $bankAccountId;

        if (
            $bankAccountId <= 0
            || empty($periodStart)
            || empty($periodEnd)
        ) {
            return null;
        }

        return $this->db
            ->select('bs.*')
            ->from('tbl_finance_bank_statement bs')
            ->where(
                'bs.bank_account_id',
                $bankAccountId
            )

            /*
         * Les deux périodes doivent se chevaucher.
         */
            ->where(
                'bs.period_start <=',
                $periodEnd
            )
            ->where(
                'bs.period_end >=',
                $periodStart
            )

            /*
         * Privilégier un relevé couvrant complètement
         * la période de la session.
         */
            ->order_by(
                '
            CASE
                WHEN bs.period_start <= '
                    . $this->db->escape($periodStart)
                    . '
                AND bs.period_end >= '
                    . $this->db->escape($periodEnd)
                    . '
                THEN 0
                ELSE 1
            END
            ',
                'ASC',
                false
            )
            ->order_by(
                'bs.statement_date',
                'DESC'
            )
            ->order_by(
                'bs.id',
                'DESC'
            )
            ->limit(1)
            ->get()
            ->row();
    }

    /**
     * Récupère toutes les lignes analysables d'un relevé.
     */
    public function getStatementLinesForAnalysis(
        $statementId,
        $periodStart,
        $periodEnd
    ) {
        return $this->db
            ->select('bsl.*')
            ->from('tbl_finance_bank_statement_line bsl')
            ->where(
                'bsl.statement_id',
                (int) $statementId
            )
            ->where(
                'bsl.operation_date >=',
                $periodStart
            )
            ->where(
                'bsl.operation_date <=',
                $periodEnd
            )
            ->where(
                'bsl.matching_status !=',
                'ignored'
            )
            ->order_by(
                'bsl.operation_date',
                'ASC'
            )
            ->order_by(
                'bsl.id',
                'ASC'
            )
            ->get()
            ->result();
    }

    /**
     * Cherche une opération système correspondant à une ligne bancaire.
     *
     * @param int $bankAccountId
     * @param object $statementLine
     * @param int $dateTolerance
     * @param float $amountTolerance
     * @return object|null
     */
    public function findMatchingBankOperation(
        $bankAccountId,
        $statementLine,
        $dateTolerance,
        $amountTolerance
    ) {
        $operationDate =
            $statementLine->operation_date;

        $minimumDate = date(
            'Y-m-d',
            strtotime(
                $operationDate
                    . ' -'
                    . (int) $dateTolerance
                    . ' days'
            )
        );

        $maximumDate = date(
            'Y-m-d',
            strtotime(
                $operationDate
                    . ' +'
                    . (int) $dateTolerance
                    . ' days'
            )
        );

        $minimumAmount =
            max(
                0,
                (float) $statementLine->amount
                    - (float) $amountTolerance
            );

        $maximumAmount =
            (float) $statementLine->amount
            + (float) $amountTolerance;

        $this->db
            ->select('bo.*')
            ->from('tbl_finance_bank_operation bo')
            ->where('bo.operation_date >=', $minimumDate)
            ->where('bo.operation_date <=', $maximumDate)
            ->where('bo.amount >=', $minimumAmount)
            ->where('bo.amount <=', $maximumAmount)
            ->where_not_in(
                'bo.status',
                [
                    'cancelled',
                    'rejected',
                ]
            );

        /*
        * Débit sur le relevé :
        * argent sorti du compte.
        */
        if (
            $statementLine->operation_direction
            === 'debit'
        ) {
            $this->db
                ->where(
                    'bo.source_bank_account_id',
                    (int) $bankAccountId
                )
                ->where_in(
                    'bo.operation_type',
                    [
                        'decaissement',
                        'transfert',
                    ]
                );
        }

        /*
        * Crédit sur le relevé :
        * argent entré dans le compte.
        */
        if (
            $statementLine->operation_direction
            === 'credit'
        ) {
            $this->db
                ->where(
                    'bo.destination_bank_account_id',
                    (int) $bankAccountId
                )
                ->where_in(
                    'bo.operation_type',
                    [
                        'encaissement',
                        'transfert',
                    ]
                );
        }

        /*
        * Exclure les opérations déjà rapprochées.
        */
        $this->db->where(
            "
        NOT EXISTS (
            SELECT 1
            FROM tbl_finance_bank_reconciliation_item bri
            WHERE bri.bank_operation_id = bo.id
            AND bri.matching_status = 'matched'
        )
        ",
            null,
            false
        );

        return $this->db
            ->order_by(
                'ABS(DATEDIFF(bo.operation_date, '
                    . $this->db->escape($operationDate)
                    . '))',
                'ASC',
                false
            )
            ->order_by(
                'ABS(bo.amount - '
                    . $this->db->escape(
                        (float) $statementLine->amount
                    )
                    . ')',
                'ASC',
                false
            )
            ->limit(1)
            ->get()
            ->row();
    }

    /**
     * Insère une ligne de résultat du rapprochement.
     *
     * @param array $data
     * @return int
     */
    public function insertReconciliationItem(array $data)
    {
        $this->db->insert(
            'tbl_finance_bank_reconciliation_item',
            $data
        );

        return (int) $this->db->insert_id();
    }

    /**
     * Supprime les résultats automatiques non validés d'une session.
     *
     * @param int $reconciliationId
     * @return bool
     */
    public function deletePreviousAutomaticAnalysis(
        $reconciliationId
    ) {
        return $this->db
            ->where(
                'reconciliation_id',
                (int) $reconciliationId
            )
            ->where('matching_method', 'automatic')
            ->where('validated_at IS NULL', null, false)
            ->delete(
                'tbl_finance_bank_reconciliation_item'
            );
    }

    /**
     * Change le statut de correspondance d'une ligne bancaire.
     *
     * @param int $statementLineId
     * @param string $status
     * @return bool
     */
    public function updateStatementLineMatchingStatus(
        $statementLineId,
        $status
    ) {
        return $this->db
            ->where('id', (int) $statementLineId)
            ->update(
                'tbl_finance_bank_statement_line',
                [
                    'matching_status' => $status,
                    'updated_at'      => date('Y-m-d H:i:s'),
                ]
            );
    }

    /**
     * Met à jour une session de rapprochement.
     *
     * @param int $reconciliationId
     * @param array $data
     * @return bool
     */
    public function updateBankReconciliation(
        $reconciliationId,
        array $data
    ) {
        return $this->db
            ->where('id', (int) $reconciliationId)
            ->update(
                'tbl_finance_bank_reconciliation',
                $data
            );
    }

    // public function getPayablePurchaseRequests(): array
    // {
    //     $this->db->select(
    //         "
    //     prf.id,

    //     CONCAT(
    //         'DA-',
    //         YEAR(prf.created_at),
    //         '-',
    //         LPAD(prf.id, 3, '0')
    //     ) AS request_reference,

    //     prf.chantier_id,
    //     prf.destination_chantier,
    //     prf.created_at AS request_created_at,

    //     p.name AS chantier_name,

    //     ppv.id AS payment_voucher_id,
    //     ppv.payment_number,
    //     ppv.summary AS payment_summary,
    //     ppv.payment_mode,
    //     ppv.amount_paid,
    //     ppv.payment_reference,
    //     ppv.payment_date,
    //     ppv.observation AS payment_observation,
    //     ppv.payment_status,

    //     GROUP_CONCAT(
    //         DISTINCT pri.designation
    //         ORDER BY pri.id ASC
    //         SEPARATOR ', '
    //     ) AS purchase_items_summary
    //     ",
    //         false
    //     );

    //     $this->db->from(
    //         'purchase_request_forms prf'
    //     );

    //     $this->db->join(
    //         'purchase_request_items pri',
    //         'pri.request_id = prf.id',
    //         'left'
    //     );

    //     $this->db->join(
    //         'projects p',
    //         'p.id = prf.chantier_id',
    //         'left'
    //     );

    //     $this->db->join(
    //         'purchase_payment_vouchers ppv',
    //         'ppv.request_id = prf.id',
    //         'inner'
    //     );

    //     /*
    //     * Pour commencer, vérifier uniquement
    //     * que le bon de paiement est effectué.
    //     */
    //     $this->db->where(
    //         'ppv.payment_status',
    //         'effectue'
    //     );

    //     $this->db->where("
    //     NOT EXISTS (
    //         SELECT 1
    //         FROM tbl_finance_cashbox_operation cfo
    //         WHERE cfo.payment_voucher_id = ppv.id
    //         AND cfo.operation_type = 'decaissement'
    //     )", NULL, FALSE);

    //     $this->db->group_by([
    //         'prf.id',
    //         'prf.created_at',
    //         'prf.chantier_id',
    //         'prf.destination_chantier',
    //         'p.name',
    //         'ppv.id',
    //         'ppv.payment_number',
    //         'ppv.summary',
    //         'ppv.payment_mode',
    //         'ppv.amount_paid',
    //         'ppv.payment_reference',
    //         'ppv.payment_date',
    //         'ppv.observation',
    //         'ppv.payment_status',
    //     ]);

    //     $this->db->order_by(
    //         'ppv.payment_date',
    //         'DESC'
    //     );

    //     $this->db->order_by(
    //         'ppv.id',
    //         'DESC'
    //     );

    //     return $this->db
    //         ->get()
    //         ->result();
    // }

    /**
     * =====================================================
     * DA PAYABLES PAR LA CAISSE SECONDAIRE
     * = attachées à un bon de paiement (INNER JOIN)
     * + pas encore payées (payment_status = 'en_attente')
     * =====================================================
     */
    public function getPayablePurchaseRequests()
    {
        $this->db->select("
            prf.id,
            prf.request_date,
            prf.created_at,
            prf.chantier_id,
            prf.destination_chantier,
            prf.payment_status,
            ch.name AS chantier_name,
            pv.id AS voucher_id,
            pv.payment_number,
            pv.summary,
            pv.payment_mode,
            pv.amount_paid,
            pv.payment_reference,
            pv.payment_date,
            pv.observation AS payment_observation,
            pv.payment_status AS voucher_payment_status
        ", false);
        $this->db->from('purchase_request_forms prf');

        /* ✅ Le lien est côté BON : pv.request_id (et non prf.payment_voucher_id, toujours NULL) */
        $this->db->join('purchase_payment_vouchers pv', 'pv.request_id = prf.id', 'inner');
        $this->db->join('chantiers ch', 'ch.id = prf.chantier_id', 'left');

        /* ✅ Enum réel de la DA : non_paye / partiel / paye */
        $this->db->where('prf.payment_status !=', 'paye');

        /* ✅ Uniquement les bons EN ATTENTE de paiement */
        $this->db->where('pv.payment_status', 'en_attente');

        /* Une seule ligne par DA si plusieurs bons */
        $this->db->group_by('prf.id');

        $this->db->order_by('prf.id', 'DESC');

        return $this->db->get()->result();
    }

    /**
     * Récupère et verrouille une caisse pendant une transaction.
     *
     * Cette méthode doit être appelée après trans_begin().
     *
     * @param int $cashboxId
     * @return object|null
     */
    public function getCashboxByIdForUpdate(int $cashboxId)
    {
        if ($cashboxId <= 0) {
            return null;
        }

        $sql = "
        SELECT
            id,
            code,
            name,
            type,
            chantier_id,
            devise,
            current_balance,
            status

        FROM tbl_finance_cashbox

        WHERE id = ?

        LIMIT 1

        FOR UPDATE
    ";

        return $this->db
            ->query(
                $sql,
                [$cashboxId]
            )
            ->row();
    }

    /**
     * Récupérer une caisse par son identifiant.
     */
    public function getCashboxById(int $cashboxId)
    {
        if ($cashboxId <= 0) {
            return null;
        }

        return $this->db
            ->where('id', $cashboxId)
            ->limit(1)
            ->get('tbl_finance_cashbox')
            ->row();
    }

    /**
     * Récupérer un bon de paiement par son identifiant.
     */
    public function getPurchasePaymentVoucherById(
        int $paymentVoucherId
    ) {
        if ($paymentVoucherId <= 0) {
            return null;
        }

        return $this->db
            ->where(
                'id',
                $paymentVoucherId
            )
            ->limit(1)
            ->get(
                'purchase_payment_vouchers'
            )
            ->row();
    }

    /**
     * =====================================================
     * STATISTIQUES DU JOURNAL DE CAISSE SUR UNE PÉRIODE
     * =====================================================
     * Uniquement les opérations VALIDÉES comptent dans les
     * montants (les transferts/approvisionnements sont des
     * mouvements internes : ils ne sont ni des entrées ni
     * des sorties globales).
     */
    public function getJournalPeriodStatistics($dateFrom, $dateTo)
    {
        /* Totaux de la période courante */
        $current = $this->getJournalPeriodTotals($dateFrom, $dateTo);

        /* Période précédente (même durée) pour la variation % */
        $fromTs     = strtotime($dateFrom);
        $toTs       = strtotime($dateTo);
        $lengthDays = (int) round(($toTs - $fromTs) / 86400) + 1;

        $prevFrom = date('Y-m-d', $fromTs - ($lengthDays * 86400));
        $prevTo   = date('Y-m-d', $fromTs - 86400);

        $previous = $this->getJournalPeriodTotals($prevFrom, $prevTo);

        $totalIn  = (float) $current['total_in'];
        $totalOut = (float) $current['total_out'];

        /* Variation des encaissements */
        $inVariation = null;
        if ((float) $previous['total_in'] > 0) {
            $inVariation = (($totalIn - (float) $previous['total_in'])
                / (float) $previous['total_in']) * 100;
        }

        /* Variation des décaissements */
        $outVariation = null;
        if ((float) $previous['total_out'] > 0) {
            $outVariation = (($totalOut - (float) $previous['total_out'])
                / (float) $previous['total_out']) * 100;
        }

        return array(
            'total_in'         => $totalIn,
            'total_out'        => $totalOut,
            'count_in'         => (int) $current['count_in'],
            'count_out'        => (int) $current['count_out'],
            'total_operations' => (int) $current['total_operations'],
            'pending_count'    => (int) $current['pending_count'],
            'cancelled_count'  => (int) $current['cancelled_count'],
            'transfer_count'   => (int) $current['transfer_count'],
            'net_flow'         => $totalIn - $totalOut,
            'in_variation'     => $inVariation,
            'out_variation'    => $outVariation,
        );
    }

    /**
     * =====================================================
     * TOTAUX D'UNE PÉRIODE (helper interne)
     * =====================================================
     */
    protected function getJournalPeriodTotals($dateFrom, $dateTo)
    {
        /* FALSE : empêche CI de casser les expressions CASE */
        $this->db->select("
            SUM(CASE WHEN operation_type = 'encaissement'
                    AND status = 'validated'
                    THEN amount ELSE 0 END) AS total_in,
            SUM(CASE WHEN operation_type = 'decaissement'
                    AND status = 'validated'
                    THEN amount ELSE 0 END) AS total_out,
            SUM(CASE WHEN operation_type = 'encaissement'
                    AND status = 'validated'
                    THEN 1 ELSE 0 END) AS count_in,
            SUM(CASE WHEN operation_type = 'decaissement'
                    AND status = 'validated'
                    THEN 1 ELSE 0 END) AS count_out,
            COUNT(id) AS total_operations,
            SUM(CASE WHEN status = 'pending'   THEN 1 ELSE 0 END) AS pending_count,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) AS cancelled_count,
            SUM(CASE WHEN operation_type = 'approvisionnement'
                    THEN 1 ELSE 0 END) AS transfer_count
        ", FALSE);
        $this->db->where('operation_date >=', $dateFrom);
        $this->db->where('operation_date <=', $dateTo);

        $row = $this->db->get('tbl_finance_cashbox_operation')->row();

        return array(
            'total_in'         => ($row && $row->total_in !== null)         ? (float) $row->total_in         : 0,
            'total_out'        => ($row && $row->total_out !== null)        ? (float) $row->total_out        : 0,
            'count_in'         => ($row && $row->count_in !== null)         ? (int) $row->count_in           : 0,
            'count_out'        => ($row && $row->count_out !== null)        ? (int) $row->count_out          : 0,
            'total_operations' => ($row && $row->total_operations !== null) ? (int) $row->total_operations   : 0,
            'pending_count'    => ($row && $row->pending_count !== null)    ? (int) $row->pending_count      : 0,
            'cancelled_count'  => ($row && $row->cancelled_count !== null)  ? (int) $row->cancelled_count    : 0,
            'transfer_count'   => ($row && $row->transfer_count !== null)   ? (int) $row->transfer_count     : 0,
        );
    }

    /**
     * =====================================================
     * SOLDES APRÈS OPÉRATION RECALCULÉS « À REBOURS »
     * =====================================================
     * Repart du current_balance de chaque caisse, puis
     * remonte les opérations de la plus récente à la
     * plus ancienne en « rembobinant » les montants validés.
     *
     * Garantie : la dernière opération validée d'une caisse
     * a un balance_after ÉGAL au current_balance de la caisse.
     */
    public function getJournalRunningBalances()
    {
        /* Soldes actuels de toutes les caisses */
        $cashboxes = $this->db->select('id, current_balance')
            ->get('tbl_finance_cashbox')
            ->result();

        $running = [];
        foreach ($cashboxes as $cashbox) {
            $running[(int) $cashbox->id] = (float) $cashbox->current_balance;
        }

        /* Toutes les opérations, de la plus récente à la plus ancienne */
        $operations = $this->db->select('id, operation_type, status, amount, source_cashbox_id, destination_cashbox_id')
            ->order_by('operation_date', 'DESC')
            ->order_by('created_at', 'DESC')
            ->order_by('id', 'DESC')
            ->get('tbl_finance_cashbox_operation')
            ->result();

        $balances = [];

        foreach ($operations as $op) {
            $amount   = (float) $op->amount;
            $sourceId = (int) $op->source_cashbox_id;
            $destId   = (int) $op->destination_cashbox_id;

            /* Caisse concernée : source, ou destination pour un encaissement */
            $concernedId = ($op->operation_type === 'encaissement')
                ? ($destId > 0 ? $destId : $sourceId)
                : $sourceId;

            if (!isset($running[$concernedId])) {
                $running[$concernedId] = 0;
            }

            /* Solde APRÈS cette opération (état à rebours avant rembobinage) */
            $balances[(int) $op->id] = $running[$concernedId];

            /* Rembobiner uniquement les opérations validées */
            if ($op->status === 'validated') {
                if ($op->operation_type === 'encaissement') {
                    /* L'entrée a crédité la caisse : on la retire à rebours */
                    $running[$concernedId] -= $amount;
                } elseif ($op->operation_type === 'decaissement') {
                    /* La sortie a débité la caisse : on la rajoute à rebours */
                    $running[$sourceId] += $amount;
                } elseif ($op->operation_type === 'approvisionnement') {
                    /* Transfert : débit source + crédit destination */
                    if ($sourceId > 0) {
                        $running[$sourceId] += $amount;
                    }
                    if ($destId > 0) {
                        if (!isset($running[$destId])) {
                            $running[$destId] = 0;
                        }
                        $running[$destId] -= $amount;
                    }
                }
            }
            /* pending / cancelled : ne modifient pas le solde, rien à rembobiner */
        }

        return $balances; /* [id_opération => balance_after] */
    }

    /**
     * =====================================================
     * JOURNAL DE CAISSE : OPÉRATIONS PAGINÉES
     * =====================================================
     */
    public function getJournalOperations($dateFrom, $dateTo, $filters = [], $limit = 15, $offset = 0)
    {
        $this->db->select("
            o.*,
            sc.name  AS source_cashbox_name,
            sc.code  AS source_cashbox_code,
            dc.name  AS destination_cashbox_name,
            dc.code  AS destination_cashbox_code
        ", FALSE);
        $this->db->from('tbl_finance_cashbox_operation o');
        $this->db->join('tbl_finance_cashbox sc', 'sc.id = o.source_cashbox_id', 'left');
        $this->db->join('tbl_finance_cashbox dc', 'dc.id = o.destination_cashbox_id', 'left');

        $this->applyJournalFilters($dateFrom, $dateTo, $filters);

        $this->db->order_by('o.operation_date', 'DESC');
        $this->db->order_by('o.created_at', 'DESC');
        $this->db->order_by('o.id', 'DESC');
        $this->db->limit($limit, $offset);

        $rows = $this->db->get()->result();

        /* -------------------------------------------------
        * Injecter les soldes après opération recalculés
        * (écrase les balance_before/after à 0 de la BDD)
        * ------------------------------------------------- */
        if (!empty($rows)) {
            $balances = $this->getJournalRunningBalances();
            foreach ($rows as $row) {
                if (isset($balances[(int) $row->id])) {
                    $row->balance_after = $balances[(int) $row->id];
                }
            }
        }

        return $rows;
    }

    /**
     * =====================================================
     * NOMBRE TOTAL D'OPÉRATIONS (pagination)
     * =====================================================
     */
    public function countJournalOperations($dateFrom, $dateTo, $filters = [])
    {
        $this->db->from('tbl_finance_cashbox_operation o');
        $this->applyJournalFilters($dateFrom, $dateTo, $filters);
        return (int) $this->db->count_all_results();
    }

    /**
     * =====================================================
     * TOTAUX PAR JOURNÉE (lignes de séparation)
     * =====================================================
     * day_in       = encaissements validés
     * day_out      = décaissements validés
     * day_transfer = transferts/approvisionnements validés
     */
    public function getJournalDayTotals($dateFrom, $dateTo, $filters = [])
    {
        $this->db->select("
        o.operation_date AS day_date,
        COUNT(o.id) AS day_count,
        SUM(CASE WHEN o.operation_type = 'encaissement'
                  AND o.status = 'validated'
                 THEN o.amount ELSE 0 END) AS day_in,
        SUM(CASE WHEN o.operation_type = 'decaissement'
                  AND o.status = 'validated'
                 THEN o.amount ELSE 0 END) AS day_out,
        SUM(CASE WHEN o.operation_type = 'approvisionnement'
                  AND o.status = 'validated'
                 THEN o.amount ELSE 0 END) AS day_transfer
    ", FALSE);
        $this->db->from('tbl_finance_cashbox_operation o');
        $this->applyJournalFilters($dateFrom, $dateTo, $filters);
        $this->db->group_by('o.operation_date');
        $this->db->order_by('o.operation_date', 'DESC');

        $rows = $this->db->get()->result();

        $map = [];
        foreach ($rows as $row) {
            $map[$row->day_date] = $row;
        }
        return $map;
    }

    /**
     * =====================================================
     * OPTIONS DU FILTRE « CAISSE »
     * =====================================================
     */
    public function getJournalCashboxOptions()
    {
        $this->db->select('id, code, name, type');
        $this->db->where('status', 'active');
        $this->db->order_by('code', 'ASC');
        return $this->db->get('tbl_finance_cashbox')->result();
    }

    /**
     * =====================================================
     * FILTRES COMMUNS DU JOURNAL (helper interne)
     * =====================================================
     */
    protected function applyJournalFilters($dateFrom, $dateTo, $filters = [])
    {
        $this->db->where('o.operation_date >=', $dateFrom);
        $this->db->where('o.operation_date <=', $dateTo);

        /* Recherche : référence, libellé, tiers, pièce, catégorie */
        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $this->db->group_start();
            $this->db->like('o.reference', $term);
            $this->db->or_like('o.label', $term);
            $this->db->or_like('o.third_party', $term);
            $this->db->or_like('o.document_number', $term);
            $this->db->or_like('o.category', $term);
            $this->db->group_end();
        }

        /* Caisse (source ou destination) */
        if (!empty($filters['cashbox_id'])) {
            $this->db->group_start();
            $this->db->where('o.source_cashbox_id', (int) $filters['cashbox_id']);
            $this->db->or_where('o.destination_cashbox_id', (int) $filters['cashbox_id']);
            $this->db->group_end();
        }

        /* Type d'opération */
        if (
            !empty($filters['type'])
            && in_array($filters['type'], ['encaissement', 'decaissement', 'approvisionnement'], true)
        ) {
            $this->db->where('o.operation_type', $filters['type']);
        }

        /* Statut */
        if (
            !empty($filters['status'])
            && in_array($filters['status'], ['validated', 'pending', 'cancelled'], true)
        ) {
            $this->db->where('o.status', $filters['status']);
        }
    }

    /**
     * =====================================================
     * RÉPARTITION PAR TYPE D'OPÉRATION
     * =====================================================
     * Compte toutes les opérations (tous statuts confondus)
     * sur la période filtrée.
     */
    public function getJournalTypeDistribution($dateFrom, $dateTo, $filters = [])
    {
        $this->db->select("
            SUM(CASE WHEN o.operation_type = 'encaissement'
                    THEN 1 ELSE 0 END) AS encaissement_count,
            SUM(CASE WHEN o.operation_type = 'decaissement'
                    THEN 1 ELSE 0 END) AS decaissement_count,
            SUM(CASE WHEN o.operation_type = 'approvisionnement'
                    THEN 1 ELSE 0 END) AS transfert_count,
            COUNT(o.id) AS total_count
        ", FALSE);
        $this->db->from('tbl_finance_cashbox_operation o');
        $this->applyJournalFilters($dateFrom, $dateTo, $filters);

        $row = $this->db->get()->row();

        $encaissement = $row ? (int) $row->encaissement_count : 0;
        $decaissement = $row ? (int) $row->decaissement_count : 0;
        $transfert    = $row ? (int) $row->transfert_count    : 0;
        $total        = $row ? (int) $row->total_count        : 0;

        return array(
            'encaissement' => $encaissement,
            'decaissement' => $decaissement,
            'transfert'    => $transfert,
            'total'        => $total,
            'encaissement_percentage' => $total > 0 ? round(($encaissement / $total) * 100) : 0,
            'decaissement_percentage' => $total > 0 ? round(($decaissement / $total) * 100) : 0,
            'transfert_percentage'    => $total > 0 ? round(($transfert / $total) * 100) : 0,
        );
    }

    /**
     * =====================================================
     * CAISSES LES PLUS ACTIVES
     * =====================================================
     * Une opération compte pour sa caisse source ET pour
     * sa caisse destination (dans le cas d'un transfert).
     */
    public function getJournalCashboxActivity($dateFrom, $dateTo, $filters = [], $limit = 5)
    {
        /* Récupérer les caisses impliquées dans les opérations filtrées */
        $this->db->select('o.source_cashbox_id, o.destination_cashbox_id');
        $this->db->from('tbl_finance_cashbox_operation o');
        $this->applyJournalFilters($dateFrom, $dateTo, $filters);
        $rows = $this->db->get()->result();

        /* Comptage par caisse */
        $counts = [];
        foreach ($rows as $row) {
            if (!empty($row->source_cashbox_id)) {
                $sid = (int) $row->source_cashbox_id;
                $counts[$sid] = isset($counts[$sid]) ? $counts[$sid] + 1 : 1;
            }
            if (
                !empty($row->destination_cashbox_id)
                && (int) $row->destination_cashbox_id !== (int) $row->source_cashbox_id
            ) {
                $did = (int) $row->destination_cashbox_id;
                $counts[$did] = isset($counts[$did]) ? $counts[$did] + 1 : 1;
            }
        }

        if (empty($counts)) {
            return [];
        }

        /* Informations des caisses concernées */
        $this->db->select('id, code, name, type');
        $this->db->from('tbl_finance_cashbox');
        $this->db->where_in('id', array_keys($counts));
        $this->db->where('status', 'active');
        $cashboxes = $this->db->get()->result();

        $activity = [];
        foreach ($cashboxes as $cashbox) {
            $activity[] = array(
                'id'               => (int) $cashbox->id,
                'code'             => $cashbox->code,
                'name'             => $cashbox->name,
                'type'             => $cashbox->type,
                'operations_count' => isset($counts[(int) $cashbox->id]) ? $counts[(int) $cashbox->id] : 0,
            );
        }

        /* Tri : les plus actives d'abord */
        usort($activity, function ($a, $b) {
            return $b['operations_count'] - $a['operations_count'];
        });

        return array_slice($activity, 0, $limit);
    }

    /**
     * =====================================================
     * CAISSE + INFOS CHANTIER PAR ID
     * =====================================================
     */
    // public function getCashboxById($cashboxId)
    // {
    //     $this->db->select('c.*, ch.name AS chantier_name, ch.ref_chantier, ch.location');
    //     $this->db->from('tbl_finance_cashbox c');
    //     $this->db->join('chantiers ch', 'ch.id = c.chantier_id', 'left');
    //     $this->db->where('c.id', (int) $cashboxId);

    //     return $this->db->get()->row();
    // }

    /**
     * =====================================================
     * SOLDES « RESTANT DANS LA CAISSE » À REBOURS
     * =====================================================
     * Repart du current_balance de LA caisse et rembobine
     * uniquement SES opérations (entrée = destination,
     * sortie = source). Dernière opération validée
     * => solde = current_balance.
     */
    public function getLivreRunningBalances($cashboxId)
    {
        $cashboxId = (int) $cashboxId;

        $cashbox = $this->db->select('current_balance')
            ->where('id', $cashboxId)
            ->get('tbl_finance_cashbox')
            ->row();

        $running = $cashbox ? (float) $cashbox->current_balance : 0;

        $operations = $this->db->select('id, status, amount, source_cashbox_id, destination_cashbox_id')
            ->group_start()
            ->where('source_cashbox_id', $cashboxId)
            ->or_where('destination_cashbox_id', $cashboxId)
            ->group_end()
            ->order_by('operation_date', 'DESC')
            ->order_by('created_at', 'DESC')
            ->order_by('id', 'DESC')
            ->get('tbl_finance_cashbox_operation')
            ->result();

        $balances = [];

        foreach ($operations as $op) {
            $amount  = (float) $op->amount;
            $isEntry = ((int) $op->destination_cashbox_id === $cashboxId);

            /* Solde après cette opération */
            $balances[(int) $op->id] = $running;

            /* Rembobiner uniquement les opérations validées */
            if ($op->status === 'validated') {
                $running = $isEntry ? $running - $amount : $running + $amount;
            }
        }

        return $balances;
    }

    /**
     * =====================================================
     * LIGNES DU LIVRE DE CAISSE (filtrées + chronologiques)
     * =====================================================
     * Le livre ne consigne que les opérations VALIDÉES.
     * Entrée = caisse en destination ; Sortie = caisse en source.
     */
    public function getLivreOperations($cashboxId, $dateFrom, $dateTo, $filters = [])
    {
        $cashboxId = (int) $cashboxId;

        $this->db->select("
        o.*,
        sc.code AS source_code,
        sc.name AS source_name,
        dc.code AS destination_code,
        dc.name AS destination_name
    ", FALSE);
        $this->db->from('tbl_finance_cashbox_operation o');
        $this->db->join('tbl_finance_cashbox sc', 'sc.id = o.source_cashbox_id', 'left');
        $this->db->join('tbl_finance_cashbox dc', 'dc.id = o.destination_cashbox_id', 'left');

        $this->db->where('o.operation_date >=', $dateFrom);
        $this->db->where('o.operation_date <=', $dateTo);
        $this->db->where('o.status', 'validated');

        /* Direction du mouvement */
        if (!empty($filters['type']) && $filters['type'] === 'entree') {
            $this->db->where('o.destination_cashbox_id', $cashboxId);
        } elseif (!empty($filters['type']) && $filters['type'] === 'sortie') {
            $this->db->where('o.source_cashbox_id', $cashboxId);
        } else {
            $this->db->group_start();
            $this->db->where('o.source_cashbox_id', $cashboxId);
            $this->db->or_where('o.destination_cashbox_id', $cashboxId);
            $this->db->group_end();
        }

        /* Recherche */
        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $this->db->group_start();
            $this->db->like('o.label', $term);
            $this->db->or_like('o.expense_justification', $term);
            $this->db->or_like('o.third_party', $term);
            $this->db->or_like('o.document_number', $term);
            $this->db->or_like('o.purchase_request_reference', $term);
            $this->db->or_like('o.category', $term);
            $this->db->group_end();
        }

        /* Ordre chronologique (comme le papier) */
        $this->db->order_by('o.operation_date', 'ASC');
        $this->db->order_by('o.created_at', 'ASC');
        $this->db->order_by('o.id', 'ASC');

        $rows = $this->db->get()->result();

        /* Injecter direction + solde restant */
        $balances = $this->getLivreRunningBalances($cashboxId);

        foreach ($rows as $row) {
            $row->livre_direction = ((int) $row->destination_cashbox_id === $cashboxId)
                ? 'entree'
                : 'sortie';
            $row->livre_balance_after = isset($balances[(int) $row->id])
                ? $balances[(int) $row->id]
                : 0;
        }

        return $rows;
    }

    /**
     * =====================================================
     * PROCHAIN CODE CAISSE : CAI-AAAA-XXX
     * Calculé depuis les codes existants de la table.
     * =====================================================
     */
    public function generateCashboxCode()
    {
        $year   = date('Y');
        $prefix = 'CAI-' . $year . '-';

        /* Dernier code de l'année en cours */
        $row = $this->db->select('code')
            ->like('code', $prefix, 'after')
            ->order_by('code', 'DESC')
            ->limit(1)
            ->get('tbl_finance_cashbox')
            ->row();

        $next = 1;
        if ($row) {
            $next = ((int) substr($row->code, strlen($prefix))) + 1;
        }

        return $prefix . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    /** Prochaine référence de mouvement d'un livre */
    public function nextMovementReference($table, $prefix)
    {
        $year = date('Y');

        $row = $this->db->select('reference')
            ->like('reference', $prefix . '-' . $year . '-', 'after')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get($table)
            ->row();

        $next = $row ? ((int) substr($row->reference, -4)) + 1 : 1;

        return $prefix . '-' . $year . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    /** Une caisse avec ce rôle existe-t-elle déjà ? */
    public function cashboxRoleExists($role)
    {
        return $this->db->where('role', $role)
            ->count_all_results('tbl_finance_cashbox') > 0;
    }

    /**
     * =====================================================
     * CRÉATION D'UNE CAISSE (PRINCIPALE OU SECONDAIRE)
     * + mouvement « solde initial » dans son livre
     * =====================================================
     */
    public function createCashboxWithRole($data)
    {
        $role = $data['role'];

        if (!in_array($role, ['principale', 'secondaire'], true)) {
            return ['success' => false, 'message' => 'Rôle de caisse invalide.'];
        }

        if ($this->cashboxRoleExists($role)) {
            return [
                'success' => false,
                'message' => ($role === 'principale')
                    ? 'Une caisse principale existe déjà — elle est unique.'
                    : 'Une caisse secondaire existe déjà — elle est unique.',
            ];
        }

        $opening = (float) $data['opening_balance'];
        $code    = $this->generateCashboxCode();
        $now     = date('Y-m-d H:i:s');

        $this->db->trans_start();

        /* ---------- 1) Insertion de la caisse ---------- */
        $this->db->insert('tbl_finance_cashbox', [
            'code'            => $code,
            'name'            => $data['name'],
            'role'            => $role,
            'responsable'     => !empty($data['responsable']) ? $data['responsable'] : null,
            'devise'          => $data['devise'],
            'opening_balance' => $opening,
            'current_balance' => $opening,
            'alert_threshold' => (float) $data['alert_threshold'],
            'observation'     => !empty($data['observation']) ? $data['observation'] : null,
            'status'          => 'active',
            'created_by'      => $data['created_by'] ?? null,
            'created_at'      => $now,
        ]);
        $cashboxId = $this->db->insert_id();

        /* ---------- 2) Solde initial > 0 → 1er mouvement du livre ---------- */
        if ($opening > 0) {
            $isPrincipal = ($role === 'principale');

            $this->db->insert(
                $isPrincipal ? 'tbl_finance_mouvement_principale' : 'tbl_finance_mouvement_secondaire',
                [
                    'reference'      => $this->nextMovementReference(
                        $isPrincipal ? 'tbl_finance_mouvement_principale' : 'tbl_finance_mouvement_secondaire',
                        $isPrincipal ? 'MVP' : 'MVS'
                    ),
                    'sens'           => 'entree',
                    'nature'         => 'solde_initial',
                    'movement_date'  => date('Y-m-d'),
                    'amount'         => $opening,
                    'balance_before' => 0,
                    'balance_after'  => $opening,
                    'devise'         => $data['devise'],
                    'label'          => 'Solde initial à la création de la caisse',
                    'observation'    => !empty($data['observation']) ? $data['observation'] : null,
                    'status'         => 'validated',
                    'created_by'     => $data['created_by'] ?? null,
                    'created_at'     => $now,
                ]
            );
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return ['success' => false, 'message' => 'Erreur pendant l’enregistrement de la caisse.'];
        }

        return ['success' => true, 'id' => $cashboxId, 'code' => $code];
    }

    /** Aiguillage selon le type d'opération */
    public function recordCashboxOperation($type, $data)
    {
        switch ($type) {
            case 'encaissement':
                return $this->recordEncaissement($data);
            case 'approvisionnement':
                return $this->recordApprovisionnement($data);
            case 'decaissement':
                return $this->recordPaiementDa($data);
            default:
                return ['success' => false, 'message' => 'Type d’opération invalide.'];
        }
    }

    /* =====================================================
 * 1) ENCAISSEMENT → livre PRINCIPALE (entrée)
 * ===================================================== */
    public function recordEncaissement($data)
    {
        $cashbox = $this->getCashboxById($data['cashbox_id']);
        if (!$cashbox) {
            return ['success' => false, 'message' => 'Caisse introuvable.'];
        }
        if ($cashbox->role !== 'principale') {
            return ['success' => false, 'message' => 'Les encaissements sont enregistrés uniquement dans la caisse principale.'];
        }

        $before = (float) $cashbox->current_balance;
        $after  = $before + $data['amount'];

        $this->db->trans_start();

        $this->db->insert('tbl_finance_mouvement_principale', [
            'reference'       => $this->nextMovementReference('tbl_finance_mouvement_principale', 'MVP'),
            'sens'            => 'entree',
            'nature'          => 'encaissement',
            'movement_date'   => $data['operation_date'],
            'amount'          => $data['amount'],
            'balance_before'  => $before,
            'balance_after'   => $after,
            'devise'          => $cashbox->devise,
            'third_party'     => $data['third_party'],
            'category'        => $data['category'],
            'payment_method'  => $data['payment_method'],
            'document_number' => $data['document_number'],
            'label'           => 'Encaissement' . (!empty($data['third_party']) ? ' — ' . $data['third_party'] : ''),
            'observation'     => $data['observation'],
            'status'          => 'validated',
            'created_by'      => $data['created_by'],
        ]);

        $this->db->where('id', $cashbox->id)
            ->update('tbl_finance_cashbox', ['current_balance' => $after]);

        $this->db->trans_complete();

        return $this->db->trans_status()
            ? ['success' => true, 'message' => 'Encaissement enregistré dans la caisse principale.']
            : ['success' => false, 'message' => 'Erreur pendant l’enregistrement de l’encaissement.'];
    }

    /* =====================================================
 * 2) APPROVISIONNEMENT → sortie PRINCIPALE + entrée SECONDAIRE
 * ===================================================== */
    public function recordApprovisionnement($data)
    {
        $source      = $this->getCashboxById($data['cashbox_id']);
        $destination = $this->getCashboxById($data['destination_cashbox_id']);

        if (!$source || !$destination) {
            return ['success' => false, 'message' => 'Caisse source ou destination introuvable.'];
        }
        if ($source->role !== 'principale') {
            return ['success' => false, 'message' => 'Seule la caisse principale peut approvisionner.'];
        }
        if ($destination->role !== 'secondaire') {
            return ['success' => false, 'message' => 'La destination doit être la caisse secondaire.'];
        }
        if ((int) $source->id === (int) $destination->id) {
            return ['success' => false, 'message' => 'La source et la destination doivent être différentes.'];
        }
        if ($data['amount'] > (float) $source->current_balance) {
            return ['success' => false, 'message' => 'Solde de la caisse principale insuffisant.'];
        }

        $transferRef = 'TRF-' . date('Y') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);

        $sBefore = (float) $source->current_balance;
        $sAfter  = $sBefore - $data['amount'];
        $dBefore = (float) $destination->current_balance;
        $dAfter  = $dBefore + $data['amount'];

        $this->db->trans_start();

        /* Livre PRINCIPALE : sortie */
        $this->db->insert('tbl_finance_mouvement_principale', [
            'reference'          => $this->nextMovementReference('tbl_finance_mouvement_principale', 'MVP'),
            'sens'               => 'sortie',
            'nature'             => 'approvisionnement',
            'movement_date'      => $data['operation_date'],
            'amount'             => $data['amount'],
            'balance_before'     => $sBefore,
            'balance_after'      => $sAfter,
            'devise'             => $source->devise,
            'transfer_reference' => $transferRef,
            'category'           => $data['category'] ?: 'Approvisionnement',
            'payment_method'     => $data['payment_method'],
            'document_number'    => $data['document_number'],
            'label'              => 'Approvisionnement de la caisse secondaire',
            'observation'        => $data['observation'],
            'status'             => 'validated',
            'created_by'         => $data['created_by'],
        ]);

        /* Livre SECONDAIRE : entrée */
        $this->db->insert('tbl_finance_mouvement_secondaire', [
            'reference'          => $this->nextMovementReference('tbl_finance_mouvement_secondaire', 'MVS'),
            'sens'               => 'entree',
            'nature'             => 'approvisionnement_recu',
            'movement_date'      => $data['operation_date'],
            'amount'             => $data['amount'],
            'balance_before'     => $dBefore,
            'balance_after'      => $dAfter,
            'devise'             => $destination->devise,
            'transfer_reference' => $transferRef,
            'category'           => $data['category'] ?: 'Approvisionnement',
            'payment_method'     => $data['payment_method'],
            'label'              => 'Approvisionnement reçu de la caisse principale',
            'observation'        => $data['observation'],
            'status'             => 'validated',
            'created_by'         => $data['created_by'],
        ]);

        /* Soldes des deux caisses */
        $this->db->where('id', $source->id)
            ->update('tbl_finance_cashbox', ['current_balance' => $sAfter]);
        $this->db->where('id', $destination->id)
            ->update('tbl_finance_cashbox', ['current_balance' => $dAfter]);

        $this->db->trans_complete();

        return $this->db->trans_status()
            ? ['success' => true, 'message' => 'Approvisionnement effectué (' . $transferRef . ').']
            : ['success' => false, 'message' => 'Erreur pendant l’approvisionnement.'];
    }

    /* =====================================================
 * 3) DÉCAISSEMENT (paiement DA) → livre SECONDAIRE (sortie)
 * ===================================================== */
    public function recordPaiementDa($data)
    {
        $cashbox = $this->getCashboxById($data['cashbox_id']);
        if (!$cashbox) {
            return ['success' => false, 'message' => 'Caisse introuvable.'];
        }
        if ($cashbox->role !== 'secondaire') {
            return ['success' => false, 'message' => 'Les paiements de demandes d’achat sont effectués uniquement par la caisse secondaire.'];
        }
        if (empty($data['purchase_request_id'])) {
            return ['success' => false, 'message' => 'Veuillez sélectionner une demande d’achat.'];
        }
        if ($data['amount'] > (float) $cashbox->current_balance) {
            return ['success' => false, 'message' => 'Solde de la caisse secondaire insuffisant.'];
        }

        $before = (float) $cashbox->current_balance;
        $after  = $before - $data['amount'];

        $this->db->trans_start();

        $this->db->insert('tbl_finance_mouvement_secondaire', [
            'reference'                  => $this->nextMovementReference('tbl_finance_mouvement_secondaire', 'MVS'),
            'sens'                       => 'sortie',
            'nature'                     => 'paiement_da',
            'movement_date'              => $data['operation_date'],
            'amount'                     => $data['amount'],
            'balance_before'             => $before,
            'balance_after'              => $after,
            'devise'                     => $cashbox->devise,
            'purchase_request_id'        => $data['purchase_request_id'],
            'purchase_request_reference' => $data['purchase_request_reference'],
            'third_party'                => $data['third_party'],
            'category'                   => $data['category'] ?: 'Paiement demande achat',
            'payment_method'             => $data['payment_method'],
            'document_number'            => $data['document_number'] ?: $data['payment_voucher_reference'],
            'label'                      => 'Paiement ' . (!empty($data['purchase_request_reference']) ? $data['purchase_request_reference'] : 'demande d’achat'),
            'observation'                => $data['expense_justification']
                ? ($data['observation'] ? $data['observation'] . ' | ' . $data['expense_justification'] : $data['expense_justification'])
                : $data['observation'],
            'status'                     => 'validated',
            'created_by'                 => $data['created_by'],
        ]);

        $this->db->where('id', $cashbox->id)
            ->update('tbl_finance_cashbox', ['current_balance' => $after]);

        $this->db->where('request_id', $data['purchase_request_id'])
            ->update('purchase_payment_vouchers', ['payment_status' => 'effectue']);

        $this->db->trans_complete();

        return $this->db->trans_status()
            ? ['success' => true, 'message' => 'Paiement de la demande d’achat enregistré.']
            : ['success' => false, 'message' => 'Erreur pendant l’enregistrement du paiement.'];
    }

    /**
     * =====================================================
     * CAISSE PRINCIPALE (unique)
     * =====================================================
     */
    public function getPrincipalCashbox()
    {
        return $this->db->select('id, code, name, role, responsable, devise,
            opening_balance, current_balance, alert_threshold, status')
            ->where('role', 'principale')
            ->where('status', 'active')
            ->get('tbl_finance_cashbox')
            ->row();
    }

    /**
     * =====================================================
     * CAISSE SECONDAIRE (unique)
     * =====================================================
     */
    public function getSecondaryCashbox()
    {
        return $this->db->select('id, code, name, role, responsable, devise,
            opening_balance, current_balance, alert_threshold, status')
            ->where('role', 'secondaire')
            ->where('status', 'active')
            ->get('tbl_finance_cashbox')
            ->row();
    }

    /**
     * =====================================================
     * STATISTIQUES DE LA PAGE CAISSE (2 CAISSES UNIQUES)
     * =====================================================
     */
    public function getTwoCashboxStatistics()
    {
        $today      = date('Y-m-d');
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        $principal = $this->getPrincipalCashbox();
        $secondary = $this->getSecondaryCashbox();

        $pBalance   = $principal ? (float) $principal->current_balance : 0;
        $sBalance   = $secondary ? (float) $secondary->current_balance : 0;
        $sThreshold = $secondary ? (float) $secondary->alert_threshold : 0;
        $global     = $pBalance + $sBalance;

        /* ---------- Livre PRINCIPALE : agrégats ---------- */
        $pRow = $this->db->select("
        SUM(CASE WHEN nature = 'encaissement' AND sens = 'entree'
                  AND status = 'validated'
                  AND movement_date BETWEEN '{$monthStart}' AND '{$monthEnd}'
                 THEN amount ELSE 0 END) AS month_entries,
        SUM(CASE WHEN nature = 'approvisionnement' AND sens = 'sortie'
                  AND status = 'validated'
                  AND movement_date BETWEEN '{$monthStart}' AND '{$monthEnd}'
                 THEN amount ELSE 0 END) AS month_approvisionnements,
        SUM(CASE WHEN nature = 'encaissement' AND sens = 'entree'
                  AND status = 'validated'
                  AND movement_date = '{$today}'
                 THEN amount ELSE 0 END) AS today_entries,
        SUM(CASE WHEN status = 'validated'
                  AND movement_date BETWEEN '{$monthStart}' AND '{$monthEnd}'
                 THEN 1 ELSE 0 END) AS month_operations
    ", false)->get('tbl_finance_mouvement_principale')->row();

        /* ---------- Livre SECONDAIRE : agrégats ---------- */
        $sRow = $this->db->select("
        SUM(CASE WHEN nature = 'approvisionnement_recu' AND sens = 'entree'
                  AND status = 'validated'
                  AND movement_date BETWEEN '{$monthStart}' AND '{$monthEnd}'
                 THEN amount ELSE 0 END) AS month_received,
        SUM(CASE WHEN nature = 'paiement_da' AND sens = 'sortie'
                  AND status = 'validated'
                  AND movement_date BETWEEN '{$monthStart}' AND '{$monthEnd}'
                 THEN amount ELSE 0 END) AS month_payments,
        SUM(CASE WHEN nature = 'paiement_da' AND status = 'validated'
                  AND movement_date BETWEEN '{$monthStart}' AND '{$monthEnd}'
                 THEN 1 ELSE 0 END) AS month_paid_count,
        SUM(CASE WHEN nature = 'paiement_da' AND sens = 'sortie'
                  AND status = 'validated'
                  AND movement_date = '{$today}'
                 THEN amount ELSE 0 END) AS today_payments,
        SUM(CASE WHEN nature = 'paiement_da' AND sens = 'sortie'
                  AND status = 'validated'
                  AND movement_date = '{$today}'
                 THEN 1 ELSE 0 END) AS today_payments_count
    ", false)->get('tbl_finance_mouvement_secondaire')->row();

        $pMonthEntries = $pRow ? (float) $pRow->month_entries : 0;
        $pMonthAppro   = $pRow ? (float) $pRow->month_approvisionnements : 0;
        $pTodayEntries = $pRow ? (float) $pRow->today_entries : 0;
        $pMonthOps     = $pRow ? (int) $pRow->month_operations : 0;

        $sMonthReceived   = $sRow ? (float) $sRow->month_received : 0;
        $sMonthPayments   = $sRow ? (float) $sRow->month_payments : 0;
        $sMonthPaidCount  = $sRow ? (int) $sRow->month_paid_count : 0;
        $sTodayPayments   = $sRow ? (float) $sRow->today_payments : 0;
        $sTodayPayCount   = $sRow ? (int) $sRow->today_payments_count : 0;

        /* ---------- Variation du solde global depuis le 1er du mois ----------
       Flux externes uniquement : encaissements (principale) − paiements DA (secondaire).
       Les approvisionnements s'annulent en interne. */
        $netFlow     = $pMonthEntries - $sMonthPayments;
        $startGlobal = $global - $netFlow;
        $globalVariation = $startGlobal > 0 ? ($netFlow / $startGlobal) * 100 : 0;

        /* ---------- Statut du solde secondaire ---------- */
        $secondaryStatus = 'normal';
        if ($sThreshold > 0 && $sBalance <= $sThreshold) {
            $secondaryStatus = 'critique';
        } elseif ($sThreshold > 0 && $sBalance <= ($sThreshold * 2)) {
            $secondaryStatus = 'faible';
        }

        return [
            'global_balance'            => $global,
            'global_variation_percentage' => $globalVariation,
            'principal_balance'         => $pBalance,
            'principal_percentage'      => $global > 0 ? ($pBalance / $global) * 100 : 0,
            'secondary_balance'         => $sBalance,
            'secondary_percentage'      => $global > 0 ? ($sBalance / $global) * 100 : 0,
            'secondary_status'          => $secondaryStatus,
            'secondary_threshold'       => $sThreshold,
            'month_entries'             => $pMonthEntries,
            'month_approvisionnements'  => $pMonthAppro,
            'today_entries'             => $pTodayEntries,
            'month_operations'          => $pMonthOps,
            'month_received'            => $sMonthReceived,
            'month_payments'            => $sMonthPayments,
            'month_paid_count'          => $sMonthPaidCount,
            'today_payments'            => $sTodayPayments,
            'today_payments_count'      => $sTodayPayCount,
        ];
    }

    /**
     * =====================================================
     * ÉVOLUTION DE LA TRÉSORERIE (principale vs secondaire)
     * Encaissements = livre principale (nature encaissement)
     * Décaissements = livre secondaire (nature paiement_da)
     * =====================================================
     */
    public function getCashflowEvolution($period = '7days')
    {
        switch ($period) {
            case '30days':
                $start = date('Y-m-d', strtotime('-29 days'));
                break;
            case 'month':
                $start = date('Y-m-01');
                break;
            default:
                $start = date('Y-m-d', strtotime('-6 days'));
                break;
        }
        $end = date('Y-m-d');

        /* Liste complète des jours (trous = 0) */
        $dates  = [];
        $labels = [];
        $cursor = $start;
        while ($cursor <= $end) {
            $dates[]  = $cursor;
            $labels[] = date('d/m', strtotime($cursor));
            $cursor   = date('Y-m-d', strtotime($cursor . ' +1 day'));
        }

        $incomes   = array_fill(0, count($dates), 0);
        $expenses  = array_fill(0, count($dates), 0);
        $dateIndex = array_flip($dates);

        /* Encaissements — livre PRINCIPALE */
        $rowsIn = $this->db->select('movement_date, SUM(amount) AS total')
            ->where('nature', 'encaissement')
            ->where('sens', 'entree')
            ->where('status', 'validated')
            ->where('movement_date >=', $start)
            ->where('movement_date <=', $end)
            ->group_by('movement_date')
            ->get('tbl_finance_mouvement_principale')->result();

        foreach ($rowsIn as $row) {
            if (isset($dateIndex[$row->movement_date])) {
                $incomes[$dateIndex[$row->movement_date]] = (float) $row->total;
            }
        }

        /* Décaissements — livre SECONDAIRE */
        $rowsOut = $this->db->select('movement_date, SUM(amount) AS total')
            ->where('nature', 'paiement_da')
            ->where('sens', 'sortie')
            ->where('status', 'validated')
            ->where('movement_date >=', $start)
            ->where('movement_date <=', $end)
            ->group_by('movement_date')
            ->get('tbl_finance_mouvement_secondaire')->result();

        foreach ($rowsOut as $row) {
            if (isset($dateIndex[$row->movement_date])) {
                $expenses[$dateIndex[$row->movement_date]] = (float) $row->total;
            }
        }

        return [
            'labels'        => $labels,
            'incomes'       => $incomes,
            'expenses'      => $expenses,
            'total_income'  => array_sum($incomes),
            'total_expense' => array_sum($expenses),
            'net'           => array_sum($incomes) - array_sum($expenses),
        ];
    }

    /**
     * =====================================================
     * ALERTES DE TRÉSORERIE
     * 1) Solde critique / faible de la caisse secondaire
     * 2) Demandes d'achat en attente de paiement
     * =====================================================
     */
    public function getTreasuryAlerts()
    {
        $alerts = [];

        /* --- Solde de la caisse secondaire vs seuil --- */
        $secondary = $this->getSecondaryCashbox();
        if ($secondary) {
            $balance   = (float) $secondary->current_balance;
            $threshold = (float) $secondary->alert_threshold;

            if ($threshold > 0 && $balance <= $threshold) {
                $alerts[] = [
                    'type'    => 'danger',
                    'icon'    => 'fas fa-exclamation-circle',
                    'title'   => 'Solde critique — ' . $secondary->name,
                    'message' => number_format((float) $balance, 0, ',', ' ') . ' BIF ≤ seuil '
                        . number_format((float) $threshold, 0, ',', ' ')
                        . ' — approvisionnement requis depuis la caisse principale.',
                ];
            } elseif ($threshold > 0 && $balance <= ($threshold * 2)) {
                $alerts[] = [
                    'type'    => 'warning',
                    'icon'    => 'fas fa-exclamation-triangle',
                    'title'   => 'Solde faible — ' . $secondary->name,
                    'message' => number_format((float) $balance, 0, ',', ' ')
                        . ' BIF restants — planifiez un approvisionnement.',
                ];
            }
        }

        /* --- DA attachées à un bon, non payées --- */
        $payable = $this->getPayablePurchaseRequests();
        if (!empty($payable)) {
            $total = 0;
            foreach ($payable as $request) {
                $total += (float) $request->amount_paid;
            }
            $count = count($payable);
            $alerts[] = [
                'type'    => 'warning',
                'icon'    => 'fas fa-file-invoice',
                'title'   => $count . ' demande' . ($count > 1 ? 's' : '') . ' d’achat à payer',
                'message' => number_format((float) $total, 0, ',', ' ')
                    . ' BIF à décaisser par la caisse secondaire après approvisionnement.',
            ];
        }

        return ['alerts' => $alerts, 'count' => count($alerts)];
    }

    /**
     * =====================================================
     * MOUVEMENTS RÉCENTS (fusion des 2 livres)
     * Principale : encaissements + approvisionnements
     * Secondaire : paiements DA (l'approvisionnement reçu
     * n'est pas dupliqué : il apparaît en Transfert)
     * =====================================================
     */
    public function getRecentMovements($limit = 6)
    {
        $principal = $this->getPrincipalCashbox();
        $secondary = $this->getSecondaryCashbox();

        $movements = [];

        /* ---------- Livre PRINCIPALE ---------- */
        if ($principal) {
            $rows = $this->db->select('*')
                ->where('nature !=', 'solde_initial')
                ->order_by('movement_date', 'DESC')
                ->order_by('id', 'DESC')
                ->limit($limit)
                ->get('tbl_finance_mouvement_principale')
                ->result();

            foreach ($rows as $row) {
                $isEntry    = ($row->nature === 'encaissement');
                $isTransfer = ($row->nature === 'approvisionnement');

                $secondaryLabel = '';
                if ($isEntry && !empty($row->third_party)) {
                    $secondaryLabel = 'Provenance : ' . $row->third_party;
                } elseif ($isTransfer) {
                    $secondaryLabel = 'Destination : '
                        . ($secondary ? $secondary->code : 'Caisse secondaire');
                }

                $movements[] = [
                    'created_at'      => $row->created_at,
                    'sort_id'         => (int) $row->id,
                    'reference'       => $row->reference,
                    'movement_date'   => $row->movement_date,
                    'cashbox_name'    => $principal->name,
                    'cashbox_code'    => $principal->code,
                    'type'            => $isTransfer ? 'transfert' : 'entree',
                    'label'           => $row->label,
                    'secondary_label' => $secondaryLabel,
                    'category'        => $row->category,
                    'entry_amount'    => $isEntry ? (float) $row->amount : null,
                    'output_amount'   => !$isEntry ? (float) $row->amount : null,
                    'balance_after'   => (float) $row->balance_after,
                    'currency'        => $row->devise,
                    'status'          => $row->status,
                ];
            }
        }

        /* ---------- Livre SECONDAIRE (paiements DA) ---------- */
        if ($secondary) {
            $rows = $this->db->select('*')
                ->where('nature', 'paiement_da')
                ->order_by('movement_date', 'DESC')
                ->order_by('id', 'DESC')
                ->limit($limit)
                ->get('tbl_finance_mouvement_secondaire')
                ->result();

            foreach ($rows as $row) {
                $movements[] = [
                    'created_at'      => $row->created_at,
                    'sort_id'         => (int) $row->id,
                    'reference'       => $row->reference,
                    'movement_date'   => $row->movement_date,
                    'cashbox_name'    => $secondary->name,
                    'cashbox_code'    => $secondary->code,
                    'type'            => 'sortie',
                    'label'           => $row->label,
                    'secondary_label' => !empty($row->third_party)
                        ? 'Bénéficiaire : ' . $row->third_party
                        : '',
                    'category'        => $row->category,
                    'entry_amount'    => null,
                    'output_amount'   => (float) $row->amount,
                    'balance_after'   => (float) $row->balance_after,
                    'currency'        => $row->devise,
                    'status'          => $row->status,
                ];
            }
        }

        /* ---------- Tri fusionné : plus récent d'abord ---------- */
        usort($movements, function ($a, $b) {
            $ta = strtotime(!empty($a['created_at']) ? $a['created_at'] : $a['movement_date']);
            $tb = strtotime(!empty($b['created_at']) ? $b['created_at'] : $b['movement_date']);
            if ($ta !== $tb) {
                return $tb - $ta;
            }
            return $b['sort_id'] - $a['sort_id'];
        });

        return array_slice($movements, 0, $limit);
    }

    /**
     * =====================================================
     * NOMBRE TOTAL DE MOUVEMENTS (2 livres)
     * =====================================================
     */
    public function countAllMovements()
    {
        $this->db->where('nature !=', 'solde_initial');
        $principalCount = $this->db->count_all_results('tbl_finance_mouvement_principale');

        $this->db->where('nature', 'paiement_da');
        $secondaryCount = $this->db->count_all_results('tbl_finance_mouvement_secondaire');

        return $principalCount + $secondaryCount;
    }

    /**
     * =====================================================
     * DÉPENSES DE LA SECONDAIRE PAR CATÉGORIE (mois en cours)
     * =====================================================
     */
    public function getSecondaryExpensesByCategory()
    {
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        $rows = $this->db->select("
        category,
        SUM(amount) AS total_amount,
        COUNT(*)    AS total_operations
    ")
            ->where('nature', 'paiement_da')
            ->where('sens', 'sortie')
            ->where('status', 'validated')
            ->where('movement_date >=', $monthStart)
            ->where('movement_date <=', $monthEnd)
            ->group_by('category')
            ->order_by('total_amount', 'DESC')
            ->get('tbl_finance_mouvement_secondaire')
            ->result();

        /* Pourcentage relatif à la plus grosse catégorie */
        $max = 0;
        foreach ($rows as $row) {
            $max = max($max, (float) $row->total_amount);
        }

        foreach ($rows as $row) {
            $row->total_amount     = (float) $row->total_amount;
            $row->total_operations = (int) $row->total_operations;
            $row->category_name    = !empty($row->category) ? trim($row->category) : 'Autre';
            $row->percentage       = $max > 0 ? ($row->total_amount / $max) * 100 : 0;
        }

        return $rows;
    }

    /**
     * =====================================================
     * CONSOMMATION PAR CHANTIER (DA payées par la secondaire)
     * =====================================================
     */
    public function getSecondaryConsumptionByChantier()
    {
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        $rows = $this->db->select("
        ch.id   AS chantier_id,
        ch.name AS chantier_name,
        prf.destination_chantier,
        SUM(m.amount)                        AS total_consumed,
        COUNT(DISTINCT m.purchase_request_id) AS da_count
    ")
            ->from('tbl_finance_mouvement_secondaire m')
            ->join('purchase_request_forms prf', 'prf.id = m.purchase_request_id', 'inner')
            ->join('chantiers ch', 'ch.id = prf.chantier_id', 'left')
            ->where('m.nature', 'paiement_da')
            ->where('m.sens', 'sortie')
            ->where('m.status', 'validated')
            ->where('m.movement_date >=', $monthStart)
            ->where('m.movement_date <=', $monthEnd)
            ->group_by('ch.id')
            ->order_by('total_consumed', 'DESC')
            ->get()
            ->result();

        /* Pourcentage relatif au chantier le plus consommateur */
        $max = 0;
        foreach ($rows as $row) {
            $max = max($max, (float) $row->total_consumed);
        }

        foreach ($rows as $row) {
            $row->total_consumed = (float) $row->total_consumed;
            $row->da_count       = (int) $row->da_count;
            $row->display_name   = !empty($row->chantier_name)
                ? $row->chantier_name
                : (!empty($row->destination_chantier) ? $row->destination_chantier : 'Non affecté');
            $row->percentage     = $max > 0 ? ($row->total_consumed / $max) * 100 : 0;
        }

        return $rows;
    }

    /** Filtres communs du livre (rôle + période + recherche) */
    protected function applyLivreWhere($role, $dateFrom = null, $dateTo = null, $search = '')
    {
        $table = ($role === 'principale')
            ? 'tbl_finance_mouvement_principale'
            : 'tbl_finance_mouvement_secondaire';

        $this->db->from($table);

        if (!empty($dateFrom)) {
            $this->db->where('movement_date >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $this->db->where('movement_date <=', $dateTo);
        }

        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('reference', $search);
            $this->db->or_like('label', $search);
            $this->db->or_like('third_party', $search);
            $this->db->or_like('category', $search);
            $this->db->or_like('transfer_reference', $search);
            if ($role === 'secondaire') {
                $this->db->or_like('purchase_request_reference', $search);
            }
            $this->db->group_end();
        }

        return $table;
    }

    /** Mouvements paginés du livre */
    public function getLivreMovements($role, $dateFrom = null, $dateTo = null, $search = '', $limit = 15, $offset = 0)
    {
        $this->db->select('*');
        $this->applyLivreWhere($role, $dateFrom, $dateTo, $search);
        $this->db->order_by('movement_date', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    /** Nombre total de mouvements du livre */
    public function countLivreMovements($role, $dateFrom = null, $dateTo = null, $search = '')
    {
        $this->applyLivreWhere($role, $dateFrom, $dateTo, $search);
        return (int) $this->db->count_all_results();
    }

    /** Statistiques du livre sur la période filtrée */
    public function getLivreStatistics($role, $dateFrom = null, $dateTo = null, $search = '')
    {
        $this->db->select("
        SUM(CASE WHEN sens = 'entree'  AND status = 'validated' THEN amount ELSE 0 END) AS total_in,
        SUM(CASE WHEN sens = 'sortie'  AND status = 'validated' THEN amount ELSE 0 END) AS total_out,
        SUM(CASE WHEN sens = 'entree'  AND status = 'validated' THEN 1 ELSE 0 END) AS count_in,
        SUM(CASE WHEN sens = 'sortie'  AND status = 'validated' THEN 1 ELSE 0 END) AS count_out,
        COUNT(*) AS total_count
    ", false);
        $this->applyLivreWhere($role, $dateFrom, $dateTo, $search);

        $row = $this->db->get()->row();

        return [
            'total_in'    => $row ? (float) $row->total_in    : 0,
            'total_out'   => $row ? (float) $row->total_out   : 0,
            'count_in'    => $row ? (int) $row->count_in      : 0,
            'count_out'   => $row ? (int) $row->count_out     : 0,
            'total_count' => $row ? (int) $row->total_count   : 0,
        ];
    }

    /**
     * =====================================================
     * TOUS LES MOUVEMENTS D'UN LIVRE (pour impression)
     * Secondaire : jointure DA + chantier pour la colonne
     * « Catégorie / intitulé du chantier »
     * =====================================================
     */
    public function getAllLivreMovements($role)
    {
        if ($role === 'principale') {
            return $this->db->select('*')
                ->from('tbl_finance_mouvement_principale')
                ->order_by('movement_date', 'ASC')
                ->order_by('id', 'ASC')
                ->get()->result();
        }

        return $this->db->select("
            m.*,
            prf.destination_chantier AS da_destination,
            ch.name AS da_chantier_name,
            prf.requested_by AS da_requested_by,
            pv.summary AS voucher_summary          /* ✅ contenu de la colonne summary */
        ")
            ->from('tbl_finance_mouvement_secondaire m')
            ->join('purchase_request_forms prf', 'prf.id = m.purchase_request_id', 'left')
            ->join('chantiers ch', 'ch.id = prf.chantier_id', 'left')
            /* ✅ Le bon de paiement via la demande d'achat */
            ->join('purchase_payment_vouchers pv', 'pv.request_id = prf.id', 'left')
            ->order_by('m.movement_date', 'ASC')
            ->order_by('m.id', 'ASC')
            ->get()->result();
    }

    /**
     * =====================================================
     * DA DONT LE BON DE PAIEMENT EST DÉJÀ EFFECTUÉ
     * ET QUI N'A PAS ENCORE DE RÉGULARISATION
     * (retour / supplément / exact)
     * =====================================================
     */
    public function getRegularizablePurchaseRequests()
    {
        /* ---------- 1) DA déjà régularisées (non annulées) ---------- */
        $regularized = $this->db->select('purchase_request_id')
            ->from('tbl_finance_regularisations')
            ->where('status !=', 'cancelled')
            ->get()->result();

        $regularizedIds = [];
        foreach ($regularized as $row) {
            $regularizedIds[] = (int) $row->purchase_request_id;
        }

        /* ---------- 2) DA avec bon effectué, non encore régularisées ---------- */
        $this->db->select("
            prf.id,
            prf.request_date,
            prf.created_at,
            prf.chantier_id,
            prf.destination_chantier,
            prf.total_amount,
            ch.name AS chantier_name,
            pv.id AS voucher_id,
            pv.payment_number,
            pv.summary,
            pv.payment_mode,
            pv.amount_paid,
            pv.payment_reference,
            pv.payment_date,
            pv.observation AS payment_observation
        ")
            ->from('purchase_request_forms prf')
            /* Le lien est côté BON : pv.request_id */
            ->join('purchase_payment_vouchers pv', 'pv.request_id = prf.id', 'inner')
            ->join('chantiers ch', 'ch.id = prf.chantier_id', 'left')
            /* Uniquement les bons déjà effectués */
            ->where('pv.payment_status', 'effectue');

        /* ✅ Exclure les DA déjà régularisées */
        if (!empty($regularizedIds)) {
            $this->db->where_not_in('prf.id', $regularizedIds);
        }

        return $this->db->order_by('prf.id', 'DESC')->get()->result();
    }


    /** Prochaine référence : REG-AAAA-XXXX */
    public function generateRegularisationReference()
    {
        $year = date('Y');

        $row = $this->db->select('reference')
            ->like('reference', 'REG-' . $year . '-', 'after')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('tbl_finance_regularisations')
            ->row();

        $next = $row ? ((int) substr($row->reference, -4)) + 1 : 1;

        return 'REG-' . $year . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    /** DA + son bon de paiement (pour contrôle) */
    public function getRequestWithVoucher($id)
    {
        return $this->db->select('prf.id, prf.destination_chantier, ch.name AS chantier_name,
            pv.id AS voucher_id, pv.payment_number, pv.amount_paid, pv.payment_status')
            ->from('purchase_request_forms prf')
            ->join('purchase_payment_vouchers pv', 'pv.request_id = prf.id', 'left')
            ->join('chantiers ch', 'ch.id = prf.chantier_id', 'left')
            ->where('prf.id', (int) $id)
            ->get()->row();
    }

    /**
     * =====================================================
     * ENREGISTRER UNE RÉGULARISATION (retour / supplément / exact)
     * =====================================================
     */
    public function storeRegularisation($data)
    {
        $this->db->trans_start();

        $this->db->insert('tbl_finance_regularisations', [
            'company_id'          => 2,
            'reference'           => $this->generateRegularisationReference(),
            'purchase_request_id' => $data['purchase_request_id'],
            'payment_voucher_id'  => $data['payment_voucher_id'],
            'regularisation_type' => $data['regularisation_type'],
            'amount'              => $data['amount'],
            'regularisation_date' => $data['regularisation_date'],
            'concerned'           => $data['concerned'],
            'receipt_number'      => $data['receipt_number'],
            'justification'       => $data['justification'],
            'observation'         => $data['observation'],
            'status'              => 'validated',
            'created_by'          => $data['created_by'],
        ]);
        $insertId = $this->db->insert_id();

        /* ---------- OPTIONNEL : répercuter dans le livre secondaire ---------- */
        if (
            in_array($data['regularisation_type'], ['retour', 'supplement'], true)
            && (float) $data['amount'] > 0
            && !empty($data['secondary_cashbox'])
        ) {
            $cashbox  = $data['secondary_cashbox'];
            $isRetour = ($data['regularisation_type'] === 'retour');
            $before   = (float) $cashbox->current_balance;
            $after    = $isRetour ? $before + $data['amount'] : $before - $data['amount'];

            $this->db->insert('tbl_finance_mouvement_secondaire', [
                'reference'      => $this->nextMovementReference('tbl_finance_mouvement_secondaire', 'MVS'),
                'sens'           => $isRetour ? 'entree' : 'sortie',
                'nature'         => $isRetour ? 'retour_caisse' : 'supplement',
                'movement_date'  => $data['regularisation_date'],
                'amount'         => $data['amount'],
                'balance_before' => $before,
                'balance_after'  => $after,
                'devise'         => $cashbox->devise,
                'purchase_request_id'        => $data['purchase_request_id'],
                'purchase_request_reference' => $data['purchase_request_reference'],
                'third_party'    => $data['concerned'],
                'category'       => $isRetour ? 'Retour à la caisse' : 'Supplément',
                'payment_method' => 'cash',
                'label'          => $isRetour
                    ? 'Retour à la caisse — ' . $data['justification']
                    : 'Supplément payé — ' . $data['justification'],
                'observation'    => $data['observation'],
                'status'         => 'validated',
                'created_by'     => $data['created_by'],
            ]);

            $this->db->where('id', $cashbox->id)
                ->update('tbl_finance_cashbox', ['current_balance' => $after]);
        }
        /* ---------------------------------------------------------------------- */

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return ['success' => false, 'message' => 'Erreur pendant l’enregistrement de la régularisation.'];
        }

        return ['success' => true, 'id' => $insertId];
    }

    /**
     * =====================================================
     * STATISTIQUES GLOBALES DU RAPPORT FINANCIER
     * =====================================================
     */
    public function getFinancialReportStatistics()
    {
        /* Total payé (bons effectués) */
        $paid = $this->db->select("SUM(amount_paid) AS total, COUNT(*) AS cnt")
            ->where('payment_status', 'effectue')
            ->get('purchase_payment_vouchers')->row();

        /* Retours à la caisse */
        $retours = $this->db->select("SUM(amount) AS total, COUNT(*) AS cnt")
            ->where('regularisation_type', 'retour')
            ->where('status', 'validated')
            ->get('tbl_finance_regularisations')->row();

        /* Suppléments payés */
        $supplements = $this->db->select("SUM(amount) AS total, COUNT(*) AS cnt")
            ->where('regularisation_type', 'supplement')
            ->where('status', 'validated')
            ->get('tbl_finance_regularisations')->row();

        $totalPaid      = $paid ? (float) $paid->total : 0;
        $totalRetours   = $retours ? (float) $retours->total : 0;
        $totalSupplem   = $supplements ? (float) $supplements->total : 0;

        return [
            'total_paid'        => $totalPaid,
            'paid_count'        => $paid ? (int) $paid->cnt : 0,
            'total_retours'     => $totalRetours,
            'retours_count'     => $retours ? (int) $retours->cnt : 0,
            'total_supplements' => $totalSupplem,
            'supplements_count' => $supplements ? (int) $supplements->cnt : 0,
            'adjusted'          => $totalPaid - $totalRetours + $totalSupplem,
        ];
    }

    /**
     * =====================================================
     * LIGNES DU RAPPROCHEMENT (bon payé vs dépense réelle)
     * =====================================================
     */
    public function getFinancialReportRows($filters = [])
    {
        $this->db->select("
        prf.id,
        prf.request_date,
        prf.created_at,
        prf.destination_chantier,
        prf.requested_by,
        prf.buyer_name,
        ch.name AS chantier_name,
        pv.id AS voucher_id,
        pv.payment_number,
        pv.summary,
        pv.amount_paid,
        pv.payment_date,
        (SELECT COALESCE(SUM(r.amount),0) FROM tbl_finance_regularisations r
          WHERE r.purchase_request_id = prf.id
            AND r.regularisation_type = 'retour'
            AND r.status = 'validated') AS total_retour,
        (SELECT COALESCE(SUM(r.amount),0) FROM tbl_finance_regularisations r
          WHERE r.purchase_request_id = prf.id
            AND r.regularisation_type = 'supplement'
            AND r.status = 'validated') AS total_supplement,
        (SELECT r2.regularisation_type FROM tbl_finance_regularisations r2
          WHERE r2.purchase_request_id = prf.id AND r2.status = 'validated'
          ORDER BY r2.id DESC LIMIT 1) AS last_type
    ")
            ->from('purchase_request_forms prf')
            ->join('purchase_payment_vouchers pv', 'pv.request_id = prf.id', 'inner')
            ->join('chantiers ch', 'ch.id = prf.chantier_id', 'left')
            ->where('pv.payment_status', 'effectue');

        /* Période (date du bon) */
        if (!empty($filters['date_from'])) {
            $this->db->where('pv.payment_date >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('pv.payment_date <=', $filters['date_to']);
        }

        /* Recherche */
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start();
            $this->db->like('pv.payment_number', $s);
            $this->db->or_like('pv.summary', $s);
            $this->db->or_like('ch.name', $s);
            $this->db->or_like('prf.destination_chantier', $s);
            $this->db->or_like('prf.buyer_name', $s);
            $this->db->or_like('prf.requested_by', $s);
            $this->db->group_end();
        }

        $rows = $this->db->order_by('pv.payment_date', 'DESC')
            ->order_by('prf.id', 'DESC')
            ->get()->result();

        /* Calculs : dépense réelle, écart, situation */
        foreach ($rows as $row) {
            $row->amount_paid      = (float) $row->amount_paid;
            $row->total_retour     = (float) $row->total_retour;
            $row->total_supplement = (float) $row->total_supplement;
            $row->real_expense     = $row->amount_paid - $row->total_retour + $row->total_supplement;
            $row->ecart            = $row->total_retour - $row->total_supplement;

            if ($row->last_type === 'exact') {
                $row->situation = 'soldee';
            } elseif ($row->total_retour > 0) {
                $row->situation = 'retour';
            } elseif ($row->total_supplement > 0) {
                $row->situation = 'supplement';
            } else {
                $row->situation = 'attente';
            }
        }

        /* Filtre situation */
        if (!empty($filters['situation'])) {
            $rows = array_values(array_filter($rows, function ($r) use ($filters) {
                return $r->situation === $filters['situation'];
            }));
        }

        return $rows;
    }

    /**
     * =====================================================
     * DERNIÈRES RÉGULARISATIONS (historique)
     * =====================================================
     */
    public function getRecentRegularisations($limit = 6)
    {
        return $this->db->select("
        r.*,
        pv.payment_number,
        prf.destination_chantier,
        ch.name AS chantier_name
    ")
            ->from('tbl_finance_regularisations r')
            ->join('purchase_request_forms prf', 'prf.id = r.purchase_request_id', 'left')
            ->join('purchase_payment_vouchers pv', 'pv.id = r.payment_voucher_id', 'left')
            ->join('chantiers ch', 'ch.id = prf.chantier_id', 'left')
            ->where('r.status', 'validated')
            ->order_by('r.id', 'DESC')
            ->limit($limit)
            ->get()->result();
    }
}