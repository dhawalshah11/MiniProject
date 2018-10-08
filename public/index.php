<?php
/**
 * Created by PhpStorm.
 * User: dhawal
 * Date: 10/5/18
 * Time: 2:03 AM
 */



main::start("WA_Retail-SalesMarketing_-ProfitCost.csv");

class main
{
    static public function start($filename)
    {
        $d = csv::getdata($filename);
        $tables = html::createTable($d);
        system::printPage($tables);
    }
}

class html
{
    public static function createTable($d)
    {
        $table = '<table border="1">';
        $table .= row::tableRow($d);
        $table .= '</table>';
        return $table;
    }
}


class row
{
    public  static function tableRow($d)
    {
        $i=0;
        $flag = true;
        $table = "";
        foreach ($d as $key => $value) {
            $table .= "<tr class= \"<?=($i++%2==1) ? 'odd'  : ''; ?>\">";
            foreach ($value as $key2 => $value2) {
                if($flag){
                    $table .= "<th>".htmlspecialchars($value2)."</th>";

                }else{
                    $table .= '<td>' . htmlspecialchars($value2) . '</td>';
                }
            }
            $flag = false;
            $table .= "</tr>";
        }

        return $table;

    }
}

class tableFactory
{

    public static function build(Array $row = null, Array $values  = null)
    {

        $table =new table($row , $values);

        return $table;

    }

}

class csv
{
    public static function getdata($filename)
    {

        $file = fopen($filename,"r");
        $fieldNames = array();
        $count = 0;

        while(! feof($file))
        {
            $record=fgetcsv($file);

            if($count==0) {

                $fieldNames = $record;
                $d[] = recordFactory::create($fieldNames, $fieldNames);
            }
            else {
                $d[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }

        fclose($file);

        return $d;

    }
}

class record{

    public function __construct(Array $fieldNames = null , $values = null){

        $record = array_combine($fieldNames, $values);

        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }
    public function ReturnArray(){

        $array= (array) $this;

        return $array;
    }

    public function createProperty($name = 'Year', $value = '2004')
    {
        $this->{$name} = $value;
    }

}
class recordFactory{

    public static function create(Array $fieldnames = null, Array $values  = null)
    {

        $record=new record($fieldnames , $values);

        return $record;

    }

}
class system{

    public static function printPage($page){

        echo $page;
    }

}
;
