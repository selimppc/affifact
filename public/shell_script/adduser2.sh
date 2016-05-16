#!/bin/bash

# User Add Menu #2 by Aaron Rockey - October 2009

clear # Clears the screen.

echo "Adding or Removing Users Menu" 
echo "*****************************"
echo "Choose from an option below:" 
echo 
echo "[1]add user simple method"
echo "[2]add user with full name"
echo "[3]add user with different shell"
echo "[4]view last 5 users added to system"
echo "[5]remove a user"
echo "[6]remove a user and their home dir"
echo "[7]Exit"
read option

while [ "$option" -ne "7" ]
do
	case "$option" in
	# Note variable is quoted.

	  "1")
		if [ $(id -u) -eq 0 ]; then 
		#If UserID is root then procede if not then proceeds to else statement
			read -p "Enter username : " username #get input
			read -p "Enter password : " password #get input

			grep "^$username" /etc/passwd >/dev/null 
			#Search /etc/passwd for name, ouput result to null
			if [ $? -eq 0 ]; then
		 	   echo "$username already exists!" #Display error message if name exists
			else
	  		   pass=$(perl -e 'print crypt($ARGV[0], "password")' $password) 
			   #encrypt password
			   useradd -p $pass $username #add user name and password to system
			   if [ $? -eq 0 ] ; then #if no errors output message
			      echo "User $username has been added to system" 
			      #Display positive message
			   else
		              echo "Failed to add user $username" #Display negative message
			   fi
			 fi
		else
		   echo "Only root may add a user to the system" 
		   #Output if user was not root executing script
		fi
	  ;;

	"2")
	   if [ $(id -u) -eq 0 ]; then 
	   #If UserID is root then procede if not then proceeds to else statement
		read -p "Enter username : " username #get input
		read -p "Enter password : " password #get input
		read -p "Enter fullname : " fullname #get input

		grep "^$username" /etc/passwd >/dev/null 
		#Search /etc/passwd for name, ouput result to null
		if [ $? -eq 0 ]; then
		   echo "$username already exists!" #Display error message if name exists
		else
		   pass=$(perl -e 'print crypt($ARGV[0], "password")' $password) 
		   #encrypt password
		   useradd -p $pass $username #add user name and password to system
		   usermod -c "$fullname" $username #adds users full name
		   if [ $? -eq 0 ] ; then #if no errors output message
		      echo "User $username has been added to system" #Display positive message
		   else
		      echo "Failed to add user $username" #Display negative message
		   fi
		fi
	  else
		echo "Only root may add a user to the system" 
	 	#Output if user was not root executing script	
	   fi
	;;

	"3")
	   if [ $(id -u) -ne 0 ]; then
	   #If UserID is root then procede if not then output error message
	      echo "Only root may add a user to the system" 
	      #Output if user was not root executing script
	   else
	      read -p "Enter username : " username #get input
	      read -p "Enter password : " password #get input
	      read -p "Enter login shell eg: /bin/ksh:" shell #get input
	      grep "^$username" /etc/passwd >/dev/null 
	      #Search /etc/passwd for name, ouput result to null
	      if [ $? -eq 0 ]; then
	         echo "$username already exists!" #Display error message if name exists	
	      else
	         grep "^$shell" /etc/shells >/dev/null
	         #Search /etc/shells for existing shell types, ouput result to null
		 if [ $? -ne 0 ]; then
		    echo "$shell is an invalid shell!"	
		 else
		    pass=$(perl -e 'print crypt($ARGV[0], "password")' $password) 
		    #encrypt password 
		    useradd -p $pass -s $shell $username 
		    #add user to system and change default shell
		    if [ $? -eq 0 ] ; then #if no errors output message
		      echo "User $username has been added to system" #Display positive message
		    else
		      echo "Failed to add user $username" #Display negative message
		    fi
		 fi
	     fi
	  fi
	;;
	
	"4")
		if [ $(id -u) -eq 0 ]; then 
			#If UserID is root then procede if not then proceed to else statement
			tail -5 /etc/passwd	
		else
			echo "Only root may perform this command" 
			#Output if user was not root executing script
		fi
	;;
	
	"5")
		if [ $(id -u) -eq 0 ]; then 
		#If UserID is root then procede if not then proceeds to else statement
			read -p "Enter username to remove: " username #get input
			grep "^$username" /etc/passwd >/dev/null 
			#Search /etc/passwd for name, ouput result to null
			if [ $? -ne 0 ]; then
		 	   echo "$username does not exist!" #Display error if username not in /etc/passwd
			else
			   userdel $username #remove user from the system
			   if [ $? -eq 0 ] ; then #if no errors output message
			      echo "User $username has been removed from the system" 
			      #Display positive message
			   else
		              echo "Failed to remove user $username" #Display negative message
			   fi
			 fi
		else
		   echo "Only root may remove a user" 
		   #Output if user was not root executing script
	
		fi
	  ;;
	  
	"6")
		if [ $(id -u) -eq 0 ]; then 
		#If UserID is root then procede if not then proceeds to else statement
			read -p "Enter username to remove: " username #get input
			grep "^$username" /etc/passwd >/dev/null 
			#Search /etc/passwd for name, ouput result to null
			if [ $? -ne 0 ]; then
		 	   echo "$username does not exist!" #Display error if username not in /etc/passwd
			else
			   userdel -r $username #remove user and home dir from the system
			   if [ $? -eq 0 ] ; then #if no errors output message
			      echo "User $username and their home dir has been removed from the system" 
			      #Display positive message
			   else
		              echo "Failed to remove user $username" #Display negative message
			   fi
			 fi
		else
		   echo "Only root may remove a user" 
		   #Output if user was not root executing script
	
		fi
	  ;;
	  
	"7")
	   #Option 7 Exit was entered script ending
	;;

	* ) #Executes this if the user enters an invalid menu number
	echo "Invalid choice! Options are..."
	;;
	
   esac			
echo
echo "[1]add user simple method"
echo "[2]add user with full name"
echo "[3]add user with different shell"
echo "[4]view last 5 users added"
echo "[5]remove a user"
echo "[6]remove a user and their home dir"
echo "[7]Exit"
echo "Enter your choice:  "
read option
done
