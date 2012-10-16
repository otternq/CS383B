from pymongo import Connection #Connection makes a connection to a MongoDB instance

class MongoInterface:

    DATABASE_HOME = "ds037407-a.mongolab.com" #the host IP address
    DATABASE_PORT = 37407 #the port to connect to
    DATABASE_NAME = "socialstock" #the database the file is working with
    DATABASE_USERNAME = "otternq" #the username the file is working with
    DATABASE_PASSWORD = "Swimm3r." #the password the file is working with
    
    connection = None
    db = nil
    
    def __init__(self):
        self.connection = Connection(self.DATABASE_HOME, self.DATABASE_PORT); #connect to the MongoDB instance

        self.db = connection[self.DATABASE_NAME] #specify the database to use
        self.db.authenticate(self.DATABASE_USERNAME, self.DATABASE_PASSWORD) #authenticate to the database

    def messageByService(self, serviceName):
    
        messagesCollection = self.db.messages #specify the collection to use
        
        return messagesCollection.find( { "service": serviceName } ) #return the results
        
    def saveResult(self, date, service, algorithm, result):
    
        resultsCollection = self.db.results
        
        result = [
            {
                "date": date,
                "service": service,
                "algorithm": algorithm,
                "result": result
            }
        ]
        
        resultsCollection.insert(result)
        
        