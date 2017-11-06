# Error Code Meanings

 - 0000 - no error number was given, unknown error

 - 0001 - log error
   - 0001~0 invalid logName given

 - 0002 - file error
   - 0002~0 - Error while opening
   - 0002~1 - Error while reading

 - 0003 - json error
  - 0003~0 No error has occurred
  - 0003~1 The maximum stack depth has been exceeded
  - 0003~2 Invalid or malformed JSON
  - 0003~3 Control character error, possibly incorrectly encoded
  - 0003~4 Syntax error
  - 0003~5 Malformed UTF-8 characters, possibly incorrectly encoded

 - 0004~[mysqli_errno()] - MySQL error (ends with mysqli_errno()) Note: MySQL errors use mysqli_error() as the description so none is needed (this can be changed in managers/log.php around line 50)
   - 0004~0 - error connecting to database
   - 0004~1 - extra values were received (this is usually pretty bad)
   - 0004~2 - effected rows was not 1

 - 0005 - flow error
   - 0005~0 - affected rows was 0
   - 0005~1 - error while moving uploaded file

 - 0006 - form error
   - 0006~0 - affected rows was 0
   - 0006~1 - error while moving uploaded file

 - 0007 - config error
   - 0007~0 - unable to locate requested file. if editing config manually it's going to be a bit hard to find where its used :)
   - 0007~1 - unable to open/read/decode json config file
