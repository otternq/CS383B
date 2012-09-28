"""
Connects to a MongoDB instance and prints each item from a collection

@author Nick Otter <otternq@gmail.com>

- U{The pymongo documentation <http://api.mongodb.org/python/current/api/pymongo/replica_set_connection.html>}

"""
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

score = 0
poscount = 0
negcount = 0
neutcount = 0

#   message = messages.find( { }, { "sentiment.response.docSentiment.type", "sentiment.response.docSentiment.score"} )

for item in messages.find( { }, { "sentiment.response.docSentiment.type", "sentiment.response.docSentiment.score"} ): #do the following for each item in the collection
    if item['sentiment']['response']['docSentiment']['type'] == 'positive':
        poscount += 1
        score += float(item['sentiment']['response']['docSentiment']['score'])
    elif item['sentiment']['response']['docSentiment']['type'] == 'negative':
        negcount += 1
        score += float(item['sentiment']['response']['docSentiment']['score'])
    elif item['sentiment']['response']['docSentiment']['type'] == 'neutral':
        neutcount += 1

print "positive responses: ", poscount, ".  Negative responses: ", negcount, "."
print "Average score: ", score/(neutcount + poscount + negcount)