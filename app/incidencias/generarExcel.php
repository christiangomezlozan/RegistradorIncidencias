<?php 

    require '../config/database.php';
    require '../../excel/vendor/autoload.php';
    require 'getEstadoInc.php';
    require 'obtenerTipologia.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use \PhpOffice\PhpSpreadsheet\IOFactory;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {

            $sql = "SELECT gdia, estado_gdia, ventanilla, estado_vent, tipologia, incidencia, info_adicional FROM incidencias";
            $incExcel = $conexion->query($sql);

            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setCreator("Christian Gomez")->setTitle("Incidencias"); // Metadatos de la hoja excel

            $hoja = $spreadsheet->getActiveSheet();

            $hoja->getColumnDimension('A')->setWidth(10);
            $hoja->setCellValue('A1', 'GDIA');
            $hoja->getColumnDimension('B')->setWidth(10);
            $hoja->setCellValue('B1', 'ESTADO_GDIA');
            $hoja->getColumnDimension('C')->setWidth(10);
            $hoja->setCellValue('C1', 'VENATNILLA');
            $hoja->getColumnDimension('D')->setWidth(10);
            $hoja->setCellValue('D1', 'ESTADO_VENT');
            $hoja->getColumnDimension('E')->setWidth(10);
            $hoja->setCellValue('E1', 'TIPOLOGIA');
            $hoja->getColumnDimension('F')->setWidth(10);
            $hoja->setCellValue('F1', 'INCIDENCIA');
            $hoja->getColumnDimension('G')->setWidth(30);
            $hoja->setCellValue('G1', 'INFO_ADICIONAL');

            $fila = 2;
            while($inc = $incExcel->fetch_assoc()){ 
                $hoja->setCellValue('A' . $fila, $inc['gdia']);
                $hoja->setCellValue('B' . $fila, obtenerEstadoInc($inc['estado_gdia']));
                $hoja->setCellValue('C' . $fila, $inc['ventanilla']);        
                $hoja->setCellValue('D' . $fila, obtenerEstadoInc($inc['estado_vent']));
                $hoja->setCellValue('E' . $fila, obtenerTipologia($inc['tipologia']));
                $hoja->setCellValue('F' . $fila, $inc['incidencia']); 
                $hoja->setCellValue('G' . $fila, $inc['info_adicional']);
                $fila++;
            }

            // $writer = new Xlsx($spreadsheet); Otro método para crear en archivo $writer
            $nombreArchivo = 'Incidencias.xlsx';

            /*
            Si se quiere almacenar el archivo en local
            $rutaArchivo = '../../excel/' . $nombreArchivo;
            $writer->save($rutaArchivo);
            
            */

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $nombreArchivo .'"');
            header('Cache-Control: max-age=0');
            
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output'); // readfile($rutaArchivo) -> Si se quiere almacenar el archivo y que se guarde a la vez
            exit;

        } catch (Exception $e) {
            die("Error al generar el archivo: " . $e->getMessage());
        }
    }

    header('Location:index.php');

?>