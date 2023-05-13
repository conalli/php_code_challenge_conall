<?php

declare(strict_types=1);

class FinalResult {
    function __construct(
        private readonly int $record_length = 16,
        private readonly int $bank_code_idx = 0,
        private readonly int $branch_code_idx = 2,
        private readonly int $account_number_idx = 6,
        private readonly int $account_name_idx = 7,
        private readonly int $amount_idx = 8,
        private readonly int $e2e_id_1_idx = 10,
        private readonly int $e2e_id_2_idx = 11,
    ) {
    }

    function results(string $filename) {
        if (!file_exists($filename)) {
            throw new Exception("results file does not exist");
        }
        $file = fopen($filename, "r");
        if ($file === false) {
            throw new Exception("could not open results file");
        }
        [$currency, $failure_code, $failure_message] = fgetcsv($file);
        $records = [];
        while (!feof($file)) {
            $record = fgetcsv($file);
            if (count($record) === $this->record_length) {
                $amount = !$record[$this->amount_idx] || $record[$this->amount_idx] === "0" ? 0 : (float) $record[$this->amount_idx];
                $account_number = !$record[$this->account_number_idx] ? "Bank account number missing" : (int) $record[$this->account_number_idx];
                $branch_code = !$record[$this->branch_code_idx] ? "Bank branch code missing" : $record[$this->branch_code_idx];
                $e2e_id = !$record[$this->e2e_id_1_idx] && !$record[$this->e2e_id_2_idx] ? "End to end id missing" : $record[$this->e2e_id_1_idx] . $record[$this->e2e_id_2_idx];
                $records[] = [
                    "amount" => [
                        "currency" => $currency,
                        "subunits" => (int) ($amount * 100)
                    ],
                    "bank_account_name" => str_replace(" ", "_", strtolower($record[$this->account_name_idx])),
                    "bank_account_number" => $account_number,
                    "bank_branch_code" => $branch_code,
                    "bank_code" => $record[$this->bank_code_idx],
                    "end_to_end_id" => $e2e_id,
                ];
            }
        }
        fclose($file);
        return [
            "filename" => basename($filename),
            "failure_code" => $failure_code,
            "failure_message" => $failure_message,
            "records" => $records
        ];
    }
}
