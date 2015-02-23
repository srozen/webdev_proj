##These scripts are used to easily manage your files on Delvigne's Server

$USERNAME = "";
PASSWORD = "";

#Upload a file to Delvigne server
# $1 Specify the file path
	# e.g "~/Documents/index.html"
# $2 Specify the emplacement on Delvigne's server
	# e.g "TRAV/5_site_core"
function yd_put(){
	curl --insecure --ssl -T $1 ftp://$USERNAME:$PASSWORD@193.190.65.94/$2/
}

#Delete a file on Delvigne server

# $1 Specify the file to delete 
	# e.g "index.html"
# $2 Specify the emplacement on Delvigne's server
	# e.g "ESSAIS"
function yd_del(){
	curl --insecure --ssl ftp://$USERNAME:$PASSWORD@193.190.65.94/$2/ -X "DELE $1"
}

#Download a file on Delvigne server

# $1 Specify the path where file will be placed
	# e.g "my_local_file.txt"
# $2 Specify the file emplacement on Delvigne's server
	# e.g "ESSAIS/the_remote_file.txt"
function yd_get(){
	curl --insecure --ssl -T ftp://$USERNAME:$PASSWORD@193.190.65.94/$2 -o $1
}
