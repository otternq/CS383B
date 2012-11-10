from pymongo import Connection

connection = Connection("ds037407.mongolab.com", 37407)
db = connection.socialstock #the database to use

db.authenticate("otternq","Swimm3r.")

collection = db.messages #the collection (or table for SQL) to access

print collection.find_one()
