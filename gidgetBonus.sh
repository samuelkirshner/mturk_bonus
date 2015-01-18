#!/usr/bin/env sh
#
# This is the script that will run all the bonus payment code from parseBonus.php
#
# It needs to be placed in and executed from your AWS MTurk Command Line Utility folder
# (e.g. /library/Application Support/aws-mturk-clt/bin)
#


INPUT=bonus.csv
OLDIFS=$IFS
IFS=";"
[ ! -f $INPUT ] &while read worker assignment bonus
do
	echo "worker : $worker"
	echo "assignment : $assignment"
	echo "bonus : $bonus"
done < $INPUT
IFS=$OLDIFS





#printf "\n"
#read -p "Are you sure you want to continue? " -n 1 -r
#if [[ $REPLY =~ ^[Yy]$ ]]
#then
#	# PUT CODE INTO THIS BLOCK, HERE! (from mturkPayments.php)
#fi
#printf "\n\n"