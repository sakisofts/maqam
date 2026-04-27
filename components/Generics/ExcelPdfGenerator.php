<?php

namespace app\components\Generics;
use Mpdf\Mpdf;
use yii\base\Component;


class ExcelPdfGenerator extends Component
{
    public static function generatePdf($model, $options = []) {
        try {
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 25,
                'margin_bottom' => 25,
                'margin_header' => 10,
                'margin_footer' => 10
            ]);
            // Set page header and footer  if options are provided
            if(isset($options['header'])) {
                $mpdf->SetHeader($options['header']);
            }
            //set footer with page number
            $footerText = isset($options['footer']) ? $options['footer'] : 'Page {PAGENO}';
            $mpdf->SetFooter($footerText);

            // building HTML content
            $html = '<html><head>';
            $html .= '<style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 15px 0;
                    background-color: #fff;
                }
                th, td {
                    padding: 12px;
                    text-align: left;
                }
                th {
                    background-color: #000;
                    color: white;
                    font-weight: bold;
                }
                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                tr:hover {
                    background-color: #ddd;
                }
                .report-title {
                    text-align: left;
                    font-size: 18px;
                    font-weight: bold;
                    margin-bottom: 6px;
                    color: #333;
                }
                .report-subtitle {
                    text-align: left;
                    font-size: 14px;
                    margin-bottom: 15px;
                    color: #666;
                }
            </style>';
            $html .= '</head><body>';

            // Add title and subtitle if provided
            if (isset($options['title'])) {
                $html .= '<div class="report-title">' . htmlspecialchars($options['title']) . '</div>';
            }
            if (isset($options['subtitle'])) {
                $html .= '<div class="report-subtitle">' . htmlspecialchars($options['subtitle']) . '</div>';
            }

            // Get model attributes and data
            $attributes = $model->exportColumns();
            $data = $model->getData();


            // Create table
            $html .= '<table>';

            $html .= '<tr>';
            foreach ($attributes as $key => $headerInfo) {
                $header = is_array($headerInfo) ? $headerInfo['label'] : $headerInfo;
                $html .= '<th>' . htmlspecialchars($header) . '</th>';
            }
            $html .= '</tr>';

            // Data rows
            foreach ($data as $row) {
                $html .= '<tr>';
                foreach ($attributes as $key => $header) {
                    if (is_array($header) && isset($header['format']) && is_callable($header['format'])) {
                        $value = $header['format']($row[$key]);
                    } else {
                        $value = $row[$key];
                    }
                    $html .= '<td style="text-transform:capitalize;">' . htmlspecialchars($value) . '</td>';
                }
                $html .= '</tr>';
            }

            $html .= '</table>';
            $html .= '</body></html>';

            // Write HTML to PDF
            $mpdf->WriteHTML($html);

            // Output PDF
            $filename = (isset($options['filename']) ? $options['filename'] : 'export') . '_' . date('Y-m-d_H-i-s') . '.pdf';
            $mpdf->Output($filename, 'D');

        } catch (\Exception $e) {
            throw new \Exception('Error generating PDF: ' . $e->getMessage());
        }
    }
}
