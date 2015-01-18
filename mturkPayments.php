<?php

// Mechanical Turk; Semi-Automated Approval and Payments
// by Michael J. Lee, mjslee@uw.edu
// 
// Version 0.5
// Initial idea and concept from Idea from: http://blog.magicbeanlab.com/dhc/a-perl-script-to-make-granting-mechanical-turk-bonuses-a-little-easier/

/* NOTE: Saving a CSV file in Excel uses CR (carriage return, \r) for line endings.
   For this script to work, your CSV files must be in either LF (line feed, \n) or CRLF endings.
   There is a function below that tries to fix it, but if you're having problems, this is the next thing to check.
*/

	$indexAssignmentID = 0;
	$indexWorkerID = 1;
	$indexBonus = 2;
	$indexMessage = 3;
	$first = true;
	$overallCounter = 0;
	$displayCounter = 0;
	$costCounter = 0.0;
	$stringOfAssignments = "";
	$stringOfAssignmentsNoBonus = "";

	// Try to autoset line endings
	ini_set('auto_detect_line_endings', true);

	$file = fopen("bonus.csv", "r");
	
	while (!feof($file) ) {
	
		$line_of_text = fgetcsv($file);

		if ($first){
			$first = false;
		}
		else {
			if ($line_of_text[$indexBonus] != "") {	
				// Remove $, if any.
				$bonusAmount = trim($line_of_text[$indexBonus], '$');
				
				// Skip it bonus is 0
				if ($bonusAmount > 0) {
					
					$message = "";
					
					// If a message exists, use that. Otherwise, use the default.	
					if ($line_of_text[$indexMessage] == "")
						$message = "\"Bonus for levels completed in the Gidget game HIT.\"";
					else
						$message = "\"".$line_of_text[$indexMessage]."\"";

					
					print "./grantBonus.sh -workerid $line_of_text[$indexWorkerID] -amount $bonusAmount -assignment $line_of_text[$indexAssignmentID] -reason ".$message."\n" . "<br />";
					$displayCounter++;
					$costCounter += $bonusAmount;
					$stringOfAssignments = $stringOfAssignments.",".$line_of_text[$indexAssignmentID];
				}
				else {
					$stringOfAssignmentsNoBonus  = $stringOfAssignmentsNoBonus.",".$line_of_text[$indexAssignmentID];
				}
			
			}
			
			$overallCounter++;
		}

	}
	fclose($file);
	
	if ($overallCounter == 0)
		print "Were you expecting results? If so, please check to make sure your input file's line endings are LF/CRLF. Excel defaults to CR, which doesn't work.";
	else {
		print "<br />" . $displayCounter . " out of " . $overallCounter . " processed with bonuses. ";
		if ($displayCounter != $overallCounter)
			print "Some results were skipped because the bonus was $0.00, or the line was blank.";
		print "<br />Total cost will be: ($" . number_format($costCounter, 2, '.', '') ."+$".number_format($costCounter*.1, 2, '.', '').")= <b>$".number_format($costCounter*1.1, 2, '.', '')."</b> excluding the flat fee + mTurk fee.";
	}


	
	// EXAMPLE:
	// ./approveWork.sh -sandbox -assignment "23VHVWAVKI62X302NZTZC9QH7CVPH2"
		
	if ($stringOfAssignments != ""){
		$stringOfAssignments = trim($stringOfAssignments, ',');
		
		print "<br /><br />To approve all the workers that DID receive a bonus, use the following command:<br />";
		print "./approveWork.sh -assignment \"$stringOfAssignments\"";
	}
	
	if ($stringOfAssignmentsNoBonus != ""){
		$stringOfAssignmentsNoBonus = trim($stringOfAssignmentsNoBonus, ',');
		print "<br /><br />To approve all the workers that DID NOT receive a bonus, use the following command:<br />";
		print "./approveWork.sh -assignment \"$stringOfAssignmentsNoBonus\"";
	}
?>