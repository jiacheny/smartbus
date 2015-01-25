<?php
    session_start();

    function assignJob($line_id,$dir_id,$filename,$driver)
    {
        if(file_exists("./data/schedule.txt"))
        {            
            $fp = fopen("./data/schedule.txt", "rb");
						$found = false;
            rewind($fp);
            while (!feof($fp)) {
                $string = fgets($fp);
                $tmp = explode("\t", $string);

                if($filename == trim($tmp[3]))
								{
									$found = true;
									$driver = $tmp[0];
									break;
								}
            }
						fclose($fp);
						
						if($found == true)
							throw new customException("Job already assigned to ".$driver);
						else
						{
							$fp = fopen("./data/schedule.txt", "a+");
							fputs($fp,$driver."\t".$line_id."\t".$dir_id."\t".$filename.PHP_EOL);
							fclose($fp);
						}
        }
        else
            die("schedule.txt not exists!");
    }

    function showDir()
    {
        //check the file
        if(file_exists("./data/testRoute.xls"))
        {
            //open file
            $fp = fopen("./data/testRoute.xls","rb");
            rewind($fp);
            
            //read file and load data
            while(!feof($fp))
            {
                $string = fgets($fp);
                $tmp = explode("\t",$string);
                
                if($tmp[0] == $_GET['route'])
                {
                    $option[0] = $tmp[2];
                    $option[1] = $tmp[3];
                    $option[2] = $tmp[4];
                    $option[3] = $tmp[5];
                    break;
                }
            }
            //set the response
            $response = "(Select Direction),".$option[0].",".$option[1].",".$option[2].",".$option[3];
        }
        else
            die("File not found!");
        //output the response
        echo $response;
    }
    
    //if the Route Selection onchange, call changeDir() function
    if(isset($_GET['route']))
    {
        $_SESSION['route'] = $_GET['route'];
        showDir();
    }

    function showJob()
    {
        $response = "(Select Job)";
        $file = scandir("./schedule/".$_SESSION['route']."/".$_GET['dir']);
        $reg = "/\.xls$/";

        foreach ($file as $value) {
            if (preg_match($reg, $value)) {
                $response .= ",".str_replace(".xls", '', $value);
            }
        }
        echo $response;
    }

    if(isset($_GET['dir']))
    {
        showJob();
    }
?>