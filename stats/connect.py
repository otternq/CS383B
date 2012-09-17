from pymongo import Connection

DATABASE_HOME = "ds037407-a.mongolab.com"
DATABASE_PORT = 37407
DATABASE_NAME = "socialstock"

connection = Connection(DATABASE_HOME, DATABASE_PORT);

db = connection[DATABASE_NAME]
db.authenticate("otternq", "Swimm3r.")

messages = db.messages

print messages.find_one()
