<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Générateur minimal de fichiers Excel .xlsx (sans dépendance externe).
 * Types de colonnes : 'string', 'int', 'decimal', 'money', 'date'
 */
class Simple_xlsx
{
    private $sheets = [];

    public function __construct($params = []) {}

    /**
     * @param string $name    Nom de l'onglet (31 caractères max)
     * @param array  $headers Libellés des colonnes
     * @param array  $rows    Lignes (tableaux indexés dans l'ordre des colonnes)
     * @param array  $types   Type par colonne
     * @param array  $widths  Largeur par colonne
     * @param array  $totals  Index des colonnes à totaliser (ligne de total en bas)
     */
    public function addSheet($name, array $headers, array $rows, array $types = [], array $widths = [], array $totals = [])
    {
        $name = mb_substr(preg_replace('/[\\\\\/\?\*\[\]:]/', ' ', $name), 0, 31);
        $this->sheets[] = compact('name', 'headers', 'rows', 'types', 'widths', 'totals');
        return $this;
    }

    public function download($filename)
    {
        if (!class_exists('ZipArchive')) {
            show_error('L\'extension PHP « zip » est nécessaire pour l\'export Excel (activer extension=zip dans php.ini).', 500);
        }

        $n = count($this->sheets);
        $parts = [
            '[Content_Types].xml'        => $this->contentTypes($n),
            '_rels/.rels'                => $this->rootRels(),
            'xl/workbook.xml'            => $this->workbook(),
            'xl/_rels/workbook.xml.rels' => $this->workbookRels($n),
            'xl/styles.xml'              => $this->styles(),
        ];
        foreach ($this->sheets as $i => $sheet) {
            $parts['xl/worksheets/sheet' . ($i + 1) . '.xml'] = $this->sheetXml($sheet);
        }

        $tmp = tempnam(sys_get_temp_dir(), 'xlsx');
        $zip = new ZipArchive();
        $zip->open($tmp, ZipArchive::OVERWRITE);
        foreach ($parts as $path => $xml) {
            // La déclaration <?xml doit être le tout premier caractère :
            // on retire tout espace / saut de ligne ajouté par un formateur de code.
            $zip->addFromString($path, trim($xml));
        }
        $zip->close();

        // Vide tout tampon de sortie (espaces, BOM, warnings) pour ne pas corrompre le fichier
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($tmp));
        header('Cache-Control: max-age=0');
        readfile($tmp);
        unlink($tmp);
    }

    /* ---------------- Parties du fichier ---------------- */

    private function contentTypes($n)
    {
        $sheets = '';
        for ($i = 1; $i <= $n; $i++) {
            $sheets .= '<Override PartName="/xl/worksheets/sheet' . $i . '.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
        }
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml" />'
            . '
    <Default Extension="xml" ContentType="application/xml" />'
            . '
    <Override PartName="/xl/workbook.xml"
        ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml" />'
            . '
    <Override PartName="/xl/styles.xml"
        ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml" />'
            . $sheets . '
</Types>';
    }

    private function rootRels()
    {
        return '
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument"
        Target="xl/workbook.xml" />'
            . '
</Relationships>';
    }

    private function workbook()
    {
        $sheets = '';
        foreach ($this->sheets as $i => $s) {
            $sheets .= '
<sheet name="' . $this->esc($s['name']) . '" sheetId="' . ($i + 1) . '" r:id="rId' . ($i + 1) . '" />';
        }
        return '
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . ' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets>' . $sheets . '</sheets>
</workbook>';
    }

    private function workbookRels($n)
    {
        $rels = '';
        for ($i = 1; $i <= $n; $i++) {
            $rels .= '<Relationship Id="rId' . $i
                . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet'
                . $i . '.xml"/>';
        }
        $rels .= '<Relationship Id="rId' . ($n + 1)
            . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>';
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' . $rels
            . '</Relationships>';
    }
    /** * Styles : 0 normal · 1 en-tête · 2 montant · 3 date · 4 décimal · 5 total montant */
    private function styles()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<numFmts count="2"><numFmt numFmtId="164" formatCode="#,##0"/><numFmt numFmtId="165" formatCode="#,##0.##"/></numFmts>'
            . '<fonts count="3">' . '<font><sz val="11"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><name val="Calibri"/></font>' . '</fonts>' . '<fills count="4">'
            . '<fill><patternFill patternType="none"/></fill>' . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FF0F766E"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFE7F4EA"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>' . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="6">' . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1"/>'
            . '<xf numFmtId="164" fontId="0" fillId="0" borderId="0" xfId="0" applyNumberFormat="1"/>'
            . '<xf numFmtId="14" fontId="0" fillId="0" borderId="0" xfId="0" applyNumberFormat="1"/>'
            . '<xf numFmtId="165" fontId="0" fillId="0" borderId="0" xfId="0" applyNumberFormat="1"/>'
            . '<xf numFmtId="164" fontId="2" fillId="3" borderId="0" xfId="0" applyNumberFormat="1" applyFont="1" applyFill="1"/>'
            . '</cellXfs>' . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
    }
    private function sheetXml(array $s)
    {
        $nbCols = count($s['headers']);
        $lastCol = $this->col($nbCols - 1);

        $cols = '';
        foreach ($s['headers'] as $i => $h) {
            $w = $s['widths'][$i] ?? 16;
            $cols .= '
    <col min="' . ($i + 1) . '" max="' . ($i + 1) . '" width="' . $w . '" customWidth="1" />';
        }

        // En-tête
        $xml = '<row r="1">';
        foreach ($s['headers'] as $i => $h) {
            $xml .= '<c r="' . $this->col($i) . '1" t="inlineStr" s="1">
            <is>
                <t>' . $this->esc($h) . '</t>
            </is>
        </c>';
        }
        $xml .= '</row>';

        // Données
        $r = 1;
        foreach ($s['rows'] as $row) {
            $r++;
            $xml .= '<row r="' . $r . '">';
            foreach (array_values($row) as $i => $val) {
                $xml .= $this->cell($this->col($i) . $r, $val, $s['types'][$i] ?? 'string');
            }
            $xml .= '</row>';
        }
        $lastData = $r;

        // Ligne de totaux
        if ($s['totals'] && $lastData >= 2) {
            $r++;
            $xml .= '<row r="' . $r . '">';
            $xml .= '<c r="A' . $r . '" t="inlineStr" s="5">
            <is>
                <t>TOTAL</t>
            </is>
        </c>';
            foreach ($s['totals'] as $i) {
                $c = $this->col($i);
                $xml .= '<c r="' . $c . $r . '" s="5">
            <f>SUM(' . $c . '2:' . $c . $lastData . ')</f>
        </c>';
            }
            $xml .= '</row>';
        }

        return '
    <?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . ' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheetViews>
            <sheetView workbookViewId="0">
                <pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen" />
            </sheetView>
        </sheetViews>'
            . '<cols>' . $cols . '</cols>'
            . '<sheetData>' . $xml . '</sheetData>'
            . ($lastData >= 2 ? '
        <autoFilter ref="A1:' . $lastCol . $lastData . '" />' : '')
            . '
    </worksheet>';
    }

    private function cell($ref, $val, $type)
    {
        if ($val === null || $val === '') return '';

        switch ($type) {
            case 'int':
                return '<c r="' . $ref . '">
        <v>' . (int) $val . '</v>
    </c>';
            case 'money':
                return '<c r="' . $ref . '" s="2">
        <v>' . (float) $val . '</v>
    </c>';
            case 'decimal':
                return '<c r="' . $ref . '" s="4">
        <v>' . (float) $val . '</v>
    </c>';
            case 'date':
                $d = DateTime::createFromFormat('Y-m-d', substr((string) $val, 0, 10), new DateTimeZone('UTC'));
                if (!$d) break;
                $d->setTime(0, 0);
                $serial = $d->getTimestamp() / 86400 + 25569;
                return '<c r="' . $ref . '" s="3">
        <v>' . $serial . '</v>
    </c>';
        }
        return '<c r="' . $ref . '" t="inlineStr">
        <is>
            <t xml:space="preserve">' . $this->esc((string) $val) . '</t>
        </is>
    </c>';
    }

    private function col($i)
    {
        $s = '';
        $i++;
        while ($i > 0) {
            $m = ($i - 1) % 26;
            $s = chr(65 + $m) . $s;
            $i = intdiv($i - 1, 26);
        }
        return $s;
    }

    private function esc($s)
    {
        $s = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}]/u', '', (string) $s);
        return htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
