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
}
