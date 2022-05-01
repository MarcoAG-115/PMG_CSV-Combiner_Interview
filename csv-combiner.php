
<?php
/********************************************************************************************************************
 * Marco Gonzalez
 * April 30, 2022
 * csv-combiner Programming Challenge (PHP)
 * Info:
 *      The following code was created with the following tools & devices:
 *      - macOS Monterrey v12.3.1 (MacBook Pro M1 Max 2021)
 *      - PHP v8.0.9 (CLI)
 *      - Visual Studio Code 1.66.2 
 *          -> Extensions: Code Runner, PHP Debug, PHP Intelephense
 *      - GitHub
 *      - Example files taken from https://github.com/AgencyPMG/ProgrammingChallenges/tree/master/csv-combiner
 * Description:
 *      This program can take several csv files and combine them into
 *      a single csv file called 'combined.csv'. Additionally, this 
 *      program will add a third column named 'filename' to combined.csv.
 *      This column will be populated with the corresponding file name
 *      indicating which file a line of data came from.
 * How to Run:
 *      1. In a shell, navigate to the directory containing csv-combiner.php.
 *      2. Type 'php ./csv-combiner.php' followed by any arguments and end it with ' > combined.csv'.
 *          Example: $ php ./csv-combiner.php ./fixtures/accessories.csv ./fixtures/clothing.csv > combined.csv
 *      3. Press "Enter" to run the program
 *      4. The 'combined.csv' file will appear in the same directory as 'csv-combiner.php'.
 ********************************************************************************************************************/

//The following function combines all the csv files that were provided as arguments.
//The end result is a file called 'partCombined.csv'. This file contains all of the
//data in the provided csv files including the new column containing file names. 
//The 'partCombined.csv' does not have updated column headers.
function combineFiles(array $files, $result) {              //the expected parameters are an array containing temp csv files and the name of the combined output file
    
    if(!is_array($files)) {                                 //checks if the expected array parameter is actually an array
        
        throw new Exception('`$files` must be an array');   //error if the expected array parameter is not an array
    }

    $combFile = fopen($result, "w+");                       //the output file is created and opened to be written to

    $fileCount = 0;                                         //'fileCount' keeps track of how many csv files have been provided as arguments

    foreach($files as $file) {                              //this for-loop will iterate through each element in the provided parameter array
        
        if ($fileCount == 0) {                              //checks for the first array element
                                                            //if TRUE, the first input csv file's contents are written to 'partCombined.csv' including headers

            $currentFile = fopen($file, "r");               //the first input file is opened to have its contents read
            
            while(!feof($currentFile)) {                    //while-loop stops once it reaches the end of the input file
                
                fwrite($combFile, fgets($currentFile));     //the first input file's contents are written to 'partCombined.csv'
            }
            fclose($currentFile);                           //the first input file stream is closed
            unset($currentFile);                            //the variable used to represent the first input file stream is reset
            $fileCount++;

        }
        else {                                              //if FALSE, the current input csv file's contents are written to 'partCombined.csv' excluding headers
            
            $currentFile = fopen($file, "r");               //the current input file is opened to have its contents read
            
            fgetcsv($currentFile);                          //the purpose of the fgetcsv() function here is to skip the first line of the current file
            
            while(!feof($currentFile)) {                             
                fwrite($combFile, fgets($currentFile));     //the current input file's contents are written to 'partCombined.csv'
            }
            fclose($currentFile);                           //the current input file stream is closed
            unset($currentFile);                            //the variable used to represent the current input file stream is reset
            $fileCount++;
        }
    }
    fclose($combFile);                                      //the output file stream is closed
    unset($combFile);                                       //the variable used to represent the output file stream is reset
}
?>

<?php

$count = 0;                                                 //the variable 'count' keeps track of how many arguments have been provided

foreach($argv as $file){                                    //the for-loop iterates through every argument provided to count the number of arguments
    $count++;
}


if ($count <= 1){                                           //checks if at least one additional file has been provided
                                                            //if TRUE, an error is printed asking to provided at least one csv file
    echo "At least one input file must be given to create combined.csv";
}
else {                                                      //if FALSE, the array 'newArray' is initialized and populated with the first temporary csv file
    $newArray = array();                                    //'newArray' is created and initialized
    array_push($newArray, 'newFile1.csv');                  //the first temporary csv file is added to 'newArray'
}

$inputCount = 1;                                            //keeps track of the number of temporary files that have been created

$argCount = 0;                                              //used to check for the first argument

foreach($argv as $file) {                                   //this for-loop iterates through all the arguments provided
    
    if($argCount == 0) {                                    //checks if the current argument is the first
        $argCount++;                                        
        continue;                                           //if TRUE, 'argCount' is increased and the next loop is started
    }
    else {                                                  //if FALSE, the current argument / file is accessed and its contents are copied to a temp file
        $argFile = fopen($file, 'r');                       //the current file is opened to be read
        $tempFile = fopen("newFile".$inputCount.".csv", 'w');//a temp file is created and opened to be written to
        
        if ($inputCount !== 1) {                            //checks if the current file is not the first argument
            array_push($newArray, 'newFile'.$inputCount.'.csv');//if TRUE, the name of the created temp file is added to 'newArray'
        }
        $line = fgetcsv($argFile);                          //gets contents from current file
        
        while($line !== FALSE) {                            //this while-loop iterates until all the content has read and written to the temp file
            $line[] = basename($file);                      //in the temp file, a third column is created and populated with only the basename of the current file
            fputcsv($tempFile, $line);
            $line = fgetcsv($argFile);
        }
        fclose($argFile);                                    //the current file stream is closed
        fclose($tempFile);                                   //the corresponding temp file stream is closed
        $inputCount++;
    }
}

combineFiles($newArray, 'partCombined.csv');                //this function will combine all the temp csv files into one file called 'partCombined.csv'


$finalFile = 'combined.csv';
$prevFile = 'partCombined.csv';

$file_to_read = file_get_contents($prevFile);               //all the contents of 'partCombined.csv' are assigned to 'file_to_read'
$lines_to_read = explode("\n", $file_to_read);              //each line from 'partCombined.csv' turned into an element in 'lines_to_read'

if ( $lines_to_read == '' ) die('EOF');                     //checks if no content was found in 'partCombined.csv'

$line_to_append = array_shift( $lines_to_read );            //the first line, the one containing the headers, is assigned to 'line_to_append'
                                                            //'line_to_append' ensures that the old headers are replaced by the new headers

file_put_contents($finalFile, implode("\n", $lines_to_read));//all the contents from 'partCombined.csv' are placed in a new file called 'combined.csv'

$header = "email_hash,category,filename  \r\n";             //the new header for 'combined.csv' is created
$data = file_get_contents($finalFile);                      //the current contents of 'combined.csv' are assigned to 'data'
file_put_contents($finalFile, $header.$data);               //the previous contents of 'combined.csv' are added back along with the new header

if(unlink("partCombined.csv")) {                            //deletes 'partCombined.csv' and checks if the file was deleted

}
else {                                                      //if FALSE, an error is printed
    echo "Error occured when trying to delete a temporary file.";
}

//deletes all temp files created and stored in newArray
foreach($newArray as $tempFile) {                           //this for-loop iterates through all the temp file names that were created and stored in 'newArray'
    
    if(unlink($tempFile)) {                                 //deletes the current temp file and checks if the file was deleted

    }
    else {                                                  //if FALSE, an error is printed
        echo "Error occured when trying to delete a temporary file.";
    }
}
?>