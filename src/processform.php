<?php
/**
* Custom form validation plugin by 
* alex.rodriguez 
* drinkhorchata@gmail.com
* www.horchatadesign.com
*/

class ProcessForm
{
	

	function __construct()
	{
		
	}



	function validate($data)
	{

		foreach ($data as $key => $value) {
			if(is_string($value) && $key != 'confirmation') {
				$data->$key = trim($value);
				$data->$key = stripslashes($value);
				$data->$key = htmlspecialchars($value);
				// return $data;
			}
		}		


		$this->process($data);
		// print_r($data);
	}





	function process($data)
	{

		/*********************************************/
		/*                EMAIL CODE                 */
		/*********************************************/


		if($data->sendemail == 1) 
		{
			// print_r($data);

			$to = 'alex.rodriguez@austintexas.gov';
			$subject = 'Form Submission';
			$from = $data->email;
			$msg = $data->name . "\n\n" . $data->email . "\n\n" . $data->subject . "\n\n" . $data->message;

			if(mail($to, $subject, $msg, "From: $from\r\nReply-To: $from\r\nReturn-Path: $from\r\n"))
				echo $data->confirmation;

		}


		/*********************************************/
		/*            CREATE NEW PAGE CODE           */
		/*********************************************/

		if($data->mkpage == 1)
		{

			//create meesage page
			$p = new Page();
			$p->template = $template;
			$p->parent = $parent;
			// $p->title = $title;
			// $p->name = $name;
			// $p->body = $body;
			foreach ($fields as $key => $value) {
				$p->set($key, $value);
			}
 			$p->setOutputFormatting(false);
			$p->save();
			
			echo $confirmation;
			
			// redirect to 'message received' page
			// $data['session']->redirect();
		}




	}


}