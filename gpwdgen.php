<?php

$dir =  dirname(__FILE__);

$file = $dir. "/words.txt";
if (!is_file($file)) { throw new Exception ("File does not exits."); }

$counter_lines = 0;
$counter_words = 0;

$handle = @fopen($file, "r");
if (!isset($handle)) { throw new Exception("Cannot open {$file}"); }

while (($buffer = fgets($handle, 4096)) !== false) {
    $words = explode(' ', $buffer);
    $counter_lines++;
    $counter_words += count($words);
}

if (!feof($handle)) {
    throw new Exception("Error: unexpected fgets() fail.");
}

$random = mt_rand(0, $counter_words);

echo "Number of lines {$counter_lines}.". PHP_EOL;
echo "Number of words {$counter_words}.". PHP_EOL;
echo "Selected random number {$random}.". PHP_EOL;

$counter_words = 0;
rewind($handle);
$word = "";
while (($buffer = fgets($handle, 4096)) !== false) {
    $words = explode(' ', $buffer);

    $next = $counter_words + count($words);
    if ($next >= $random)
    {
        $current = ($random - $counter_words) - 1;
        $word =  $words[$current];
        $word = trim($word, " \t\n\r\0\x0B");
        break;
    }
    $counter_words += count($words);
}
fclose($handle);

echo "Selected password word '{$word}''.". PHP_EOL;


for ($i = 0, $passwd = "", $length = strlen($word); $i < $length; $i++)
{
    $char = substr($word, $i, 1);

    $previous_char = '';
    switch ($char) {

        case 'b':
            $char = '8';
            $previous_char = 'b';
            break;

        case 'd':
            $char = '6';
            $previous_char = 'd';
            break;

        case 'e':
            $char = '3';
            $previous_char = 'e';
            break;

        case 'i':
            $previous_char = 'i';
        case 'l':
            $char = '1';
            $previous_char = 'l';
            break;

        case 'o':
            $char = '0';
            $previous_char = 'o';
            break;

        case 's':
            $char = '5';
            $previous_char = 's';
            break;

        case 't':
            $char = '7';
            $previous_char = 't';
            break;
    }

    if (!empty($previous_char))
    {
        echo "{$previous_char} ({$char})" . PHP_EOL;
    }
    else
    {
        echo $char . PHP_EOL;
    }


    $passwd .= $char;

}

echo "Selected password converted '{$passwd}'." . PHP_EOL;

?>