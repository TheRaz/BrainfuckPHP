BrainfuckPHP
============

A Brainfuck interpreter written purely in PHP, Big brother of (Derp++)[https://github.com/TheRaz/DerpPlusPlus]
For information on how brainfuck works please read (this article)[en.wikipedia.org/wiki/Brainfuck]


Useage
======
```php
  $BF = new Interpreter();
  $BF->loadProgram('code'); /*OR*/ $BF->loadProgram($file, 'file');
  /*[OPTIONAL FUNCTION]*/ $BF->input('string') /*OR*/ $BF->input('string', 'replace') /*Append or replace the input string [OPTIONAL FUNCTION]*/
  $BF->run(); /* Pass true if you want to print the output otherwise it's accessable from the public variable */ $BF->output; 
```

This Readme is to be updated
============================