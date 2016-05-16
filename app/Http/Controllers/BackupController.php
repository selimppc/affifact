<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BackupController extends Controller
{
    public static function file_zip($source, $destination)
    {
        if ( ! extension_loaded('zip') || ! file_exists($source)) return false;

        $zip = new ZipArchive();

        if ( ! $zip->open($destination, ZIPARCHIVE::CREATE)) return false;

        $source = str_replace('', '/', realpath($source));

        if (is_dir($source) === true)
        {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file)
            {
                $file = str_replace('', '/', $file);
                $file = realpath($file);
                if (is_dir($file) === true)
                {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                } else if (is_file($file) === true)
                {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        } else if (is_file($source) === true)
        {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

#$file_name = 'files-backup-' . date("d-m-y-h-i-s-A") . '.zip';
// Nom du fichier zip contenant tous les fichiers Zip('<span style="color: #ff0000;">pathtowebsite</span>', 'folder_backup_zip' .$file_name)
// // Ne pas oublier de changer les valeurs



    public function db_back_up(){
        $query = $this->database_backup('localhost', 'root', 'root1234', 'affifact');
        exit("Success!");
    }


    protected static function database_backup($host, $user, $pass, $name, $tables = '*')
    {
            $link = mysqli_connect($host, $user, $pass);
            mysqli_select_db($link, $name);
            if ($tables == '*')
            {
                $tables = [];
                $result = mysqli_query($link, 'SHOW TABLES');
                while ($row = mysqli_fetch_row($result))
                {
                    $tables[] = $row[0];
                }
            } else
            {
                $tables = is_array($tables) ? $tables : explode(',', $tables);
            }

            $return = null;
            foreach ($tables as $table)
            {
                $result = mysqli_query($link, 'SELECT * FROM ' . $table);
                $num_fields = mysqli_num_fields($result);

                $return .= 'DROP TABLE ' . $table . ';';
                $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE ' . $table));
                $return .= "\r\n" . $row2[1] . ";\r\n";

                for ($i = 0; $i < $num_fields; $i ++)
                {
                    while ($row = mysqli_fetch_row($result))
                    {
                        $return .= 'INSERT INTO ' . $table . ' VALUES(';
                        for ($j = 0; $j < $num_fields; $j ++)
                        {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = mb_ereg_replace("n", "n", $row[$j]);
                            if (isset($row[$j]))
                            {
                                $return .= '"' . $row[$j] . '"';
                            } else
                            {
                                $return .= '""';
                            }
                            if ($j < ($num_fields - 1))
                            {
                                $return .= ',';
                            }
                        }
                        $return .= ");\r\n";
                    }
                }
                $return .= "\r\n";



            }

            $file_name = 'db-backup-' . date("d-m-y-h-i-s-A") . '.sql';
            $handle = fopen("/tmp/db_backup/" . $file_name, 'w+');
            fwrite($handle, $return);
            fclose($handle);
    }

}
