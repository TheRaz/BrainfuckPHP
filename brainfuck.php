<?php
namespace Brainfuck;
/**
 * @author  Rasmus Wallin <hej@rasmusw.se>
 * @version 1.0
 * @license Beerware <http://en.wikipedia.org/wiki/Beerware>
 */
class Interpreter {

	private $_pointer;
	private	$_memory;
	private $_program;
	private $_position;
	private $_inputPosition;
	private $_allowedCharacters = array('>','<','+','-','.',',','[',']');
	public  $input;
	public  $output;
	
	/**
	 * Interpreter::__construct()
	 *
	 * @return  void
	 */
	public function __construct() {
		$this->restore(true, true);
	}
	/**
	 * Interpreter::loadProgram()
	 *
	 * @return  boolean
	 */
	public function loadProgram($code, $from = 'string') {
		if($from === 'string') {
			if(is_string($code)) {
				$this->_program = $code;
			}else {
				throw new Exception("Expected 'string' got " . gettype($code));
				return false;
			}
			return true;
		}elseif($from === 'file') {
			$this->_program = file_get_contents($code);
		}
	}
	/**
	 * Interpreter::restore()
	 * 
	 * @param boolean $program
	 * @param boolean $input
	 * @return void
	 */
	public function restore($program = false, $input = false) {

		$this->_pointer = 0;
		$this->_memory = array_fill(0, 30000, 0);
		$this->position = 0;
		$this->_inputPosition = 0;
		$this->output = '';
		if($program) {
			$this->_program = '';	
		}
		if($input)  {
			$this->_input = '';
		} 
	}
	/**
	 * Interpreter::input()
	 *
	 * @param string $input
	 * @param string $how [append/replace]
	 * @return void
	 */
	public function input($input, $how = 'append') {

		if($how === 'append') {
			$this->input += $input;
		}elseif($how === 'replace') {
			$this->input = $input;
		}

	}
	/**
	 * Interpreter::run()
	 *
	 * @param boolean $print
	 * @return boolean
	 * @output string
	 */
	public function run($print = false) {
		$this->restore();
		if(!is_array($this->_program)) {
			$this->_program = str_split(trim($this->_program));	
		}
		for($this->_position = 0; $this->_position < count($this->_program); $this->_position++) {
			$instruction = $this->_program[$this->_position];
			if(!in_array($instruction, $this->_allowedCharacters)) {

				throw new Exception("Illegal character '" . $instruction . "' at position " . $this->_position);
				return false;
			}

			switch($instruction) {
				case '>':
					$this->_pointer++;
				break;
				case '<': 
					$this->_pointer--;
				break;
				case '+':
					$this->_memory[$this->_pointer]++;
				break;
				case '-':
					$this->_memory[$this->_pointer]--;
				break;
				case '.':
					$this->output .= chr($this->_memory[$this->_pointer]);
				break;
				case ',':
					if(isset($this->_input[$this->_inputPosition])) {
						$this->_memory[$this->_pointer] = ord($this->_input[$this->_inputPosition]);
						$this->_inputPosition++;
					}
				break;
				case '[':
					if(!$this->_memory[$this->_pointer]) {
						$counter = 1;
						while($counter) {
							switch($this->_program[++$this->_position]) {
								case '[':
									$counter++;
								break;
								case ']':
									$counter--;
								break;
							}
						}
					}
				break;
				case ']':
					$counter = 1;
					while($counter) {
						switch($this->_program[--$this->_position]) {
							case ']':
								$counter++;
							break;
							case '[':
								$counter--;
							break;
						}
					}
					$this->_position--;
				break;
			}
		}
		if($print) {
			print $this->output;
		}
	}

}
/**
 * Test case, should print the alphabet if everything is working correctly
 *
 *$BF = new Interpreter();
 *$BF->loadProgram('+++++[>+++++++++++++<-]>.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.+.');
 *try {
 *	$BF->run(true);
 *} catch(Exception $Error) {
 *	print '<pre>';
 *	print_r($Error);
 *	print '</pre>';
 *}
 */
?>
