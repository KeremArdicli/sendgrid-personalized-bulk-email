<?php

//Load Composer's autoloader
require 'vendor/autoload.php';

use SendGrid\Mail\From;
use SendGrid\Mail\HtmlContent;
use SendGrid\Mail\Mail;
use SendGrid\Mail\PlainTextContent;
use SendGrid\Mail\Subject;
use SendGrid\Mail\To;

$from = new From("youremail@email.com", "Bulk personalized email");

$recipients = [
	['name' => 'Person Name', 'email' => 'person1email@gmail.com', 'company' => 'SendGrid', 'country' => 'USA', 'subject' => "subject-1"],
	['name' => 'Person Name', 'email' => 'person1email@gmail.com', 'company' => 'SendGrid', 'country' => 'USA', 'subject' => "subject-2"],
	['name' => 'Person Name', 'email' => 'person1email@gmail.com', 'company' => 'SendGrid', 'country' => 'USA', 'subject' => "subject-3"],
	['name' => 'Person Name', 'email' => 'person1email@gmail.com', 'company' => 'SendGrid', 'country' => 'USA', 'subject' => "subject-4"],
	['name' => 'Person Name', 'email' => 'person1email@gmail.com', 'company' => 'SendGrid', 'country' => 'USA', 'subject' => "subject-5"],
	['name' => 'Person Name', 'email' => 'person1email@gmail.com', 'company' => 'SendGrid', 'country' => 'USA', 'subject' => "subject-6"]
];

$tos = [];

foreach ($recipients as $recipient) {
	array_push(
		$tos,
		new To(
			$recipient["email"],
			$recipient["name"],
			[
				'-name-' => $recipient["name"],
				'-email-' => $recipient["email"],
				'-company-' => $recipient["company"],
				'-country-' => $recipient["country"],
        '-subject-' => $recipient["subject"]
			],
      "Personalized subject: -subject-"
		)
	);
};

// You can populate email list with args one by one
// $tos = [
//     new To(
//         "person1@gmail.com",
//         "Kerem Ardıçlı",
//         [
//             '-name-' => 'Kerem Ardıçlı',
//             '-parameter-' => 'para1'
//         ],
//         "Personal Subject"
//     ),
//     new To(
//         "person1@gmail.com",
//         "Kerem Ardıçlı",
//         [
//             '-name-' => 'Kerem Plaza',
//             '-parameter-' => 'para2'
//         ]
//     )
// ];

$subject = new Subject("Online Registration"); // default subject (subject can be personalized as well)

$plainTextContent = new PlainTextContent(	"Hello -name-, welcome."); // use this if you dont want to send html format

$htmlContent = new HtmlContent(
	'
					<table style="background-color: #f5f5f5;border: 1px solid white;color: black;font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;">
					<tr style="width: 120px;border: 1px solid white;font-weight: 600;height: 50px;">
						<td colspan="2">Dear -name- ,</td>
					</tr>
					<tr style="width: 120px;border: 1px solid white;font-weight: 600;height: 50px;">
						<td colspan="2">You have successfully registered. Please see details below;</td>
					</tr>
					<tr>
						<td style="width: 120px;border: 1px solid white;font-weight: 600;">E-Mail</td>
						<td style="width: 500px;border: 1px solid white;">: -email- </td>
					</tr>
					<tr>
						<td style="width: 120px;border: 1px solid white;font-weight: 600;">Password</td>
						<td style="width: 500px;border: 1px solid white;">: -password-</td>
					</tr>
					<tr>
						<td style="width: 120px;border: 1px solid white;font-weight: 600;">Company</td>
						<td style="width: 500px;border: 1px solid white;">: -company- </td>
					</tr>
					<tr>
						<td style="width: 120px;border: 1px solid white;font-weight: 600;">Country</td>
						<td style="width: 500px;border: 1px solid white;">: -country- </td>
					</tr>
				</table>
			'
);
$globalSubstitutions = [
	'-password-' => "123",
];
$email = new Mail(
	$from,
	$tos,
	$subject, // or array of subjects, these take precedence
	$htmlContent,
);

$sendgrid = new \SendGrid("SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"); // your SG API Key

try {
	$response = $sendgrid->send($email);
	print $response->statusCode() . "\n";
	print_r($response->headers());
	print $response->body() . "\n";
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage() . "\n";
}
