# Simple code challenge #

This code is an example from a real world scenario that has been modified to protect the source. The code is one file from a large PHP application.

The context of the file is a parser of a result file from a specific Singapore bank regarding bank transfers. There were multiple banks from multiple countries involved in this application.

To install the dependencies run `composer install` (this assumes you have composer installed in your environment)

The code works and outputs what it required. Included is one test file with one test. This can be run and should pass with `./vendor/bin/phpunit tests`

Read through the `src/FinalResult.php` as well as the test file `tests/FinalResultTest.php` and see what improvements can be made (if any). Please be prepared to explain any modifications that have been made (or not) and why. The only rule is to not change the current end result or output.

Keep in mind this is from a larger application that handles multiple files, multiple banks, mutiple countries, and multiple currencies.

Do the best you can to demonstrate your skillset.

---

## Changes ##

| Change | Reason |
| :---: | :--- |
| General naming | Although some variable naming was fine, I prefer more explicit names as they are easier to understand quickly for people new to the code. |
| General usage of strict equality | This is safer than using PHP's type juggling. |
| Destructure initial fgetcsv data | Makes the naming and usage of the variables clearer. |
| Added constructor | I had considered adding class constants for clearly identifying the magic numbers used while indexing the records but decided adding a constructor would allow for csvs with different formatting to also be used. If data is uniformly pre-formatted, I would probably remove the constructor and just use constants. |
| Check file exists and can be opened | Should throw errors if either the file does not exist or it cannot be opened. |
| Remove unneeeded `$rcd` variable assignment | Can push to the `$records` array directly. |
| Remove unneeded `array_filter` call | It was not necessary. |
| Add `fclose` | Should close all open files after they have been used. |
| Remove `"document"` field | It was an unneccesary reference to the opened file, and the file has already been closed above. |
