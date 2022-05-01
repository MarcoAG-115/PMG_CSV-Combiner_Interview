# PMG Interview Challenge CSV-Combiner
This program can take several csv files and combine them into a single csv file called 'combined.csv'. 
Additionally, this program will add a third column named 'filename' to combined.csv. 
This column will be populated with the corresponding file name indicating which file a line of data came from.

## How To Use
1. Download csv-combiner.php and place in desired directory / folder.
2. In a shell, navigate to the directory containing csv-combiner.php.
3. Type 'php ./csv-combiner.php' followed by any arguments and end it with ' > combined.csv'.
```bash
$ php ./csv-combiner.php ./fixtures/accessories.csv ./fixtures/clothing.csv > combined.csv
```
4. Press "Enter" to run the program
5. The 'combined.csv' file will appear in the same directory as 'csv-combiner.php'.

## Additional Information
The following code was created with the following tools & devices:
- macOS Monterrey v12.3.1 (MacBook Pro M1 Max 2021)
- PHP v8.0.9 (CLI)
- Visual Studio Code 1.66.2 
  - Extensions: Code Runner, PHP Debug, PHP Intelephense
- GitHub
- Example files taken from https://github.com/AgencyPMG/ProgrammingChallenges/tree/master/csv-combiner
