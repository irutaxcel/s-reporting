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
     * ============================================================
     * DÉPENSES DE LA SECONDAIRE PAR CATÉGORIE (période filtrable)
     * ============================================================
     * @param string|null $startDate 'Y-m-d H:i:s' (défaut : 1er du mois en cours 00:00:00)
     * @param string|null $endDate   'Y-m-d H:i:s' (défaut : aujourd'hui 23:59:59)
     */
    public function getSecondaryExpensesByCategory($startDate = null, $endDate = null)
    {
        list($startDate, $endDate) = $this->_normalizePeriodRange($startDate, $endDate);

        $rows = $this->db->select("
                category,
                SUM(amount) AS total_amount,
                COUNT(*)    AS total_operations
            ")
            ->where('nature', 'paiement_da')
            ->where('sens', 'sortie')
            ->where('status', 'validated')
            ->where('movement_date >=', $startDate)
            ->where('movement_date <=', $endDate)
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
     * ============================================================
     * CONSOMMATION PAR CHANTIER (DA payées par la secondaire, période filtrable)
     * ============================================================
     * @param string|null $startDate 'Y-m-d H:i:s' (défaut : 1er du mois en cours 00:00:00)
     * @param string|null $endDate   'Y-m-d H:i:s' (défaut : aujourd'hui 23:59:59)
     */
    public function getSecondaryConsumptionByChantier($startDate = null, $endDate = null)
    {
        list($startDate, $endDate) = $this->_normalizePeriodRange($startDate, $endDate);

        $rows = $this->db->select("
                ch.id   AS chantier_id,
                ch.name AS chantier_name,
                prf.destination_chantier,
                SUM(m.amount)                       AS total_consumed,
                COUNT(DISTINCT m.purchase_request_id) AS da_count
            ")
            ->from('tbl_finance_mouvement_secondaire m')
            ->join('purchase_request_forms prf', 'prf.id = m.purchase_request_id', 'inner')
            ->join('chantiers ch', 'ch.id = prf.chantier_id', 'left')
            ->where('m.nature', 'paiement_da')
            ->where('m.sens', 'sortie')
            ->where('m.status', 'validated')
            ->where('m.movement_date >=', $startDate)
            ->where('m.movement_date <=', $endDate)
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

    /**
     * Valide et normalise une plage de dates.
     * - Valeurs absentes ou invalides => mois en cours (1er 00:00:00 → aujourd'hui 23:59:59)
     * - Une date seule 'Y-m-d' est étendue à 00:00:00 / 23:59:59
     * - Si start > end, les bornes sont inversées
     */
    private function _normalizePeriodRange($startDate, $endDate)
    {
        $parse = function ($value, $endOfDay) {
            if (empty($value)) {
                return null;
            }
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $value .= $endOfDay ? ' 23:59:59' : ' 00:00:00';
            }
            $dt = DateTime::createFromFormat('Y-m-d H:i:s', $value);
            return $dt ? $dt->format('Y-m-d H:i:s') : null;
        };

        $start = $parse($startDate, false) ?: date('Y-m-01 00:00:00');
        $end   = $parse($endDate, true)    ?: date('Y-m-d 23:59:59');

        if ($start > $end) {
            list($start, $end) = [$end, $start];
        }

        return [$start, $end];
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

    // /** Mouvements paginés du livre */
    // public function getLivreMovements($role, $dateFrom = null, $dateTo = null, $search = '', $limit = 15, $offset = 0)
    // {
    //     $this->db->select('*');
    //     $this->applyLivreWhere($role, $dateFrom, $dateTo, $search);
    //     $this->db->order_by('movement_date', 'DESC');
    //     $this->db->order_by('id', 'DESC');
    //     $this->db->limit($limit, $offset);

    //     return $this->db->get()->result();
    // }

    /**
     * =====================================================
     * MOUVEMENTS PAGINÉS DU LIVRE (ordre chronologique ASC)
     * =====================================================
     */
    public function getLivreMovements($role, $dateFrom = null, $dateTo = null, $search = '', $limit = 15, $offset = 0)
    {
        $this->db->select('*');
        $this->applyLivreWhere($role, $dateFrom, $dateTo, $search);

        /* ✅ Ordre croissant : du plus ancien au plus récent */
        $this->db->order_by('movement_date', 'ASC');
        $this->db->order_by('id', 'ASC');

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
     * TOUS LES CHANTIERS (pour les filtres)
     * =====================================================
     */
    public function getAllChantiers()
    {
        return $this->db->select('id, name, ref_chantier')
            ->from('chantiers')
            ->order_by('name', 'ASC')
            ->get()->result();
    }

    /**
     * =====================================================
     * STATISTIQUES GLOBALES DU RAPPORT FINANCIER
     * =====================================================
     */
    // public function getFinancialReportStatistics()
    // {
    //     /* Total payé (bons effectués) */
    //     $paid = $this->db->select("SUM(amount_paid) AS total, COUNT(*) AS cnt")
    //         ->where('payment_status', 'effectue')
    //         ->get('purchase_payment_vouchers')->row();

    //     /* Retours à la caisse */
    //     $retours = $this->db->select("SUM(amount) AS total, COUNT(*) AS cnt")
    //         ->where('regularisation_type', 'retour')
    //         ->where('status', 'validated')
    //         ->get('tbl_finance_regularisations')->row();

    //     /* Suppléments payés */
    //     $supplements = $this->db->select("SUM(amount) AS total, COUNT(*) AS cnt")
    //         ->where('regularisation_type', 'supplement')
    //         ->where('status', 'validated')
    //         ->get('tbl_finance_regularisations')->row();

    //     $totalPaid      = $paid ? (float) $paid->total : 0;
    //     $totalRetours   = $retours ? (float) $retours->total : 0;
    //     $totalSupplem   = $supplements ? (float) $supplements->total : 0;

    //     return [
    //         'total_paid'        => $totalPaid,
    //         'paid_count'        => $paid ? (int) $paid->cnt : 0,
    //         'total_retours'     => $totalRetours,
    //         'retours_count'     => $retours ? (int) $retours->cnt : 0,
    //         'total_supplements' => $totalSupplem,
    //         'supplements_count' => $supplements ? (int) $supplements->cnt : 0,
    //         'adjusted'          => $totalPaid - $totalRetours + $totalSupplem,
    //     ];
    // }

    public function getFinancialReportStatistics($filters = [])
    {
        $chantierId = !empty($filters['chantier_id']) ? (int) $filters['chantier_id'] : 0;

        /* Total payé (bons effectués) */
        $this->db->select("SUM(pv.amount_paid) AS total, COUNT(*) AS cnt")
            ->from('purchase_payment_vouchers pv')
            ->join('purchase_request_forms prf', 'prf.id = pv.request_id', 'left')
            ->where('pv.payment_status', 'effectue');
        if ($chantierId > 0) {
            $this->db->where('prf.chantier_id', $chantierId);
        }
        $paid = $this->db->get()->row();

        /* Retours à la caisse */
        $this->db->select("SUM(r.amount) AS total, COUNT(*) AS cnt")
            ->from('tbl_finance_regularisations r')
            ->join('purchase_request_forms prf', 'prf.id = r.purchase_request_id', 'left')
            ->where('r.regularisation_type', 'retour')
            ->where('r.status', 'validated');
        if ($chantierId > 0) {
            $this->db->where('prf.chantier_id', $chantierId);
        }
        $retours = $this->db->get()->row();

        /* Suppléments payés */
        $this->db->select("SUM(r.amount) AS total, COUNT(*) AS cnt")
            ->from('tbl_finance_regularisations r')
            ->join('purchase_request_forms prf', 'prf.id = r.purchase_request_id', 'left')
            ->where('r.regularisation_type', 'supplement')
            ->where('r.status', 'validated');
        if ($chantierId > 0) {
            $this->db->where('prf.chantier_id', $chantierId);
        }
        $supplements = $this->db->get()->row();

        $totalPaid    = $paid ? (float) $paid->total : 0;
        $totalRetours = $retours ? (float) $retours->total : 0;
        $totalSupplem = $supplements ? (float) $supplements->total : 0;

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
     * ✅ Filtres : chantier, période, recherche, situation
     * =====================================================
     */
    public function getFinancialReportRows($filters = [])
    {
        /* ---------- ✅ Récupérer le nom du chantier AVANT la requête principale ----------
       (un select->get() pendant la construction fusionnerait les 2 requêtes !) */
        $chantierName = null;
        if (!empty($filters['chantier_id'])) {
            $chantierRow = $this->db->select('name')
                ->from('chantiers')
                ->where('id', (int) $filters['chantier_id'])
                ->get()->row();
            $chantierName = $chantierRow ? $chantierRow->name : null;
        }

        /* ---------- Requête principale ---------- */
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

        /* ---------- ✅ Filtre par chantier ---------- */
        if (!empty($filters['chantier_id'])) {
            $this->db->group_start();
            $this->db->where('prf.chantier_id', (int) $filters['chantier_id']);
            if ($chantierName !== null) {
                $this->db->or_where('prf.destination_chantier', $chantierName);
            }
            $this->db->group_end();
        }

        /* ---------- Période (date du bon) ---------- */
        if (!empty($filters['date_from'])) {
            $this->db->where('pv.payment_date >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('pv.payment_date <=', $filters['date_to']);
        }

        /* ---------- Recherche ---------- */
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

        /* ---------- Calculs : dépense réelle, écart, situation ---------- */
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

        /* ---------- Filtre situation (en PHP) ---------- */
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

        // ======================================================================
    //  JOURNAL DE CAISSE
    //  Sources : tbl_finance_mouvement_principale (MVP-...)
    //            tbl_finance_mouvement_secondaire (MVS-...)
    //  Caisse  : tbl_finance_cashbox (liée par role = principale/secondaire)
    //  DA      : purchase_request_forms -> chantiers ; users (créé/validé par)
    // ======================================================================

    /** Sous-requête qui unifie les deux tables de mouvements. */
    private function _jcSource()
    {
        return "(
            SELECT CONCAT('P', p.id) AS uid, p.id, 'principale' AS source,
                   p.reference, p.sens, p.nature, p.movement_date, p.created_at,
                   p.amount, p.balance_before, p.balance_after, p.devise, p.transfer_reference,
                   p.label, p.third_party, p.category, p.payment_method, p.document_number,
                   p.observation, p.status, NULL AS purchase_request_id,
                   NULL AS purchase_request_reference, p.created_by, p.validated_by
            FROM tbl_finance_mouvement_principale p
            UNION ALL
            SELECT CONCAT('S', s.id), s.id, 'secondaire',
                   s.reference, s.sens, s.nature, s.movement_date, s.created_at,
                   s.amount, s.balance_before, s.balance_after, s.devise, s.transfer_reference,
                   s.label, s.third_party, s.category, s.payment_method, s.document_number,
                   s.observation, s.status, s.purchase_request_id,
                   s.purchase_request_reference, s.created_by, s.validated_by
            FROM tbl_finance_mouvement_secondaire s
        ) m
        JOIN tbl_finance_cashbox ca         ON ca.role = m.source
        LEFT JOIN purchase_request_forms pr ON pr.id = m.purchase_request_id
        LEFT JOIN chantiers ch              ON ch.id = pr.chantier_id
        LEFT JOIN users uc                  ON uc.id = m.created_by
        LEFT JOIN users uv                  ON uv.id = m.validated_by";
    }

    /** Clause WHERE + paramètres liés à partir des filtres. */
    private function _jcWhere(array $f, array &$binds)
    {
        $w = [];
        if (!empty($f['caisse_id'])) {
            $w[] = 'ca.id = ?';
            $binds[] = (int) $f['caisse_id'];
        }
        if (!empty($f['chantier_id'])) {
            $w[] = 'ch.id = ?';
            $binds[] = (int) $f['chantier_id'];
        }
        if (!empty($f['type'])) {
            $w[] = 'm.sens = ?';
            $binds[] = $f['type'];
        }
        if (!empty($f['statut'])) {
            $w[] = 'm.status = ?';
            $binds[] = $f['statut'];
        }
        if (!empty($f['date_debut'])) {
            $w[] = 'm.movement_date >= ?';
            $binds[] = $f['date_debut'];
        }
        if (!empty($f['date_fin'])) {
            $w[] = 'm.movement_date <= ?';
            $binds[] = $f['date_fin'];
        }
        if (!empty($f['q'])) {
            $like = '%' . trim($f['q']) . '%';
            $w[] = '(m.reference LIKE ? OR m.label LIKE ? OR m.third_party LIKE ?
                     OR m.purchase_request_reference LIKE ? OR ch.name LIKE ?)';
            array_push($binds, $like, $like, $like, $like, $like);
        }
        return $w ? ' WHERE ' . implode(' AND ', $w) : '';
    }

    /** Colonnes renvoyées à la vue. */
    private function _jcSelect()
    {
        return "SELECT
            m.uid, m.id, m.source, m.reference, m.sens AS type, m.nature, m.category,
            (m.sens = 'entree') AS is_entree,
            CONCAT(m.movement_date, ' ', TIME(m.created_at)) AS date_operation,
            m.amount AS montant, m.balance_before AS solde_avant, m.balance_after AS solde_apres,
            m.devise, m.transfer_reference, m.payment_method, m.document_number,
            m.label AS libelle, m.third_party AS beneficiaire, m.observation,
            CASE m.status WHEN 'validated' THEN 'valide'
                          WHEN 'pending'   THEN 'en_attente'
                          WHEN 'cancelled' THEN 'annule' ELSE m.status END AS statut,
            ca.id AS caisse_id, ca.name AS caisse_nom, ca.code AS caisse_code,
            m.purchase_request_reference AS da_reference,
            ch.name AS chantier_nom,
            CONCAT_WS(' ', uc.first_name, uc.last_name) AS cree_par,
            CONCAT_WS(' ', uv.first_name, uv.last_name) AS valide_par";
    }

    /** Liste paginée (plus récentes d'abord). $limit = null => tout (export). */
    public function getJournalCaisse(array $filters = [], $limit = 25, $offset = 0)
    {
        $binds = [];
        $sql = $this->_jcSelect() . ' FROM ' . $this->_jcSource()
            . $this->_jcWhere($filters, $binds)
            . ' ORDER BY m.movement_date DESC, m.created_at DESC, m.id DESC';

        if ($limit !== null) {
            $sql .= ' LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset;
        }
        return $this->db->query($sql, $binds)->result();
    }

    public function countJournalCaisse(array $filters = [])
    {
        $binds = [];
        $sql = 'SELECT COUNT(*) AS nb FROM ' . $this->_jcSource() . $this->_jcWhere($filters, $binds);
        return (int) $this->db->query($sql, $binds)->row()->nb;
    }

    public function getJournalCaisseTotaux(array $filters = [])
    {
        $binds = [];
        $sql = "SELECT COUNT(*) AS nb_operations,
                       COALESCE(SUM(CASE WHEN m.sens = 'entree' THEN m.amount ELSE 0 END), 0) AS total_entrees,
                       COALESCE(SUM(CASE WHEN m.sens = 'sortie' THEN m.amount ELSE 0 END), 0) AS total_sorties
                FROM " . $this->_jcSource() . $this->_jcWhere($filters, $binds);
        $row = $this->db->query($sql, $binds)->row();
        $row->solde_net = $row->total_entrees - $row->total_sorties;
        return $row;
    }

    /** Détail : $uid = 'P12' (principale) ou 'S309' (secondaire). */
    public function getJournalCaisseById($uid)
    {
        if (!preg_match('/^[PS]\d+$/', (string) $uid)) {
            return null;
        }
        $sql = $this->_jcSelect() . ' FROM ' . $this->_jcSource() . ' WHERE m.uid = ?';
        return $this->db->query($sql, [$uid])->row();
    }

    public function getCaissesForFilter()
    {
        return $this->db->query(
            "SELECT id, name AS nom, code FROM tbl_finance_cashbox ORDER BY role = 'secondaire', name"
        )->result();
    }

    public function getChantiersForFilter()
    {
        return $this->db->query('SELECT id, name AS nom FROM chantiers ORDER BY name')->result();
    }

        /* =====================================================================
     * =====================================================================
     *  MODULE BANQUE V2
     *  Tables : tbl_finance_bank, tbl_finance_bank_account,
     *           tbl_finance_bank_operation, tbl_finance_bank_movement
     *  Lien caisse : tbl_finance_cashbox + tbl_finance_mouvement_principale
     * =====================================================================
     * ===================================================================== */

    /**
     * Règles par type d'opération :
     * - source      : un compte bancaire est débité ;
     * - destination : un compte bancaire est crédité ;
     * - cashbox     : la caisse principale est impliquée.
     */
    private $bankOperationRules = [
        'encaissement'        => ['source' => false, 'destination' => true,  'cashbox' => false],
        'decaissement'        => ['source' => true,  'destination' => false, 'cashbox' => false],
        'transfert'           => ['source' => true,  'destination' => true,  'cashbox' => false],
        'retrait_banque'      => ['source' => true,  'destination' => false, 'cashbox' => true],
        'versement_banque'    => ['source' => false, 'destination' => true,  'cashbox' => true],
        'frais_bancaires'     => ['source' => true,  'destination' => false, 'cashbox' => false],
        'interets_crediteurs' => ['source' => false, 'destination' => true,  'cashbox' => false],
    ];

    /* ---------------------------------------------------------------------
     * OUTILS INTERNES
     * ------------------------------------------------------------------- */

    /** Chaîne vide → NULL, sinon valeur nettoyée. */
    private function bankNullable($value)
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        return ($value === '' || $value === null) ? null : $value;
    }

    /**
     * Prochaine référence séquentielle annuelle : PREFIXE-AAAA-00001.
     * $lock = true : à appeler DANS une transaction (verrou FOR UPDATE).
     */
    private function bankNextReference(
        string $table,
        string $prefix,
        int $padding = 5,
        string $column = 'reference',
        bool $lock = false
    ): string {
        $base = $prefix . '-' . date('Y') . '-';

        $sql = "SELECT {$column} AS ref
                FROM {$table}
                WHERE {$column} LIKE ?
                ORDER BY id DESC
                LIMIT 1" . ($lock ? ' FOR UPDATE' : '');

        $row = $this->db->query($sql, [$base . '%'])->row();

        $next = $row ? ((int) substr($row->ref, strlen($base))) + 1 : 1;

        return $base . str_pad((string) $next, $padding, '0', STR_PAD_LEFT);
    }

    /** Verrouille un compte bancaire (à appeler dans une transaction). */
    private function getBankAccountForUpdate(int $accountId)
    {
        return $this->db
            ->query(
                'SELECT * FROM tbl_finance_bank_account WHERE id = ? LIMIT 1 FOR UPDATE',
                [$accountId]
            )
            ->row();
    }

    /** Contrôles communs : existence, statut, période verrouillée, ouverture. */
    private function assertBankAccountUsable($account, string $role, string $operationDate): void
    {
        if (!$account) {
            throw new RuntimeException("Le compte {$role} est introuvable.");
        }

        if ($account->status !== 'active') {
            throw new RuntimeException("Le compte {$account->name} n’est pas actif.");
        }

        if ($operationDate < $account->opening_date) {
            throw new RuntimeException(
                "La date de l’opération est antérieure à l’ouverture du compte {$account->name} ("
                    . date('d/m/Y', strtotime($account->opening_date)) . ').'
            );
        }

        if (
            !empty($account->last_reconciled_date)
            && $operationDate <= $account->last_reconciled_date
        ) {
            throw new RuntimeException(
                "La période jusqu’au " . date('d/m/Y', strtotime($account->last_reconciled_date))
                    . " est rapprochée et verrouillée pour le compte {$account->name}."
            );
        }
    }

    /** Vérifie que le compte peut supporter une sortie (solde + découvert autorisé). */
    private function assertBankFundsAvailable($account, float $amount): void
    {
        $available = (float) $account->current_balance + (float) $account->overdraft_limit;

        if ($amount > $available + 0.001) {
            throw new RuntimeException(
                'Solde insuffisant sur ' . $account->name . ' : disponible '
                    . number_format($available, 2, ',', ' ') . ' ' . $account->currency . '.'
            );
        }
    }

    /**
     * Écrit une ligne dans le livre de banque et met à jour le solde du compte.
     * L'objet $account est mis à jour en mémoire (current_balance).
     */
    private function insertBankMovement($account, string $sens, string $nature, float $amount, array $extra): float
    {
        $before = round((float) $account->current_balance, 2);
        $after  = round($sens === 'entree' ? $before + $amount : $before - $amount, 2);

        $inserted = $this->db->insert('tbl_finance_bank_movement', [
            'reference'          => $this->bankNextReference('tbl_finance_bank_movement', 'MVB', 5, 'reference', true),
            'bank_account_id'    => (int) $account->id,
            'bank_operation_id'  => $extra['bank_operation_id'] ?? null,
            'sens'               => $sens,
            'nature'             => $nature,
            'movement_date'      => $extra['movement_date'],
            'value_date'         => $extra['value_date'] ?? null,
            'amount'             => $amount,
            'balance_before'     => $before,
            'balance_after'      => $after,
            'currency'           => $account->currency,
            'label'              => $extra['label'],
            'third_party'        => $extra['third_party'] ?? null,
            'document_number'    => $extra['document_number'] ?? null,
            'transfer_reference' => $extra['transfer_reference'] ?? null,
            'status'             => 'validated',
            'created_by'         => $extra['created_by'] ?? null,
        ]);

        if (!$inserted) {
            throw new RuntimeException('Impossible d’écrire la ligne du livre de banque.');
        }

        $this->db
            ->where('id', (int) $account->id)
            ->update('tbl_finance_bank_account', ['current_balance' => $after]);

        $account->current_balance = $after;

        return $after;
    }

    /**
     * Écrit le mouvement correspondant dans le livre de la caisse principale.
     * retrait_banque   : la caisse reçoit (entrée) ;
     * versement_banque : la caisse donne  (sortie).
     * $isReversal = true : écriture inverse (annulation).
     */
    private function insertCashMovementFromBank($cashbox, $operation, ?int $userId, bool $isReversal = false): string
    {
        $sens = $operation->operation_type === 'retrait_banque' ? 'entree' : 'sortie';

        if ($isReversal) {
            $sens = $sens === 'entree' ? 'sortie' : 'entree';
        }

        $amount = (float) $operation->amount;
        $before = round((float) $cashbox->current_balance, 2);
        $after  = round($sens === 'entree' ? $before + $amount : $before - $amount, 2);

        if ($after < 0) {
            throw new RuntimeException('Le solde de la caisse principale deviendrait négatif.');
        }

        $baseLabel = $operation->operation_type === 'retrait_banque'
            ? 'Retrait bancaire ' . $operation->reference
            : 'Versement en banque ' . $operation->reference;

        $reference = $this->nextMovementReference('tbl_finance_mouvement_principale', 'MVP');

        $inserted = $this->db->insert('tbl_finance_mouvement_principale', [
            'reference'          => $reference,
            'sens'               => $sens,
            'nature'             => $isReversal ? 'contre_passation' : $operation->operation_type,
            'movement_date'      => $isReversal ? date('Y-m-d') : $operation->operation_date,
            'amount'             => $amount,
            'balance_before'     => $before,
            'balance_after'      => $after,
            'devise'             => $cashbox->devise,
            'transfer_reference' => $operation->reference,
            'third_party'        => $operation->third_party,
            'category'           => 'Banque',
            'payment_method'     => 'cash',
            'document_number'    => $operation->document_number,
            'label'              => ($isReversal ? 'Annulation — ' : '') . $baseLabel,
            'observation'        => $operation->observation,
            'status'             => 'validated',
            'created_by'         => $userId,
        ]);

        if (!$inserted) {
            throw new RuntimeException('Impossible d’écrire le mouvement dans le livre de la caisse principale.');
        }

        $this->db
            ->where('id', (int) $cashbox->id)
            ->update('tbl_finance_cashbox', ['current_balance' => $after]);

        $cashbox->current_balance = $after;

        return $reference;
    }

    /* ---------------------------------------------------------------------
     * RÉFÉRENTIEL DES BANQUES
     * ------------------------------------------------------------------- */

    public function getActiveBanks(): array
    {
        return $this->db
            ->select('id, code, name, swift_code')
            ->where('status', 'active')
            ->order_by('name', 'ASC')
            ->get('tbl_finance_bank')
            ->result();
    }

    /* ---------------------------------------------------------------------
     * COMPTES BANCAIRES
     * ------------------------------------------------------------------- */

    /** Aperçu du prochain code (affichage dans la modale, sans verrou). */
    public function getNextBankAccountCode(): string
    {
        return $this->bankNextReference('tbl_finance_bank_account', 'BAN', 3, 'code', false);
    }

    public function bankAccountNumberExists(int $bankId, string $accountNumber, int $excludeId = 0): bool
    {
        $this->db
            ->where('bank_id', $bankId)
            ->where('account_number', $accountNumber);

        if ($excludeId > 0) {
            $this->db->where('id !=', $excludeId);
        }

        return $this->db->count_all_results('tbl_finance_bank_account') > 0;
    }

    /**
     * Crée un compte bancaire.
     * Si le solde initial > 0, la première ligne du livre est « solde_initial ».
     */
    public function createBankAccount(array $data): array
    {
        $openingBalance = round((float) ($data['opening_balance'] ?? 0), 2);
        $userId         = !empty($data['created_by']) ? (int) $data['created_by'] : null;

        $this->db->trans_begin();

        try {
            $bank = $this->db
                ->where('id', (int) $data['bank_id'])
                ->where('status', 'active')
                ->get('tbl_finance_bank')
                ->row();

            if (!$bank) {
                throw new RuntimeException('La banque sélectionnée est introuvable ou inactive.');
            }

            if ($this->bankAccountNumberExists((int) $data['bank_id'], $data['account_number'])) {
                throw new RuntimeException('Ce numéro de compte existe déjà pour ' . $bank->name . '.');
            }

            $code = $this->bankNextReference('tbl_finance_bank_account', 'BAN', 3, 'code', true);

            $this->db->insert('tbl_finance_bank_account', [
                'code'                  => $code,
                'bank_id'               => (int) $data['bank_id'],
                'name'                  => $data['name'],
                'account_number'        => $data['account_number'],
                'account_type'          => $data['account_type'],
                'currency'              => $data['currency'],
                'branch_name'           => $this->bankNullable($data['branch_name'] ?? null),
                'accounting_account_id' => !empty($data['accounting_account_id']) ? (int) $data['accounting_account_id'] : null,
                'opening_date'          => $data['opening_date'],
                'opening_balance'       => $openingBalance,
                'current_balance'       => 0,
                'overdraft_limit'       => round((float) ($data['overdraft_limit'] ?? 0), 2),
                'alert_threshold'       => round((float) ($data['alert_threshold'] ?? 0), 2),
                'observation'           => $this->bankNullable($data['observation'] ?? null),
                'status'                => 'active',
                'created_by'            => $userId,
            ]);

            $accountId = (int) $this->db->insert_id();

            if ($accountId <= 0) {
                throw new RuntimeException('Le compte bancaire n’a pas pu être enregistré.');
            }

            if ($openingBalance > 0) {
                $account = $this->getBankAccountForUpdate($accountId);

                $this->insertBankMovement($account, 'entree', 'solde_initial', $openingBalance, [
                    'movement_date' => $data['opening_date'],
                    'label'         => 'Solde initial à l’ouverture du compte',
                    'created_by'    => $userId,
                ]);
            }

            if ($this->db->trans_status() === false) {
                throw new RuntimeException('Erreur de base de données pendant la création du compte.');
            }

            /* Point de départ convenu avec la banque : considéré comme rapproché */
            $this->db
                ->where('bank_account_id', $accountId)
                ->where('nature', 'solde_initial')
                ->update('tbl_finance_bank_movement', [
                    'is_reconciled' => 1,
                    'reconciled_at' => date('Y-m-d H:i:s'),
                ]);

            $this->db->trans_commit();

            return [
                'status'  => true,
                'id'      => $accountId,
                'code'    => $code,
                'message' => 'Le compte ' . $code . ' — ' . $data['name'] . ' (' . $bank->name . ') a été créé.',
            ];
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', 'Banque — création compte : ' . $e->getMessage());

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Met à jour les informations descriptives d'un compte.
     * Les soldes ne se modifient jamais ici : uniquement via le livre.
     */
    public function updateBankAccount(int $accountId, array $data, ?int $userId = null): array
    {
        $account = $this->getBankAccountById($accountId);

        if (!$account) {
            return ['status' => false, 'message' => 'Compte bancaire introuvable.'];
        }

        $allowedStatus = ['active', 'inactive', 'blocked', 'closed'];

        $update = [
            'name'                  => $data['name'],
            'branch_name'           => $this->bankNullable($data['branch_name'] ?? null),
            'accounting_account_id' => !empty($data['accounting_account_id']) ? (int) $data['accounting_account_id'] : null,
            'overdraft_limit'       => round((float) ($data['overdraft_limit'] ?? 0), 2),
            'alert_threshold'       => round((float) ($data['alert_threshold'] ?? 0), 2),
            'observation'           => $this->bankNullable($data['observation'] ?? null),
            'status'                => in_array($data['status'] ?? '', $allowedStatus, true) ? $data['status'] : $account->status,
            'updated_by'            => $userId,
        ];

        if ($update['status'] === 'closed' && abs((float) $account->current_balance) > 0.001) {
            return ['status' => false, 'message' => 'Un compte ne peut être clôturé que si son solde est nul.'];
        }

        $this->db->where('id', $accountId)->update('tbl_finance_bank_account', $update);

        return ['status' => true, 'message' => 'Le compte ' . $account->code . ' a été mis à jour.'];
    }

    public function getBankAccountById(int $accountId)
    {
        if ($accountId <= 0) {
            return null;
        }

        return $this->db
            ->select('a.*, b.code AS bank_code, b.name AS bank_name')
            ->from('tbl_finance_bank_account a')
            ->join('tbl_finance_bank b', 'b.id = a.bank_id', 'left')
            ->where('a.id', $accountId)
            ->get()
            ->row();
    }

    /** Comptes actifs (listes déroulantes des modales). */
    public function getActiveBankAccounts(?string $currency = null): array
    {
        $this->db
            ->select('a.id, a.code, a.name, a.account_number, a.account_type, a.currency,
                      a.current_balance, a.overdraft_limit, a.last_reconciled_date,
                      b.code AS bank_code, b.name AS bank_name')
            ->from('tbl_finance_bank_account a')
            ->join('tbl_finance_bank b', 'b.id = a.bank_id', 'inner')
            ->where('a.status', 'active');

        if (in_array($currency, ['BIF', 'USD', 'EUR'], true)) {
            $this->db->where('a.currency', $currency);
        }

        return $this->db
            ->order_by('b.name', 'ASC')
            ->order_by('a.name', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Situation des comptes (cartes de la page) avec filtres :
     * search, bank_id, currency, status.
     * Entrées / sorties du mois calculées depuis le livre (hors solde initial).
     */
    public function getBankAccounts(array $filters = []): array
    {
        $sql = "
            SELECT
                a.*,
                b.code AS bank_code,
                b.name AS bank_name,
                COALESCE(m.monthly_entries, 0)    AS monthly_entries,
                COALESCE(m.monthly_outputs, 0)    AS monthly_outputs,
                COALESCE(m.monthly_operations, 0) AS monthly_operations
            FROM tbl_finance_bank_account a
            INNER JOIN tbl_finance_bank b ON b.id = a.bank_id
            LEFT JOIN (
                SELECT
                    bank_account_id,
                    SUM(CASE WHEN sens = 'entree' THEN amount ELSE 0 END) AS monthly_entries,
                    SUM(CASE WHEN sens = 'sortie' THEN amount ELSE 0 END) AS monthly_outputs,
                    COUNT(*) AS monthly_operations
                FROM tbl_finance_bank_movement
                WHERE status = 'validated'
                  AND nature <> 'solde_initial'
                  AND movement_date BETWEEN ? AND ?
                GROUP BY bank_account_id
            ) m ON m.bank_account_id = a.id
            WHERE 1 = 1
        ";

        $binds = [date('Y-m-01'), date('Y-m-t')];

        $search = trim((string) ($filters['search'] ?? ''));

        if ($search !== '') {
            $sql .= " AND (a.code LIKE ? OR a.name LIKE ? OR a.account_number LIKE ?
                           OR a.branch_name LIKE ? OR b.name LIKE ? OR b.code LIKE ?)";
            $like = '%' . $search . '%';
            array_push($binds, $like, $like, $like, $like, $like, $like);
        }

        if (!empty($filters['bank_id'])) {
            $sql .= ' AND a.bank_id = ?';
            $binds[] = (int) $filters['bank_id'];
        }

        if (in_array($filters['currency'] ?? '', ['BIF', 'USD', 'EUR'], true)) {
            $sql .= ' AND a.currency = ?';
            $binds[] = $filters['currency'];
        }

        if (in_array($filters['status'] ?? '', ['active', 'inactive', 'blocked', 'closed'], true)) {
            $sql .= ' AND a.status = ?';
            $binds[] = $filters['status'];
        }

        $sql .= " ORDER BY FIELD(a.status, 'active', 'blocked', 'inactive', 'closed'),
                           b.name ASC, a.currency ASC, a.name ASC";

        return $this->db->query($sql, $binds)->result();
    }

    /**
     * Recalcule le solde d'un compte depuis le livre (outil de contrôle).
     */
    public function recalculateBankAccountBalance(int $accountId): float
    {
        $row = $this->db
            ->select("COALESCE(SUM(CASE WHEN sens = 'entree' THEN amount ELSE -amount END), 0) AS balance", false)
            ->where('bank_account_id', $accountId)
            ->where('status', 'validated')
            ->get('tbl_finance_bank_movement')
            ->row();

        $balance = round((float) $row->balance, 2);

        $this->db
            ->where('id', $accountId)
            ->update('tbl_finance_bank_account', ['current_balance' => $balance]);

        return $balance;
    }

    /* ---------------------------------------------------------------------
     * OPÉRATIONS BANCAIRES
     * ------------------------------------------------------------------- */

    /** Aperçu de la prochaine référence (affichage, sans verrou). */
    public function getNextBankOperationReference(): string
    {
        return $this->bankNextReference('tbl_finance_bank_operation', 'BOP', 5, 'reference', false);
    }

    /**
     * Crée une opération bancaire.
     * status = 'validated' (défaut) : écrit immédiatement le livre.
     * status = 'pending'            : enregistrée, en attente de validation.
     */
    public function createBankOperation(array $data): array
    {
        $type = (string) ($data['operation_type'] ?? '');

        if (!isset($this->bankOperationRules[$type])) {
            return ['status' => false, 'message' => 'Type d’opération bancaire invalide.'];
        }

        $amount = round((float) ($data['amount'] ?? 0), 2);

        if ($amount <= 0) {
            return ['status' => false, 'message' => 'Le montant doit être supérieur à zéro.'];
        }

        $rules  = $this->bankOperationRules[$type];
        $userId = !empty($data['created_by']) ? (int) $data['created_by'] : null;
        $status = ($data['status'] ?? 'validated') === 'pending' ? 'pending' : 'validated';

        $this->db->trans_begin();

        try {
            $sourceId = $rules['source'] ? (int) ($data['source_bank_account_id'] ?? 0) : 0;
            $destId   = $rules['destination'] ? (int) ($data['destination_bank_account_id'] ?? 0) : 0;

            if ($rules['source'] && $sourceId <= 0) {
                throw new RuntimeException('Le compte bancaire à débiter est obligatoire.');
            }

            if ($rules['destination'] && $destId <= 0) {
                throw new RuntimeException('Le compte bancaire à créditer est obligatoire.');
            }

            if ($type === 'transfert' && $sourceId === $destId) {
                throw new RuntimeException('Le compte source et le compte destination doivent être différents.');
            }

            $cashboxId = null;

            if ($rules['cashbox']) {
                $principal = $this->getPrincipalCashbox();

                if (!$principal) {
                    throw new RuntimeException('Aucune caisse principale active n’est configurée.');
                }

                $cashboxId = (int) $principal->id;
            }

            /* La devise vient toujours du compte, jamais du formulaire */
            $referenceAccount = $this->getBankAccountById($sourceId ?: $destId);

            if (!$referenceAccount) {
                throw new RuntimeException('Le compte bancaire sélectionné est introuvable.');
            }

            $reference = $this->bankNextReference('tbl_finance_bank_operation', 'BOP', 5, 'reference', true);

            $inserted = $this->db->insert('tbl_finance_bank_operation', [
                'reference'                   => $reference,
                'operation_type'              => $type,
                'operation_date'              => $data['operation_date'],
                'value_date'                  => $this->bankNullable($data['value_date'] ?? null),
                'source_bank_account_id'      => $sourceId ?: null,
                'destination_bank_account_id' => $destId ?: null,
                'cashbox_id'                  => $cashboxId,
                'amount'                      => $amount,
                'currency'                    => $referenceAccount->currency,
                'category'                    => $this->bankNullable($data['category'] ?? null),
                'third_party'                 => $this->bankNullable($data['third_party'] ?? null),
                'payment_method'              => $data['payment_method'] ?? 'virement',
                'document_number'             => $this->bankNullable($data['document_number'] ?? null),
                'attachment'                  => $this->bankNullable($data['attachment'] ?? null),
                'source_type'                 => $this->bankNullable($data['source_type'] ?? null),
                'source_id'                   => !empty($data['source_id']) ? (int) $data['source_id'] : null,
                'chantier_id'                 => !empty($data['chantier_id']) ? (int) $data['chantier_id'] : null,
                'label'                       => $data['label'],
                'observation'                 => $this->bankNullable($data['observation'] ?? null),
                'status'                      => 'pending',
                'created_by'                  => $userId,
            ]);

            if (!$inserted) {
                throw new RuntimeException('Impossible d’enregistrer l’opération bancaire.');
            }

            $operationId = (int) $this->db->insert_id();

            if ($status === 'validated') {
                $this->applyBankOperation($operationId, $userId);
            }

            if ($this->db->trans_status() === false) {
                throw new RuntimeException('Erreur de base de données pendant l’opération bancaire.');
            }

            $this->db->trans_commit();

            return [
                'status'       => true,
                'operation_id' => $operationId,
                'reference'    => $reference,
                'message'      => $status === 'validated'
                    ? 'Opération ' . $reference . ' enregistrée et inscrite au livre de banque.'
                    : 'Opération ' . $reference . ' enregistrée, en attente de validation.',
            ];
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', 'Banque — création opération : ' . $e->getMessage());

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /** Valide une opération en attente (écrit le livre). */
    public function validateBankOperation(int $operationId, ?int $userId): array
    {
        $this->db->trans_begin();

        try {
            $this->applyBankOperation($operationId, $userId);

            if ($this->db->trans_status() === false) {
                throw new RuntimeException('Erreur de base de données pendant la validation.');
            }

            $this->db->trans_commit();

            return ['status' => true, 'message' => 'Opération validée et inscrite au livre de banque.'];
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', 'Banque — validation opération : ' . $e->getMessage());

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Applique une opération « pending » : contrôles, lignes du livre,
     * mouvement de caisse éventuel, passage au statut « validated ».
     * Doit être appelée DANS une transaction.
     */
    private function applyBankOperation(int $operationId, ?int $userId): void
    {
        $operation = $this->db
            ->query('SELECT * FROM tbl_finance_bank_operation WHERE id = ? LIMIT 1 FOR UPDATE', [$operationId])
            ->row();

        if (!$operation) {
            throw new RuntimeException('Opération bancaire introuvable.');
        }

        if ($operation->status !== 'pending') {
            throw new RuntimeException('L’opération ' . $operation->reference . ' a déjà été traitée.');
        }

        $amount = (float) $operation->amount;
        $date   = $operation->operation_date;
        $type   = $operation->operation_type;

        /* Verrouillage dans l'ordre croissant des id (évite les interblocages) */
        $accountIds = array_values(array_filter([
            (int) $operation->source_bank_account_id,
            (int) $operation->destination_bank_account_id,
        ]));
        sort($accountIds);

        $locked = [];

        foreach ($accountIds as $accountId) {
            $locked[$accountId] = $this->getBankAccountForUpdate($accountId);
        }

        $source = $operation->source_bank_account_id
            ? ($locked[(int) $operation->source_bank_account_id] ?? null)
            : null;

        $destination = $operation->destination_bank_account_id
            ? ($locked[(int) $operation->destination_bank_account_id] ?? null)
            : null;

        if ($operation->source_bank_account_id) {
            $this->assertBankAccountUsable($source, 'à débiter', $date);

            if ($source->currency !== $operation->currency) {
                throw new RuntimeException('La devise de l’opération ne correspond pas au compte à débiter.');
            }

            $this->assertBankFundsAvailable($source, $amount);
        }

        if ($operation->destination_bank_account_id) {
            $this->assertBankAccountUsable($destination, 'à créditer', $date);

            if ($destination->currency !== $operation->currency) {
                throw new RuntimeException(
                    'Les deux comptes doivent avoir la même devise (pas encore de gestion de taux de change).'
                );
            }
        }

        /* Caisse principale (retrait / versement) */
        $cashbox = null;

        if (!empty($operation->cashbox_id)) {
            $cashbox = $this->db
                ->query('SELECT * FROM tbl_finance_cashbox WHERE id = ? LIMIT 1 FOR UPDATE', [(int) $operation->cashbox_id])
                ->row();

            if (!$cashbox || $cashbox->status !== 'active' || $cashbox->role !== 'principale') {
                throw new RuntimeException('La caisse principale est introuvable ou inactive.');
            }

            if ($cashbox->devise !== $operation->currency) {
                throw new RuntimeException('La caisse principale et le compte bancaire n’ont pas la même devise.');
            }

            if ($type === 'versement_banque' && $amount > (float) $cashbox->current_balance + 0.001) {
                throw new RuntimeException(
                    'Solde de la caisse principale insuffisant : '
                        . number_format((float) $cashbox->current_balance, 0, ',', ' ') . ' ' . $cashbox->devise . '.'
                );
            }
        }

        $transferReference = in_array($type, ['transfert', 'retrait_banque', 'versement_banque'], true)
            ? $operation->reference
            : null;

        $common = [
            'bank_operation_id'  => (int) $operation->id,
            'movement_date'      => $date,
            'value_date'         => $operation->value_date,
            'label'              => $operation->label,
            'third_party'        => $operation->third_party,
            'document_number'    => $operation->document_number,
            'transfer_reference' => $transferReference,
            'created_by'         => $userId,
        ];

        if ($source) {
            $this->insertBankMovement(
                $source,
                'sortie',
                $type === 'transfert' ? 'transfert_sortant' : $type,
                $amount,
                $common
            );
        }

        if ($destination) {
            $this->insertBankMovement(
                $destination,
                'entree',
                $type === 'transfert' ? 'transfert_entrant' : $type,
                $amount,
                $common
            );
        }

        $cashReference = null;

        if ($cashbox) {
            $cashReference = $this->insertCashMovementFromBank($cashbox, $operation, $userId, false);
        }

        $this->db
            ->where('id', (int) $operation->id)
            ->update('tbl_finance_bank_operation', [
                'status'                  => 'validated',
                'validated_by'            => $userId,
                'validated_at'            => date('Y-m-d H:i:s'),
                'cash_movement_reference' => $cashReference,
            ]);
    }

    /**
     * Annule une opération.
     * - pending   : simple changement de statut ;
     * - validated : contre-passation dans le livre (et dans la caisse si besoin).
     * Interdit si une de ses lignes est déjà rapprochée.
     */
    public function cancelBankOperation(int $operationId, string $reason, ?int $userId): array
    {
        $reason = trim($reason);

        if ($reason === '') {
            return ['status' => false, 'message' => 'Le motif d’annulation est obligatoire.'];
        }

        $this->db->trans_begin();

        try {
            $operation = $this->db
                ->query('SELECT * FROM tbl_finance_bank_operation WHERE id = ? LIMIT 1 FOR UPDATE', [$operationId])
                ->row();

            if (!$operation) {
                throw new RuntimeException('Opération bancaire introuvable.');
            }

            if ($operation->status === 'cancelled') {
                throw new RuntimeException('Cette opération est déjà annulée.');
            }

            if ($operation->status === 'validated') {
                $movements = $this->db
                    ->where('bank_operation_id', (int) $operation->id)
                    ->where('nature !=', 'contre_passation')
                    ->get('tbl_finance_bank_movement')
                    ->result();

                foreach ($movements as $movement) {
                    if ((int) $movement->is_reconciled === 1) {
                        throw new RuntimeException(
                            'L’opération est déjà rapprochée avec un relevé : annulation impossible.'
                        );
                    }
                }

                $accountIds = array_unique(array_map(function ($m) {
                    return (int) $m->bank_account_id;
                }, $movements));
                sort($accountIds);

                $locked = [];

                foreach ($accountIds as $accountId) {
                    $locked[$accountId] = $this->getBankAccountForUpdate($accountId);
                }

                $today = date('Y-m-d');

                foreach ($movements as $movement) {
                    $account     = $locked[(int) $movement->bank_account_id];
                    $reverseSens = $movement->sens === 'entree' ? 'sortie' : 'entree';

                    if ($account->status === 'closed') {
                        throw new RuntimeException('Le compte ' . $account->name . ' est clôturé.');
                    }

                    if ($reverseSens === 'sortie') {
                        $this->assertBankFundsAvailable($account, (float) $movement->amount);
                    }

                    $this->insertBankMovement($account, $reverseSens, 'contre_passation', (float) $movement->amount, [
                        'bank_operation_id'  => (int) $operation->id,
                        'movement_date'      => $today,
                        'label'              => 'Contre-passation ' . $operation->reference . ' — ' . $reason,
                        'transfer_reference' => $movement->transfer_reference,
                        'created_by'         => $userId,
                    ]);
                }

                if (!empty($operation->cash_movement_reference) && !empty($operation->cashbox_id)) {
                    $cashbox = $this->db
                        ->query('SELECT * FROM tbl_finance_cashbox WHERE id = ? LIMIT 1 FOR UPDATE', [(int) $operation->cashbox_id])
                        ->row();

                    if (!$cashbox) {
                        throw new RuntimeException('La caisse principale liée est introuvable.');
                    }

                    $this->insertCashMovementFromBank($cashbox, $operation, $userId, true);
                }
            }

            $this->db
                ->where('id', (int) $operation->id)
                ->update('tbl_finance_bank_operation', [
                    'status'        => 'cancelled',
                    'cancelled_by'  => $userId,
                    'cancelled_at'  => date('Y-m-d H:i:s'),
                    'cancel_reason' => $reason,
                ]);

            if ($this->db->trans_status() === false) {
                throw new RuntimeException('Erreur de base de données pendant l’annulation.');
            }

            $this->db->trans_commit();

            return ['status' => true, 'message' => 'L’opération ' . $operation->reference . ' a été annulée.'];
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', 'Banque — annulation opération : ' . $e->getMessage());

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /** Requête commune : opérations + comptes + banques + créateur. */
    private function bankOperationBaseQuery(): void
    {
        $this->db
            ->select("
                o.*,
                sa.code AS source_account_code, sa.name AS source_account_name,
                sa.account_number AS source_account_number, sb.name AS source_bank_name,
                da.code AS destination_account_code, da.name AS destination_account_name,
                da.account_number AS destination_account_number, dbk.name AS destination_bank_name,
                CONCAT_WS(' ', uc.first_name, uc.last_name) AS created_by_name,
                CONCAT_WS(' ', uv.first_name, uv.last_name) AS validated_by_name
            ", false)
            ->from('tbl_finance_bank_operation o')
            ->join('tbl_finance_bank_account sa', 'sa.id = o.source_bank_account_id', 'left')
            ->join('tbl_finance_bank sb', 'sb.id = sa.bank_id', 'left')
            ->join('tbl_finance_bank_account da', 'da.id = o.destination_bank_account_id', 'left')
            ->join('tbl_finance_bank dbk', 'dbk.id = da.bank_id', 'left')
            ->join('users uc', 'uc.id = o.created_by', 'left')
            ->join('users uv', 'uv.id = o.validated_by', 'left');
    }

    public function getRecentBankOperations(int $limit = 10): array
    {
        $this->bankOperationBaseQuery();

        return $this->db
            ->order_by('o.operation_date', 'DESC')
            ->order_by('o.id', 'DESC')
            ->limit(max(1, min(100, $limit)))
            ->get()
            ->result();
    }

    public function countBankOperations(): int
    {
        return (int) $this->db->count_all('tbl_finance_bank_operation');
    }

    /** Détail d'une opération avec ses lignes du livre (modale « Voir »). */
    public function getBankOperationById(int $operationId)
    {
        $this->bankOperationBaseQuery();

        $operation = $this->db->where('o.id', $operationId)->get()->row();

        if ($operation) {
            $operation->movements = $this->db
                ->select('m.*, a.code AS account_code, a.name AS account_name')
                ->from('tbl_finance_bank_movement m')
                ->join('tbl_finance_bank_account a', 'a.id = m.bank_account_id', 'left')
                ->where('m.bank_operation_id', $operationId)
                ->order_by('m.id', 'ASC')
                ->get()
                ->result();
        }

        return $operation;
    }

    /* ---------------------------------------------------------------------
     * TABLEAU DE BORD BANCAIRE
     * ------------------------------------------------------------------- */

    /**
     * Statistiques principales (comptes actifs d'une devise).
     * Les flux du jour excluent le solde initial et les transferts internes.
     */
    public function getBankMainStatistics(string $currency = 'BIF'): array
    {
        $today      = date('Y-m-d');
        $monthStart = date('Y-m-01');

        $accounts = $this->db
            ->query("
                SELECT COALESCE(SUM(current_balance), 0) AS global_balance,
                       COUNT(*) AS currency_accounts
                FROM tbl_finance_bank_account
                WHERE status = 'active' AND currency = ?
            ", [$currency])
            ->row();

        $allActive = $this->db
            ->query("
                SELECT COUNT(*) AS active_accounts, COUNT(DISTINCT bank_id) AS bank_count
                FROM tbl_finance_bank_account
                WHERE status = 'active'
            ")
            ->row();

        $opening = $this->db
            ->query("
                SELECT COALESCE(SUM(CASE WHEN m.sens = 'entree' THEN m.amount ELSE -m.amount END), 0) AS balance
                FROM tbl_finance_bank_movement m
                INNER JOIN tbl_finance_bank_account a ON a.id = m.bank_account_id
                WHERE a.status = 'active' AND a.currency = ?
                  AND m.status = 'validated' AND m.movement_date < ?
            ", [$currency, $monthStart])
            ->row();

        $todayFlows = $this->db
            ->query("
                SELECT
                    COALESCE(SUM(CASE WHEN sens = 'entree' THEN amount ELSE 0 END), 0) AS income_amount,
                    COALESCE(SUM(CASE WHEN sens = 'entree' THEN 1 ELSE 0 END), 0)      AS income_count,
                    COALESCE(SUM(CASE WHEN sens = 'sortie' THEN amount ELSE 0 END), 0) AS expense_amount,
                    COALESCE(SUM(CASE WHEN sens = 'sortie' THEN 1 ELSE 0 END), 0)      AS expense_count
                FROM tbl_finance_bank_movement
                WHERE status = 'validated' AND currency = ? AND movement_date = ?
                  AND nature NOT IN ('solde_initial', 'transfert_entrant', 'transfert_sortant')
            ", [$currency, $today])
            ->row();

        $globalBalance = (float) $accounts->global_balance;
        $monthOpening  = (float) $opening->balance;

        if (abs($monthOpening) > 0.001) {
            $variation = (($globalBalance - $monthOpening) / abs($monthOpening)) * 100;
        } else {
            $variation = $globalBalance > 0 ? 100 : 0;
        }

        return [
            'currency'                    => $currency,
            'global_balance'              => $globalBalance,
            'currency_accounts'           => (int) $accounts->currency_accounts,
            'active_accounts'             => (int) $allActive->active_accounts,
            'bank_count'                  => (int) $allActive->bank_count,
            'today_income_amount'         => (float) $todayFlows->income_amount,
            'today_income_count'          => (int) $todayFlows->income_count,
            'today_expense_amount'        => (float) $todayFlows->expense_amount,
            'today_expense_count'         => (int) $todayFlows->expense_count,
            'month_opening_balance'       => $monthOpening,
            'global_variation_percentage' => round($variation, 1),
        ];
    }

    /**
     * Évolution des flux (graphique).
     * Périodes : 7days, 30days, month, year.
     */
    public function getBankFlowEvolution(string $period = '7days', string $currency = 'BIF'): array
    {
        $monthNames = [
            1 => 'Janv.',
            2 => 'Févr.',
            3 => 'Mars',
            4 => 'Avr.',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juil.',
            8 => 'Août',
            9 => 'Sept.',
            10 => 'Oct.',
            11 => 'Nov.',
            12 => 'Déc.',
        ];

        $byMonth = false;

        switch ($period) {
            case '30days':
                $start = date('Y-m-d', strtotime('-29 days'));
                $end   = date('Y-m-d');
                break;
            case 'month':
                $start = date('Y-m-01');
                $end   = date('Y-m-t');
                break;
            case 'year':
                $start   = date('Y-01-01');
                $end     = date('Y-12-31');
                $byMonth = true;
                break;
            default:
                $period = '7days';
                $start  = date('Y-m-d', strtotime('-6 days'));
                $end    = date('Y-m-d');
                break;
        }

        $rows = $this->db
            ->query("
                SELECT
                    DATE_FORMAT(movement_date, ?) AS period_key,
                    SUM(CASE WHEN sens = 'entree' THEN amount ELSE 0 END) AS total_in,
                    SUM(CASE WHEN sens = 'sortie' THEN amount ELSE 0 END) AS total_out
                FROM tbl_finance_bank_movement
                WHERE status = 'validated' AND currency = ?
                  AND nature NOT IN ('solde_initial', 'transfert_entrant', 'transfert_sortant')
                  AND movement_date BETWEEN ? AND ?
                GROUP BY period_key
            ", [$byMonth ? '%Y-%m' : '%Y-%m-%d', $currency, $start, $end])
            ->result();

        $indexed = [];

        foreach ($rows as $row) {
            $indexed[$row->period_key] = [(float) $row->total_in, (float) $row->total_out];
        }

        $labels = $incomes = $expenses = [];

        if ($byMonth) {
            for ($month = 1; $month <= 12; $month++) {
                $key        = date('Y') . '-' . str_pad((string) $month, 2, '0', STR_PAD_LEFT);
                $labels[]   = $monthNames[$month];
                $incomes[]  = $indexed[$key][0] ?? 0;
                $expenses[] = $indexed[$key][1] ?? 0;
            }
        } else {
            for ($ts = strtotime($start); $ts <= strtotime($end); $ts = strtotime('+1 day', $ts)) {
                $key        = date('Y-m-d', $ts);
                $labels[]   = date('d', $ts) . ' ' . $monthNames[(int) date('n', $ts)];
                $incomes[]  = $indexed[$key][0] ?? 0;
                $expenses[] = $indexed[$key][1] ?? 0;
            }
        }

        $totalIncome  = array_sum($incomes);
        $totalExpense = array_sum($expenses);

        return [
            'period'        => $period,
            'start_date'    => $start,
            'end_date'      => $end,
            'labels'        => $labels,
            'incomes'       => $incomes,
            'expenses'      => $expenses,
            'total_income'  => $totalIncome,
            'total_expense' => $totalExpense,
            'net'           => $totalIncome - $totalExpense,
        ];
    }

    /** Solde par banque (part du total, comptes actifs d'une devise). */
    public function getBankBalanceDistribution(string $currency = 'BIF'): array
    {
        $rows = $this->db
            ->query("
                SELECT b.name AS bank_name,
                       COUNT(a.id) AS account_count,
                       COALESCE(SUM(a.current_balance), 0) AS total_balance
                FROM tbl_finance_bank_account a
                INNER JOIN tbl_finance_bank b ON b.id = a.bank_id
                WHERE a.status = 'active' AND a.currency = ?
                GROUP BY b.id, b.name
                ORDER BY total_balance DESC
            ", [$currency])
            ->result();

        $total = 0;

        foreach ($rows as $row) {
            $total += max(0, (float) $row->total_balance);
        }

        $distribution = [];

        foreach ($rows as $row) {
            $balance = (float) $row->total_balance;

            $distribution[] = [
                'bank_name'     => $row->bank_name,
                'account_count' => (int) $row->account_count,
                'total_balance' => $balance,
                'percentage'    => $total > 0 ? round(max(0, $balance) / $total * 100, 2) : 0,
            ];
        }

        return $distribution;
    }

    /**
     * Alertes bancaires :
     * découvert / seuil, opérations en attente, justificatifs manquants,
     * rapprochement en retard (> 35 jours).
     */
    public function getBankAlerts(int $limit = 6): array
    {
        $alerts = [];

        /* 1. Soldes sous le seuil ou à découvert */
        $lowAccounts = $this->db
            ->query("
                SELECT id, name, currency, current_balance, alert_threshold
                FROM tbl_finance_bank_account
                WHERE status = 'active'
                  AND (current_balance < 0 OR (alert_threshold > 0 AND current_balance <= alert_threshold))
                ORDER BY current_balance ASC
            ")
            ->result();

        foreach ($lowAccounts as $account) {
            $isOverdraft = (float) $account->current_balance < 0;

            $alerts[] = [
                'type'        => 'danger',
                'icon'        => 'fas fa-university',
                'title'       => $isOverdraft ? 'Compte à découvert' : 'Solde sous le seuil d’alerte',
                'description' => $account->name . ' : '
                    . number_format((float) $account->current_balance, 0, ',', ' ') . ' ' . $account->currency
                    . ($isOverdraft ? '.' : ' (seuil ' . number_format((float) $account->alert_threshold, 0, ',', ' ') . ').'),
                'account_id'  => (int) $account->id,
                'priority'    => 0,
            ];
        }

        /* 2. Opérations en attente de validation */
        $pending = $this->db
            ->select('id, reference, amount, currency, operation_date')
            ->where('status', 'pending')
            ->order_by('operation_date', 'ASC')
            ->limit(5)
            ->get('tbl_finance_bank_operation')
            ->result();

        foreach ($pending as $operation) {
            $alerts[] = [
                'type'         => 'warning',
                'icon'         => 'fas fa-clock',
                'title'        => 'Opération en attente de validation',
                'description'  => $operation->reference . ' — '
                    . number_format((float) $operation->amount, 0, ',', ' ') . ' ' . $operation->currency
                    . ' du ' . date('d/m/Y', strtotime($operation->operation_date)) . '.',
                'operation_id' => (int) $operation->id,
                'priority'     => 1,
            ];
        }

        /* 3. Rapprochement en retard (> 35 jours) */
        $limitDate = date('Y-m-d', strtotime('-35 days'));

        $lateAccounts = $this->db
            ->query("
                SELECT id, name, last_reconciled_date
                FROM tbl_finance_bank_account
                WHERE status = 'active'
                  AND (
                        (last_reconciled_date IS NULL AND opening_date < ?)
                     OR last_reconciled_date < ?
                  )
            ", [$limitDate, $limitDate])
            ->result();

        foreach ($lateAccounts as $account) {
            $alerts[] = [
                'type'        => 'warning',
                'icon'        => 'fas fa-balance-scale',
                'title'       => 'Rapprochement en retard',
                'description' => $account->name . ' : '
                    . (empty($account->last_reconciled_date)
                        ? 'aucun rapprochement effectué.'
                        : 'dernier rapprochement au ' . date('d/m/Y', strtotime($account->last_reconciled_date)) . '.'),
                'account_id'  => (int) $account->id,
                'priority'    => 2,
            ];
        }

        /* 4. Justificatifs manquants (90 derniers jours) */
        $missing = $this->db
            ->query("
                SELECT id, reference, amount, currency
                FROM tbl_finance_bank_operation
                WHERE status = 'validated'
                  AND operation_type IN ('encaissement', 'decaissement')
                  AND (attachment IS NULL OR attachment = '')
                  AND operation_date >= ?
                ORDER BY amount DESC
                LIMIT 5
            ", [date('Y-m-d', strtotime('-90 days'))])
            ->result();

        foreach ($missing as $operation) {
            $alerts[] = [
                'type'         => 'info',
                'icon'         => 'fas fa-file-invoice',
                'title'        => 'Justificatif manquant',
                'description'  => $operation->reference . ' — '
                    . number_format((float) $operation->amount, 0, ',', ' ') . ' ' . $operation->currency
                    . ' sans pièce justificative.',
                'operation_id' => (int) $operation->id,
                'priority'     => 3,
            ];
        }

        usort($alerts, function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        return array_slice($alerts, 0, max(1, $limit));
    }

        /* ---------------------------------------------------------------------
     * LIVRE DE BANQUE
     * ------------------------------------------------------------------- */

    /** Libellés des natures de lignes du livre de banque. */
    public function getBankMovementNatureLabels(): array
    {
        return [
            'solde_initial'       => 'Solde initial',
            'encaissement'        => 'Encaissement',
            'decaissement'        => 'Décaissement',
            'transfert_entrant'   => 'Transfert entrant',
            'transfert_sortant'   => 'Transfert sortant',
            'retrait_banque'      => 'Retrait vers caisse',
            'versement_banque'    => 'Versement depuis caisse',
            'frais_bancaires'     => 'Frais bancaires',
            'interets_crediteurs' => 'Intérêts créditeurs',
            'contre_passation'    => 'Contre-passation',
        ];
    }

    /**
     * Livre de banque d'un compte sur une période.
     *
     * Le solde progressif est calculé sur TOUTES les lignes de la période
     * (ordre date puis id), puis les filtres d'affichage sont appliqués :
     * le solde affiché sur chaque ligne reste donc toujours juste.
     *
     * Filtres : date_from, date_to, sens, nature, search, reconciled (yes|no)
     */
    public function getBankLedger(int $accountId, array $filters): array
    {
        $dateFrom = $filters['date_from'];
        $dateTo   = $filters['date_to'];

        /* Solde d'ouverture = toutes les lignes validées avant la période */
        $openingBalance = round((float) $this->db
            ->query("
                SELECT COALESCE(SUM(CASE WHEN sens = 'entree' THEN amount ELSE -amount END), 0) AS balance
                FROM tbl_finance_bank_movement
                WHERE bank_account_id = ?
                  AND status = 'validated'
                  AND movement_date < ?
            ", [$accountId, $dateFrom])
            ->row()
            ->balance, 2);

        /* Lignes de la période */
        $rows = $this->db
            ->query("
                SELECT
                    m.id, m.reference, m.bank_operation_id, m.sens, m.nature,
                    m.movement_date, m.value_date, m.amount, m.currency,
                    m.label, m.third_party, m.document_number, m.transfer_reference,
                    m.is_reconciled, m.reconciled_at, m.created_at,
                    o.reference      AS operation_reference,
                    o.operation_type AS operation_type,
                    o.payment_method AS payment_method,
                    o.attachment     AS attachment,
                    o.status         AS operation_status,
                    CONCAT_WS(' ', u.first_name, u.last_name) AS created_by_name
                FROM tbl_finance_bank_movement m
                LEFT JOIN tbl_finance_bank_operation o ON o.id = m.bank_operation_id
                LEFT JOIN users u ON u.id = m.created_by
                WHERE m.bank_account_id = ?
                  AND m.status = 'validated'
                  AND m.movement_date BETWEEN ? AND ?
                ORDER BY m.movement_date ASC, m.id ASC
            ", [$accountId, $dateFrom, $dateTo])
            ->result();

        /* Solde progressif + totaux de la période (sans filtre) */
        $running      = $openingBalance;
        $totalIn      = 0;
        $totalOut     = 0;
        $countIn      = 0;
        $countOut     = 0;
        $unreconciled = 0;
        $lineNumber   = 0;

        foreach ($rows as $row) {
            $amount = (float) $row->amount;

            if ($row->sens === 'entree') {
                $running         += $amount;
                $totalIn         += $amount;
                $countIn++;
                $row->entry_amount = $amount;
                $row->exit_amount  = 0;
            } else {
                $running         -= $amount;
                $totalOut        += $amount;
                $countOut++;
                $row->entry_amount = 0;
                $row->exit_amount  = $amount;
            }

            $row->line_number     = ++$lineNumber;
            $row->running_balance = round($running, 2);

            if ((int) $row->is_reconciled !== 1) {
                $unreconciled++;
            }
        }

        /* Filtres d'affichage */
        $search     = function_exists('mb_strtolower') ? mb_strtolower((string) ($filters['search'] ?? ''), 'UTF-8') : strtolower((string) ($filters['search'] ?? ''));
        $sens       = $filters['sens'] ?? '';
        $nature     = $filters['nature'] ?? '';
        $reconciled = $filters['reconciled'] ?? '';

        $displayed = array_values(array_filter($rows, function ($row) use ($search, $sens, $nature, $reconciled) {
            if ($sens !== '' && $row->sens !== $sens) {
                return false;
            }

            if ($nature !== '' && $row->nature !== $nature) {
                return false;
            }

            if ($reconciled === 'yes' && (int) $row->is_reconciled !== 1) {
                return false;
            }

            if ($reconciled === 'no' && (int) $row->is_reconciled === 1) {
                return false;
            }

            if ($search !== '') {
                $haystack = implode(' ', [
                    $row->reference,
                    $row->operation_reference,
                    $row->label,
                    $row->third_party,
                    $row->document_number,
                    $row->transfer_reference,
                ]);

                $haystack = function_exists('mb_strtolower') ? mb_strtolower($haystack, 'UTF-8') : strtolower($haystack);

                if (strpos($haystack, $search) === false) {
                    return false;
                }
            }

            return true;
        }));

        $filteredIn  = 0;
        $filteredOut = 0;

        foreach ($displayed as $row) {
            $filteredIn  += $row->entry_amount;
            $filteredOut += $row->exit_amount;
        }

        return [
            'opening_balance' => $openingBalance,
            'closing_balance' => round($running, 2),
            'total_in'        => round($totalIn, 2),
            'total_out'       => round($totalOut, 2),
            'count_in'        => $countIn,
            'count_out'       => $countOut,
            'count_all'       => count($rows),
            'unreconciled'    => $unreconciled,
            'filtered_in'     => round($filteredIn, 2),
            'filtered_out'    => round($filteredOut, 2),
            'is_filtered'     => ($search !== '' || $sens !== '' || $nature !== '' || $reconciled !== ''),
            'rows'            => $displayed,
        ];
    }

        /* ---------------------------------------------------------------------
     * RAPPROCHEMENT BANCAIRE — SESSIONS ET RELEVÉS (6a)
     * ------------------------------------------------------------------- */

    /** Statuts encore modifiables. */
    private $reconciliationOpenStatuses = ['draft', 'in_progress', 'completed'];

    /** Statuts : [libellé, classe du badge]. */
    public function getReconciliationStatusLabels(): array
    {
        return [
            'draft'       => ['Relevé en saisie', 'badge-secondary'],
            'in_progress' => ['Pointage en cours', 'badge-warning'],
            'completed'   => ['Prêt à valider', 'badge-info'],
            'validated'   => ['Validé', 'badge-success'],
            'cancelled'   => ['Annulé', 'badge-dark'],
        ];
    }

    /** Début de la prochaine période : lendemain du dernier rapprochement, sinon date d'ouverture. */
    public function getReconciliationPeriodStart($account): string
    {
        return !empty($account->last_reconciled_date)
            ? date('Y-m-d', strtotime($account->last_reconciled_date . ' +1 day'))
            : $account->opening_date;
    }

    /** Solde initial attendu du relevé (continuité avec le rapprochement précédent). */
    public function getReconciliationExpectedOpening($account): float
    {
        return $account->last_reconciled_balance !== null
            ? (float) $account->last_reconciled_balance
            : (float) $account->opening_balance;
    }

    /** Solde du livre de banque à une date (incluse). */
    public function getBankBookBalanceAt(int $accountId, string $date): float
    {
        $row = $this->db
            ->query("
                SELECT COALESCE(SUM(CASE WHEN sens = 'entree' THEN amount ELSE -amount END), 0) AS balance
                FROM tbl_finance_bank_movement
                WHERE bank_account_id = ?
                  AND status = 'validated'
                  AND movement_date <= ?
            ", [$accountId, $date])
            ->row();

        return round((float) $row->balance, 2);
    }

    /** Rapprochement encore ouvert pour un compte (au plus un). */
    public function getOpenReconciliation(int $accountId)
    {
        return $this->db
            ->select('id, reference, period_start, period_end, status')
            ->where('bank_account_id', $accountId)
            ->where_in('status', $this->reconciliationOpenStatuses)
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('tbl_finance_bank_reconciliation')
            ->row();
    }

    /** Historique (filtres : bank_account_id, status). */
    public function getReconciliations(array $filters = []): array
    {
        $this->db
            ->select("
                r.*,
                a.code AS account_code, a.name AS account_name, a.account_number,
                b.name AS bank_name,
                s.reference AS statement_reference, s.statement_number,
                CONCAT_WS(' ', u.first_name, u.last_name) AS responsible_name
            ", false)
            ->from('tbl_finance_bank_reconciliation r')
            ->join('tbl_finance_bank_account a', 'a.id = r.bank_account_id', 'inner')
            ->join('tbl_finance_bank b', 'b.id = a.bank_id', 'left')
            ->join('tbl_finance_bank_statement s', 's.id = r.statement_id', 'left')
            ->join('users u', 'u.id = r.responsible_user_id', 'left');

        if (!empty($filters['bank_account_id'])) {
            $this->db->where('r.bank_account_id', (int) $filters['bank_account_id']);
        }

        if (!empty($filters['status'])) {
            $this->db->where('r.status', $filters['status']);
        }

        return $this->db
            ->order_by('r.period_end', 'DESC')
            ->order_by('r.id', 'DESC')
            ->get()
            ->result();
    }

    /** Détail d'un rapprochement avec son compte et son relevé. */
    public function getReconciliationById(int $reconciliationId)
    {
        if ($reconciliationId <= 0) {
            return null;
        }

        return $this->db
            ->select("
                r.*,
                a.code AS account_code, a.name AS account_name, a.account_number,
                a.opening_balance AS account_opening_balance, a.opening_date AS account_opening_date,
                a.last_reconciled_date, a.last_reconciled_balance, a.status AS account_status,
                b.name AS bank_name,
                s.reference AS statement_reference, s.statement_number, s.statement_date,
                s.original_file_name, s.imported_at,
                CONCAT_WS(' ', u.first_name, u.last_name) AS responsible_name
            ", false)
            ->from('tbl_finance_bank_reconciliation r')
            ->join('tbl_finance_bank_account a', 'a.id = r.bank_account_id', 'inner')
            ->join('tbl_finance_bank b', 'b.id = a.bank_id', 'left')
            ->join('tbl_finance_bank_statement s', 's.id = r.statement_id', 'left')
            ->join('users u', 'u.id = r.responsible_user_id', 'left')
            ->where('r.id', $reconciliationId)
            ->get()
            ->row();
    }

    /** Rapprochement modifiable, sinon exception. */
    private function getEditableReconciliation(int $reconciliationId)
    {
        $reconciliation = $this->getReconciliationById($reconciliationId);

        if (!$reconciliation) {
            throw new RuntimeException('Rapprochement introuvable.');
        }

        if (!in_array($reconciliation->status, $this->reconciliationOpenStatuses, true)) {
            throw new RuntimeException(
                'Ce rapprochement est ' . ($reconciliation->status === 'validated' ? 'validé' : 'annulé') . ' : il ne peut plus être modifié.'
            );
        }

        return $reconciliation;
    }

    /**
     * Crée un rapprochement et son relevé.
     * Période : du lendemain du dernier rapprochement validé jusqu'à period_end.
     */
    public function createReconciliation(array $data): array
    {
        $accountId = (int) ($data['bank_account_id'] ?? 0);
        $userId    = !empty($data['created_by']) ? (int) $data['created_by'] : null;

        $this->db->trans_begin();

        try {
            $account = $this->getBankAccountForUpdate($accountId);

            if (!$account || !in_array($account->status, ['active', 'blocked'], true)) {
                throw new RuntimeException('Le compte bancaire est introuvable ou n’est plus actif.');
            }

            $open = $this->getOpenReconciliation($accountId);

            if ($open) {
                throw new RuntimeException(
                    'Le rapprochement ' . $open->reference . ' est déjà en cours pour ce compte : terminez-le ou annulez-le avant d’en commencer un autre.'
                );
            }

            $periodStart = $this->getReconciliationPeriodStart($account);
            $periodEnd   = $data['period_end'];

            if ($periodEnd < $periodStart) {
                throw new RuntimeException(
                    'La date de fin doit être postérieure ou égale au ' . date('d/m/Y', strtotime($periodStart)) . ' (début de la période à rapprocher).'
                );
            }

            if ($periodEnd > date('Y-m-d')) {
                throw new RuntimeException('La date de fin ne peut pas être dans le futur.');
            }

            $opening = round((float) $data['statement_opening_balance'], 2);
            $closing = round((float) $data['statement_closing_balance'], 2);

            /* Relevé */
            $this->db->insert('tbl_finance_bank_statement', [
                'reference'        => $this->bankNextReference('tbl_finance_bank_statement', 'REL', 5, 'reference', true),
                'bank_account_id'  => $accountId,
                'statement_number' => $this->bankNullable($data['statement_number'] ?? null),
                'statement_date'   => !empty($data['statement_date']) ? $data['statement_date'] : $periodEnd,
                'period_start'     => $periodStart,
                'period_end'       => $periodEnd,
                'currency'         => $account->currency,
                'opening_balance'  => $opening,
                'closing_balance'  => $closing,
                'import_mode'      => 'manual',
                'status'           => 'draft',
                'observation'      => $this->bankNullable($data['observation'] ?? null),
                'imported_by'      => $userId,
            ]);

            $statementId = (int) $this->db->insert_id();

            if ($statementId <= 0) {
                throw new RuntimeException('Le relevé n’a pas pu être créé.');
            }

            /* Rapprochement */
            $reference = $this->bankNextReference('tbl_finance_bank_reconciliation', 'RAP', 5, 'reference', true);

            $this->db->insert('tbl_finance_bank_reconciliation', [
                'reference'                 => $reference,
                'bank_account_id'           => $accountId,
                'statement_id'              => $statementId,
                'period_start'              => $periodStart,
                'period_end'                => $periodEnd,
                'currency'                  => $account->currency,
                'statement_opening_balance' => $opening,
                'statement_closing_balance' => $closing,
                'book_closing_balance'      => $this->getBankBookBalanceAt($accountId, $periodEnd),
                'date_tolerance'            => 5,
                'amount_tolerance'          => 0,
                'status'                    => 'draft',
                'observation'               => $this->bankNullable($data['observation'] ?? null),
                'responsible_user_id'       => $userId,
            ]);

            $reconciliationId = (int) $this->db->insert_id();

            if ($this->db->trans_status() === false || $reconciliationId <= 0) {
                throw new RuntimeException('Erreur de base de données pendant la création du rapprochement.');
            }

            $this->db->trans_commit();

            return [
                'status'    => true,
                'id'        => $reconciliationId,
                'reference' => $reference,
                'message'   => 'Rapprochement ' . $reference . ' créé. Saisissez ou importez maintenant les lignes du relevé.',
            ];
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', 'Banque — création rapprochement : ' . $e->getMessage());

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /** Lignes du relevé, dans l'ordre du relevé. */
    public function getStatementLines(int $statementId): array
    {
        return $this->db
            ->where('statement_id', $statementId)
            ->order_by('operation_date', 'ASC')
            ->order_by('line_number', 'ASC')
            ->order_by('id', 'ASC')
            ->get('tbl_finance_bank_statement_line')
            ->result();
    }

    private function nextStatementLineNumber(int $statementId): int
    {
        $row = $this->db
            ->select('COALESCE(MAX(line_number), 0) AS last_number', false)
            ->where('statement_id', $statementId)
            ->get('tbl_finance_bank_statement_line')
            ->row();

        return (int) $row->last_number + 1;
    }

    /** Recalcule les totaux du relevé. */
    private function refreshStatementTotals(int $statementId): void
    {
        $row = $this->db
            ->select('COALESCE(SUM(debit), 0) AS total_debit, COALESCE(SUM(credit), 0) AS total_credit, COUNT(*) AS total_lines', false)
            ->where('statement_id', $statementId)
            ->get('tbl_finance_bank_statement_line')
            ->row();

        $this->db
            ->where('id', $statementId)
            ->update('tbl_finance_bank_statement', [
                'total_debit'  => round((float) $row->total_debit, 2),
                'total_credit' => round((float) $row->total_credit, 2),
                'total_lines'  => (int) $row->total_lines,
            ]);
    }

    /** Ajoute une ligne au relevé (saisie manuelle). */
    public function addStatementLine(int $reconciliationId, array $data): array
    {
        try {
            $reconciliation = $this->getEditableReconciliation($reconciliationId);
            $date           = $data['operation_date'];

            if ($date < $reconciliation->period_start || $date > $reconciliation->period_end) {
                throw new RuntimeException(
                    'La date doit être comprise entre le ' . date('d/m/Y', strtotime($reconciliation->period_start))
                        . ' et le ' . date('d/m/Y', strtotime($reconciliation->period_end)) . '.'
                );
            }

            $amount = round((float) $data['amount'], 2);

            if ($amount <= 0) {
                throw new RuntimeException('Le montant doit être supérieur à zéro.');
            }

            $this->db->insert('tbl_finance_bank_statement_line', [
                'statement_id'    => (int) $reconciliation->statement_id,
                'line_number'     => $this->nextStatementLineNumber((int) $reconciliation->statement_id),
                'operation_date'  => $date,
                'value_date'      => $this->bankNullable($data['value_date'] ?? null),
                'label'           => $data['label'],
                'bank_reference'  => $this->bankNullable($data['bank_reference'] ?? null),
                'debit'           => $data['direction'] === 'debit' ? $amount : 0,
                'credit'          => $data['direction'] === 'credit' ? $amount : 0,
                'matching_status' => 'unmatched',
            ]);

            $this->refreshStatementTotals((int) $reconciliation->statement_id);

            return ['status' => true, 'message' => 'Ligne ajoutée au relevé.'];
        } catch (Throwable $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Importe des lignes déjà analysées par le contrôleur.
     * $rows : [line, operation_date, value_date, label, bank_reference, debit, credit]
     */
    public function importStatementLines(int $reconciliationId, array $rows, ?string $fileName, ?int $userId): array
    {
        $this->db->trans_begin();

        try {
            $reconciliation = $this->getEditableReconciliation($reconciliationId);
            $statementId    = (int) $reconciliation->statement_id;
            $lineNumber     = $this->nextStatementLineNumber($statementId);
            $imported       = 0;
            $errors         = [];

            foreach ($rows as $row) {
                if ($row['operation_date'] < $reconciliation->period_start || $row['operation_date'] > $reconciliation->period_end) {
                    $errors[] = 'Ligne ' . $row['line'] . ' : date ' . date('d/m/Y', strtotime($row['operation_date'])) . ' hors de la période du rapprochement.';
                    continue;
                }

                $this->db->insert('tbl_finance_bank_statement_line', [
                    'statement_id'    => $statementId,
                    'line_number'     => $lineNumber++,
                    'operation_date'  => $row['operation_date'],
                    'value_date'      => $row['value_date'],
                    'label'           => $row['label'],
                    'bank_reference'  => $this->bankNullable($row['bank_reference']),
                    'debit'           => $row['debit'],
                    'credit'          => $row['credit'],
                    'matching_status' => 'unmatched',
                ]);

                $imported++;
            }

            $this->refreshStatementTotals($statementId);

            $this->db
                ->set('imported_lines', 'imported_lines + ' . (int) $imported, false)
                ->set('rejected_lines', 'rejected_lines + ' . count($errors), false)
                ->set('import_mode', 'csv')
                ->set('original_file_name', $fileName)
                ->set('imported_at', date('Y-m-d H:i:s'))
                ->set('imported_by', $userId)
                ->where('id', $statementId)
                ->update('tbl_finance_bank_statement');

            if ($this->db->trans_status() === false) {
                throw new RuntimeException('Erreur de base de données pendant l’import.');
            }

            $this->db->trans_commit();

            return ['status' => true, 'imported' => $imported, 'errors' => $errors];
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', 'Banque — import relevé : ' . $e->getMessage());

            return ['status' => false, 'imported' => 0, 'errors' => [], 'message' => $e->getMessage()];
        }
    }

    /** Supprime une ligne du relevé (uniquement si elle n'est pas pointée). */
    public function deleteStatementLine(int $reconciliationId, int $lineId): array
    {
        try {
            $reconciliation = $this->getEditableReconciliation($reconciliationId);

            $line = $this->db
                ->where('id', $lineId)
                ->where('statement_id', (int) $reconciliation->statement_id)
                ->get('tbl_finance_bank_statement_line')
                ->row();

            if (!$line) {
                throw new RuntimeException('Ligne du relevé introuvable.');
            }

            if (in_array($line->matching_status, ['matched', 'partially_matched'], true)) {
                throw new RuntimeException('Cette ligne est pointée : dépointez-la avant de la supprimer.');
            }

            $this->db->where('id', $lineId)->delete('tbl_finance_bank_statement_line');
            $this->refreshStatementTotals((int) $reconciliation->statement_id);

            return ['status' => true, 'message' => 'Ligne supprimée du relevé.'];
        } catch (Throwable $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /** Synthèse : équilibre du relevé, continuité, solde du livre. */
    public function getReconciliationSummary($reconciliation): array
    {
        $totals = $this->db
            ->query("
                SELECT
                    COALESCE(SUM(debit), 0)  AS total_debit,
                    COALESCE(SUM(credit), 0) AS total_credit,
                    COUNT(*) AS line_count,
                    COALESCE(SUM(CASE WHEN matching_status IN ('matched', 'ignored') THEN 0 ELSE 1 END), 0) AS unmatched_count
                FROM tbl_finance_bank_statement_line
                WHERE statement_id = ?
            ", [(int) $reconciliation->statement_id])
            ->row();

        $opening  = (float) $reconciliation->statement_opening_balance;
        $closing  = (float) $reconciliation->statement_closing_balance;
        $debit    = (float) $totals->total_debit;
        $credit   = (float) $totals->total_credit;
        $computed = round($opening + $credit - $debit, 2);
        $gap      = round($closing - $computed, 2);
        $isOpen   = in_array($reconciliation->status, $this->reconciliationOpenStatuses, true);

        /* Continuité : seulement tant que le rapprochement est ouvert */
        $expectedOpening = null;
        $continuityGap   = 0;

        if ($isOpen) {
            $account         = $this->getBankAccountById((int) $reconciliation->bank_account_id);
            $expectedOpening = $this->getReconciliationExpectedOpening($account);
            $continuityGap   = round($opening - $expectedOpening, 2);
        }

        return [
            'opening'          => $opening,
            'closing'          => $closing,
            'total_debit'      => round($debit, 2),
            'total_credit'     => round($credit, 2),
            'computed_closing' => $computed,
            'statement_gap'    => $gap,
            'is_balanced'      => abs($gap) < 0.005,
            'line_count'       => (int) $totals->line_count,
            'unmatched_count'  => (int) $totals->unmatched_count,
            'expected_opening' => $expectedOpening,
            'continuity_gap'   => $continuityGap,
            'book_closing'     => $isOpen
                ? $this->getBankBookBalanceAt((int) $reconciliation->bank_account_id, $reconciliation->period_end)
                : (float) $reconciliation->book_closing_balance,
        ];
    }

    /** Annule un rapprochement non validé (le relevé est annulé avec lui). */
    public function cancelReconciliation(int $reconciliationId, string $reason, ?int $userId): array
    {
        $reason = trim($reason);

        if ($reason === '') {
            return ['status' => false, 'message' => 'Le motif d’annulation est obligatoire.'];
        }

        $this->db->trans_begin();

        try {
            $reconciliation = $this->getEditableReconciliation($reconciliationId);

            $this->db->where('reconciliation_id', $reconciliationId)->delete('tbl_finance_bank_reconciliation_match');

            $this->db
                ->where('statement_id', (int) $reconciliation->statement_id)
                ->update('tbl_finance_bank_statement_line', ['matching_status' => 'unmatched']);

            $this->db
                ->where('id', (int) $reconciliation->statement_id)
                ->update('tbl_finance_bank_statement', ['status' => 'cancelled']);

            $this->db
                ->where('id', $reconciliationId)
                ->update('tbl_finance_bank_reconciliation', [
                    'status'                 => 'cancelled',
                    'validated_by'           => $userId,
                    'validated_at'           => date('Y-m-d H:i:s'),
                    'validation_observation' => 'Annulé : ' . $reason,
                ]);

            if ($this->db->trans_status() === false) {
                throw new RuntimeException('Erreur de base de données pendant l’annulation.');
            }

            $this->db->trans_commit();

            return ['status' => true, 'message' => 'Le rapprochement ' . $reconciliation->reference . ' a été annulé.'];
        } catch (Throwable $e) {
            $this->db->trans_rollback();

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

        /* ---------------------------------------------------------------------
     * PRÉVISIONS DE TRÉSORERIE
     * ------------------------------------------------------------------- */

    /** Catégories de prévision par sens de flux. */
    public function getForecastCategories(): array
    {
        return [
            'entree' => [
                'paiement_client'  => 'Paiements clients / décomptes',
                'avance_marche'    => 'Avances de démarrage',
                'retenue_garantie' => 'Libération des retenues de garantie',
                'apport'           => 'Apports des associés',
                'emprunt'          => 'Emprunts / crédits reçus',
                'autre_entree'     => 'Autres entrées',
            ],
            'sortie' => [
                'salaires'              => 'Salaires et charges sociales',
                'fournisseurs'          => 'Fournisseurs (matériaux)',
                'sous_traitance'        => 'Sous-traitance',
                'carburant'             => 'Carburant et entretien des engins',
                'loyer'                 => 'Loyers et charges fixes',
                'impots'                => 'Impôts et taxes',
                'remboursement_emprunt' => 'Remboursements d’emprunts',
                'frais_bancaires'       => 'Frais bancaires',
                'investissement'        => 'Investissements',
                'autre_sortie'          => 'Autres sorties',
            ],
        ];
    }

    /** Date de la n-ième échéance d'une récurrence (le 31 devient le dernier jour du mois). */
    private function forecastShiftDate(string $date, string $recurrence, int $step): string
    {
        $base = new DateTime($date);

        if ($recurrence === 'weekly') {
            return $base->modify('+' . (7 * $step) . ' days')->format('Y-m-d');
        }

        $months = ['monthly' => 1, 'quarterly' => 3, 'yearly' => 12][$recurrence] ?? 0;

        if ($months === 0) {
            return $date;
        }

        $day   = (int) $base->format('j');
        $first = (new DateTime($base->format('Y-m-01')))->modify('+' . ($months * $step) . ' months');

        return $first->format('Y-m-') . str_pad((string) min($day, (int) $first->format('t')), 2, '0', STR_PAD_LEFT);
    }

    /**
     * Crée une prévision (et ses échéances si elle est récurrente).
     * La première échéance est le « parent », les suivantes pointent vers elle.
     */
    public function createTreasuryForecast(array $data): array
    {
        $categories = $this->getForecastCategories();
        $flowType   = (string) ($data['flow_type'] ?? '');
        $category   = (string) ($data['category'] ?? '');

        if (!isset($categories[$flowType][$category])) {
            return ['status' => false, 'message' => 'La catégorie ne correspond pas au type de flux choisi.'];
        }

        $amount = round((float) ($data['amount'] ?? 0), 2);

        if ($amount <= 0) {
            return ['status' => false, 'message' => 'Le montant doit être supérieur à zéro.'];
        }

        $recurrence = in_array($data['recurrence'] ?? 'none', ['none', 'weekly', 'monthly', 'quarterly', 'yearly'], true)
            ? $data['recurrence']
            : 'none';

        $startDate = (string) $data['expected_date'];
        $endDate   = $recurrence !== 'none' ? (string) ($data['recurrence_end_date'] ?? '') : '';

        if ($recurrence !== 'none' && ($endDate === '' || $endDate < $startDate)) {
            return ['status' => false, 'message' => 'La date de fin de récurrence doit être postérieure à la première échéance.'];
        }

        $userId    = !empty($data['created_by']) ? (int) $data['created_by'] : null;
        $accountId = !empty($data['bank_account_id']) ? (int) $data['bank_account_id'] : null;
        $currency  = in_array($data['currency'] ?? '', ['BIF', 'USD', 'EUR'], true) ? $data['currency'] : 'BIF';

        $this->db->trans_begin();

        try {
            if ($accountId) {
                $account = $this->getBankAccountById($accountId);

                if (!$account) {
                    throw new RuntimeException('Le compte bancaire choisi est introuvable.');
                }

                /* La devise vient du compte quand un compte est choisi */
                $currency = $account->currency;
            }

            $base = [
                'flow_type'           => $flowType,
                'category'            => $category,
                'label'               => $data['label'],
                'third_party'         => $this->bankNullable($data['third_party'] ?? null),
                'bank_account_id'     => $accountId,
                'chantier_id'         => !empty($data['chantier_id']) ? (int) $data['chantier_id'] : null,
                'currency'            => $currency,
                'amount'              => $amount,
                'probability'         => max(0, min(100, (int) ($data['probability'] ?? 100))),
                'recurrence'          => $recurrence,
                'recurrence_end_date' => $endDate !== '' ? $endDate : null,
                'observation'         => $this->bankNullable($data['observation'] ?? null),
                'status'              => 'planned',
                'created_by'          => $userId,
            ];

            $dates = [$startDate];

            if ($recurrence !== 'none') {
                for ($step = 1; $step < 60; $step++) {
                    $next = $this->forecastShiftDate($startDate, $recurrence, $step);

                    if ($next > $endDate) {
                        break;
                    }

                    $dates[] = $next;
                }
            }

            $parentId       = null;
            $firstReference = null;

            foreach ($dates as $date) {
                $reference      = $this->bankNextReference('tbl_finance_treasury_forecast', 'PRV', 5, 'reference', true);
                $firstReference = $firstReference ?? $reference;

                $this->db->insert('tbl_finance_treasury_forecast', $base + [
                    'reference'          => $reference,
                    'expected_date'      => $date,
                    'parent_forecast_id' => $parentId,
                ]);

                $insertedId = (int) $this->db->insert_id();

                if ($insertedId <= 0) {
                    throw new RuntimeException('La prévision n’a pas pu être enregistrée.');
                }

                if ($parentId === null) {
                    $parentId = $insertedId;
                }
            }

            if ($this->db->trans_status() === false) {
                throw new RuntimeException('Erreur de base de données pendant l’enregistrement.');
            }

            $this->db->trans_commit();

            return [
                'status'  => true,
                'message' => count($dates) > 1
                    ? count($dates) . ' échéances créées (série ' . $firstReference . ', jusqu’au ' . date('d/m/Y', strtotime(end($dates))) . ').'
                    : 'Prévision ' . $firstReference . ' enregistrée.',
            ];
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', 'Prévision — création : ' . $e->getMessage());

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /** Enregistre la réalisation (totale ou partielle) d'une prévision. */
    public function realizeTreasuryForecast(int $forecastId, float $amount, string $date, ?int $operationId, ?int $userId): array
    {
        $amount = round($amount, 2);

        if ($amount <= 0) {
            return ['status' => false, 'message' => 'Le montant réalisé doit être supérieur à zéro.'];
        }

        $this->db->trans_begin();

        try {
            $forecast = $this->db
                ->query('SELECT * FROM tbl_finance_treasury_forecast WHERE id = ? LIMIT 1 FOR UPDATE', [$forecastId])
                ->row();

            if (!$forecast) {
                throw new RuntimeException('Prévision introuvable.');
            }

            if (!in_array($forecast->status, ['planned', 'partially_realized'], true)) {
                throw new RuntimeException('Cette prévision est déjà réalisée ou annulée.');
            }

            if ($operationId) {
                $operation = $this->db
                    ->where('id', $operationId)
                    ->where('status', 'validated')
                    ->get('tbl_finance_bank_operation')
                    ->row();

                if (!$operation) {
                    throw new RuntimeException('L’opération bancaire choisie est introuvable ou non validée.');
                }

                if ($operation->currency !== $forecast->currency) {
                    throw new RuntimeException('L’opération bancaire n’est pas dans la devise de la prévision.');
                }
            }

            $realized = round((float) $forecast->realized_amount + $amount, 2);
            $status   = $realized + 0.005 >= (float) $forecast->amount ? 'realized' : 'partially_realized';

            $this->db
                ->where('id', $forecastId)
                ->update('tbl_finance_treasury_forecast', [
                    'realized_amount'       => $realized,
                    'realized_date'         => $date,
                    'realized_operation_id' => $operationId ?: $forecast->realized_operation_id,
                    'status'                => $status,
                    'updated_by'            => $userId,
                ]);

            if ($this->db->trans_status() === false) {
                throw new RuntimeException('Erreur de base de données pendant la réalisation.');
            }

            $this->db->trans_commit();

            return [
                'status'  => true,
                'message' => $status === 'realized'
                    ? 'La prévision ' . $forecast->reference . ' est entièrement réalisée.'
                    : 'Réalisation partielle enregistrée : reste '
                    . number_format((float) $forecast->amount - $realized, 0, ',', ' ') . ' ' . $forecast->currency . '.',
            ];
        } catch (Throwable $e) {
            $this->db->trans_rollback();

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Annule une prévision.
     * $withFollowing = true : annule aussi les échéances suivantes non réalisées de la même série.
     */
    public function cancelTreasuryForecast(int $forecastId, string $reason, bool $withFollowing, ?int $userId): array
    {
        $reason = trim($reason);

        if ($reason === '') {
            return ['status' => false, 'message' => 'Le motif d’annulation est obligatoire.'];
        }

        $forecast = $this->db->where('id', $forecastId)->get('tbl_finance_treasury_forecast')->row();

        if (!$forecast) {
            return ['status' => false, 'message' => 'Prévision introuvable.'];
        }

        if ($forecast->status !== 'planned') {
            return ['status' => false, 'message' => 'Seule une prévision non réalisée peut être annulée.'];
        }

        $update = [
            'status'        => 'cancelled',
            'cancelled_by'  => $userId,
            'cancelled_at'  => date('Y-m-d H:i:s'),
            'cancel_reason' => $reason,
        ];

        if ($withFollowing && $forecast->recurrence !== 'none') {
            $rootId = $forecast->parent_forecast_id ? (int) $forecast->parent_forecast_id : (int) $forecast->id;

            $this->db
                ->group_start()
                ->where('id', $rootId)
                ->or_where('parent_forecast_id', $rootId)
                ->group_end()
                ->where('expected_date >=', $forecast->expected_date)
                ->where('status', 'planned')
                ->update('tbl_finance_treasury_forecast', $update);

            $count = $this->db->affected_rows();

            return ['status' => true, 'message' => $count . ' échéance(s) de la série annulée(s).'];
        }

        $this->db->where('id', $forecastId)->update('tbl_finance_treasury_forecast', $update);

        return ['status' => true, 'message' => 'La prévision ' . $forecast->reference . ' a été annulée.'];
    }

    /** Liste des prévisions (filtres : currency, flow_type, status, date_from, date_to). */
    public function getTreasuryForecasts(array $filters = []): array
    {
        $this->db
            ->select("
                f.*,
                a.code AS account_code, a.name AS account_name,
                ch.name AS chantier_name,
                o.reference AS operation_reference
            ", false)
            ->from('tbl_finance_treasury_forecast f')
            ->join('tbl_finance_bank_account a', 'a.id = f.bank_account_id', 'left')
            ->join('chantiers ch', 'ch.id = f.chantier_id', 'left')
            ->join('tbl_finance_bank_operation o', 'o.id = f.realized_operation_id', 'left');

        if (!empty($filters['currency'])) {
            $this->db->where('f.currency', $filters['currency']);
        }

        if (in_array($filters['flow_type'] ?? '', ['entree', 'sortie'], true)) {
            $this->db->where('f.flow_type', $filters['flow_type']);
        }

        if (($filters['status'] ?? '') === 'open') {
            $this->db->where_in('f.status', ['planned', 'partially_realized']);
        } elseif (in_array($filters['status'] ?? '', ['planned', 'partially_realized', 'realized', 'cancelled'], true)) {
            $this->db->where('f.status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $this->db->where('f.expected_date >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $this->db->where('f.expected_date <=', $filters['date_to']);
        }

        return $this->db
            ->order_by('f.expected_date', 'ASC')
            ->order_by('f.id', 'ASC')
            ->limit(500)
            ->get()
            ->result();
    }

    /** Trésorerie disponible aujourd'hui : comptes bancaires + caisses actifs d'une devise. */
    public function getTreasuryStartingPosition(string $currency): array
    {
        $bank = $this->db
            ->query("
                SELECT COALESCE(SUM(current_balance), 0) AS balance,
                       COALESCE(SUM(alert_threshold), 0) AS threshold,
                       COUNT(*) AS items
                FROM tbl_finance_bank_account
                WHERE status = 'active' AND currency = ?
            ", [$currency])
            ->row();

        $cash = $this->db
            ->query("
                SELECT COALESCE(SUM(current_balance), 0) AS balance,
                       COALESCE(SUM(alert_threshold), 0) AS threshold,
                       COUNT(*) AS items
                FROM tbl_finance_cashbox
                WHERE status = 'active' AND devise = ?
            ", [$currency])
            ->row();

        return [
            'bank'            => round((float) $bank->balance, 2),
            'bank_count'      => (int) $bank->items,
            'cash'            => round((float) $cash->balance, 2),
            'cash_count'      => (int) $cash->items,
            'total'           => round((float) $bank->balance + (float) $cash->balance, 2),
            'alert_threshold' => round((float) $bank->threshold + (float) $cash->threshold, 2),
        ];
    }

    /** Périodes du plan : 13 semaines, 6 mois ou 12 mois. */
    private function getTreasuryPeriods(string $horizon): array
    {
        $monthNames = [
            1 => 'Janv.',
            2 => 'Févr.',
            3 => 'Mars',
            4 => 'Avr.',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juil.',
            8 => 'Août',
            9 => 'Sept.',
            10 => 'Oct.',
            11 => 'Nov.',
            12 => 'Déc.'
        ];

        $periods = [];
        $today   = new DateTime('today');

        if ($horizon === '13w') {
            $monday = (clone $today)->modify('monday this week');

            for ($i = 0; $i < 13; $i++) {
                $start = (clone $monday)->modify('+' . (7 * $i) . ' days');
                $end   = (clone $start)->modify('+6 days');

                $periods[] = [
                    'start'    => $start->format('Y-m-d'),
                    'end'      => $end->format('Y-m-d'),
                    'label'    => 'S' . $start->format('W'),
                    'sublabel' => $start->format('d/m') . '–' . $end->format('d/m'),
                ];
            }

            return $periods;
        }

        $count = $horizon === '12m' ? 12 : 6;
        $first = new DateTime($today->format('Y-m-01'));

        for ($i = 0; $i < $count; $i++) {
            $start = (clone $first)->modify('+' . $i . ' months');

            $periods[] = [
                'start'    => $start->format('Y-m-d'),
                'end'      => $start->format('Y-m-t'),
                'label'    => $monthNames[(int) $start->format('n')],
                'sublabel' => $start->format('Y'),
            ];
        }

        return $periods;
    }

    /**
     * Plan de trésorerie.
     * $scenario : 'pondere' (montant × probabilité) ou 'brut' (100 %).
     * Les montants en retard (date passée, non réalisés) sont placés dans la 1re période.
     */
    public function getTreasuryPlan(string $horizon, string $currency, string $scenario, float $opening, float $threshold): array
    {
        $periods    = $this->getTreasuryPeriods($horizon);
        $count      = count($periods);
        $firstStart = $periods[0]['start'];
        $lastEnd    = $periods[$count - 1]['end'];
        $categories = $this->getForecastCategories();

        $rows    = [];
        $overdue = ['count' => 0, 'in' => 0.0, 'out' => 0.0];

        $bucket = function (string $date) use ($periods, $firstStart) {
            if ($date < $firstStart) {
                return 0;
            }

            foreach ($periods as $index => $period) {
                if ($date <= $period['end']) {
                    return $index;
                }
            }

            return null;
        };

        $add = function (string $flow, string $key, string $label, bool $isAuto, string $date, float $amount) use (&$rows, &$overdue, $bucket, $count, $firstStart) {
            $index = $bucket($date);

            if ($index === null || $amount <= 0) {
                return;
            }

            $rowKey = $flow . '|' . $key;

            if (!isset($rows[$rowKey])) {
                $rows[$rowKey] = [
                    'flow'   => $flow,
                    'key'    => $key,
                    'label'  => $label,
                    'auto'   => $isAuto,
                    'values' => array_fill(0, $count, 0.0),
                    'total'  => 0.0,
                ];
            }

            $rows[$rowKey]['values'][$index] += $amount;
            $rows[$rowKey]['total']          += $amount;

            if ($date < $firstStart) {
                $overdue['count']++;
                $overdue[$flow === 'entree' ? 'in' : 'out'] += $amount;
            }
        };

        /* 1. Prévisions saisies (reste à réaliser) */
        $forecasts = $this->db
            ->query("
                SELECT flow_type, category, expected_date, amount, realized_amount, probability
                FROM tbl_finance_treasury_forecast
                WHERE status IN ('planned', 'partially_realized')
                  AND currency = ?
                  AND expected_date <= ?
            ", [$currency, $lastEnd])
            ->result();

        foreach ($forecasts as $forecast) {
            $remaining = max(0, (float) $forecast->amount - (float) $forecast->realized_amount);

            if ($scenario === 'pondere') {
                $remaining *= ((int) $forecast->probability) / 100;
            }

            $label = $categories[$forecast->flow_type][$forecast->category] ?? $forecast->category;
            $add($forecast->flow_type, $forecast->category, $label, false, $forecast->expected_date, round($remaining, 2));
        }

        /* 2. Échéances clients attendues (module Encaissements) */
        if ($this->db->table_exists('tbl_finance_expected_receipt')) {
            $receipts = $this->db
                ->query("
                    SELECT expected_date, expected_amount
                    FROM tbl_finance_expected_receipt
                    WHERE status IN ('pending', 'partial', 'overdue')
                      AND expected_amount > 0
                      AND currency = ?
                      AND expected_date <= ?
                ", [$currency, $lastEnd])
                ->result();

            foreach ($receipts as $receipt) {
                $add('entree', 'auto_receipts', 'Échéances clients attendues', true, $receipt->expected_date, (float) $receipt->expected_amount);
            }
        }

        /* 3. Bons de paiement en attente (achats) — en BIF */
        if ($currency === 'BIF' && $this->db->table_exists('purchase_payment_vouchers')) {
            $vouchers = $this->db
                ->query("
                    SELECT payment_date, amount_paid
                    FROM purchase_payment_vouchers
                    WHERE payment_status = 'en_attente'
                      AND amount_paid > 0
                ")
                ->result();

            foreach ($vouchers as $voucher) {
                $date = !empty($voucher->payment_date) ? substr($voucher->payment_date, 0, 10) : date('Y-m-d');
                $add('sortie', 'auto_vouchers', 'Bons de paiement en attente', true, $date, (float) $voucher->amount_paid);
            }
        }

        /* Ordre d'affichage : catégories saisies puis sources automatiques */
        $ordered = ['entree' => [], 'sortie' => []];

        foreach (['entree', 'sortie'] as $flow) {
            $keys = array_merge(array_keys($categories[$flow]), [$flow === 'entree' ? 'auto_receipts' : 'auto_vouchers']);

            foreach ($keys as $key) {
                if (isset($rows[$flow . '|' . $key])) {
                    $ordered[$flow][] = $rows[$flow . '|' . $key];
                }
            }
        }

        /* Totaux et soldes */
        $totalsIn  = array_fill(0, $count, 0.0);
        $totalsOut = array_fill(0, $count, 0.0);

        foreach ($ordered['entree'] as $row) {
            foreach ($row['values'] as $i => $value) {
                $totalsIn[$i] += $value;
            }
        }

        foreach ($ordered['sortie'] as $row) {
            foreach ($row['values'] as $i => $value) {
                $totalsOut[$i] += $value;
            }
        }

        $openings = [];
        $closings = [];
        $net      = [];
        $balance  = $opening;
        $lowest   = ['amount' => null, 'index' => 0];
        $alerts   = 0;

        for ($i = 0; $i < $count; $i++) {
            $openings[$i] = round($balance, 2);
            $net[$i]      = round($totalsIn[$i] - $totalsOut[$i], 2);
            $balance     += $net[$i];
            $closings[$i] = round($balance, 2);

            if ($lowest['amount'] === null || $closings[$i] < $lowest['amount']) {
                $lowest = ['amount' => $closings[$i], 'index' => $i];
            }

            if ($closings[$i] < $threshold) {
                $alerts++;
            }
        }

        return [
            'periods'      => $periods,
            'rows'         => $ordered,
            'totals_in'    => array_map(function ($v) {
                return round($v, 2);
            }, $totalsIn),
            'totals_out'   => array_map(function ($v) {
                return round($v, 2);
            }, $totalsOut),
            'net'          => $net,
            'openings'     => $openings,
            'closings'     => $closings,
            'total_in'     => round(array_sum($totalsIn), 2),
            'total_out'    => round(array_sum($totalsOut), 2),
            'opening'      => round($opening, 2),
            'closing'      => $count ? $closings[$count - 1] : round($opening, 2),
            'lowest'       => $lowest,
            'threshold'    => round($threshold, 2),
            'alert_count'  => $alerts,
            'overdue'      => $overdue,
        ];
    }

    /** Prévu / réalisé par mois sur les N derniers mois (prévisions saisies). */
    public function getForecastVsActual(string $currency, int $months = 6): array
    {
        $monthNames = [
            1 => 'Janv.',
            2 => 'Févr.',
            3 => 'Mars',
            4 => 'Avr.',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juil.',
            8 => 'Août',
            9 => 'Sept.',
            10 => 'Oct.',
            11 => 'Nov.',
            12 => 'Déc.'
        ];

        $start = date('Y-m-01', strtotime('-' . ($months - 1) . ' months', strtotime(date('Y-m-01'))));

        $rows = $this->db
            ->query("
                SELECT DATE_FORMAT(expected_date, '%Y-%m') AS ym, flow_type,
                       SUM(amount) AS planned, SUM(realized_amount) AS realized
                FROM tbl_finance_treasury_forecast
                WHERE status <> 'cancelled'
                  AND currency = ?
                  AND expected_date BETWEEN ? AND LAST_DAY(CURDATE())
                GROUP BY ym, flow_type
            ", [$currency, $start])
            ->result();

        $indexed = [];

        foreach ($rows as $row) {
            $indexed[$row->ym][$row->flow_type] = [(float) $row->planned, (float) $row->realized];
        }

        $result = [];

        for ($i = 0; $i < $months; $i++) {
            $ts = strtotime('+' . $i . ' months', strtotime($start));
            $ym = date('Y-m', $ts);

            $in  = $indexed[$ym]['entree'] ?? [0, 0];
            $out = $indexed[$ym]['sortie'] ?? [0, 0];

            $result[] = [
                'label'        => $monthNames[(int) date('n', $ts)] . ' ' . date('Y', $ts),
                'in_planned'   => $in[0],
                'in_realized'  => $in[1],
                'in_rate'      => $in[0] > 0 ? round($in[1] / $in[0] * 100, 1) : null,
                'out_planned'  => $out[0],
                'out_realized' => $out[1],
                'out_rate'     => $out[0] > 0 ? round($out[1] / $out[0] * 100, 1) : null,
            ];
        }

        return $result;
    }

    /** Opérations bancaires validées récentes (pour lier une réalisation). */
    public function getRealizableBankOperations(string $currency, int $limit = 80): array
    {
        return $this->db
            ->select('id, reference, operation_type, operation_date, amount, label')
            ->where('status', 'validated')
            ->where('currency', $currency)
            ->where_not_in('operation_type', ['transfert'])
            ->order_by('operation_date', 'DESC')
            ->order_by('id', 'DESC')
            ->limit($limit)
            ->get('tbl_finance_bank_operation')
            ->result();
    }
}
