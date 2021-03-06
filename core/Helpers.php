<?php 
require_once("enable_errors.php");
require_once("Request.php");


/**
 * Class the contains some useful functions
 * as the name indicates i.e "Helpers".
 */


class Helpers {

    /**    
     * Simple function that redirect the user to a page 
     * given the link. 
     *
     * @param string $url : the url to be redirected to.
     *
     */
    public static function redirect(string $url, $statusCode = 303)

	{
	   header('Location: ' . $url, true, $statusCode);
	   die();
	}


    public static function RandomString($length = 8) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
        
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomString;
    }


    /**
     * This function displays a table fields and contents
     * given the tablename. 
     *
     * @param string $table_name : the name of the table to be displayed.
     */
	public static function show_data(string $table_name) {


			$columns_query = "SHOW columns FROM ".$table_name.";";

			$query = "SELECT * FROM ".$table_name.";";

			$columns = Request::execute($columns_query);

			$columns_names = array();

				echo "<table border=\"1\">";

				echo "<tr>";

			for ($i = 0; $i < count($columns); $i++) {

				array_push($columns_names, $columns[$i]['Field']);

				echo "<th>".$columns[$i]['Field']."</th>";
			}

				echo "</tr>";


			$data = Request::execute($query);


			for ($i = 0; $i < count($data); $i++) {

				echo "<tr>";

				for ($j = 0; $j < count($columns_names); $j++) {

					echo "<td>".$data[$i][$columns_names[$j]]."</td>";
				} 

				echo "</tr>";

			}

			echo "</table>";


	}




    /**
     * Replaces a string in a file
     *
     * @param string $FilePath
     * @param string $OldText text to be replaced
     * @param string $NewText new text
     * @return array $Result status (success | error) & message (file exist, file permissions)
     */
    public static function replace_in_file($FilePath, $OldText, $NewText)
    {

        $Result = array('status' => 'error', 'message' => '');

        if(file_exists($FilePath)== true)
        {

            if(is_writeable($FilePath))
            {

                try
                {
                    $FileContent = file_get_contents($FilePath);
                    $FileContent = str_replace($OldText, $NewText, $FileContent);

                    if(file_put_contents($FilePath, $FileContent) > 0)
                    {
                        $Result["status"] = 'success';
                    }
                    else
                    {
                       $Result["message"] = 'Error while writing file';
                    }
                }
                catch(Exception $e)
                {
                    $Result["message"] = 'Error : '.$e;
                }
            }
            else
            {
                $Result["message"] = 'File '.$FilePath.' is not writable !';
            }
        }
        else
        {
            $Result["message"] = 'File '.$FilePath.' does not exist !';
        }
        return $Result;
    }

    public static function match($key,$keys)
    {

        $matched = false;

        for ($i=0; $i < count($keys); $i++)
        { 
            if($key == $keys[$i]) $matched = true;
        }

        return $matched;

    }

    public static function nullOrEmpty($fields,$array)
    {

        $keys = array_keys($array);

        foreach ($array as $key => $value) {
            
            if(match($key,$keys))
            {

            }
            else
            {

            }
        }


            //if (match($key,$fields)) // make a list of boolean and indicators and return the elements that is missing. 

            // proceed with the same way with empty case.

        
    }


    // defines the priority of fields on a table
    // to be used on generating order of priority
    // of fields on order by sql statements
    public static function priority($table_name)
    {
        $sql = "SHOW columns FROM ".$table_name;

        $columns = Request::execute($sql);

        $columns_names = array();

        for ($i = 0; $i < count($columns); $i++) {

            array_push($columns_names, $columns[$i]['Field']);
        }

        return $columns_names;


    }

}





?>
