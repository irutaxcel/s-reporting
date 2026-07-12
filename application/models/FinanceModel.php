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
}
