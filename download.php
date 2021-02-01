<?php 
            $file    ="berkas/template.xls";
            header('Content-Description: File Transfer');
            header('Content-Type: application/xls');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: private');
            header('Pragma: private');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file); 


?>