<?php
	/*
	* Author: Iftikhar Ahmed
	* 
	* Date: 23/05/2018
	*
	* @className: CreateUserCommand
	*
	* @desc: This class extends Command class and it performs following simple operations...
	*		 - Converts given input string into MD5 and SHa1 hash
	* 		 - Calculates dates difference and presents in human readable format. Plus shows unix timestamp value of given date.
	*		 - Creates random string and password of given length.
	*	To run this user needs to type 'php index.php app:jarral username' from current directory in command prompt.	
	*
	* @required-namespaces: Namespaces given below.
	*
	* @required-classes: Extends Command class. 
	*
	* @methods: configure(), execute(), getRandomString
	*/
	namespace UserCommand;
	
	// Following namespaces are required.
	use \Datetime;
	use Carbon\Carbon;	
	use Symfony\Component\Console\Command\Command;
	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Output\OutputInterface;
	use Symfony\Component\Console\Input\InputArgument;
	use Symfony\Component\Console\Input\InputOption;
	use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
	use Symfony\Component\Console\Style\SymfonyStyle;
	
	class CreateUserCommand extends Command {
		
		/*
		* Name: configure()
		*
		* @desc: This is a mandatory function to define a command. In this function a different properties and arguments have been configured 
		*		 
		* Parameters: NULL
		* 			  
		* Returns: Nothing	
		*/
		 
		protected function configure() {
			
			 $this
				// the name of the command (the part after php index.php)
				->setName('app:jarral')
				// Defining Argument which user passes after command name('app:jarral' in our case) 
				->addArgument('name', InputArgument::REQUIRED, 'Person who starts')
				
				// the short description shown while running
				->setDescription('Simple php command-line tool.')

				// the full command description shown when running the command with
				// the "--help" option
				->setHelp('...')
			;
		}
		
		/*
		* Name: execute()
		*
		* @desc: This is the second mandatory function for a command. In this function actual functionality has been written
		*		 
		* Parameters: 2, InputInterface and OutputInterface
		* 			  
		* Returns: Nothing	
		*/
		
		protected function execute(InputInterface $input, OutputInterface $output)	{
			 
			$io = new SymfonyStyle($input, $output);
			
			$io->title('Welcome to Jarral CMD-TOOL');
			
			$io->text('Welcome on board '.$input->getArgument('name')); // $input->getArgument holds the argument that a user passes while initiating this app 
			
			
			while(1) { // This infinite loop is ended depending upon user input
				
				$userChoice = $io->choice('Please choose one of the following options', // This prompts user to choose an option.
				
				array('MD5&SHa1 Hash', 'Date', 'Random String&Password', 'Exit'));
				
				switch ($userChoice) {
					
					case 'MD5&SHa1 Hash':
						$io->text('Your have chosen: '.$userChoice); // It just writes given text						
						$userInput = $io->ask('Please input anything'); // It prompts user to give an input and stores that value in a variable
						$io->text('MD5 of given input is: '.md5($userInput)); //Converts given input into MD5 and prints
						$io->text('Sha1 of given input is: '.sha1($userInput)); //Converts given input into sha1 and prints
						
					break;
					
					case 'Random String&Password':
						
						$io->text('Your have chosen: '.$userChoice);
						
						while(1) { // This loop continues until user enters an integer length value.
							
							$length = $io->ask('Please input length');
							
							if(is_numeric($length)) {
								
								$io->text('Random string of given length is: '.$this->getRandomString($length,'')); //getRandomString is a member function to get random string or password
								$io->text('Random Password of given length is: '.$this->getRandomString($length,'password'));
								
								break 2; 
							} else
								$io->text('Please input an integer value');								
							
						}					
					break;
					
					case 'Date':
						$io->text('Your have chosen: '.$userChoice);
						$io->text('');
						
						while(1) { // runs until user enters a valid date
							
							$userInput = $io->ask('Please input a valid Date like (mm/dd/yyyy)');
							$io->text($userInput);
							
							if (strtotime($userInput)) { // if its a valid input date
								
								$now = Carbon::now(); // Returns current date
								
								$end = Carbon::parse($userInput); // Converts input date into Carbon object
								
								$timestp = $end->timestamp;  // timestamp of input date 
								
								$io->text('Unix timestamp for given date is: '.$timestp);
								
								$io->text('Difference between given date and today is: '.$end->diffForHumans($now, false, false, 6)); //Calculates dates difference and returns in human readable format
								
								break 2;
							} 
						}
						
					break;	
					default:
					
					break 2;
						
				}	
				
				$output->writeln('');
				$stopApp = $io->ask('Do you want to stop? Y/N');
				
				if($stopApp == 'Y' || $stopApp == 'y') {
					$io->text('');
					$io->text('Have a nice day :)');
					break; // End of outer most while loop
				}
				
			}
									
		}
		
		/*
		* Name: getRandomString()
		*
		* @desc: This function generates random string or password of given length
		*		 
		* Parameters: 2, first is the length and second determines whether to generate string or password 
		* 			  
		* Returns: Generated string or password
		*/
		
		private function getRandomString($length, $str) {
			
			if($str == 'password') 
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';	
			else
				$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			

			$string = '';

			for ($i = 0; $i < $length; $i++) {
				$string .= $characters[mt_rand(0, strlen($characters) - 1)];
			}

			return $string;
		}
		
		
	}