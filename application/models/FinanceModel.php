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

    public function createCashboxOperation(array $data): array
    {
        $year = (int) date(
            'Y',
            strtotime($data['operation_date'])
        );

        $lockName = 'cashbox_operation_reference_' . $year;

        $this->db->trans_begin();

        try {
            /*
         * Verrou de génération de référence.
         */
            $lockQuery = $this->db->query(
                'SELECT GET_LOCK(?, 10) AS lock_status',
                [$lockName]
            );

            $lockResult = $lockQuery->row();

            if (
                !$lockResult
                || (int) $lockResult->lock_status !== 1
            ) {
                throw new RuntimeException(
                    'Impossible de générer la référence de l’opération.'
                );
            }

            $data['reference'] =
                $this->getNextCashboxOperationReference($year);

            $operationType = $data['operation_type'];
            $amount = (float) $data['amount'];

            if ($amount <= 0) {
                throw new RuntimeException(
                    'Le montant doit être supérieur à zéro.'
                );
            }

            /*
         * ENCAISSEMENT
         */
            if ($operationType === 'encaissement') {
                $destinationId = (int) $data['destination_cashbox_id'];

                $destinationCashbox =
                    $this->getCashboxForUpdate($destinationId);

                if (!$destinationCashbox) {
                    throw new RuntimeException(
                        'La caisse sélectionnée est introuvable.'
                    );
                }

                if ($destinationCashbox->status !== 'active') {
                    throw new RuntimeException(
                        'La caisse sélectionnée n’est pas active.'
                    );
                }

                if ($destinationCashbox->devise !== $data['currency']) {
                    throw new RuntimeException(
                        'La devise de l’opération ne correspond pas à celle de la caisse.'
                    );
                }

                $newBalance =
                    (float) $destinationCashbox->current_balance
                    + $amount;

                $this->db
                    ->where('id', $destinationId)
                    ->update(
                        'tbl_finance_cashbox',
                        [
                            'current_balance' => $newBalance,
                            'updated_at'      => date('Y-m-d H:i:s'),
                        ]
                    );

                $data['source_cashbox_id'] = null;
            }

            /*
         * DÉCAISSEMENT
         */ elseif ($operationType === 'decaissement') {
                $sourceId = (int) $data['source_cashbox_id'];

                $sourceCashbox =
                    $this->getCashboxForUpdate($sourceId);

                if (!$sourceCashbox) {
                    throw new RuntimeException(
                        'La caisse sélectionnée est introuvable.'
                    );
                }

                if ($sourceCashbox->status !== 'active') {
                    throw new RuntimeException(
                        'La caisse sélectionnée n’est pas active.'
                    );
                }

                if ($sourceCashbox->devise !== $data['currency']) {
                    throw new RuntimeException(
                        'La devise de l’opération ne correspond pas à celle de la caisse.'
                    );
                }

                if (
                    (float) $sourceCashbox->current_balance
                    < $amount
                ) {
                    throw new RuntimeException(
                        'Le solde disponible dans la caisse est insuffisant.'
                    );
                }

                $newBalance =
                    (float) $sourceCashbox->current_balance
                    - $amount;

                $this->db
                    ->where('id', $sourceId)
                    ->update(
                        'tbl_finance_cashbox',
                        [
                            'current_balance' => $newBalance,
                            'updated_at'      => date('Y-m-d H:i:s'),
                        ]
                    );

                $data['destination_cashbox_id'] = null;
            }

            /*
         * APPROVISIONNEMENT / TRANSFERT INTERNE
         */ elseif ($operationType === 'approvisionnement') {
                $sourceId = (int) $data['source_cashbox_id'];
                $destinationId =
                    (int) $data['destination_cashbox_id'];

                if ($sourceId === $destinationId) {
                    throw new RuntimeException(
                        'La caisse source et la caisse destination doivent être différentes.'
                    );
                }

                /*
             * On verrouille dans l’ordre croissant des IDs
             * pour réduire le risque d’interblocage.
             */
                $firstId = min($sourceId, $destinationId);
                $secondId = max($sourceId, $destinationId);

                $firstCashbox =
                    $this->getCashboxForUpdate($firstId);

                $secondCashbox =
                    $this->getCashboxForUpdate($secondId);

                if (!$firstCashbox || !$secondCashbox) {
                    throw new RuntimeException(
                        'Une des caisses sélectionnées est introuvable.'
                    );
                }

                $sourceCashbox = $sourceId === $firstId
                    ? $firstCashbox
                    : $secondCashbox;

                $destinationCashbox =
                    $destinationId === $firstId
                    ? $firstCashbox
                    : $secondCashbox;

                if (
                    $sourceCashbox->status !== 'active'
                    || $destinationCashbox->status !== 'active'
                ) {
                    throw new RuntimeException(
                        'Les deux caisses doivent être actives.'
                    );
                }

                if (
                    $sourceCashbox->devise
                    !== $destinationCashbox->devise
                ) {
                    throw new RuntimeException(
                        'Le transfert ne peut pas être effectué entre deux caisses de devises différentes.'
                    );
                }

                if (
                    $sourceCashbox->devise
                    !== $data['currency']
                ) {
                    throw new RuntimeException(
                        'La devise de l’opération est incorrecte.'
                    );
                }

                if (
                    (float) $sourceCashbox->current_balance
                    < $amount
                ) {
                    throw new RuntimeException(
                        'Le solde de la caisse source est insuffisant.'
                    );
                }

                $newSourceBalance =
                    (float) $sourceCashbox->current_balance
                    - $amount;

                $newDestinationBalance =
                    (float) $destinationCashbox->current_balance
                    + $amount;

                $this->db
                    ->where('id', $sourceId)
                    ->update(
                        'tbl_finance_cashbox',
                        [
                            'current_balance' => $newSourceBalance,
                            'updated_at'      => date('Y-m-d H:i:s'),
                        ]
                    );

                $this->db
                    ->where('id', $destinationId)
                    ->update(
                        'tbl_finance_cashbox',
                        [
                            'current_balance' =>
                            $newDestinationBalance,

                            'updated_at' =>
                            date('Y-m-d H:i:s'),
                        ]
                    );
            } else {
                throw new RuntimeException(
                    'Type d’opération invalide.'
                );
            }

            /*
         * Insertion du mouvement.
         */
            $this->db->insert(
                'tbl_finance_cashbox_operation',
                $data
            );

            if ($this->db->affected_rows() !== 1) {
                throw new RuntimeException(
                    'L’opération n’a pas pu être enregistrée.'
                );
            }

            $operationId = $this->db->insert_id();

            $this->db->query(
                'SELECT RELEASE_LOCK(?)',
                [$lockName]
            );

            if ($this->db->trans_status() === false) {
                throw new RuntimeException(
                    'Erreur pendant la transaction.'
                );
            }

            $this->db->trans_commit();

            return [
                'status'    => true,
                'id'        => $operationId,
                'reference' => $data['reference'],
            ];
        } catch (Throwable $exception) {
            $this->db->trans_rollback();

            $this->db->query(
                'SELECT RELEASE_LOCK(?)',
                [$lockName]
            );

            log_message(
                'error',
                'Erreur opération caisse : '
                    . $exception->getMessage()
            );

            return [
                'status'  => false,
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
    public function getCashFlowEvolution(string $period = '7days'): array
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
     * RÉCUPÉRATION DES MOUVEMENTS AGRÉGÉS
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

        FROM tbl_finance_cashbox_operation

        WHERE status = 'validated'

        AND operation_type IN (
            'encaissement',
            'decaissement'
        )

        AND operation_date BETWEEN ? AND ?

        GROUP BY
            DATE_FORMAT(
                operation_date,
                ?
            )

        ORDER BY period_key ASC
    ";

        $queryResults = $this->db
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
     * Indexer les résultats par date ou par mois.
     */
        $indexedResults = [];

        foreach ($queryResults as $row) {
            $indexedResults[$row->period_key] = [
                'income'  => (float) $row->total_income,
                'expense' => (float) $row->total_expense,
            ];
        }

        $labels = [];
        $incomes = [];
        $expenses = [];

        /*
     * =========================================================
     * PÉRIODE ANNUELLE : UN POINT PAR MOIS
     * =========================================================
     */
        if ($period === 'year') {
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

                $incomes[] = isset($indexedResults[$key])
                    ? $indexedResults[$key]['income']
                    : 0;

                $expenses[] = isset($indexedResults[$key])
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

                $incomes[] = isset($indexedResults[$key])
                    ? $indexedResults[$key]['income']
                    : 0;

                $expenses[] = isset($indexedResults[$key])
                    ? $indexedResults[$key]['expense']
                    : 0;
            }
        }

        return [
            'period'     => $period,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'labels'     => $labels,
            'incomes'    => $incomes,
            'expenses'   => $expenses,
        ];
    }

    /**
     * Retourne les alertes dynamiques de trésorerie.
     *
     * Types d’alertes :
     * - solde critique ;
     * - opération en attente ;
     * - justificatif manquant.
     */
    public function getTreasuryAlerts(int $limit = 8): array
    {
        $limit = max(
            1,
            min(
                $limit,
                30
            )
        );

        $alerts = [];

        /*
     * =========================================================
     * 1. CAISSES AVEC SOLDE CRITIQUE
     * =========================================================
     */

        $criticalCashboxes = $this->db
            ->select([
                'c.id',
                'c.code',
                'c.name',
                'c.type',
                'c.devise',
                'c.current_balance',
                'c.alert_threshold',
                'ch.name AS chantier_name',
            ])
            ->from('tbl_finance_cashbox c')
            ->join(
                'chantiers ch',
                'ch.id = c.chantier_id',
                'left'
            )
            ->where('c.status', 'active')
            ->where('c.alert_threshold >', 0)
            ->where(
                'c.current_balance <= c.alert_threshold',
                null,
                false
            )
            ->order_by('c.current_balance', 'ASC')
            ->get()
            ->result();

        foreach ($criticalCashboxes as $cashbox) {
            $displayName = !empty($cashbox->chantier_name)
                ? $cashbox->chantier_name
                : $cashbox->name;

            $alerts[] = [
                'type'       => 'danger',
                'icon'       => 'fas fa-wallet',
                'title'      => 'Solde critique — ' . $displayName,
                'message'    =>
                'Le solde disponible de '
                    . number_format(
                        (float) $cashbox->current_balance,
                        0,
                        ',',
                        ' '
                    )
                    . ' '
                    . $cashbox->devise
                    . ' est inférieur ou égal au seuil de '
                    . number_format(
                        (float) $cashbox->alert_threshold,
                        0,
                        ',',
                        ' '
                    )
                    . ' '
                    . $cashbox->devise
                    . '.',

                'priority'   => 1,
                'created_at' => null,
            ];
        }

        /*
     * =========================================================
     * 2. OPÉRATIONS EN ATTENTE
     * =========================================================
     */

        $pendingOperations = $this->db
            ->select([
                'op.id',
                'op.reference',
                'op.operation_type',
                'op.amount',
                'op.currency',
                'op.label',
                'op.created_at',
                'source.name AS source_name',
                'destination.name AS destination_name',
            ])
            ->from('tbl_finance_cashbox_operation op')
            ->join(
                'tbl_finance_cashbox source',
                'source.id = op.source_cashbox_id',
                'left'
            )
            ->join(
                'tbl_finance_cashbox destination',
                'destination.id = op.destination_cashbox_id',
                'left'
            )
            ->where('op.status', 'pending')
            ->order_by('op.created_at', 'ASC')
            ->limit(5)
            ->get()
            ->result();

        foreach ($pendingOperations as $operation) {
            $operationLabel = 'Opération en attente';

            if (
                $operation->operation_type
                === 'approvisionnement'
            ) {
                $operationLabel =
                    'Approvisionnement en attente';
            } elseif (
                $operation->operation_type
                === 'encaissement'
            ) {
                $operationLabel =
                    'Encaissement en attente';
            } elseif (
                $operation->operation_type
                === 'decaissement'
            ) {
                $operationLabel =
                    'Décaissement en attente';
            }

            $message = $operation->reference
                . ' — '
                . number_format(
                    (float) $operation->amount,
                    0,
                    ',',
                    ' '
                )
                . ' '
                . $operation->currency;

            if (
                $operation->operation_type
                === 'approvisionnement'
                && !empty($operation->destination_name)
            ) {
                $message .=
                    ' vers '
                    . $operation->destination_name;
            }

            $alerts[] = [
                'type'       => 'warning',
                'icon'       => 'fas fa-clock',
                'title'      => $operationLabel,
                'message'    => $message
                    . ' attend une validation.',

                'priority'   => 2,
                'created_at' => $operation->created_at,
            ];
        }

        /*
     * =========================================================
     * 3. DÉCAISSEMENTS SANS JUSTIFICATIF
     * =========================================================
     */

        $missingAttachments = $this->db
            ->select([
                'op.id',
                'op.reference',
                'op.amount',
                'op.currency',
                'op.category',
                'op.third_party',
                'op.created_at',
                'c.name AS cashbox_name',
            ])
            ->from('tbl_finance_cashbox_operation op')
            ->join(
                'tbl_finance_cashbox c',
                'c.id = op.source_cashbox_id',
                'left'
            )
            ->where(
                'op.operation_type',
                'decaissement'
            )
            ->where(
                'op.status',
                'validated'
            )
            ->group_start()
            ->where(
                'op.attachment IS NULL',
                null,
                false
            )
            ->or_where(
                'op.attachment',
                ''
            )
            ->group_end()
            ->order_by('op.amount', 'DESC')
            ->limit(5)
            ->get()
            ->result();

        foreach ($missingAttachments as $operation) {
            $alerts[] = [
                'type'  => 'info',
                'icon'  => 'fas fa-file-alt',
                'title' => 'Justificatif manquant',

                'message' =>
                'Le décaissement '
                    . $operation->reference
                    . ' de '
                    . number_format(
                        (float) $operation->amount,
                        0,
                        ',',
                        ' '
                    )
                    . ' '
                    . $operation->currency
                    . ' dans '
                    . (
                        $operation->cashbox_name
                        ?: 'une caisse'
                    )
                    . ' ne possède pas de pièce justificative.',

                'priority'   => 3,
                'created_at' => $operation->created_at,
            ];
        }

        /*
     * Trier les alertes :
     * danger, warning, puis information.
     */
        usort(
            $alerts,
            function (
                array $firstAlert,
                array $secondAlert
            ): int {
                return $firstAlert['priority']
                    <=> $secondAlert['priority'];
            }
        );

        return array_slice(
            $alerts,
            0,
            $limit
        );
    }

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
    public function getAllActiveCashboxes(): array
    {
        return $this->db
            ->select([
                'id',
                'code',
                'name',
                'type',
                'chantier_id',
                'responsable',
                'devise',
                'opening_balance',
                'current_balance',
                'alert_threshold',
                'observation',
                'status',
                'created_by',
                'created_at',
                'updated_at',
            ])
            ->from('tbl_finance_cashbox')
            ->where('status', 'active')
            ->order_by(
                "
            CASE
                WHEN type = 'siege' THEN 0
                WHEN type = 'chantier' THEN 1
                ELSE 2
            END
            ",
                '',
                false
            )
            ->order_by('name', 'ASC')
            ->get()
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
}
