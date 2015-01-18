# mturk_bonus
Script to pay workers bonuses semi-automatically using AWS command line tools

Paying a lot of bonuses using the Amazon Mechanical Turk (mTurk) website GUI is very tedious. This is an attempt to make it a little easier. You will need to have access to a webserver that can run PHP, and the AWS command line tools installed.

Steps:
1. Edit bonus.csv with the workerID, AssignmentID, and Bonus amount that you want to pay. The first two columns should be availalbe from the downloadable content from your mTurk HIT. The workerID and AssignmentID must match for payment to go through correctly (that is, mTurk won't allow you to pay someone who hasn't actually done work for you).
2. Open mturkPayments.php in your webbrowser or from the command line. It will output the AWS commands required for you to pay each MTurk worker.
3. Copy-and-paste the output from step #2 into the designated area in gidgetBonus.sh (~line 29). Execute this bash script from your command line. It will confirm you want to continue, then execute all the commands you gave it.
