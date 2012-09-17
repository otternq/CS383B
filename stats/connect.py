from pymongo import Connection #Connection makes a connection to a MongoDB instance

DATABASE_HOME = "ds037407-a.mongolab.com" #the host IP address
DATABASE_PORT = 37407 #the port to connect to
DATABASE_NAME = "socialstock" #the database the file is working with
DATABASE_USERNAME = "otternq" #the username the file is working with
DATABASE_PASSWORD = "Swimm3r." #the password the file is working with

connection = Connection(DATABASE_HOME, DATABASE_PORT); #connect to the MongoDB instance

db = connection[DATABASE_NAME] #specify the database to use
db.authenticate(DATABASE_USERNAME, DATABASE_PASSWORD) #authenticate to the database

messages = db.messages #specify the collection to use

for message in messages.find(): #do the following for each item in the collection
	print message #print the item
