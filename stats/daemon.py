from database.MongoInterface import MongoInterface
from algorithm1 import Algorithm1

db = MongoInterface()

#messages = db.messageByService("Twitter")
#print Algorithm1.getResult(messages)

messages = db.messageByService("Google Plus")
print Algorithm1.getResult(messages)

#messages = db.messageByService("Facebook")
#print Algorithm1.getResult(messages)

#messages = db.messageByService("Reddit")
#print Algorithm1.getResult(messages)
